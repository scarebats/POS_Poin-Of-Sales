<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;


class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Data Stok Barang'
        ];

        $barang = BarangModel::all();
        $activeMenu = 'stok';
        $stok = StokModel::all();
        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'barang' => $barang,
            'stok' => $stok
        ]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'supplier']) // Pastikan memuat relasi barang & supplier
            ->select('stok_id', 'barang_id', 'stok_jumlah', 'supplier_id');

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang->barang_nama ?? '-'; // Pastikan menggunakan $stok
            })
            ->addColumn('supplier_nama', function ($stok) {
                return $stok->supplier->supplier_nama ?? '-'; // Pastikan menggunakan $stok
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show/show_ajax') . '\')" 
                        class="btn btn-info btn-sm">Detail</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" 
                        class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" 
                        class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok Barang',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Stok Barang'
        ];

        $barang = BarangModel::all();
        $users = UserModel::all(); // Ambil data user dari database
        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'page', 'barang', 'users', 'activeMenu'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'barang_id' => 'required',
    //         'stok_jumlah' => 'required|numeric',
    //         'stok_tanggal' => 'required|date',
    //         'user_id' => 'required|integer', // Validasi untuk user_id
    //     ]);

    //     StokModel::create([
    //         'barang_id' => $request->barang_id,
    //         'stok_jumlah' => $request->stok_jumlah,
    //         'stok_tanggal' => $request->stok_tanggal,
    //         'user_id' => $request->user_id, // Mengambil user_id dari form
    //     ]);

    //     return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    // }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Stok Barang',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Stok Barang'
        ];

        $stok = StokModel::with('barang')->find($id);
        $activeMenu = 'stok';

        return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Stok Barang',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Stok Barang'
        ];

        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $activeMenu = 'stok';

        return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required',
            'stok_jumlah' => 'required|numeric',
            'stok_tanggal' => 'required|date',
        ]);

        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        $stok->barang_id = $request->barang_id;
        $stok->stok_jumlah = $request->stok_jumlah;
        $stok->stok_tanggal = $request->stok_tanggal;
        $stok->save();

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function destroy($id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        $stok->delete();

        return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
    }

    public function create_ajax()
    {
        $barang = BarangModel::leftJoin('t_stok', 'm_barang.barang_id', '=', 't_stok.barang_id')
            ->whereNull('t_stok.barang_id')
            ->select('m_barang.*') // Ambil semua kolom dari t_barang
            ->get();

        $user = UserModel::all();
        $supplier = SupplierModel::all();
        return view('stok.create_ajax', [
            'barang' => $barang,
            'user' => $user,
            'supplier' => $supplier,
        ]);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required',
                'supplier_id' => 'required',
                'user_id' => 'required',
                'stok_jumlah' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => $request->user_id,
                'supplier_id' => $request->supplier_id,
                'stok_jumlah' => $request->stok_jumlah,
                'stok_tanggal' => now(),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data Barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::join('m_barang', 't_stok.barang_id', '=', 'm_barang.barang_id')
            ->join('m_supplier', 't_stok.supplier_id', '=', 'm_supplier.supplier_id')
            ->select(
                't_stok.stok_id as stok_id',
                'm_barang.barang_kode as barang_kode',
                'm_barang.barang_nama as barang_nama',
                't_stok.stok_jumlah as stok_jumlah',
                't_stok.supplier_id as supplier_id',
                'm_supplier.supplier_nama as supplier_nama'
            )
            ->where('t_stok.stok_id', $id) // Tambahkan where untuk filter stok_id
            ->first(); // Mengambil satu data saja
        if (!$stok) {
            return response()->json(['message' => 'Data stok tidak ditemukan'], 404);
        }

        return view('stok.edit_ajax', [
            'stok' => $stok, // Perbaiki dari 'barang' menjadi 'stok'
        ]);
    }


    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'kategori_id' => 'required|integer',
                // 'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
                // 'barang_nama' => 'required|string|max:100',
                // 'harga_beli' => 'required|integer',
                'stok_jumlah' => 'required|min:1|max:10000'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = BarangModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/barang/list');
    }

    public function confirm_ajax($id)
    {
        $stok = StokModel::join('m_barang', 't_stok.barang_id', '=', 'm_barang.barang_id')
            ->join('m_supplier', 't_stok.supplier_id', '=', 'm_supplier.supplier_id')
            ->select(
                't_stok.stok_id as stok_id',
                'm_barang.barang_kode as barang_kode',
                'm_barang.barang_nama as barang_nama',
                't_stok.stok_jumlah as stok_jumlah',
                't_stok.supplier_id as supplier_id',
                'm_supplier.supplier_nama as supplier_nama'
            )
            ->where('t_stok.stok_id', $id) // Tambahkan where untuk filter stok_id
            ->first(); // Mengambil satu data saja
        if (!$stok) {
            return response()->json(['message' => 'Data stok tidak ditemukan'], 404);
        }

        return view('stok.confirm_ajax', [
            'stok' => $stok,
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);

            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        // Redirect ke halaman utama jika bukan request AJAX
        return redirect('/');
    }
}
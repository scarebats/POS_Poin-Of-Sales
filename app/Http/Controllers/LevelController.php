<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level User',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        $level = LevelModel::all();

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        if ($request->level_kode) {
            $level->where('level_kode', $request->level_kode);
        }

        return DataTables::of($level)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn = '<a href="'.url('level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('level/'.$level->level_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level User',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level user baru'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'level_kode' => 'required|string|min:3|unique:m_user,username',
            'level_nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level User',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level User'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level User',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level User'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'level_kode' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'level_nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Data user tidak ditemukan');
        }

        try {
            LevelModel::destroy($id); // Hapus data user

            return redirect('/level')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

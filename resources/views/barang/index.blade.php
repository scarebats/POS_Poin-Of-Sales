@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
                <button type="submit" onclick="modalAction('{{ url('barang/create_ajax') }}')"
                    class="btn btn-sa btn-primary mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="barang_id" name="barang_id" required>
                                <option value="">- Semua -</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Barang Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true">
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>

        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            })
        }
        var dataBarang;
        $(document).ready(function () {
            dataBarang = $('#table_barang').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('/barang/list') }}",
                    type: "POST",
                    method: "POST",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        d.barang_id = $('#barang_id').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "barang_kode", orderable: true, searchable: true },
                    { data: "barang_nama", orderable: true, searchable: true },
                    { data: "kategori_nama", orderable: true, searchable: true },
                    { data: "harga_beli", orderable: true, searchable: true },
                    { data: "harga_jual", orderable: true, searchable: true },
                    { data: "aksi", orderable: false, searchable: false }
                ]
            });

            $('#barang_id').on('change', function () {
                dataBarang.ajax.reload();
            });
        });

    </script>
@endpush
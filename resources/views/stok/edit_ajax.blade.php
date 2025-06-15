@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Stok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input value="{{$stok->barang_kode}}" type="text" name="barang_kode" id="barang_kode"
                            class="form-control" required readonly>
                        <small id="error-stok-kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input value="{{$stok->barang_nama}}" type="text" name="barang_nama" id="barang_nama"
                            class="form-control" required readonly>
                        <small id="error-barang-kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <input value="{{$stok->supplier_nama}}" type="text" name="supplier_nama" id="supplier_nama"
                            class="form-control" required readonly>
                        <small id="error-supplier-kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Stok</label>
                        <input value="{{$stok->stok_jumlah}}" type="number" name="stok_jumlah" id="stok_jumlah"
                            class="form-control" required>
                        <small id="error-stok-jumlah" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    barang_id: { required: true },
                    user_id: { required: true },
                    supplier_id: { required: true },
                    stok_jumlah: { required: true, number: true, min: 1, max: 10000 },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').fadeOut(300, function () {
                                    $(this).modal('hide');
                                });

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });

                                dataStok.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function (prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
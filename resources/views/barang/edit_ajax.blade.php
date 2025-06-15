@empty($barang)
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
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input value="{{$barang->barang_kode}}" type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                        <small id="error-barang-kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input value="{{$barang->barang_nama}}" type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                        <small id="error-barang-kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $l)
                                <option value="{{ $l->kategori_id }}" 
                                    {{ $l->kategori_id == $barang->kategori_id ? 'selected' : '' }}>
                                    {{ $l->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Harga Jual</label>
                        <input value="{{$barang->harga_jual}}" type="text" name="harga_jual" id="harga_jual" class="form-control" required>
                        <small id="error-barang-kode" class="error-text form-text text-danger"></small>
                    </div><div class="form-group">
                        <label>Harga Beli</label>
                        <input value="{{$barang->harga_beli}}" type="text" name="harga_beli" id="harga_beli" class="form-control" required>
                        <small id="error-barang-kode" class="error-text form-text text-danger"></small>
                    </div>
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
                    barang_kode: { required: true, minlength:3, maxlength:10 },
                    barang_nama: { required: true, minlength: 3, maxlength: 100 },
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

                                dataBarang.ajax.reload();
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
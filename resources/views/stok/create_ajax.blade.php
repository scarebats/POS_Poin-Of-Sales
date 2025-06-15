<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="barang_id">Pilih Barang</label>
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">
                                {{ $item->barang_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="barang_id">Pilih User</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->user_id }}">
                                {{ $item->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="barang_id">Pilih Supplier</label>
                    <select class="form-control" id="supplier_id" name="supplier_id" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplier as $item)
                            <option value="{{ $item->supplier_id }}">
                                {{ $item->supplier_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="stok_jumlah">Jumlah Stok</label>
                    <input type="text" class="form-control" id="stok_jumlah" name="stok_jumlah">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                barang_id: { required: true },
                user_id:{ required: true },
                supplier_id: { required: true },
                stok_jumlah: { required: true, number: true, min:1, max: 10000 },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataStok.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
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
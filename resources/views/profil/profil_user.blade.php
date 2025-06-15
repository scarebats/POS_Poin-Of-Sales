@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('/profil/edit_foto') }}')" class="btn btn-warning btn-sm">Edit Foto</button>
                </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/foto_profil/' . $user->foto) }}"
                        alt="User profile picture">
                    
                    </div>

                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Nama</b> <a class="float-right">{{ $user->nama }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right">{{ $user->username }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Level</b> <a class="float-right">{{ $user->level->level_nama }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableBarang;

        $(document).ready(function() {
        });
    </script>
@endpush
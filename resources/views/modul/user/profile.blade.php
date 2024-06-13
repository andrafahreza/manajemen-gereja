@extends('front.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="card m-5">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4 class="card-title">Ganti Password</h4>
                <div class="row mt-4">
                    <div class="col-12">
                        <form action="{{ route('ganti-password') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Password Lama</label>
                                    <input type="password" class="form-control" name="old_password" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="konfirmasi_password" required>
                                    <br>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

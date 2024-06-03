@extends('front.layouts.app')

@section('content')
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>  {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h4>Login</h4>
                    <h6 class="font-weight-light">Silahkan masukkan akun anda</h6>
                    <form class="pt-3" method="POST" action="{{ route('login-auth') }}">
                        @csrf
                        <div class="form-group">
                            <input type="username" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                        </div>
                        <div class="mt-3 d-grid gap-2">
                            <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">SIGN IN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

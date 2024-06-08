@extends('front.layouts.app')

@section('content')
<div class="content-wrapper">
    <a href="{{ route('berita') }}" class="btn btn-primary" id="btnTambah">< Kembali</a>
    <div class="card m-5">
        <div class="card-body">
            <h4 class="card-title">{{ $data->judul }}</h4>
            <img src="{{ asset($data->gambar) }}" style="width: 500px">
            <p>{!! $data->isi !!}</p>
        </div>
    </div>
</div>
@endsection

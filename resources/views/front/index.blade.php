@extends('front.layouts.app')

@section('content')
    @push('styles')
        <style>
            #fotoDepan {
                filter: blur(3px);
                -webkit-filter: blur(3px);
            }

            #bacaan {
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                color: white;
                border: 3px solid #f1f1f1;
                z-index: 2;
                padding: 20px;
            }
        </style>
    @endpush

    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg" style="background-color: transparent">
                    <div class="card-people mt-auto" style="padding-top: 0px;">
                        <img src="/gereja.jpeg" alt="people" height="700">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div id="bacaan">
                                    @if ($jadwalTerdekat != null)
                                        <h2 class="mb-0 font-weight-normal">{{ $jadwalTerdekat->nama_jadwal }}</h2>
                                        <h6 class="font-weight-normal">
                                            {{ \App\Http\Controllers\Controller::formatDate($jadwalTerdekat->jadwal) }}</h6>
                                        <h6 class="font-weight-normal">Petugas Misa Dari</h6>
                                        <h6 class="font-weight-normal">{{ $jadwalTerdekat->fakultas->nama_fakultas }}</h6>
                                    @else
                                        <h2 class="mb-0 font-weight-normal">Belum ada Jadwal</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    @foreach ($data as $item)
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card {{ $item['css'] }}">
                                <div class="card-body">
                                    <p class="mb-4">{{ $item['kegiatan'] }}</p>
                                    <span class="fs-30 mt-4"> <i class="ti-check-box"></i>
                                        {{ $item['fakultas']->nama_fakultas }}</span>
                                    <p>Jadwal: {{ $item['jadwal'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($jadwalTerdekat != null)
            <h2>Petugas</h2>
            <div class="row">
                @if ($petugas->count() > 0)
                    @foreach ($petugas as $value)
                        <div class="col-md-6 h-100">
                            <div class="bg-primary p-4 rounded">
                                <div id="profile-list-left" class="py-2">
                                    <div class="card rounded mb-2">
                                        <div class="card-body p-3">
                                            <div class="media">
                                                <img src="../../../assets/images/faces/face1.jpg" alt="image"
                                                    class="img-sm me-3 rounded-circle">
                                                <div class="media-body">
                                                    <h6 class="mb-1">{{ $value->nama }}</h6>
                                                    <p class="mb-0 text-muted">
                                                        {{ $value->jabatan }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($value->anggota as $anggota)
                                        <div class="card rounded mb-2">
                                            <div class="card-body p-3">
                                                <div class="media">
                                                    <img src="../../../assets/images/faces/face1.jpg" alt="image"
                                                        class="img-sm me-3 rounded-circle">
                                                    <div class="media-body">
                                                        <h6 class="mb-1">{{ $anggota->nama }}</h6>
                                                        <p class="mb-0 text-muted">
                                                            Anggota
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-6 h-100">
                        <div class="bg-primary p-4 rounded">
                            <div id="profile-list-left" class="py-2">
                                <span class="text-white">{{ $jadwalTerdekat->fakultas->nama_fakultas }} belum ada petugas</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

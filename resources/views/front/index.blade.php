@extends('front.layouts.app')

@section('content')

@push("styles")
    <style>
        #fotoDepan{
            filter: blur(3px);
            -webkit-filter: blur(3px);
        }
        #bacaan{
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0, 0.4);
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
                                <h2 class="mb-0 font-weight-normal">Ibadah Misa</h2>
                                <h6 class="font-weight-normal">Jumat, 9 Februari 2024</h6>
                                <h6 class="font-weight-normal">Jam 08:00 WIB s/d</h6>
                                <h6 class="font-weight-normal">Petugas Misa Dari Fakultas</h6>
                                <h6 class="font-weight-normal">Ilmu Komputer</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <span class="fs-30 mt-4"> <i class="ti-check-box"></i> Fakultas Ilmu Komputer</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Ekonomi</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Sastra</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Teknik</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Pertanian</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Hukum</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <span class="fs-30 mt-4">Fakultas Keguruan dan Ilmu Pendidikan</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Number of Meetings</p>
                            <p class="fs-30 mb-2">34040</p>
                            <p>2.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Number of Clients</p>
                            <p class="fs-30 mb-2">47033</p>
                            <p>0.22% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

</div>
@endsection

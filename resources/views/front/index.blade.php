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
                    <div class="col-md-12 h-100">
                        <div class="bg-primary p-4 rounded">
                            <div id="profile-list-left" class="py-2">
                                @foreach ($petugas as $value)
                                    <div class="card rounded mb-2">
                                        <div class="card-body p-3">
                                            <div class="media">
                                                <img src="/user.png" alt="image"
                                                    class="img-sm me-3 rounded-circle">
                                                <div class="media-body">
                                                    <h6 class="mb-1">{{ $value->nama }}</h6>
                                                    <p class="mb-0 text-muted">
                                                        {{ $value->npm }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 h-100">
                        <div class="bg-primary p-4 rounded">
                            <div id="profile-list-left" class="py-2">
                                <span class="text-white">{{ $jadwalTerdekat->fakultas->nama_fakultas }} belum ada petugas</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        <br>

        <h2>Jadwal</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="jadwal" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Jenis Pelayanan</th>
                                        <th>Jadwal Pelayanan</th>
                                        <th>Fakultas</th>
                                        <th>Kolekte</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nama_jadwal }}</td>
                                            <td>{{ $item->jenis_pelayanan }}</td>
                                            <td>{{ \App\Http\Controllers\Controller::formatDate($item->jadwal) }}</td>
                                            <td>{{ $item->fakultas->nama_fakultas }}</td>
                                            <td>
                                                @if ($item->kolekte != null)
                                                    Rp. {{ number_format($item->kolekte) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'belum_dimulai')
                                                    <span class="badge bg-warning">Belum Selesai</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <h2>Pengumuman</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="jadwal" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Isi Pengumuman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumuman as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->isi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <h2>Berita</h2>
        @if ($berita->count() == 0)
            <div class="row">
                <div class="col-md-12 h-100">
                    <div class="bg-primary p-4 rounded">
                        <div id="profile-list-left" class="py-2">
                            <span class="text-white">Belum ada berita</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($berita as $item)
                    <div class="card-columns">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($item->gambar) }}" alt="Card image cap">
                            <div class="card-body">
                                <span style="font-size: 13px">{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</span>
                                <h4 class="card-title">{{ $item->judul }}</h4>
                                <a href="{{ route('lihat-berita', ['id' => $item->id]) }}" class="btn btn-primary">Lihat Berita</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <br>
    </div>

    @push("scripts")
        <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
        <script src="/assets/js/data-table.js"></script>

        <script>
            $('#jadwal').DataTable({
                "aLengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
                "iDisplayLength": 10,
                "language": {
                    search: ""
                }
            });

            $('#jadwal').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });

            $('#pengumuman').DataTable({
                "aLengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
                "iDisplayLength": 10,
                "language": {
                    search: ""
                }
            });

            $('#pengumuman').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        </script>
    @endpush
@endsection

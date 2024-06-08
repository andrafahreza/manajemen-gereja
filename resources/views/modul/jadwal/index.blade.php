@extends('front.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="card m-5">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>  {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong>  {{ Session::get('success'); }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4 class="card-title">Jadwal Pelayanan</h4>
                @if (auth()->check())
                    <button type="button" class="btn btn-primary" id="btnTambah">+ Tambah</button>
                @endif
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Jadwal Pelayanan</th>
                                        <th>Fakultas</th>
                                        <th>Status</th>
                                        @if (auth()->check())
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nama_jadwal }}</td>
                                            <td>{{ \App\Http\Controllers\Controller::formatDate($item->jadwal) }}</td>
                                            <td>{{ $item->fakultas->nama_fakultas }}</td>
                                            <td>
                                                @if ($item->status == 'belum_dimulai')
                                                    <span class="badge bg-warning">Belum Selesai</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            @if (auth()->check())
                                                <td>
                                                    @if ($item->status == "belum_dimulai" && strtotime(now()) > strtotime($item->jadwal))
                                                        <button type="button" class="btn btn-outline-warning" onclick="selesai({{ $item->id }})" id="btnSelesai">Selesai</button>
                                                    @endif

                                                    @if ($item->status == "belum_dimulai" && strtotime(now()) < strtotime($item->jadwal))
                                                        <button type="button" class="btn btn-outline-primary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                        <button type="button" class="btn btn-outline-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalJadwal" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('simpan-jadwal') }}" method="POST" id="formJadwal">
                    @csrf
                    <input type="hidden" name="id" id="id_save">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data Jadwal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errorMessage d-none">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>  <span id="spanError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label>Fakultas <span class="text-danger">*</span></label>
                                <select class="form-control" name="fakultas_id" id="fakultas_id" required>
                                    <option value="">Pilih Fakultas</option>
                                    @foreach ($fakultas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Nama kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_jadwal" id="nama_jadwal" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jadwal <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="jadwal" id="jadwal" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Hapus Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menghapus data ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('hapus-jadwal') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="hapus_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade selesai" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Selesaikan Jadwal</h4>
                        <p class="text-muted mb-4"> Yakin ingin menyelesaikan jadwal ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('selesai-jadwal') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="selesai_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @push("scripts")
        <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
        <script src="/assets/js/data-table.js"></script>

        <script>
            $('#btnTambah').on('click', function() {
                $('#formJadwal')[0].reset();
                $('#errorMessage').addClass('d-none');
                $('.modalJadwal').modal('toggle');
            });

            function edit(id) {
                $('#formJadwal')[0].reset();
                var url = "{{ route('show-jadwal') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            $('.modalJadwal').modal('toggle');
                            $('#errorMessage').addClass('d-none');

                            const data = response.data;
                            $('#formJadwal')[0].reset();
                            $('#formJadwal').attr("action", "{{ route('simpan-jadwal') }}");
                            $('#nama_jadwal').val(data.nama_jadwal);
                            $('#fakultas_id').val(data.fakultas_id);
                            $('#jadwal').val(data.jadwal);
                            $('#id_save').val(data.id);
                        } else {
                            $('#errorMessage').removeClass('d-none');
                            $('#spanError').text(response.message);
                        }
                    },
                    error: function(response) {
                        $('#errorMessage').removeClass('d-none');
                        $('#spanError').text(response.message);
                    }
                });
            }

            function hapus(id) {
                $('#hapus_id').val(id);
                $('.hapus').modal('toggle');
            }

            function selesai(id) {
                $('#selesai_id').val(id);
                $('.selesai').modal('toggle');
            }
        </script>
    @endpush
@endsection

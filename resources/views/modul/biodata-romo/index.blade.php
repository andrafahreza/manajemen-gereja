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
                <h4 class="card-title">Biodata Romo</h4>
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
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Foto</th>
                                        <th>Tgl Lahir</th>
                                        <th>Biodata Singkat</th>
                                        @if (auth()->check())
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>
                                                <a href="{{ asset($item->photo) }}" target="_blank">
                                                    <img src="{{ asset($item->photo) }}" width="200">
                                                </a>
                                            </td>
                                            <td>{!! date('d-m-Y', strtotime($item->tanggal_lahir)) !!}</td>
                                            <td>{!! $item->keterangan !!}</td>
                                            @if (auth()->check())
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
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

    <div class="modal fade modalBiodata" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('simpan-biodata') }}" method="POST" id="formBiodata" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id_save">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data Biodata Romo</h5>
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
                                <label>Nama Romo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Foto <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="photo" id="photo" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Biodata Singkat <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
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
                            <form action="{{ route('hapus-biodata') }}" method="POST">
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

    @push("scripts")
        <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
        <script src="/assets/js/data-table.js"></script>

        <script>
            $('#btnTambah').on('click', function() {
                $('#formBiodata')[0].reset();
                $('#errorMessage').addClass('d-none');
                $('.modalBiodata').modal('toggle');
            });

            function edit(id) {
                $('#formBiodata')[0].reset();
                var url = "{{ route('show-biodata') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            $('.modalBiodata').modal('toggle');
                            $('#errorMessage').addClass('d-none');

                            const data = response.data;
                            $('#formBiodata')[0].reset();
                            $('#formBiodata').attr("action", "{{ route('simpan-biodata') }}");
                            $('#nama').val(data.nama);
                            $('#jabatan').val(data.jabatan);
                            $('#tanggal_lahir').val(data.tanggal_lahir);
                            $('#keterangan').val(data.keterangan);
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
        </script>
    @endpush
@endsection

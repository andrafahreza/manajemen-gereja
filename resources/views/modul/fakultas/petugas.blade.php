@extends('front.layouts.app')

@section('content')
    <div class="content-wrapper">
        <a href="{{ route('fakultas') }}" class="btn btn-secondary text-white" style="margin-left: 65px">< Kembali</a>
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
                <h4 class="card-title">Data Petugas {{ $fakultas->nama_fakultas }}</h4>
                <button type="button" class="btn btn-primary" id="btnTambah">+ Tambah</button>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Kontak</th>
                                        <th>Anggota</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->kontak }}</td>
                                            <td>{{ $item->anggota->count() }}</td>
                                            <td>
                                                <a href="{{ route('anggota', ['id' => $item->id]) }}" class="btn btn-outline-success">Anggota</a>
                                                <button type="button" class="btn btn-outline-primary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                <button type="button" class="btn btn-outline-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
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
    </div>

    <div class="modal fade modalPetugas" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('simpan-petugas') }}" method="POST" id="formPetugas">
                    @csrf
                    <input type="hidden" name="id" id="id_save">
                    <input type="hidden" name="fakultas_id" id="fakultas_id" value="{{ $fakultas->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data Petugas</h5>
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
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>kontak <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="kontak" id="kontak" required>
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
                            <form action="{{ route('hapus-petugas') }}" method="POST">
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
                $('#formPetugas')[0].reset();
                $('#errorMessage').addClass('d-none');
                $('.modalPetugas').modal('toggle');
            });

            function edit(id) {
                $('#formPetugas')[0].reset();
                var url = "{{ route('show-petugas') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            $('.modalPetugas').modal('toggle');
                            $('#errorMessage').addClass('d-none');

                            const data = response.data;
                            $('#formPetugas')[0].reset();
                            $('#formPetugas').attr("action", "{{ route('simpan-petugas') }}");
                            $('#nama').val(data.nama);
                            $('#jabatan').val(data.jabatan);
                            $('#kontak').val(data.kontak);
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

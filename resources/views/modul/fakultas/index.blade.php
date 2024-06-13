@extends('front.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row m-5">
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Fakultas</h4>
                        @if (auth()->user()->role == "fakultas")
                            <button type="button" class="btn btn-primary" id="btnTambah">+ Tambah</button>
                        @endif
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Prodi</th>
                                                <th>Nama Fakultas</th>
                                                <th>Petugas</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        @if ($item->prodi_id != null)
                                                            {{ $item->prodi->nama_prodi }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->nama_fakultas }}</td>
                                                    <td>{{ $item->petugas->count() }}</td>
                                                    <td>
                                                        <a href="{{ route('petugas', ['id' => $item->id]) }}" class="btn btn-outline-success">Petugas</a>
                                                        @if (auth()->user()->role == "fakultas")
                                                            <button type="button" class="btn btn-outline-primary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                            <button type="button" class="btn btn-outline-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
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
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Prodi</h4>
                        <button type="button" class="btn btn-primary" id="btnTambahProdi">+ Tambah</button>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="prodi" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Prodi</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prodi as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->nama_prodi }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-primary" onclick="editProdi({{ $value->id }})" id="btnEditProdi">Edit</button>
                                                        <button type="button" class="btn btn-outline-danger" onclick="hapusProdi({{ $value->id }})" id="btnHapusProdi">Hapus</button>
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
        </div>
    </div>

    <div class="modal fade modalFakultas" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('simpan-fakultas') }}" method="POST" id="formFakultas">
                    @csrf
                    <input type="hidden" name="id" id="id_save">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data Fakultas</h5>
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
                                <label>Prodi <span class="text-danger">*</span></label>
                                <select class="form-control" name="prodi_id" id="prodi_id" required>
                                    <option value="">Pilih prodi</option>
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Nama Fakultas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_fakultas" id="nama_fakultas" required>
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
                            <form action="{{ route('hapus-fakultas') }}" method="POST">
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

    <div class="modal fade modalProdi" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('simpan-prodi') }}" method="POST" id="formProdi">
                    @csrf
                    <input type="hidden" name="id" id="id_save">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data Prodi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errorMessageProdi d-none">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>  <span id="spanErrorProdi"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label>Nama Prodi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_prodi" id="nama_prodi" required>
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

    <div class="modal fade hapusProdi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Hapus Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menghapus data ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('hapus-prodi') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="hapus_prodi_id">
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
            $('#prodi').DataTable({
                "aLengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
                "iDisplayLength": 10,
                "language": {
                    search: ""
                }
            });

            $('#prodi').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });

            $('#btnTambah').on('click', function() {
                $('#formFakultas')[0].reset();
                $('#errorMessage').addClass('d-none');
                $('.modalFakultas').modal('toggle');
            });

            $('#btnTambahProdi').on('click', function() {
                $('#formProdi')[0].reset();
                $('#errorMessageProdi').addClass('d-none');
                $('.modalProdi').modal('toggle');
            });

            function edit(id) {
                $('#formFakultas')[0].reset();
                var url = "{{ route('show-fakultas') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            $('.modalFakultas').modal('toggle');
                            $('#errorMessage').addClass('d-none');

                            const data = response.data;
                            $('#formFakultas')[0].reset();
                            $('#formFakultas').attr("action", "{{ route('simpan-fakultas') }}");
                            $('#prodi_id').val(data.prodi_id);
                            $('#nama_fakultas').val(data.nama_fakultas);
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

            function editProdi(id) {
                $('#formProdi')[0].reset();
                var url = "{{ route('show-prodi') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            $('.modalProdi').modal('toggle');
                            $('#errorMessageProdi').addClass('d-none');

                            const data = response.data;
                            $('#formProdi')[0].reset();
                            $('#formProdi').attr("action", "{{ route('simpan-prodi') }}");
                            $('#nama_prodi').val(data.nama_prodi);
                            $('#id_save').val(data.id);
                        } else {
                            $('#errorMessageProdi').removeClass('d-none');
                            $('#spanErrorProdi').text(response.message);
                        }
                    },
                    error: function(response) {
                        $('#errorMessageProdi').removeClass('d-none');
                        $('#spanErrorProdi').text(response.message);
                    }
                });
            }

            function hapus(id) {
                $('#hapus_id').val(id);
                $('.hapus').modal('toggle');
            }

            function hapusProdi(id) {
                $('#hapus_prodi_id').val(id);
                $('.hapusProdi').modal('toggle');
            }
        </script>
    @endpush
@endsection

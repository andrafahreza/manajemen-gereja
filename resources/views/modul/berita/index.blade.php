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
                <h4 class="card-title">Berita</h4>
                @if (auth()->check())
                    <a href="{{ route('page-berita') }}" class="btn btn-primary" id="btnTambah">+ Tambah</a>
                @endif
            </div>
        </div>
        @foreach ($data as $item)
            <div class="card-columns m-5">
                <div class="card">
                    <img class="card-img-top" src="{{ asset($item->gambar) }}" alt="Card image cap">
                    <div class="card-body">
                        <span style="font-size: 13px">{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</span>
                        <h4 class="card-title">{{ $item->judul }}</h4>
                        <a href="{{ route('lihat-berita', ['id' => $item->id]) }}" class="btn btn-primary">Lihat Berita</a>
                        @if (auth()->check())
                            <a href="{{ route('page-berita', ['id' => $item->id]) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" type="button" onclick="hapus({{ $item->id }})">Hapus</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Hapus Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menghapus data ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('hapus-berita') }}" method="POST">
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
            function hapus(id) {
                $('#hapus_id').val(id);
                $('.hapus').modal('toggle');
            }
        </script>
    @endpush
@endsection

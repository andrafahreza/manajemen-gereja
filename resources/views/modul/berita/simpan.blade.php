@extends('front.layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="/assets/vendors/quill/quill.snow.css">
    @endpush

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
                <h4 class="card-title">Simpan Berita</h4>
                <div class="row mt-4">
                    <form action="{{ route('simpan-berita') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="@if (!empty($data)) {{ $data->id }} @endif">
                        <div class="col-6">
                            <label>Judul Berita</label>
                            <input type="text" class="form-control" name="judul" value="@if (!empty($data)) {{ $data->judul }} @endif" required>
                        </div>
                        <div class="col-6 mt-4">
                            <label>Gambar Berita</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>
                        <div class="col-12 mt-4">
                            <label>Isi Berita</label>
                            <div id="quillExample1" class="quill-container">
                            </div>
                        <div class="col-4 mt-4">
                            <textarea style="display: none" id="isi" name="isi">@if (!empty($data)) {{ $data->isi }} @endif</textarea>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="/assets/vendors/quill/quill.min.js"></script>

        <script>
            if ($("#quillExample1").length) {
                var quill = new Quill('#quillExample1', {
                    modules: {
                        toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        ['image', 'code-block']
                        ]
                    },
                    placeholder: 'Isi Berita',
                    theme: 'snow' // or 'bubble'
                });

                quill.on('text-change', function(delta, oldDelta, source) {
                    console.log(quill.container.firstChild.innerHTML)
                    $('#isi').val(quill.container.firstChild.innerHTML);
                });

                quill.pasteHTML($('#isi').val());
            }
        </script>
    @endpush
@endsection

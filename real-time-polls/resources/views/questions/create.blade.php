@extends('layouts.master')

@section('title', 'Create Campaign')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/scss/pages/summernote.scss')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">
@endpush
@section('content')
    <div class="page-heading">
        <h3>Tambah Pertanyaan</h3>
    </div>
    <div class="page-content">

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Pertanyaan</label>
                                                <label class="form-label text-danger">*</label>
                                                <input type="text" class="form-control" name="name" required
                                                       placeholder="nama campaign.." value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Berlaku Sampai</label>
                                                <label class="form-label text-danger">*</label>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="is_active" required>
                                                        <option value="1" {{ old('is_active') == 1 ? "selected" : "" }}>Aktif</option>
                                                        <option value="0" {{ old('is_active') == 0 ? "selected" : "" }}>Tidak Aktif</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Simpan
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>
@endsection

@push('scripts')

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/summernote.js') }}"></script>

    <script>

    </script>
@endpush

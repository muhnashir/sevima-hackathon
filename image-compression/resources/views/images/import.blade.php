@extends('layouts.master')

@section('title', 'Create Campaign')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/scss/pages/summernote.scss')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
    <style>
        .drop-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .drop-area.highlight {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
@endpush
@section('content')
    <div class="page-content">

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="page-heading ml-2">
                                    <h3>Import Image</h3>
                                </div>
                                <form class="form" action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Masukkan Gambar <span style="color: red;">*</span></label>
                                                <div class="drop-area" id="drop-area">
                                                    <p>Tarik gambar ke sini atau klik untuk memilih file</p>
                                                    <input class="form-control" type="file" id="formFile" name="image" required hidden>
                                                    <img id="preview" class="preview-image">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-start mt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Simpan
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('formFile');
            const preview = document.getElementById('preview');

            // Klik area untuk memilih file
            dropArea.addEventListener('click', function() {
                fileInput.click();
            });

            // Tampilkan preview saat file dipilih
            fileInput.addEventListener('change', function() {
                displayFile(this.files[0]);
            });

            // Mencegah browser membuka file saat di-drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop area saat file di-drag di atasnya
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('highlight');
            }

            function unhighlight() {
                dropArea.classList.remove('highlight');
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    fileInput.files = files;
                    displayFile(files[0]);
                }
            }

            function displayFile(file) {
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(file);
                }
            }
        });
    </script>



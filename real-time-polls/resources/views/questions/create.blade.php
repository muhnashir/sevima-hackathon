@extends('layouts.master')

@section('title', 'Create Campaign')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/scss/pages/summernote.scss')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
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
                                <form class="form" action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Pertanyaan</label>
                                                <label class="form-label text-danger">*</label>
                                                <input type="text" class="form-control" name="name" required
                                                       placeholder="Masukkan pertanyaan..." value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Berlaku Sampai</label>
                                                <label class="form-label text-danger">*</label>
                                                <input type="datetime-local" class="form-control flatpickr" name="finish_at" required
                                                       placeholder="Pilih tanggal dan waktu..." value="{{ old('finish_at') }}">
                                            </div>
                                        </div>

                                        <!-- Question Options Section -->
                                        <div class="col-12 mt-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Pilihan Jawaban</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="options-container">
                                                        <div class="row option-row mb-2">
                                                            <div class="col-1 d-flex align-items-center">
                                                                <span class="option-label">A</span>
                                                            </div>
                                                            <div class="col-10">
                                                                <input type="text" class="form-control" name="options[]" required placeholder="Masukkan pilihan jawaban...">
                                                            </div>
                                                            <div class="col-1 d-flex align-items-center">
                                                                <button type="button" class="btn btn-danger btn-sm remove-option" disabled>
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row option-row mb-2">
                                                            <div class="col-1 d-flex align-items-center">
                                                                <span class="option-label">B</span>
                                                            </div>
                                                            <div class="col-10">
                                                                <input type="text" class="form-control" name="options[]" required placeholder="Masukkan pilihan jawaban...">
                                                            </div>
                                                            <div class="col-1 d-flex align-items-center">
                                                                <button type="button" class="btn btn-danger btn-sm remove-option">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <button type="button" id="add-option" class="btn btn-primary btn-sm">
                                                                <i class="bi bi-plus"></i> Tambah Pilihan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt-3">
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
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>

    <script>
        // Initialize flatpickr for datetime picker
        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        // Handle dynamic options
        $(document).ready(function() {
            // Add new option
            $("#add-option").click(function() {
                const optionsContainer = $("#options-container");
                const optionCount = optionsContainer.children().length;

                // Get the next option letter (A, B, C, ...)
                const nextLetter = String.fromCharCode(65 + optionCount); // 65 is ASCII for 'A'

                const newOption = `
                    <div class="row option-row mb-2">
                        <div class="col-1 d-flex align-items-center">
                            <span class="option-label">${nextLetter}</span>
                        </div>
                        <div class="col-10">
                            <input type="text" class="form-control" name="options[]" required placeholder="Masukkan pilihan jawaban...">
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-option">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                optionsContainer.append(newOption);
                updateRemoveButtons();
            });

            // Remove option
            $(document).on("click", ".remove-option", function() {
                $(this).closest(".option-row").remove();
                updateOptionLabels();
                updateRemoveButtons();
            });

            // Update option labels (A, B, C, ...)
            function updateOptionLabels() {
                $(".option-row").each(function(index) {
                    const letter = String.fromCharCode(65 + index);
                    $(this).find(".option-label").text(letter);
                });
            }

            // Ensure at least 2 options remain
            function updateRemoveButtons() {
                const optionCount = $(".option-row").length;
                if (optionCount <= 2) {
                    $(".remove-option").prop("disabled", true);
                } else {
                    $(".remove-option").prop("disabled", false);
                }
            }
        });
    </script>
@endpush

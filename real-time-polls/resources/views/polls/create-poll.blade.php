@extends('layouts.master')

@section('title', 'Answer Poll')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/scss/pages/summernote.scss')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
@endpush

@section('content')
    @if(!$data['is_expired'])
        <div class="page-heading">
            <h3>Ayo Dijawab Gaess !</h3>
        </div>
        <div class="page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <form class="form" action="{{route('poll.store', ['uuid' => $data['data']->uuid ])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="card shadow-sm">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0 text-white">{{ $data['data']->name ?? "Question" }}</h4>
                                    <input type="hidden" name="question" value="{{ $data['data']->id }}">
                                </div>
                                <div class="card-body p-4">
                                    <div id="options-container">
                                        @foreach($data['data']->options as $i => $option)
                                            @php
                                                $index = chr(65 + $i);
                                            @endphp
                                            <div class="d-flex align-items-center p-3 mb-3 border rounded option-item" onclick="selectOption(this)">
                                                <span class="fw-bold">{{ $index }}. </span>
                                                <div class="flex-grow-1"> {{ $option->name }}</div>
                                                <input type="radio" name="option" value="{{ $option->id }}" class="d-none">
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            Lanjutkan<i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="page-heading">
            <h3>Sudah expired gaess !</h3>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        function selectOption(element) {
            $('.option-item').removeClass('bg-light-primary border-primary');
            $(element).addClass('bg-light-primary border-primary');
            $(element).find('input[type="radio"]').prop('checked', true);
        }

        $(document).ready(function() {
            $("#add-option").click(function() {
                const optionsContainer = $("#options-container");
                const optionCount = optionsContainer.children().length;

                const nextLetter = String.fromCharCode(65 + optionCount);

                const newOption = `
                    <div class="d-flex align-items-center p-3 mb-3 border rounded option-item" onclick="selectOption(this)">
                        <div class="avatar avatar-sm bg-primary me-3 d-flex justify-content-center align-items-center">
                            <span class="fw-bold">${nextLetter}</span>
                        </div>
                        <div class="flex-grow-1">
                            <input type="text" class="form-control border-0 bg-transparent p-0" name="options[]" required placeholder="Enter your option...">
                        </div>
                        <button type="button" class="btn btn-sm btn-danger remove-option ms-2">
                            <i class="bi bi-trash"></i>
                        </button>
                        <input type="radio" name="selected_option" value="new_${optionCount}" class="d-none">
                    </div>
                `;

                optionsContainer.append(newOption);
                optionsContainer.find('.form-control').last().focus();
            });

            $(document).on("click", ".remove-option", function(e) {
                e.stopPropagation();
                $(this).closest(".option-item").remove();
                updateOptionLabels();
            });

            function updateOptionLabels() {
                $(".option-item").each(function(index) {
                    const letter = String.fromCharCode(65 + index);
                    $(this).find(".avatar span").text(letter);
                });
            }

            $("form").on("submit", function(e) {
                if (!$('input[name="option"]:checked').val()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Tidak Ada jawaban yang dipilih',
                        text: 'Pilih Jawaban Terlebih Dahulu',
                        icon: 'warning',
                        confirmButtonColor: '#435ebe'
                    });
                } else {
                    Swal.fire({
                        title: 'Loading...',
                        text: 'Jawaban anda berhasil kami proses',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        });
    </script>
@endpush

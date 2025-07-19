@extends('layouts.master')

@section('title', 'Create Campaign')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/scss/pages/summernote.scss')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
@endpush
@section('content')
    <div class="page-heading">
        <h3>Hasil Polling</h3>
        <h7>{{ $data['data']->name ?? "" }} ?</h7>
    </div>
    <div class="page-content">

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-4">
                    @foreach($data['data']->options as $i => $option)
                    @php
                        $index = chr(65 + $i);
                    @endphp
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-title">{{ $index . ". ".$option->name }}</h4>
                                <p class="card-text">{{ $option->votes }} Votes : 3</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/summernote.js') }}"></script>
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
@endpush

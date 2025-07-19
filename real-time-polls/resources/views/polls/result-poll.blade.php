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
                <div class="col-4" id="poll-results">
                    @foreach($data['data']->options as $i => $option)
                    @php
                        $index = chr(65 + $i);
                    @endphp
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-title">{{ $index . ". ".$option->name }}</h4>
                                <p class="card-text">{{ $option->votes }} Votes</p>
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

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchPollResults();
            setupPusher();
        });

        function fetchPollResults() {
            console.log('Fetching poll results...');
            $.ajax({
                url: "{{ route('api-result-poll', ['uuid' => $data['data']->uuid]) }}",
                method: 'GET',
                success: function(response) {
                    console.log('Poll results received:', response);
                    if (response.status === 'success') {
                        updatePollResults(response.data.votes.question);
                    }
                },
                error: function(error) {
                    console.log("Error fetching poll results:", error);
                    console.error('Error fetching poll results:', error);
                }
            });
        }

        function setupPusher() {
            console.log('Setting up Pusher...');
            console.log('Pusher key:', '{{ env('PUSHER_APP_KEY') }}');
            console.log('Pusher cluster:', '{{ env('PUSHER_APP_CLUSTER') }}');

            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channelName = 'polls.{{ $data['data']->uuid }}';
            console.log('Subscribing to channel:', channelName);
            var channel = pusher.subscribe(channelName);

            channel.bind('pusher:subscription_succeeded', function() {
                console.log('Successfully subscribed to channel:', channelName);
            });

            channel.bind('pusher:subscription_error', function(error) {
                console.error('Error subscribing to channel:', error);
            });

            console.log('Binding to event: poll.created');
            channel.bind('poll.created', function(data) {
                console.log('New poll data received:', data);
                fetchPollResults();
            });
        }
        function updatePollResults(question) {
            var resultsContainer = document.getElementById('poll-results');
            resultsContainer.innerHTML = '';
            if (question && question.options) {
                question.options.forEach(function(option, i) {
                    var index = String.fromCharCode(65 + i);
                    var cardHtml = `
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">${index}. ${option.name}</h4>
                                    <p class="card-text">${option.votes} Votes</p>
                                </div>
                            </div>
                        </div>
                    `;
                    resultsContainer.innerHTML += cardHtml;
                });

            }
        }
    </script>
@endpush

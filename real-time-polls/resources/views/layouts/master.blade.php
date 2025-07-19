<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TrimHub Indonesia - @yield('title')</title>


    <!-- Meta description for SEO -->
    <meta name="description" content="Experience seamless bookings, personalized care, online payments, and a comprehensive CRM, along with an intuitive dashboard for owners, all within our innovative, effortless management solution">

    <!-- Keywords for SEO -->
    <meta name="keywords" content="Barbershop, Salon, Online Booking, Beauty Clinic, Personal Care, Haircut, Grooming, Spa Services, Appointment Scheduling, TrimHub">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:title" content="TrimHub Indonesia - Pasti Bisa Cakep!">
    <meta property="og:description" content="Experience seamless bookings, personalized care, online payments, and a comprehensive CRM, along with an intuitive dashboard for owners, all within our innovative, effortless management solution">
    <meta property="og:image" content="https://devel.s3.nevaobjects.id/general/assets/landing-page/8592c575-6f1b-43aa-a351-e47ed9121271.png">
    <meta property="og:url" content="https://trimhub.id/">

    <!-- Twitter card meta tags for better Twitter sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="TrimHub Indonesia - Pasti Bisa Cakep!">
    <meta name="twitter:description" content="Experience seamless bookings, personalized care, online payments, and a comprehensive CRM, along with an intuitive dashboard for owners, all within our innovative, effortless management solution">
    <meta name="twitter:image" content="https://devel.s3.nevaobjects.id/general/assets/landing-page/8592c575-6f1b-43aa-a351-e47ed9121271.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://devel.s3.nevaobjects.id/general/assets/landing-page/8592c575-6f1b-43aa-a351-e47ed9121271.png">

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">

    <!-- CHOICES -->
    {{--    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">--}}

    {{-- Date picker --}}
    {{--    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">--}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles')
</head>

<body>

<div id="app">
    <!-- sidebar -->
    @include('layouts.sidebar')
    <!-- /.sidebar -->

    <!-- alert -->
    @include('layouts.alert')
    <!-- /.alert -->

    <div id="main" class="px-2">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div id="app-vite">
            <!-- content -->
            {{--            <example-component></example-component>--}}
            @yield('content')
            <!-- /.content -->
        </div>


        <!-- footer -->
        @include('layouts.footer')
        <!-- /.footer -->
    </div>
</div>
</body>

</html>

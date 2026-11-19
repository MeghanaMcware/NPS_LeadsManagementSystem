<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Meta --}}
    <meta name="description" content="Book Appointment">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>@yield('title', 'Book Appointment')</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/pwa/images/GBA-removebg-preview.png') }}">
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('admin/assets/images/newphotes/icon.jpg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/newphotes/icon.jpg') }}" type="image/x-icon">
    <title>@yield('title') - Admin</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    {{-- Core Vendor CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/feather-icon.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('admin/assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/select2.css') }}">

    {{-- Layout overrides --}}
    <style>
    .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .simplebar-offset {
        height: auto !important;
    }

    .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-link:not(.active) span:hover{
        color:white !important;
    }

    body {
        background-color: #edf4fbad !important;
    }

    .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a span {
        color: #fff !important;
    }

    .nav-menus {
        display: flex;
        align-items: center;
    }

    .admin-page-loader {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1rem;
        color: #fff;
        text-align: center;
        background: #021b45;
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }

    .admin-page-loader.is-visible {
        display: flex;
        animation: adminLoaderFade .25s ease-out;
    }

    body.admin-page-loading {
        overflow: hidden;
    }

    .btn-primary {
        background-color: #001c45 !important;
        border-color: #001c45 !important;
    }
    .btn-primary:hover {
        background-color: #001c45 !important;
        border-color: #001c45 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button:active {
         background-color: #001c45 !important;
    }

    .admin-loader-ring {
        position: relative;
        display: grid;
        width: 116px;
        height: 116px;
        place-items: center;
    }

    .admin-loader-ring::before {
        position: absolute;
        inset: 0;
        border: 4px solid rgba(255, 255, 255, .18);
        border-top-color: #f5b82e;
        border-radius: 50%;
        content: "";
        animation: adminLoaderSpin 1s linear infinite;
    }

    .admin-loader-emblem {
        display: grid;
        width: 86px;
        height: 86px;
        overflow: hidden;
        place-items: center;
        background: #fff;
        border-radius: 50%;
    }

    .admin-loader-emblem img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .admin-loader-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .admin-loader-subtitle {
        margin: 0;
        font-size: .9rem;
        opacity: .8;
    }

    .admin-loader-bar {
        width: 190px;
        height: 4px;
        overflow: hidden;
        background: rgba(255, 255, 255, .18);
        border-radius: 4px;
    }

    .admin-loader-bar::after {
        display: block;
        width: 40%;
        height: 100%;
        background: #8ee6a8;
        border-radius: 4px;
        content: "";
        animation: adminLoaderSlide 1.2s ease-in-out infinite;
    }

    @keyframes adminLoaderSpin {
        to { transform: rotate(360deg); }
    }

    @keyframes adminLoaderSlide {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(260%); }
    }

    @keyframes adminLoaderFade {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 1366px) and (min-width: 767px) {
        .page-wrapper.compact-wrapper .page-header .header-wrapper .nav-right {
            flex: 0 0 64%;
            max-width: 64%;
        }
    }

    @media (max-width: 767px) {
        .page-wrapper.compact-wrapper .page-header .header-wrapper .nav-right {
            margin-left: 0 !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-loader-ring::before,
        .admin-loader-bar::after {
            animation-duration: 2.5s;
        }
    }
    </style>
    @yield('style')
    @stack('styles')
</head>

<body>

    <div class="admin-page-loader is-visible" id="adminPageLoader" role="status" aria-live="polite"
        aria-hidden="false">
        <div class="admin-loader-ring">
            <div class="admin-loader-emblem">
                <img src="{{ asset('admin/assets/images/logo/NPS_logo (1).png') }}" alt="">
            </div>
        </div>
        <div>
            <p class="admin-loader-title">Loading page...</p>
            <p class="admin-loader-subtitle">Please wait while your page loads</p>
        </div>
        <div class="admin-loader-bar"></div>
    </div>

    {{-- Back to top --}}
    <div class="tap-top">
        <i data-feather="chevrons-up"></i>
    </div>

    <div class="page-wrapper default-wrapper" id="pageWrapper">

        {{-- NAVBAR --}}
        @include('admin.layouts.header')

        <div class="page-body-wrapper default-menu">

            {{-- SIDEBAR --}}
            @include('admin.layouts.sidebar')

            <div class="page-body">

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                @endif

                {{-- MAIN CONTENT --}}
                <div class="">
                    @yield('content')
                </div>

            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')
    </div>

    <script src="{{ asset('admin/assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- <script src="{{ asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script> -->
    <!-- <script src="{{ asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script> -->
    <script src="{{ asset('admin/assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/select2/select2-custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    @stack('scripts')

    <script>
    (function () {
        const loader = document.getElementById('adminPageLoader');

        function showLoader() {
            loader.classList.add('is-visible');
            loader.setAttribute('aria-hidden', 'false');
            document.body.classList.add('admin-page-loading');
        }

        function hideLoader() {
            loader.classList.remove('is-visible');
            loader.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('admin-page-loading');
        }

        document.addEventListener('click', function (event) {
            const clickedElement = event.target;

            if (
                event.defaultPrevented ||
                event.button !== 0 ||
                event.metaKey ||
                event.ctrlKey ||
                event.shiftKey ||
                event.altKey ||
                !(clickedElement instanceof Element)
            ) {
                return;
            }

            const link = clickedElement.closest('a[href]');

            if (
                !link ||
                link.hasAttribute('download') ||
                (link.target && link.target.toLowerCase() !== '_self')
            ) {
                return;
            }

            const destination = new URL(link.href, window.location.href);

            if (
                destination.origin !== window.location.origin ||
                (destination.pathname === window.location.pathname &&
                    destination.search === window.location.search &&
                    destination.hash !== '')
            ) {
                return;
            }

            showLoader();
        });

        document.addEventListener('submit', function (event) {
            const form = event.target;

            if (
                event.defaultPrevented ||
                !(form instanceof HTMLFormElement) ||
                form.method.toLowerCase() === 'dialog' ||
                (form.target && form.target.toLowerCase() !== '_self')
            ) {
                return;
            }

            showLoader();
        });

        window.addEventListener('load', hideLoader, { once: true });
        window.addEventListener('pageshow', hideLoader);
    })();
    </script>

    <script>
    // THIS CODE RUNS WHEN THE DOCUMENT IS LOADED
    $(document).ready(function() {
        // CALL THE ALERT FUNCTION
        showFlashAlerts();

        // Auto-hide standard bootstrap alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "all 0.4s ease";
                alert.style.opacity = "0";
                alert.style.transform = "translateY(-10px)";
                setTimeout(() => alert.remove(), 400);
            });
        }, 5000);
    });

    // FUNCTION DEFINITION
    function showFlashAlerts() {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonColor: '#28a745',
            confirmButtonText: 'ok'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#d33',
            confirmButtonText: 'yes'
        });
        @endif
    }
    </script>
</body>

</html>
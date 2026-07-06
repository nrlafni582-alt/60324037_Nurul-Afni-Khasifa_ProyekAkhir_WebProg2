<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    @include('layouts.navigation')

    <div class="container mt-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show flash-message" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show flash-message" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        setTimeout(function () {
            let alerts = document.querySelectorAll('.flash-message');
            alerts.forEach(function(alert){
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 3000);
    </script>

    @stack('scripts')

    <style>
    /* Dark mode */
    .dark-mode{ background:#121212!important; color:#e6e6e6; }
    .dark-mode .card{ background:#1e1e1e; color:#e6e6e6; }
    .dark-mode .navbar{ background:#000!important; }
    .dark-mode table{ color:#e6e6e6; }
    .dark-mode .form-control, .dark-mode .form-select{ background:#2b2b2b; color:#e6e6e6; border-color:#555; }
    .dark-mode .btn-outline-primary{ color:#e6e6e6; }
    .dark-mode .dropdown-menu{ background:#1e1e1e; color:#e6e6e6; }

    /* Loader */
    #loader{ position:fixed; width:100%; height:100%; background:#fff; display:flex; justify-content:center; align-items:center; z-index:9999; }
    #loader.hidden{ display:none; }

    /* Animations & UI polish */
    .card{ animation:fadeIn .5s ease; transition:.3s; }
    @keyframes fadeIn{ from{ opacity:0; transform:translateY(20px); } to{ opacity:1; transform:translateY(0); } }

    .btn{ transition:.3s; }
    .btn:hover{ transform:scale(1.05); }

    .card:hover{ transform:translateY(-6px); box-shadow:0 12px 25px rgba(0,0,0,.2); }

    .navbar{ transition:.4s; }

    .form-control:focus{ box-shadow:0 0 10px #0d6efd; transform:scale(1.02); transition:.3s; }

    .table tbody tr{ transition:.3s; }
    .table tbody tr:hover{ background:#eef6ff; }

    .badge{ transition:.3s; }
    .badge:hover{ transform:rotate(-3deg); }

    .bi{ transition:.3s; }
    .bi:hover{ transform:rotate(10deg); }
    </style>

    <script>
        (function(){
            const btn = document.getElementById('theme-toggle');
            try {
                if (btn && localStorage.getItem('theme') === 'dark'){
                    document.body.classList.add('dark-mode');
                    btn.innerHTML = '☀️';
                }

                if (btn) {
                    btn.addEventListener('click', function(){
                        document.body.classList.toggle('dark-mode');
                        if(document.body.classList.contains('dark-mode')){
                            localStorage.setItem('theme','dark');
                            btn.innerHTML = '☀️';
                        } else {
                            localStorage.setItem('theme','light');
                            btn.innerHTML = '🌙';
                        }
                    });
                }
            } catch (e) {
                console.error(e);
            }
        })();
    </script>

    <!-- Page loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <script>
        window.addEventListener('load', function(){
            const l = document.getElementById('loader');
            if (l) l.classList.add('hidden');
        });
    </script>

</body>
</html>
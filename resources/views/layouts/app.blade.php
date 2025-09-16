<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arsip Surat - Kelurahan Karangduren')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pdf-viewer.css') }}">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .btn {
            border-radius: 8px;
        }

        .badge {
            border-radius: 20px;
        }

        .sidebar-brand {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
        }

        .sidebar-brand h5 {
            margin: 0;
            font-weight: bold;
        }

        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .content-wrapper {
            background: white;
            border-radius: 15px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="sidebar-brand">
                        <i class="fas fa-archive fa-2x mb-2 text-primary"></i>
                        <h5 class="text-white">Arsip Surat</h5>
                        <small class="text-light">Kelurahan Karangduren</small>
                    </div>

                    <ul class="nav flex-column mt-4">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('arsip-surat.*', 'home') ? 'active' : '' }}"
                                href="{{ route('arsip-surat.index') }}">
                                <i class="fas fa-archive me-2"></i>
                                Arsip Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori-surat.*') ? 'active' : '' }}"
                                href="{{ route('kategori-surat.index') }}">
                                <i class="fas fa-tags me-2"></i>
                                Kategori Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                                href="{{ route('about') }}">
                                <i class="fas fa-info-circle me-2"></i>
                                About
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="content-wrapper">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    @stack('scripts')
</body>

</html>
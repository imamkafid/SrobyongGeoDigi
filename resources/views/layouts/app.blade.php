<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SrobyongGeoDigi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" /> -->
    <!-- Custom CSS -->
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            border: none;
            border-radius: 10px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,.1);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-card .card-title {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .card-number {
            font-size: 2rem;
            font-weight: 600;
            margin: 10px 0;
        }

        .table {
            box-shadow: 0 0 20px rgba(0,0,0,.05);
            border-radius: 10px;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-menunggu { background-color: #fef3c7; color: #92400e; }
        .status-proses { background-color: #dbeafe; color: #1e40af; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .status-ditolak { background-color: #fee2e2; color: #991b1b; }

        .text-danger {color: #dc3545 !important;}
    </style>
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-geo-alt-fill me-2"></i>
                SrobyongGeoDigi
            </a>
            
            @if(session()->has('role'))
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>
                            <span>
                                {{ session('role') === 'admin' ? 'Admin' : 'Warga' }} - {{ session('nik') }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
    @stack('scripts')
</body>
</html>
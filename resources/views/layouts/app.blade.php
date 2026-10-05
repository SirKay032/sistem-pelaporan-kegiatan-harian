<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Sistem Pelaporan Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #0f172a;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        
        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        
        .navbar {
            background-color: var(--secondary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 600;
            color: #fff !important;
        }
        
        .sidebar {
            background-color: var(--secondary);
            color: #fff;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            margin-top: 60px;
        }
        
        .sidebar .nav-link {
            color: #dbeafe !important;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: #fff !important;
        }
        
        .sidebar .divider {
            height: 1px;
            background-color: rgba(255,255,255,0.1);
            margin: 1rem 0;
        }
        
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }
        
        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
        }
        
        .stat-box {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .stat-box .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-box .label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        table {
            background: #fff;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">SPK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="ps-3 pe-3">
            <div class="user-info mb-4">
                <div style="font-weight: 600; font-size: 0.95rem;">{{ Auth::user()->nama }}</div>
                <div style="font-size: 0.8rem; color: #cbd5e1;">{{ Auth::user()->role == 'pegawai' ? 'Pegawai' : (Auth::user()->role == 'atasan' ? 'Atasan' : 'Admin') }}</div>
            </div>
            
            <nav class="nav flex-column">
                <a class="nav-link{{ request()->routeIs('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link{{ request()->routeIs('laporan.*') ? ' active' : '' }}" href="{{ route('laporan.index') }}">Laporan Harian</a>
                <a class="nav-link{{ request()->routeIs('rekap.*') ? ' active' : '' }}" href="{{ route('rekap.index') }}">Rekap Bulanan</a>
            </nav>
        </div>
    </div>

    <div class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

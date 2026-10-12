<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WorkTrack') | WorkTrack</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #eef2ff;
            --page-bg: #f8fafc;
            --text-dark: #172033;
            --text-muted: #64748b;
            --border: #e8edf4;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text-dark);
            font-family: Inter, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            inset: 0 auto 0 0;
            background: #fff;
            border-right: 1px solid var(--border);
            padding: 28px 18px;
            z-index: 1000;
        }

        .brand {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 38px;
        }

        .brand span {
            color: var(--primary);
        }

        .nav-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 1.1px;
            margin: 24px 12px 10px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 10px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: .2s;
        }

        .side-link:hover,
        .side-link.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .side-link i {
            font-size: 18px;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            padding: 0 34px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-content {
            padding: 32px 34px;
        }

        .card-clean {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .025);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 21px;
        }

        .stat-value {
            font-size: 29px;
            font-weight: 750;
            letter-spacing: -1px;
        }

        .text-muted-custom {
            color: var(--text-muted);
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border: 0;
            border-radius: 9px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: #4338ca;
            color: white;
        }

        .table> :not(caption)>*>* {
            padding: 16px;
            border-bottom-color: var(--border);
            vertical-align: middle;
        }

        .table thead th {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            background: #fafbfe;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-progress {
            background: #eef2ff;
            color: #4f46e5;
        }

        .status-completed {
            background: #dcfce7;
            color: #15803d;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-overdue {
            background: #fee2e2;
            color: #b91c1c;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 76px;
                padding: 24px 10px;
            }

            .brand {
                font-size: 17px;
                text-align: center;
            }

            .brand-text,
            .nav-label,
            .link-text {
                display: none;
            }

            .side-link {
                justify-content: center;
                padding: 13px 8px;
            }

            .main-content {
                margin-left: 76px;
            }

            .topbar {
                padding: 0 18px;
            }

            .page-content {
                padding: 22px 16px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 60px;
                padding-inline: 6px;
            }

            .main-content {
                margin-left: 60px;
            }

            .topbar {
                height: 64px;
            }

            .page-content {
                padding: 18px 12px;
            }

            .stat-value {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-layers-fill" style="color:#4f46e5"></i>
            <span class="brand-text">WorkTrack</span>
        </div>

        <div class="nav-label">WORKSPACE</div>

        <a href="{{ route('dashboard') }}" class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="link-text">Dashboard</span>
        </a>

        <a href="{{ route('tasks.index') }}" class="side-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="bi bi-kanban"></i>
            <span class="link-text">All Tasks</span>
        </a>

        <a href="{{ route('daily-updates.index') }}" class="side-link">
            <i class="bi bi-calendar2-check"></i>
            <span class="link-text">Daily Updates</span>
        </a>

        <div class="nav-label">MANAGEMENT</div>

        @if(auth()->user()->role === 'manager')
            <a href="{{ route('employees.index') }}" class="side-link">
                <i class="bi bi-people"></i>
                <span class="link-text">Employees</span>
            </a>
        @endif

        <a href="{{ route('performance.index') }}" class="side-link">
            <i class="bi bi-graph-up-arrow"></i>
            <span class="link-text">Performance</span>
        </a>


        @if(auth()->user()->role === 'manager')
            <a href="{{ route('reports.index') }}" class="side-link">
                <i class="bi bi-bar-chart"></i>
                <span>Reports</span>
            </a>
        @endif
    </aside>

    <main class="main-content">
        <header class="topbar">

            <div>
                <div class="fw-semibold">@yield('topbar-title', 'Workspace')</div>
                <small class="text-muted-custom">Employee productivity platform</small>
            </div>




            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-semibold small">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </div>
                    <small class="text-muted-custom">
                        {{ ucfirst(auth()->user()->role ?? 'employee') }}
                    </small>
                </div>



                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:40px;height:40px;background:#e0e7ff;color:#4338ca;font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <section class="page-content">
            @yield('content')
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
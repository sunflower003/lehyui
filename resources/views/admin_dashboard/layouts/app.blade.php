<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - LehyUI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-width: 250px;
            --header-height: 60px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #1e293b;
            color: #e2e8f0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-collapsed {
            left: calc(-1 * var(--sidebar-width) + 60px);
        }
        .content-area {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
            background: #f3f4f6;
            display: flex;
            flex-direction: column;
        }
        .content-expanded {
            margin-left: 60px;
        }
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 6px;
            margin: 4px 8px;
        }
        .nav-link:hover {
            background-color: #334155;
            color: white;
        }
        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        .card-stats {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
            transition: all 0.3s;
        }
        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.mobile-open {
                left: 0;
            }
            .content-area {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-layer-group text-indigo-400 text-xl mr-2"></i>
                    <h1 class="text-xl font-bold">LehyUI Admin</h1>
                </div>
                <button id="sidebar-toggle" class="lg:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-6">
                @include("admin_dashboard.layouts.nav")
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-area w-full" id="content-area">
            <!-- Header -->
            <div class="header flex items-center justify-between px-4">
                <div class="flex items-center">
                    <button id="mobile-toggle" class="mr-4 lg:hidden">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    <h2 class="text-gray-700 font-medium">@yield('page-title', 'Dashboard')</h2>
                </div>
                @include("admin_dashboard.layouts.header")
            </div>

            <!-- Main Content -->
            <main class="flex-1 px-8 py-6" style="width:100%;">
                @if(Session::has('success'))
                    <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        {{ Session::get('error') }}
                    </div>
                @endif

                @yield("wrapper")
            </main>

            <!-- Footer -->
            <footer class="p-4 text-center text-gray-600 border-t">
                <p class="mb-0">Tất cả các quyền © Nam Duong.</p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentArea = document.getElementById('content-area');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileToggle = document.getElementById('mobile-toggle');
            
            // Mobile toggle
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
            
            // Sidebar close on mobile
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
            });
            
            // Set active nav link
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href)) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @yield("script")
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - LehyUI</title>
</head>

<body>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <div class="wrapper">
        @include("admin_dashboard.layouts.header")
        @include("admin_dashboard.layouts.nav")

        <main>
            @yield("content")
        </main>

        <footer>
            <p class="mb-0">Tất cả các quyền © Nam Duong.</p>
        </footer>
    </div>

    <!-- dùng CDN thay vì asset lỗi -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @yield("script")
</body>
</html>

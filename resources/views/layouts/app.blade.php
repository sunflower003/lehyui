<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LehyUI')</title>
    <link rel="icon" href="{{ asset('img/google_ads.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @yield('content')

    <!-- JS -->
    <script src="{{ asset('js/event.js') }}"></script>

    <!-- Toast Notification -->
    <div id="toast" class="custom-toast"></div>
    <script>
    function showToast(message) {
      const toast = document.getElementById('toast');
      if (!toast) return;
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 2600);
    }
    // Tự động show toast nếu có session từ backend
    @if (session('success'))
      showToast(@json(session('success')));
    @endif
    @if (session('login_success'))
      showToast(@json(session('login_success')));
    @endif
    @if ($errors->any())
      showToast(@json($errors->first()));
    @endif
    </script>
</body>
</html>

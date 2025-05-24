<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LehyUI')</title>
    <link rel="icon" href="{{ asset('img/google_ads.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @yield('content')
    <a href="#"><i class="ri-arrow-up-line scroll-up"></i></a>


    <!-- Toast Notification -->
    <div id="toast" class="custom-toast"></div>
    <script>
    function showToast(message) {
      const toast = document.getElementById('toast');
      if (!toast) return;
      toast.innerHTML = message; // Cho phép HTML (icon, link)
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3200);
    }
    // Tự động show toast nếu có session từ backend
    @if (session('success'))
      showToast(@json(session('success')));
    @endif
    @if (session('login_success'))
      showToast(@json(session('login_success')));
    @endif
    @if (session('mail_notification'))
      showToast(@json(session('mail_notification')));
    @endif
    @if ($errors->any())
      showToast(@json($errors->first()));
    @endif
    
    </script>
    <!-- JS -->
    <script src="{{ asset('js/event.js') }}"></script>
</body>
</html>
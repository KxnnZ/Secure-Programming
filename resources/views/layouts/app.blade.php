<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Cinema67')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
@stack('scripts')
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Cinema67</a>
    <div class="navbar-nav">
        <a class="nav-link" href="{{ route('movies.index') }}">Movies</a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a class="nav-link" href="{{ route('admin.movies.index') }}">Admin</a>
            @endif
        @endauth
    </div>
    <ul class="navbar-nav ms-auto">
        @auth
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-link nav-link" type="submit">Logout</button>
                </form>
            </li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @endauth
    </ul>
  </div>
</nav>

<main class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @yield('content')
</main>
<footer class="text-center text-secondary py-3 mt-5 border-top border-secondary">
    <small>&copy; {{ date('Y') }} <strong>Cinema67</strong> — All Rights Reserved</small>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

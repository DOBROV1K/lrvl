<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="{{ route('clubs.index') }}">Футбольные клубы</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Пользователи</a>
            </li>

            @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clubs.trash') }}">Корзина</a>
                </li>
            @endif
        @endauth

        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Вход</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
          </li>
        @else
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
              @if(Auth::user()->isAdmin())
                <span class="badge bg-danger">Админ</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('profile.edit') }}">
                      <i class="fa-solid fa-user-gear me-1"></i> Мой профиль
                  </a>
              </li>

              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Выход</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<div class="container my-4">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @yield('content')
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

@extends('layouts.guest')

@section('title', 'Вход')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="width: 420px;">
        <h2 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-right-to-bracket text-primary me-2"></i> Вход
        </h2>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Войти
            </button>

            <div class="text-center mt-2">
                Нет аккаунта?
                <a href="{{ route('register') }}">Регистрация</a>
            </div>
        </form>
    </div>
</div>
@endsection

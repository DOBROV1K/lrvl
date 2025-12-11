@extends('layouts.guest')

@section('title', 'Регистрация')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="width: 480px;">
        <h2 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-user-plus text-primary me-2"></i> Регистрация
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Имя</label>
                <input type="text" name="name" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-3">
                Создать аккаунт
            </button>

            <div class="text-center">
                Уже есть аккаунт?
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </form>
    </div>
</div>
@endsection

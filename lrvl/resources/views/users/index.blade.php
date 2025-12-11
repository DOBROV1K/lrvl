@extends('layouts.app')

@section('title', 'Все пользователи')

@section('content')
<h1 class="mb-4">Список пользователей</h1>

@if($users->isEmpty())
    <div class="alert alert-info">Пользователи отсутствуют</div>
@else
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <i class="fa-solid fa-user"></i> {{ $user->name }}
                </span>

                <a href="{{ route('users.clubs', $user->name) }}" class="btn btn-primary btn-sm">
                    Смотреть клубы
                </a>
            </li>
        @endforeach
    </ul>
@endif
@endsection

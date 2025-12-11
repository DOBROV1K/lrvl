@extends('layouts.app')

@section('title', 'Клубы пользователя ' . $user->name)

@section('content')

<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>

    @auth
        @if(Auth::id() !== $user->id)
            @if(Auth::user()->isFriendWith($user))
                <form action="{{ route('friends.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <i class="fa-solid fa-user-minus me-1"></i> Удалить из друзей
                    </button>
                </form>
            @else
                <form action="{{ route('friends.store', $user->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">
                        <i class="fa-solid fa-user-plus me-1"></i> Добавить в друзья
                    </button>
                </form>
            @endif
        @endif
    @endauth
</div>

<h2 class="fw-bold mb-4">
    Клубы пользователя: {{ $user->name }}
</h2>

@if($clubs->isEmpty())
    <div class="alert alert-info">
        У пользователя {{ $user->name }} пока нет клубов.
    </div>
@else
    <div class="row g-4">
        @foreach($clubs as $club)
            @include('clubs.partials.card', ['club' => $club])
        @endforeach
    </div>
@endif

@auth
    @include('clubs.edit-modal')
    @include('clubs.create-modal')
@endauth

@endsection

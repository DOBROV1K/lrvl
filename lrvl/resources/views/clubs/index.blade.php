@extends('layouts.app')

@section('title', 'Футбольные клубы')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    @auth
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createClubModal">
        <i class="fa-solid fa-plus"></i> Добавить клуб
    </button>
    @endauth
</div>

@guest
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <a href="{{ route('login') }}">Войдите</a> или
        <a href="{{ route('register') }}">зарегистрируйтесь</a>,
        чтобы добавлять и управлять клубами.
    </div>
@endguest

<div class="row g-4">
    @foreach($clubs as $club)
        @include('clubs.partials.card', ['club' => $club])
    @endforeach
</div>

@auth
    @include('clubs.create-modal')
    @include('clubs.edit-modal')
@endauth

@endsection

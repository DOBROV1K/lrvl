@extends('layouts.app')

@section('title', 'Клубы пользователя ' . $user->name)

@section('content')

<div class="mb-4">
    <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад к списку
    </a>
</div>



@if($clubs->isEmpty())
    <div class="alert alert-info">
        У пользователя {{ $user->name }} пока нет клубов
    </div>
@else
    <div class="row g-4">
        @foreach($clubs as $club)
            @include('clubs.partials.card', ['club' => $club])
        @endforeach
    </div>
@endif

@endsection

@auth
    @include('clubs.edit-modal')
    @include('clubs.create-modal')
@endauth

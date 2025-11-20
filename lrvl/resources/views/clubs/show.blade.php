@extends('layouts.app')

@section('title', $club->name)

@section('content')

<div class="container py-4">
    <div class="card shadow-lg rounded-4">
        
        <div class="card-header bg-primary text-white rounded-top-4">
            <h2 class="mb-0">
                <i class="fa-solid fa-futbol me-2"></i>
                {{ $club->name }}
            </h2>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-4 text-center">
                    @if($club->image_path)
                        <img src="{{ asset($club->image_path) }}" 
                             class="img-fluid rounded mb-3 shadow"
                             style="max-height: 250px; object-fit: contain;">
                    @endif
                </div>

                <div class="col-md-8">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            <strong>Страна:</strong> {{ $club->country }}
                        </li>

                        <li class="list-group-item">
                            <strong>Основан:</strong> {{ $club->founded }}
                        </li>

                        <li class="list-group-item">
                            <strong>Президент:</strong> {{ $club->president }}
                        </li>

                        <li class="list-group-item">
                            <strong>Стадион:</strong> {{ $club->stadium }}
                        </li>

                        @if($club->capacity)
                        <li class="list-group-item">
                            <strong>Вместимость:</strong> {{ $club->capacity }}
                        </li>
                        @endif

                        @if($club->trophies)
                        <li class="list-group-item">
                            <strong>Трофеи:</strong> {{ $club->trophies }}
                        </li>
                        @endif

                    </ul>
                </div>
            </div>

            @if($club->description)
                <div class="mt-4">
                    <h5><strong>Описание</strong></h5>
                    <p class="text-muted">{{ $club->description }}</p>
                </div>
            @endif

        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('clubs.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Назад
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('clubs.edit', $club) }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-pen"></i> Редактировать
                </a>

                <form method="POST" action="{{ route('clubs.destroy', $club) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Удалить клуб?')">
                        <i class="fa-solid fa-trash"></i>
                        Удалить
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection

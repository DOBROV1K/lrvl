@extends('layouts.app')

@section('title','Клубы')

@section('content')
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createClubModal">
    <i class="fa-solid fa-plus"></i> Добавить клуб
</button>

<div class="row g-4">
@foreach($clubs as $club)
<div class="col-12 col-md-6 col-lg-4">
    <div class="club-card card shadow-lg border-0 rounded-4 overflow-hidden h-100 d-flex flex-column">

        <div class="club-card-img-wrapper">
        @if($club->image_path)
            <img src="{{ asset($club->image_path) }}" class="club-card-img" alt="{{ $club->name }}">
        @endif
        </div>

        <div class="card-body">
            <h4 class="fw-bold mb-2">
                <i class="fa-solid fa-futbol text-primary me-2"></i>
                {{ $club->name }}
            </h4>

            <p class="text-muted mb-1">
                <i class="fa-solid fa-flag"></i> {{ $club->country }}
            </p>

            <p class="text-muted mb-0">
                <i class="fa-solid fa-calendar"></i> Основан: {{ $club->founded }}
            </p>
        </div>

        <div class="card-footer bg-white border-0 mt-auto">
            <div class="d-flex gap-2 justify-content-between align-items-stretch w-100">
                <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary btn-sm flex-fill d-flex align-items-center justify-content-center">
                    Подробнее
                </a>

                <button 
                    class="btn btn-outline-secondary btn-sm flex-fill edit-modal-btn"
                    data-id="{{ $club->id }}"
                    data-name="{{ $club->name }}"
                    data-country="{{ $club->country }}"
                    data-founded="{{ $club->founded }}"
                    data-president="{{ $club->president }}"
                    data-stadium="{{ $club->stadium }}"
                    data-capacity="{{ $club->capacity }}"
                    data-trophies="{{ $club->trophies }}"
                    data-description="{{ $club->description }}"
                    data-image="{{ asset($club->image_path) }}"
                >
                    Редактировать
                </button>

                <form action="{{ route('clubs.destroy',$club) }}" method="POST" class="flex-fill d-flex">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm flex-fill d-flex align-items-center justify-content-center" onclick="return confirm('Удалить?')">
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>
@endsection
@include('clubs.modal')
@include('clubs.edit-modal')
@include('clubs.create-modal')
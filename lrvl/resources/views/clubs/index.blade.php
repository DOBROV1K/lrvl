@extends('layouts.app')

@section('title','Клубы')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">

    
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
    чтобы добавлять и управлять клубами
</div>
@endguest

<div class="row g-4">
@foreach($clubs as $club)
<div class="col-12 col-md-6 col-lg-4">
    <div class="club-card card shadow-lg border-0 rounded-4 overflow-hidden h-100 d-flex flex-column @if($club->trashed()) opacity-50 @endif">

        <div class="club-card-img-wrapper">
        @if($club->image_path)
            <img src="{{ asset($club->image_path) }}" class="club-card-img" alt="{{ $club->name }}">
        @endif
        </div>

        <div class="card-body">
            <h4 class="fw-bold mb-2">
                <i class="fa-solid fa-futbol text-primary me-2"></i>
                {{ $club->name }}
                
                @if($club->trashed())
                    <span class="badge bg-danger">Удалён</span>
                @endif
            </h4>

            <p class="text-muted mb-1">
                <i class="fa-solid fa-flag"></i> {{ $club->country }}
            </p>

            <p class="text-muted mb-1">
                <i class="fa-solid fa-calendar"></i> Основан: {{ $club->founded }}
            </p>

            <p class="text-muted mb-0">
                <i class="fa-solid fa-user"></i> Владелец: 
                <a href="{{ route('users.clubs', $club->user->name) }}">
                    {{ $club->user->name }}
                </a>
            </p>
        </div>

        <div class="card-footer bg-white border-0 mt-auto">
            <div class="d-flex gap-2 justify-content-between align-items-stretch w-100 flex-wrap">
                <button 
                    class="btn btn-primary btn-sm flex-fill"
                    data-bs-toggle="modal" 
                    data-bs-target="#showClubModal{{ $club->id }}"
                >
                    Подробнее
                </button>

                @auth
                    @can('update-club', $club)
                        @if(!$club->trashed())
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
                        @endif
                    @endcan

                    @can('delete-club', $club)
                        @if(!$club->trashed())
                        <form action="{{ route('clubs.destroy',$club) }}" method="POST" class="flex-fill d-flex">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm flex-fill d-flex align-items-center justify-content-center" onclick="return confirm('Удалить?')">
                                Удалить
                            </button>
                        </form>
                        @endif
                    @endcan

                    @can('restore-club')
                        @if($club->trashed())
                        <form action="{{ route('clubs.restore', $club->id) }}" method="POST" class="flex-fill d-flex">
                            @csrf
                            <button class="btn btn-success btn-sm flex-fill">
                                <i class="fas fa-undo"></i> Восстановить
                            </button>
                        </form>
                        @endif
                    @endcan

                    @can('force-delete-club')
                        @if($club->trashed())
                        <form action="{{ route('clubs.force-destroy', $club->id) }}" method="POST" class="flex-fill d-flex">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm flex-fill" onclick="return confirm('Удалить навсегда? Это действие необратимо!')">
                                <i class="fas fa-trash"></i> Удалить навсегда
                            </button>
                        </form>
                        @endif
                    @endcan
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно Подробнее -->
<div class="modal fade zoom-modal" id="showClubModal{{ $club->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header">
        <h4 class="modal-title fw-bold">
          <i class="fa-solid fa-futbol text-primary me-2"></i>
          {{ $club->name }}
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 text-center mb-3">
            @if($club->image_path)
                <img src="{{ asset($club->image_path) }}" class="img-fluid rounded shadow" style="max-height: 200px; object-fit: contain;">
            @endif
          </div>

          <div class="col-md-8">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong><i class="fa-solid fa-flag text-primary me-2"></i>Страна:</strong> 
                {{ $club->country }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-calendar text-primary me-2"></i>Основан:</strong> 
                {{ $club->founded }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-user-tie text-primary me-2"></i>Президент:</strong> 
                {{ $club->president }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-stadium text-primary me-2"></i>Стадион:</strong> 
                {{ $club->stadium }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-users text-primary me-2"></i>Вместимость:</strong> 
                {{ $club->capacity ? $club->capacity . ' мест' : 'Не указана' }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-trophy text-primary me-2"></i>Трофеи:</strong> 
                {{ $club->trophies ?: 'Не указаны' }}
              </li>
              <li class="list-group-item">
                <strong><i class="fa-solid fa-user text-primary me-2"></i>Владелец:</strong> 
                <a href="{{ route('users.clubs', $club->user->name) }}">{{ $club->user->name }}</a>
              </li>
            </ul>
          </div>
        </div>

        @if($club->description)
        <div class="mt-3">
          <h6 class="fw-bold"><i class="fa-solid fa-file-lines text-primary me-2"></i>Описание</h6>
          <p class="text-muted">{{ $club->description }}</p>
        </div>
        @endif
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

@endforeach
</div>
@endsection

@auth
@include('clubs.edit-modal')
@include('clubs.create-modal')
@endauth
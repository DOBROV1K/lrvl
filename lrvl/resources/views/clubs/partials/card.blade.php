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

                <button class="btn btn-primary btn-sm flex-fill"
                        data-bs-toggle="modal"
                        data-bs-target="#showClubModal{{ $club->id }}">
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
                @endauth
            </div>
        </div>

    </div>
</div>

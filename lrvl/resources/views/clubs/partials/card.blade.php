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
                    <div class="d-flex gap-2 w-100">
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
                            <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                        onclick="return confirm('Вы уверены, что хотите удалить этот клуб?')">
                                    Удалить
                                </button>
                            </form>
                            @endif
                        @endcan
                    </div>
                @endauth
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="showClubModal{{ $club->id }}" tabindex="-1" aria-labelledby="showClubModalLabel{{ $club->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header">
        <h4 class="modal-title fw-bold" id="showClubModalLabel{{ $club->id }}">
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
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item"><strong>Страна:</strong> {{ $club->country }}</li>
              <li class="list-group-item"><strong>Основан:</strong> {{ $club->founded }}</li>
              <li class="list-group-item"><strong>Президент:</strong> {{ $club->president }}</li>
              <li class="list-group-item"><strong>Стадион:</strong> {{ $club->stadium }}</li>
              <li class="list-group-item"><strong>Вместимость:</strong> {{ $club->capacity }}</li>
              <li class="list-group-item"><strong>Трофеи:</strong> {{ $club->trophies }}</li>
              <li class="list-group-item"><strong>Владелец:</strong> {{ $club->user->name }}</li>
            </ul>
          </div>
        </div>

        @if($club->description)
        <div class="mt-3">
          <h6 class="fw-bold">Описание</h6>
          <p class="text-muted">{{ $club->description }}</p>
        </div>
        @endif

        <h5 class="mt-4"><i class="fa-solid fa-users me-2"></i> Игроки</h5>
        
        @auth
            @can('update-club', $club)
            <form action="{{ route('players.store', $club) }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Имя игрока" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="number" class="form-control form-control-sm" placeholder="Номер">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="position" class="form-control form-control-sm" placeholder="Позиция" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-sm w-100">Добавить</button>
                    </div>
                </div>
            </form>
            @endcan
        @endauth

        @if($club->players->isNotEmpty())
            <ul class="list-group mb-3">
                @foreach($club->players as $player)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            @if($player->number) <strong>#{{ $player->number }}</strong> @endif
                            {{ $player->name }} — {{ $player->position }}
                        </div>

                        @can('update-club', $club)
                            <form action="{{ route('players.destroy', $player) }}" method="POST" onsubmit="return confirm('Удалить игрока?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        @endcan
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">Игроков пока нет</p>
        @endif

        <hr>
        <h5><i class="fa-solid fa-comments me-2"></i> Комментарии</h5>

        @if($club->comments->isNotEmpty())
            <ul class="list-group mb-3">
                @foreach($club->comments as $comment)
                    @php $isFriend = auth()->check() && auth()->user()->isFriendWith($comment->user); @endphp
                    <li class="list-group-item @if($isFriend) border-success bg-light @endif">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                @if($isFriend) <span class="badge bg-success ms-2">Друг</span> @endif
                                <div class="small text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                                <div class="mt-2">{{ $comment->body }}</div>
                            </div>
                            @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Удалить</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">Комментариев пока нет</p>
        @endif

        @auth
            <form action="{{ route('comments.store', $club) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <textarea name="body" class="form-control" rows="3" placeholder="Оставьте комментарий..."></textarea>
                </div>
                <button class="btn btn-primary btn-sm">Комментировать</button>
            </form>
        @endauth

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>

    </div>
  </div>
</div>

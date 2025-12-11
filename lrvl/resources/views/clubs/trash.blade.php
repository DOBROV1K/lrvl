@extends('layouts.app')

@section('title', 'Корзина клубов')

@section('content')

<a href="{{ route('clubs.index') }}" class="btn btn-outline-primary mb-3">
    <i class="fa-solid fa-arrow-left"></i> Назад к списку
</a>

@if($clubs->isEmpty())
    <div class="alert alert-info">Корзина пуста</div>
@else
    <div class="row g-4">
        @foreach($clubs as $club)
            <div class="col-md-4">
                <div class="card shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $club->name }}</h5>
                        <p class="card-text text-muted">{{ $club->country }}</p>

                        <div class="d-flex gap-2">
                            <form action="{{ route('clubs.restore', $club->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Восстановить
                                </button>
                            </form>

                            <form action="{{ route('clubs.force-destroy', $club->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Удалить навсегда?')">
                                    Удалить навсегда
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

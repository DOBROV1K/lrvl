@extends('layouts.app')

@section('title','Лента друзей')

@section('content')
<h1 class="mb-4">Лента — новые клубы друзей</h1>

@if($clubs->isEmpty())
    <div class="alert alert-info">Новые клубы друзей отсутствуют</div>
@else
    <div class="row g-4">
        @foreach($clubs as $club)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $club->name }}</h5>
                        <p class="text-muted">от <strong>{{ $club->user->name }}</strong> — {{ $club->created_at->diffForHumans() }}</p>
                        <p>{{ Str::limit($club->description, 150) }}</p>
                        <a href="{{ route('clubs.show', $club) }}" class="btn btn-sm btn-primary">Открыть</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $clubs->links() }}</div>
@endif

@endsection

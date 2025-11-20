@extends('layouts.app')

@section('title', $club->name)

@section('content')
<h2>{{ $club->name }}</h2>

@include('clubs.partials.show', ['club'=>$club])

<a href="{{ route('clubs.index') }}" class="btn btn-secondary mt-3">Назад</a>
@endsection

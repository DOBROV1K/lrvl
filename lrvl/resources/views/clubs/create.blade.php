@extends('layouts.app')

@section('title','Добавить клуб')

@section('content')
<h2>Добавить клуб</h2>

<form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data">
    @include('clubs.form')
    <button class="btn btn-success mt-2">Создать</button>
</form>
@endsection

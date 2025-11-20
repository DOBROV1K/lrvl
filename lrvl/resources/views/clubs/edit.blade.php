@extends('layouts.app')

@section('title','Редактировать клуб')

@section('content')
<h2>Редактировать клуб</h2>

<form action="{{ route('clubs.update',$club) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('clubs.form')
    <button class="btn btn-primary mt-2">Сохранить</button>
</form>
@endsection

<div class="row">
  <div class="col-md-4">
    @if($club->image_path)
      <img src="{{ asset($club->image_path) }}" class="img-fluid rounded">
    @endif
  </div>
  <div class="col-md-8">
    <p><strong>Страна:</strong> {{ $club->country }}</p>
    <p><strong>Год основания:</strong> {{ $club->founded }}</p>
    <p><strong>Президент:</strong> {{ $club->president }}</p>
    <p><strong>Стадион:</strong> {{ $club->stadium }} ({{ $club->capacity }})</p>
    <p><strong>Трофеи:</strong> {{ $club->trophies }}</p>
    <hr>
    <p>{{ $club->description }}</p>
  </div>
</div>

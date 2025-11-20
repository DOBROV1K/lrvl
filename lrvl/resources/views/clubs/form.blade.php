@csrf
<div class="mb-3">
  <label>Название</label>
  <input type="text" name="name" class="form-control" required
         value="{{ old('name', $club->name ?? '') }}">
</div>

<div class="mb-3">
  <label>Страна</label>
  <input type="text" name="country" class="form-control"
         value="{{ old('country',$club->country ?? '') }}">
</div>

<div class="mb-3">
  <label>Год основания (YYYY)</label>
  <input type="text" name="founded" class="form-control" pattern="\d{4}"
         value="{{ old('founded',$club->founded ?? '') }}">
</div>

<div class="mb-3">
  <label>Президент</label>
  <input type="text" name="president" class="form-control"
         value="{{ old('president',$club->president ?? '') }}">
</div>

<div class="mb-3">
  <label>Стадион</label>
  <input type="text" name="stadium" class="form-control"
         value="{{ old('stadium',$club->stadium ?? '') }}">
</div>

<div class="mb-3">
  <label>Вместимость</label>
  <input type="text" name="capacity" class="form-control"
         value="{{ old('capacity',$club->capacity ?? '') }}">
</div>

<div class="mb-3">
  <label>Трофеи</label>
  <textarea name="trophies" class="form-control">{{ old('trophies',$club->trophies ?? '') }}</textarea>
</div>

<div class="mb-3">
  <label>Описание</label>
  <textarea name="description" class="form-control">{{ old('description',$club->description ?? '') }}</textarea>
</div>

<div class="mb-3">
  <label>Картинка</label>
  <input type="file" name="image" class="form-control" accept="image/*">
</div>

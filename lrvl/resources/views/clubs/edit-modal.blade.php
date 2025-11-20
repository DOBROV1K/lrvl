<div class="modal fade zoom-modal" id="editClubModal" tabindex="-1" aria-labelledby="editClubModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">

      <div class="modal-header">
        <h4 class="modal-title fw-bold" id="editClubModalLabel">Редактировать клуб</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="editClubForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Название</label>
              <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Страна</label>
              <input type="text" name="country" id="edit-country" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Основан</label>
              <input type="number" name="founded" id="edit-founded" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Президент</label>
              <input type="text" name="president" id="edit-president" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Стадион</label>
              <input type="text" name="stadium" id="edit-stadium" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Вместимость</label>
              <input type="text" name="capacity" id="edit-capacity" class="form-control">
            </div>

            <div class="col-12">
              <label class="form-label">Трофеи</label>
              <input type="text" name="trophies" id="edit-trophies" class="form-control">
            </div>

            <div class="col-12">
              <label class="form-label">Описание</label>
              <textarea name="description" id="edit-description" rows="4" class="form-control"></textarea>
            </div>

            <div class="col-12">
              <label class="form-label">Изображение клуба</label>
              <input type="file" name="image" class="form-control">
              <img id="edit-preview" class="img-fluid rounded mt-2" style="max-height:140px;">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
          <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </div>
      </form>

    </div>
  </div>
</div>

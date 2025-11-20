<div class="modal fade zoom-modal" id="createClubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content p-3">

            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fa-solid fa-plus text-primary"></i> Добавить клуб
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Страна</label>
                            <input type="text" name="country" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Год основания</label>
                            <input type="number" name="founded" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Президент</label>
                            <input type="text" name="president" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Стадион</label>
                            <input type="text" name="stadium" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Вместимость (число)</label>
                            <input type="number" name="capacity" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Трофеи</label>
                            <textarea name="trophies" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Загрузить изображение</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Сохранить
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>

            </form>
        </div>
    </div>
</div>

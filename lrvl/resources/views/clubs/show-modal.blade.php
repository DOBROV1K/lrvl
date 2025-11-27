<div class="modal fade zoom-modal" id="showClubModal" tabindex="-1" aria-labelledby="showClubModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">

      <div class="modal-header">
        <h4 class="modal-title fw-bold" id="showClubModalLabel">
          <i class="fa-solid fa-futbol text-primary me-2"></i>
          Детали клуба
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 text-center mb-3">
            <img id="show-image" class="img-fluid rounded shadow" style="max-height: 200px; object-fit: contain;" src="" alt="">
          </div>

          <div class="col-md-8">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong><i class="fa-solid fa-flag text-primary me-2"></i>Название:</strong> 
                <span id="show-name"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-globe text-primary me-2"></i>Страна:</strong> 
                <span id="show-country"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-calendar text-primary me-2"></i>Основан:</strong> 
                <span id="show-founded"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-user-tie text-primary me-2"></i>Президент:</strong> 
                <span id="show-president"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-stadium text-primary me-2"></i>Стадион:</strong> 
                <span id="show-stadium"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-users text-primary me-2"></i>Вместимость:</strong> 
                <span id="show-capacity"></span>
              </li>

              <li class="list-group-item">
                <strong><i class="fa-solid fa-trophy text-primary me-2"></i>Трофеи:</strong> 
                <span id="show-trophies"></span>
              </li>
            </ul>
          </div>
        </div>

        <div class="mt-3">
          <h6 class="fw-bold"><i class="fa-solid fa-file-lines text-primary me-2"></i>Описание</h6>
          <p id="show-description" class="text-muted"></p>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>

    </div>
  </div>
</div>
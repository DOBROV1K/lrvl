class CustomToasts {
    constructor() {
        this.toastElement = document.getElementById('liveToast');
        this.toastMessage = document.getElementById('toastMessage');
        this.toast = null;
        this.init();
    }

    init() {
        if (this.toastElement && window.bootstrap) {
            this.toast = new window.bootstrap.Toast(this.toastElement, {
                autohide: true,
                delay: 4000
            });
        }
    }

    showLoadingToast() {
        if (!this.toast) {
            this.init(); 
        }
        
        if (!this.toast) return;

        this.toastMessage.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-spinner fa-spin-custom text-primary me-2"></i>
                <span>Функционал загрузки временно недоступен. Пожалуйста, попробуйте позже.</span>
            </div>
        `;
        
        this.toast.show();
    }
}

window.showToast = function() {
    const toastManager = new CustomToasts();
    toastManager.showLoadingToast();
};


document.addEventListener('DOMContentLoaded', function() {
    new CustomToasts();
});
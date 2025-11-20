import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import $ from 'jquery';
import '@fortawesome/fontawesome-free/js/all';
import '../sass/styles.scss';

console.log('app.js loaded');


// ------- Инициализация Bootstrap Popover -------
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
        new bootstrap.Popover(el);
    });
});

// ------- Плавная прокрутка по якорям -------
function initSmoothScroll() {
    document.querySelectorAll('.navbar-nav .nav-link[href^="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const id = this.getAttribute('href').substring(1);
            const target = document.getElementById(id);

            if (target) {
                e.preventDefault();

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                setActiveNavLink(this);
                closeMobileMenu();
            }
        });
    });
}

function setActiveNavLink(activeLink) {
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.classList.remove('active');
    });
    activeLink.classList.add('active');
}

// ------- Закрытие мобильного меню -------
function closeMobileMenu() {
    const toggler = document.querySelector('.navbar-toggler');
    const navbar = document.querySelector('.navbar-collapse');

    if (toggler && !toggler.classList.contains('collapsed')) {
        const collapse = new bootstrap.Collapse(navbar, {
            toggle: false
        });
        collapse.hide();
    }
}

// ------- ScrollSpy -------
function initScrollSpy() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
    const sections = document.querySelectorAll('section[id], main[id]');

    window.addEventListener('scroll', () => {
        let current = '';

        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= 150 && rect.bottom >= 150) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href').substring(1);
            if (href === current) link.classList.add('active');
        });
    });
}

// ------- Toasts (если есть toasts.js) -------
try {
    require('./toasts.js');
} catch (e) {
    console.warn("toasts.js not found — skipping.");
}

// ------- Запуск функционала -------
document.addEventListener('DOMContentLoaded', () => {
    initSmoothScroll();
    initScrollSpy();
});
// --- Modal info load ---
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('open-modal-btn')) {
        const btn = e.target;

        const modalBody = document.getElementById('modalContent');
        const modalTitle = document.getElementById('clubModalLabel');

        modalTitle.textContent = btn.dataset.name;

        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <img src="${btn.dataset.image}" class="img-fluid rounded" alt="${btn.dataset.name}">
                </div>
                <div class="col-md-8">
                    <p><strong>Страна:</strong> ${btn.dataset.country}</p>
                    <p><strong>Основан:</strong> ${btn.dataset.founded}</p>
                    <p><strong>Президент:</strong> ${btn.dataset.president}</p>
                    <p><strong>Стадион:</strong> ${btn.dataset.stadium}</p>
                    <p><strong>Вместимость:</strong> ${btn.dataset.capacity}</p>
                    <p><strong>Трофеи:</strong> ${btn.dataset.trophies}</p>
                    <p class="mt-3">${btn.dataset.description}</p>
                </div>
            </div>
        `;

        const modalEl = document.getElementById('clubModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
});
// ===== OPEN EDIT MODAL =====
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('edit-modal-btn')) {

    const b = e.target;

    document.getElementById("edit-name").value = b.dataset.name;
    document.getElementById("edit-country").value = b.dataset.country;
    document.getElementById("edit-founded").value = b.dataset.founded;
    document.getElementById("edit-president").value = b.dataset.president;
    document.getElementById("edit-stadium").value = b.dataset.stadium;
    document.getElementById("edit-capacity").value = b.dataset.capacity;
    document.getElementById("edit-trophies").value = b.dataset.trophies;
    document.getElementById("edit-description").value = b.dataset.description;

    const preview = document.getElementById("edit-preview");
    preview.src = b.dataset.image;

    // Inject form action dynamically
    const form = document.getElementById("editClubForm");
    form.action = `/clubs/${b.dataset.id}`;

    const modalEl = document.getElementById('editClubModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
});

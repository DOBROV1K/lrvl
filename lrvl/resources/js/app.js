import './bootstrap';

import Alpine from 'alpinejs';

document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".edit-modal-btn");

    editButtons.forEach(button => {
        button.addEventListener("click", () => {

            document.getElementById("edit-name").value = button.dataset.name;
            document.getElementById("edit-country").value = button.dataset.country;
            document.getElementById("edit-founded").value = button.dataset.founded;
            document.getElementById("edit-president").value = button.dataset.president;
            document.getElementById("edit-stadium").value = button.dataset.stadium;
            document.getElementById("edit-capacity").value = button.dataset.capacity;
            document.getElementById("edit-trophies").value = button.dataset.trophies;
            document.getElementById("edit-description").value = button.dataset.description;

            if (button.dataset.image) {
                document.getElementById("edit-preview").src = button.dataset.image;
            }

            const form = document.getElementById("editClubForm");
            form.action = "/clubs/" + button.dataset.id;

            const modal = new bootstrap.Modal(document.getElementById("editClubModal"));
            modal.show();
        });
    });
});


window.Alpine = Alpine;

Alpine.start();


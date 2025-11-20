class ModalNavigation {
    constructor() {
        this.clubsData = window.clubsData || [];
        this.currentIndex = 0;
        this.init();
    }

    init() {
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('clubModal');
            if (modal && modal.classList.contains('show')) {
                this.handleKeyPress(e);
            }
        });
    }

    handleKeyPress(e) {
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                this.previousClub();
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.nextClub();
                break;
        }
    }

    getCurrentIndex() {
        if (window.currentModalClubId) {
            return this.clubsData.findIndex(club => club.id === window.currentModalClubId);
        }
        return this.currentIndex;
    }

    previousClub() {
        const currentIndex = this.getCurrentIndex();
        const previousIndex = (currentIndex - 1 + this.clubsData.length) % this.clubsData.length;
        this.showClub(previousIndex);
    }

    nextClub() {
        const currentIndex = this.getCurrentIndex();
        const nextIndex = (currentIndex + 1) % this.clubsData.length;
        this.showClub(nextIndex);
    }

    showClub(index) {
        const club = this.clubsData[index];
        if (club && window.openModal) {
            window.openModal(club.id);
            this.currentIndex = index;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new ModalNavigation();
});
/* Šis skripts nodrošina "progress" publiskās saskarnes interaktivitāti. */

document.addEventListener("DOMContentLoaded", function () {
    const photoInput = document.getElementById('photo');
    const fileNameDisplay = document.getElementById('file-name-display');

    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebar');
    const hasSidebar = Boolean(mobileToggle && sidebar);

    photoInput?.addEventListener('change', function () {
        if (this.files.length > 0 && fileNameDisplay) {
            fileNameDisplay.textContent = this.files[0].name;
        }
    });

    if (hasSidebar) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = sidebar.classList.toggle('active');
            mobileToggle.setAttribute('aria-expanded', String(isOpen));
        });

        document.addEventListener('click', e => {
            if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('active');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxDesc = document.getElementById('lightbox-desc');
    const lightboxDate = document.getElementById('lightbox-date');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-nav.prev');
    const nextBtn = document.querySelector('.lightbox-nav.next');
    const photos = document.querySelectorAll('.photo-item');
    const hasLightbox = Boolean(lightbox && lightboxImg && lightboxDesc && lightboxDate && closeBtn && prevBtn && nextBtn);
    let currentIdx = -1;

    const openLightbox = idx => {
        if (!hasLightbox || idx < 0 || idx >= photos.length) return;
        currentIdx = idx;
        const photo = photos[idx];
        lightboxImg.src = photo.dataset.img;
        lightboxDesc.textContent = photo.dataset.desc || 'No description';
        lightboxDate.textContent = photo.dataset.date || '';
        lightbox.setAttribute('aria-hidden', 'false');
    };

    const closeLightbox = () => {
        if (!hasLightbox) return;
        lightbox.setAttribute('aria-hidden', 'true');
        currentIdx = -1;
    };

    if (hasLightbox) {
        photos.forEach((photo, idx) => {
            const img = photo.querySelector('.photo-img');
            if (!img) return;

            img.tabIndex = 0;
            img.setAttribute('role', 'button');

            img.addEventListener('click', () => openLightbox(idx));
            img.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openLightbox(idx);
                }
            });
        });

        closeBtn.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', e => {
            if (e.target === lightbox) closeLightbox();
        });

        prevBtn.addEventListener('click', () => openLightbox((currentIdx - 1 + photos.length) % photos.length));
        nextBtn.addEventListener('click', () => openLightbox((currentIdx + 1) % photos.length));
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            if (hasSidebar) {
                sidebar.classList.remove('active');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }

            closeLightbox();
            return;
        }

        if (!hasLightbox || lightbox.getAttribute('aria-hidden') !== 'false') {
            return;
        }

        if (e.key === 'ArrowLeft') {
            prevBtn.click();
        }

        if (e.key === 'ArrowRight') {
            nextBtn.click();
        }
    });
});

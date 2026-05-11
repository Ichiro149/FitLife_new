/* Šis skripts nodrošina "welcome" publiskās saskarnes interaktivitāti. */

document.addEventListener('DOMContentLoaded', () => {
    const welcomeHeader = document.getElementById('welcomeHeader');
    const welcomeNav = document.getElementById('welcomeNav');
    const welcomeMenuToggle = document.getElementById('welcomeMenuToggle');
    const welcomeMobilePanel = document.getElementById('welcomeMobilePanel');
    const welcomeMobileBackdrop = document.getElementById('welcomeMobileBackdrop');
    const welcomeSectionLinks = document.querySelectorAll('a[href^="#"]');

    const setMenuOpen = (isOpen) => {
        if (welcomeMenuToggle) {
            welcomeMenuToggle.classList.toggle('is-open', isOpen);
            welcomeMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        if (welcomeMobilePanel) {
            welcomeMobilePanel.hidden = !isOpen;
            welcomeMobilePanel.classList.toggle('is-open', isOpen);
            welcomeMobilePanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        }

        if (welcomeMobileBackdrop) {
            welcomeMobileBackdrop.hidden = !isOpen;
            welcomeMobileBackdrop.classList.toggle('is-visible', isOpen);
        }

        if (welcomeNav && window.innerWidth <= 900) {
            welcomeNav.classList.toggle('is-open', isOpen);
        }

        document.body.classList.toggle('welcome-menu-open', isOpen);
    };

    setMenuOpen(false);

    const stripWelcomeHash = () => {
        if (!window.location.hash) {
            return;
        }

        const cleanUrl = window.location.pathname + window.location.search;
        window.history.replaceState(null, '', cleanUrl);
    };

    welcomeMenuToggle?.addEventListener('click', () => {
        const isOpen = !welcomeMenuToggle.classList.contains('is-open');
        setMenuOpen(isOpen);
    });

    welcomeMobileBackdrop?.addEventListener('click', () => {
        setMenuOpen(false);
    });

    welcomeSectionLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const targetId = link.getAttribute('href');

            if (!targetId || targetId === '#') {
                return;
            }

            const target = document.querySelector(targetId);

            if (!target) {
                return;
            }

            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });

            setMenuOpen(false);

            stripWelcomeHash();
        });
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) {
            setMenuOpen(false);
        }
    });

    window.addEventListener('load', () => {
        if (!window.location.hash) {
            return;
        }

        window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
        stripWelcomeHash();
    });

    window.addEventListener('scroll', () => {
        if (!welcomeHeader) {
            return;
        }

        welcomeHeader.classList.toggle('is-scrolled', window.scrollY > 24);
    });
});
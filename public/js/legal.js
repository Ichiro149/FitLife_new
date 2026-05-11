/* Šis skripts nodrošina "legal" publiskās saskarnes interaktivitāti. */

document.addEventListener('DOMContentLoaded', () => {
    const mobileMenu = document.getElementById('mobileMenu');
    const navLinks = document.getElementById('navLinks');
    const nav = document.getElementById('legalNav');

    const setMenuOpen = (isOpen) => {
        navLinks?.classList.toggle('is-open', isOpen);
        mobileMenu?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        mobileMenu?.classList.toggle('is-open', isOpen);
    };

    mobileMenu?.addEventListener('click', () => {
        setMenuOpen(!navLinks?.classList.contains('is-open'));
    });

    navLinks?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    const syncScrolledState = () => {
        nav?.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    window.addEventListener('scroll', syncScrolledState, { passive: true });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) {
            setMenuOpen(false);
        }
    });

    syncScrolledState();
});
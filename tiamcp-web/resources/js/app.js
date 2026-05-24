import './bootstrap';

const mobileButton = document.querySelector('[data-mobile-menu-button]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

if (mobileButton instanceof HTMLButtonElement && mobileMenu instanceof HTMLElement) {
    mobileButton.addEventListener('click', () => {
        const expanded = mobileButton.getAttribute('aria-expanded') === 'true';
        mobileButton.setAttribute('aria-expanded', String(!expanded));
        mobileMenu.classList.toggle('hidden', expanded);
    });
}

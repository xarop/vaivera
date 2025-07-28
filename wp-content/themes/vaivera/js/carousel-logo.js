/**
 * Homepage Carousel Logo Position Handler
 * Switches the V logo from absolute to fixed position during scroll
 */
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.homepage-carousel');

    if (!carousel) return;

    let isFixed = false;

    function updateLogoPosition() {
        const carouselRect = carousel.getBoundingClientRect();
        const carouselHeight = carousel.offsetHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Calculate if the bottom (::after) would be above the top (::before)
        // This happens when we've scrolled past about 60% of the carousel height
        const switchPoint = carouselHeight * 0.6;
        const shouldBeFixed = scrollTop > switchPoint;

        if (shouldBeFixed && !isFixed) {
            // Switch to fixed positioning
            carousel.classList.add('logo-fixed');
            isFixed = true;
        } else if (!shouldBeFixed && isFixed) {
            // Switch back to absolute positioning
            carousel.classList.remove('logo-fixed');
            isFixed = false;
        }
    }

    // Listen for scroll events
    window.addEventListener('scroll', updateLogoPosition);

    // Initial check
    updateLogoPosition();
});

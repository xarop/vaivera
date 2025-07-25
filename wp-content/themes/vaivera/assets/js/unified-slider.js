/**
 * Unified Slider/Carousel Script
 * 
 * Handles both homepage carousel and project gallery functionality
 */

(function ($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function () {
        initHomepageCarousel();
        initProjectGallery();
    });

    /**
     * Homepage Carousel Functionality
     */
    function initHomepageCarousel() {
        const carousel = document.querySelector('.homepage-carousel');
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.carousel-slide');
        const indicators = carousel.querySelectorAll('.carousel-indicator');
        const prevBtn = carousel.querySelector('.carousel-prev');
        const nextBtn = carousel.querySelector('.carousel-next');

        let currentSlide = 0;
        let autoplayInterval;

        // Show specific slide
        function showSlide(index) {
            // Remove active class from all slides and indicators
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            // Add active class to current slide and indicator
            if (slides[index]) {
                slides[index].classList.add('active');
            }
            if (indicators[index]) {
                indicators[index].classList.add('active');
            }

            currentSlide = index;
        }

        // Next slide
        function nextSlide() {
            const next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        // Previous slide
        function prevSlide() {
            const prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        // Start autoplay
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        // Stop autoplay
        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
            }
        }

        // Event listeners
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        }

        // Indicator clicks
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                showSlide(index);
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        });

        // Pause autoplay on hover
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
                stopAutoplay();
                startAutoplay();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
                stopAutoplay();
                startAutoplay();
            }
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    nextSlide();
                } else {
                    // Swipe right - previous slide
                    prevSlide();
                }
                stopAutoplay();
                startAutoplay();
            }
        }

        // Start autoplay when page loads
        if (slides.length > 1) {
            startAutoplay();
        }
    }

    /**
     * Project Gallery Functionality
     */
    function initProjectGallery() {
        // Variables
        var modal = $('#galleryModal');
        var slides = $('.slide');
        var currentSlide = 0;

        // Initialize - make sure slides are properly set up
        function initializeSlider() {
            slides = $('.slide'); // Refresh slides collection
            slides.hide(); // Hide all slides first
        }

        // Open modal and show clicked image
        $('.gallery-link').on('click', function (e) {
            e.preventDefault();

            initializeSlider();
            currentSlide = parseInt($(this).data('index'));
            showSlide(currentSlide);
            modal.fadeIn();

            // Disable body scroll
            $('body').css('overflow', 'hidden');
        });

        // Close modal
        $('.close-modal').on('click', function () {
            modal.fadeOut();

            // Enable body scroll
            $('body').css('overflow', '');
        });

        // Close modal when clicking outside content
        $(modal).on('click', function (e) {
            if (e.target === modal[0]) {
                modal.fadeOut();
                $('body').css('overflow', '');
            }
        });

        // Navigate slides
        $('.slider-nav.prev').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        $('.slider-nav.next').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });

        // Keyboard navigation
        $(document).on('keydown', function (e) {
            if (!modal.is(':visible')) return;

            if (e.key === 'Escape') {
                modal.fadeOut();
                $('body').css('overflow', '');
            } else if (e.key === 'ArrowLeft') {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            } else if (e.key === 'ArrowRight') {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }
        });

        // Show slide
        function showSlide(index) {
            slides.removeClass('active').hide();
            $(slides[index]).addClass('active').show();
        }

        // Swipe support for touch devices
        var touchStartX = 0;
        var touchEndX = 0;

        $('.slider').on('touchstart', function (e) {
            touchStartX = e.originalEvent.touches[0].clientX;
        });

        $('.slider').on('touchend', function (e) {
            touchEndX = e.originalEvent.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchStartX - touchEndX > 50) {
                // Swipe left
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            } else if (touchEndX - touchStartX > 50) {
                // Swipe right
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }
        }
    }

})(jQuery);
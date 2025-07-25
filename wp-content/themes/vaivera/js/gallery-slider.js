/**
 * Gallery Slider Script
 * 
 * Handles the full-width image slider functionality for project galleries
 */

(function ($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function () {
        initGallerySlider();
    });

    function initGallerySlider() {
        // Variables
        var modal = $('#galleryModal');
        var slides = $('.carousel-slide');
        var currentSlide = 0;

        // Initialize - make sure slides are properly set up
        function initializeSlider() {
            slides = $('.gallery-modal .carousel-slide'); // Refresh slides collection in modal
            slides.removeClass('active'); // Remove active class from all slides
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
        $('.gallery-modal .carousel-prev').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        $('.gallery-modal .carousel-next').on('click', function (e) {
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
            slides.removeClass('active');
            $(slides[index]).addClass('active');
        }

        // Swipe support for touch devices
        var touchStartX = 0;
        var touchEndX = 0;

        $('.gallery-modal .carousel-slides').on('touchstart', function (e) {
            touchStartX = e.originalEvent.touches[0].clientX;
        });

        $('.gallery-modal .carousel-slides').on('touchend', function (e) {
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
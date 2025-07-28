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

    // Also initialize on window load as backup
    $(window).on('load', function () {
        // Re-check gallery links after page fully loads
        setTimeout(function () {
            console.log('Window loaded - Gallery links found:', $('.gallery-link').length);
            console.log('Gallery modal found:', $('#galleryModal').length);
        }, 100);
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

        // Auto-play functionality
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        // Initialize carousel
        if (slides.length > 0) {
            showSlide(0);

            // Only start autoplay if there are multiple slides
            if (slides.length > 1) {
                startAutoplay();
            }
        }

        // Navigation buttons
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoplay();
                prevSlide();
                startAutoplay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoplay();
                nextSlide();
                startAutoplay();
            });
        }

        // Indicator buttons
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                stopAutoplay();
                showSlide(index);
                startAutoplay();
            });
        });

        // Pause on hover
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', () => {
            if (slides.length > 1) {
                startAutoplay();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (carousel.matches(':hover')) {
                if (e.key === 'ArrowLeft') {
                    stopAutoplay();
                    prevSlide();
                    startAutoplay();
                } else if (e.key === 'ArrowRight') {
                    stopAutoplay();
                    nextSlide();
                    startAutoplay();
                }
            }
        });

        // Touch/swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                stopAutoplay();
                if (diff > 0) {
                    nextSlide(); // Swipe left
                } else {
                    prevSlide(); // Swipe right
                }
                startAutoplay();
            }
        }
    }

    /**
     * Project Gallery Functionality
     */
    function initProjectGallery() {
        // Variables
        var modal = $('#galleryModal');
        var slides = $('.gallery-modal .carousel-slide');
        var currentSlide = 0;

        // Debug: Check initial state
        console.log('initProjectGallery called');
        console.log('Modal found:', modal.length);
        console.log('Gallery links found:', $('.gallery-link').length);

        // Initialize - refresh slides collection
        function initializeSlider() {
            slides = $('.gallery-modal .carousel-slide');
            slides.removeClass('active');
        }

        // Open modal and show clicked image (using event delegation)
        $(document).on('click', '.gallery-link', function (e) {
            e.preventDefault();

            console.log('Gallery link clicked'); // Debug log

            currentSlide = parseInt($(this).data('index'));

            // Debug: Check if modal exists
            console.log('Modal element found:', modal.length);

            // Show modal first
            modal.fadeIn();

            // Wait a moment for modal content to be ready, then initialize
            setTimeout(function () {
                slides = $('.gallery-modal .carousel-slide'); // Refresh slides collection in modal
                slides.removeClass('active'); // Remove active class from all slides

                // Debug: log the number of slides found
                console.log('Gallery modal slides found:', slides.length);
                console.log('Current slide index:', currentSlide);

                if (slides.length > 0) {
                    showSlide(currentSlide);
                } else {
                    console.error('No carousel slides found in gallery modal');
                }
            }, 150);

            // Disable body scroll
            $('body').css('overflow', 'hidden');
        });

        // Close modal (using event delegation)
        $(document).on('click', '.close-modal', function () {
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

            // Refresh slides in case they weren't found initially
            slides = $('.gallery-modal .carousel-slide');
            if (slides.length > 0) {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }
        });

        $('.gallery-modal .carousel-next').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Refresh slides in case they weren't found initially
            slides = $('.gallery-modal .carousel-slide');
            if (slides.length > 0) {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }
        });

        // Keyboard navigation
        $(document).on('keydown', function (e) {
            if (!modal.is(':visible')) return;

            if (e.key === 'Escape') {
                modal.fadeOut();
                $('body').css('overflow', '');
            } else if (e.key === 'ArrowLeft') {
                slides = $('.gallery-modal .carousel-slide');
                if (slides.length > 0) {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(currentSlide);
                }
            } else if (e.key === 'ArrowRight') {
                slides = $('.gallery-modal .carousel-slide');
                if (slides.length > 0) {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }
            }
        });

        // Show slide
        function showSlide(index) {
            console.log('showSlide called with index:', index);
            console.log('Total slides:', slides.length);

            slides.removeClass('active');
            if (slides[index]) {
                $(slides[index]).addClass('active');
                console.log('Activated slide:', index);
            } else {
                console.error('Slide not found at index:', index);
            }
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
                slides = $('.gallery-modal .carousel-slide');
                if (slides.length > 0) {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }
            } else if (touchEndX - touchStartX > 50) {
                // Swipe right
                slides = $('.gallery-modal .carousel-slide');
                if (slides.length > 0) {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(currentSlide);
                }
            }
        }
    }

})(jQuery);

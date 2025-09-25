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
            autoplayInterval = setInterval(nextSlide, 10000); // Change slide every 8 seconds
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
        const modal = document.getElementById('galleryModal');
        if (!modal) return;

        let currentSlide = 0;
        let slides = [];

        // Initialize modal carousel
        function initModalCarousel() {
            const carousel = modal.querySelector('.carousel-container');
            if (!carousel) return;

            slides = carousel.querySelectorAll('.carousel-slide');
            const prevBtn = carousel.querySelector('.carousel-prev');
            const nextBtn = carousel.querySelector('.carousel-next');

            // Show specific slide
            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                if (slides[index]) {
                    slides[index].classList.add('active');
                }
                currentSlide = index;
            }

            // Navigation
            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const prev = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(prev);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const next = (currentSlide + 1) % slides.length;
                    showSlide(next);
                });
            }

            // Keyboard navigation
            function handleKeydown(e) {
                if (!modal.style.display || modal.style.display === 'none') return;

                if (e.key === 'Escape') {
                    closeModal();
                } else if (e.key === 'ArrowLeft') {
                    const prev = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(prev);
                } else if (e.key === 'ArrowRight') {
                    const next = (currentSlide + 1) % slides.length;
                    showSlide(next);
                }
            }

            document.addEventListener('keydown', handleKeydown);

            // Touch/swipe support
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].clientX;
                const diff = touchStartX - touchEndX;
                const swipeThreshold = 50;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        const next = (currentSlide + 1) % slides.length;
                        showSlide(next);
                    } else {
                        // Swipe right - previous slide
                        const prev = (currentSlide - 1 + slides.length) % slides.length;
                        showSlide(prev);
                    }
                }
            });

            return { showSlide };
        }

        // Open modal
        function openModal(slideIndex = 0) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                const modalCarousel = initModalCarousel();
                if (modalCarousel && slides.length > 0) {
                    modalCarousel.showSlide(slideIndex);
                }
            }, 100);
        }

        // Close modal
        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        // Event delegation for gallery links
        document.addEventListener('click', (e) => {
            if (e.target.matches('.gallery-link') || e.target.closest('.gallery-link')) {
                e.preventDefault();
                const link = e.target.matches('.gallery-link') ? e.target : e.target.closest('.gallery-link');
                const slideIndex = parseInt(link.dataset.index) || 0;
                openModal(slideIndex);
            }
        });

        // Close modal events
        const closeBtn = modal.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

})(jQuery);

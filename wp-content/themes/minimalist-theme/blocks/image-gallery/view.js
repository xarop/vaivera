/**
 * Minimalist Image Gallery Lightbox Functionality
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('Minimalist Gallery: Initializing lightbox functionality');

    // Create lightbox HTML structure
    function createLightbox() {
        const lightbox = document.createElement('div');
        lightbox.className = 'minimalist-lightbox';
        lightbox.innerHTML = `
            <div class="lightbox-content">
                <button class="lightbox-close" aria-label="Close lightbox">×</button>
                <button class="lightbox-nav lightbox-prev" aria-label="Previous image">‹</button>
                <button class="lightbox-nav lightbox-next" aria-label="Next image">›</button>
                <div class="lightbox-image-container">
                    <div class="lightbox-loading"></div>
                    <img class="lightbox-image" alt="" />
                </div>
                <div class="lightbox-caption"></div>
                <div class="lightbox-counter"></div>
            </div>
        `;
        document.body.appendChild(lightbox);
        return lightbox;
    }

    // Initialize lightbox
    const lightbox = createLightbox();
    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const lightboxCaption = lightbox.querySelector('.lightbox-caption');
    const lightboxCounter = lightbox.querySelector('.lightbox-counter');
    const lightboxLoading = lightbox.querySelector('.lightbox-loading');
    const closeBtn = lightbox.querySelector('.lightbox-close');
    const prevBtn = lightbox.querySelector('.lightbox-prev');
    const nextBtn = lightbox.querySelector('.lightbox-next');

    let currentGallery = [];
    let currentIndex = 0;
    let isOpen = false;

    // Open lightbox
    function openLightbox(gallery, index) {
        console.log('Opening lightbox for image', index, 'of', gallery.length);
        currentGallery = gallery;
        currentIndex = index;
        isOpen = true;

        // Show lightbox
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Load image
        loadImage(currentIndex);

        // Update navigation visibility
        updateNavigation();
    }

    // Close lightbox
    function closeLightbox() {
        console.log('Closing lightbox');
        isOpen = false;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';

        // Reset image
        lightboxImage.src = '';
        lightboxCaption.textContent = '';
        lightboxCounter.textContent = '';
    }

    // Load image
    function loadImage(index) {
        if (!currentGallery[index]) return;

        const imageData = currentGallery[index];

        // Show loading
        lightboxLoading.style.display = 'block';
        lightboxImage.style.opacity = '0';

        // Create new image to preload
        const img = new Image();

        img.onload = function () {
            lightboxImage.src = imageData.fullUrl;
            lightboxImage.alt = imageData.alt || '';
            lightboxCaption.textContent = imageData.caption || '';
            lightboxCounter.textContent = `${index + 1} / ${currentGallery.length}`;

            // Hide loading and show image
            lightboxLoading.style.display = 'none';
            lightboxImage.style.opacity = '1';
        };

        img.onerror = function () {
            console.error('Failed to load image:', imageData.fullUrl);
            lightboxLoading.style.display = 'none';
            lightboxImage.style.opacity = '1';
        };

        img.src = imageData.fullUrl;
    }

    // Navigate to previous image
    function prevImage() {
        if (currentIndex > 0) {
            currentIndex--;
            loadImage(currentIndex);
            updateNavigation();
        }
    }

    // Navigate to next image
    function nextImage() {
        if (currentIndex < currentGallery.length - 1) {
            currentIndex++;
            loadImage(currentIndex);
            updateNavigation();
        }
    }

    // Update navigation button visibility
    function updateNavigation() {
        prevBtn.style.display = currentIndex > 0 ? 'flex' : 'none';
        nextBtn.style.display = currentIndex < currentGallery.length - 1 ? 'flex' : 'none';
    }

    // Event listeners
    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', prevImage);
    nextBtn.addEventListener('click', nextImage);

    // Close on background click
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (!isOpen) return;

        switch (e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    });

    // Initialize galleries
    function initializeGalleries() {
        const galleries = document.querySelectorAll('.wp-block-minimalist-image-gallery .gallery-grid');

        galleries.forEach(gallery => {
            const items = gallery.querySelectorAll('.gallery-item');

            // Create gallery data array
            const galleryData = Array.from(items).map(item => {
                const img = item.querySelector('img');
                const caption = item.querySelector('.gallery-caption');

                return {
                    fullUrl: img.getAttribute('data-full') || img.src,
                    alt: img.alt,
                    caption: caption ? caption.textContent : ''
                };
            });

            // Add click listeners to gallery items
            items.forEach((item, index) => {
                // Make items focusable
                item.setAttribute('tabindex', '0');
                item.setAttribute('role', 'button');
                item.setAttribute('aria-label', `Open image ${index + 1} in lightbox`);

                // Click handler
                const clickHandler = function (e) {
                    e.preventDefault();
                    openLightbox(galleryData, index);
                };

                item.addEventListener('click', clickHandler);

                // Keyboard handler
                item.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        clickHandler(e);
                    }
                });
            });

            console.log('Initialized gallery with', galleryData.length, 'images');
        });
    }

    // Initialize all galleries
    initializeGalleries();

    // Reinitialize galleries when new content is loaded (for dynamic content)
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.addedNodes.length) {
                const addedGalleries = Array.from(mutation.addedNodes)
                    .filter(node => node.nodeType === 1)
                    .flatMap(node => [
                        ...node.querySelectorAll('.wp-block-minimalist-image-gallery'),
                        ...(node.classList && node.classList.contains('wp-block-minimalist-image-gallery') ? [node] : [])
                    ]);

                if (addedGalleries.length > 0) {
                    console.log('New galleries detected, reinitializing...');
                    setTimeout(initializeGalleries, 100);
                }
            }
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    lightbox.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next image
                nextImage();
            } else {
                // Swipe right - previous image
                prevImage();
            }
        }
    }

    console.log('Minimalist Gallery: Lightbox functionality initialized');
});
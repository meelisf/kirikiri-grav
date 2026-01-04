document.addEventListener('DOMContentLoaded', function () {
    console.log('Lightbox script loaded');

    // Select all images within the article content
    const contentImages = document.querySelectorAll('.article-content img');
    console.log('Found images for lightbox:', contentImages.length);

    // Create the lightbox overlay element
    const lightboxOverlay = document.createElement('div');
    lightboxOverlay.id = 'lightbox-overlay';
    lightboxOverlay.className = 'lightbox-overlay';

    // Create the image container
    const lightboxImageContainer = document.createElement('div');
    lightboxImageContainer.className = 'lightbox-image-container';

    // Create the image element
    const lightboxImage = document.createElement('img');

    // Create close button
    const closeButton = document.createElement('span');
    closeButton.className = 'lightbox-close';
    closeButton.innerHTML = '&times;';

    // Assemble the lightbox
    lightboxImageContainer.appendChild(lightboxImage);
    lightboxOverlay.appendChild(lightboxImageContainer);
    lightboxOverlay.appendChild(closeButton);
    document.body.appendChild(lightboxOverlay);

    // Function to open lightbox
    function openLightbox(imgSrc, imgAlt) {
        console.log('Opening lightbox for:', imgSrc);
        lightboxImage.src = imgSrc;
        lightboxImage.alt = imgAlt || '';
        lightboxOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    // Function to close lightbox
    function closeLightbox() {
        console.log('Closing lightbox');
        lightboxOverlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
        setTimeout(() => {
            lightboxImage.src = ''; // Clear source after transition
        }, 300);
    }

    // Add click event to images
    contentImages.forEach(img => {
        // Only apply to images that are likely content (skip small icons if any)
        if (img.naturalWidth > 100 || img.width > 100) {
            img.style.cursor = 'zoom-in';
            img.classList.add('lightbox-trigger');

            img.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default link behavior if wrapped in link
                e.stopPropagation(); // Stop event bubbling
                openLightbox(this.src, this.alt);
            });
        }
    });

    // Close on overlay click
    lightboxOverlay.addEventListener('click', function (e) {
        if (e.target === lightboxOverlay || e.target === closeButton) {
            closeLightbox();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightboxOverlay.classList.contains('active')) {
            closeLightbox();
        }
    });
});

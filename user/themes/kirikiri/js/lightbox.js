// DEBUG: Alert to test if script loads
alert('Lightbox JS laetud!');

// Wait for all images to load before attaching lightbox handlers
window.addEventListener('load', function () {
    console.log('Lightbox script loaded (window.onload version)');

    // Select all images within the article content
    const contentImages = document.querySelectorAll('.article-content img');
    console.log('Found images for lightbox:', contentImages.length);

    // Create the lightbox overlay element with INLINE STYLES
    const lightboxOverlay = document.createElement('div');
    lightboxOverlay.id = 'lightbox-overlay';

    // Critical styles applied directly via JS
    lightboxOverlay.style.position = 'fixed';
    lightboxOverlay.style.top = '0';
    lightboxOverlay.style.left = '0';
    lightboxOverlay.style.width = '100vw';
    lightboxOverlay.style.height = '100vh';
    lightboxOverlay.style.backgroundColor = 'rgba(0, 0, 0, 0.95)';
    lightboxOverlay.style.zIndex = '2147483647';
    lightboxOverlay.style.display = 'none';
    lightboxOverlay.style.justifyContent = 'center';
    lightboxOverlay.style.alignItems = 'center';
    lightboxOverlay.style.cursor = 'pointer';

    // Create the image container
    const lightboxImageContainer = document.createElement('div');
    lightboxImageContainer.style.maxWidth = '90%';
    lightboxImageContainer.style.maxHeight = '90vh';
    lightboxImageContainer.style.position = 'relative';
    lightboxImageContainer.style.display = 'flex';
    lightboxImageContainer.style.justifyContent = 'center';
    lightboxImageContainer.style.alignItems = 'center';

    // Create the image element
    const lightboxImage = document.createElement('img');
    lightboxImage.style.maxWidth = '100%';
    lightboxImage.style.maxHeight = '90vh';
    lightboxImage.style.objectFit = 'contain';
    lightboxImage.style.border = '2px solid #333';
    lightboxImage.style.backgroundColor = '#000';

    // Create close button
    const closeButton = document.createElement('span');
    closeButton.innerHTML = '&times;';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '20px';
    closeButton.style.right = '30px';
    closeButton.style.color = '#fff';
    closeButton.style.fontSize = '40px';
    closeButton.style.fontWeight = 'bold';
    closeButton.style.cursor = 'pointer';
    closeButton.style.zIndex = '2147483647';

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
        lightboxOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Function to close lightbox
    function closeLightbox() {
        console.log('Closing lightbox');
        lightboxOverlay.style.display = 'none';
        document.body.style.overflow = '';
        setTimeout(() => {
            lightboxImage.src = '';
        }, 100);
    }

    // Add click event to ALL images (skip size check since it was problematic)
    contentImages.forEach(img => {
        console.log('Attaching lightbox to image:', img.src, 'width:', img.width, 'naturalWidth:', img.naturalWidth);

        // Apply to all images in article content, regardless of size
        img.style.cursor = 'zoom-in';
        img.style.transition = 'opacity 0.2s';

        img.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openLightbox(this.src, this.alt);
        });
    });

    // Close on overlay click
    lightboxOverlay.addEventListener('click', function (e) {
        if (e.target === lightboxOverlay || e.target === closeButton || e.target === lightboxImageContainer) {
            closeLightbox();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightboxOverlay.style.display === 'flex') {
            closeLightbox();
        }
    });
});

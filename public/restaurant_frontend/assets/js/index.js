 document.addEventListener('DOMContentLoaded', () => {
    function setupCarousel(carouselSelector, prevBtnSelector, nextBtnSelector, itemsSelector, desktopItems, mobileItems) {
        const carousel = document.querySelector(carouselSelector);
        const items = document.querySelector(itemsSelector);
        const prevBtn = document.querySelector(prevBtnSelector);
        const nextBtn = document.querySelector(nextBtnSelector);

        if (!carousel || !items || !prevBtn || !nextBtn) {
            console.error('Required carousel elements not found');
            return;
        }

        let itemWidth = 0;
        let currentIndex = 0;
        let totalItems = items.children.length;
        let visibleItems = 0;

        console.log('Total items:', totalItems);

        function updateCarousel() {
            const carouselWidth = carousel.offsetWidth;
            const isMobile = window.innerWidth <= 768;
            visibleItems = isMobile && mobileItems ? mobileItems : (desktopItems || Math.floor(carouselWidth / items.children[0].offsetWidth));
            itemWidth = items.children[0].offsetWidth; // Use actual item width
            slideTo(currentIndex);
        }

        function updateButtons() {
            prevBtn.classList.toggle('ecom-disabled', currentIndex === 0);
            nextBtn.classList.toggle('ecom-disabled', currentIndex >= totalItems - visibleItems);
        }

        function slideTo(index) {
            if (index < 0 || index > totalItems - visibleItems) return;
            currentIndex = index;
            items.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            updateButtons();
        }

        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('Previous button clicked', currentIndex);
            if (currentIndex > 0) {
                slideTo(currentIndex - 1);
            }
        });

        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('Next button clicked', currentIndex);
            if (currentIndex < totalItems - visibleItems) {
                slideTo(currentIndex + 1);
            }
        });

        window.addEventListener('resize', () => {
            updateCarousel();
        });

        carousel.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') prevBtn.click();
            if (e.key === 'ArrowRight') nextBtn.click();
        });

        let touchStartX = 0;
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            const swipeDistance = touchStartX - touchEndX;
            if (Math.abs(swipeDistance) > 50) {
                if (swipeDistance > 0) nextBtn.click();
                else if (swipeDistance < 0) prevBtn.click();
            }
        });

        updateCarousel();
        updateButtons();
    }

    // Initialize carousels
    setupCarousel('.ecom-category-carousel', '.ecom-category-prev', '.ecom-category-next', '.ecom-category-carousel .ecom-custom-categories', 9, 2);
    setupCarousel('.ecom-featured-products', '.ecom-featured-prev', '.ecom-featured-next', '.ecom-featured-products .ecom-custom-products', 8, 2);

        setupCarousel('.ecom-banner-carousel', '.ecom-banner-prev', '.ecom-banner-next', '.ecom-banner-carousel .ecom-custom-banners', 3, 1);
            setupCarousel('.ecom-category-carousel', '.ecom-category-prev', '.ecom-category-next', '.ecom-category-carousel .ecom-custom-categories', 9, 2);
            setupCarousel('.ecom-featured-products', '.ecom-featured-prev', '.ecom-featured-next', '.ecom-featured-products .ecom-custom-products', 8, 2);

            setupCarousel('.ecom-latest-products', '.ecom-latest-prev', '.ecom-latest-next', '.ecom-latest-products .ecom-custom-products', 8, 2);

            setupCarousel('.ecom-discounted-products', '.ecom-discounted-prev', '.ecom-discounted-next', '.ecom-discounted-products .ecom-custom-products', 8, 2);
            setupCarousel('.ecom-all-products', '.ecom-all-prev', '.ecom-all-next', '.ecom-all-products .ecom-custom-products', 5, 2);
            setupCarousel('.ecom-free-shipping-products', '.ecom-free-shipping-prev', '.ecom-free-shipping-next', '.ecom-free-shipping-products .ecom-custom-products', 8, 2);

});

 document.addEventListener('DOMContentLoaded', () => {



        });

        document.addEventListener('click', function (e) {
    if (e.target && e.target.id === 'load-more-btn') {
        const loadMoreBtn = e.target;
        const nextPage = loadMoreBtn.getAttribute('data-next-page');
        if (!nextPage) return;

        fetch(nextPage, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                // Append new products
                document.getElementById('product-list').insertAdjacentHTML('beforeend', html);

                // Update next page URL
                const urlParams = new URL(nextPage);
                const newNextPage = urlParams.searchParams.get('page');
                if (newNextPage) {
                    const nextPageUrl = nextPage.replace(/page=\d+/, 'page=' + (parseInt(newNextPage) + 1));
                    loadMoreBtn.setAttribute('data-next-page', nextPageUrl);
                } else {
                    loadMoreBtn.remove(); // No more pages
                }
            })
            .catch(err => console.error(err));
    }


});


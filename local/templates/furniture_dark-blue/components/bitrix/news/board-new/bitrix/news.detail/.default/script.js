document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.similar-swiper').forEach(function (el) {
        new Swiper(el, {
            slidesPerView: 'auto',
            spaceBetween: 16,
            loop: true,
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });

    document.querySelectorAll('.detail-gallery').forEach(function (el) {
        new Swiper(el, {
            slidesPerView: 1,
            loop: true,
            pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });

});

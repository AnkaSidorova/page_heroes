require('./bootstrap');
import Swiper, { Pagination, Autoplay } from 'swiper';
Swiper.use([Pagination, Autoplay]);

window.Swiper = Swiper;
document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper-container', {

        speed: 400,
        spaceBetween: 70,
        loop: true,
        slidesPerView: 4,
        autoplayStart: true,
        disableOnInteraction: true,
        paginationShow: true,

        autoplay: {
            delay: 2500
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function(index, className) {
                return '<span class="' + className + '"></span>';
            },
        },

        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            480: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            720: {
                slidesPerView: 4,
                spaceBetween: 40
            }
        }
    });
});
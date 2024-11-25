import "./bootstrap";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

const swiper = new Swiper(".swiperCarousel", {
    spaceBetween: 15,
    slidesPerView: 3,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    speed: 1000,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});
swiper();

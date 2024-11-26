$(document).ready(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 2500);
    };
    spinner();

    // Initiate the wowjs
    new WOW().init();

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $(".navbar").addClass("sticky-top shadow-sm");
        } else {
            $(".navbar").removeClass("sticky-top shadow-sm");
        }
    });

    // Validate de datum en tijd van de flatpickr/datepicker
    const validate = (dateString) => {
        const date = new Date(dateString);
        const day = date.getDay();
        const hours = date.getHours();
        const minutes = date.getMinutes();

        const timeRanges = {
            3: [17, 22], // Wednesday
            4: [12, 22], // Thursday
            5: [12, 23], // Friday
            6: [12, 23], // Saturday
            0: [12, 23], // Sunday
        };

        if (day == 1 || day == 2) return false; // Monday or Tuesday
        if (timeRanges[day]) {
            const [start, end] = timeRanges[day];
            if (hours < start || (hours == end && minutes > 0) || hours > end)
                return false;
        }

        return true;
    };

    // document.querySelector('#datetimepicker').addEventListener('input', evt => {
    //     if (!validate(evt.target.value)) {
    //         evt.target.value = '';
    //     }
    // });

    // Initialize the flatpickr en set the rules/options
    flatpickr("#datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        time_24hr: true,
        minuteIncrement: 15,
        minTime: "12:00",
        maxTime: "20:30",
        disable: [
            function (date) {
                return date.getDay() === 1 || date.getDay() === 2;
            },
        ],
        onReady: function (selectedDates, dateStr, instance) {
            setMinTime(instance);
        },
        onChange: function (selectedDates, dateStr, instance) {
            setMinTime(instance);
        },
    });

    // Set the minTime based on the selected date
    function setMinTime(instance) {
        const date = instance.selectedDates[0];
        if (!date) return;

        const day = date.getDay();
        if (day === 3) {
            // Wednesday
            instance.set("minTime", "17:00");
        } else if (day === 4 || day === 5 || day === 6 || day === 0) {
            // Thursday, Friday, Saturday, Sunday
            instance.set("minTime", "12:00");
        }
    }

    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function () {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
                function () {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function () {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });
    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
        return false;
    });

    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000,
    });

    // Modal Video
    // $(document).ready(function () {
    //     var $videoSrc;
    //     $(".btn-play").click(function () {
    //         $videoSrc = $(this).data("src");
    //     });
    //     console.log($videoSrc);

    //     $("#videoModal").on("shown.bs.modal", function (e) {
    //         $("#video").attr(
    //             "src",
    //             $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"
    //         );
    //     });

    //     $("#videoModal").on("hide.bs.modal", function (e) {
    //         $("#video").attr("src", $videoSrc);
    //     });
    // });

    // Initialize Swiper
    let swiperInstance;

    function initializeSwiper() {
        if (swiperInstance) {
            swiperInstance.destroy(true, true);
        }
        swiperInstance = new Swiper(".swiperCarousel", {
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
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        });
    }

    initializeSwiper();

    window.addEventListener("swiper-reinit", function () {
        initializeSwiper();
    });
});

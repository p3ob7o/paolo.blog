jQuery(document).ready(function($) {
    // Add click event listener to gallery links
    $('a.my-gallery-link').on('click', function(e) {
        e.preventDefault();

        // Find all gallery links
        var links = $('a.my-gallery-link');

        // Create an array of gallery data from the links
        var galleryData = [];
        links.each(function() {
            galleryData.push({
                src: $(this).attr('href'),
                title: '',
                caption: '',
                type: 'image'
            });
        });

        // Open the custom Jetpack Carousel gallery
        var gallery = new Swiper('.swiper-container', {
            init: false,
            loop: true,
            grabCursor: true,
            keyboard: true,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            zoom: {
                enabled: true,
            },
            autoplay: {
                delay: 5000,
            },
            on: {
                init: function() {
                    this.slideTo(links.index($('a.my-gallery-link[href="' + window.location.hash + '"]')));
                },
            },
        });
        gallery.init();
        gallery.removeAllSlides();
        gallery.appendSlide(galleryData);
        gallery.update();

        // Open the first slide
        gallery.slideTo(0, 0);
        $('body').addClass('jetpack-carousel');
        $('html').addClass('jetpack-carousel');
        $('.jetpack-carousel-wrap').fadeIn(200);
    });
});

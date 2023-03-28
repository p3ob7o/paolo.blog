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
                mime_type: 'image'
            });
        });

        // Open the custom Jetpack Carousel gallery
        $(document).trigger('click', {
            gallery: galleryData,
            start: links.index(this)
        });
    });
});

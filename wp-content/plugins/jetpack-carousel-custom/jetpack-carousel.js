jQuery(document).ready(function($) {
    // Add click event listener to carousel links
    $('a.my-jetpack-carousel-link').on('click', function(e) {
        e.preventDefault();

        // Find all carousel links
        var links = $('a.my-jetpack-carousel-link');

        // Find the index of the clicked link
        var index = links.index(this);

        // Open the Jetpack carousel with all images on the page
        $(document).trigger('click', { index: index, gallery: links.toArray() });
    });
});

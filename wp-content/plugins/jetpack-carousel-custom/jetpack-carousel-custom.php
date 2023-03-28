<?php
/*
Plugin Name: Jetpack Carousel Custom
Plugin URI: https://paolo.blog
Description: Adds navigation between individual images in Jetpack Carousel
Version: 1.0
Author: Paolo Belcastro
Author URI: https://paolo.blog
*/

// Add a custom class to all images on the page that should trigger the Jetpack Carousel in gallery mode when clicked
add_filter( 'wp_get_attachment_link', 'my_add_custom_image_class', 10, 6 );

function my_add_custom_image_class( $link, $id, $size, $permalink, $icon, $text ) {
    $custom_class = 'my-gallery-link'; // Customize this class name as desired
    $new_link = str_replace( '<a ', '<a class="' . $custom_class . ' ', $link );
    return $new_link;
}

// Add a click event listener to all images with the custom class that opens the Jetpack Carousel in gallery mode with the corresponding images
add_action( 'wp_footer', 'my_open_jetpack_carousel_gallery' );

function my_open_jetpack_carousel_gallery() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('body').on('click', 'a.my-gallery-link', function(e) {
                e.preventDefault();

                var gallery_data = [];

                // Find all images with the custom class
                var images = $('img.my-gallery-link');

                // Create an array of gallery data for the images
                images.each(function() {
                    var link = $(this).parent('a');
                    if ( link.length ) {
                        gallery_data.push({
                            src: link.attr('href'),
                            title: '',
                            caption: '',
                            mime_type: 'image'
                        });
                    }
                });

                // Open the Jetpack Carousel in gallery mode with the corresponding images
                $(document).trigger('click', {
                    gallery: gallery_data,
                    start: images.index(this),
                    type: 'gallery'
                });
            });
        });
    </script>
    <?php
}


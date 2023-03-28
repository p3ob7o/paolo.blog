<?php
/*
Plugin Name: Jetpack Carousel Custom
Plugin URI: https://paolo.blog
Description: Adds navigation between individual images in Jetpack Carousel
Version: 1.0
Author: Paolo Belcastro
Author URI: https://paolo.blog
*/

add_filter( 'the_content', 'my_add_carousel_links' );

function my_add_carousel_links( $content ) {
    // Find all image tags in the content
    preg_match_all('/<img[^>]+>/i', $content, $matches);
    $images = $matches[0];

    // Create an array of image URLs
    $urls = array();
    foreach ( $images as $image ) {
        preg_match('/src="([^"]*)"/i', $image, $url);
        $urls[] = $url[1];
    }

    // If there are no images, return the original content
    if ( empty( $urls ) ) {
        return $content;
    }

    // Add links to open images in a Jetpack carousel
    $links = array();
    foreach ( $urls as $url ) {
        $links[] = '<a href="' . $url . '" class="my-jetpack-carousel-link"></a>';
    }
    $content .= implode( '', $links );

    return $content;
}

add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

<<<<<<< HEAD:wp-content/plugins/jetpack-carousel-custom/jetpack-carousel-custom-disabled.php
function my_enqueue_jetpack_carousel() {
    // Enqueue the Jetpack Carousel script
    wp_enqueue_script( 'jetpack-carousel' );

    // Add a custom script that modifies the Jetpack Carousel behavior
    wp_enqueue_script( 'my-jetpack-carousel', plugin_dir_url( __FILE__ ) . 'my-jetpack-carousel.js', array( 'jetpack-carousel' ), '1.0', true );
}

// Add a click event listener to all images on the page that opens the custom gallery
add_action( 'wp_footer', 'my_add_gallery_links' );

function my_add_gallery_links() {
    // Find all images on the page
    $images = get_posts( array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'fields'         => 'ids',
    ) );

// Add a click event listener to all images on the page that opens the custom gallery
add_action( 'wp_footer', 'my_add_gallery_links' );

function my_add_gallery_links() {
    // Find all images on the page
    $images = get_posts( array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'fields'         => 'ids',
    ) );

    // Add a click event listener to each image that opens the custom gallery
    foreach ( $images as $image ) {
        echo '<a href="' . wp_get_attachment_url( $image ) . '" class="my-gallery-link"></a>';
    }
}
=======
function my_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jetpack-carousel', 'https://s1.wp.com/wp-content/mu-plugins/jetpack/_inc/build/carousel/jetpack-carousel.min.js', array( 'jquery' ), JETPACK__VERSION );
    wp_enqueue_script( 'my-jetpack-carousel', plugin_dir_url( __FILE__ ) . 'my-jetpack-carousel.js', array( 'jquery', 'jetpack-carousel' ), '1.0', true );
}
>>>>>>> parent of 2c85955 (New iteration, closer to how the carousel actually works):wp-content/plugins/jetpack-carousel-custom/jetpack-carousel-custom.php

<?php
/*
Plugin Name: Jetpack Carousel Custom
Plugin URI: https://paolo.blog
Description: Adds navigation between individual images in Jetpack Carousel
Version: 1.0
Author: Paolo Belcastro
Author URI: https://paolo.blog
*/

// Add custom data to the Jetpack Carousel script
add_filter( 'jetpack_carousel_data', 'my_jetpack_carousel_data' );

function my_jetpack_carousel_data( $data ) {
    // Find all images on the page
    $images = get_posts( array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'fields'         => 'ids',
    ) );

    // Create an array of gallery data for all images on the page
    $gallery_data = array();
    foreach ( $images as $image ) {
        $gallery_data[] = array(
            'src'       => wp_get_attachment_url( $image ),
            'title'     => get_the_title( $image ),
            'caption'   => get_post_field( 'post_excerpt', $image ),
            'mime_type' => get_post_mime_type( $image ),
        );
    }

    // Add custom data to the Jetpack Carousel script
    $data['gallery_data'] = $gallery_data;

    return $data;
}

// Modify the Jetpack Carousel script to create a custom gallery
add_action( 'wp_enqueue_scripts', 'my_enqueue_jetpack_carousel' );

function my_enqueue_jetpack_carousel() {
	// Enqueue the Swiper.js library and the Jetpack Carousel script
	wp_enqueue_script( 'swiper' );
	wp_enqueue_script( 'jetpack-carousel-swipe' );

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

    // Add a click event listener to each image that opens the custom gallery
    foreach ( $images as $image ) {
        echo '<a href="' . wp_get_attachment_url( $image ) . '" class="my-gallery-link"></a>';
    }
}

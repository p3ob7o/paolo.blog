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

function my_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jetpack-carousel', 'https://s1.wp.com/wp-content/mu-plugins/jetpack/_inc/build/carousel/jetpack-carousel.min.js', array( 'jquery' ), JETPACK__VERSION );
    wp_enqueue_script( 'my-jetpack-carousel', plugin_dir_url( __FILE__ ) . 'my-jetpack-carousel.js', array( 'jquery', 'jetpack-carousel' ), '1.0', true );
}
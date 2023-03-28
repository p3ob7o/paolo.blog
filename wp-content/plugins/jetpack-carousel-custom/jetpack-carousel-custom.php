<?php
/*
Plugin Name: Jetpack Carousel Custom
Plugin URI: https://paolo.blog
Description: Adds navigation between individual images in Jetpack Carousel
Version: 1.0
Author: Paolo Belcastro
Author URI: https://paolo.blog
*/

add_filter( 'jetpack_carousel_options', 'my_jetpack_carousel_options' );

function my_jetpack_carousel_options( $options ) {
    $options['carousel_options']['single_image_nav'] = true;
    return $options;
}

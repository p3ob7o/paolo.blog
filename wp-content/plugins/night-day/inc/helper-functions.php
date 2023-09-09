<?php
function night-day_register_styles() {
    wp_register_style( 'style1', plugins_url( 'assets/css/style1.css', dirname( __FILE__ ) ) );
    wp_register_style( 'style2', plugins_url( 'assets/css/style2.css', dirname( __FILE__ ) ) );
}
add_action( 'wp_enqueue_scripts', 'night-day_register_styles' );

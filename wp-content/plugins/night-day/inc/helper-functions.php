<?php
function night_day_register_styles() {
    wp_enqueue_style( 'global-style1', get_template_directory_uri() . '/path/to/global/style1.css' ); // Replace with actual path
    wp_enqueue_style( 'global-style2', get_template_directory_uri() . '/path/to/global/style2.css' ); // Replace with actual path
}
add_action( 'wp_enqueue_scripts', 'night_day_register_styles' );

function night_day_get_global_styles() {
    // Retrieve the list of global styles. Replace this with your method to get the styles.
    $global_styles = array(
        array( 'label' => 'Global Style 1', 'value' => 'global-style1' ),
        array( 'label' => 'Global Style 2', 'value' => 'global-style2' ),
    );

    return $global_styles;
}

<?php

function night_day_register_block() {
    wp_register_script(
        'night-day-block',
        plugins_url( 'assets/js/block.js', dirname( __FILE__, 2 ) ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . '/../assets/js/block.js' ),
        true
    );

    // Localize the script with the global styles data
    wp_localize_script('night-day-block', 'nightDayGlobals', array(
        'globalStyles' => night_day_get_global_styles(),
    ));

    register_block_type( 'night-day/block', array(
        'editor_script' => 'night-day-block',
        'editor_style'  => 'night-day-editor-style',
        'style'         => 'night-day-style',
    ) );
}

function night_day_get_global_styles() {
    // Retrieve the list of global styles. Replace this with your method to get the styles.
    $global_styles = array(
        array( 'label' => 'Global Style 1', 'value' => 'global-style1' ),
        array( 'label' => 'Global Style 2', 'value' => 'global-style2' ),
    );

    return $global_styles;
}

add_action( 'init', 'night_day_register_block' );

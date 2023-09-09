<?php

function night_day_register_block() {
    wp_register_script(
        'night-day-block',
        plugins_url( 'assets/js/block.js', dirname( __FILE__, 2 ) ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . '/../assets/js/block.js' ),
        true
    );

    register_block_type( 'night-day/block', array(
        'editor_script' => 'night-day-block',
        'editor_style'  => 'night-day-editor-style',
        'style'         => 'night-day-style',
    ) );
}
add_action( 'init', 'night_day_register_block' );

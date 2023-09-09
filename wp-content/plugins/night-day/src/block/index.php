<?php

function night_day_register_block() {
    wp_register_script(
        'night-day-block',
        plugins_url( 'assets/js/block.js', dirname( __FILE__, 2 ) ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . '/../assets/js/block.js' ),
        true
    );

    // Add the type="module" attribute to the script tag
    add_filter( 'script_loader_tag', function( $tag, $handle ) {
        if ( 'night-day-block' !== $handle ) {
            return $tag;
        }
        return str_replace( ' src', ' type="module" src', $tag );
    }, 10, 2 );


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

add_action( 'init', 'night_day_register_block' );

<?php
function plugin_name_register_block() {
    wp_register_script(
        'plugin-name-block',
        plugins_url( 'assets/js/block.js', dirname( __FILE__, 2 ) ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/block.js' ),
        true
    );

    register_block_type( 'plugin-name/block', array(
        'editor_script' => 'plugin-name-block',
        'editor_style'  => 'plugin-name-editor-style',
        'style'         => 'plugin-name-style',
    ) );
}
add_action( 'init', 'plugin_name_register_block' );

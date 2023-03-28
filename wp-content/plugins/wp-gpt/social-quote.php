<?php

function wp_gpt_social_quote_block() {
    wp_register_script(
        'wp-gpt-social-quote',
        plugins_url('social-quote.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'social-quote.js')
    );

    register_block_type('wp-gpt/social-quote', array(
        'editor_script' => 'wp-gpt-social-quote',
    ));
}

add_action('init', 'wp_gpt_social_quote_block');

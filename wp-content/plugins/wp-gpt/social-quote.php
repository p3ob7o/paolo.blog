<?php

function wp_gpt_social_quote_register_block() {
    wp_register_script(
        'wp-gpt-social-quote-editor',
        plugins_url('social-quote-editor.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-i18n'),
        filemtime(plugin_dir_path(__FILE__) . 'social-quote-editor.js')
    );

    wp_register_style(
        'wp-gpt-social-quote-editor',
        plugins_url('social-quote-editor.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'social-quote-editor.css')
    );

    wp_register_style(
        'wp-gpt-social-quote',
        plugins_url('social-quote.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'social-quote.css')
    );

register_block_type('wp-gpt/social-quote', array(
        'editor_script' => 'wp-gpt-social-quote-editor',
        'editor_style' => 'wp-gpt-social-quote-editor',
        'style' => 'wp-gpt-social-quote',
    ));

    error_log('Social Quote Block registered.'); // Add this line for debugging
}

add_action('init', 'wp_gpt_social_quote_register_block');


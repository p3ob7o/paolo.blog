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
}

add_action('init', 'wp_gpt_social_quote_register_block');


function social_quote_enqueue_editor_assets() {
    $block_js = 'social-quote-editor.js';
    $block_css = 'social-quote-editor.css';

    wp_enqueue_script(
        'wp-gpt-social-quote-editor',
        plugins_url($block_js, __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . $block_js),
        true
    );

    wp_enqueue_style(
        'wp-gpt-social-quote-editor',
        plugins_url($block_css, __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . $block_css)
    );
}

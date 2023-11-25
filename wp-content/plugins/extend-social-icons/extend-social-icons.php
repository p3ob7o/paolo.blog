<?php
/**
 * Plugin Name: Extend Social Icons Block
 * Description: This plugin extends the Social Icons block to add the Gravatar icon.
 * Version: 1.0
 * Author: Paolo Belcastro
 * Author URI: https://paolo.blog
 */

function enqueue_block_editor_assets() {
    wp_enqueue_script(
        'extend-social-icons-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js'),
        true
    );

    wp_enqueue_style(
        'extend-social-icons-block',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );
}

add_action('enqueue_block_editor_assets', 'enqueue_block_editor_assets');
add_action('wp_enqueue_scripts', 'enqueue_block_editor_assets');
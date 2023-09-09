<?php
/**
 * Enqueue scripts and styles for the block.
 *
 * @package Dark/Light Mode Toggle
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue block editor JavaScript and CSS
 */
function enqueue_block_editor_assets() {
    // Make paths variables so we don't write em twice ;)
    $blockPath = '/src/block/block.js';
    $editorStylePath = '/src/block/editor.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'dark-light-mode-toggle-block-js',
        plugins_url($blockPath, __FILE__),
        ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . $blockPath)
    );

    // Enqueue optional editor only styles
    wp_enqueue_style(
        'dark-light-mode-toggle-block-editor-css',
        plugins_url($editorStylePath, __FILE__),
        ['wp-edit-blocks'],
        filemtime(plugin_dir_path(__FILE__) . $editorStylePath)
    );
}

// Hook scripts function into block editor hook
add_action('enqueue_block_editor_assets', 'enqueue_block_editor_assets');

/**
 * Enqueue view scripts
 */
function enqueue_block_scripts() {
    $stylePath = '/src/block/style.css';
    $darkStylePath = '/src/block/dark-mode.css';
    $lightStylePath = '/src/block/light-mode.css';

    wp_enqueue_style(
        'dark-light-mode-toggle-block-css',
        plugins_url($stylePath, __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . $stylePath)
    );

    wp_enqueue_style(
        'dark-light-mode-toggle-block-dark-css',
        plugins_url($darkStylePath, __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . $darkStylePath)
    );

    wp_enqueue_style(
        'dark-light-mode-toggle-block-light-css',
        plugins_url($lightStylePath, __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . $lightStylePath)
    );
}

// Hook scripts function into frontend hook
add_action('enqueue_block_assets', 'enqueue_block_scripts');
?>

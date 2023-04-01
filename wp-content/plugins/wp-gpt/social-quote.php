<?php

function wp_gpt_social_quote_render_callback($attributes, $content) {
    $quote = isset($attributes['quote']) ? $attributes['quote'] : '';
    $author = isset($attributes['author']) ? $attributes['author'] : '';

    if (!$quote || !$author) {
        return '';
    }

    $tweet_text = urlencode('"' . $quote . '" - ' . $author);
    $tweet_url = 'https://twitter.com/intent/tweet?text=' . $tweet_text;

    return sprintf(
        '<blockquote class="wp-gpt-social-quote">
            <p>%1$s</p>
            <footer>
                — <cite>%2$s</cite>
                <a href="%3$s" target="_blank" rel="noopener noreferrer" class="wp-gpt-tweet-this">Tweet This</a>
            </footer>
        </blockquote>',
        esc_html($quote),
        esc_html($author),
        esc_url($tweet_url)
    );
}

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

    // Add this line to set the pluginDirUrl global variable
    wp_localize_script('wp-gpt-social-quote-editor', 'pluginDirUrl', plugin_dir_url(__FILE__));

    register_block_type('wp-gpt/social-quote', array(
        'editor_script' => 'wp-gpt-social-quote-editor',
        'editor_style' => 'wp-gpt-social-quote-editor',
        'style' => 'wp-gpt-social-quote',
        'render_callback' => 'wp_gpt_social_quote_render_callback',
    ));
}

add_action('init', 'wp_gpt_social_quote_register_block');


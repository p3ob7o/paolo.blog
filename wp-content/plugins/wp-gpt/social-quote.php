<?php
function wp_gpt_social_quote_register_block() {
    wp_register_script(
        'wp-gpt-social-quote-editor',
        plugins_url('social-quote-editor.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-api-fetch', 'wp-url')
    );

    wp_register_style(
        'wp-gpt-social-quote-editor',
        plugins_url('social-quote-editor.css', __FILE__),
        array('wp-edit-blocks')
    );

    wp_register_style(
        'wp-gpt-social-quote',
        plugins_url('social-quote.css', __FILE__),
        array()
    );

    register_block_type('wp-gpt/social-quote', array(
        'editor_script' => 'wp-gpt-social-quote-editor',
        'editor_style' => 'wp-gpt-social-quote-editor',
        'style' => 'wp-gpt-social-quote',
        'render_callback' => 'wp_gpt_social_quote_render_callback',
        'attributes' => array(
            'quote' => array(
                'type' => 'string',
            ),
            'author' => array(
                'type' => 'string',
            ),
        ),
    ));
}
add_action('init', 'wp_gpt_social_quote_register_block');

function wp_gpt_social_quote_render_callback($attributes) {
    if (!isset($attributes['quote']) || !isset($attributes['author'])) {
        return '';
    }

    $quote = $attributes['quote'];
    $author = $attributes['author'];

    return sprintf(
        '<blockquote class="wp-gpt-social-quote"><p>%1$s</p><footer><cite>— %2$s</cite></footer></blockquote>',
        esc_html($quote),
        esc_html($author)
    );
}

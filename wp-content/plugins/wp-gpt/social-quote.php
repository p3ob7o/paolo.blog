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
		'render_callback' => 'wp_gpt_social_quote_render_callback', // Add this line
		'attributes' => array(
			'quote' => array(
				'type' => 'string',
			),
		),
	));
}
add_action('init', 'wp_gpt_social_quote_register_block');

function wp_gpt_social_quote_enqueue_styles() {
    wp_enqueue_style(
        'wp-gpt-social-quote-frontend',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );
}
add_action('wp_enqueue_scripts', 'wp_gpt_social_quote_enqueue_styles');

function wp_gpt_social_quote_enqueue_scripts() {
    wp_enqueue_script(
        'wp-gpt-social-quote-frontend',
        plugins_url('frontend-script.js', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'frontend-script.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'wp_gpt_social_quote_enqueue_scripts');

function wp_gpt_social_quote_render_callback($attributes, $content) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    $quote_div = $dom->getElementsByTagName('div')->item(0);
    $quote = $quote_div->getAttribute('data-quote');

    if (empty($quote)) {
        return '';
    }

    $quote_html = sprintf('<p>%1$s</p>', esc_html($quote));
    $twitter_button_html = '<div class="wp-gpt-social-quote__button"><a href="https://twitter.com/intent/tweet?text=' . urlencode($quote) . '" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-twitter"></span></a></div>';

    return sprintf(
        '<blockquote class="wp-gpt-social-quote">%1$s%2$s</blockquote>',
        $quote_html,
        $twitter_button_html
    );
}

function wp_gpt_social_quote_dynamic_block($block_content, $block) {
    if ($block['blockName'] === 'wp-gpt/social-quote') {
        error_log("Rendering the social quote block (dynamic block filter)");
        $quote = $block['attrs']['quote'] ?? '';
        return sprintf(
            '<blockquote class="wp-gpt-social-quote"><p>%1$s</p></blockquote>',
            esc_html($quote)
        );
    }

    return $block_content;
}

add_filter('render_block', 'wp_gpt_social_quote_dynamic_block', 10, 2);


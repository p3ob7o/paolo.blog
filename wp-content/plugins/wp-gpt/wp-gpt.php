<?php
/*
Plugin Name: GPT for WordPress
Description: A sandbox to play with GPT-powered features in WordPress
Version: 0.1
Author: Paolo Belcastro
License: GPL-3.0
*/

require_once plugin_dir_path(__FILE__) . 'social-quote.php';

function wp_gpt_admin_menu() {
    add_options_page(
        'GPT for WordPress Settings',
        'GPT for WordPress',
        'manage_options',
        'wp-gpt',
        'wp_gpt_settings_page'
    );
}

function wp_gpt_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="gpt_api_key">OpenAI API Key</label>
                        </th>
                        <td>
                            <input name="gpt_api_key" type="text" id="gpt_api_key" value="<?php echo esc_attr(get_option('gpt_api_key', '')); ?>" class="regular-text">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <button type="button" id="gpt_save_api_key" class="button button-primary">Save API Key</button>
            </p>
        </form>
    </div>
    <?php
}

add_action('admin_menu', 'wp_gpt_admin_menu');

function wp_gpt_enqueue_settings_scripts() {
    $screen = get_current_screen();
    if (strpos($screen->base, 'wp-gpt') === false) {
        return;
    }

    wp_enqueue_script(
        'wp-gpt-settings',
        plugins_url('gpt-settings.js', __FILE__),
        array('wp-api'),
        filemtime(plugin_dir_path(__FILE__) . 'gpt-settings.js')
    );
}

add_action('admin_enqueue_scripts', 'wp_gpt_enqueue_settings_scripts');

function wp_gpt_register_rest_routes() {
    register_rest_route('gpt4/v1', '/update-api-key', array(
        'methods' => 'POST',
        'callback' => 'wp_gpt_update_api_key',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
    ));
}

add_action('rest_api_init', 'wp_gpt_register_rest_routes');

function wp_gpt_update_api_key(WP_REST_Request $request) {
    $api_key = $request->get_param('gpt_api_key');
    update_option('gpt_api_key', sanitize_text_field($api_key));
    return new WP_REST_Response(array('status' => 'success'), 200);
}

require_once plugin_dir_path(__FILE__) . 'social-quote.php';

function wp_gpt_enqueue_block_assets() {
  wp_enqueue_style(
    'wp-gpt-social-quote-style',
    plugins_url('social-quote-style.css', __FILE__),
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'social-quote-style.css')
  );
  
  wp_enqueue_style(
    'wp-gpt-style',
    plugins_url('style.css', __FILE__),
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'style.css')
  );
}
add_action('enqueue_block_assets', 'wp_gpt_enqueue_block_assets');

function wp_gpt_enqueue_frontend_scripts() {
  wp_enqueue_script(
    'wp-gpt-frontend-script',
    plugins_url('frontend-script.js', __FILE__),
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'frontend-script.js'),
    true
  );
}
add_action('wp_enqueue_scripts', 'wp_gpt_enqueue_frontend_scripts');


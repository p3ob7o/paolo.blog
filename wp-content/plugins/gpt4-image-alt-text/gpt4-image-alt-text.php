<?php
/**
 * Plugin Name: GPT-4 Image Alt Text
 * Description: Enhance the default WordPress Image block by adding a button to generate image descriptions using the GPT-4 API.
 * Version: 1.1
 * Author: Paolo Belcastro
 * License: GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

function gpt4_image_alt_text_enqueue() {
    wp_enqueue_script(
        'gpt4-image-alt-text',
        plugin_dir_url(__FILE__) . 'gpt4-image-alt-text.js',
        array('wp-blocks', 'wp-element', 'wp-hooks', 'wp-data', 'wp-compose', 'wp-components', 'wp-i18n', 'wp-api'),
        filemtime(plugin_dir_path(__FILE__) . 'gpt4-image-alt-text.js')
    );
}
add_action('enqueue_block_editor_assets', 'gpt4_image_alt_text_enqueue');

function gpt4_admin_menu() {
    add_options_page(
        'GPT-4 Image Alt Text Settings',
        'GPT-4 Image Alt Text',
        'manage_options',
        'gpt4-image-alt-text',
        'gpt4_settings_page'
    );
}
add_action('admin_menu', 'gpt4_admin_menu');

function gpt4_settings_page() {
    wp_enqueue_script(
        'gpt4-settings',
        plugin_dir_url(__FILE__) . 'gpt4-settings.js',
        array('wp-api'),
        filemtime(plugin_dir_path(__FILE__) . 'gpt4-settings.js')
    );
    wp_localize_script('gpt4-settings', 'wpApiSettings', array(
        'root' => esc_url_raw(rest_url()),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
    ?>
    <div class="wrap">
        <h1>GPT-4 Image Alt Text Settings</h1>
        <form>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="gpt4_api_key">API Key</label>
                        </th>
                        <td>
                            <input name="gpt4_api_key" type="text" id="gpt4_api_key" value="<?php echo esc_attr(get_option('gpt4_api_key')); ?>" class="regular-text">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <button type="button" id="gpt4_save_api_key" class="button button-primary">Save</button>
            </p>
        </form>
    </div>
    <?php
}

function gpt4_register_rest_routes() {
    register_rest_route('gpt4/v1', '/update-api-key', array(
        'methods' => 'POST',
        'callback' => 'gpt4_update_api_key',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
    ));
    register_rest_route('gpt4/v1', '/get-api-key', array(
    'methods' => 'GET',
    'callback' => 'gpt4_get_api_key',
    'permission_callback' => function () {
        	return current_user_can('edit_posts');
    	},
	));
}
add_action('rest_api_init', 'gpt4_register_rest_routes');

function gpt4_update_api_key(WP_REST_Request $request) {
    $api_key = sanitize_text_field($request->get_param('gpt4_api_key'));

    if (update_option('gpt4_api_key', $api_key)) {
        return new WP_REST_Response(array('status' => 'success'), 200);
    } else {
        return new WP_REST_Response(array('status' => 'error'), 500);
    }
}

function gpt4_get_api_key() {
    return new WP_REST_Response(array('gpt4_api_key' => get_option('gpt4_api_key')), 200);
}

function gpt4_image_alt_text_enqueue_assets() {
    wp_enqueue_script(
        'gpt4-image-alt-text',
        plugins_url('gpt4-image-alt-text.js', __FILE__),
        array('wp-blocks', 'wp-editor', 'wp-element', 'wp-components'),
        filemtime(plugin_dir_path(__FILE__) . 'gpt4-image-alt-text.js'),
        true
    );
}

add_action('enqueue_block_editor_assets', 'gpt4_image_alt_text_enqueue_assets');

wp_enqueue_style('gpt4-image-alt-text-css', plugin_dir_url(__FILE__) . 'gpt4-image-alt-text.css', array(), filemtime(plugin_dir_path(__FILE__) . 'gpt4-image-alt-text.css'));

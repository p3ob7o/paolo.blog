<?php
/**
 * Plugin Name: Chatbase JS Injector
 * Plugin URI: https://paolo.blog/
 * Description: This plugin adds a specific Chatbase Javascript code to the frontend of your WordPress site.
 * Version: 1.0.0
 * Author: Paolo Belcastro
 * Author URI: https://paolobelcastro.com/
 */

function add_chatbase_js() {
    ?>
    <script>
      window.chatbaseConfig = {
        chatbotId: "Ru9sAHW8mEd08h_cnJOxR",
      }
    </script>
    <script
      src="https://www.chatbase.co/embed.min.js"
      id="Ru9sAHW8mEd08h_cnJOxR"
      defer>
    </script>
    <?php
}
add_action('wp_footer', 'add_chatbase_js');

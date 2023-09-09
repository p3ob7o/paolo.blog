<?php
/**
 * Plugin Name: Night & Day
 * Description: A plugin to toggle between two global styles via a WordPress block.
 * Version: 1.0
 * Author: Paolo Belcastro
 */

defined( 'ABSPATH' ) || exit;

define( 'NIGHT_DAY_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Include necessary files
require_once NIGHT_DAY_DIR_PATH . 'inc/helper-functions.php';
require_once NIGHT_DAY_DIR_PATH . 'src/block/index.php';

<?php
/**
 * This plugin demonstrates how to use the WordPress Ajax APIs.
 *
 * @package           Acme
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Ajax Demo
 * Description:       A simple demonstration of the WordPress Ajax APIs.
 * Version:           2.0.0
 * Author:            Tom McFarlin
 * Author URI:        https://tommcfarlin.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Loads and registers dependencies.
 */
include_once( 'includes/class-dependency-loader.php' );

/**
 * The primary class for the plugin
 */
include_once( 'class-wp-simple-ajax.php' );

/**
 * Instantiates the main class and initializes the plugin.
 */
function acme_start_plugin() {

	$plugin = new Acme_Simple_Ajax();
	$plugin->initialize();

}
acme_start_plugin();

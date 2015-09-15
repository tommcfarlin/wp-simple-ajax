<?php
/**
 * This plugin demonstrates how to use the WordPress Ajax APIs.
 *
 * @package           SA_Demo
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Ajax Demo
 * Description:       A simple demonstration of the WordPress Ajax APIs.
 * Version:           1.0.0
 * Author:            Tom McFarlin
 * Author URI:        https://tommcfarlin.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'wp_enqueue_scripts', 'sa_add_ajax_support' );
/**
 * Adds support for WordPress to handle asynchronous requests on both the front-end
 * of the website.
 *
 * @since    1.0.0
 */
function sa_add_ajax_support() {

	wp_enqueue_script(
		'ajax-script',
		plugin_dir_url( __FILE__ ) . 'frontend.js',
		array( 'jquery' )
	);

	wp_localize_script(
		'ajax-script',
		'sa_demo',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	);

}

/**
 * Determines if a user is logged into the site using the specified user ID. If not,
 * then the following error code and message will be returned to the client:
 *
 * -2: The visitor is not currently logged into the site.
 *
 * @access   private
 * @since    1.0.0
 *
 * @param    int $user_id         The current user's ID.
 *
 * @return   bool $is_logged_in    Whether or not the current user is logged in.
 */
function _sa_user_is_logged_in( $user_id ) {

	$is_logged_in = true;

	if ( 0 === $user_id ) {

		wp_send_json_error(
			new WP_Error( '-2', 'The visitor is not currently logged into the site.' )
		);

		$is_logged_in = false;

	}

	return $is_logged_in;

}

/**
 * Determines if a user with the specified ID exists in the WordPress database. If not, then will
 * the following error code and message will be returned to the client:
 *
 * -1: No user was found with the specified ID [ $user_id ].
 *
 * @access   private
 * @since    1.0.0
 *
 * @param    int $user_id        The current user's ID.
 *
 * @return   bool $user_exists    Whether or not the specified user exists.
 */
function _sa_user_exists( $user_id ) {

	$user_exists = true;

	if ( false === get_user_by( 'id', $user_id ) ) {

		wp_send_json_error(
			new WP_Error( '-1', 'No user was found with the specified ID [' . $user_id . ']' )
		);

		$user_exists = false;

	}

	return $user_exists;

}

add_action( 'wp_ajax_get_current_user_info', 'sa_get_current_user_info' );
add_action( 'wp_ajax_nopriv_get_current_user_info', 'sa_get_current_user_info' );
/**
 * Retrieves information about the user who is currently logged into the site.
 *
 * This function is intended to be called via the client-side of the public-facing
 * side of the site.
 *
 * @since    1.0.0
 */
function sa_get_current_user_info() {

	// Grab the current user's ID.
	$user_id = get_current_user_id();

	// If the user is logged in and the user exists, return success with the user JSON.
	if ( _sa_user_is_logged_in( $user_id ) && _sa_user_exists( $user_id ) ) {

		wp_send_json_success(
			wp_json_encode( get_user_by( 'id', $user_id ) )
		);

	}

}

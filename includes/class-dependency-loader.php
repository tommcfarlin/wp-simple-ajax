<?php
/**
 * Loads and registers dependencies.
 *
 * @since    1.0.0
 *
 * @package   Acme
 * @author    Tom McFarlin
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt
 * @link      https://tommcfarlin.com/
 */

/**
 * Loads and enqueues dependencies for the plugin.
 *
 * @package    Acme
 * @subpackage Acme/includes
 * @since      1.0.0
 * @author     Tom McFarlin
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://tommcfarlin.com/
 */
class Dependency_Loader {

	/**
	 * Enqueues the front-end scripts for getting the current user's information
	 * via Ajax.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			'ajax-script',
			plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/frontend.js',
			array( 'jquery' )
		);

		wp_localize_script(
			'ajax-script',
			'sa_demo',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
		);

	}

	/**
	 * Registers the callback functions responsible for providing a response
	 * to Ajax requests setup throughout the rest of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function setup_ajax_handlers() {

		add_action(
			'wp_ajax_get_current_user_info',
			array( $this, 'get_current_user_info' )
		);

		add_action(
			'wp_ajax_nopriv_get_current_user_info',
			array( $this, 'get_current_user_info' )
		);

	}

	/**
	 * Retrieves information about the user who is currently logged into the site.
	 *
	 * This function is intended to be called via the client-side of the public-facing
	 * side of the site.
	 *
	 * @since    1.0.0
	 */
	public function get_current_user_info() {

		$user_id = get_current_user_id();

		if ( $this->user_is_logged_in( $user_id ) && $this->user_exists( $user_id ) ) {

			wp_send_json_success(
				wp_json_encode( get_user_by( 'id', $user_id ) )
			);

		}

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
	private function user_is_logged_in( $user_id ) {

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
	private function user_exists( $user_id ) {

		$user_exists = true;

		if ( false === get_user_by( 'id', $user_id ) ) {

			wp_send_json_error(
				new WP_Error( '-1', 'No user was found with the specified ID [' . $user_id . ']' )
			);

			$user_exists = false;

		}

		return $user_exists;

	}
}

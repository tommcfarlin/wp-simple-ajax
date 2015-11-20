<?php
/**
 * The primary class for the plugin
 *
 * Stores the plugin version, loads and enqueues dependencies
 * for the plugin.
 *
 * @since    1.0.0
 *
 * @package   Acme
 * @author    Tom McFarlin
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt
 * @link      https://tommcfarlin.com/
 */

/**
 * Stores the plugin version, loads and enqueues dependencies
 * for the plugin.
 *
 * @package   Acme
 * @author    Tom McFarlin
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt
 * @link      https://tommcfarlin.com/
 */
class Acme_Simple_Ajax {

	/**
	 * Represents the current version of this plugin.
	 *
	 * @access    private
	 * @since     1.0.0
	 * @var       string
	 */
	private $version;

	/**
	 * A reference to the Dependency Loader.
	 *
	 * @access    private
	 * @since     1.0.0
	 * @var       Dependency_Loader
	 */
	private $loader;

	/**
	 * Initializes the properties of the class.
	 *
	 * @access    private
	 * @since     1.0.0
	 */
	public function __construct() {

		$this->version = '2.0.0';
		$this->loader  = new Dependency_Loader();

	}

	/**
	 * Initializes this plugin and the dependency loader to include
	 * the JavaScript necessary for the plugin to function.
	 *
	 * @access    private
	 * @since     1.0.0
	 */
	public function initialize() {

		$this->loader->enqueue_scripts();
		$this->loader->setup_ajax_handlers();

	}
}

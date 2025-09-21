<?php
/**
 * Plugin Name: Fauxpress Site Hygiene
 * Plugin URI: https://example.com
 * Description: A fake plugin demonstrating PSR-4 autoloading.
 * Author: Fauxpress
 * Version: 0.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.2
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fauxpress-site-hygiene
 *
 * @package FauxpressSiteHygiene
 */

namespace Fauxpress\SiteHygiene;

require __DIR__ . '/lib/autoload.php';

/**
 * Class Fauxpress
 */
class Fauxpress {
	/**
	 * Class runner.
	 */
	public function run() {
		add_action( 'init', array( $this, 'init' ) );

		$admin_init = new Admin\Init();
		$admin_init->run();

		$admin_settings = new Admin\Settings();
		$admin_settings->run();
	}

	/**
	 * Init the class.
	 */
	public function init() {
		load_plugin_textdomain( 'fauxpress-site-hygiene' );
	}
}

add_action(
	'plugins_loaded',
	function () {
		$fauxpress = new Fauxpress();
		$fauxpress->run();
	}
);

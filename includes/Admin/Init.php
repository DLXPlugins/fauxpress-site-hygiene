<?php
/**
 * Admin init class.
 *
 * @package FauxpressSiteHygiene
 */

namespace Fauxpress\SiteHygiene\Admin;

/**
 * Admin init class.
 */
class Init {
	/**
	 * Class runner.
	 */
	public function run() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
	}

	/**
	 * Initialize the admin menu.
	 */
	public function add_admin_menu() {
		add_options_page(
			'Fauxpress Site Hygiene',
			'Fauxpress Site Hygiene',
			'manage_options',
			'fauxpress-site-hygiene',
			array( $this, 'render_admin_page' ),
			10
		);
	}

	/**
	 * Render the admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'fauxpress' );
				do_settings_sections( 'fauxpress' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}

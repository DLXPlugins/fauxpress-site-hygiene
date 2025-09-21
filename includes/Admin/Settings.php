<?php
/**
 * Admin settings class.
 *
 * @package FauxpressSiteHygiene
 */

namespace Fauxpress\SiteHygiene\Admin;

use Fauxpress\SiteHygiene\Options;

/**
 * Admin settings class.
 */
class Settings {
	/**
	 * Class runner.
	 */
	public function run() {
		add_action( 'admin_init', array( $this, 'add_admin_init' ) );
	}

	/**
	 * Initialize the admin menu.
	 */
	public function add_admin_init() {
		// Register individual settings.
		register_setting(
			'fauxpress',
			'fauxpress',
			array(
				'sanitize_callback' => function ( $in ) {
					return array(
						'disable_all_comments'  => ! empty( $in['disable_all_comments'] ),
						'disable_site_indexing' => ! empty( $in['disable_site_indexing'] ),
						'admin_notice_text'     => sanitize_text_field( $in['admin_notice_text'] ?? '' ),
					);
				},
			)
		);

		// Register sections.
		add_settings_section( 'fauxpress_section', 'Fauxpress Site Hygiene', '__return_empty_string', 'fauxpress' );

		// Register fields.
		add_settings_field( 'disable_all_comments', 'Disable All Comments', array( $this, 'render_admin_field_disable_all_comments' ), 'fauxpress', 'fauxpress_section', array( 'label_for' => 'disable_all_comments' ) );
		add_settings_field( 'disable_site_indexing', 'Disable Site Indexing', array( $this, 'render_admin_field_disable_site_indexing' ), 'fauxpress', 'fauxpress_section', array( 'label_for' => 'disable_site_indexing' ) );
		add_settings_field( 'admin_notice_text', 'Admin Notice Text', array( $this, 'render_admin_field_admin_notice_text' ), 'fauxpress', 'fauxpress_section', array( 'label_for' => 'admin_notice_text' ) );
	}

	/**
	 * Render the admin field.
	 */
	public function render_admin_field_disable_all_comments() {
		$options = Options::get_options();
		?>
		<input type="hidden" name="fauxpress[disable_all_comments]" value="0" />
		<input type="checkbox" name="fauxpress[disable_all_comments]" value="1" <?php checked( (bool) $options['disable_all_comments'], true ); ?> id="disable_all_comments" />
		<?php
	}

	/**
	 * Render the admin field.
	 */
	public function render_admin_field_disable_site_indexing() {
		$options = Options::get_options();
		?>
		<input type="hidden" name="fauxpress[disable_site_indexing]" value="0" />
		<input type="checkbox" name="fauxpress[disable_site_indexing]" value="1" <?php checked( (bool) $options['disable_site_indexing'], true ); ?> id="disable_site_indexing" />
		<?php
	}

	/**
	 * Render the admin field.
	 */
	public function render_admin_field_admin_notice_text() {
		$options = Options::get_options();
		?>
		<input type="text" placeholder="Enter admin notice text" name="fauxpress[admin_notice_text]" value="<?php echo esc_attr( $options['admin_notice_text'] ); ?>" id="admin_notice_text" />
		<?php
	}
}

<?php
/**
 * Helper functions for the plugin's options.
 *
 * @package FauxpressSiteHygiene
 */

namespace Fauxpress\SiteHygiene;

/**
 * Class Options
 */
class Options {

	/**
	 * A static cached version of the main options for the plugin.
	 *
	 * @var array $options
	 */
	private static $options = array();

	/**
	 * Options key.
	 *
	 * @var string $options_key The key when saving the options.
	 */
	private static $options_key = 'fauxpress';

	/**
	 * Retrieve default options for the plugin.
	 */
	public static function get_defaults() {
		$defaults = array(
			'disable_all_comments'  => false,
			'disable_site_indexing' => false,
			'admin_notice_text'     => '',
		);
		return $defaults;
	}

	/**
	 * Retrieve the plugin's options
	 *
	 * Retrieve the plugin's options based on key.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $force_reload Whether to retrieve cached options or forcefully retrieve from the database.

	 * @return array|string All options for key, value for $option, empty array on failure.
	 */
	public static function get_options( bool $force_reload = false ) {

		// Try to get cached options value.
		$options = self::$options;

		// Retrieve fresh options if empty or force_reload is true.
		if ( empty( $options ) || true === $force_reload ) {
			$options = get_option( self::$options_key, array() );
		}

		// Parse options with defaults and update options static var.
		$options       = wp_parse_args( $options, self::get_defaults() );
		self::$options = $options;

		return $options;
	}

	/**
	 * Save options for the plugin.
	 *
	 * @param array|string $options Options to save.
	 * @param bool         $force True to forcefully retrieve fresh options.
	 *
	 * @return array|null  Options.
	 */
	public static function update_options( $options = array(), $force = false ) {

		$cached_options = self::get_options( $force );

		if ( is_array( $cached_options ) && is_array( $options ) ) {
			$cached_options = $options;
			$cached_options = wp_parse_args( $cached_options, self::get_defaults() );
			update_option( self::$options_key, $cached_options );
		} elseif ( is_array( $options ) ) {
			$cached_options = wp_parse_args( $options, $cached_options );
			update_option( self::$options_key, $cached_options );
		} else {
			return null;
		}
		self::$options = $cached_options;

		return self::$options;
	}

	/**
	 * Reset the options to defaults.
	 */
	public static function reset_options() {
		$new_options = self::get_defaults();
		self::update_options( $new_options, false );
		return $new_options;
	}
}

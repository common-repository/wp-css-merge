<?php

/**
 * Fired during plugin activation
 *
 * @link       digitalapps.co
 * @since      1.0.0
 *
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/includes
 * @author     digitalapps <support@digitalapps.co>
 */
class Wp_Css_Merge_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'wp-css-merge-activate', 0 );
	}

}

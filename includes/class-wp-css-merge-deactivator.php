<?php

/**
 * Fired during plugin deactivation
 *
 * @link       digitalapps.co
 * @since      1.0.0
 *
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/includes
 * @author     digitalapps <support@digitalapps.co>
 */
class Wp_Css_Merge_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		if( current_user_can( 'activate_plugins' ) ) {
			
			require_once WP_PLUGIN_DIR . '/wp-css-merge/includes/class-wp-css-merge-helper.php';
			
			$instance = Wp_Css_Merge_Helper::getInstance();

			delete_option( 'wp-css-merge-activate' );
			
			if( file_exists( $instance::get_path_to_css() ) ) {

				wp_delete_file( $instance::get_path_to_css() );

			}

		}

	}

}

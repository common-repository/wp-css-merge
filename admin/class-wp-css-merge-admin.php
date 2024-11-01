<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       digitalapps.co
 * @since      1.0.0
 *
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Css_Merge
 * @subpackage Wp_Css_Merge/admin
 * @author     digitalapps <support@digitalapps.co>
 */
class Wp_Css_Merge_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Css_Merge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Css_Merge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/wp-css-merge-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-toggle-switch', plugin_dir_url( __FILE__ ) . 'css/toggle-switch.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Css_Merge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Css_Merge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-css-merge-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function localize_script() {

        $nonces = apply_filters( 'wp_css_merge_nonces', array(
			'merge_css'				=> wp_create_nonce( 'merge-css' ),
			'activate_merge_css'	=> wp_create_nonce( 'activate-merge-css' )
        ) );

        $data = apply_filters( 'att_data', array(
            'nonces'	=> $nonces
        ) );

        // wp_localize_script( $handle, $name, $data );
        wp_localize_script(
            $this->plugin_name,
            'wp_css_merge_app',
            $data
        );

	}

	public function activate_merge_css() {

		$action = 'activate-merge-css';

		$result = check_ajax_referer( $action, 'nonce', false );

		if ( false === $result ) {
            $return = array(
				'att_error' => 1, 
				'body' => sprintf( 
					__( 
						'Invalid nonce for: %s', $this->plugin_name ), 
						$action 
					) 
				);

			$this->end_ajax( json_encode( $return ) );
			
		} else {
			
			if ( isset( $_POST[ 'action' ] ) && wp_verify_nonce( $_POST['nonce'], $action ) && current_user_can( 'activate_plugins' ) ) {
				
				update_option( $this->plugin_name . '-activate', $_POST[ 'value' ] ? 1 : 0 );

			}

		}
		
		return print_r( $_REQUEST );

		exit;
	}

	function end_ajax( $return = false ) {
        echo ( false === $return ) ? '' : $return;
        exit;
	}

	/**
     * Adds a settings link next to Deactivate on the Plugins page
     *
     * @since           1.0.3
     */
    public function add_settings_link( $links ) {
		
        $settings_link = '<a href="options-general.php?page=' . $this->plugin_name . '-page-general-settings">' . __( 'Settings' ) . '</a>';
        array_push( $links, $settings_link );

        return $links;

	}
	
}

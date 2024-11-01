<?php

class Wp_Css_Merge_Settings {

	private $plugin_name;
    private $version;
    
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
        $this->init();

    }

    function init() {

        register_setting( 
            $this->plugin_name . '-activate-group',
            $this->plugin_name . '-options',
            array( $this , 'validate_options' )
        );

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'settings/class-wp-css-merge-admin-page-settings.php';

        $general_settings_page = new Wp_Css_Merge_Settings_Page( 
			$this->plugin_name, 
			$this->version,
			'WP CSS Merge', 
			$this->get_plugin_name() . '-page-general-settings'  
		);
		
		/*
		 * $id ( section_id ), $section_title, $callback, $page, $html_title, $description
		 */
		$general_settings_page->add_section( 
			$this->get_plugin_name() . '-section-general-settings', 
			esc_html__( '', $this->plugin_name ),
			'section_options',
			'Settings',
			'Adjust Settings'
		);

		/*
		 * $id ( field_id ), $title, $callback, $section_id, $args
		 */
		$option = get_option( $this->plugin_name . '-activate' );
		$general_settings_page->add_field(

			$this->get_plugin_name() . '-activate',
			'Activate CSS Merge:',
			'field_toggle',
            $this->get_plugin_name() . '-section-general-settings',
            array(
                'id'                => $this->plugin_name . '-general-options[' . $this->plugin_name . '-activate]',
                'name'              => $this->plugin_name . '-general-options[' . $this->plugin_name . '-activate]',
                'value'             => $option ? 1 : 0,
			)
			
        );

        add_action( 'admin_init', [ $general_settings_page, 'init' ] );
	}
	
	function get_plugin_name() {
		return $this->plugin_name;
	}
    
}
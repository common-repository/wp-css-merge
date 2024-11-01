<?php
/**
 * Layout - Single page settings
 *
 * @since           1.0.0
 */

class Wp_Css_Merge_General_Settings_Section {
    
    private $plugin_name;
    private $version;
    private $page_name;

    // constructor
    public function __construct( $plugin_name, $version, $page_name ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->page_name = $page_name;
    
    }

    public function register_settings_all() {

        $defaults = array(
            'type'              => 'string',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false
        );
     
        register_setting( 
            $this->plugin_name . '-activate-group',
            $this->plugin_name . '-options',
            $defaults
        );

        add_settings_section( 
            $this->plugin_name . '-section-general-settings',
            apply_filters( $this->plugin_name . 'section-title', esc_html__( '', $this->plugin_name ) ),
            array( $this, 'section_options' ),
            $this->plugin_name . '-page-general-settings'
        );

        add_settings_field(
            $this->plugin_name . '-activate',
            apply_filters( $this->plugin_name . 'label-type', esc_html__( 'Toogle Box:', $this->plugin_name ) ),
            array( this, 'field_toggle' ),
            $this->plugin_name . '-page-general-settings',
            $this->plugin_name . '-section-general-settings',
            array(
                $this->plugin_name . '-author-box-single-post',
                $this->plugin_name . '-general-options[' . $this->plugin_name . '-activate]',
                'hide',
                array(
                    array(
                            'value'     => 'hide',
                            'label'     => 'Hide'
                        ),
                    array(
                            'value'     => 'show',
                            'label'     => 'Show'
                        )
                )
            )
        );

    }

    public function register_settings() {
        
        // register_setting( $option_group, $option_name, $sanitize_callback );

        $settings = [];
        $settings[] = [
            'option_group'      => $this->plugin_name . '-activate-group',
            'option_name'       => $this->plugin_name . '-options',
            'sanitize_callback' => 'validate_options'
        ];

        register_setting( 
            $this->plugin_name . '-activate-group',
            $this->plugin_name . '-options',
            array( $this , 'validate_options' )
        );

        // foreach ( $settings as $setting ) {
    
        //     register_setting( 
        //         $setting[ 'option_group' ],
        //         $setting[ 'option_name' ],
        //         array( $this , $setting[ 'sanitize_callback' ] )
        //     );

        // }

    }

    /**
     * #1 Registers settings sections with WordPress
     */
    public function register_sections() {

        // add_settings_section( $id, $title, $callback, $menu_slug );

        $sections = [];
        $sections[] = [
            'id'        => $this->plugin_name . '-section-general-settings',
            'title'     => esc_html__( '', $this->plugin_name ),
            'callback'  => 'section_options',
            'page'      => $this->plugin_name . '-page-general-settings'
        ];

        foreach ( $sections as $section ) {

            add_settings_section( 
                $section[ 'id'],
                $section[ 'title' ],
                array( $this, $section[ 'callback '] ),
                $section[ 'page' ]
            );

        }

    }
    
    /**
     * Creates a settings section
     *
     * @since           1.0.0
     * @param           array       $params     Array of parameters for the section
     * @return          mixed                   The settings section
     */
    public function section_options( $params ) {
        $title = '';
        $description = '';

        $return = '';
        $return = '<br>';
        $return .= '<h2>' . $title . '</h2>';
        $return .= '<p>' . $description . '</p>';

        echo $return;

    } // section_options()

        /**
     * Creates a select field
     *
     * Note: label is blank since its created in the Settings API
     *
     * @param           array       $args       The arguments for the field
     * @return          string                  The HTML field
     */
    public function field_toggle( $args ) {


        $defaults['aria']           = '';
        $defaults['blank']          = '';
        $defaults['class']          = 'widefat';
        $defaults['context']        = '';
        $defaults['description']    = '';
        $defaults['label']          = '';
        $defaults['name']           = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['selections']     = array();
        $defaults['value']          = '';

        apply_filters( $this->plugin_name . '-field-toggle-options-defaults', $defaults );
        
        $atts = wp_parse_args( $args, $defaults );

        if ( ! empty( $this->options[ $atts['id'] ] ) ) {

            $atts['value'] = $this->options[ $atts['id'] ];

        }

        if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

            $atts['aria'] = $atts['description'];

        } elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

            $atts['aria'] = $atts['label'];

        }

        include( plugin_dir_path( __DIR__ ) . 'partials/components/' . $this->plugin_name . '-admin-field-toggle.php' );

    }

    /**
     * Validates saved options
     *
     * @since   1.0.0
     * @param   array       $input      array of submitted plugin options
     * @return  array       array of validated plugin options
     */
    public function validate_options( $input ) {

        if ( null == $input ) {
            add_settings_error(
                'requiredTextFieldEmpty',
                'empty',
                'Cannot be empty',
                'error'
            );
        }

        $valid          = array();
        $options        = $this->get_options_list();
        $settings       = $this->options;

        foreach ( $options as $option ) {
            $name = $option[0]; // wp-global-site-tag-status
            $type = $option[1]; // text

            $valid[$name] = $this->sanitizer( $type, $input[$name] );

            if( empty( $valid[$name] ) && ! array_key_exists( $name, $input )) {
                $valid[$name] = $settings[$name];
            }
        }

        return $valid;

    } // validate_options()

}
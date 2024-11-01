<?php

class Wp_Css_Merge_Settings_Page {

	private $plugin_name;
    private $version;
    private $page_title;
    private $description;
    private $slug;
    
    private $menu_title;
    private $capability;

    private $sections;
    private $fields;
    
    public function __construct( $plugin_name, $version, $page_title, $slug ) {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
        $this->page_title   = $page_title;
        $this->slug         = $slug;

        $this->sections     = [];
        $this->fields       = [];

        add_action( 'admin_menu', [ $this, 'add_settings_page_menu' ] );

    }
    
    public function add_settings_page_menu() {

        $this->menu_title   = $this->page_title;
        $this->icon         = 'dashicons-welcome-widgets-menus';
        $this->position     = 100;
        $this->capability = 'manage_options';

        add_options_page( 
            $this->page_title, 
            $this->menu_title, 
            $this->capability, 
            $this->slug, 
            array( $this, 'page_content' ), 
            $this->icon, 
            $this->position 
        );

    }

    public function page_content() { ?>

        <div class="wrap">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content" class="daabd-admin-body">
                        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

                        <h3 class="nav-tab-wrapper">
                            <a href="<?php echo admin_url( 'admin.php?page=' . $this->plugin_name . '-page-general-settings' . '&tab=general_settings' ); ?>" class="nav-tab <?php echo ( $this->get_current_tab() == 'general_settings' ) ? 'nav-tab-active' : ''; ?>">Settings</a>
                        </h3>
                    
                        <form method="post" action="options.php"><?php

                            settings_fields( $this->plugin_name . '-activate-group' );
                            do_settings_sections( $this->slug );

                        ?></form>

                    </div>

                <?php $this->page_sidebar(); ?>

                <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

    <?php
    } // page_options()

    public function get_current_tab() {

        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';
        return $active_tab;
    
    }

    public function add_section( $id, $section_title, $callback, $html_title, $description ) {

        $this->sections[ $id ] = [
            'id'            => $id,
            'title'         => esc_html__( $section_title, $this->plugin_name ),
            'callback'      => 'section_options',
            'html_title'    => $html_title,
            'description'   => $description,
        ];

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

        switch( $params['id'] ){
            case $this->plugin_name . '-section-general-settings':
                $title = 'Author Box';
                $description = 'Adds a responsive author box at the end of your posts, showing the author name, author gravatar and author description.';
                break;
        }

        $return = '';
        $return = '<br>';
        $return .= '<h2>' . $this->page_title . '</h2>';
        $return .= '<p>' . $this->description . '</p>';

        echo $return;

    } // section_options()

    public function add_field( $id, $title, $callback, $section_id, $args ) {

        $this->fields[ $id ] = [
            'id'            => $this->plugin_name . '-section-general-settings',
            'title'         => esc_html__( $title, $this->plugin_name ),
            'callback'      => $callback,
            'page'          => $this->slug,
            'section'       => $section_id,
            'args'          => $args
            
        ];

    }

    /**
     * Creates a select field
     *
     * Note: label is blank since its created in the Settings API
     *
     * @param           array       $args       The arguments for the field
     * @return          string                  The HTML field
     */
    public function field_toggle( $args ) {

        $args[ 'id' ] = isset( $args[ 'id' ] ) ? $args[ 'id' ] : '';

        $defaults['aria']           = '';
        $defaults['blank']          = '';
        $defaults['class']          = 'widefat';
        $defaults['context']        = '';
        $defaults['description']    = '';
        $defaults['label']          = '';
        $defaults['name']           = $this->plugin_name . '-options[' . $args[ 'id' ] . ']';
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

    public function init() {

        foreach ( $this->sections as $section ) {

            add_settings_section( 
                $section[ 'id' ],
                $section[ 'title' ],
                array( $this, $section[ 'callback' ] ),
                $this->slug
            );

        }
        
        foreach ( $this->fields as $field ) {

            add_settings_field( 
                $field[ 'id' ],
                $field[ 'title' ],
                array( $this, $field[ 'callback' ] ),
                $this->slug,
                $field[ 'section' ],
                $field[ 'args' ]
            );

        }
    }

    /**
     * Creates the options page
     *
     * @since           1.0.0
     * @return          void
     */
    public function page_sidebar() {

        include( plugin_dir_path( __DIR__ ) . 'partials/wp-css-merge-admin-page-sidebar.php' );

    } // page_options()

}
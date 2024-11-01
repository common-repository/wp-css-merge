<?php
class Wp_Css_Merge_Helper {

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct() {
        // The expensive process (e.g.,db connection) goes here.
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {

        if ( self::$instance == null ) {

            self::$instance = new Wp_Css_Merge_Helper();
            
        }

        return self::$instance;

    }

    public static function os_path_optimize( $path ) {

         // *nix
         if( DIRECTORY_SEPARATOR == '/' ) {

            return str_replace( '\\', '/', $path );

         }

         // windows
        if( DIRECTORY_SEPARATOR == '\\' ) {

            return str_replace( '/', '\\', $path );

        }
        
    }

    public static function get_path_to_css() {

        // *nix
        if( DIRECTORY_SEPARATOR == '/' ) {

            return WP_CONTENT_DIR . "/wp-css-merge.css";

        }

        // windows
        if( DIRECTORY_SEPARATOR == '\\' ) {

            return wp_normalize_path( WP_CONTENT_DIR . "/wp-css-merge.css" );

        }

    }
}
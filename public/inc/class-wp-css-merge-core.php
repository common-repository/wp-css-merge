<?php
class Wp_Css_Merge_Core {

	private $plugin_name;
    private $version;
	private $activate;
	private $path_css_file;

	public function __construct(  $plugin_name, $version ) {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
		$this->activate 	= get_option( $this->plugin_name . '-activate' );
	
		require_once WP_PLUGIN_DIR . '/wp-css-merge/includes/class-wp-css-merge-helper.php';	
		
		$instance = Wp_Css_Merge_Helper::getInstance();
		$this->path_css_file = $instance->get_path_to_css();

	}
	
	function file_exists() {

		if( $this->activate ) {

			
			if( file_exists( $this->path_css_file ) ) {

				return true;

			}

		}
		
		return false;
		
	}

	function run() {
		
		if( $this->activate && ( false === $this->file_exists() ) ) {
			
			$this->list_all_css();
			$this->minify_css();

		}

		if( $this->activate && $this->file_exists() ) {
			
			$this->exclude_css();

		}

	}

	function exclude_css() {

		if( $this->file_exists() ) {
			
			global $wp_styles;

			foreach( $wp_styles->queue as $style ) :

				if( $style != 'wp-css-merge' ) {
					
					wp_dequeue_style( $style );
					wp_deregister_style( $style );

				}

			endforeach;

		}
	}

	function list_all_css() {

		$wp_domain; 
		$wp_home;
		$wp_home = site_url();   # get the current wordpress installation url
		$wp_domain = trim( str_ireplace( array('http://', 'https://'), '', trim( $wp_home, '/' ) ) );
		$wp_home_path = ABSPATH;
	
		$result = [];
		$result['scripts'] = [];
		$result['styles'] = [];
		$url = '';
		
		// Print all loaded Styles (CSS)
		global $wp_styles;
		
		if ( is_array($wp_styles->queue) ) {

			foreach( $wp_styles->queue as $style ) :

				$url = $this->get_url( $wp_styles->registered[$style]->src, $wp_domain, $wp_home, $wp_home_path );

				if( ! empty( $url ) ) {

					$result[ 'styles' ][] = $url;
					$this->write_to_file( $url );

				}

			endforeach;

		}
	
	}

	function get_url( $src, $wp_domain, $wp_home, $wp_home_path ) {

		$hurl = '';
		$hurl = trim( $src ); 
		if( empty( $hurl ) ) { return $hurl; } 
	
		# protocol + home for relative paths
		if (substr($hurl, 0, 12) === "/wp-includes" || substr($hurl, 0, 9) === "/wp-admin" || substr($hurl, 0, 11) === "/wp-content" ) { 
			$hurl = $wp_home.'/'.ltrim($hurl, "/"); 
		}
	
		$hurl = str_replace( $wp_home, '', $hurl );
		//if ( substr( $hurl, 0, strlen( $wp_home ) ) === $wp_home ) {
			// if ( substr( $hurl, 0, 1 ) === '/' ) {
				$hurl = substr( $hurl, 1 );
			// }
			$hurl =  $wp_home_path . '' . $hurl;


			require_once WP_PLUGIN_DIR . '/wp-css-merge/includes/class-wp-css-merge-helper.php';	
			$instance = Wp_Css_Merge_Helper::getInstance();
			$hurl = $instance::os_path_optimize( $hurl );
		//}
		
		return $hurl;

	}
	
	function write_to_file( $file_from ) {

		$handle1 = fopen( $file_from, "r" );
		$handle2 = fopen( $this->path_css_file, "a" );

		stream_copy_to_stream( $handle1, $handle2 );
	
		fclose( $handle1 );
		fclose( $handle2 );

	}

	function minify_css() {

		$content = file_get_contents( $this->path_css_file );
		$content = trim( $content );
		// Remove comments
		$content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content );
		// Remove whitespace
		$content = str_replace( array("\r\n", "\r", "\n", "\t"), '', $content );
		$content = preg_replace('/\s{2,}/s',' ', $content );
		$content = preg_replace('/;}/','}',$content);
		
		file_put_contents( $this->path_css_file, $content );

	}
}


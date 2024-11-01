=== Plugin Name ===
Contributors: digitalapps
Donate link: digitalapps.co
Tags: css, cache, speed, minify
Requires at least: 3.0.1
Tested up to: 5.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugins detects all of the styles queued via wp_enqueue_style. Contents of each css file are copied and stored in a single css file. This file is loaded on the frontend. The plugin wp_dequeue_style and wp_deregister_style all other css files. The result is your website only makes one single http request to load css styling. Bonus feature the contents of the css file are minified.

== Description ==

This plugins detects all of the styles queued via wp_enqueue_style. Contents of each css file are copied and stored in a single css file. This file is loaded on the frontend. The plugin wp_dequeue_style and wp_deregister_style all other css files. The result is your website only makes one single http request to load css styling. Bonus feature the contents of the css file are minified.

Simply flip the switch and the plugin will do the rest.

NOTE: I have only tested this plugin on my own sites running the AdSense Theme. If you encounter a problem with this plugin please let me know. I will be able to help you.

== Installation ==

Installing WP CSS Merge is easy, go to you your WordPress admin panel and click on Plugins > Add New, searching for "WP CSS Merge".
Alternatively, you can install the plugin manually by downloading the plugin from wordpress.org/plugins
1. Upload the entire wp-css-merge folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Customize the plugin from the menu by selecting AdUnblocker in the sidebar.

== Changelog ==

= 1.0 =
* First Release
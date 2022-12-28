<?php
	
/*
Plugin Name: 🅽 CGSpark Analytics
Description: Plugin display information about viewport devices that surf your site(s).
Version: 1.0
Author: 🅽 Sergey Nadolskiy
Author URI: https://www.upwork.com/freelancers/~01ad9db08dbea67811
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// require plugin_dir_path( __FILE__ ) . 'functions/global-functions.php';

// 🅽 Path to the plugin directories
define('PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('PLUGIN_URL', plugin_dir_url(__FILE__));

class viewport_size {
 
	// Initializes the plugin by setting localization, filters, and administration functions.
	function __construct() {
		add_action('admin_menu', array( &$this,'page_notification_register_menu') );
	} // [x] function __construct() { ... } 
 
	// Adding to the wp menu
	function page_notification_register_menu() {
		add_menu_page( 'CGS Analytics', 'CGS Analytics', 'read', 'viewport_size', array( &$this, 'viewport_size_create_empty' ), 'dashicons-cover-image', 2 );
		add_submenu_page( 'viewport_size', 'Platforms', 'Platforms', 'read','viewport_size', array( &$this, 'viewport_size_create_platforms' ), 1);
		add_submenu_page( 'viewport_size', 'Browsers', 'Browsers', 'read','viewport_size_browsers', array( &$this, 'viewport_size_create_browsers' ), 2);
		add_submenu_page( 'viewport_size', 'ViewPorts', 'ViewPorts', 'read','viewport_size_viewport', array( &$this, 'viewport_size_create_viewport' ), 3);
		add_submenu_page( 'viewport_size', 'eToroX', 'eToroX', 'read','viewport_size_etorox', array( &$this, 'viewport_size_create_etorox' ),4);

	} // [x] function page_notification_register_menu() { ... }

    function viewport_size_create_empty() {
  	    include_once( 'pages/empty.php' );
	} // [x] function viewport_size_importer_create_dashboard() { ... }

	function viewport_size_create_platforms() {
		include_once( 'pages/platforms.php' );
  	} // [x] function viewport_size_importer_create_dashboard() { ... }


	function viewport_size_create_browsers() {
		include_once( 'pages/browsers.php' );
  	} // [x] function viewport_size_importer_create_dashboard() { ... }

	function viewport_size_create_viewport() {
		include_once( 'pages/viewport.php' );
  	} // [x] function viewport_size_importer_create_dashboard() { ... }
	
	function viewport_size_create_etorox() {
		include_once( 'pages/etorox.php' );
  } // [x] function viewport_size_importer_create_dashboard() { ... }


} // [x] class viewport_size { ... }

// 🅽 Instantiate plugin's class
$GLOBALS['viewport_size'] = new viewport_size();
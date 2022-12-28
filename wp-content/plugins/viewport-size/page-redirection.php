<?php
	
/*
Plugin Name: 🅽 Page Redirection Plugin
Description: Page Redirection Plugin with data visualization and dark mode.
Version: 1 (alfa)
Author: 🅽 Sergey Nadolskiy
Author URI: https://www.linkedin.com/in/sergeynadolskiy
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require plugin_dir_path( __FILE__ ) . 'functions/global-functions.php';

// 🅽 Path to the plugin directories
define('PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('PLUGIN_URL', plugin_dir_url(__FILE__));

class page_redirection {
 
	// Initializes the plugin by setting localization, filters, and administration functions.
	function __construct() {
		add_action('admin_menu', array( &$this,'page_notification_register_menu') );
	} // [x] function __construct() { ... } 
 
	// Adding to the wp menu
	function page_notification_register_menu() {
		add_menu_page( 'Redirect Plugin', 'Redirect Plugin', 'read', 'page_redirection', array( &$this, 'page_redirection_create_dashboard' ), 'dashicons-admin-links' );
	} // [x] function page_notification_register_menu() { ... }
	
	
    function page_redirection_create_dashboard() {
  	    include_once( 'pages/dashboard.php' );
	} // [x] function page_redirection_importer_create_dashboard() { ... }


} // [x] class page_redirection { ... }

// 🅽 Instantiate plugin's class
$GLOBALS['page_redirection'] = new page_redirection();
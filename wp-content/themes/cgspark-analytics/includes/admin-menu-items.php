<?php 

if( function_exists('acf_add_options_page') ) {
	
  // Site content
	acf_add_options_page(array(
		'page_title' 	=> 'Site content',
		'menu_title'	=> 'Site Content',
		'menu_slug' 	=> 'site-content',
    'position' 		=> 2,
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

  // Assets
  acf_add_options_page(array(
		'page_title' 	=> 'All assets',
		'menu_title'	=> 'Assets',
		'menu_slug' 	=> 'all-assets',
    'position' 		=> 6,
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
    'icon_url'    => 'dashicons-star-half',
	));
	
}
?>

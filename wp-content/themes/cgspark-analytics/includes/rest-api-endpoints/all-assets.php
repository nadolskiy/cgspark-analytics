<?php 

add_action('rest_api_init', function () {
  register_rest_route( 'crypto-assets/v1', 'all-assets',array(
    'methods'  => 'GET',
    'callback' => 'get_all_assets',
  ));
});

function get_all_assets() {
  $all_assets = array();
  $assets_short_names = array();

  $assets_response = get_field('add_assets', 'option');

  // Create array with all short names
  foreach ($assets_response as $asset) {
    array_push($assets_short_names, $asset['asset_short_name']);
  }

  // Update asset object
  foreach ($assets_response as $asset) {
    $asset_short_name = strtoupper($asset['asset_short_name']);
  
    // Continue here
    if(in_array($asset_short_name, $assets_short_names)) {
      if(function_exists('iconize_coin')) {
        if(iconize_coin($asset_short_name)->full_name != 'no asset found') {
          $asset['icon'] = iconize_coin($asset_short_name)->src;
        } else {
          $asset['icon'] = iconize_plug();
        }
      }
    }

    array_push($all_assets, $asset);
  }

  $response = new WP_REST_Response(array('all_assets' => $all_assets));
  $response->set_status(200);

  return $response;
}

?>
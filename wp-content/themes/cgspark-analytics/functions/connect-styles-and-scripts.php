<?php

function connect_styles($pages_array) {
    $tmpl_uri         = get_template_directory_uri() . '/assets/';
    $static_css_url   = $tmpl_uri . 'css/';
    $static_fonts_url = $tmpl_uri . 'fonts/';

    foreach ($pages_array as $page_styles) {
        if($page_styles['if']) {
            if(count($page_styles['css'])) {
                foreach($page_styles['css'] as $css_link) {
                    wp_enqueue_style( $page_styles['page_name'], $static_css_url . $css_link, array(), CACHE_VERSION, 'all' ); 
                }
            }

            if(count($page_styles['mobile_styles']) && IS_MOBILE) {
                foreach ($page_styles['mobile_styles'] as $mobile_css_link) {
                    wp_enqueue_style( 'mobile-' . $page_styles['page_name'], $static_css_url . $mobile_css_link, array(), CACHE_VERSION, 'all' );
                }
            }

            if(count($page_styles['preload_fonts'])) {
                foreach($page_styles['preload_fonts'] as $preload_font_link) {
                    echo '<link rel="preload" href="'. $static_fonts_url .''. $preload_font_link .'" as="font" type="font/woff2" crossorigin>';
                }
            }
            
            break;
        }
    }
}

function connect_scripts($pages_array) {
    $tmpl_uri      = get_template_directory_uri() . '/assets/';
    $static_js_url = $tmpl_uri . 'js/';

    wp_enqueue_script('jquery');
    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );
    wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

    foreach ($pages_array as $page_scripts) {

        
        if($page_scripts['if']) {
            if(count($page_scripts['scripts'])) {
                foreach($page_scripts['scripts'] as $js_link) {
                    wp_enqueue_script( 'scripts-' . $page_scripts['page_name'], $static_js_url . $js_link, array('jquery'), CACHE_VERSION, true); 

                    add_filter( 'script_loader_tag', 'defer', 10, 3 );
                }
            }
            
            break;
        }
    }
}

function defer( $tag, $handle, $src ) {
    return str_replace( ' src', ' defer src', $tag );
}
<?php

class Styles_Array_Factory {
    public function get_styles_array(string $page_name, array $css, array $preload_fonts, array $mobile_styles) {
        return [
            'page_name' => $page_name,
            'if' => is_page_template("templates/$page_name-page.php"),
            'css' => $css,
            'preload_fonts' => $preload_fonts,
            'mobile_styles' => $mobile_styles
        ];
    }
}

$factory = new Styles_Array_Factory();

$home_styles = $factory->get_styles_array('home', 
    ['general.min.css'],
    [],
    ['mobile.min.css']
);

$about_styles = $factory->get_styles_array('about', 
    ['test-css-about'],
    [],
    []
);

$all_pages_styles = [
    $home_styles,
    $about_styles
];

connect_styles($all_pages_styles);

?>
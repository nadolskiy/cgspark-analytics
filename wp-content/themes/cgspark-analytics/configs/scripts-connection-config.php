<?php

class Scripts_Array_Factory {
    public function get_scripts_array(string $page_name, array $script) {
        return [
            'page_name' => $page_name,
            'if' => is_page_template("templates/$page_name-page.php"),
            'scripts' => $script,
        ];
    }
}

$factory = new Scripts_Array_Factory();

$home_scripts = $factory->get_scripts_array('home', 
    ['home/home.min.js']
);

$all_pages_scripts = [
    $home_scripts,
];

connect_scripts($all_pages_scripts);

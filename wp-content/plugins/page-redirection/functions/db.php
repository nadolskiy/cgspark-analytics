<?php

extract($_GET);
extract($_POST);

include_once 'helpers/abspath.php';
include_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

rp_check_the_tables();

$action = $_GET['action'];
$action = ($action == '') ? $_POST['action'] : $action;

if (isset($action)) {
	switch ($action) {
		case 'add':
			add_redirection_to_db($source_url, $target_url, $query_parameter);
			break;
		
		case 'get':
			get_all_redirects();
			break;

		case 'remove':
			remove_redirection_db($source_url);

		case 'counter':
			get_all_counters();
			break;

		// case 'get_all_approved_images':
		// 	get_all_approved_images();
		// 	break;

		// case 'add_redirect_to_approved':
		// 	add_redirect_to_approved($approved_redirect);
		// 	break;

		// case 'add_the_new_icon_to_db':
		// 	add_the_new_icon_to_db();
		// 	break;

		// case 'remove_redirect_from_approved':
		// 	remove_redirect_from_approved($redirect_to_remove_from_approved);
		// 	break;

		// case 'upload':
		// 	save_manual_image_to_the_db();
		// 	break;
		// case 'check_for_updates':
		// 	check_for_updates();
		// 	break;

		default:
			// echo 'this';
			#
			// if (isset($action_to_do) && isset($redirect_name)) {

			// 	if ($action_to_do === 'upload') {
			// 		save_manual_image_to_the_db();
			// 	} # [x] if ($action_to_do === 'upload') { ... }

			// } # [x] if (isset($action_to_do) && isset($redirect_name)) { ... }

			break;
	}
}

/*  🅽 Checking if the table exist, if not - create it. */
function rp_check_the_tables() {

	global $wpdb;
	// $wpdb->show_errors();
	// $wpdb->print_error();

	# Tables names
	$list_of_tables_names = array(

		// Statistic
		get_the_table_name('statistic'),
		
		// Redirection
		get_the_table_name('redirection'),

	);

	# Tables structure
	$list_of_tables_structure = array(

		// Statistic
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2020-11-11',
        count int,
		PRIMARY KEY (id)",

		// Redirection
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
		source_url tinytext,
		target_url tinytext,
		query tinytext,
		count int,
		last_redirect_date datetime DEFAULT '2020-11-11 11:11:11',
		PRIMARY KEY (id)",
	);


	# Go throw all tables
	for ($i=0; $i < count($list_of_tables_names); $i++) { 
		
		$checking_table_name = $list_of_tables_names[$i];

		# If there is no table in DB
		if($wpdb->get_var("SHOW TABLES LIKE '$checking_table_name'") != $checking_table_name) { 
        
			# Creating the new table
			$charset_collate = $wpdb->get_charset_collate();

			$sql= "CREATE TABLE $checking_table_name ($list_of_tables_structure[$i]) $charset_collate;";
			
			dbDelta( $sql ); 
	
		}  // [x] if there is no table in DB

	} # go throw all tables

} # pr_check_the_tables() { ... }


function get_the_table_name($table_short_name) {
	
	global $wpdb;

	$table_full_name = $wpdb->prefix;

	switch ($table_short_name) {

		case 'statistic':
			$table_full_name .= 'pr_statistic';
			break;
		
		case 'redirection':
			$table_full_name .= 'pr_redirection';
			break;

		default:
			return false;
			break;

	}
		
	return $table_full_name;

} # [x] get_table_name($table_short_name) { ... }


function add_redirection_to_db($source_url, $target_url, $query_parameter) {

	global $wpdb;

	$target_url = trim(strtolower($target_url));
	$target_url = substr( $target_url, 0, 1 ) === "/" ? get_site_url() . $target_url : $target_url;


	
	$data   = array(
        source_url          => rtrim(trim(strtolower($source_url)), '/'),
		target_url          => $target_url, 
		query               => $query_parameter,
		count               => 0,
		last_redirect_date  => gmdate("Y-m-d H:i:s")
	); # $data = array();

	$rp_table_with_redirection = get_the_table_name('redirection');
    $result = $wpdb->insert( $rp_table_with_redirection, $data);

	echo $result;

} # add_redirection_to_db() { ... }

function get_all_redirects() {

    global $wpdb;

    $table_full_name = get_the_table_name('redirection');
    $all_redirects = $wpdb->get_results("SELECT * FROM $table_full_name ORDER BY `source_url`");

    $data_array = array();

    foreach ($all_redirects as $redirect) {
		
		$db_source_url  = $redirect->source_url;
        $db_target_url  = $redirect->target_url ;
        $db_query       = $redirect->query;
        $db_count       = $redirect->count;
        $db_last_date   = $redirect->last_redirect_date;


        switch ($db_query) {
            case '0':
                $db_query = 'Exact match all parameters in any order';
                break;

            case '1':
                $db_query = 'Ignore all parameters';
                break;

            case '2':
                $db_query = 'Add new redirection';
                break;

            default:
                break;
        }

        // Get First Source Letter
        $first_latter = substr($db_source_url, 0, 1); 
        $data_array[$first_latter] = $data_array[$first_latter] . '~[*]~'. $db_source_url . '~[+]~' . $db_target_url . '~[+]~'. $db_query . '~[+]~' . $db_count . '~[+]~' . $db_last_date;

	} // [x] go throw all redirects
    
    $html_alphabet = '';

    $uid = 0;

    foreach ($data_array as $letter => $value) {
        
        $html_alphabet  .= '<a class="rp-list-alphabet--link" href="#section-letter--'.$letter.'">'.strtoupper($letter).'</a> ∙ ';

        $html_redirect = '';
        $redirects = explode('~[*]~', $value);


        foreach ($redirects as $redirect) {
            $redirect_data  = explode('~[+]~', $redirect);
            if ($redirect_data[0]) {
                $uid++;
                $html_redirect .= 
                '<div class="pr-redirect-container" data-aos="fade-up">' .
                    '<div class="pr-redirect-source-url">'.$redirect_data[0].'</div>'.
                    '<div class="pr-redirect-data">'.
                        '<div class="pr-redirection-group">'.
                            '<div class="pr-redirect-target-url"><span>Redirect to: </span><a href="'.$redirect_data[1].'">'.$redirect_data[1].'</a></div>'.
                            '<div class="pr-redirect-query-parameters"><span>Query: </span>'.$redirect_data[2].'</div>'.
                            '<div class="pr-redirect-last-redirection"><span>Last redirection: </span>'.$redirect_data[4].'</div>'.
                            '<div class="pr-buttons">'.
                                '<div data-source="'.$redirect_data[0].'" data-target="'.$redirect_data[1].'" id="pr-button-remove--'.$uid.'" class="pr-button pr-button--remove">Remove</div>'.
                            '</div>'.
                        '</div>'.
                        '<div class="pr-redirect-count"><span>redirected</span>'.$redirect_data[3].'<span>times</span></div>'.
                    '</div>'.
                '</div>';
            }
        }


        $html_container .= '<div id="section-letter--'.$letter.'" class="rp-list-alphabet--section"><h3>'.strtoupper($letter).'</h3><div id="rp-list-alphabet-container--'.$letter.'" class="rp-list-alphabet-container">'.$html_redirect.'</div></div>';
    }

   
    $html_alphabet = rtrim($html_alphabet, " ∙ ");


    echo 
    '<div class="rp-list">
        <div class="rp-list-alphabet">'.$html_alphabet.'</div><!-- .rp-list-alphabet -->
        <div id="rp-list-redirection" class="rp-list-redirection"> '.$html_container.'

        </div>
    </div> <!-- .rp-list -->';




    

} # get_all_redirects() {..}


function get_all_counters() {
	global $wpdb;

    $table_full_name = get_the_table_name('statistic');

	$period = $wpdb->get_results("SELECT (SELECT sum(count) FROM $table_full_name) as whole, (SELECT sum(count) FROM $table_full_name WHERE YEAR(date) = YEAR(CURDATE())) as year, (SELECT sum(count) FROM $table_full_name WHERE MONTH(date) = MONTH(CURDATE())) as month, (SELECT sum(count) FROM $table_full_name WHERE yearweek(DATE(date), 1) = yearweek(curdate(), 1)) as week, (SELECT sum(count) FROM $table_full_name WHERE DATE(date) = CURDATE()) as day");

	$day = $period[0]->day;
	$day = $day ? $day : 0;
	$week = $period[0]->week;
	$week = $week ? $week : 0;
	$month = $period[0]->month;
	$month = $month ? $month : 0;
	$year = $period[0]->year;
	$year = $year ? $year : 0;
	$whole = $period[0]->whole;
	$whole = $whole ? $whole : 0;

	echo $day . '~[N]~' . $week . '~[N]~' .$month . '~[N]~' . $year. '~[N]~' . $whole;

}

// Remove redirection from the DB
function remove_redirection_db($source_url) {
	global $wpdb;
	$wpdb->delete( get_the_table_name('redirection'), array( 'source_url' => $source_url ) );

}
// update_redirection_db()
// check_redirection_db()
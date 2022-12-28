<?php
include_once 'helpers/abspath.php';
include_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

// ///////// //////// /////
vps_check_all_tables();

if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = '';
}
if (isset($_GET['function'])) {
	$page = $_GET['function'];
} else {
	$page = '';
}

if ($action) {
    if ($action === 'viewport_size') {
        switch ($page) {
            case 'platform':
                getPlatformData('general');
                break;

            case 'platform_graph':
                getPlatformGraphData('general', 'devices');
                break;

            case 'platform_graph_period':
                getPlatformGraphPeriodData('general', 'devices');
                break;
            
            case 'platform_all':
                getPlatformAllData('general', 'devices');
            default:
                # code...
                break;
        }
    } else if ($action === 'viewport_size_etorox') {
        switch ($page) {
            case 'platform':
                getPlatformData('eToroX');
                break;

            case 'platform_graph':
                getPlatformGraphData('eToroX','devices');
                break;

            case 'platform_graph_period':
                getPlatformGraphPeriodData('eToroX', 'devices');
                break;
            
            case 'platform_all':
                getPlatformAllData('eToroX', 'devices');
                break;

            case 'top_browsers':
                getTopBrowsers('eToroX');
                break;

            case 'browser_graph':
                getPlatformGraphData('eToroX','browsers');
                break;

            case 'browser_graph_period':
                getPlatformGraphPeriodData('eToroX', 'browsers');
                break;
            case 'browser_all':
                getPlatformAllData('eToroX', 'browsers');
                break;

                // ViewPort
            case 'top_3_desktop_width':
                getTopWidths('etorox');
                break;
            case 'width_graph':
                getPlatformGraphData('eToroX','viewport');
                break;
            case 'width_graph_period':
                getPlatformGraphPeriodData('eToroX', 'viewport');
                break;
            case 'width_all':
                getPlatformAllData('eToroX', 'viewport');
                break;

            default:
                # code...
                break;
        }
    } else if ($action === 'viewport_size_browsers') {
        switch ($page) {
            case 'top_browsers':
                getTopBrowsers('general');
                break;

            case 'browser_graph':
                getPlatformGraphData('general', 'browsers');
                break;

            case 'browser_graph_period':
                getPlatformGraphPeriodData('general', 'browsers');
                break;
            case 'browser_all':
                getPlatformAllData('general', 'browsers');
                break;
            
            default:
                # code...
                break;
        }
    } 
    
    /* ViewPort */
    else if ($action === 'viewport_size_viewport') {
        switch ($page) {
            case 'top_3_desktop_width':
                getTopWidths('global');
                break;
            case 'width_graph':
                getPlatformGraphData('general','viewport');
                break;
            case 'width_graph_period':
                getPlatformGraphPeriodData('general', 'viewport');
                break;
            case 'width_all':
                getPlatformAllData('general', 'viewport');
                break;
            
            
            default:
                # code...
                break;
        }
    } /* [x] ViewPort */
}



// Select Action
if (isset($action)) {
	switch ($action) {
		case 'add':
			add_new_to_db($_GET['site'], $_GET['viewport_size'], $_GET['browser'], $_GET['browser_version'], $_GET['device_type'], $_GET['user_agent']);
			break;
		
		case 'viewport_size':
            // get_all_data('general');
			break;
        case 'viewport_size_etorox':
            // echo 'eToroX';
            break;

		// case 'remove':
		// 	remove_redirection_db($source_url);

		// case 'counter':
			// get_all_counters();
			// break;

		default:
			break;
	}
} // [x] if (isset($action)) { ... }

/*  🅽 Checking if the table exist, if not - create it. */
function vps_check_all_tables() {

	global $wpdb;

	# Tables names
	$list_of_tables_names = array(

        # User Agents #
        get_the_table_name('user_agent'),

        # GLOBAL #
    
		// Global viewport by date
		get_the_table_name('global_viewport'),
        // Global browsers by date
		get_the_table_name('global_browsers'),
        // Global devices by date
		get_the_table_name('global_devices'),
        
        # ETOROX #

        // Global viewport by date
		get_the_table_name('etorox_viewport'),
        // Global browsers by date
		get_the_table_name('etorox_browsers'),
        // Global devices by date
		get_the_table_name('etorox_devices')

	);

	# Tables structure
	$list_of_tables_structure = array(

        # User Agent #
        "id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_agent TEXT,
        count int,
		PRIMARY KEY (id)",

		# GLOBAL #

        // Global viewport by date
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        width int,
        height int,
        count int,
		PRIMARY KEY (id)",

        // Global browsers by date
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        browser tinytext,
        browser_version tinytext,
        count int,
		PRIMARY KEY (id)",

        // Global devices by date
        "id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        device tinytext,
        count int,
		PRIMARY KEY (id)",

		# ETOROX #

        // eToroX viewport by date
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        width int,
        height int,
        count int,
		PRIMARY KEY (id)",

        // eToroX browsers by date
		"id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        browser tinytext,
        browser_version tinytext,
        count int,
		PRIMARY KEY (id)",

        // eToroX devices by date
        "id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '2021-12-12',
        device tinytext,
        count int,
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

        # USER AGENT #
        case 'user_agent':
            $table_full_name .= 'vps_user_agent';
            break;

        # GLOBAL #

        // Global viewport by date
		case 'global_viewport':
			$table_full_name .= 'vps_global_viewport';
			break;
		
        // Global browsers by date
        case 'global_browsers':
            $table_full_name .= 'vps_global_browsers';
            break;

        // Global devices by date
        case 'global_devices':
            $table_full_name .= 'vps_global_devices';
            break;

        # eToroX #

        // eToroX viewport by date
		case 'etorox_viewport':
			$table_full_name .= 'vps_etorox_viewport';
			break;
		
        // eToroX browsers by date
        case 'etorox_browsers':
            $table_full_name .= 'vps_etorox_browsers';
            break;

        // eToroX devices by date
        case 'etorox_devices':
            $table_full_name .= 'vps_etorox_devices';
            break;

		default:
			return false;
			break;

	}
		
	return $table_full_name;

} # [x] get_table_name($table_short_name) { ... }


function add_item_to_db($table, $value, $browser_version, $type) {
    
    global $wpdb;

    if ($type === 'viewport_size') {
        $size = explode('x', $value);
        $width = $size[0];
        $height = $size[1];
    }


    // Get count
    if ($browser_version) 
    {
        $db_count = $wpdb->get_row("SELECT count, id FROM $table WHERE $type LIKE '$value' AND browser_version LIKE $browser_version AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())");
    } 
    else if ($type === 'user_agent') 
    {
        $db_count = $wpdb->get_row("SELECT count, id FROM $table WHERE $type LIKE '$value'");
    } 
    else if ($type === 'viewport_size') 
    {
        $db_count = $wpdb->get_row("SELECT count, id FROM $table WHERE `width` LIKE '$width' AND `height` LIKE '$height'");
    } 
    else 
    {
        $db_count = $wpdb->get_row("SELECT count, id FROM $table WHERE $type LIKE '$value' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())");
    }

    // Count exist - need to update
    if ($db_count) {
        
        $count = intval($db_count->count) + 1;
        $data_to_update = array(
            "count" => $count
        );

        $where_to_update = array(
            "id" => $db_count->id
        );

        $wpdb->update( $table, $data_to_update, $where_to_update);

    } // [x] count exist - need to update
    
    // No count - need to add new item
    else 
    {
        switch ($type) 
        {    
            case 'viewport_size':
                $data_to_insert = array(
                    "date" => gmdate("Y-m-d"),
                    "width" => $width,
                    "height" => $height,
                    "count" => 1
                );
                break;

            case 'browser':
                $data_to_insert = array(
                    "date" => gmdate("Y-m-d"),
                    "browser" => $value,
                    "browser_version" => $browser_version,
                    "count" => 1
                );
                break;

            case 'device':
                $data_to_insert = array(
                    "date" => gmdate("Y-m-d"),
                    "device" => $value,
                    "count" => 1
                );
                break;

            case 'user_agent':
                $data_to_insert = array(
                    "user_agent" => $value,
                    "count" => 1
                );
                break;
            
            default:
                $data_to_insert = array();
                break;
        }
      
        $wpdb->insert($table, $data_to_insert);
    } // [x] no count

};

function add_new_to_db($site, $viewport_size, $browser, $browser_version, $device_type, $user_agent) {

    // Add info to the site db
    switch ($site) {
        case 'etorox':
            add_item_to_db(get_the_table_name('etorox_viewport'), $viewport_size, false, 'viewport_size');
            add_item_to_db(get_the_table_name('etorox_browsers'), $browser, $browser_version, 'browser');
            add_item_to_db(get_the_table_name('etorox_devices'), $device_type, false, 'device');
            break;
        
        default:
            # code...
            break;
    }

    // Add info to the global db
    add_item_to_db(get_the_table_name('global_viewport'), $viewport_size, false, 'viewport_size');
    add_item_to_db(get_the_table_name('global_browsers'), $browser, $browser_version, 'browser');
    add_item_to_db(get_the_table_name('global_devices'), $device_type, false, 'device');
    
    // Add info to the user agent
    add_item_to_db(get_the_table_name('user_agent'), $user_agent, false, 'user_agent');

} # add_new_to_db() { ... }


function get_all_data($site) {
    // echo $site; // TODO: remove

    global $wpdb;

    switch ($site) {
        case 'general':
            $table_browsers_name    = 'global_browsers';
            $table_device_name      = 'global_devices';
            $table_viewport_name    = 'global_viewport';
            break;

        case 'eToroX':
            $table_browsers_name    = 'etorox_browsers';
            $table_device_name      = 'etorox_devices';
            $table_viewport_name    = 'etorox_viewport';
            break;
        
        default:
            # code...
            break;
    }

    $table_devices  = get_the_table_name($table_device_name);
    $table_browsers = get_the_table_name($table_browsers_name);
    $table_viewport = get_the_table_name($table_viewport_name);

    $all_devices = $wpdb->get_results("SELECT * FROM $table_devices ORDER BY count*1 DESC");
    
    $years = array();
    foreach ($all_devices as $device => $value) {
        $year = explode("-", $value->date);
        if(!in_array($year[0], $years, true)){
            array_push($years, $year[0]);
        }
    }
    rsort($years);
   
    $html = '
    <div class="title_row">
        <h2 class="sub-title">Devices</h2>
        <div class="list_of_devices">
            <div class="list_of_years">
                <span id="all_years" class="year-all year active_year">All Data</span>';
                foreach ($years as $year) {
                    $html .= '<span id="year--'.$year.'" class="year">'.$year.'</span>';
                }
    $html .= '
            </div>
        <div class="device_analytics">
            <div class="device_table_graph">
                
            </div>
            <div class="device_table_list">List</div>
        </div>';


    $html .= '</div>';
    $html .= '</div>';


    echo $html;


    var_dump($all_devices);
} // [x] function get_all_data(site) { ... }


function getPlatformData($site) {

    global $wpdb;
    if ($site === 'general') {
        $table_platform  = get_the_table_name('global_devices');
    } else if ($site === 'eToroX') {
        $table_platform  = get_the_table_name('etorox_devices');
    }

    $top_3_platforms = $wpdb->get_results("SELECT device, SUM(count) FROM $table_platform GROUP BY `device` ORDER BY count*1 DESC LIMIT 3");
    $all_platforms_count = (array) $wpdb->get_row("SELECT sum(count) FROM $table_platform");
    $all_count = $all_platforms_count['sum(count)'];
    $delay = 150*(count($top_3_platforms)-1);
    
    foreach ($top_3_platforms as $platform => $data) {
        $data = get_object_vars($data);
        $platform = trim($data['device']);
        $platform = $platform ? $platform : 'Other';
        $count = intval($data['SUM(count)']);
        $percent = round(($count / $all_count) * 100, 2);
        $platform_image = strtolower(str_replace(' ', '_', $platform));
        echo ' <div class="platform box-container bg-'.strtolower($platform).'" data-aos="fade-right" data-aos-delay="'.$delay.'">
        <p class="box--sub-title">most used platform</p>
        <div class="box-container--title">
            <p class="box--title">'.$platform.'</p>
            <img src="'.PLUGIN_URL.'assets/img/logo_'.$platform_image.'.svg" alt="'.$platform.'">
        </div>
        <p class="box--count">'.$count.' <span>users</span></p>
            <p class="box--percent"><span>'.$percent .'%</span> of all users</p>

    </div> <!-- .platform box-container --> ';
    $delay -= 150;
    }

}

function getPlatformGraphData($site, $needed_table_name) {

    global $wpdb;
    if ($site === 'general') {
        $table_platform  = get_the_table_name('global_'.$needed_table_name);
    } else if ($site === 'eToroX') {
        $table_platform  = get_the_table_name('etorox_'.$needed_table_name);
    }

    if ($needed_table_name === 'devices') {
        $top_platforms = $wpdb->get_results("SELECT *, SUM(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `device` ORDER BY SUM(count)*1 DESC LIMIT 7");
    } else if ($needed_table_name === 'browsers') {
        $top_platforms = $wpdb->get_results("SELECT *, SUM(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `browser` ORDER BY SUM(count)*1 DESC LIMIT 7");
    } else if ($needed_table_name === 'viewport') {
        $top_platforms = $wpdb->get_results("SELECT *, SUM(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `width` ORDER BY SUM(count)*1 DESC LIMIT 10");
    }

    $graph_data = array();
    foreach ($top_platforms as $platform => $data) {
        $data = get_object_vars($data);

        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);        
        } else if ($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if ($needed_table_name === 'viewport') {
            $platform = trim($data['width'])."px";
        }
        $platform = $platform ? $platform : 'Other';
        $graph_data[$platform] = $data['SUM(count)'];
    }
    echo json_encode($graph_data);

}


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

	// echo $day . '~[N]~' . $week . '~[N]~' .$month . '~[N]~' . $year. '~[N]~' . $whole;

}

function getPlatformGraphPeriodData($site, $needed_table_name) {
    
    global $wpdb;
    if ($site === 'general') {
        $table_platform  = get_the_table_name('global_'.$needed_table_name);
    } else if ($site === 'eToroX') {
        $table_platform  = get_the_table_name('etorox_'.$needed_table_name);
    }

    
    if ($needed_table_name === 'devices') {
        $top_platforms = $wpdb->get_results("SELECT device, count, MONTH(date) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) ORDER BY count*1 DESC LIMIT 7");
    } else if ($needed_table_name === 'browsers') {
        $top_platforms = $wpdb->get_results("SELECT browser, sum(count), MONTH(date) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY browser ORDER BY sum(count)*1 DESC LIMIT 7");
    } else if ($needed_table_name === 'viewport') {
        $top_platforms = $wpdb->get_results("SELECT width, sum(count), MONTH(date) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY width ORDER BY sum(count)*1 DESC LIMIT 10");
    }

    

    $graph_data = array();
    foreach ($top_platforms as $platform => $data) {
        $data = get_object_vars($data);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
            $platform = $platform ? $platform : 'Other';
            $graph_data[$data['MONTH(date)']][$platform] = $data['count'];
        } else if ($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
            $platform = $platform ? $platform : 'Other';
            $graph_data[$data['MONTH(date)']][$platform] = $data['sum(count)'];
        } else if ($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
            $platform = $platform ? $platform : 'Other';
            $graph_data[$data['MONTH(date)']][$platform] = $data['sum(count)'];
        }
        
    }
    echo json_encode($graph_data);
}


function getPlatformAllData($site, $needed_table_name) {
    global $wpdb;
    if ($site === 'general') {
        $table_platform  = get_the_table_name('global_'.$needed_table_name);
    } else if ($site === 'eToroX') {
        $table_platform  = get_the_table_name('etorox_'.$needed_table_name);
    }

    // Platforms
    if ($needed_table_name === 'devices') 
    {
        // All for all years
        $all_platforms_names = $wpdb->get_results("SELECT device, sum(count) FROM $table_platform GROUP BY `device` ORDER BY count*1 DESC");
        // All for 1 year
        $all_platforms_names_year = $wpdb->get_results("SELECT device, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `device` ORDER BY count*1 DESC");
        // Current month
        $all_platforms_names_month = $wpdb->get_results("SELECT device, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) GROUP BY `device` ORDER BY count*1 DESC");
        // Previous month
        $all_platforms_names_prev_month = $wpdb->get_results("SELECT device, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-1 GROUP BY `device` ORDER BY count*1 DESC");
        // All count
        // $all_platforms_count = (array) $wpdb->get_row("SELECT sum(count) FROM $table_platform");
        // $all_count = $all_platforms_count['sum(count)'];
    } 
    
    else if ($needed_table_name === 'browsers') {

        // All for all years
        $all_platforms_names = $wpdb->get_results("SELECT browser, sum(count) FROM $table_platform GROUP BY `browser` ORDER BY sum(count)*1 DESC");

        $all_platforms_names_year = $wpdb->get_results("SELECT browser, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `browser` ORDER BY sum(count)*1 DESC");

        // Current month
        $all_platforms_names_month = $wpdb->get_results("SELECT browser, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) GROUP BY `browser` ORDER BY sum(count)*1 DESC");

        // Previous month
        $all_platforms_names_prev_month = $wpdb->get_results("SELECT browser, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-1 GROUP BY `browser` ORDER BY count*1 DESC");

        $all_platforms_names_prev_prev_month = $wpdb->get_results("SELECT browser, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-2 GROUP BY `browser` ORDER BY count*1 DESC");

    }

    // ViewPort
    else if ($needed_table_name === 'viewport') {

        // All for all years
        $all_platforms_names = $wpdb->get_results("SELECT width, sum(count) FROM $table_platform GROUP BY `width` ORDER BY sum(count)*1 DESC");

        
        $all_platforms_names_year = $wpdb->get_results("SELECT width, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) GROUP BY `width` ORDER BY sum(count)*1 DESC");
        
        // Current month
        $all_platforms_names_month = $wpdb->get_results("SELECT width, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) GROUP BY `width` ORDER BY sum(count)*1 DESC");
        
        // Previous month
        $all_platforms_names_prev_month = $wpdb->get_results("SELECT width, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-1 GROUP BY `width` ORDER BY count*1 DESC");
        
        $all_platforms_names_prev_prev_month = $wpdb->get_results("SELECT width, sum(count) FROM $table_platform WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-2 GROUP BY `width` ORDER BY count*1 DESC");

    }

    // All count
    $all_platforms_count = (array) $wpdb->get_row("SELECT sum(count) FROM $table_platform");
    $all_count = $all_platforms_count['sum(count)'];
   

    $data_for_year = array();

    // Get data for current year
    foreach ($all_platforms_names_year as $key => $value) {
        $data = get_object_vars($value);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
        } else if($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
        } 

        
        $platform = $platform ? $platform : 'Other';
        $data_for_year[$platform] = $data['sum(count)'];
    }
    
    $data_for_months = array();
    // Get data for the current month
    foreach ($all_platforms_names_month as $key => $value) {
        $data = get_object_vars($value);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
        } else if($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
        }
        $platform = $platform ? $platform : 'Other';
        $data_for_months[$platform] = $data['sum(count)'];
    }

    $data_for_prevent_months = array();
    
    // Get data for the prevent months
    foreach ($all_platforms_names_prev_month as $key => $value) {
        $data = get_object_vars($value);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
        } else if($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
        }
        $platform = $platform ? $platform : 'Other';
        $data_for_prevent_months[$platform] = $data['sum(count)'];
    }

    $data_for_prevent_prevent_months = array();
    // Get data for the prevent prevent months
    foreach ($all_platforms_names_prev_prev_month as $key => $value) {
        $data = get_object_vars($value);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
        } else if($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
        }
        $platform = $platform ? $platform : 'Other';
        $data_for_prevent_prevent_months[$platform] = $data['sum(count)'];
    }
    
    $counter = 0;

    foreach ($all_platforms_names as $key => $value) {


        $data = get_object_vars($value);
        if ($needed_table_name === 'devices') {
            $platform = trim($data['device']);
        } else if($needed_table_name === 'browsers') {
            $platform = trim($data['browser']);
        } else if($needed_table_name === 'viewport') {
            $platform = trim($data['width']);
        }
        


        $platform = $platform ? $platform : 'Other';
        $count_for_year = $data_for_year[$platform];
        $count_for_year = $count_for_year ? $count_for_year : 0;
        $count_for_month = $data_for_months[$platform];
        $count_for_month = $count_for_month ? $count_for_month : 0;
        $count_for_prevent_month = $data_for_prevent_months[$platform];
        $count_for_prevent_month = $count_for_prevent_month ? $count_for_prevent_month : 0;
        $count_for_prevent_prevent_month = $data_for_prevent_prevent_months[$platform];
        $count_for_prevent_prevent_month = $count_for_prevent_prevent_month ? $count_for_prevent_prevent_month : 0;
        
        $progress = intval($count_for_prevent_month) - intval($count_for_prevent_prevent_month);
        
        if ($progress === 0) {
            $color = 'gray';
            $symbol = '&#8645;';
        } else if($progress > 0) {
            $color = 'green';
            $symbol = '&uarr; +';
        } else {
            $color = 'red';
            $symbol = '&darr;';
        }
        $percent = round(($data['sum(count)'] / $all_count) * 100, 2);

        if ($needed_table_name === 'viewport') {
            if (intval($platform) < ) {

            } else if () {

            } else {

            }
            $image_name = strtolower(str_replace(' ', '_', $platform));
        } else {
            $image_name = strtolower(str_replace(' ', '_', $platform));
        }


        if ($needed_table_name === 'devices' || $needed_table_name === 'viewport') {
            echo 
            '<div class="platform-data platform-data-list"  data-aos="fade-right">
                <div class="platform-column platform-column--name"><img src="'.PLUGIN_URL.'assets/img/logo_'.$image_name.'.svg" alt="'.$platform.'">'.$platform.'</div>
            <div class="platform-column '.$color.'">'.$symbol.' '.$progress.'</div>
            <div class="platform-column green">+'.$count_for_month.'</div>
            <div class="platform-column">'.$count_for_year.'</div>
            <div class="platform-column">'.$data['sum(count)'].'</div>
            <div class="platform-column platform-column--progress"><div class="progress-container"><span class="progress" style="width:'.$percent.'%;"></span></div>'.$percent.'%</div>
                </div>';
        } 
        
        else if($needed_table_name === 'browsers') {
            if ($platform != 'Other') {
            
                // Browser versions
                $browser_lowest_version = $wpdb->get_results("SELECT browser_version FROM $table_platform WHERE browser LIKE '$platform' ORDER BY browser_version*1 ASC LIMIT 1");
                $browser_lowest_version = $browser_lowest_version[0]->browser_version;
                $browser_highest_version = $wpdb->get_results("SELECT browser_version FROM $table_platform WHERE browser LIKE '$platform' ORDER BY browser_version*1 DESC LIMIT 1");
                $browser_highest_version = $browser_highest_version[0]->browser_version;

                $browser_versions = $browser_lowest_version.' - '.$browser_highest_version;

                if ($browser_lowest_version === $browser_highest_version) {
                    $browser_versions = $browser_highest_version;
                }

                echo 
                '<div class="platform-data browser-data platform-data-list pointer"  data-aos="fade-right" data-id="'.$counter.'">
                    <div class="platform-column platform-column--name"><img src="'.PLUGIN_URL.'assets/img/logo_'.$image_name.'.svg" alt="'.$platform.'">'.$platform.'</div>
                <div class="platform-column">'.$browser_versions.'</div>
                <div class="platform-column '.$color.'">'.$symbol.' '.$progress.'</div>
                <div class="platform-column green">+'.$count_for_month.'</div>
                <div class="platform-column">'.$count_for_year.'</div>
                <div class="platform-column">'.$data['sum(count)'].'</div>
                <div class="platform-column platform-column--progress"><div class="progress-container"><span class="progress" style="width:'.$percent.'%;"></span></div>'.$percent.'%</div>
                    </div>';
                
                // Browser data for the all period
                $browser_data_whole_period = $wpdb->get_results("SELECT * FROM $table_platform WHERE `browser` LIKE '$platform' ORDER BY browser_version*1 DESC");
                
                // Go throw all data
                foreach ($browser_data_whole_period as $key => $value) {
                    $percent = round(($value->count / $all_count) * 100, 2);
                    
                    // Browser data for the current year
                    $browser_data_this_year = $wpdb->get_results("SELECT count FROM $table_platform WHERE `browser` LIKE '$value->browser' AND `browser_version` LIKE '$value->browser_version' AND YEAR(date) = YEAR(CURDATE()) ORDER BY count*1 DESC");

                    // Browser data for the current month
                    $browser_data_this_months = $wpdb->get_results("SELECT count FROM $table_platform WHERE `browser` LIKE '$value->browser' AND `browser_version` LIKE '$value->browser_version' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) ORDER BY count*1 DESC");

                    // Browser data for the prevent month
                    $browser_data_prevent_months = $wpdb->get_results("SELECT count FROM $table_platform WHERE `browser` LIKE '$value->browser' AND `browser_version` LIKE '$value->browser_version' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-1 ORDER BY count*1 DESC");

                    // Browser data for the prevent prevent month
                    $browser_data_prevent_prevent_months = $wpdb->get_results("SELECT count FROM $table_platform WHERE `browser` LIKE '$value->browser' AND `browser_version` LIKE '$value->browser_version' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())-2 ORDER BY count*1 DESC");
                    
                    $progress = intval($browser_data_prevent_months[0]->count) - intval($browser_data_prevent_prevent_months[0]->count);
        
                    if ($progress === 0) {
                        $color = 'gray';
                        $symbol = '&#8645;';
                    } else if($progress > 0) {
                        $color = 'green';
                        $symbol = '&uarr; +';
                    } else {
                        $color = 'red';
                        $symbol = '&darr;';
                    }

                    echo '
                    <div class="platform-data browser-data platform-data-list platform-data-list-small d-none child-id-'.$counter.'"  data-aos="fade-left">
                        <div class="platform-column platform-column--name"></div>
                        <div class="platform-column">'.$value->browser_version.'</div>
                        <div class="platform-column '.$color.'">'.$symbol.' '.$progress.'</div>
                        <div class="platform-column green">+'.$browser_data_this_months[0]->count.'</div>
                        <div class="platform-column">'.$browser_data_this_year[0]->count.'</div>
                        <div class="platform-column">'.$value->count.'</div>
                        <div class="platform-column platform-column--progress"><div class="progress-container"><span class="progress" style="width:'.$percent.'%;"></span></div>'.$percent.'%</div>
                        </div>
                    ';
                } // [x] foreach


            } // [x]   if ($platform == 'Other') { ...}




        } // [x] else if($needed_table_name === 'browsers') { ... }

        $counter++;
    }

    
    
    // $graph_data = array();
    // foreach ($top_platforms as $platform => $data) {
    //     $data = get_object_vars($data);
    //     $platform = trim($data['device']);
    //     $platform = $platform ? $platform : 'Other';
    //     $graph_data[$data['MONTH(date)']][$platform] = $data['count'];
    // }
    // echo json_encode($graph_data);
}


// Browsers
function getTopBrowsers($site) {

    global $wpdb;

    if ($site === 'general') {
        $table_platform  = get_the_table_name('global_browsers');
    } else if ($site === 'eToroX') {
        $table_platform  = get_the_table_name('etorox_browsers');
    }

    // Top 3 browsers
    $top_3_browsers = $wpdb->get_results("SELECT browser, SUM(count) FROM $table_platform GROUP BY browser ORDER BY SUM(count)*1 DESC LIMIT 6");

    // Browser #1 lowest version
    // $browser_1_lowest_version = $wpdb->get_results("SELECT browser_version, SUM(count) FROM $table_platform GROUP BY `browser` ORDER BY browser_version*1 ASC LIMIT 3");


    // All browsers count
    $all_browsers_count = (array) $wpdb->get_row("SELECT sum(count) FROM $table_platform");
    $all_browsers_count = $all_browsers_count['sum(count)'];
    // $delay = 150*(count($top_3_browsers)-1);
    $delay = 0;

    foreach ($top_3_browsers as $browser => $data) {
        $data = get_object_vars($data);
        $browser = trim($data['browser']);
        $browser = $browser ? $browser : 'Other';
        $count = intval($data['SUM(count)']);
        $percent = round(($count / $all_browsers_count) * 100, 2);
        $browser_image = str_replace(' ', '_', $browser);

        // Lowest version
        $browser_lowest_version = $wpdb->get_results("SELECT browser_version, count FROM $table_platform WHERE browser LIKE '$browser' ORDER BY browser_version*1 ASC LIMIT 1");
    
        $browser_lowest_version_counter = $browser_lowest_version[0]->count;
        $browser_lowest_version = $browser_lowest_version[0]->browser_version;
        $percent_lower_version_browser = round(($browser_lowest_version_counter / $count) * 100, 2);
        $percent_lower_version_all = round(($browser_lowest_version_counter / $all_browsers_count) * 100, 2);

        // Newest version
        $browser_newest_version = $wpdb->get_results("SELECT browser_version, count FROM $table_platform WHERE browser LIKE '$browser' ORDER BY browser_version*1 DESC LIMIT 1");

        $browser_newest_version_counter = $browser_newest_version[0]->count;
        $browser_newest_version = $browser_newest_version[0]->browser_version;
        $percent_newest_version_browser = round(($browser_newest_version_counter / $count) * 100, 2);
        $percent_newest_version_all = round(($browser_newest_version_counter / $all_browsers_count) * 100, 2);


        // Most popular version
        $browser_popular_version = $wpdb->get_results("SELECT browser_version, count FROM $table_platform WHERE browser LIKE '$browser' ORDER BY count*1 DESC LIMIT 3");

        $browser_popular_version_counter_1 = $browser_popular_version[0]->count;
        $browser_popular_version_1 = $browser_popular_version[0]->browser_version;
        $percent_popular_version_browser_1 = round(($browser_popular_version_counter_1 / $count) * 100, 2);
        $percent_popular_version_all_1 = round(($browser_popular_version_counter_1 / $all_browsers_count) * 100, 2);

        $browser_popular_version_counter_2 = $browser_popular_version[1]->count;
        $browser_popular_version_2 = $browser_popular_version[1]->browser_version;
        $browser_popular_version_2 = $browser_popular_version_2 ? $browser_popular_version_2 : '-';
        $percent_popular_version_browser_2 = round(($browser_popular_version_counter_2 / $count) * 100, 2);
        $percent_popular_version_all_2 = round(($browser_popular_version_counter_2 / $all_browsers_count) * 100, 2);
        $percent_popular_version_all_2 = $percent_popular_version_all_2 ? $percent_popular_version_all_2 : '-';
        $browser_popular_version_counter_2 = $browser_popular_version_counter_2 ? $browser_popular_version_counter_2 : '-';


        $browser_popular_version_counter_3 = $browser_popular_version[2]->count;
        $browser_popular_version_counter_3 = $browser_popular_version_counter_3 ? $browser_popular_version_counter_3 : 0;
        $browser_popular_version_3 = $browser_popular_version[2]->browser_version;
        $browser_popular_version_3 = $browser_popular_version_3 ? $browser_popular_version_3 : '-';
        $percent_popular_version_browser_3 = round(($browser_popular_version_counter_3 / $count) * 100, 2);
        $percent_popular_version_all_3 = round(($browser_popular_version_counter_3 / $all_browsers_count) * 100, 2);
        $percent_popular_version_all_3 = $percent_popular_version_all_3 ? $percent_popular_version_all_3 : '-';
        $browser_popular_version_counter_3 = $browser_popular_version_counter_3 ? $browser_popular_version_counter_3 : '-';

        $image_name = strtolower(str_replace(' ', '_', $browser_image));

        echo ' <div class="platform box-container bg-'.strtolower($browser).'" data-aos="fade-right" data-aos-delay="'.$delay.'">
        <p class="box--sub-title">most used browser</p>
        <div class="box-container--title">
            <p class="box--title">'.$browser.'</p>
            <img src="'.PLUGIN_URL.'assets/img/logo_'.$image_name.'.svg" alt="'.$browser.'">
        </div>
        <div class="counter-statistic">
            <p class="box--count">'.$count.' <span>users</span></p>
            <p class="box--count box--count-percent">'.$percent.'%<span>of all users</span></p>
        </div>
        <div class="browser-data-block">
         <div class="title row">
            <div class="column"></div>
            <div class="column">version</div>
            <div class="column">users</div>
            <div class="column">all users</div>
         </div>
         <div class="row">
            <div class="column">popular</div>
            <div class="column">🥇 '.$browser_popular_version_1.'</div>
            <div class="column">'.$browser_popular_version_counter_1.'</div>
            <div class="column">'.$percent_popular_version_all_1.'%</div>
         </div>
         <div class="row">
            <div class="column">popular</div>
            <div class="column">🥈 '.$browser_popular_version_2.'</div>
            <div class="column">'.$browser_popular_version_counter_2.'</div>
            <div class="column">'.$percent_popular_version_all_2.'%</div>
         </div>
         <div class="row">
            <div class="column">popular</div>
            <div class="column">🥉 '.$browser_popular_version_3.'</div>
            <div class="column">'.$browser_popular_version_counter_3.'</div>
            <div class="column">'.$percent_popular_version_all_3.'%</div>
         </div>
         <div class="horizontal_line"></div>
         <div class="row">
            <div class="column">oldest</div>
            <div class="column">'.$browser_lowest_version.'</div>
            <div class="column">'.$browser_lowest_version_counter.'</div>
            <div class="column">'.$percent_lower_version_all.'%</div>
         </div>
         <div class="row">
            <div class="column">newest</div>
            <div class="column">'.$browser_newest_version.'</div>
            <div class="column">'.$browser_newest_version_counter.'</div>
            <div class="column">'.$percent_newest_version_all.'%</div>
         </div>
         
        </div>

    </div> <!-- .browser box-container --> ';
    $delay += 150;
    }

}


# ---------------------------------------------------------------------------- #
# ############################### # ViewPort # ############################### #
# ---------------------------------------------------------------------------- #

function getTopWidths($site) {
    global $wpdb;
    $table_name  = get_the_table_name("{$site}_viewport");

    $select = '';
    $where = '';
    $group_by = '';
    $order_by = '';
    $limit = '';
    $sort = '';
    
    $top_3_desktop_width = $wpdb->get_results("SELECT width, SUM(count) FROM $table_name WHERE width*1 > 100 AND width*1 >= 1025 GROUP BY width ORDER BY SUM(count)*1 DESC LIMIT 3");
    $top_3_tablet_width = $wpdb->get_results("SELECT width, SUM(count) FROM $table_name WHERE width*1 > 100 AND width*1 > 540 AND width*1 < 1025 GROUP BY width ORDER BY SUM(count)*1 DESC LIMIT 3");
    $top_3_mobile_width = $wpdb->get_results("SELECT width, SUM(count) FROM $table_name WHERE width*1 > 100 AND width*1 <= 540 GROUP BY width ORDER BY SUM(count)*1 DESC LIMIT 3");

    $all_width_count = (array) $wpdb->get_row("SELECT sum(count) FROM $table_name WHERE width*1 > 100");
    $all_width_count = intval($all_width_count['sum(count)']);

    $all_desktop_width_count = (array) $wpdb->get_row("SELECT sum(count) as count, min(width*1) as min ,max(width*1) as max FROM $table_name WHERE width*1 > 100 AND width*1 >= 1025" );
    $min_desktop_width = intval($all_desktop_width_count['min']);
    $max_desktop_width = intval($all_desktop_width_count['max']);
    $all_desktop_width_count = intval($all_desktop_width_count['count']);
    $desktop_percent = round(($all_desktop_width_count / $all_width_count) * 100, 2);
    
    $all_tablet_width_count = (array) $wpdb->get_row("SELECT sum(count) as count, min(width*1) as min ,max(width*1) as max FROM $table_name WHERE width*1 > 100 AND width*1 > 540 AND width*1 < 1025" );
    $min_tablet_width = intval($all_tablet_width_count['min']);
    $max_tablet_width = intval($all_tablet_width_count['max']);
    $all_tablet_width_count = intval($all_tablet_width_count['count']);
    $tablet_percent = round(($all_tablet_width_count / $all_width_count) * 100, 2);

    $all_mobile_width_count = (array) $wpdb->get_row("SELECT sum(count) as count, min(width*1) as min ,max(width*1) as max FROM $table_name WHERE width*1 > 100 AND width*1 <= 540" );
    $min_mobile_width = intval($all_mobile_width_count['min']);
    $max_mobile_width = intval($all_mobile_width_count['max']);
    $all_mobile_width_count = intval($all_mobile_width_count['count']);
    $mobile_percent = round(($all_mobile_width_count / $all_width_count) * 100, 2);

    print_top_width('Mobile', 'mobile', $min_mobile_width, $max_mobile_width, $all_mobile_width_count, $mobile_percent, $top_3_mobile_width, $all_width_count, 300);

    print_top_width('Tablet', 'tablet', $min_tablet_width, $max_tablet_width, $all_tablet_width_count, $tablet_percent, $top_3_tablet_width, $all_width_count, 150);

    print_top_width('Desktop', 'desktop', $min_desktop_width, $max_desktop_width, $all_desktop_width_count, $desktop_percent, $top_3_desktop_width, $all_width_count, 0);

} /* [x] function getTopWidths($site, $type) { ... } */

function print_top_width($title, $icon_name, $min_width, $max_width, $users_count, $user_percent, $top_3_width, $all_width_count, $delay) {
    
    $image_source = PLUGIN_URL . "assets/img";

    echo <<<__HTML
    <div class="platform box-container" data-aos="fade-right" data-aos-delay="${delay}">
        
        <p class="box--sub-title">top width</p>

        <div class="box-container--title">
            <p class="box--title box--title-big">{$title}</p>
            <div class="logo-container">
            <img src="{$image_source}/logo_{$icon_name}.svg" alt="Desktop">
            <span class="min-max">{$min_width} px - {$max_width} px</span>
            </div>
        </div> <!-- .box-container--title -->

        <div class="counter-statistic">
            <p class="box--count">{$users_count}<span>users</span></p>
            <p class="box--count box--count-percent">{$user_percent}%<span>of all users</span></p>
        </div> <!-- .counter-statistic -->

        <div class="browser-data-block">
            <div class="title row">
                <div class="column"></div>
                <div class="column">users</div>
                <div class="column">desktop</div>
                <div class="column">all users</div>
            </div>
            <div class="horizontal_line"></div>
    __HTML;
    
    foreach ($top_3_width as $width => $data) {
        $data = get_object_vars($data);
        $width = intval(trim($data['width']));
        $count = intval(trim($data['SUM(count)']));
        $percent_all = round(($count / $all_width_count) * 100, 2);
        $percent_desktop = round(($count / $users_count) * 100, 2);

        echo <<<__HTML
        <div class="row">
            <div class="column">{$width} px</div>
            <div class="column">{$count}</div>
            <div class="column">{$percent_desktop}%</div>
            <div class="column">{$percent_all}%</div>
        </div> <!-- .row -->
        __HTML;
    }
    
    
    echo <<<__HTML
        </div> <!-- .browser-data-block -->
    </div> <!-- .browser box-container -->
    __HTML;

}

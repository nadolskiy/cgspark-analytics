<?php

/**
 * Function checks if needed to redirect current page.
 * @param $CURRENT_URL - URL of page which needed to be redirected.
 * @return false - no need to do redirection 
 */
function do_redirection($CURRENT_URL) {
    
    // Parse url
    $CURRENT_URL = trim(ltrim(strtolower($CURRENT_URL), '/'));
    $URL = explode('?', $CURRENT_URL);
    $page_url = rtrim($URL[0], '/');
    $page_url_with_dash = $URL[0] . '/';
    $query_parameters = $URL[1];

    // Checking do we need to do the redirection
    global $wpdb;
    $table_with_urls = $wpdb->prefix . 'pr_redirection';

    $redirection = $wpdb->get_row("SELECT target_url, query, count, id FROM $table_with_urls WHERE (`source_url` LIKE '$page_url' AND (`query`='1' OR `query`='2')) OR `source_url` LIKE '$CURRENT_URL' AND `query`='0' OR `source_url` LIKE '$page_url' AND `query`='0' OR `source_url` LIKE '$page_url_with_dash' AND `query`='0'");

    // Do redirection
    if ($redirection) {

        // Update redirection count
        $where = array('id'=>$redirection->id);
        $data = array('count' => intval($redirection->count) + 1,'last_redirect_date'  => gmdate("Y-m-d H:i:s"));
        $wpdb->update( $table_with_urls, $data, $where);

        // Update statistic
        $table_with_statistic = $wpdb->prefix . 'pr_statistic';
        $current_date = gmdate("Y-m-d");
        $current_day_statistic = $wpdb->get_row( "SELECT count FROM $table_with_statistic WHERE date = '$current_date'", OBJECT );

        if (empty($current_day_statistic)) {
            $wpdb->insert( $table_with_statistic, array( "date" => $current_date, "count" => 1));
        } else {
            $wpdb->update( $table_with_statistic, array("count" => intval($current_day_statistic->count) + 1), array('date' => $current_date));
        }

        $url_for_redirect = $redirection->target_url;

        if (parse_url($redirection->target_url, PHP_URL_SCHEME)) {
            $url_for_redirect = $redirection->target_url;
        } else {
            $url_for_redirect = 'https://' . $redirection->target_url;
        }

        // Check what need to do with the parameters
        switch ($redirection->query) {
            case 0:
            case 2:
                $url_for_redirect .= $query_parameters ? '?'.$query_parameters : '';
                break;

           default:
               break;
        } // [x] switch ($redirection->query) { ... }

        Header( "HTTP/1.1 301 Moved Permanently" );
		Header("Location: ". $url_for_redirect, true, 303);
		die();

    } // [x] if ($redirection) { ... }

    // Don't do redirection
    else {
        return false;
    } // [x] else { ... }

} // [x] function do_redirection($CURRENT_URL) { ... }
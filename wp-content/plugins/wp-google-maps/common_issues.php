<?php
/*
 * 
 * WP Google Maps - Common Issues Handler
 * 
 * 
 */


global $wpgmza_common_errors;


function wpgmza_check_common_issues() {
    wpgmza_check_db_columns();
}

function wpgmza_check_db_columns() {
    global $wpdb;
    global $wpgmza_tblname;
    global $wpgmza_common_errors;
    $wpgmza_common_errors = false;
    
    $results = $wpdb->get_results("DESCRIBE $wpgmza_tblname",ARRAY_A);
    foreach( $results as $row ) {
        if ($row['Field'] == "desc") { $wpgmza_common_errors = true; }
    }
    
    
}

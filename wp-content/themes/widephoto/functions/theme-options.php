<?php

add_action('init','wdp_options');

if (!function_exists('wdp_options')) {
function wdp_options(){
	
// VARIABLES
$theme_data = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $theme_data['Name'];
$themeversion = $theme_data['Version'];
$shortname = "tz";

// Populate option in array for use in theme
global $wdp_options;
$wdp_options = get_option('wdp_options');

$GLOBALS['template_path'] = wdp_DIRECTORY;

//Access the WordPress Categories via an Array
$wdp_categories = array();  
$wdp_categories_obj = get_categories('hide_empty=0');
foreach ($wdp_categories_obj as $wdp_cat) {
    $wdp_categories[$wdp_cat->cat_ID] = $wdp_cat->cat_name;}
$categories_tmp = array_unshift($wdp_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$wdp_pages = array();
$wdp_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($wdp_pages_obj as $wdp_page) {
    $wdp_pages[$wdp_page->ID] = $wdp_page->post_name; }
$wdp_pages_tmp = array_unshift($wdp_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Stylesheets Reader
$alt_stylesheet_path = wdp_FILEPATH . '/css/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = '';
if(isset($uploads_arr['path'])) $all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('wdp_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

// Set the Options Array
$options = array();


$options[] = array( "name" => __('Background Images','framework'),
                    "type" => "heading");
                    
$options[] = array( "name" => "",
					"message" => __('Here, you can change the background images. Use an image resolution of 1280px X 800px ~ 200 KB, if possible.','framework'),
					"type" => "intro");
 
                    


$options[] = array( "name" => __('Background Image 1','framework'),
					"desc" => __('Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)','framework'),
					"id" => $shortname."_bg_image_1",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => __('Background Image 2','framework'),
					"desc" => __('Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)','framework'),
					"id" => $shortname."_bg_image_2",
					"std" => "",
					"type" => "upload");					
					
$options[] = array( "name" => __('Background Image 3','framework'),
					"desc" => __('Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)','framework'),
					"id" => $shortname."_bg_image_3",
					"std" => "",
					"type" => "upload");

update_option('wdp_template',$options); 					  
update_option('wdp_themename',$themename);   
update_option('wdp_shortname',$shortname);

    }
}
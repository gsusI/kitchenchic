<?php
/**
 * widephoto functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package widephoto
 * @since widephoto 0.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 650; /* pixels */

if ( ! function_exists( 'widephoto_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override widephoto_setup() in a child theme, add your own widephoto_setup to your child theme's
 * functions.php file.
 */
function widephoto_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on widephoto, use a find and replace
	 * to change 'widephoto' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'widephoto', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Add post thumbnail support
	 */
	add_theme_support( 'post-thumbnails' );
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'widephoto' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
}
endif; // widephoto_setup

/**
 * Tell WordPress to run widephoto_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'widephoto_setup' );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function widephoto_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'widephoto_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function widephoto_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'widephoto' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'widephoto' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second sidebar area', 'widephoto' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'widephoto_widgets_init' );

if ( ! function_exists( 'widephoto_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since widephoto 1.2
 */
function widephoto_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'widephoto' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'widephoto' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'widephoto' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'widephoto' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'widephoto' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // widephoto_content_nav


if ( ! function_exists( 'widephoto_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own widephoto_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since widephoto 0.4
 */
function widephoto_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'widephoto' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'widephoto' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'widephoto' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'widephoto' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'widephoto' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'widephoto' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for widephoto_comment()

if ( ! function_exists( 'widephoto_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own widephoto_posted_on to override in a child theme
 *
 * @since widephoto 1.2
 */
function widephoto_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'widephoto' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'widephoto' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @since widephoto 1.2
 */
function widephoto_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'widephoto_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since widephoto 1.2
 */
function widephoto_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so widephoto_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so widephoto_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in widephoto_categorized_blog
 *
 * @since widephoto 1.2
 */
function widephoto_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'widephoto_category_transient_flusher' );
add_action( 'save_post', 'widephoto_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function widephoto_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'widephoto_enhanced_image_navigation' );


/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a widephoto.
 */
 

/* 
 * Turns off the default options panel from Twenty Eleven
 */
 
add_action('after_setup_theme','remove_twentyeleven_options', 100);

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}

/* 
 * Widephoto enqueue scripts
 */

function widephoto_enqueue_scripts () {
	// comment out the next two lines to load the local copy of jQuery
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'widephoto_enqueue_scripts');

/* 
 * Add Supersized scripts to head
 */
function widephoto_add_supersized_script () { ?>
		<!-- Supersized scripts -->
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/supersized/css/supersized.css" type="text/css" media="screen" />
		<!-- You might need to update the src in the line below, to match your own installation -->
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/supersized/js/supersized.3.1.3.min.js"></script>
		
		<script type="text/javascript">  
			
			jQuery(function($){
				$.supersized({
				
					//Functionality
					slideshow               :   1,		//Slideshow on/off
					autoplay				:	1,		//Slideshow starts playing automatically
					start_slide             :   1,		//Start slide (0 is random)
					slide_interval          :   4000,	//Length between transitions
					slideshow_interval          :   4000,	//Length between transitions
					transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	500,	//Speed of transition
					new_window				:	1,		//Image links open in new window/tab
					pause_hover             :   0,		//Pause slideshow on hover
					keyboard_nav            :   1,		//Keyboard navigation on/off
					performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,		//Disables image dragging and right click with Javascript
					image_path				:	'img/', //Default image path

					//Size & Position
					min_width		        :   0,		//Min width allowed (in pixels)
					min_height		        :   0,		//Min height allowed (in pixels)
					vertical_center         :   1,		//Vertically center background
					horizontal_center       :   1,		//Horizontally center background
					fit_portrait         	:   1,		//Portrait images will not exceed browser height
					fit_landscape			:   0,		//Landscape images will not exceed browser width
					
					//Components
					navigation              :   1,		//Slideshow controls on/off
					thumbnail_navigation    :   1,		//Thumbnail navigation
					slide_counter           :   1,		//Display slide numbers
					slide_captions          :   1,		//Slide caption (Pull from "title" in slides array)
					slides 					:  	[		//Slideshow Images
					
							<?php
							 $slides = array('wdp_bg_image_1','wdp_bg_image_2','wdp_bg_image_3');
							 $i=1;
							 $j=0;
							 foreach ($slides as $slide) {
									if(get_option($slide)<>"") $j++;
									}

									if ($j != 0) {
										foreach ($slides as $slide) {
											
												if ($i == $j) {
													echo "{image : '".stripslashes(get_option($slide))."'}";
												}
												else {
													echo "{image : '".stripslashes(get_option($slide))."'},";
													
												}
											
										$i++;
										}
									
									}
									else echo "{image : '".get_template_directory_uri()."/images/before-the-storm.jpg'}, {image : '".get_template_directory_uri()."/images/fisherman.jpg'}, {image : '".get_template_directory_uri()."/images/castle.jpg'}";
							?>
														
												]
												
				}); 
		    });
		    
		</script>
<!-- End of Supersized scripts -->
	<?php	
}
	
add_action('wp_head','widephoto_add_supersized_script');


/*-----------------------------------------------------------------------------------*/
/*	Load Theme Options
/*-----------------------------------------------------------------------------------*/

define('wdp_FILEPATH', TEMPLATEPATH);
define('wdp_DIRECTORY', get_template_directory_uri());

require_once (wdp_FILEPATH . '/admin/admin-functions.php');
require_once (wdp_FILEPATH . '/admin/admin-interface.php');
require_once (wdp_FILEPATH . '/functions/theme-options.php');
require_once (wdp_FILEPATH . '/functions/theme-functions.php');
?>
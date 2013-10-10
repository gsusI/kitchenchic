<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
 <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/supersized.css" media="screen" />	 
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/prettyphoto.css" media="screen" />	
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<?php 
wp_enqueue_script('jquery');
wp_enqueue_script('superfish', get_stylesheet_directory_uri() .'/js/superfish.js');
wp_enqueue_script('effects', get_stylesheet_directory_uri() .'/js/effects.js');
wp_enqueue_script('supersized', get_stylesheet_directory_uri() .'/js/supersized.3.1.3.min.js');
wp_enqueue_script('prettyphoto', get_stylesheet_directory_uri() .'/js/jquery.prettyPhoto.js');
?>

<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>


<script type="text/javascript">  
			
	jQuery(function($){
		$.supersized({
				
					//Functionality
					slideshow               :   1,		//Slideshow on/off
					autoplay				:	1,		//Slideshow starts playing automatically
					start_slide             :   1,		//Start slide (0 is random)
					random					: 	0,		//Randomize slide order (Ignores start slide)
					slide_interval          :   5000,	//Length between transitions
					transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	1000,	//Speed of transition
					new_window				:	1,		//Image links open in new window/tab
					pause_hover             :   0,		//Pause slideshow on hover
					keyboard_nav            :   1,		//Keyboard navigation on/off
					performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,		//Disables image dragging and right click with Javascript
					
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
					
/* 					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/1.jpg'},
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/2.jpg'},							
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/3.jpg'},	
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/4.jpg'},
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/5.jpg'},							
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/6.jpg'},	
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/7.jpg'},
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/8.jpg'},							
					{image : '<?php bloginfo('stylesheet_directory'); ?>/slides/9.jpg'} */
					
					
					
<?php 
// The Query
 query_posts( 'post_type=slides&posts_per_page=-1&orderby=' );
$i=0; 
while ( have_posts() ) : the_post();
$simg=get_post_meta($post->ID, 'wtf_slide', true);
if ($i > 0) : echo ','; else: echo ''; endif; //For IE sake add a coma BEFORE every image offsetting the first one.
echo "{image : '".$simg."'}"; 
$i++; 
endwhile;
wp_reset_query();
 ?>	
]
										
}); 
});
</script>
		


</head>
<body>

<div id="masthead" class="clearfix"><!-- masthead begin -->

	<div id="top"> 
		<h1 class="logo"><a href="<?php bloginfo('siteurl');?>/" title="<?php bloginfo('name');?>"><?php bloginfo('name');?></a></h1>
	</div>
		
	<div id="botmenu" class="clearfix">
		<?php wp_nav_menu( array( 'container_id' => 'submenu', 'theme_location' => 'primary','menu_class'=>'sf-menu sf-vertical','fallback_cb'=> 'fallbackmenu' ) ); ?>
	</div>

	<div class="strigger">
	<span class="trig"></span>
	</div>
	
</div><!--end masthead-->
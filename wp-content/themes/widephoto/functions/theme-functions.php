<?php

/* These are functions specific to the included option settings and this theme */


/*-----------------------------------------------------------------------------------*/
/* Output Custom CSS from theme options
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_head_css' ) ) {
    function wdp_head_css() {
        
        $output = '';
        
        /* Set Custom Background Image if needed --------*/
        
        // gain access to post id
        global $wp_query;
        if( is_home() && !is_tax( 'portfolio-type' ) ) {
            $postid = get_option('page_for_posts');
        } elseif( is_tax( 'portfolio-type' ) || is_search() || is_404() ) {
            $postid = 0;
        } else {
            $postid = $wp_query->post->ID;
        }

        // get custom image for page
        $bg_img = get_post_meta($postid, 'wdp_background_image', true);

        if( empty($bg_img) ) {
            // No custom image supplied, check the default position
            $bg_pos = get_option('wdp_default_bg_position');
            
            if( $bg_pos != 'full' ) {
                // We aren't dealing with a full screen image, so set up body bg
                $bg_img = get_option('wdp_default_bg_image');
                if( !empty($bg_img) ) {
                    $bg_img = " url($bg_img)";
                } else {
                    $bg_img = " none";
                }
                $bg_repeat = get_option('wdp_default_bg_repeat');
                $bg_color = get_post_meta($postid, 'wdp_background_color', true);
                if( empty($bg_color) ) { 
                    $bg_color = get_option('wdp_default_bg_color');
                }
                
                $output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: fixed;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
            }    
        } else {
            // Custom image provided, check default position
            $bg_pos = get_post_meta($postid, 'wdp_background_position', true);

            if( $bg_pos != __('Full Screen', 'framework') ) {
                // We aren't dealing with a full screen image, so set up body bg
                $bg_img = " url($bg_img)";
                
                // Handle the pos
                if( $bg_pos == __('Centered', 'framework') ) { $bg_pos = 'center'; }
                $bg_pos = strtolower($bg_pos);

                // Handle the repeat
                $bg_repeat = get_post_meta($postid, 'wdp_background_repeat', true);
                if( $bg_repeat == __('No Repeat', 'framework') ) { 
                    $bg_repeat = 'no-repeat'; 
                } elseif( $bg_repeat == __('Repeat', 'framework') ) {
                    $bg_repeat = 'repeat';
                } elseif( $bg_repeat == __('Repeat Horizontally', 'framework') ) {
                    $bg_repeat = 'repeat-x';
                } else {
                    $bg_repeat = 'repeat-y';
                }
                
                $bg_color = get_post_meta($postid, 'wdp_background_color', true);
                if( empty($bg_color) ) { 
                    $bg_color = get_option('wdp_default_bg_color');
                }
                
                $output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: fixed;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
            }
        }
        
	    /* Custom CSS from Theme Options --------------------*/
		$custom_css = get_option('wdp_custom_css');
	
		if ( !empty($custom_css) ) {
			$output .= $custom_css . "\n";
		}
		
		/* Custom Highlight Color ----------------------------*/
		$custom_highlight = get_option('wdp_highlight_color');
		if( !empty($custom_highlight) && $custom_highlight != '#' ) {
		    $output .= "a:hover,\n#header-top p,\n.slider .slides_prev:hover,\n.slider .slides_next:hover,\nbutton:hover,\n.page-template-template-portfolio-php .post-thumb a,\n.tax-portfolio-type .post-thumb a,\n.recent-work .post-thumb a,\n.portfolio-related .post-thumb a,\n.tz-recent-portfolios-widget .post-thumb a,\n#sort-by a.active,\n.entry-meta span.post-format,\n#comments,\n#submit:hover,\n#respond h3,\n.tz-blog-widget .entry-title a:hover { background-color: $custom_highlight; }\n";
		    $output .= ".slider a,\n.slider-desc span,\n.slider-desc em,\n#footer .tz-blog-widget .entry-title a:hover { color: $custom_highlight; }\n";
		    $output .= "button:hover,\n#submit:hover,\n.bypostauthor .avatar,\n.flickr_badge_image img { border-color: $custom_highlight; }\n";
		}
	
		/* Output our custom styles --------------------------*/
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo stripslashes($output);
		}
	
    }

    add_action('wp_head', 'wdp_head_css');
}


/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_body_class' ) ) { 
    function wdp_body_class($classes) {
    	$shortname = get_option('wdp_shortname');
    	$layout = get_option($shortname .'_layout');
    	if ($layout == '') {
    		$layout = 'layout-2cr';
    	}
    	$classes[] = $layout;
    	return $classes;
    }
    add_filter('body_class','wdp_body_class');
}


/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_favicon' ) ) {
    function wdp_favicon() {
    	$shortname = get_option('wdp_shortname');
    	if (get_option($shortname . '_custom_favicon') != '') {
    	echo '<link rel="shortcut icon" href="'. get_option('wdp_custom_favicon') .'"/>'."\n";
    	}
    	else { ?>
    	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/admin/images/favicon.ico" />
    	<?php }
    }
    add_action('wp_head', 'wdp_favicon');
}


/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_analytics' ) ) {
    function wdp_analytics(){
    	$shortname =  get_option('wdp_shortname');
    	$output = get_option($shortname . '_google_analytics');
    	if ( $output <> "" ) 
    		echo stripslashes($output) . "\n";
    }
    add_action('wp_footer','wdp_analytics');
}


/*-----------------------------------------------------------------------------------*/
/*	Get related posts by taxonomy
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_get_posts_related_by_taxonomy' ) ) {
    function wdp_get_posts_related_by_taxonomy($post_id, $taxonomy, $args=array()) {
        $query = new WP_Query();
        $terms = wp_get_object_terms($post_id, $taxonomy);
        if (count($terms)) {
        // Assumes only one term for per post in this taxonomy
        $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
        $post = get_post($post_id);
        $args = wp_parse_args($args,array(
            'post_type' => $post->post_type, // The assumes the post types match
            'post__not_in' => array($post_id),
            'taxonomy' => $taxonomy,
            'term' => $terms[0]->slug,
            'orderby' => 'rand',
            'posts_per_page' => get_option('wdp_portfolio_related_number')
        ));
        $query = new WP_Query($args);
        }
        return $query;
    }
}


/*-----------------------------------------------------------------------------------*/
/* Output image */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_image' ) ) {
    function wdp_image($postid, $imagesize) {
        // get the featured image for the post
        $thumbid = 0;
        if( has_post_thumbnail($postid) ) {
            $thumbid = get_post_thumbnail_id($postid);
        }
    
        // get first 2 attachments for the post
        $args = array(
            'orderby' => 'menu_order',
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => 2
        );
        $attachments = get_posts($args);

        if( !empty($attachments) ) {
            foreach( $attachments as $attachment ) {
                // if current image is featured image reloop
                if( $attachment->ID == $thumbid ) continue;
                $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<div class='image-frame'>";
                echo "<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' />";
                echo "</div>";
                // got image, time to exit foreach
                break;
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Output gallery slideshow */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_gallery' ) ) {
    function wdp_gallery($postid, $imagesize) { ?>
        <script type="text/javascript">
    		jQuery(document).ready(function(){
    			jQuery("#slider-<?php echo $postid; ?>").slides({
    				preload: true,
    				preloadImage: jQuery("#slider-<?php echo $postid; ?>").attr('data-loader'), 
    				generatePagination: true,
    				generateNextPrev: true,
    				next: 'slides_next',
    				prev: 'slides_prev',
    				effect: 'fade',
    				crossfade: true,
    				autoHeight: true,
    				bigTarget: true
    			});
    		});
    	</script>
    <?php 
        $loader = 'ajax-loader.gif';
        $thumbid = 0;
    
        // get the featured image for the post
        if( has_post_thumbnail($postid) ) {
            $thumbid = get_post_thumbnail_id($postid);
        }
        echo "<!-- BEGIN #slider-$postid -->\n<div id='slider-$postid' class='slider' data-loader='" . get_template_directory_uri() . "/images/$loader'>";
    
        // get all of the attachments for the post
        $args = array(
            'orderby' => 'menu_order',
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => -1
        );
        $attachments = get_posts($args);
        if( !empty($attachments) ) {
            echo '<div class="slides_container">';
            $i = 0;
            foreach( $attachments as $attachment ) {
                if( $attachment->ID == $thumbid ) continue;
                $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
                $caption = $attachment->post_excerpt;
                $caption = ($caption) ? "<div class='slider-desc'>$caption</div>" : '';
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<div>$caption<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' /></div>";
                $i++;
            }
            echo '</div>';
        }
        echo "<!-- END #slider-$postid -->\n</div>";
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Output Audio
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_audio' ) ) {
    function wdp_audio($postid, $width = 560) {
	
    	$mp3 = get_post_meta($postid, 'wdp_audio_mp3', TRUE);
    	$ogg = get_post_meta($postid, 'wdp_audio_ogg', TRUE);
    	$poster = get_post_meta($postid, 'wdp_audio_poster', TRUE);
    	$height = get_post_meta($postid, 'wdp_poster_height', TRUE);
	
    ?>

    		<script type="text/javascript">
		
    			jQuery(document).ready(function(){
	
    				if(jQuery().jPlayer) {
    					jQuery("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
    						ready: function () {
    							jQuery(this).jPlayer("setMedia", {
    							    <?php if($poster != '') : ?>
    							    poster: "<?php echo $poster; ?>",
    							    <?php endif; ?>
    							    <?php if($mp3 != '') : ?>
    								mp3: "<?php echo $mp3; ?>",
    								<?php endif; ?>
    								<?php if($ogg != '') : ?>
    								oga: "<?php echo $ogg; ?>",
    								<?php endif; ?>
    								end: ""
    							});
    						},
    						<?php if( !empty($poster) ) { ?>
    						size: {
            				    width: "<?php echo $width; ?>px",
            				    height: "<?php echo $height . 'px'; ?>"
            				},
            				<?php } ?>
    						swfPath: "<?php echo get_template_directory_uri(); ?>/js",
    						cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
    						supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3, <?php endif; ?> all"
    					});
					
    				}
    			});
    		</script>
		
    	    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-audio"></div>

            <div class="jp-audio-container">
                <div class="jp-audio">
                    <div class="jp-type-single">
                        <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                            <ul class="jp-controls">
                            	<li><div class="seperator-first"></div></li>
                                <li><div class="seperator-second"></div></li>
                                <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                                <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                                <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                                <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                            </ul>
                            <div class="jp-progress-container">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-volume-bar-container">
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	<?php 
    }
}


/*-----------------------------------------------------------------------------------*/
/* Output video */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_video' ) ) {
    function wdp_video($postid, $width = 560) {
	
    	$height = get_post_meta($postid, 'wdp_video_height', true);
    	$m4v = get_post_meta($postid, 'wdp_video_m4v', true);
    	$ogv = get_post_meta($postid, 'wdp_video_ogv', true);
    	$poster = get_post_meta($postid, 'wdp_video_poster', true);
	
    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function(){
		
    		if(jQuery().jPlayer) {
    			jQuery("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
    				ready: function () {
    					jQuery(this).jPlayer("setMedia", {
    						<?php if($m4v != '') : ?>
    						m4v: "<?php echo $m4v; ?>",
    						<?php endif; ?>
    						<?php if($ogv != '') : ?>
    						ogv: "<?php echo $ogv; ?>",
    						<?php endif; ?>
    						<?php if ($poster != '') : ?>
    						poster: "<?php echo $poster; ?>"
    						<?php endif; ?>
    					});
    				},
    				size: {
    				    width: "<?php echo $width ?>px",
    				    height: "<?php echo $height . 'px'; ?>"
    				},
    				swfPath: "<?php echo get_template_directory_uri(); ?>/js",
    				cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
    				supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv, <?php endif; ?> all"
    			});
    		}
    	});
    </script>

    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-video"></div>

    <div class="jp-video-container">
        <div class="jp-video">
            <div class="jp-type-single">
                <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                    <ul class="jp-controls">
                    	<li><div class="seperator-first"></div></li>
                        <li><div class="seperator-second"></div></li>
                        <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    </ul>
                    <div class="jp-progress-container">
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="jp-volume-bar-container">
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php }
}


/*-----------------------------------------------------------------------------------*/
/* Custom Walker for wp_list_categories in template-portfolio.php */
/*-----------------------------------------------------------------------------------*/

class Portfolio_Walker extends Walker_Category {
    function start_el(&$output, $category, $depth, $args) {
            extract($args);

            $cat_name = esc_attr( $category->name );
            $cat_name = apply_filters( 'list_cats', $cat_name, $category );
            $link = '<a href="' . esc_attr( get_term_link($category) ) . '" ';
            $link .= 'data-filter="' . $category->slug . '" ';
            if ( $use_desc_for_title == 0 || empty($category->description) )
                    $link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ,'widephoto'), $cat_name) ) . '"';
            else
                    $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
            $link .= '>';
            $link .= $cat_name . '</a>';

            if ( !empty($feed_image) || !empty($feed) ) {
                    $link .= ' ';

                    if ( empty($feed_image) )
                            $link .= '(';

                    $link .= '<a href="' . get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) . '"';

                    if ( empty($feed) ) {
                            $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','widephoto' ), $cat_name ) . '"';
                    } else {
                            $title = ' title="' . $feed . '"';
                            $alt = ' alt="' . $feed . '"';
                            $name = $feed;
                            $link .= $title;
                    }

                    $link .= '>';

                    if ( empty($feed_image) )
                            $link .= $name;
                    else
                            $link .= "<img src='$feed_image'$alt$title" . ' />';

                    $link .= '</a>';

                    if ( empty($feed_image) )
                            $link .= ')';
            }

            if ( !empty($show_count) )
                    $link .= ' (' . intval($category->count) . ')';

            if ( !empty($show_date) )
                    $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);

            if ( 'list' == $args['style'] ) {
                    $output .= "\t<li";
                    $class = 'cat-item cat-item-' . $category->term_id;
                    if ( !empty($current_category) ) {
                            $_current_category = get_term( $current_category, $category->taxonomy );
                            if ( $category->term_id == $current_category )
                                    $class .=  ' current-cat';
                            elseif ( $category->term_id == $_current_category->parent )
                                    $class .=  ' current-cat-parent';
                    }
                    $output .=  ' class="' . $class . '"';
                    $output .= ">$link\n";
            } else {
                    $output .= "\t$link<br />\n";
            }
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Helpful function to see if a number is a multiple of another number
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'wdp_is_multiple' ) ) {
    function wdp_is_multiple($number, $multiple) { return ($number % $multiple) == 0; }
}
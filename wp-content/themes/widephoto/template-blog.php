<?php
/*
Template Name: Blog
*/


get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

				<header class="page-header">
					<h1 class="page-title">
						<?php _e('Blog','widephoto'); ?>
					</h1>
				</header>
								
				<?php
				
				// Fix for the WordPress 3.0 "paged" bug.
				$paged = 1;
				if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
				if ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
				$paged = intval( $paged );

				$query_args = array(
					'post_type' => 'post', 
					'paged' => $paged
				);
					
				$wp_query = NULL;
				$wp_query = new WP_Query();
				$wp_query->query($query_args);
		
				?>
				
				<?php if ( $wp_query->have_posts() ) : ?>
				
				<?php rewind_posts(); ?>

				<?php widephoto_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php widephoto_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'widephoto' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'widephoto' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
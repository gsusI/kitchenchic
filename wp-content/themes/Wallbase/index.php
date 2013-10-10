<?php get_header(); ?>

<?php if(get_option('wall_homelayout') == "blog") { ?>

<div id="casing">

<div class="incasing">

<div id="content">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">

<div class="title">
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
</div>
<div class="postmeta">
	<span class="author">Posted by <?php the_author(); ?> </span> <span class="clock">  <?php the_time('M - j - Y'); ?></span> <span class="comm"><?php comments_popup_link('0 Comment', '1 Comment', '% Comments'); ?></span>
</div>

<div class="entry">

<?php
if ( has_post_thumbnail() ) { ?>
	<a href="<?php the_permalink() ?>"><img class="postimg" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&amp;h=200&amp;w=470&amp;zc=1" alt=""/></a>
<?php } else { ?>
	<a href="<?php the_permalink() ?>"><img class="postimg" src="<?php bloginfo('template_directory'); ?>/images/dummy.png" alt="" /></a>
<?php } ?>
<?php the_excerpt(); ?>
<div class="clear"></div>
</div>

</div>

<?php endwhile; ?>

<div class="clear"></div>

<?php getpagenavi(); ?>

<?php else : ?>
		<h1 class="title">Not Found</h1>
		<p>Sorry, but you are looking for something that isn't here.</p>
<?php endif; ?>
     
</div>

<?php get_sidebar(); ?>
<div class="clear"></div>
<?php include (TEMPLATEPATH . '/bottom.php'); ?>	
</div>

<div class="clear"></div>

</div>	

<?php }  ?>

<?php get_footer(); ?>
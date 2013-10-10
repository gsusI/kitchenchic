<?php
/*
	Template Name: Fullpage 
*/
?>

<?php get_header(); ?>

<div id="casing">
<div class="incasing">
<div id="content" style="width:700px;">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">

<div class="title">
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
</div>

<div class="entry">
<?php the_content('Read the rest of this entry &raquo;'); ?>
<div class="clear"></div>
</div>

</div>

<?php endwhile; else: ?>

		<h1 class="title">Not Found</h1>
		<p>I'm Sorry,  you are looking for something that is not here. Try a different search.</p>

<?php endif; ?>

</div>

<div class="clear"></div>

</div>

<div class="clear"></div>
</div>	
<?php get_footer(); ?>
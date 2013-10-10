<?php get_header(); ?>
<div id="casing">
<div class="incasing">
	<div class="npost">
		<div class="ntitle title">
			<h2>404-Not Found</h2>
		</div>
		<div class="nentry">
			<p>The page you are looking for is not here.. please try a different search.</p>
		
		</div>
		
		<div id="usearch">
	<form method="get" id="searchform" action="<?php bloginfo('home'); ?>" >
	<input id="seform"  type="text" name="s" onfocus="if(this.value=='search site'){this.value=''};" onblur="if(this.value==''){this.value='search site'};" value="<?php echo wp_specialchars($s, 1); ?>" />
	<input id="sebut" type="submit" value="Search" />
	</form>
</div>
	</div>

<div class='clear'></div>	
</div>
</div>
<?php get_footer(); ?>
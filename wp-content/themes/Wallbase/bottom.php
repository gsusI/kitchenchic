
<div class="bottomcover ">

<div id="bottom" >

<?php include (TEMPLATEPATH . '/sponsors.php'); ?>	
<ul>

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar("Footer") ) : ?>  

	<li class="botwid">
				<h3 class="bothead"><?php _e( 'Archives', '' ); ?></h3>
				<ul>
						<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
	</li>
	
	<li class="botwid">
				<h3 class="bothead"><?php _e( 'Meta', '' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>
	</li>	
<?php endif; ?>
	</ul>

<div class="clear"> </div>
</div>
</div>
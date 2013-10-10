<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package widephoto
 * @since widephoto 0.1
 */
?>

	</div><!-- #main -->
	<div class="clear"></div>
	</div><!-- #page -->
	<div class="clear"></div>
</div><!-- #wrapper -->

	<footer id="colophon" role="contentinfo">
		<div id="site-generator">
			<?php do_action( 'widephoto_credits' ); ?>
			<div id="credits">&copy;&nbsp;<?php echo date("Y")." ".get_bloginfo('name'); ?> |
			<a href="<?php echo esc_url( __( 'http://buzzrain.com', 'widephoto' ) ); ?>" title="<?php esc_attr_e( 'Wordpress for Photographers', 'widephoto' ); ?>" rel="generator"><?php printf( __( 'Photography Theme by %s', 'widephoto' ), 'Buzzrain' ); ?></a>
		</div>
	</footer><!-- #colophon -->


<?php wp_footer(); ?>

</body>
</html>
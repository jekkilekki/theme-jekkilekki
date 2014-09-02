<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Jekkilekki
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
            <?php get_sidebar('footer'); ?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'jekkilekki' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'jekkilekki' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'jekkilekki' ), 'Jekkilekki', '<a href="http://www.aaronsnowberger.com" rel="designer">Aaron Snowberger</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

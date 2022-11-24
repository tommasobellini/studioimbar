<?php
/**
 * The template for displaying the footer
 *
 */

$afe = new ZoacresFooterElements;

?>


	</div><!-- .zoacres-content-wrapper -->

	<footer class="site-footer<?php $afe->zoacresFooterLayout(); ?>">
		<?php echo zoacres_ads_out( $afe->zoacresThemeOpt( 'footer-ads-list' ) );	?>
		<?php $afe->zoacresFooterElements(); ?>
		
		<?php $afe->zoacresFooterBacktoTop(); ?>
	</footer><!-- #colophon -->

</div><!-- #page -->
<?php 
	
	/*
	 * Footer Actions	 	
	 * Log/Register Form - zoacresLogRegisterForm - 10
	 */
	do_action('zoacres_footer_action');
	
	/*
	 * Footer Filters	 
	 * Full Search - factrieFullSearchWrap - 10
	 */
	echo apply_filters( 'zoacres_footer_search_filter', '' );
	
	wp_footer();
	
?>

</body>
</html>

<?php
/**
 * Template Name: IDX Template
 */
 
//Header
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'page'; // template id
$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

?>

<div class="zoacres-content zoacres-content-idx <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php $ahe->zoacresPageTitle( $template ); ?>

		<div class="zoacres-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="col-md-8">
						<?php while ( have_posts() ) : the_post(); ?>
						
							<div id="primary" class="content-area idx-content-area clearfix">
								<?php get_template_part( 'template-parts/page/content', 'page' ); ?>
							</div><!-- #primary -->

						<?php endwhile; // End of the loop. ?>
					</div><!-- main col -->

					<div class="col-md-4">
						<aside class="widget-area right-widget-area idx-widget-area">
							<?php 
								if( is_active_sidebar( 'idx-sidebar' ) ) {
									dynamic_sidebar( 'idx-sidebar' );
								}
							?>
						</aside>
					</div><!-- sidebar col -->
					
				</div><!-- row -->
			
		</div><!-- .container -->
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

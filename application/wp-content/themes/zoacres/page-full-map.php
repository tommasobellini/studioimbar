<?php
/**
 * Template Name: Full Map
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'page'; // template id
$aps->zoacresSetPostTemplate( $template );
$full_width_class = '';

$template_class = $aps->zoacresTemplateContentClass();

$zpe = new ZoacresPropertyElements();

?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
	<?php $ahe->zoacresHeaderSlider('bottom'); ?>
		
	<?php $ahe->zoacresPageTitle( $template ); ?>

	<div class="zoacres-content-inner">
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 full-map-wrap">
					<div class="full-map-property-wrap property-map-identity">
					<?php 
						$args = array(
							'post_type' => 'zoacres-property',
							'posts_per_page' => 50,
							'order'   => 'DESC'
						);
						
						wp_enqueue_script( 'zoacres-gmaps' );
						wp_enqueue_script( 'infobox' );
						wp_enqueue_script( 'marker-clusterer' );
						
						$extra_args = array(
							'zoom_control' => true,
							'location_search' => true,
							'nav' => true,
							'map_style' => true,
							'full_screen' => true,
							'my_location' => true
						);

						$map_array = $zpe->zoacresHalfMapProperties( $args );
						$zpe->zoacresHalfMapPropertiesMakeMap( $map_array, $extra_args );
					?>
					</div> <!-- .half-map-property-wrap -->
				</div>
			</div>
		</div><!-- .container-fluid -->
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">	
					<?php 									
						//Advanced search form
						$searcg_args = array(
							'toggle' => true,
							'key_search' => true,
							'location' => true,
							'radius' => true,
							'action' => true,
							'types' => true,
							'city' => true,
							'area' => true,
							'min_rooms' => true,
							'max_rooms' => true,
							'min_bath' => true,
							'min_garage' => true,
							'min_area' => true,
							'max_area' => true,
							'price_range' => true,
							'more_search' => true
						);
						$searcg_args = apply_filters( 'zoacres_full_map_template_property_args', $searcg_args );
						$zpe->zoacresAdvanceSearch( "half-map-ajax-box", $searcg_args ); //"ajax-key-search"
					?>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
		
		<?php
			$thecontent = get_the_content();
			if(!empty($thecontent)):
		?>
		
		<div class="container full-map-property-content-area">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
					
						<?php while ( have_posts() ) : the_post(); ?>

							<div id="primary" class="content-area clearfix">
								<?php get_template_part( 'template-parts/page/content', 'page' ); ?>
							</div><!-- #primary -->

						<?php endwhile; // End of the loop. ?>
						
					</div><!-- main col -->
					
					<?php if( $template_class['lsidebar_class'] != '' ) : ?>
					<div class="<?php echo esc_attr( $template_class['lsidebar_class'] ); ?>">
						<aside class="widget-area left-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
							<?php dynamic_sidebar( $template_class['left_sidebar'] ); ?>
						</aside>
					</div><!-- sidebar col -->
					<?php endif; ?>
					
					<?php if( $template_class['rsidebar_class'] != '' ) : ?>
					<div class="<?php echo esc_attr( $template_class['rsidebar_class'] ); ?>">
						<aside class="widget-area right-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
							<?php dynamic_sidebar( $template_class['right_sidebar'] ); ?>
						</aside>
					</div><!-- sidebar col -->
					<?php endif; ?>
					
				</div><!-- row -->
			
		</div><!-- .container -->
		<?php
			endif;
		?>
		
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

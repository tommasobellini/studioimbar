<?php
/**
 * Template Name: Full Property Archive
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'page'; // template id
$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

$zpe = new ZoacresPropertyElements();

?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php $ahe->zoacresHeaderSlider('bottom'); ?>
		
		<?php $ahe->zoacresPageTitle( $template ); ?>

		<div class="zoacres-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">

						<div class="full-map-property-list-wrap property-list-identity">	
							<?php 									
								//Advanced search form
								$searcg_args = array(
									'toggle' => false,
									'key_search' => true,
									'location' => false,
									'radius' => false,
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
									'more_search' => true,
									'property_layouts' => true
								);
								$searcg_args = apply_filters( 'zoacres_full_property_archive_template_args', $searcg_args );
								$zpe->zoacresAdvanceSearch( "half-map-ajax-box", $searcg_args );
								
								//Cols
								$cols = $aps->zoacresGetThemeOpt( 'full-archive-property-grid-cols' );
								$layout = $aps->zoacresGetThemeOpt( 'full-archive-property-layout' );
								$animation = $aps->zoacresGetThemeOpt( 'archive-property-animation' );
								$ppp = $aps->zoacresGetThemeOpt( 'full-archive-property-per-page' );
							?>
							<div class="map-property-list" data-layout="<?php echo esc_attr( $layout ); ?>" data-cols="<?php echo esc_attr( $cols ); ?>" data-animation="<?php echo esc_attr( $animation ); ?>" data-ppp="<?php echo esc_attr( $ppp ); ?>">
								<?php
								
									$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
									$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
									$zpe::$cus_excerpt_len = apply_filters( 'zoacres_full_property_archive_excerpt_length', $arch_exc_len );
									
									$args = $args = array(
										'post_type' => 'zoacres-property',
										'posts_per_page' => absint( $ppp ),
										'order'   => 'DESC'
									);
									
									//Load More Check
									$cargs = $args;
									$cpaged = isset( $cargs['paged'] ) && $cargs['paged'] != '' ? absint( $cargs['paged'] ) : '1';
									$cargs['paged'] = ++$cpaged;
									$query = new WP_Query( $cargs );
									$found_posts = $query->found_posts;
									$load_more_class = '';
									if( !$found_posts ) :
										$load_more_class = ' d-hide';
									endif;
									
									
									$property_cols = 'col-lg-' . $cols;
									$property_cols .= $cols != '12' ? ' col-md-6' : '';
									
									$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
									$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
									if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
									
									$meta_args = array( 'animation' => $animation, 'layout' => $layout );
									
									$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', $property_cols, $meta_args );
									
								?>
								<div class="property-load-more-wrap text-center<?php echo esc_attr( $load_more_class ); ?>">
									<div class="property-load-more-inner">
										<a href="#" class="btn btn-default property-load-more" data-page="2"><?php esc_html_e( 'Load More', 'zoacres' ); ?></a>
										<?php
											$infinite = $zpe->zoacresPropertyThemeOpt( "infinite-loader-img" );
											$infinite_image = isset( $infinite['url'] ) && $infinite['url'] != '' ? $infinite['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
										?>
										<img src="<?php echo esc_url( $infinite_image ); ?>" class="img-fluid property-loader" alt="<?php esc_attr_e( 'Loader', 'zoacres' ); ?>" />
									</div>	
								</div>
								
							</div> <!-- .map-property-list -->
						</div><!-- .full-map-property-list-wrap -->
						
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
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

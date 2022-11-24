<?php
/**
 * Template Name: Half Map
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'page'; // template id
$aps->zoacresSetPostTemplate( $template );
$full_width_class = '';

$zpe = new ZoacresPropertyElements();
$ppp = $aps->zoacresGetThemeOpt( 'property-per-page' );

?>

<div class="zoacres-content zoacres-half-map-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
	<?php $ahe->zoacresHeaderSlider('bottom'); ?>
	
	<?php $ahe->zoacresPageTitle( $template ); ?>

	<div class="zoacres-content-inner">
		<div class="container-fluid">
			<div class="row half-map-property-row">
				<div class="col-xl-6 col-lg-12">		
					<div class="half-map-property-wrap property-map-identity">
					<?php 
						$args = array(
							'post_type' => 'zoacres-property',
							'posts_per_page' => absint( $ppp ),
							'order'   => 'DESC'
						);
						
						wp_enqueue_script( 'zoacres-gmaps' );
						wp_enqueue_script( 'infobox' );
						wp_enqueue_script( 'marker-clusterer' );
						
						$extra_args = array(
							'zoom_control' => true,
							'nav' => true,
							'map_style' => true
						);

						$map_array = $zpe->zoacresHalfMapProperties( $args );
						$zpe->zoacresHalfMapPropertiesMakeMap( $map_array, $extra_args );
					?>
					</div> <!-- .half-map-property-wrap -->
				</div>
				<div class="col-xl-6 col-lg-12">	
					<div class="half-map-property-list-wrap property-list-identity">	
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
							$searcg_args = apply_filters( 'zoacres_half_map_template_property_args', $searcg_args );
							$zpe->zoacresAdvanceSearch( "half-map-ajax-box", $searcg_args );
							$animation = $aps->zoacresGetThemeOpt( 'archive-property-animation' );
							$layout = $aps->zoacresGetThemeOpt( 'full-archive-property-layout' );
						?>
						<div class="map-property-list" data-layout="<?php echo esc_attr( $layout ); ?>" data-cols="6" data-animation="<?php echo esc_attr( $animation ); ?>">
							<?php
								
								$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
								$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
								$zpe::$cus_excerpt_len = apply_filters( 'zoacres_half_map_property_excerpt_length', $arch_exc_len );
								
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
								
								$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
								$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
								if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
								
								$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', 'col-md-6' );
								
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
					</div><!-- .half-map-property-list-wrap -->
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
		
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

<?php
/**
 * Template Name: Property Search Result
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
		
	<?php $ahe->zoacresPageTitle( $template ); ?>

	<div class="zoacres-content-inner">
		
		<div class="container">
			<div class="row">
			
				<div class="full-map-wrap <?php echo esc_attr( $template_class['content_class'] ); ?>">
					<div class="property-search-result-wrap">
						<?php
							//Advanced search form
							$searcg_args = array(
								'toggle' => true,
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
								'more_search' => true
							);
							$searcg_args = apply_filters( 'zoacres_search_template_property_args', $searcg_args );
							
							$search_res_form = apply_filters( 'zoacres_search_template_ajax_form_disable', false );
							if( !$search_res_form  ) $zpe->zoacresAdvanceSearch( "half-map-ajax-box", $searcg_args );
						?>
						<div class="map-property-list" data-cols="4" data-animation="true">
							<?php 									

								//Get values from url
								// Property rooms
								$rooms_id = isset( $_GET['rooms_id'] ) ? $_GET['rooms_id'] : "";
								$no_rooms_arr = array();
								if( $rooms_id ){
									$no_rooms_arr = array(
										'key'     => 'zoacres_property_no_rooms',
										'value'   => esc_attr( $rooms_id ),
										'compare' => '>='
									);
								}
								$no_rooms_arr = !empty( $no_rooms_arr ) ? $no_rooms_arr : '';
						
								// Property bed rooms
								$bed_id = isset( $_GET['bed_id'] ) ? $_GET['bed_id'] : "";
								$bed_arr = array();
								if( $bed_id ){
									$bed_arr = array(
										'key'     => 'zoacres_property_no_bed_rooms',
										'value'   => esc_attr( $bed_id ),
										'compare' => '>='
									);
								}
								$bed_arr = !empty( $bed_arr ) ? $bed_arr : '';
								
								// Property bath rooms
								$bath_id = isset( $_GET['bath_id'] ) ? $_GET['bath_id'] : "";
								$bath_arr = array();
								if( $bath_id ){
									$bath_arr = array(
										'key'     => 'zoacres_property_no_bath_rooms',
										'value'   => esc_attr( $bath_id ),
										'compare' => '>='
									);
								}
								$bath_arr = !empty( $bath_arr ) ? $bath_arr : '';
								
								// Property garage rooms
								$garage_id = isset( $_GET['garage_id'] ) ? $_GET['garage_id'] : "";
								$garage_arr = array();
								if( $garage_id ){
									$garage_arr = array(
										'key'     => 'zoacres_property_no_garages',
										'value'   => esc_attr( $garage_id ),
										'compare' => '>='
									);
								}
								$garage_arr = !empty( $garage_arr ) ? $garage_arr : '';
								
								// Property area
								$minarea = isset( $_GET['minarea_id'] ) && $_GET['minarea_id'] != '' ? $_GET['minarea_id'] : "0";
								$maxarea = isset( $_GET['maxarea_id'] ) && $_GET['maxarea_id'] != '' ? $_GET['maxarea_id'] : "0";
								$property_size = array();
								if( $minarea || $maxarea ){
									if( $minarea != '0' &&  $maxarea == '0' ){
										$property_size = array(
											'key'     => 'zoacres_property_size',
											'value' => doubleval( esc_attr( $minarea ) ),
											'compare' => '>=',
										);
									}elseif( $maxarea != '0' &&  $minarea == '0' ){
										$property_size = array(
											'key'     => 'zoacres_property_size',
											'value' => doubleval( esc_attr( $maxarea ) ),
											'compare' => '<=',			
										);
									}else{
										$property_size = array(
											'key'     => 'zoacres_property_size',
											'value'   => array( doubleval( $minarea ), doubleval( $maxarea ) ),
											'type'	  => 'NUMERIC',
											'compare' => 'BETWEEN'				
										);
									}
								}
								$property_size = !empty( $property_size ) ? $property_size : '';
								
								// Property price
								$minprice = isset( $_GET['price_min'] ) && $_GET['price_min'] != '' ? $_GET['price_min'] : "0";
								$maxprice = isset( $_GET['price_max'] ) && $_GET['price_max'] != '' ? $_GET['price_max'] : "0";
								$property_price = array();
								if( $minprice || $maxprice ){
									$property_price = array(
										'key'     => 'zoacres_property_price',
										'value'   => array( doubleval( $minprice ), doubleval( $maxprice ) ),
										'type'	  => 'NUMERIC',
										'compare' => 'BETWEEN'				
									);
								}
								$property_price = !empty( $property_price ) ? $property_price : '';
								
								// Property Country
								$country_id = isset( $_GET['country_id'] ) ? $_GET['country_id'] : "";
								$country_tax_array = array();
								if( $country_id && $country_id != 'all' ){
									$country_tax_array = array(
										'taxonomy' => 'property-country',
										'field' => 'term_id',
										'terms' => array( $country_id ),
										'operator'=> 'IN'
									);
								}
								$country_tax_array = !empty( $country_tax_array ) ? $country_tax_array : '';
								
								// Property State
								$state_id = isset( $_GET['state_id'] ) ? $_GET['state_id'] : "";
								$state_tax_array = array();
								if( $state_id && $state_id != 'all' ){
									$state_tax_array = array(
										'taxonomy' => 'property-state',
										'field' => 'term_id',
										'terms' => array( $state_id ),
										'operator'=> 'IN'
									);
								}
								$state_tax_array = !empty( $state_tax_array ) ? $state_tax_array : '';
								
								// Property City
								$city_id = isset( $_GET['city_id'] ) ? $_GET['city_id'] : "";
								$city_tax_array = array();
								if( $city_id && $city_id != 'all' ){
									$city_tax_array = array(
										'taxonomy' => 'property-city',
										'field' => 'term_id',
										'terms' => array( $city_id ),
										'operator'=> 'IN'
									);
								}
								$city_tax_array = !empty( $city_tax_array ) ? $city_tax_array : '';
								
								// Property Area
								$area_id = isset( $_GET['area_id'] ) ? $_GET['area_id'] : "";
								$area_tax_array = array();
								if( $area_id && $area_id != 'all' ){
									$area_tax_array = array(
										'taxonomy' => 'property-area',
										'field' => 'term_id',
										'terms' => array( $area_id ),
										'operator'=> 'IN'
									);
								}
								$area_tax_array = !empty( $area_tax_array ) ? $area_tax_array : '';
								
								// Property Category
								$type_id = isset( $_GET['type_id'] ) ? $_GET['type_id'] : "";
								$type_tax_array = array();
								if( $type_id && $type_id != 'all' ){
									$type_tax_array = array(
										'taxonomy' => 'property-category',
										'field' => 'term_id',
										'terms' => array( $type_id ),
										'operator'=> 'IN'
									);
								}
								$type_tax_array = !empty( $type_tax_array ) ? $type_tax_array : '';
								
								// Property Action
						
								$action_id = isset( $_GET['action_id'] ) ? $_GET['action_id'] : "";
								$action_tax_array = array();
								if( $action_id && $action_id != 'all' ){
									$action_tax_array = array(
										'taxonomy' => 'property-action',
										'field' => 'term_id',
										'terms' => array( $action_id ),
										'operator'=> 'IN'
									);
								}
								$action_tax_array = !empty( $action_tax_array ) ? $action_tax_array : '';
								
								$meta_query = array(
									'relation' => 'AND',
									$property_price,
									$property_size,
									$no_rooms_arr,
									$bed_arr,
									$bath_arr,
									$garage_arr
								);
																
								$more_features = isset( $_GET['features'] ) && !empty( $_GET['features'] ) ? explode( ",", $_GET['features'] ) : '';
								$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
								$property_features_arr = zoacres_trim_array_same_values( $property_features );
								$feat_final = $more_features;
								if( !empty( $more_features ) ){
									foreach( $feat_final as $feature ){
									
										$more_features_arr = array(
											'key'     => 'zoacres_property_features_' . $feature,
											'value'   => $feature,
											'compare' => '='
										);
										array_push( $meta_query, $more_features_arr );
									}
								}
								
								$tax_query = array(
									'relation' => 'AND',
									$country_tax_array,
									$state_tax_array,
									$city_tax_array,
									$area_tax_array,
									$type_tax_array,
									$action_tax_array				
								);
								
								$prop_name = isset( $_GET['prop_name'] ) ? $_GET['prop_name'] : "";

								//Search archive products
								$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
								$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
								$zpe::$cus_excerpt_len = apply_filters( 'zoacres_property_search_excerpt_length', $arch_exc_len );
								
								$zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
								$ppp = $zpe->zoacresPropertyThemeOpt( 'property-per-page' );
								
								$args = array(
									'post_type' => 'zoacres-property',
									'posts_per_page' => absint( $ppp ),
									'order'   => 'DESC',
									's'		  => esc_attr( $prop_name ),
									'meta_query' => $meta_query,
									'tax_query' => $tax_query
								);
								
								$query = new WP_Query( $args );
								$found_posts = $query->found_posts;
								
								$targs = $args;
								$targs['paged'] = 2;
								$squery = new WP_Query( $targs );
								$sfound_posts = $squery->found_posts;

								$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
								$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
								if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
								
								$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', 'col-md-4' );

								if( $sfound_posts ):
							?>
								<div class="property-load-more-wrap text-center">
									<div class="property-load-more-inner">
										<a href="#" class="btn btn-default property-load-more" data-page="2"><?php esc_html_e( 'Load More', 'zoacres' ); ?></a>
										<?php
											$infinite = $zpe->zoacresPropertyThemeOpt( "infinite-loader-img" );
											$infinite_image = isset( $infinite['url'] ) && $infinite['url'] != '' ? $infinite['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
										?>
										<img src="<?php echo esc_url( $infinite_image ); ?>" class="img-fluid property-loader" alt="<?php esc_attr_e( 'Loader', 'zoacres' ); ?>" />
									</div>
								</div>
							<?php
								endif;
							?>
								
								<?php if( !$found_posts ) : ?>
								<div class="property-nothing-found"><span class="icon-dislike icons"></span><p><?php esc_html_e( 'Nothing Found!', 'zoacres' ); ?></p></div>
								<?php endif; ?>

						</div> <!-- .map-property-list -->
					</div> <!-- .property-search-result-wrap -->
				</div><!-- .col -->
				
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
				
			</div>
		</div><!-- .container -->
				
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

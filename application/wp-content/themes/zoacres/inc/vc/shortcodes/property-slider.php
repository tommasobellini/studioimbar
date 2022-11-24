<?php 
/**
 * Zoacres Property slider
 */
if ( ! function_exists( "zoacres_vc_zoproperty_slider_shortcode" ) ) {
	function zoacres_vc_zoproperty_slider_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_zoproperty_slider", $atts );
		extract( $atts );
		$output = '';
	 	$meta_args = array();
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $text_align ) && $text_align != '' ? ' text-' . $text_align : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 10;
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 15;
		$cols = isset( $zoproperty_cols ) && $zoproperty_cols != '' ? $zoproperty_cols : '3';
		$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'no';
		
		$slide_stat = 0; $data_atts = '';
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			$gal_atts = array(
				'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' ? 1 : 0 ) .'"',
				'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' ? absint( $slide_margin ) : 0 ) .'"',
				'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' ? 1 : 0 ) .'"',
				'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
				'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' ? 1 : 0 ) .'"',
				'data-autoplay="'. ( isset( $slide_item_autoplay ) && $slide_item_autoplay == 'on' ? 1 : 0 ) .'"',
				'data-items="'. ( isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 1 ) .'"',
				'data-items-tab="'. ( isset( $slide_item_tab ) && $slide_item_tab != '' ? absint( $slide_item_tab ) : 1 ) .'"',
				'data-items-mob="'. ( isset( $slide_item_mobile ) && $slide_item_mobile != '' ? absint( $slide_item_mobile ) : 1 ) .'"',
				'data-duration="'. ( isset( $slide_duration ) && $slide_duration != '' ? absint( $slide_duration ) : 5000 ) .'"',
				'data-smartspeed="'. ( isset( $slide_smart_speed ) && $slide_smart_speed != '' ? absint( $slide_smart_speed ) : 250 ) .'"',
				'data-scrollby="'. ( isset( $slide_slideby ) && $slide_slideby != '' ? absint( $slide_slideby ) : 1 ) .'"',
				'data-autoheight="false"',
			);
			$data_atts = implode( " ", $gal_atts );
			$slide_stat = 1;
		}
		
		$filter = isset( $property_filter ) ? $property_filter : 'recent';
		$filter_by = isset( $property_filter_by ) ? $property_filter_by : 'recent';
		$orderby = $days = $property_in = '';
		$order = 'DESC';
		
		//Property Category
		$property_cat = isset( $property_cat ) && $property_cat != '' ? $property_cat : '';
		$type_tax_array = '';
		if( $property_cat ){
			$property_cat = zoacres_explode_array( $property_cat );
			$type_tax_array = array(
				'taxonomy' => 'property-category',
				'field' => 'term_id',
				'terms' => $property_cat,
				'operator'=> 'IN'
			);
		}
		
		//Property Action
		$property_action = isset( $property_action ) && $property_action != '' ? $property_action : '';
		$type_action_array = '';
		if( $property_action ){
			$property_cat = zoacres_explode_array( $property_action );
			$type_action_array = array(
				'taxonomy' => 'property-action',
				'field' => 'term_id',
				'terms' => $property_action,
				'operator'=> 'IN'
			);
		}
		
		if( $filter == 'recent' ){ // ascending order
			$order = 'DESC';
		}elseif( $filter == 'asc' ){ // ascending order
			$order = 'ASC';
		}elseif( $filter == 'random' ){
			$orderby = 'rand';
		}
			
		
		$meta_query = array();
		if( $filter_by == 'comment' ){ // comment
			$orderby = 'comment_count';
		}elseif( $filter_by == 'days' ){ // days
			$orderby = 'date';
			$days = isset( $days_count ) && $days_count != '' ? array( array( 'after' => absint( $days_count ) . ' days ago' ) ) : '';
		}elseif( $filter_by == 'custom' ){ // comment
			$orderby = 'post__in';
			$property_in = isset( $include_property_ids ) && $include_property_ids != '' ? zoacres_explode_array( $include_property_ids ) : '';
		}elseif( $filter_by == "featured" ){
			$meta_query = array(
				array(
					'key' => 'zoacres_post_featured_stat',
					'value' => true,
				)
			);
		}
		
		$property_not_in = isset( $exclude_property_ids ) && $exclude_property_ids != '' ? zoacres_explode_array( $exclude_property_ids ) : '';
		$output .= '<div class="map-property-list property-sc-slider'. esc_attr( $class_names ) .'">';
				
			$zpe = new ZoacresPropertyElements();
			$zpe::$cus_excerpt_len = $excerpt_length;
			
			$args = array(
				'post_type' => 'zoacres-property',
				'posts_per_page' => absint( $ppp ),
				'order' => $order,
				'orderby' => $orderby,					
				'date_query' => $days,
				'post__in' => $property_in,
				'post__not_in' => $property_not_in,
				'tax_query' => array(
					'relation' => 'AND',
					$type_tax_array,
					$type_action_array
				),
				'meta_query' => $meta_query		
			);
			
			$zoproperty_items = isset( $zoproperty_items ) ? zoacres_drag_and_drop_trim( $zoproperty_items ) : array( 'Enabled' => '' );
			$prop_elements = isset( $zoproperty_items['Enabled'] ) ? $zoproperty_items['Enabled'] : '';
			
			if( isset( $image_size ) ){
				$image_size = $image_size != '' ? $image_size : 'medium';
				if( $image_size == 'custom' ){
					$custom_image_size = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '500x500';
				}
			}
			
			$read_more = isset( $more_text ) && $more_text != '' ? $more_text : esc_html__( 'Read More', 'zoacres' );
			
			$meta_args = array();
			$meta_args['overlay_opt'] = false;
			$meta_args['shortcode_stat'] = false;
			
			$col_class = $animate_grid == 'on' ? 'zoacres-animate' : '';
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
			
				if( $slide_stat ){
					$output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
					$col_class .= ' property-item';
				}else{
					$output .= '<div class="row">';
					$col_class .= ' col-md-' . esc_attr( $cols );
				}
				
				$units = $zpe->zoacresGetPropertyUnits();
			
				while ( $query->have_posts() ) {
			
					$query->the_post();
					$property_id = get_the_ID();
				
					$output .= '<div class="'. esc_attr( $col_class ) .'">';
						$output .= '<div class="property-wrap">';
						
							$output .= '<div class="property-image-wrap">';
								if( $image_size == "custom" ){
									$custom_opt = $custom_image_size != '' ? explode( "x", $custom_image_size ) : array();
									$img_prop = zoacres_custom_image_size_chk( $image_size, $custom_opt );
									$image_size = array( $img_prop[1], $img_prop[2] );
								}
								ob_start();
								$zpe->zoacresPropertyImage( $property_id, $image_size, '', $meta_args );
								$output .= ob_get_clean();
								if ( $prop_elements ): 
									$output .= '<div class="container"><div class="row"><div class="col-md-12">';
										$output .= '<div class="property-overlay-wrap">';
											ob_start();
											foreach ( $prop_elements as $element => $value ) {
												switch( $element ) {
													case "title":
													?>
														<div class="property-title-wrap">
															<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h5>
														</div>
													<?php
													break;
													
													case "price":
													?>
														<div class="property-price-wrap">
															<?php $zpe->zoacresGetPropertyPrice('span', 'div'); ?>
														</div>
													<?php
													break;
													
													case "address":
														$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
														$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
														$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
														$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
														$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
														$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
														echo '<div class="property-area"><span class="icon-location-pin"></span> ';
														echo ( ''. $property_area_link != '' ) ? '<a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, ' : '';
														echo ( ''. $property_city_link != '' ) ? '<a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a>' : '';
														echo '</div>';
													break;
													
													case "excerpt":
														add_filter( 'excerpt_length', array( &$zpe, 'zoacresSetPropertyExcerptLength' ), 999 );
													?>
														<div class="property-excerpt-wrap">
															<?php the_excerpt(); ?>
														</div>
													<?php
													break;
													
													case "more":
													?>
														<div class="property-read-more"><a href="<?php echo esc_url( get_the_permalink() ); ?>" class="btn btn-sm btn-primary"><?php echo esc_html( $read_more ); ?></a></div>
													<?php
													break;
													
													case "meta":
													?>
														<div class="property-slider-meta">
															<?php
																$plot_area = get_post_meta( $property_id, 'zoacres_property_size', true );
																$bed_rooms = get_post_meta( $property_id, 'zoacres_property_no_bed_rooms', true );
																$bath_rooms = get_post_meta( $property_id, 'zoacres_property_no_bath_rooms', true );
															?>
															<ul class="nav key-search-list">
																<?php if( $plot_area ): ?>
																<li class="property-size"><span class="flaticon-area-chart"></span><?php echo esc_html( $plot_area .' '. $units ); ?></li>
																<?php endif; if( $bed_rooms ): ?>
																<li class="property-bed-rooms"><span class="flaticon-slumber"></span><?php echo esc_html( $bed_rooms ); ?></li>
																<?php endif; if( $bath_rooms ): ?>
																<li class="property-bath-rooms"><span class="flaticon-bathtub"></span><?php echo esc_html( $bath_rooms ); ?></li>
																<?php endif; ?>
															</ul>
														</div>
													<?php
													break;
													
												}
											}
											$output .= ob_get_clean();
										$output .= '</div><!-- .property-overlay-wrap -->';
									$output .= '</div></div></div><!-- .container -->';
								endif;
							$output .= '</div><!-- .property-image-wrap -->';
						$output .= '</div><!-- .property-wrap -->';
					$output .= '</div><!-- .property-item/.col -->';	
				} // end while
				$output .= '</div><!-- .owl/.row -->';
			}
			wp_reset_postdata();
		
		$output .= '</div> <!-- .map-property-list -->';
		return $output;
	}
}
if ( ! function_exists( "zoacres_vc_zoproperty_slider_shortcode_map" ) ) {
	function zoacres_vc_zoproperty_slider_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Property Slider", "zoacres" ),
				"description"			=> esc_html__( "Property slider.", "zoacres" ),
				"base"					=> "zoacres_vc_zoproperty_slider",
				"category"				=> esc_html__( "Shortcodes", "zoacres" ),
				"icon"					=> "zozo-vc-icon",
				"params"				=> array(
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Extra Class", "zoacres" ),
						"param_name"	=> "extra_class",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Property Per Page", "zoacres" ),
						"description"	=> esc_html__( "Here you can define post limits per page. Example 10", "zoacres" ),
						"param_name"	=> "post_per_page",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Excerpt Length", "zoacres" ),
						"description"	=> esc_html__( "Here you can define post excerpt length. Example 10", "zoacres" ),
						"param_name"	=> "excerpt_length",
						"value" 		=> "15"
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Read More Text", "zoacres" ),
						"description"	=> esc_html__( "Here you can enter read more text instead of default text.", "zoacres" ),
						"param_name"	=> "more_text",
						"value" 		=> esc_html__( "Read More", "zoacres" ),
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Property Category ID\'s', "zoacres" ),
						'param_name'	=> 'property_cat',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter property category id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Property Action ID\'s', "zoacres" ),
						'param_name'	=> 'property_action',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter property action id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Filter", "zoacres" ),
						"param_name"	=> "property_filter",
						"value"			=> array(
							esc_html__( "Recent Property(Descending)", "zoacres" )	=> "recent",
							esc_html__( "Older Property(Ascending)", "zoacres" )		=> "asc",
							esc_html__( "Random", "zoacres" )					=> "random"
						),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Filter By", "zoacres" ),
						"param_name"	=> "property_filter_by",
						"value"			=> array(
							esc_html__( "None", "zoacres" )				=> "none",
							esc_html__( "Most Commented", "zoacres" )	=> "comment",
							esc_html__( "From Custom Days", "zoacres" )	=> "days",
							esc_html__( "Custom Propery IDs", "zoacres" )	=> "custom",
							esc_html__( "Featured Properties", "zoacres" )	=> "featured"
						),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Enter Days', "zoacres" ),
						'param_name'	=> 'days_count',
						'description'	=> esc_html__( 'if enter 10 means, it\'s showing last 10 days properties.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "property_filter_by", "value" => 'days' ),
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Include Property ID\'s', "zoacres" ),
						'param_name'	=> 'include_property_ids',
						'description'	=> esc_html__( 'Manually enter property id\'s for include. These property ordered not based on Ascending, Descending or Random. eg: 21, 15, 30', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "property_filter_by", "value" => 'custom' ),
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Exclude Property ID\'s', "zoacres" ),
						'param_name'	=> 'exclude_property_ids',
						'description'	=> esc_html__( 'Manually enter property id\'s for exclude. eg: 21, 15, 30', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Grid Load Animation", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property grid animate when load.", "zoacres" ),
						"param_name"	=> "animate_grid",
						"value"			=> "on",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Property Columns", "zoacres" ),
						"description"	=> esc_html__( "This is option for property columns.", "zoacres" ),
						"param_name"	=> "zoproperty_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
						),
						'std'			=> '4',
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property custom layout. here you can set your own layout. Drag and drop needed property items to Enabled part.", "zoacres" ),
						'param_name'	=> 'zoproperty_items',
						'dd_fields' => array ( 
							'Enabled'  => array(
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'price'	=> esc_html__( 'Price', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' )
							),
							'disabled' => array(
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'meta'	=> esc_html__( 'Property Meta', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is option for property text align", "zoacres" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Image Size", "zoacres" ),
						"param_name"	=> "image_size",
						'description'	=> esc_html__( 'Choose thumbnail size for display different size image.', 'zoacres' ),
						"value"			=> array(
							esc_html__( "Grid Large", "zoacres" ) 	=> "zoacres-grid-large",
							esc_html__( "Grid Medium", "zoacres" ) 	=> "zoacres-grid-medium",
							esc_html__( "Grid Small", "zoacres" ) 	=> "zoacres-grid-small",
							esc_html__( "Medium", "zoacres" ) 		=> "medium",
							esc_html__( "Large", "zoacres" )		=> "large",
							esc_html__( "Thumbnail", "zoacres" )	=> "thumbnail",
							esc_html__( "Custom", "zoacres" ) 		=> "custom",
						),
						'std'			=> 'medium',
						'group'			=> esc_html__( 'Image', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Custom Image Size', "zoacres" ),
						'param_name'	=> 'custom_image_size',
						'description'	=> esc_html__( 'Enter custom image size. eg: 200x200', 'zoacres' ),
						'value' 		=> '',
						"dependency"	=> array(
								"element"	=> "image_size",
								"value"		=> "custom"
						),
						'group'			=> esc_html__( 'Image', 'zoacres' )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider option. If you enable slide option then slide columns using instead grid columns. Limited options only working with slide.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is option for property slider scroll by.", "zoacres" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_zoproperty_slider_shortcode_map" );
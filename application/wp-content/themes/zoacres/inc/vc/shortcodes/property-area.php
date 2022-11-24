<?php 
/**
 * Zoacres Property Area
 */

if ( ! function_exists( "zoacres_vc_zoproperty_area_shortcode" ) ) {
	function zoacres_vc_zoproperty_area_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_zoproperty_area", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();

		$cols = isset( $zoproperty_area_cols ) && $zoproperty_area_cols != '' ? $zoproperty_area_cols : '3';
		$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'off';
		$title_element = isset( $title_element ) && $title_element != '' ? $title_element : 'h3';
		
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
		
		//get_term_by('id', 12, 'category')

		/*$property_cat = isset( $property_filter ) && $property_filter != '' ? $property_filter : 'city';
		if( $property_cat == 'city' ){
			if( isset( $property_city ) && $property_city != '' ){
				$property_city_arr = zoacres_explode_array( $property_city );
				if( is_array( $property_city_arr ) ){
					foreach( $property_city_arr as $city ){
						$term = term_exists( absint( $city ), 'property-city' );
						if ( $term !== 0 && $term !== null ) {
							$city_arr = get_term_by('id', absint( $city ), 'property-city');
							$term_link = get_term_link( $city_arr );
							$output .= '<div class="property-city">';
								$output .= '<div class="property-city-inner">';
									$output .= '<div class="property-city-content">';
										$output .= '<h3><a href="'. esc_url( $term_link ) .'">'. esc_html( $city_arr->name ) .'</a></h3>';
										$output .= '<p>'. esc_html( $city_arr->count ) .' '. esc_html__(  'Listings', 'zoacres' ) .'</p>';
									$output .= '</div><!-- .property-city-content -->';
								$output .= '</div><!-- .property-city-inner -->';
							$output .= '</div><!-- .property-city -->';
						}
					}
				}
			}
		}*/
		
		$property_cat = isset( $property_filter ) && $property_filter != '' ? $property_filter : 'city';
		$property_filter_arr = $filter_key = '';
		if( $property_cat == 'city' ){
			$filter_key = 'property-city';
			if( isset( $property_city ) && $property_city != '' ){
				$property_filter_arr = zoacres_explode_array( $property_city );
			}
		}elseif( $property_cat == 'area' ){
			$filter_key = 'property-area';
			if( isset( $property_area ) && $property_area != '' ){
				$property_filter_arr = zoacres_explode_array( $property_area );
			}
		}
		
		
		
		$class_names .= isset( $text_align ) && $text_align != '' ? ' text-' . $text_align : '';
		$cols = $animate_grid != 'off' ? 'zoacres-animate' : '';
		
		if( $slide_stat ){
			$cols .= ' property-area-item';
			$class_names .= ' property-area-slide owl-carousel';
		}else{
			$class_names .= ' row';
			$cols .= isset( $zoproperty_area_cols ) && $zoproperty_area_cols != '' ? ' col-md-' . $zoproperty_area_cols : ' col-md-4';
		}
		
		$excerpt_opt = isset( $excerpt_opt ) && $excerpt_opt == 'yes' ? true : false;
		$excerpt_len = isset( $excerpt_len ) && $excerpt_len != '' ? $excerpt_len : 10;
		
		if( !empty( $property_filter_arr ) ){
			$output .= '<div class="'. esc_attr( $class_names ) .'" '. ( $data_atts ) .'>';
				foreach( $property_filter_arr as $filter ){
					$term = term_exists( absint( $filter ), $filter_key );
					if ( $term !== 0 && $term !== null ) {
						$filter_arr = get_term_by('id', absint( $filter ), $filter_key);
						$term_link = get_term_link( $filter_arr );
						$term_image = get_term_meta( absint( $filter ), 'bg-image-id', true);
						$image_url = wp_get_attachment_url( $term_image );
						
						//New code added
						$args = array(
							'post_type'     => 'zoacres-property', //post type, I used 'product'
							'post_status'   => 'publish', // just tried to find all published post
							'posts_per_page' => -1,  //show all
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => $filter_key,  //taxonomy name  here, I used 'product_cat'
									'field' => 'id',
									'terms' => array( absint( $filter ) )
								)
							)
						);

						$query = new WP_Query( $args);
						$tax_property_count = (int)$query->post_count; //$filter_arr->count
						//New code ended
						
						$output .= '<div class="'. esc_attr( $cols ) .'">';
							$output .= '<div class="property-area-wrap">';
								$output .= '<div class="property-area-inner" style="background-image: url('. esc_url( $image_url ) .');">';
									$output .= '<span class="property-area-overlay"></span>';
									$output .= '<div class="property-area-content typo-white">';
										$output .= '<'. esc_attr( $title_element ) .'><a href="'. esc_url( $term_link ) .'">'. esc_html( $filter_arr->name ) .'</a></'. esc_attr( $title_element ) .'>';
										$output .= '<p>'. esc_html( $tax_property_count ) .' '. esc_html__(  'Listings', 'zoacres' ) .'</p>';
										if( $excerpt_opt ){
											$term_content = term_description( absint( $filter ), $filter_key );
											$term_content = $term_content != '' ? wp_trim_words( $term_content, absint( $excerpt_len ), '' ) : '';
											if( $term_content ){
												$output .= '<div class="property-area-excerpt">';
													$output .= $term_content;
												$output .= '</div><!-- .property-area-excerpt -->';
											}
										}
									$output .= '</div><!-- .property-area-content -->';
								$output .= '</div><!-- .property-area-inner -->';
							$output .= '</div><!-- .property-area -->';
						$output .= '</div><!-- .col -->';
					}
				}
			$output .= '</div><!-- .row -->';
		}

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_zoproperty_area_shortcode_map" ) ) {
	function zoacres_vc_zoproperty_area_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Property Area/City", "zoacres" ),
				"description"			=> esc_html__( "Property area/city filter.", "zoacres" ),
				"base"					=> "zoacres_vc_zoproperty_area",
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Excerpt Option", "zoacres" ),
						"description"	=> esc_html__( "This is option for except content.", "zoacres" ),
						"param_name"	=> "excerpt_opt",
						"value"			=> array(
							esc_html__( "No", "zoacres" )	=> "no",
							esc_html__( "Yes", "zoacres" )	=> "yes"
						)
					),	
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Excerpt Length", "zoacres" ),
						"param_name"	=> "excerpt_len",
						"value" 		=> "",
						"dependency" => array( "element" => "excerpt_opt", "value" => 'yes' ),
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Select Area/City", "zoacres" ),
						"param_name"	=> "property_filter",
						"value"			=> array(
							esc_html__( "City", "zoacres" )	=> "city",
							esc_html__( "Area", "zoacres" )	=> "area"
						),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Property Filter ID\'s', "zoacres" ),
						'param_name'	=> 'property_city',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter property filter type(area/city) id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "property_filter", "value" => 'city' ),
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Property Area ID\'s', "zoacres" ),
						'param_name'	=> 'property_area',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter property area id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "property_filter", "value" => 'area' ),
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
						"heading"		=> esc_html__( "Title Element", "zoacres" ),
						"description"	=> esc_html__( "This is option for city or area title element.", "zoacres" ),
						"param_name"	=> "title_element",
						"value"			=> array(
							esc_html__( "H2", "zoacres" )	=> "h2",
							esc_html__( "H3", "zoacres" )	=> "h3",
							esc_html__( "H4", "zoacres" )	=> "h4",
							esc_html__( "H5", "zoacres" )	=> "h5",
							esc_html__( "H6", "zoacres" )	=> "h6",
						),
						"std"			=> 'h3',
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Property Columns", "zoacres" ),
						"description"	=> esc_html__( "This is option for property columns.", "zoacres" ),
						"param_name"	=> "zoproperty_area_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
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
add_action( "vc_before_init", "zoacres_vc_zoproperty_area_shortcode_map" );
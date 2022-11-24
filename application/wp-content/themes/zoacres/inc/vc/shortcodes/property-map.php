<?php 
/**
 * Zoacres Property Map
 */

if ( ! function_exists( "zoacres_vc_property_map_shortcode" ) ) {
	function zoacres_vc_property_map_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_property_map", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		$output .= '<div class="zoacres-search-property-wrap '. esc_attr( $class_names ) .'">';

			//Create property class object
			$zpe = new ZoacresPropertyElements();

			//Property Code Start
			$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 10;
			$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 15;
			$cols = isset( $zoproperty_cols ) && $zoproperty_cols != '' ? $zoproperty_cols : '3';
			$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'no';
			
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
			$data_animate = $animate_grid == 'on' ? true : false;
			
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
	
			//Property Map Start
			$map_height = isset( $map_height ) && $map_height != '' ? $map_height : '500px';
			$map_zoom_control = isset( $map_zoom_control ) && $map_zoom_control == 'on' ? true : false;
			$map_zoom_level = isset( $map_zoom_level ) && $map_zoom_level != '' ? absint( $map_zoom_level ) : '15';
			$map_nav = isset( $map_nav ) && $map_nav == 'on' ? true : false;
			$map_style = isset( $map_style ) && $map_style == 'on' ? true : false;
			$map_location_search = isset( $map_location_search ) && $map_location_search == 'on' ? true : false;
			$map_fullscreen = isset( $map_fullscreen ) && $map_fullscreen == 'on' ? true : false;
			$map_my_location = isset( $map_my_location ) && $map_my_location == 'on' ? true : false;
			
			$map_array = $zpe->zoacresHalfMapProperties( $args );
			$map_args = array(
				'height' => esc_attr( $map_height ),
				'zoom_control' => $map_zoom_control,
				'zoom' => $map_zoom_level,
				'location_search' => $map_location_search,
				'nav' => $map_nav,
				'map_style' => $map_style,
				'full_screen' => $map_fullscreen,
				'my_location' => $map_my_location
			);
			$output .= '<div class="full-map-property-wrap property-map-identity">';
				ob_start();
					$zpe->zoacresHalfMapPropertiesMakeMap( $map_array, $map_args );
				$output .= ob_get_clean();
			$output .= '</div>';
			
			wp_enqueue_script( 'zoacres-gmaps' );
			wp_enqueue_script( 'infobox' );
			wp_enqueue_script( 'marker-clusterer' );				
			//Property Map End
			
			//Floating search 
			$float_search = isset( $float_search ) ? $float_search : 'none';
			if( $float_search != 'none' ){
			
				$search_toggle = isset( $search_toggle ) && $search_toggle == 'on' ? true : false;
				$search_key = isset( $search_key ) && $search_key == 'on' ? true : false;
				$search_action = isset( $search_action ) && $search_action == 'on' ? true : false;
				$search_types = isset( $search_types ) && $search_types == 'on' ? true : false;
				$search_city = isset( $search_city ) && $search_city == 'on' ? true : false;
				$search_area = isset( $search_area ) && $search_area == 'on' ? true : false;
				$search_rooms = isset( $search_rooms ) && $search_rooms == 'on' ? true : false;
				$search_bed = isset( $search_bed ) && $search_bed == 'on' ? true : false;
				$search_bath = isset( $search_bath ) && $search_bath == 'on' ? true : false;
				$search_garage = isset( $search_garage ) && $search_garage == 'on' ? true : false;
				$search_min_area = isset( $search_min_area ) && $search_min_area == 'on' ? true : false;
				$search_max_area = isset( $search_max_area ) && $search_max_area == 'on' ? true : false;
				$search_price = isset( $search_price ) && $search_price == 'on' ? true : false;
				$search_more = isset( $search_more ) && $search_more == 'on' ? true : false;
				$search_location = isset( $search_location ) && $search_location == 'on' ? true : false;
				$search_radius = isset( $search_radius ) && $search_radius == 'on' ? true : false;
	
				$searcg_args = array(
					'toggle' => $search_toggle,
					'key_search' => $search_key,
					'location' => $search_location,
					'radius' => $search_radius,
					'action' => $search_action,
					'types' => $search_types,
					'city' => $search_city,
					'area' => $search_area,
					'min_rooms' => $search_rooms,
					'max_rooms' => $search_bed,
					'min_bath' => $search_bath,
					'min_garage' => $search_garage,
					'min_area' => $search_min_area,
					'max_area' => $search_max_area,
					'price_range' => $search_price,
					'more_search' => $search_more
				);
					
				$output .= $float_search == 'float' ? '<div class="floating-search-wrap">' : '';
					$output .= '<div class="container">';
						$float_form_class = '';
						if( $float_search != 'normal' ){
							$output .= '<a class="btn btn-primary" data-toggle="collapse" href="#advance-search-form" aria-expanded="false">'. esc_html__( 'Advance Search', 'zoacres' ) .'</a>';
							$float_form_class = ' collapse';
						}
						$output .= '<div id="advance-search-form" class="advance-search-form-accordion'. esc_attr( $float_form_class ) .'">';
							ob_start();
								$zpe->zoacresAdvanceSearch( "", $searcg_args, "search-form-redirect search-form-part-redirect" ); //"ajax-key-search" //search-form-redirect, search-form-part-redirect
							$output .= ob_get_clean();
						$output .= '</div>';
					$output .= '</div>';
				$output .= $float_search == 'float' ? '</div><!-- .floating-search-wrap -->' : '';
			}
	
		$output .= '</div><!-- .zoacres-search-property-wrap -->';	

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_property_map_shortcode_map" ) ) {
	function zoacres_vc_property_map_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Property Map", "zoacres" ),
				"description"			=> esc_html__( "Properies map with form.", "zoacres" ),
				"base"					=> "zoacres_vc_property_map",
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
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Load More", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property load more.", "zoacres" ),
						"param_name"	=> "load_more",
						"value"			=> "off",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),	
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property pagination.", "zoacres" ),
						"param_name"	=> "pagination",
						"value"			=> "off",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),	
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Map Height", "zoacres" ),
						"description"	=> esc_html__( "Here you can define map height. Example 500px", "zoacres" ),
						"param_name"	=> "map_height",
						"value" 		=> "500px",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map Zoom", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map zoom control.", "zoacres" ),
						"param_name"	=> "map_zoom_control",
						"value"			=> "on",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Map Zoom Level", "zoacres" ),
						"description"	=> esc_html__( "Here you can define map zoom level. Example 15", "zoacres" ),
						"param_name"	=> "map_zoom_level",
						"value" 		=> "15",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map navigation control.", "zoacres" ),
						"param_name"	=> "map_nav",
						"value"			=> "on",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map Style", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map style dropdown.", "zoacres" ),
						"param_name"	=> "map_style",
						"value"			=> "on",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map Location Search", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map location search.", "zoacres" ),
						"param_name"	=> "map_location_search",
						"value"			=> "off",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map Fullscreen", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map fullscreen control.", "zoacres" ),
						"param_name"	=> "map_fullscreen",
						"value"			=> "on",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Map My Location", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable map my location control.", "zoacres" ),
						"param_name"	=> "map_my_location",
						"value"			=> "off",
						"group"			=> esc_html__( "Map", "zoacres" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Float Search", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form normal or floating on map.", "zoacres" ),
						"param_name"	=> "float_search",
						"value"			=> array(
							esc_html__( "None", "zoacres" )		=> "none",
							esc_html__( "Normal", "zoacres" )	=> "normal",
							esc_html__( "Float", "zoacres" )	=> "float",
						),
						"std"			=> 'none',
						'group'			=> esc_html__( 'Search', 'zoacres' )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Search Toggle", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form toggle options.", "zoacres" ),
						"param_name"	=> "search_toggle",
						"value"			=> "off",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Key Search", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form key search box.", "zoacres" ),
						"param_name"	=> "search_key",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Action", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property action.", "zoacres" ),
						"param_name"	=> "search_action",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Type", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property types.", "zoacres" ),
						"param_name"	=> "search_types",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property City", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property city.", "zoacres" ),
						"param_name"	=> "search_city",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Area", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property area.", "zoacres" ),
						"param_name"	=> "search_area",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Rooms", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property rooms.", "zoacres" ),
						"param_name"	=> "search_rooms",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Bed Rooms", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property bed rooms.", "zoacres" ),
						"param_name"	=> "search_bed",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Bath", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property bath rooms.", "zoacres" ),
						"param_name"	=> "search_bath",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Garage", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property garage rooms.", "zoacres" ),
						"param_name"	=> "search_garage",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Location", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form location field.", "zoacres" ),
						"param_name"	=> "search_location",
						"value"			=> "off",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Radius", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form radius field.", "zoacres" ),
						"param_name"	=> "search_radius",
						"value"			=> "off",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Min Area", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property minimum area.", "zoacres" ),
						"param_name"	=> "search_min_area",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Max Area", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property max area.", "zoacres" ),
						"param_name"	=> "search_max_area",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Price Ranger", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property price ranger.", "zoacres" ),
						"param_name"	=> "search_price",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property More Features", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable search form property more features search.", "zoacres" ),
						"param_name"	=> "search_more",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_property_map_shortcode_map" );
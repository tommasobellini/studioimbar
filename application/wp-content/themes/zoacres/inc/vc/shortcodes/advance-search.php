<?php 
/**
 * Zoacres Advance Search
 */

if ( ! function_exists( "zoacres_vc_advance_search_shortcode" ) ) {
	function zoacres_vc_advance_search_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_advance_search", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $form_layouts ) ? ' advance-search-' . $form_layouts : ' advance-search-style-1';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		$output .= '<div class="zoacres-advance-search-form-wrap '. esc_attr( $class_names ) .'">';
			
			//Create property class object
			$zpe = new ZoacresPropertyElements();
			
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
			$search_submit = isset( $search_submit ) && $search_submit == 'on' ? true : false;
			$search_saved = isset( $search_saved ) && $search_saved == 'on' ? true : false;
			$search_placeholder = isset( $search_placeholder ) ? $search_placeholder : '';			
			
			$auto_suggestion_class = isset( $auto_suggestion ) && $auto_suggestion == 'on' ? "ajax-key-search" : "";
			
			//Searchform Code Start
			$searcg_args = array(
				'toggle' => $search_toggle,
				'key_search' => $search_key,
				'location' => false,
				'radius' => false,
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
				'more_search' => $search_more,
				'no_filter' => true,
				'no_submit' => $search_submit,
				'no_saved' => true,
				'placeholder' => $search_placeholder
			);
			ob_start();
			$zpe->zoacresAdvanceSearch( $auto_suggestion_class, $searcg_args, "search-form-redirect" ); //ajax-key-search -> first argument
			$output .= ob_get_clean();
			
			//Searchform Code End
			
		$output .= '</div>';	
		
		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_advance_search_shortcode_map" ) ) {
	function zoacres_vc_advance_search_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Advance Search", "zoacres" ),
				"description"			=> esc_html__( "Advance search form.", "zoacres" ),
				"base"					=> "zoacres_vc_advance_search",
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
						"heading"		=> esc_html__( "Layout", "zoacres" ),
						"description"	=> esc_html__( "This is option for advance search layout.", "zoacres" ),
						"param_name"	=> "form_layouts",
						"value"			=> array(
							esc_html__( "Style 1", "zoacres" )	=> "style-1",
							esc_html__( "Style 2", "zoacres" )	=> "style-2",
							esc_html__( "Style 3", "zoacres" )	=> "style-3"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Add Your placeholder Text", "zoacres" ),
						"param_name"	=> "search_placeholder",
						"value" 		=> "",
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
						"heading"		=> esc_html__( "Auto Suggestion", "zoacres" ),
						"description"	=> esc_html__( "This is option for auto suggestion when search entered on key search box.", "zoacres" ),
						"param_name"	=> "auto_suggestion",
						"value"			=> "off",
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
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Disable Saved Search", "zoacres" ),
						"description"	=> esc_html__( "This is option for disable saved search.", "zoacres" ),
						"param_name"	=> "search_saved",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Submit Disable", "zoacres" ),
						"description"	=> esc_html__( "This is option for disable the bottom submit button.", "zoacres" ),
						"param_name"	=> "search_submit",
						"value"			=> "on",
						"group"			=> esc_html__( "Search", "zoacres" )
					)					
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_advance_search_shortcode_map" );
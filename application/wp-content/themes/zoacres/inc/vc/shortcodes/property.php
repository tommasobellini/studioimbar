<?php 
/**
 * Zoacres Property
 */

if ( ! function_exists( "zoacres_vc_zoproperty_shortcode" ) ) {
	function zoacres_vc_zoproperty_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_zoproperty", $atts );
		extract( $atts );

		$output = '';
	 	$meta_args = array();
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $zoproperty_model ) ? ' property-model-' . $zoproperty_model : ' property-model-1';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$layout = isset( $zoproperty_layout ) ? $zoproperty_layout : 'grid';
			$space_class_name = '';
			if( $layout == 'list' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . '.property-sc-wrapper .property-wrap .property-list-wrap >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.property-sc-wrapper .property-wrap >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 10;
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 15;
		$cols = isset( $zoproperty_cols ) && $zoproperty_cols != '' ? $zoproperty_cols : '3';
		$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'no';
		
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
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

		$output .= '<div class="map-property-list property-sc-wrapper'. esc_attr( $class_names ) .'" data-cols="'. esc_attr( $cols ) .'" data-ppp="'. esc_attr( $ppp ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				
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
				
				// Normal Top Bottom Meta
				$meta_args = array();
				$top_meta = isset( $top_meta ) ? zoacres_drag_and_drop_trim( $top_meta ) : array( 'Left' => '', 'Right' => '' );
				$bottom_meta = isset( $bottom_meta ) ? zoacres_drag_and_drop_trim( $bottom_meta ) : array( 'Left' => '', 'Right' => '' );
				$meta_args['top_meta'] = $top_meta;
				$meta_args['bottom_meta'] = $bottom_meta;
				
				$text_align = isset( $text_align ) ? $text_align : '';
				$meta_args['text_align'] = $text_align;
				
				$meta_args['slide_stat'] = $slide_stat;
				$meta_args['data_atts'] = $data_atts;
				
				$meta_args['gallery_opt'] = isset( $gallery_opt ) ? $gallery_opt : 'no';
								
				if( isset( $overlay_meta_opt ) && $overlay_meta_opt == 'yes' ){
					// Overlay Top Bottom Meta					
					$ovrly_top_meta = isset( $overlay_top_meta ) ? zoacres_drag_and_drop_trim( $overlay_top_meta ) : array( 'Left' => '', 'Right' => '' );
					$ovrly_bottom_meta = isset( $overlay_bottom_meta ) ? zoacres_drag_and_drop_trim( $overlay_bottom_meta ) : array( 'Left' => '', 'Right' => '' );
					$overlay_items = isset( $overlay_items ) ? zoacres_drag_and_drop_trim( $overlay_items ) : array( 'Top' => '', 'Bottom' => '' );
					$meta_args['overlay_top_meta'] = $ovrly_top_meta;
					$meta_args['overlay_bottom_meta'] = $ovrly_bottom_meta;
					$meta_args['overlay_items'] = $overlay_items;
					$meta_args['overlay_opt'] = true;
				}else{
					$meta_args['overlay_opt'] = false;
				}
				
				if( isset( $more_text ) ){
					$meta_args['more_text'] = $more_text;
				}
				
				if( isset( $image_size ) ){
					$meta_args['img_size'] = $image_size != '' ? $image_size : 'medium';
					if( $image_size == 'custom' ){
						$meta_args['img_csize'] = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '500x500';
					}
				}
				
				if( isset( $zoproperty_layout ) ){
					$meta_args['layout'] = $zoproperty_layout;
					$cols = $zoproperty_layout == 'list' ? '12' : $cols;
				} 
				
				$meta_args['pagination'] = isset( $pagination ) && $pagination != '' ? $pagination : 'off';
				$meta_args['dark_overlay'] = isset( $overlay_dark ) && $overlay_dark == 'on' ? ' no-dark-overlay' : '';
				
				$col_class = 'col-lg-' . esc_attr( $cols );	
				$col_class .= $cols != '12' ? ' col-md-6' : ''; 
				$col_class .= $animate_grid == 'on' ? ' zoacres-animate' : '';

				ob_start();
				$zpe->zoacresPropertiesArchiveShortcode( $args, $prop_elements, 'archive', $col_class, $meta_args );
				$output .= ob_get_clean();
		
		$output .= '</div> <!-- .map-property-list -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_zoproperty_shortcode_map" ) ) {
	function zoacres_vc_zoproperty_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Property", "zoacres" ),
				"description"			=> esc_html__( "Property custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_zoproperty",
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
						"heading"		=> esc_html__( "Property Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property pagination.", "zoacres" ),
						"param_name"	=> "pagination",
						"value"			=> "off",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),	
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Property Model", "zoacres" ),
						"param_name"	=> "zoproperty_model",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/property/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/property/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/property/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Property Layout", "zoacres" ),
						"description"	=> esc_html__( "This is option for property layout.", "zoacres" ),
						"param_name"	=> "zoproperty_layout",
						"value"			=> array(
							esc_html__( "Grid", "zoacres" )	=> "grid",
							esc_html__( "List", "zoacres" )	=> "list"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
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
						"dependency"	=> array(
							"element"	=> "zoproperty_layout",
							"value"		=> "grid"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Gallery Instead of Image", "zoacres" ),
						"description"	=> esc_html__( "This is settings for property gallery showing instead of property image.", "zoacres" ),
						"param_name"	=> "gallery_opt",
						"value"			=> array(
							esc_html__( "No", "zoacres" )	=> "no",
							esc_html__( "Yes", "zoacres" )	=> "yes"
						),
						'std'			=> 'no',
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Disable Overlay Drak", "zoacres" ),
						"description"	=> esc_html__( "This is option for disable the dark layer of image overlay wrapper.", "zoacres" ),
						"param_name"	=> "overlay_dark",
						"value"			=> "on",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Property Overlay Meta", "zoacres" ),
						"description"	=> esc_html__( "This is settings for property shortcode property overlay meta enable or disable.", "zoacres" ),
						"param_name"	=> "overlay_meta_opt",
						"value"			=> array(
							esc_html__( "No", "zoacres" )	=> "no",
							esc_html__( "Yes", "zoacres" )	=> "yes"
						),
						'std'			=> 'no',
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Overlay Top Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is options for property overlay top meta items. You can enable the items from drag and drop to enabled part like Left/Right.", "zoacres" ),
						'param_name'	=> 'overlay_top_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'featured-ribb'	=> esc_html__( 'Featured Ribbon', 'zoacres' )						
							),
							'Right'  => array(
								'other-ribb'	=> esc_html__( 'Other Ribbon', 'zoacres' )						
							),
							'disabled' => array(
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
								'gallery'	=> esc_html__( 'Gallery', 'zoacres' ),
								'video'	=> esc_html__( 'Video', 'zoacres' ),
								'compare'	=> esc_html__( 'Compare', 'zoacres' )
								
							)
						),
						"dependency"	=> array(
								"element"	=> "overlay_meta_opt",
								"value"		=> "yes"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Overlay Bottom Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is options for property overlay bottom meta items. You can enable the items from drag and drop to enabled part like Left/Right.", "zoacres" ),
						'param_name'	=> 'overlay_bottom_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'address'	=> esc_html__( 'Address', 'zoacres' ),
							),
							'Right'  => array(
								'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
								'gallery'	=> esc_html__( 'Gallery', 'zoacres' ),
								'video'	=> esc_html__( 'Video', 'zoacres' ),
								'compare'	=> esc_html__( 'Compare', 'zoacres' )
							),
							'disabled' => array(
								'featured-ribb'	=> esc_html__( 'Featured Ribbon', 'zoacres' ),
								'other-ribb'	=> esc_html__( 'Other Ribbon', 'zoacres' )
							)
						),
						"dependency"	=> array(
								"element"	=> "overlay_meta_opt",
								"value"		=> "yes"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Overlay Items', 'zoacres' ),
						"description"	=> esc_html__( "This is options for property overlay items. You can enable the items from drag and drop to enabled part like Top/Bottom.", "zoacres" ),
						'param_name'	=> 'overlay_items',
						'dd_fields' => array ( 
							'Top'  => array(
								'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
							),
							'Bottom'  => array(
								'bottom-meta'	=> esc_html__( 'Bottom Meta', 'zoacres' )
							),
							'disabled' => array(
								'title'	=> esc_html__( 'Title', 'zoacres' )
							)
						),
						"dependency"	=> array(
								"element"	=> "overlay_meta_opt",
								"value"		=> "yes"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Top Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property shortcode property top meta.", "zoacres" ),
						'param_name'	=> 'top_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'bed'	=> esc_html__( 'Bed Rooms', 'zoacres' ),
								'bath'	=> esc_html__( 'Bath Rooms', 'zoacres' ),
								'size'	=> esc_html__( 'Property Size', 'zoacres' )
							),
							'Right'  => array(
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
							),
							'disabled' => array(
								'agent'	=> esc_html__( 'Agent', 'zoacres' ),
								'social'	=> esc_html__( 'Social Share', 'zoacres' ),
								'garage'	=> esc_html__( 'Garage', 'zoacres' ),
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
								'gallery'	=> esc_html__( 'Gallery', 'zoacres' ),
								'video'	=> esc_html__( 'Video', 'zoacres' ),
								'compare'	=> esc_html__( 'Compare', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Bottom Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property shortcode post bottom meta.", "zoacres" ),
						'param_name'	=> 'bottom_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'agent'	=> esc_html__( 'Agent', 'zoacres' )						
							),
							'Right'  => array(
								'social'	=> esc_html__( 'Social Share', 'zoacres' )
							),
							'disabled' => array(
								'bed'	=> esc_html__( 'Bed Rooms', 'zoacres' ),
								'bath'	=> esc_html__( 'Bath Rooms', 'zoacres' ),
								'size'	=> esc_html__( 'Property Size', 'zoacres' ),
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'garage'	=> esc_html__( 'Garage', 'zoacres' ),
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
								'gallery'	=> esc_html__( 'Gallery', 'zoacres' ),
								'video'	=> esc_html__( 'Video', 'zoacres' ),
								'compare'	=> esc_html__( 'Compare', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property custom layout. here you can set your own layout. Drag and drop needed property items to Enabled part.", "zoacres" ),
						'param_name'	=> 'zoproperty_items',
						'dd_fields' => array ( 
							'Enabled'  => array(
								'image'	=> esc_html__( 'Image', 'zoacres' ),
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'price'	=> esc_html__( 'Price', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' ),
								'tm'	=> esc_html__( 'Top Meta', 'zoacres' )
							),
							'disabled' => array(
								'bm'	=> esc_html__( 'Bottom Meta', 'zoacres' ),
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'title-address'	=> esc_html__( 'Title with Address', 'zoacres' )
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
							esc_html__( "Grid Large", "zoacres" )=> "zoacres-grid-large",
							esc_html__( "Grid Medium", "zoacres" )=> "zoacres-grid-medium",
							esc_html__( "Grid Small", "zoacres" )=> "zoacres-grid-small",
							esc_html__( "Medium", "zoacres" )=> "medium",
							esc_html__( "Large", "zoacres" )=> "large",
							esc_html__( "Thumbnail", "zoacres" )=> "thumbnail",
							esc_html__( "Custom", "zoacres" )=> "custom",
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
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Items Spacing", "zoacres" ),
						"description"	=> esc_html__( "Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "zoacres" ),
						"param_name"	=> "sc_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "zoacres" ),
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_zoproperty_shortcode_map" );
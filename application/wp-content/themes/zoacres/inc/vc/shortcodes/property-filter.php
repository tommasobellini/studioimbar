<?php 
/**
 * Zoacres Property
 */

if ( ! function_exists( "zoacres_vc_zoproperty_filter_shortcode" ) ) {
	function zoacres_vc_zoproperty_filter_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_zoproperty_filter", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $text_align ) && $text_align != '' ? ' text-' . $text_align : '';
		
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
		
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 10;
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 15;
		$cols = isset( $zoproperty_filter_cols ) && $zoproperty_filter_cols != '' ? $zoproperty_filter_cols : '3';
		$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'no';
		
		$filter = isset( $property_filter ) ? $property_filter : 'recent';
		$filter_by = isset( $property_filter_by ) ? $property_filter_by : 'recent';
		$orderby = $days = $property_in = '';
		$order = 'DESC';
		
		$property_cat = $all_prop_cat = isset( $property_cat ) && $property_cat != '' ? $property_cat : '';
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
		
		$filter_align .= isset( $filter_align ) && $filter_align != '' ? ' text-' . $filter_align : '';
		
		$output .= '<div class="property-filter-sc">';
		
			if( isset( $property_filter ) && $property_filter == 'on' ){
				$output .= '<div class="property-filter-wrap'. esc_attr( $filter_align ) .'">';
					$output .= '<ul class="nav property-filter">';
					$active_stat = 0;
					if( isset( $filter_all ) && $filter_all != '' ){
						$active_stat = 1;
						$output .= '<li class="nav-item"><a class="active" href="#" data-id="'. esc_attr( $all_prop_cat ) .'">'. esc_html( $filter_all ) .'</a></li>';
					}
					if( $property_cat ){
						foreach( $property_cat as $cat ){
							$term = term_exists( absint( $cat ), 'property-category' );
							if ( $term !== 0 && $term !== null ) {
								$prop_cat = get_term_by('id', absint( $cat ), 'property-category');
								if( !$active_stat ){
									$output .= '<li class="nav-item"><a class="active" href="#" data-id="'. esc_attr( $cat ) .'">'. esc_html( $prop_cat->name ) .'</a></li>';
									$active_stat = 1;
								}else{
									$output .= '<li class="nav-item"><a href="#" data-id="'. esc_attr( $cat ) .'">'. esc_html( $prop_cat->name ) .'</a></li>';
								}
							}
						}
					}
					$output .= '</ul>';
				$output .= '</div>';
			}
			
			$output .= '<div class="map-property-list property-sc-wrapper'. esc_attr( $class_names ) .'" data-cols="'. esc_attr( $cols ) .'" data-ppp="'. esc_attr( $ppp ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					
					$zpe = new ZoacresPropertyElements();
					$zpe::$cus_excerpt_len = $excerpt_length;
					
					$args = array(
						'post_type' => 'zoacres-property',
						'posts_per_page' => absint( $ppp ),
						'order' => 'DESC',
						'tax_query' => array(
							'relation' => 'AND',
							$type_tax_array				
						)					
					);
					
					$zoproperty_filter_items = isset( $zoproperty_filter_items ) ? zoacres_drag_and_drop_trim( $zoproperty_filter_items ) : array( 'Enabled' => '' );
					$prop_elements = isset( $zoproperty_filter_items['Enabled'] ) ? $zoproperty_filter_items['Enabled'] : '';
					
					// Normal Top Bottom Meta
					$meta_args = array();
					$top_meta = isset( $top_meta ) ? zoacres_drag_and_drop_trim( $top_meta ) : array( 'Left' => '', 'Right' => '' );
					$bottom_meta = isset( $bottom_meta ) ? zoacres_drag_and_drop_trim( $bottom_meta ) : array( 'Left' => '', 'Right' => '' );
					$meta_args['top_meta'] = $top_meta;
					$meta_args['bottom_meta'] = $bottom_meta;
					
					$text_align = isset( $text_align ) ? $text_align : '';
					$meta_args['text_align'] = $text_align;
					
					if( isset( $overlay_meta_opt ) && $overlay_meta_opt == 'yes' ){
						// Overlay Top Bottom Meta
						$meta_args = array();
						$ovrly_top_meta = isset( $overlay_top_meta ) ? zoacres_drag_and_drop_trim( $overlay_top_meta ) : array( 'Left' => '', 'Right' => '' );
						$ovrly_bottom_meta = isset( $overlay_bottom_meta ) ? zoacres_drag_and_drop_trim( $overlay_bottom_meta ) : array( 'Left' => '', 'Right' => '' );
						$overlay_items = isset( $overlay_items ) ? zoacres_drag_and_drop_trim( $overlay_items ) : array( 'Top' => '', 'Bottom' => '' );
						$meta_args['overlay_top_meta'] = $ovrly_top_meta;
						$meta_args['overlay_bottom_meta'] = $ovrly_bottom_meta;
						$meta_args['overlay_items'] = $overlay_items;
						$meta_args['overlay_opt'] = true;
					}else {
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
					
					if( isset( $zoproperty_filter_layout ) ){
						$meta_args['layout'] = $zoproperty_filter_layout;
						$cols = $zoproperty_filter_layout == 'list' ? '12' : $cols;
					} 
					
					$col_class = 'col-lg-' . esc_attr( $cols );
					$col_class .= $cols != '12' ? ' col-md-6' : ''; 
					$col_class .= $animate_grid == 'on' ? ' zoacres-animate' : '';
					
					$nprop_array = array(
						'prop_elements' => $prop_elements,
						'col_class' => $col_class,
						'meta_args' => $meta_args,
						'excerpt_length' => $excerpt_length,
						'animate_grid' => $animate_grid
					);
					
					$meta_args['dark_overlay'] = isset( $overlay_dark ) && $overlay_dark == 'on' ? ' no-dark-overlay' : '';
	
					ob_start();
					$zpe->zoacresPropertiesArchiveShortcode( $args, $prop_elements, 'archive', $col_class, $meta_args );
					$output .= ob_get_clean();

			$output .= '</div> <!-- .map-property-list -->';
			
			$output .= '<input type="hidden" class="prop-params" data-params="'. htmlspecialchars( json_encode( $nprop_array ), ENT_QUOTES, 'UTF-8' ) .'" />';
			
			if( isset( $property_loadmore ) && $property_loadmore == 'on' ){
				$load_text = isset( $load_text ) && $load_text != '' ? $load_text : esc_html__( "Load More Properties", "zoacres" );
				$output .= '<div class="property-loadmore-wrap text-center">';
					$output .= '<p class="no-more-property">'. esc_html__( "No more property to load.", "zoacres" ) .'</p>';
					$output .= '<a href="#" class="btn property-loadmore" data-page="2">'. esc_html( $load_text ) .'</a>';
				$output .= '</div> <!-- .property-loadmore -->';
			}
			
		$output .= '</div><!-- .property-filter-sc -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_zoproperty_filter_shortcode_map" ) ) {
	function zoacres_vc_zoproperty_filter_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Property Filter", "zoacres" ),
				"description"			=> esc_html__( "Property custom post type with filters.", "zoacres" ),
				"base"					=> "zoacres_vc_zoproperty_filter",
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
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Filter", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property filter enable/disable.", "zoacres" ),
						"param_name"	=> "property_filter",
						"value"			=> "on",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Property Load More", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable property load more button enable/disable.", "zoacres" ),
						"param_name"	=> "property_loadmore",
						"value"			=> "on",
						"group"			=> esc_html__( "Filter", "zoacres" )
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
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Load More Label", "zoacres" ),
						"description"	=> esc_html__( "Here you can set load more property label.", "zoacres" ),
						"param_name"	=> "load_text",
						"value" 		=> esc_html__( "Load More Properties", "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Filter Align", "zoacres" ),
						"description"	=> esc_html__( "This is option for property filter alignment align", "zoacres" ),
						"param_name"	=> "filter_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						"group"			=> esc_html__( "Filter", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Property Filter First Link", "zoacres" ),
						"description"	=> esc_html__( "Here you can set property filter first link text ex. All. If you leave this field empty then all filter not showing.", "zoacres" ),
						"param_name"	=> "filter_all",
						"value" 		=> esc_html__( "All", "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Property Layout", "zoacres" ),
						"description"	=> esc_html__( "This is option for property layout.", "zoacres" ),
						"param_name"	=> "zoproperty_filter_layout",
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
						"param_name"	=> "zoproperty_filter_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
						),
						'std'			=> '4',
						"dependency"	=> array(
							"element"	=> "zoproperty_filter_layout",
							"value"		=> "grid"
						),
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
								'garage'	=> esc_html__( 'Garage', 'zoacres' )
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
								'garage'	=> esc_html__( 'Garage', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Property Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property custom layout. here you can set your own layout. Drag and drop needed property items to Enabled part.", "zoacres" ),
						'param_name'	=> 'zoproperty_filter_items',
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
add_action( "vc_before_init", "zoacres_vc_zoproperty_filter_shortcode_map" );
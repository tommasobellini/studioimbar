<?php 
/**
 * Zoacres Image Grid
 */

if ( ! function_exists( "zoacres_vc_image_grid_shortcode" ) ) {
	function zoacres_vc_image_grid_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_image_grid", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $image_grid_layout ) ? ' image-grid-' . $image_grid_layout : ' image-grid-1';
		$cols = isset( $grid_cols ) ? $grid_cols : 12;
		$grids = '';
		
		$gal_atts = $data_atts = '';
		if( isset( $image_grid_images ) ){
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
			$grids = isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2;
		}
		
		if( $grids === 1 ){
			$thumb_size = 'large';
		}elseif( $grids == 2 ){
			$thumb_size = 'medium';
		}elseif( $grids == 3 ){
			$thumb_size = 'zoacres-grid-large';
		}else{
			$thumb_size = 'zoacres-grid-medium';
		}
			
		if( isset( $image_grid_images ) ){
			
			$output .= '<div class="image-grid-wrapper'. esc_attr( $class_names ) .'">';
				$row_stat = 0;
				
				//Image Grid Slide
				if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';
				
					$image_ids = explode( ',', $image_grid_images );

					foreach( $image_ids as $image_id ){
					
						if( $row_stat == 0 && $slide_opt != 'on' ) :
							$output .= '<div class="row">';
						endif;
					
						//Image Grid Slide
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="item">';
						
							$col_class = "col-lg-". absint( $cols );
							$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
							$output .= '<div class="'. esc_attr( $col_class ) .'">';
								$output .= '<div class="image-grid-inner">';
					
									$images = wp_get_attachment_image_src( $image_id, $thumb_size, true );
									$image_alt = get_post_meta( absint( $image_id ), '_wp_attachment_image_alt', true);
									$image_alt = $image_alt == '' ? esc_html__( 'Image', 'zoacres' ) : $image_alt;
									$output .='<img class="img-fluid" src="'. $images[0] .'" data-mce-src="'. $images[0] .'" alt="'. esc_attr( $image_alt ) .'" />';
									
								$output .= '</div><!-- .image-grid-inner -->';
							$output .= '</div><!-- .cols -->';
						
						//Team Slide Item End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .item -->';		
						
						$row_stat++;
						if( $row_stat == ( 12/ $cols ) && $slide_opt != 'on' ) :
							$output .= '</div><!-- .row -->';
							$row_stat = 0;
						endif;
						
					}
					
				//Image Grid Slide End
				if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .owl-carousel -->';
				
			$output .= '</div><!-- .image-grid-wrapper -->';
			
		}
		
		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_image_grid_shortcode_map" ) ) {
	function zoacres_vc_image_grid_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Image Grid", "zoacres" ),
				"description"			=> esc_html__( "Image Grid custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_image_grid",
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
						"heading"		=> esc_html__( "Image Grid Columns", "zoacres" ),
						"description"	=> esc_html__( "This grid option using to divide columns as per given numbers. This option active only when slide inactive otherwise slide columns only focus to divide.", "zoacres" ),
						"param_name"	=> "grid_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
						)
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Image Grid Layout", "zoacres" ),
						"param_name"	=> "image_grid_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/image-grid/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/image-grid/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/image-grid/3.png"
						),
						"default"		=> "1"
					),
					array(
						"type" => "attach_images",
						"heading" => esc_html__( "Attach Images", "zoacres" ),
						"description" => esc_html__( "Choose image grid images.", "zoacres" ),
						"param_name" => "image_grid_images",
						"value" => '',
						"group"			=> esc_html__( "Image", "zoacres" ),
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Enable", "zoacres" ),
						"description"	=> esc_html__( "This is an option for enable or disable slide.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "3",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for image gird shortcode scroll by.", "zoacres" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_image_grid_shortcode_map" );
<?php 
/**
 * Zoacres Content Carousel
 */

if ( ! function_exists( "zoacres_vc_content_carousel_shortcode" ) ) {
	function zoacres_vc_content_carousel_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_content_carousel", $atts );
		extract( $atts );

		$output = $class = '';
		
		//Defined Variable
		$animation = isset( $animation ) ? $animation : '';
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		
		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		$gal_atts = '';

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

				
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.content-carousel-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
			
		$output .= '<div class="content-carousel-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			//Content Carousel Slide
			$output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
				$output .= do_shortcode( $content );
			//Content Carousel Slide End
			$output .= '</div><!-- .owl-carousel -->';
		$output .= '</div><!-- .content-carousel-wrapper -->';

		
		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_content_carousel_shortcode_map" ) ) {
	function zoacres_vc_content_carousel_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Content Carousel", "zoacres" ),
				"description"			=> esc_html__( "Any content carousel.", "zoacres" ),
				"base"					=> "zoacres_vc_content_carousel",
				"is_container"			=> true,
				"content_element"		=> true,
				"js_view" 				=> 'VcColumnView',
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
						"type"			=> "animation_style",
						"heading"		=> esc_html__( "Animation Style", "zoacres" ),
						"description"	=> esc_html__( "Choose your animation style.", "zoacres" ),
						"param_name"	=> "animation",
						'admin_label'	=> false,
                		'weight'		=> 0,
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the font color.", "zoacres" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel text align", "zoacres" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for content carousel slider scroll by.", "zoacres" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_content_carousel_shortcode_map" );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Zoacres_Vc_Content_Carousel extends WPBakeryShortCodesContainer {
    }
}
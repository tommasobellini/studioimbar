<?php 
/**
 * Zoacres Section Title
 */

if ( ! function_exists( "zoacres_vc_section_title_shortcode" ) ) {
	function zoacres_vc_section_title_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_section_title", $atts );
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';		
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		$title = isset( $title ) ? $title : '';
		$title_head = isset( $title_head ) ? $title_head : 'h1';
		
		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		// Title Color/ Title Prefix / Title Suffix Coloe CSS / Title Typo Settings
		$shortcode_css .= isset( $title_prefix_color ) && $title_prefix_color != '' ? '.' . esc_attr( $rand_class ) . ' .section-title .title-prefix { color: '. esc_attr( $title_prefix_color ) .'; }' : '';
		$shortcode_css .= isset( $title_suffix_color ) && $title_suffix_color != '' ? '.' . esc_attr( $rand_class ) . ' .section-title .title-suffix { color: '. esc_attr( $title_suffix_color ) .'; }' : '';
		$shortcode_css .= isset( $title_margin ) && $title_margin != '' ? '.' . esc_attr( $rand_class ) . ' .title-wrap { margin: '. esc_attr( $title_margin ) .'; }' : '';
		
		
		$sep_border_color = isset( $sep_border_color ) ? $sep_border_color : '';
		$shortcode_css .= isset( $sep_type ) && $sep_type == 'border' ? '.' . esc_attr( $rand_class ) . ' .title-separator.separator-border { background-color: '. esc_attr( $sep_border_color ) .'; }' : '';
		
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.section-title-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $sub_title_color ) && $sub_title_color != '' ? '.' . esc_attr( $rand_class ) . '.section-title-wrapper .sub-title { color: '. esc_attr( $sub_title_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;

			$space_class_name = '.' . esc_attr( $rand_class ) . '.section-title-wrapper >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}		
		
		$title_css = isset( $title_color ) && $title_color != '' ? ' color: '. esc_attr( $title_color ) .';' : '';
		$title_css .= isset( $font_size ) && $font_size != '' ? ' font-size: '. esc_attr( $font_size ) .'px;' : '';
		$title_css .= isset( $line_height ) && $line_height != '' ? ' line-height: '. esc_attr( $line_height ) .'px;' : '';
		$title_css .= isset( $title_trans ) && $title_trans != '' ? ' text-transform: '. esc_attr( $title_trans ) .';' : '';
		
		$shortcode_css .= $title_css != '' ? '.' . esc_attr( $rand_class ) . ' .section-title {' . $title_css . ' }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$sub_title = isset( $sub_title ) && $sub_title != '' ? '<span class="sub-title">'. esc_html( $sub_title ) .'</span>' : '';
		$sub_title_pos = isset( $sub_title_pos ) ? $sub_title_pos : 'bottom';
		
		$output .= '<div class="section-title-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			$output .= '<div class="title-wrap">';
				// Section title 
				$output .= $sub_title != '' && $sub_title_pos == 'top' ? $sub_title : '';
				$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
					$output .= isset( $title_prefix ) && $title_prefix != '' ? '<span class="title-prefix theme-color">' . esc_html( $title_prefix ) . '</span> ' : '';
					$output .= esc_html( $title );
					$output .= isset( $title_suffix ) && $title_suffix != '' ? ' <span class="title-suffix theme-color">' . esc_html( $title_suffix ) . '</span>' : '';
				$output .= '</' . esc_attr( $title_head ) . '>';
				$output .= $sub_title != '' && $sub_title_pos == 'bottom' ? $sub_title : '';
				
				// Section title separator 
				$sep_type = isset( $sep_type ) ? $sep_type : 'border';
				if( $sep_type == 'border' ){
					$output .= '<span class="title-separator separator-border theme-color-bg"></span>';
				}elseif( $sep_type == 'image' ){
					$img_attr = wp_get_attachment_image_src( absint( $sep_image ), 'full', true );
					$image_alt = get_post_meta( absint( $sep_image ), '_wp_attachment_image_alt', true);
					$output .= isset( $img_attr[0] ) ? '<span class="title-separator separator-img"><img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" /></span>' : '';
				}
			$output .= '</div><!-- .title-wrap -->';
			
			$output .= '<div class="section-description">';
				$output .= isset( $content ) && $content != '' ? wp_kses_post( $content ) : '';
				$btn_url = isset( $btn_url ) ? $btn_url : '';
				$btn_type = isset( $btn_type ) ? $btn_type : '';
			$output .= '</div><!-- .section-description -->';
			$output .= isset( $btn_text ) && $btn_text != '' ? '<div class="section-title-btn"><a class="btn '. esc_attr( $btn_type ) .'" href="'. esc_html( $btn_url ) .'" title="'. esc_attr( $btn_text ) .'">'. esc_html( $btn_text ) .'</a></div>' : '';
			
		$output .= '</div><!-- .section-title-wrapper -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_section_title_shortcode_map" ) ) {
	function zoacres_vc_section_title_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Section Title", "zoacres" ),
				"description"			=> esc_html__( "Variant section title.", "zoacres" ),
				"base"					=> "zoacres_vc_section_title",
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
						"heading"		=> esc_html__( "Title Heading Tag", "zoacres" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "zoacres" ),
						"param_name"	=> "title_head",
						"value"			=> array(
							esc_html__( "H1", "zoacres" )=> "h1",
							esc_html__( "H2", "zoacres" )=> "h2",
							esc_html__( "H3", "zoacres" )=> "h3",
							esc_html__( "H4", "zoacres" )=> "h4",
							esc_html__( "H5", "zoacres" )=> "h5",
							esc_html__( "H6", "zoacres" )=> "h6"
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title", "zoacres" ),
						"description"	=> esc_html__( "Enter section title here.", "zoacres" ),
						"param_name"	=> "title",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Prefix", "zoacres" ),
						"description"	=> esc_html__( "Enter section title prefix. If no need title prefix, then leave this box blank.", "zoacres" ),
						"param_name"	=> "title_prefix",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Suffix", "zoacres" ),
						"description"	=> esc_html__( "Enter section title suffix. If no need title suffix, then leave this box blank.", "zoacres" ),
						"param_name"	=> "title_suffix",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for section title text align.", "zoacres" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can set the section title color.", "zoacres" ),
						"param_name"	=> "title_color",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Prefix Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can set the section prefix title color.", "zoacres" ),
						"param_name"	=> "title_prefix_color",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Suffix Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can set the section title suffix color.", "zoacres" ),
						"param_name"	=> "title_suffix_color",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Font Size", "zoacres" ),
						"description"	=> esc_html__( "Enter title font size. Example 30.", "zoacres" ),
						"param_name"	=> "font_size",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Line Height", "zoacres" ),
						"description"	=> esc_html__( "Enter title line height. Example 30.", "zoacres" ),
						"param_name"	=> "line_height",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Title Text Transform", "zoacres" ),
						"param_name" 	=> "title_trans",
						"value" 		=> array(
							esc_html__( "None", "zoacres" ) => "none",
							esc_html__( "Capitalize", "zoacres" ) => "capitalize",
							esc_html__( "Upper Case", "zoacres" )=> "uppercase",
							esc_html__( "Lower Case", "zoacres" )=> "lowercase"
						),
						"group"			=> esc_html__( "Title", "zoacres" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Margin", "zoacres" ),
						"description"	=> esc_html__( "Enter title margin here. Example 30px 20px 30px 20px.", "zoacres" ),
						"param_name"	=> "title_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Sub Title", "zoacres" ),
						"description"	=> esc_html__( "Enter section title here. If no need sub title, then leave this box blank.", "zoacres" ),
						"param_name"	=> "sub_title",
						"value" 		=> "",
						"group"			=> esc_html__( "Sub Title", "zoacres" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Sub Title Position", "zoacres" ),
						"param_name" 	=> "sub_title_pos",
						"value" 		=> array(
							esc_html__( "Bottom", "zoacres" ) => "bottom",
							esc_html__( "Top", "zoacres" )=> "top"
						),
						"group"			=> esc_html__( "Sub Title", "zoacres" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Sub Title Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can set the section sub title color.", "zoacres" ),
						"param_name"	=> "sub_title_color",
						"group"			=> esc_html__( "Sub Title", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Separator Type", "zoacres" ),
						"param_name" 	=> "sep_type",
						"value" 		=> array(
							esc_html__( "None", "zoacres" ) => "none",
							esc_html__( "Border", "zoacres" ) => "border",
							esc_html__( "Image", "zoacres" )=> "image"
						),
						"group"			=> esc_html__( "Separator", "zoacres" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Separator Border", "zoacres" ),
						"description"	=> esc_html__( "Here you can set the section title separator border color.", "zoacres" ),
						"param_name"	=> "sep_border_color",
						'dependency' => array(
							'element' => 'sep_type',
							'value' => 'border',
						),
						"group"			=> esc_html__( "Separator", "zoacres" )
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Separator Image", "zoacres" ),
						"description" => esc_html__( "Choose section title separator image.", "zoacres" ),
						"param_name" => "sep_image",
						"value" => '',
						'dependency' => array(
							'element' => 'sep_type',
							'value' => 'image',
						),
						"group"			=> esc_html__( "Separator", "zoacres" ),
					),
					array(
						"type"			=> "textarea_html",
						"heading"		=> esc_html__( "Content", "zoacres" ),
						"description"	=> esc_html__( "Enter section title below content.", "zoacres" ),
						"param_name"	=> "content",
						"value" 		=> "",
						"group"			=> esc_html__( "Content", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button Text", "zoacres" ),
						"description"	=> esc_html__( "Enter section button text here. If no need button, then leave this box blank.", "zoacres" ),
						"param_name"	=> "btn_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "zoacres" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button URL", "zoacres" ),
						"description"	=> esc_html__( "Enter section button url here. If no need button url, then leave this box blank.", "zoacres" ),
						"param_name"	=> "btn_url",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "zoacres" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Type", "zoacres" ),
						"param_name" 	=> "btn_type",
						"value" 		=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Link", "zoacres" )		=> "link",
							esc_html__( "Classic", "zoacres" )	=> "classic",
							esc_html__( "Bordered", "zoacres" )	=> "bordered",
							esc_html__( "Inverse", "zoacres" )	=> "inverse"
						),
						"group"			=> esc_html__( "Button", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_section_title_shortcode_map" );
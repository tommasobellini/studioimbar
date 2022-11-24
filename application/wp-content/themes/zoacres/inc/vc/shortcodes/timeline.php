<?php 
/**
 * Zoacres Timeline
 */

if ( ! function_exists( "zoacres_vc_timeline_shortcode" ) ) {
	function zoacres_vc_timeline_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_timeline", $atts );
		extract( $atts );
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : ''; 
		$class .= isset( $timeline_style ) && $timeline_style != '' ? ' timeline-style-'.$timeline_style : ''; 

		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.timeline-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$output = '';

		$output .= '<div class="timeline-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
		
		// All Timeline Items
		$timeline_settings = isset( $timeline_settings ) ? $timeline_settings : '';
		$tl_items =  json_decode( urldecode( $timeline_settings ), true ); // $tl_items is timeline items
		if( $tl_items ):
			
			$tl_layout = isset( $timeline_layout ) ? $timeline_layout : '';
			$layout_class = $timeline_layout != 'default' ? ' tl-' . $timeline_layout . '-layout' : '';
			$layout_class .= isset( $timeline_line ) && $timeline_line != 'default' ? ' tl-border-' . $timeline_line : '';
			$output .= '<ul class="timeline'. esc_attr( $layout_class ) .'">';
			foreach( $tl_items as $tlitem ) {
				
				$tl_rand_class = 'timeline-rand-'. zoacres_shortcode_rand_id();
				$tl_pos = isset( $tlitem['timeline_pos'] ) ? $tlitem['timeline_pos'] : '';
				$li_class = '';
				if( $tl_layout == 'default' ){
					$li_class .= $tl_pos == 'opp' ? ' timeline-inverted' : '';
				}elseif( $tl_layout == 'left' ){
					$li_class .= ' timeline-inverted';
				}
				$tl_title = isset( $tlitem['timeline_title'] ) ? $tlitem['timeline_title'] : '';
				$tl_stitle = isset( $tlitem['timeline_subtitle'] ) ? $tlitem['timeline_subtitle'] : '';
				$tl_content = isset( $tlitem['tl_content'] ) ? $tlitem['tl_content'] : '';
				$auto_p = isset( $tlitem['tl_content_p'] ) ? $tlitem['tl_content_p'] : '';
				
				$separator_type = isset( $tlitem['separator_type'] ) ? $tlitem['separator_type'] : 'none';
				$sep_out = '';
				switch( $separator_type ){
					case "icon":
						$icon_type = isset( $tlitem['icon_type'] ) ? 'icon_' . $tlitem['icon_type'] : '';
						$icon = isset( $tlitem[$icon_type] ) ? $tlitem[$icon_type] : '';
						$sep_out = '<i class="'. esc_attr( $icon ) .'"></i>';
					break;
					case "img":
						$sep_image = isset( $tlitem['separator_image'] ) ? $tlitem['separator_image'] : '';
						if( $sep_image ){
							$img_attr = wp_get_attachment_image_src( absint( $sep_image ), 'full', true );
							$image_alt = get_post_meta( absint( $sep_image ), '_wp_attachment_image_alt', true);
							$sep_out = isset( $img_attr[0] ) ? '<img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
						}
					break;
					case "txt":
						$sep_text = isset( $tlitem['separator_text'] ) ? $tlitem['separator_text'] : '';
						$sep_out = '<span class="separator-text">'. esc_html( $sep_text ) .'</span>';
					break;
					default:
						$sep_out = '<span class="separator-empty"></span>';
					break;
				}
				
				$sep_title = isset( $tlitem['separator_title'] ) && $tlitem['separator_title'] != '' ? $tlitem['separator_title'] : '';
				$sep_stitle = isset( $tlitem['separator_subtitle'] ) && $tlitem['separator_subtitle'] != '' ? $tlitem['separator_subtitle'] : '';
				$sep_tit_out = '';
				if( $sep_title != '' || $sep_stitle != '' ){
					$sep_tit_out .= $sep_title != '' ? esc_html( $sep_title ) : '';
					$sep_tit_out .= $sep_stitle != '' ? '<span>'. esc_html( $sep_stitle ) .'</span>' : '';
				}
				
				$sep_class = '';
				$sep_bg_stat = 1;
				if( $sep_out ){
					if( isset( $tlitem['separator_shape'] ) ){
						if( is_numeric( $tlitem['separator_shape'] ) ){
							$sep_class = ' separator-shape-custom';
							$sep_bg = isset( $tlitem['separator_bgcolor'] ) ? $tlitem['separator_bgcolor'] : '#333';
							$sep_out .= '<canvas id="canvas_agon" class="canvas_agon" width=50 height=50 data-size="25" data-side="'. esc_attr( $tlitem['separator_shape'] ) .'" data-color="'. esc_attr( $sep_bg ) .'"></canvas>';
							$sep_bg_stat = 0;
						}else{
							$sep_class = ' '.$tlitem['separator_shape'];
						}
					}else{
						$sep_class = ' '. $tlitem['separator_shape'];
					}
				}
				
				//Timeline css ccde here
				$tl_css = isset( $tlitem['title_color'] ) && $tlitem['title_color'] != '' ? '.' . esc_attr( $tl_rand_class ) . ' .timeline-title { color: '. esc_attr( $tlitem['title_color'] ) .'; }' : '';
				
				if( $sep_bg_stat ){
					$tl_css .= isset( $tlitem['separator_bgcolor'] ) && $tlitem['separator_bgcolor'] != '' ? '.timeline > .' . esc_attr( $tl_rand_class ) . ' .timeline-badge { background-color: '. esc_attr( $tlitem['separator_bgcolor'] ) .'; }' : '';
				}

				$tl_css .= isset( $tlitem['separator_color'] ) && $tlitem['separator_color'] != '' ? '.timeline > .' . esc_attr( $tl_rand_class ) . ' .timeline-badge { color: '. esc_attr( $tlitem['separator_color'] ) .'; }' : '';

				if( $tl_css ) $li_class .= ' ' . $tl_rand_class . ' zoacres-inline-css';

				$output .= '<li class="'. esc_attr( $li_class ) .'" data-css="'. htmlspecialchars( json_encode( $tl_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					
					$output .= $sep_out != '' ? '<div class="timeline-badge'. esc_attr( $sep_class ) .'">'. ( $sep_out ) .'</div>' : '';
					$output .= $sep_tit_out != '' ? '<div class="timeline-sep-title">'. wp_kses_post( $sep_tit_out ) .'</div>' : '';
				
					$output .= '<div class="timeline-panel">';

						if( $tl_title || $tl_stitle ):
							$output .= '<div class="timeline-heading">';
								$output .= $tl_title != '' ? '<h4 class="timeline-title">'. esc_html( $tl_title ) .'</h4>' : '';
								$output .= $tl_stitle != '' ? '<p><small class="text-muted">'. wp_kses_post( $tl_stitle ) .'</small></p>' : '';
							$output .= '</div>';
						endif;
						
						if( $tl_content ):
							$output .= '<div class="timeline-body">';
								$output .= $auto_p ? '<p>' : '';
								$output .= do_shortcode( $tl_content );
								$output .= $auto_p ? '</p>' : '';
							$output .= '</div>';
						endif;
						
					$output .= '</div>';
				$output .= '</li><!-- .timeline item li -->';
				
			}
			$output .= '</ul>';
		endif;
							
		$output .= '</div><!-- .timeline-wrapper -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_timeline_shortcode_map" ) ) {
	function zoacres_vc_timeline_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Timeline", "zoacres" ),
				"description"			=> esc_html__( "Numeric timeline.", "zoacres" ),
				"base"					=> "zoacres_vc_timeline",
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
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Timeline Style", "zoacres" ),
						"param_name"	=> "timeline_style",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/timeline/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/timeline/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/timeline/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Timeline", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Timeline Layout", "zoacres" ),
						"description"	=> esc_html__( "This is an option for timeline layout. If you choose left/right layout, then this option set the timeline position same side.", "zoacres" ),
						"param_name"	=> "timeline_layout",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )		=> "default",
							esc_html__( "Left Layout", "zoacres" )	=> "left",
							esc_html__( "Right Layout", "zoacres" )	=> "right"
						),
						"group"			=> esc_html__( "Timeline", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "History Line Style", "zoacres" ),
						"description"	=> esc_html__( "This is an option for timeline history line style.", "zoacres" ),
						"param_name"	=> "timeline_line",
						"value"			=> array(
							esc_html__( "Dotted", "zoacres" )	=> "default",
							esc_html__( "Solid", "zoacres" )		=> "solid"
						),
						"group"			=> esc_html__( "Timeline", "zoacres" )
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Timeline Setting", "zoacres" ),
						'value' => '',
						'param_name' => 'timeline_settings',
						'params' => array(
							array(
								"type"			=> "dropdown",
								"heading"		=> esc_html__( "Timeline Position", "zoacres" ),
								"description"	=> esc_html__( "This is an option for timeline position. Either same side or opposite side.", "zoacres" ),
								"param_name"	=> "timeline_pos",
								"value"			=> array(
									esc_html__( "Same Side", "zoacres" )=> "same",
									esc_html__( "Opposite Side", "zoacres" )=> "opp"
								),
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Title", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline title.", "zoacres" ),
								"param_name"	=> "timeline_title",
								"admin_label" 	=> true,
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Sub Title", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline sub title.", "zoacres" ),
								"param_name"	=> "timeline_subtitle",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Timeline Title Color", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline title and subtitle color.", "zoacres" ),
								"param_name"	=> "title_color",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type" 			=> "dropdown",
								"param_name" 	=> "separator_shape",
								"heading" 		=> esc_html__( "Separator Shape", "zoacres" ),
								"description" 	=> esc_html__( "This is an options for separator shape.", "zoacres" ),
								"value" 		=> array(
									esc_html__( "Square", "zoacres" ) => "sq",
									esc_html__( "Rounded", "zoacres" )=> "rounded",
									esc_html__( "Circle", "zoacres" ) => "rounded-circle",
									esc_html__( "Triangle", "zoacres" ) => "3",
									esc_html__( "Pentagon", "zoacres" ) => "5",
									esc_html__( "Hexagon", "zoacres" ) => "6",
									esc_html__( "Heptagon", "zoacres" ) => "7",
									esc_html__( "Octagon", "zoacres" ) => "8",
									esc_html__( "Nonagon", "zoacres" ) => "9",
									esc_html__( "Decagon", "zoacres" ) => "10",
								),
								"group"			=> esc_html__( "Timeline", "zoacres" ),
							),
							array(
								"type"			=> "dropdown",
								"heading"		=> esc_html__( "Separator Type", "zoacres" ),
								"description"	=> esc_html__( "This is an option for timeline separator type either icon/image/text. If no need separator, then choose none.", "zoacres" ),
								"param_name"	=> "separator_type",
								"value"			=> array(
									esc_html__( "None", "zoacres" )=> "none",
									esc_html__( "Icon", "zoacres" )=> "icon",
									esc_html__( "Image", "zoacres" )=> "img",
									esc_html__( "Text", "zoacres" )=> "txt"
								),
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type" 			=> "dropdown",
								"heading" 		=> esc_html__( "Separator Icon", "zoacres" ),
								"value" 		=> array(
									esc_html__( "None", "zoacres" ) 				=> "",
									esc_html__( "Font Awesome", "zoacres" ) 		=> "fontawesome",
									esc_html__( "Simple Line Icons", "zoacres" ) => "simplelineicons",
								),
								"param_name" 	=> "icon_type",
								"description" 	=> esc_html__( "Choose from Icon library.", "zoacres" ),
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'icon',
								),
								"group"			=> esc_html__( "Timeline", "zoacres" ),
							),		
							array(
								'type' => 'iconpicker',
								'heading' => esc_html__( 'Icon', 'zoacres' ),
								'param_name' => 'icon_fontawesome',
								"value" 		=> "fa fa-heart-o",
								'settings' => array(
									'emptyIcon' => false,
									'type' => 'fontawesome',
									'iconsPerPage' => 675,
								),
								'dependency' => array(
									'element' => 'icon_type',
									'value' => 'fontawesome',
								),
								'description' => esc_html__( 'Select icon from library.', 'zoacres' ),
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								'type' => 'iconpicker',
								'heading' => esc_html__( 'Icon', 'zoacres' ),
								'param_name' => 'icon_simplelineicons',
								"value" 	=> "icon-trophy",
								'settings' => array(
									'emptyIcon' => false,
									'type' => 'simplelineicons',
									'iconsPerPage' => 500,
								),
								'dependency' => array(
									'element' => 'icon_type',
									'value' => 'simplelineicons',
								),
								'description' => esc_html__( 'Select icon from library.', 'zoacres' ),
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),		
							array(
								"type" => "attach_image",
								"heading" => esc_html__( "Separator Image", "zoacres" ),
								"description" => esc_html__( "Choose separator image.", "zoacres" ),
								"param_name" => "separator_image",
								"value" => '',
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'img',
								),
								"group"			=> esc_html__( "Timeline", "zoacres" ),
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Text", "zoacres" ),
								"description" => esc_html__( "This is an option for showing text on separator.", "zoacres" ),
								"param_name"	=> "separator_text",
								"value" 		=> "",
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'txt',
								),
								"group"			=> esc_html__( "Timeline", "zoacres" ),
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Separator Color", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline separator color.", "zoacres" ),
								"param_name"	=> "separator_color",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Separator Background Color", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline separator color.", "zoacres" ),
								"param_name"	=> "separator_bgcolor",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Title", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline separator title.", "zoacres" ),
								"param_name"	=> "separator_title",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Sub Title", "zoacres" ),
								"description"	=> esc_html__( "Here you can put the timeline separator sub title.", "zoacres" ),
								"param_name"	=> "separator_subtitle",
								"group"			=> esc_html__( "Timeline", "zoacres" )
							),
							array(
								"type"			=> "textarea",
								"heading"		=> esc_html__( "Content", "zoacres" ),
								"description" 	=> esc_html__( "You can give the feature box content here. HTML allowed here.", "zoacres" ),
								"param_name"	=> "tl_content",
								"value" 		=> "",
								"group"			=> esc_html__( "Content", "zoacres" )
							),
							array(
								"type"			=> "switch_bit",
								"heading"		=> esc_html__( "Auto Paragraph", "zoacres" ),
								"description" 	=> esc_html__( "This is an option for content covered by paragraph.", "zoacres" ),
								"param_name"	=> "tl_content_p",
								"value"			=> "off",
							)
						),
						"group"			=> esc_html__( "Timeline", "zoacres" )
					),
					
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_timeline_shortcode_map" );
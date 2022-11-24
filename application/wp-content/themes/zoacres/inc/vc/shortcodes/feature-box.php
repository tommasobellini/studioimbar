<?php 
/**
 * Zoacres Feature Box
 */

if ( ! function_exists( "zoacres_vc_feature_box_shortcode" ) ) {
	function zoacres_vc_feature_box_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_feature_box", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';		
		$class .= isset( $feature_layout ) ? ' feature-box-style-' . $feature_layout : '';	
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		$layout = isset( $layout ) ? $layout : 'normal';
		
		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		// VC Design Options
		$class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "zoacres_vc_feature_box", $atts );
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $title_color ) && $title_color != '' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .section-title { color: '. esc_attr( $title_color ) .'; }' : '';
		$shortcode_css .= isset( $title_text_trans ) && $title_text_trans != 'default' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .section-title { text-transform: '. esc_attr( $title_text_trans ) .'; }' : '';
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			if( $layout == 'list' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .fbox-list .media-body >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.feature-box-wrapper >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		if( isset( $gradient_opt ) && $gradient_opt != '' ){
			$clr_1 = isset( $gradient_color_1 ) ? $gradient_color_1 : '';
			$clr_2 = isset( $gradient_color_2 ) ? $gradient_color_2 : '';
			$clr_3 = isset( $gradient_color_3 ) ? $gradient_color_3 : '';
			$shortcode_css .= '.' . esc_attr( $rand_class ) . '.feature-box-wrapper {';
				$shortcode_css .= 'background: -moz-linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);
				background: -webkit-linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);
				background: linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);';
			$shortcode_css .= '}';
		}
		
		
		if( isset( $icon_size ) && $icon_size ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { font-size: '. esc_attr( $icon_size ) .'px; }';
			$dimension = absint( $icon_size ) * 2;
			if( isset( $icon_inner_space ) && !$icon_inner_space )
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { height: '. esc_attr( $dimension ) .'px; width: '. esc_attr( $dimension ) .'px; }';
		}
		if( isset( $icon_midd ) && $icon_midd ){
			if( isset( $icon_inner_space ) && !$icon_inner_space )
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon > span { line-height: 2; }';
		}
		
		// Icon Variation/Styles
		$icon_type = isset( $icon_type ) ? 'icon_' . $icon_type : '';
		$icon = isset( $$icon_type ) ? $$icon_type : '';
		$icon_class = isset( $icon_style ) ? ' ' . $icon_style : '';
		
		if( isset( $icon_variation ) ){
			if( $icon_variation == 'c' ){
				$shortcode_css .= isset( $icon_color ) && $icon_color != '' ? '.' . esc_attr( $rand_class ) . ' .feature-box-icon { color: '. esc_attr( $icon_color ) .'; }' : '';
			}else{
				$icon_class .= ' ' . esc_attr( $icon_variation );
			}
		}
		$shortcode_css .= isset( $icon_hcolor ) && $icon_hcolor != '' ? '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { color: '. esc_attr( $icon_hcolor ) .'; }' : '';

		if( isset( $icon_bg_trans ) ){
			if( $icon_bg_trans == 'c' ){
				$shortcode_css .= isset( $icon_bg_color ) && $icon_bg_color != '' ? '.' . esc_attr( $rand_class ) . ' .feature-box-icon { background-color: '. esc_attr( $icon_bg_color ) .'; }' : '';
			}elseif( $icon_bg_trans == 't' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { background: transparent; }';
			}else{
				$icon_class .= ' ' . esc_attr( $icon_bg_trans );
			}
			
		}

		if( isset( $icon_hbg_trans ) ){
		
			if( $icon_hbg_trans == 'c' ){
				$shortcode_css .= isset( $icon_hbg_color ) && $icon_hbg_color != '' ? '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { background-color: '. esc_attr( $icon_hbg_color ) .'; }' : '';
			}else{
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { background: '. esc_attr( $icon_hbg_trans ) .'; }';
			}
		}
		
		if( isset( $border_color ) && $border_color != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { border-style: solid; border-color: '. esc_attr( $border_color ) .'; }';
		}
		
		if( isset( $border_hcolor ) && $border_hcolor != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { border-color: '. esc_attr( $border_hcolor ) .'; }';
		}
		
		if( isset( $border_size ) && $border_size != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { border-width: '. esc_attr( $border_size ) .'px; }';
		}
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$title = isset( $title ) ? $title : '';
		$title_head = isset( $title_head ) ? $title_head : 'h2';

		$img_class = isset( $img_style ) ? ' ' . $img_style : ''; 
		$class .= isset( $img_effects ) && $img_effects != 'none' ? ' fbox-img-' . $img_effects : '';
		$fbox_image = isset( $fbox_image ) ? ' ' . $fbox_image : '';
		$video_url = isset( $fbox_video ) ? $fbox_video : '';
		
		$content = isset( $content ) && $content != '' ? $content : '';
		
		//Button Properties
		$btnn_txt = $btnn_type = $btnn_url = '';
		if( isset( $btn_text ) && $btn_text != '' ){
			$btnn_txt = $btn_text;
			$btnn_url = isset( $btn_url ) ? $btn_url : '';
			$btnn_type = isset( $btn_type ) ? $btn_type : '';
		}

		if( $layout == 'list' ){
			$class .= isset( $list_layout ) ? ' feature-' . $list_layout : '';
		}		
		
		$tit_url = '';
		if( isset( $title_url_opt ) && $title_url_opt == 'yes' ){
			$tit_url = isset( $title_url ) ? $title_url : '';
		}
			
		$output .= '<div class="feature-box-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
		
			$output .= isset( $ribbon_value ) && $ribbon_value != '' && $layout != 'list' && $feature_layout == '4' ? '<span class="feature-box-ribbon">'. esc_html( $ribbon_value ) .'</span>' : '';
			
			// Normal/Grid Layout
			if( $layout == 'normal' ):
			
				$opt_array = array(
					'icon_class' => $icon_class,
					'icon' => $icon,
					'img_id' => $fbox_image,
					'img_class' => $img_class,
					'img_effects' => $img_effects,
					'title' => $title,
					'title_url' => $tit_url,
					'title_head' => $title_head,
					'content' => $content,
					'btn_text' => $btnn_txt,
					'btn_url' => $btnn_url,
					'btn_type' => $btnn_type,
					'video'	=> $video_url
				);
	
				$elemetns = isset( $fbox_items ) ? zoacres_drag_and_drop_trim( $fbox_items ) : array( 'Enabled' => '' );
	
				if( isset( $elemetns['Enabled'] ) ) :
					foreach( $elemetns['Enabled'] as $element => $value ){
						$output .= zoacres_feature_box_shortcode_elements( $element, $opt_array );
					}
				endif;
				
			elseif( $layout == 'list' ):
				
				$list_layout = isset( $list_layout ) ? $list_layout : 'list-1';
				$list_head = isset( $list_head ) ? $list_head : 'icon';
				
				$title_url_opt = isset( $title_url_opt ) ? $title_url_opt : '';
				$tit_url = isset( $title_url ) ? $title_url : '';
				
				if( $list_layout == 'list-1' ):
				
					$output .= '<div class="fbox-list">';
						$output .= '<div class="media">';
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon mr-3 text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $fbox_image ){
									$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
									$output .= '<div class="feature-box-thumb mr-4">';
										$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
										$image_alt = $image_alt != '' ? $image_alt : $title;
										$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
									$output .= '</div><!-- .feature-box-thumb -->';
								}
							}
							$output .= '<div class="media-body">';
							
								$output .= '<div class="feature-box-title">';
									$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
										$output .= zoacres_feature_box_title( $title_url_opt, $tit_url, $title );
									$output .= '</' . esc_attr( $title_head ) . '>';
								$output .= '</div><!-- .feature-box-title -->';
								
								if( $content != '' ):
									$output .= '<div class="feature-box-content">';
										$output .= wp_kses_post( $content );
										
										if( $btnn_txt != '' ):
											$output .= '<div class="feature-box-btn mt-3">';
												$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_html( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
											$output .= '</div><!-- .feature-box-btn -->';
										endif;
										
									$output .= '</div><!-- .feature-box-content -->';
								endif;
								
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				
				elseif( $list_layout == 'list-2' ):
				
					$output .= '<div class="fbox-list">';
					
						$output .= '<div class="media fbox-list-head clearfix">';
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $fbox_image ){
									$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
									$output .= '<div class="feature-box-thumb">';
										$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
										$image_alt = $image_alt != '' ? $image_alt : $title;
										$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'"  alt="'. esc_attr( $image_alt ) .'" />' : '';
									$output .= '</div><!-- .feature-box-thumb -->';
								}
							}
							
							$output .= '<div class="media-body align-self-center feature-box-title">';
								$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
									$output .= zoacres_feature_box_title( $title_url_opt, $tit_url, $title );
								$output .= '</' . esc_attr( $title_head ) . '>';
							$output .= '</div><!-- .feature-box-title -->';
						$output .= '</div><!-- .fbox-list-head -->';
						if( $content != '' ):
							$output .= '<div class="fbox-list-body">';
								$output .= '<div class="feature-box-content">';
									$output .= wp_kses_post( $content );
									
									if( $btnn_txt != '' ):
										$output .= '<div class="feature-box-btn mt-3">';
											$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_html( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
										$output .= '</div><!-- .feature-box-btn -->';
									endif;
									
								$output .= '</div><!-- .feature-box-content -->';
							$output .= '</div>';
						endif;
					$output .= '</div><!-- .fbox-list -->';

				elseif( $list_layout == 'list-3' ):
				
					$output .= '<div class="fbox-list">';
						$output .= '<div class="media">';
							
							$output .= '<div class="media-body">';
							
								$output .= '<div class="feature-box-title">';
									$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
										$output .= zoacres_feature_box_title( $title_url_opt, $tit_url, $title );
									$output .= '</' . esc_attr( $title_head ) . '>';
								$output .= '</div><!-- .feature-box-title -->';
								
								if( $content != '' ):
									$output .= '<div class="feature-box-content">';
										$output .= wp_kses_post( $content );
										
										if( $btnn_txt != '' ):
											$output .= '<div class="feature-box-btn mt-3">';
												$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_html( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
											$output .= '</div><!-- .feature-box-btn -->';
										endif;
										
									$output .= '</div><!-- .feature-box-content -->';
								endif;
								
							$output .= '</div>';
							
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon ml-3 text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $fbox_image ){
									$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
									$output .= '<div class="feature-box-thumb ml-3">';
										$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
										$image_alt = $image_alt != '' ? $image_alt : $title;
										$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'"  alt="'. esc_attr( $image_alt ) .'" />' : '';
									$output .= '</div><!-- .feature-box-thumb -->';
								}
							}
							
						$output .= '</div>';
					$output .= '</div>';

				endif;
				
			endif;
			
		$output .= '</div><!-- .feature-box-wrapper -->';
		
		return $output;
	}
}

function zoacres_feature_box_title( $tit_opt, $tit_url, $title ){
	$output = '';
	if( $tit_opt == 'yes' && $tit_url != '' )
		$output .= '<a href="'. esc_url( $tit_url ) .'" title="'. esc_attr( $title ) .'" >'. esc_html( $title ) .'</a>';
	else
		$output .= esc_html( $title );
		
	return $output;
}

function zoacres_feature_box_shortcode_elements( $element, $opts ){
	$output = '';
	switch( $element ){
	
		case "title":
			$output .= '<div class="feature-box-title">';
				$output .= '<' . esc_attr( $opts['title_head'] ) . ' class="section-title">';
					if( $opts['title_url'] == '' )
						$output .= esc_html( $opts['title'] );
					else
						$output .= '<a href="'. esc_url( $opts['title_url'] ) .'" title="'. esc_attr( $opts['title'] ) .'" >'. esc_html( $opts['title'] ) .'</a>';
				$output .= '</' . esc_attr( $opts['title_head'] ) . '>';
			$output .= '</div><!-- .feature-box-title -->';		
		break;
		
		case "icon":
			$icon_class = $opts['icon_class'];
			$icon = $opts['icon'];
			if( $icon ):
				$output .= '<div class="feature-box-icon text-center'. esc_attr( $icon_class ) .'">';
					$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
				$output .= '</div><!-- .feature-box-icon -->';
			endif;
		break;
		
		case "image":
			$img_id = $opts['img_id'];
			$img_class = $opts['img_class'];
			$img_attr = wp_get_attachment_image_src( absint( $img_id ), 'full', true );
			if( isset( $img_attr ) ):
				$output .= '<div class="feature-box-thumb">';
					$image_alt = get_post_meta( absint( $img_id ), '_wp_attachment_image_alt', true);
					$image_alt = $image_alt != '' ? $image_alt : esc_html( $opts['title'] );
					$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
				$output .= '</div><!-- .feature-box-thumb -->';
			endif;
		break;
		
		case "content":
			if( $opts['content'] != '' ):
				$output .= '<div class="feature-box-content">';
					$output .= wp_kses_post( $opts['content'] );
				$output .= '</div><!-- .feature-box-content -->';
			endif;
		break;
		
		case "btn":
			if( $opts['btn_text'] != '' ):
				$output .= '<div class="feature-box-btn">';
					$output .= '<a class="btn '. esc_attr( $opts['btn_type'] ) .'" href="'. esc_html( $opts['btn_url'] ) .'" title="'. esc_attr( $opts['btn_text'] ) .'">'. esc_html( $opts['btn_text'] ) .'</a>';
				$output .= '</div><!-- .feature-box-btn -->';
			endif;
		break;
		
		case "video":
			if( isset( $opts['video'] ) ) :
				$output .= '<div class="feature-box-video">';
					$output .= do_shortcode( '[videoframe url="'. esc_url( $opts['video'] ) .'" width="100%" height="100%" params="byline=0&portrait=0&badge=0" /]' );
				$output .= '</div><!-- .feature-box-video -->';
			endif;
		break;
		
	}
	return $output; 
}

if ( ! function_exists( "zoacres_vc_feature_box_shortcode_map" ) ) {
	function zoacres_vc_feature_box_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Feature Box", "zoacres" ),
				"description"			=> esc_html__( "Ultimate feature box.", "zoacres" ),
				"base"					=> "zoacres_vc_feature_box",
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
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title", "zoacres" ),
						"param_name"	=> "title",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Set Title as Link", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box title as link. Enable yes to set title url.", "zoacres" ),
						"param_name"	=> "title_url_opt",
						"value"			=> array(
							esc_html__( "No", "zoacres" )	=> "no",
							esc_html__( "Yes", "zoacres" )	=> "yes"
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title External Link", "zoacres" ),
						"param_name"	=> "title_url",
						"value" 		=> "",
						'dependency' => array(
							'element' => 'title_url_opt',
							'value' => 'yes',
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "zoacres" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "zoacres" ),
						"param_name"	=> "title_head",
						"value"			=> array(
							esc_html__( "H2", "zoacres" )=> "h2",
							esc_html__( "H3", "zoacres" )=> "h3",
							esc_html__( "H4", "zoacres" )=> "h4",
							esc_html__( "H5", "zoacres" )=> "h5",
							esc_html__( "H6", "zoacres" )=> "h6",
							esc_html__( "Paragraph", "zoacres" )=> "p"
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the font color.", "zoacres" ),
						"param_name"	=> "title_color",
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "zoacres" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "zoacres" ),
						"param_name"	=> "title_text_trans",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )=> "default",
							esc_html__( "Capitalized", "zoacres" )=> "capitalize",
							esc_html__( "Upper Case", "zoacres" )=> "uppercase",
							esc_html__( "Lower Case", "zoacres" )=> "lowercase"
						),
						"group"			=> esc_html__( "Title", "zoacres" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Feature Box Layout", "zoacres" ),
						"param_name"	=> "feature_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/feature-box/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/feature-box/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/feature-box/3.png",
							"4"	=> ZOACRES_ADMIN_URL . "/assets/images/feature-box/4.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box text align", "zoacres" ),
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box Layout", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box layout.", "zoacres" ),
						"param_name"	=> "layout",
						"value"			=> array(
							esc_html__( "Normal", "zoacres" )	=> "normal",
							esc_html__( "List Style", "zoacres" )	=> "list"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Ribbon Values", "zoacres" ),
						"description"	=> esc_html__( "This is an option for corner rounded number like ribbon. This option working only when active feature box layout 4.", "zoacres" ),
						"param_name"	=> "ribbon_value",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Feature Box Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for feature box custom layout. here you can set your own layout. Drag and drop needed feature items to Enabled part.", "zoacres" ),
						'param_name'	=> 'fbox_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'icon'	=> esc_html__( 'Icon', 'zoacres' ),
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'content'	=> esc_html__( 'Content', 'zoacres' )					
							),
							'disabled' => array(
								'image'	=> esc_html__( 'Image', 'zoacres' ),
								'btn'	=> esc_html__( 'Button', 'zoacres' ),
								'video'	=> esc_html__( 'Video', 'zoacres' )
							)
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'normal',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
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
						"heading"		=> esc_html__( "Gradient Background", "zoacres" ),
						"description"	=> esc_html__( "This is an option for enable gradient background. You must give three colors.", "zoacres" ),
						"param_name"	=> "gradient_opt",
						"value"			=> array(
							esc_html__( "Disable", "zoacres" )	=> "0",
							esc_html__( "Enable", "zoacres" )	=> "1"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 1", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose gradient start color.", "zoacres" ),
						"param_name"	=> "gradient_color_1",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 2", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose gradient middle color.", "zoacres" ),
						"param_name"	=> "gradient_color_2",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 3", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose gradient end color.", "zoacres" ),
						"param_name"	=> "gradient_color_3",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box List Head", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box list head item.", "zoacres" ),
						"param_name"	=> "list_head",
						"value"			=> array(
							esc_html__( "Icon", "zoacres" )	=> "icon",
							esc_html__( "Image", "zoacres" )	=> "img"
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'list',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box List Layout", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box list layout.", "zoacres" ),
						"param_name"	=> "list_layout",
						"value"			=> array(
							esc_html__( "List Style 1", "zoacres" )	=> "list-1",
							esc_html__( "List Style 2", "zoacres" )	=> "list-2",
							esc_html__( "List Style 3", "zoacres" )	=> "list-3"
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'list',
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Icon Size", "zoacres" ),
						"description" 	=> esc_html__( "This is an option for set icon size. Example 30", "zoacres" ),
						"param_name"	=> "icon_size",
						"value" 		=> "24",
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon Vertical Middle", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box icon set vertically middle.", "zoacres" ),
						"param_name"	=> "icon_midd",
						"value"			=> array(
							esc_html__( "Yes", "zoacres" )	=> "1",
							esc_html__( "No", "zoacres" )	=> "0"
						),
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"        => "checkbox",
						"heading"     => esc_html__( "Icon Inner Space Empty", "zoacres" ),
						"description" => esc_html__( "check this to empty icon inner space.", "zoacres" ),
						"param_name"  => "icon_inner_space",
						"value"       => array(
							'Check to 0 space' => '1'
						), //value
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Choose from Icon library", "zoacres" ),
						"value" 		=> array(
							esc_html__( "None", "zoacres" ) 				=> "",
							esc_html__( "Font Awesome", "zoacres" ) 		=> "fontawesome",
							esc_html__( "Simple Line Icons", "zoacres" ) => "simplelineicons",
						),
						"admin_label" 	=> true,
						"param_name" 	=> "icon_type",
						"description" 	=> esc_html__( "Select icon library.", "zoacres" ),
						"group"			=> esc_html__( "Icon", "zoacres" ),
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
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'zoacres' ),
						'param_name' => 'icon_simplelineicons',
						"value" 	=> "vc_li vc_li-star",
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
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon Style", "zoacres" ),
						"description"	=> esc_html__( "This is an option for feature box icon style.", "zoacres" ),
						"param_name"	=> "icon_variation",
						"value"			=> array(
							esc_html__( "Dark", "zoacres" )		=> "icon-dark",
							esc_html__( "Light", "zoacres" )		=> "icon-light",
							esc_html__( "Theme", "zoacres" )		=> "theme-color",
							esc_html__( "Custom", "zoacres" )	=> "c"
						),
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the icons icon color.", "zoacres" ),
						"param_name"	=> "icon_color",
						'dependency' => array(
							'element' => 'icon_variation',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Hover Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the icon hover color.", "zoacres" ),
						"param_name"	=> "icon_hcolor",
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Background", "zoacres" ),
						"value" 		=> array(
							esc_html__( "None", "zoacres" ) => "none",
							esc_html__( "Theme Color", "zoacres" ) => "theme-color-bg",
							esc_html__( "Transparent", "zoacres" ) => "t",
							esc_html__( "Custom Color", "zoacres" )=> "c"
						),
						"param_name" 	=> "icon_bg_trans",
						"group"			=> esc_html__( "Icon", "zoacres" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Background Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the icon background color.", "zoacres" ),
						"param_name"	=> "icon_bg_color",
						'dependency' => array(
							'element' => 'icon_bg_trans',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Background Hover", "zoacres" ),
						"value" 		=> array(
							esc_html__( "None", "zoacres" ) => "none",
							esc_html__( "Transparent", "zoacres" ) => "transparent",
							esc_html__( "Set Color", "zoacres" )=> "c"
						),
						"param_name" 	=> "icon_hbg_trans",
						"group"			=> esc_html__( "Icon", "zoacres" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Background Hover Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the icon background hover color.", "zoacres" ),
						"param_name"	=> "icon_hbg_color",
						'dependency' => array(
							'element' => 'icon_hbg_trans',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Style", "zoacres" ),
						"value" 		=> array(
							esc_html__( "Squared", "zoacres" ) => "squared",
							esc_html__( "Rounded", "zoacres" ) => "rounded",
							esc_html__( "Circled", "zoacres" ) => "rounded-circle",
						),
						"param_name" 	=> "icon_style",
						"group"			=> esc_html__( "Icon", "zoacres" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Border Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the border color.", "zoacres" ),
						"param_name"	=> "border_color",
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Hover Border Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the hover border color.", "zoacres" ),
						"param_name"	=> "border_hcolor",
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Border Size", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the border size in value. Example 2", "zoacres" ),
						"param_name"	=> "border_size",
						"value" 		=> "",
						"group"			=> esc_html__( "Icon", "zoacres" )
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Feature Box Image", "zoacres" ),
						"description" => esc_html__( "Choose feature box image.", "zoacres" ),
						"param_name" => "fbox_image",
						"value" => '',
						"group"			=> esc_html__( "Image", "zoacres" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Image Style", "zoacres" ),
						"value" 		=> array(
							esc_html__( "Squared", "zoacres" ) => "squared",
							esc_html__( "Rounded", "zoacres" ) => "rounded",
							esc_html__( "Circled", "zoacres" ) => "rounded-circle",
						),
						"param_name" 	=> "img_style",
						"group"			=> esc_html__( "Image", "zoacres" ),
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image Hover Effects", "zoacres" ),
						"description"	=> esc_html__( "This is effects option for image hover.", "zoacres" ),
						"param_name"	=> "img_effects",
						"value"			=> array(
							esc_html__( "None", "zoacres" )=> "none",
							esc_html__( "Overlay", "zoacres" )=> 'overlay',
							esc_html__( "Zoom In", "zoacres" )=> 'zoomin',
							esc_html__( "Grayscale", "zoacres" )=> 'grayscale',
							esc_html__( "Blur", "zoacres" )=> 'blur'
						),
						"group"			=> esc_html__( "Image", "zoacres" )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Feature Box Video", "zoacres" ),
						"param_name" => "fbox_video",
						"value" => '',
						"description" => esc_html__( "Choose feature box video. This url maybe youtube or vimeo video. Example https://www.youtube.com/embed/qAHRvrrfGC4", "zoacres" ),
						"group"			=> esc_html__( "Video", "zoacres" )
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
						"type"			=> "textarea_html",
						"heading"		=> esc_html__( "Content", "zoacres" ),
						"description" 	=> esc_html__( "You can give the feature box content here. HTML allowed here.", "zoacres" ),
						"param_name"	=> "content",
						"value" 		=> "",
						"group"			=> esc_html__( "Content", "zoacres" )
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Items Spacing", "zoacres" ),
						"description"	=> esc_html__( "Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "zoacres" ),
						"param_name"	=> "sc_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "zoacres" ),
					),
					array(
						'type'		=> "css_editor",
						'heading'	=> esc_html__( "Css", 'zoacres' ),
						'param_name'=> "css",
						'group'		=> esc_html__( "Design options", "zoacres" ),
					)					
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_feature_box_shortcode_map" );
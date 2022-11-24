<?php 
/**
 * Zoacres Social Icons
 */

if ( ! function_exists( "zoacres_vc_social_icons_shortcode" ) ) {
	function zoacres_vc_social_icons_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_social_icons", $atts ); 
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';	
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.social-icons-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$output .= '<div class="social-icons-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			$output .= isset( $title ) && $title != '' ? '<h3 class="social-icons-title">'. esc_html( $title ) .'</h3>' : '';
			
			$social_media = array( 
				'social-fb' => 'fa fa-facebook', 
				'social-twitter' => 'fa fa-twitter', 
				'social-instagram' => 'fa fa-instagram', 
				'social-linkedin' => 'fa fa-linkedin', 
				'social-pinterest' => 'fa fa-pinterest-p', 				
				'social-youtube' => 'fa fa-youtube-play', 
				'social-vimeo' => 'fa fa-vimeo', 
				'social-soundcloud' => 'fa fa-soundcloud', 
				'social-yahoo' => 'fa fa-yahoo', 
				'social-tumblr' => 'fa fa-tumblr',  
				'social-paypal' => 'fa fa-paypal', 
				'social-mailto' => 'fa fa-envelope-o', 
				'social-flickr' => 'fa fa-flickr', 
				'social-dribbble' => 'fa fa-dribbble', 
				'social-rss' => 'fa fa-rss' 
			);

			// Actived social icons from theme option output generate via loop
			$social_icons = '';
			foreach( $social_media as $key => $icon_class ){
				
				$social_field = str_replace( "-", "_", $key );
				
				if( isset( $$social_field ) && $$social_field != '' ){
					$social_url = $$social_field;
					$social_icons .= '<li>
									<a href="'. esc_url( $social_url ) .'" class="nav-link '. esc_attr( $key ) .'">
										<i class="'. esc_attr( $icon_class ) .'"></i>
									</a>
								</li>';
				}
			}
	
			$social_class = isset( $social_icons_type ) ? ' social-' . $social_icons_type : '';
			$social_class .= isset( $social_icons_fore ) ? ' social-' . $social_icons_fore : '';
			$social_class .= isset( $social_icons_hfore ) ? ' social-' . $social_icons_hfore : '';
			$social_class .= isset( $social_icons_bg ) ? ' social-' . $social_icons_bg : '';
			$social_class .= isset( $social_icons_hbg ) ? ' social-' . $social_icons_hbg : '';
			
			$output .= '<ul class="nav social-icons '. esc_attr( $social_class ) .'">';
				$output .= $social_icons;
			$output .= '</ul>';

		$output .= '</div><!-- .social-icons-wrapper -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_social_icons_shortcode_map" ) ) {
	function zoacres_vc_social_icons_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Social Icons", "zoacres" ),
				"description"			=> esc_html__( "Social icons for link.", "zoacres" ),
				"base"					=> "zoacres_vc_social_icons",
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
						"heading"		=> esc_html__( "Title", "zoacres" ),
						"description"	=> esc_html__( "Here you put the social shortcode title.", "zoacres" ),
						"param_name"	=> "title",
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
						"heading"		=> esc_html__( "Social Iocns Type", "zoacres" ),
						"param_name"	=> "social_icons_type",
						"img_lists" => array ( 
							"squared"	=> ZOACRES_ADMIN_URL . "/assets/images/social-icons/1.png",
							"rounded"	=> ZOACRES_ADMIN_URL . "/assets/images/social-icons/2.png",
							"circled"	=> ZOACRES_ADMIN_URL . "/assets/images/social-icons/3.png",
							"transparent"	=> ZOACRES_ADMIN_URL . "/assets/images/social-icons/4.png"
						),
						"default"		=> "transparent",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for day social icons shortcode text align", "zoacres" ),
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
						"heading"		=> esc_html__( "Social Icons Fore", "zoacres" ),
						"description"	=> esc_html__( "This is an option for day social icons fore color.", "zoacres" ),
						"param_name"	=> "social_icons_fore",
						"value"			=> array(
							esc_html__( "Black", "zoacres" )	=> "black",
							esc_html__( "White", "zoacres" )		=> "white",
							esc_html__( "Own Color", "zoacres" )	=> "own"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Fore Hover", "zoacres" ),
						"description"	=> esc_html__( "This is an option for day social icons fore hover color.", "zoacres" ),
						"param_name"	=> "social_icons_hfore",
						"value"			=> array(
							esc_html__( "Own Color", "zoacres" )	=> "h-own",
							esc_html__( "Black", "zoacres" )	=> "h-black",
							esc_html__( "White", "zoacres" )		=> "h-white"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background", "zoacres" ),
						"description"	=> esc_html__( "This is an option for day social icons background color.", "zoacres" ),
						"param_name"	=> "social_icons_bg",
						"value"			=> array(
							esc_html__( "Transparent", "zoacres" )	=> "bg-transparent",
							esc_html__( "White", "zoacres" )		=> "bg-white",
							esc_html__( "Black", "zoacres" )		=> "bg-black",
							esc_html__( "Light", "zoacres" )		=> "bg-light",
							esc_html__( "Dark", "zoacres" )		=> "bg-dark",
							esc_html__( "Own Color", "zoacres" )	=> "bg-own"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background Hover", "zoacres" ),
						"description"	=> esc_html__( "This is an option for day social icons background hover color.", "zoacres" ),
						"param_name"	=> "social_icons_hbg",
						"value"			=> array(
							esc_html__( "Transparent", "zoacres" )	=> "hbg-transparent",
							esc_html__( "White", "zoacres" )		=> "hbg-white",
							esc_html__( "Black", "zoacres" )		=> "hbg-black",
							esc_html__( "Light", "zoacres" )		=> "hbg-light",
							esc_html__( "Dark", "zoacres" )		=> "hbg-dark",
							esc_html__( "Own Color", "zoacres" )	=> "hbg-own"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Facebook", "zoacres" ),
						"description"	=> esc_html__( "This is an option for facebook social icon.", "zoacres" ),
						"param_name"	=> "social_fb",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Twitter", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter social icon.", "zoacres" ),
						"param_name"	=> "social_twitter",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Instagram", "zoacres" ),
						"description"	=> esc_html__( "This is an option for instagram social icon.", "zoacres" ),
						"param_name"	=> "social_instagram",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Pinterest", "zoacres" ),
						"description"	=> esc_html__( "This is an option for pinterest social icon.", "zoacres" ),
						"param_name"	=> "social_pinterest",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Youtube", "zoacres" ),
						"description"	=> esc_html__( "This is an option for youtube social icon.", "zoacres" ),
						"param_name"	=> "social_youtube",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Vimeo", "zoacres" ),
						"description"	=> esc_html__( "This is an option for vimeo social icon.", "zoacres" ),
						"param_name"	=> "social_vimeo",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Soundcloud", "zoacres" ),
						"description"	=> esc_html__( "This is an option for soundcloud social icon.", "zoacres" ),
						"param_name"	=> "social_soundcloud",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Yahoo", "zoacres" ),
						"description"	=> esc_html__( "This is an option for yahoo social icon.", "zoacres" ),
						"param_name"	=> "social_yahoo",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Tumblr", "zoacres" ),
						"description"	=> esc_html__( "This is an option for tumblr social icon.", "zoacres" ),
						"param_name"	=> "social_tumblr",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Paypal", "zoacres" ),
						"description"	=> esc_html__( "This is an option for paypal social icon.", "zoacres" ),
						"param_name"	=> "social_paypal",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Mailto", "zoacres" ),
						"description"	=> esc_html__( "This is an option for mailto social icon.", "zoacres" ),
						"param_name"	=> "social_mailto",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Flickr", "zoacres" ),
						"description"	=> esc_html__( "This is an option for flickr social icon.", "zoacres" ),
						"param_name"	=> "social_flickr",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Dribbble", "zoacres" ),
						"description"	=> esc_html__( "This is an option for dribbble social icon.", "zoacres" ),
						"param_name"	=> "social_dribbble",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "RSS", "zoacres" ),
						"description"	=> esc_html__( "This is an option for rss social icon.", "zoacres" ),
						"param_name"	=> "social_rss",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_social_icons_shortcode_map" );
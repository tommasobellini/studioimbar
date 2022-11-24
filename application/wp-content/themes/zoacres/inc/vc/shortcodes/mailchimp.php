<?php 
/**
 * Zoacres Mailchimp
 */

if ( ! function_exists( "zoacres_vc_mailchimp_shortcode" ) ) {
	function zoacres_vc_mailchimp_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_mailchimp", $atts );
		extract( $atts );
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : '';		

		// Get VC Animation
		$class .= zoacresGetCSSAnimation( $animation );
		
		//Get mailchimp list id's
		$zoacres_option = get_option( 'zoacres_options' );
		$mc_api_key = isset( $zoacres_option['mailchimp-api'] ) ? $zoacres_option['mailchimp-api'] : '';
		
		$output = '';

		$rand_id = zoacres_shortcode_rand_id();
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.mailchimp-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';

		$output .= '<div class="mailchimp-wrapper text-center'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';

			$output .= isset( $title ) && $title != '' ? '<h3 class="mailchimp-title">'. esc_html( $title ) .'</h3>' : '';
			$output .= isset( $sub_title ) && $sub_title != '' ? '<p class="mailchimp-sub-title">'. esc_html( $sub_title ) .'</p>' : '';
			
			$output .= '<div class="form-group">';
			
				$output .= '<form class="zozo-mc-form" method="post">';

					$output .= isset( $first_name ) && $first_name == 'on' ? '<input type="text" class="form-control" name="zozo_mc_first_name" placeholder="'. esc_attr__( 'Enter First Name', 'zoacres' ) .'">' : '';
					$output .= isset( $last_name ) && $last_name == 'on' ? '<input type="text" class="form-control" name="zozo_mc_last_name" placeholder="'. esc_attr__( 'Enter Last Name', 'zoacres' ) .'">' : '';
					
					$output .= isset( $mailchimp_list ) && $mailchimp_list != '' ? '<input type="hidden" class="form-control" name="zoacres_mc_listid" value="'. esc_attr( $mailchimp_list ) .'">' : '';
	
					$placeholder = isset( $placeholder ) && $placeholder != '' ? $placeholder : '';
					
					$button_style = isset( $button_style ) ? $button_style : 'icon';
					$btn_txt = '';
					if( $button_style == 'text' ){
						$btn_txt = isset( $button_text ) && $button_text != '' ? '<span class="subscribe-text">' . $button_text . '</span>' : '<span class="fa fa-paper-plane-o"></span>';
					}elseif( $button_style == 'icon' ){
						$btn_txt = apply_filters( 'zoacres_mailchimp_icon', '<span class="fa fa-paper-plane-o"></span>' );
					}else{
						$btn_txt = isset( $button_text ) && $button_text != '' ? '<span class="subscribe-text">' . $button_text . '</span>' . apply_filters( 'zoacres_mailchimp_icon', '<span class="fa fa-paper-plane-o"></span>' ) : '<span class="fa fa-paper-plane-o"></span>';
					}
					
					if( isset( $mailchimp_layout ) && $mailchimp_layout == '1' ){
						$output .= '<div class="input-group">';
							$output .= '<input type="text" class="form-control" name="zozo_mc_email" placeholder="'. esc_attr( $placeholder ) .'">';
			
							$output .= '<span class="input-group-btn">';
								$output .= '<button class="btn btn-secondary zozo-mc" type="button">'. wp_kses_post( $btn_txt ) .'</button>'; //mc-submit-btn
							$output .= '</span>';
						$output .= '</div><!-- .input-group -->';
					}else{
						$output .= '<input type="text" class="form-control" name="zozo_mc_email" placeholder="'. esc_attr( $placeholder ) .'">';
						$output .= '<span class="input-group-btn">';
							$output .= '<button class="btn btn-secondary mc-submit-btn" type="button">'. wp_kses_post( $btn_txt ) .'</button>';
						$output .= '</span>';
					}
				$output .= '</form><!-- .mc-form -->';
				
			$output .= '</div><!-- .form-group -->';
			
			$success = isset( $success_text ) && $success_text != '' ? $success_text : esc_html__( 'Success', 'zoacres' );
			$fail = isset( $fail_text ) && $fail_text != '' ? $fail_text : esc_html__( 'Failed', 'zoacres' );
			$output .= '<div class="mc-notice-group" data-success="'. esc_html( $success ) .'" data-fail="'. esc_html( $fail ) .'">';
				$output .= '<span class="mc-notice-msg"></span>';
			$output .= '</div><!-- .mc-notice-group -->';
			
		$output .= '</div><!-- .mailchimp-wrapper -->';

		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_mailchimp_shortcode_map" ) ) {
	function zoacres_vc_mailchimp_shortcode_map() {
	
		$mailchimp_list_ids = function_exists( 'zoacres_get_mailchimp_list_ids' ) ? zoacres_get_mailchimp_list_ids() : array();
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Mailchimp", "zoacres" ),
				"description"			=> esc_html__( "AJAX mailchimp.", "zoacres" ),
				"base"					=> "zoacres_vc_mailchimp",
				"category"				=> esc_html__( "Shortcodes", "zoacres" ),
				"mailchimp"					=> "zozo-vc-mailchimp",
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
						"param_name"	=> "title",
						"value" 		=> ""
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
						"heading"		=> esc_html__( "Mailchimp Layout", "zoacres" ),
						"param_name"	=> "mailchimp_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/services/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/services/2.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Select a Mailing List", "zoacres" ),
						"description" 	=> esc_html__( "This mailchimp list's showing by given mailchimp api key from theme options.", "zoacres" ),
						"value" 		=> $mailchimp_list_ids,
						"param_name" 	=> "mailchimp_list",
						"group"			=> esc_html__( "Mailchimp", "zoacres" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Signup Button Style", "zoacres" ),
						"description" 	=> esc_html__( "This is an option for mailchimp button style.", "zoacres" ),
						"value" 		=> array(
							esc_html__( "Only Text", "zoacres" ) 	=> "text",
							esc_html__( "Only Icon", "zoacres" ) 	=> "icon",
							esc_html__( "Text with Icon", "zoacres" ) => "text-icon",
						),
						"param_name" 	=> "button_style",
						"group"			=> esc_html__( "Mailchimp", "zoacres" ),
					),		
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Signup Button Text", "zoacres" ),
						"description"		=> esc_html__( "This is the option for mailchimp singup button text. If no text need, then leave it empty.", "zoacres" ),
						"param_name"	=> "button_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Placeholder Text", "zoacres" ),
						"description"		=> esc_html__( "This is for placeholder text.", "zoacres" ),
						"param_name"	=> "placeholder",
						"value" 		=> "",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "First Name Field", "zoacres" ),
						"description"	=> esc_html__( "This is an option for collect first name.", "zoacres" ),
						"param_name"	=> "first_name",
						"value"			=> "off",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Last Name Field", "zoacres" ),
						"description"	=> esc_html__( "This is an option for collect last name.", "zoacres" ),
						"param_name"	=> "last_name",
						"value"			=> "off",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Sub Title", "zoacres" ),
						"description"	=> esc_html__( "This subtitle text show below of mailchimp title.", "zoacres" ),
						"param_name"	=> "sub_title",
						"value" 		=> "",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Success Text", "zoacres" ),
						"description"	=> esc_html__( "This success message text for mailchimp.", "zoacres" ),
						"param_name"	=> "success_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Failed Text", "zoacres" ),
						"description"	=> esc_html__( "This failed message text for mailchimp.", "zoacres" ),
						"param_name"	=> "fail_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Mailchimp", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_mailchimp_shortcode_map" );
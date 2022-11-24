<?php 
/**
 * Zoacres Twitter
 */

if ( ! function_exists( "zoacres_vc_twitter_shortcode" ) ) {
	function zoacres_vc_twitter_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_twitter", $atts );
		extract( $atts );

		$output = '';

		//Defined Variable
		$animation = isset( $animation ) ? $animation : '';
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $twitter_layout ) ? ' twitter-' . $twitter_layout : ' twitter-1';
		$class_names .= isset( $variation ) ? ' twitter-' . $variation : '';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		
		// Get VC Animation
		$class_names .= zoacresGetCSSAnimation( $animation );
	
		$gal_atts = $data_atts = '';
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
		}
		
		//Twitter API Details
		$twitter_id = isset( $twitter_id ) ? esc_attr( $twitter_id ) : '';
		$consumer_key = isset( $consumer_key ) ? esc_attr( $consumer_key ) : '';
		$consumer_secret = isset( $consumer_secret ) ? esc_attr( $consumer_secret ) : '';
		$access_token = isset( $access_token ) ? esc_attr( $access_token ) : '';
		$access_token_secret = isset( $access_token_secret ) ? esc_attr( $access_token_secret ) : '';
		$tweet_count = isset( $tweet_count ) ? absint( $tweet_count ) : '';
		
		if( class_exists( "ZoacresRedux" ) ){
			$tweets = zoacres_get_tweets( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $tweet_count, $twitter_id );
		}else{
			return false;
		}
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.twitter-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$output .= '<div class="twitter-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
		// Check tweets array
		$output .= isset( $title ) && $title != '' ? '<h3 class="twitter-title">' . esc_html( $title ) . '</h3>' : '';
		
		if( $tweets && is_array( $tweets ) ) {
			$output .= '<div class="twitter-feeds">';
				$slide_class = isset( $slide_opt ) && $slide_opt == 'on' ? ' owl-carousel' : '';
				$output .= '<ul class="twitter-box'. esc_attr( $slide_class ) .'" '. ( isset( $slide_opt ) && $slide_opt == 'on' ? $data_atts : '' ) .'>';
					$i = 0; // for no.of tweets showing
					foreach( $tweets as $tweet ) {
					
						if( $i < $tweet_count ){
							$i++; 
						
							$output .= '<li class="tweet-item">';
							
								$tweet_time = strtotime( $tweet['created_at'] ); 
								$time_ago = zoacres_tweet_time_ago( $tweet_time );
								
								if( isset( $twitter_layout ) && $twitter_layout == '2' ){
									
									$output .= '<div class="tweet-info">';
										$output .= '<div class="media">';
											$output .= '<a href="http://twitter.com/'. esc_attr( $tweet["user"]["screen_name"] ) .'/statuses/'. esc_attr( $tweet['id_str'] ) .'">';
												$output .= '<img class="d-flex mr-3 tweet-img" src="'. $tweet['user']['profile_image_url'] .'" alt="'. esc_attr( $tweet['user']['screen_name'] ) .'" />';
											$output .= '</a>';
											$output .= '<div class="media-body">';
												$output .= '<h5 class="mt-0 tweet-title">';
													$output .= '<a href="http://twitter.com/'. esc_attr( $tweet['user']['screen_name'] ) .'/statuses/'. esc_attr( $tweet['id_str'] ) .'">';
														$output .= esc_attr( $tweet['user']['screen_name'] );
													$output .= '</a>';
												$output .= '</h5>';
												$output .= '<p class="tweet-text">';
													$tweet_text = $tweet['text'];
													$tweet_text = preg_replace( "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a href=\"\\0\">\\0</a>", $tweet_text );
													$output .= wp_kses_post( $tweet_text );
												$output .= '</p>';
											$output .= '</div><!-- .media-body -->';
										$output .= '</div><!-- .media -->';
									$output .= '</div><!-- .tweet-info -->';
								
								}else{
									$output .= '<div class="tweet-info">';
										$output .= '<a href="http://twitter.com/'. esc_attr( $tweet["user"]["screen_name"] ) .'/statuses/'. esc_attr( $tweet['id_str'] ) .'">';
											$output .= '<img class="d-block tweet-img" src="'. $tweet['user']['profile_image_url'] .'" alt="'. esc_attr( $tweet['user']['screen_name'] ) .'" />';
										$output .= '</a>';
										$output .= '<h5 class="mt-0 tweet-title">';
											$output .= '<a href="http://twitter.com/'. esc_attr( $tweet['user']['screen_name'] ) .'/statuses/'. esc_attr( $tweet['id_str'] ) .'">';
												$output .= esc_attr( $tweet['user']['screen_name'] );
											$output .= '</a>';
										$output .= '</h5>';
										$output .= '<p class="tweet-text">';
											$tweet_text = $tweet['text'];
											$tweet_text = preg_replace( "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a href=\"\\0\">\\0</a>", $tweet_text );
											$output .= wp_kses_post( $tweet_text );
										$output .= '</p>';
									$output .= '</div><!-- .tweet-info -->';
								}
							$output .= '</li>';
						}
					}//foreach
				$output .= '</ul>';
			$output .= '</div>';
			
		}// tweet array check
			
		$output .= '</div><!-- .twitter-wrapper -->';
		return $output;
	}
}

if ( ! function_exists( "zoacres_vc_twitter_shortcode_map" ) ) {
	function zoacres_vc_twitter_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Twitter", "zoacres" ),
				"description"			=> esc_html__( "Recent tweets.", "zoacres" ),
				"base"					=> "zoacres_vc_twitter",
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
						"heading"		=> esc_html__( "Twitter Layout", "zoacres" ),
						"param_name"	=> "twitter_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/twitter/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/twitter/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/twitter/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Twitter Variation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter variation either dark or light.", "zoacres" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "zoacres" )	=> "light",
							esc_html__( "Dark", "zoacres" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter text align", "zoacres" ),
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
						"heading"		=> esc_html__( "Twitter ID", "zoacres" ),
						"param_name"	=> "twitter_id",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Consumer Key", "zoacres" ),
						"param_name"	=> "consumer_key",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Consumer Secret", "zoacres" ),
						"param_name"	=> "consumer_secret",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Access Token", "zoacres" ),
						"param_name"	=> "access_token",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Access Token Secret", "zoacres" ),
						"param_name"	=> "access_token_secret",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Tweet Count", "zoacres" ),
						"param_name"	=> "tweet_count",
						"value" 		=> "",
						"group"			=> esc_html__( "API", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider option.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for twitter slider scroll by.", "zoacres" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "zoacres_vc_twitter_shortcode_map" );
<?php 
/**
 * Zoacres Agent
 */

if ( ! function_exists( "zoacres_vc_zoagent_shortcode" ) ) {
	function zoacres_vc_zoagent_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_zoagent", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $text_align ) && $text_align != '' ? ' text-' . $text_align : '';
		$class_names .= isset( $animate_grid ) && $animate_grid == 'on' ? ' zoacres-animate' : '';
		
		$agent_style = isset( $zoagent_style ) ? ' agent-modal-' . $zoagent_style : ' agent-modal-1';
		$class_names .= $agent_style;
		
		$agent_layout = isset( $zoagent_layout ) ? $zoagent_layout : 'grid';
		$class_names .= ' agent-layout-' . $agent_layout;
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			$layout = isset( $zoagent_layout ) ? $zoagent_layout : 'grid';
			if( $layout == 'list' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . ' .agent-sc-wrap .agent-right-wrap >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . ' .agent-sc-wrap >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$css_class = '';
		if( $shortcode_css ) $css_class = ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 3;
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 15;
		if( isset( $zoagent_cols ) && $zoagent_cols != '' ){
			$cols = 'col-lg-'. esc_attr( $zoagent_cols );
			$cols .= $zoagent_cols != '12' ? ' col-md-6' : '';
		}else{
			$cols = 'col-lg-4 col-md-6';
		}
		$animate_grid = isset( $animate_grid ) && $animate_grid != '' ? $animate_grid : 'no';
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : esc_html__( "Contact Me", "zoacres" );
		$filter_by = isset( $filter_by ) && $filter_by != '' ? $filter_by : 'agent';
		
		$cols = $agent_layout != 'list' ? $cols : 'col-md-12';
		
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
		
		$agent_items = isset( $zoagent_items ) ? zoacres_drag_and_drop_trim( $zoagent_items ) : array( 'Enabled' => '' );
		$agent_items = isset( $agent_items['Enabled'] ) && !empty( $agent_items['Enabled'] ) ? $agent_items['Enabled'] : '';
		
		// Normal Top Bottom Meta
		$top_meta = isset( $top_meta ) ? zoacres_drag_and_drop_trim( $top_meta ) : array( 'Left' => '', 'Right' => '' );
		$bottom_meta = isset( $bottom_meta ) ? zoacres_drag_and_drop_trim( $bottom_meta ) : array( 'Left' => '', 'Right' => '' );
		
		$overlay_stat = 0;
		if( isset( $overlay_meta_opt ) && $overlay_meta_opt == 'yes' ){
			$overlay_meta = isset( $overlay_meta ) ? zoacres_drag_and_drop_trim( $overlay_meta ) : array( 'Left' => '', 'Right' => '' );
			$overlay_stat = 1;
		}
		
		$img_size = $img_csize = '';
		if( isset( $image_size ) ){
			$img_size = $image_size != '' ? $image_size : 'medium';
			if( $img_size == 'custom' ){
				$img_csize = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '500x500';
			}
		}
		
		$post_in = $post_not_in = '';
		if( $filter_by == 'agent' ){
		
			$agent_id = isset( $agent_id ) && $agent_id != '' ? $agent_id : '';
			if( $agent_id ){
				$post_in = zoacres_explode_array( $agent_id );
			}
						
		}elseif( $filter_by == 'agency' ){
		
			$agency_id = isset( $agency_id ) && $agency_id != '' ? $agency_id : '';
			if( $agency_id ){
				$post_in = zoacres_explode_array( $agency_id );
			}
			
		}
		
		$exclude_post_ids = isset( $exclude_post_ids ) && $exclude_post_ids != '' ? $exclude_post_ids : '';
		if( $exclude_post_ids ){
			$post_not_in = zoacres_explode_array( $exclude_post_ids );
		}
		
		$order = 'DESC';
		$orderby = '';
		$filter = isset( $agent_filter ) ? $agent_filter : 'recent';
		if( $filter == 'recent' ){ // ascending order
			$order = 'DESC';
		}elseif( $filter == 'asc' ){ // ascending order
			$order = 'ASC';
		}elseif( $filter == 'random' ){
			$orderby = 'rand';
		}
		
		$zpe = new ZoacresPropertyElements();
		$zpe::$cus_excerpt_len = $excerpt_length;
		
		$args = array(
			'post_type' => 'zoacres-agent',
			'posts_per_page' => absint( $ppp ),
			'order' => $order,
			'orderby' => $orderby,
			'post__in' => $post_in,
			'post__not_in' => $post_not_in,
			'meta_query' => array(
				 array(
					'key'       => 'zoacres_agent_type',
					'value'     => esc_attr( $filter_by ),
					'compare'   => '='
				 )
			)
		);
		
		$extra_args = array();
		$extra_args['more_text'] = $more_text;
		
		$row_class = 'row';
		if( $slide_stat ){
			$cols = 'agent-item';
			$row_class = 'owl-carousel';
		}
		
		$row_class .= $css_class;
		
		// The Query
		$query = new WP_Query( $args );
		
		// The Loop
		if ( $query->have_posts() ) {
			$output .= '<div class="'. esc_attr( $row_class ) .'" '. ( $data_atts ) .' data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				while ( $query->have_posts() ) {
					$query->the_post();
					
					$output .= '<div class="'. esc_attr( $cols ) .'">';
					
						$agent_id = get_the_ID();
						
						if( !empty( $agent_items ) && is_array( $agent_items ) ){
							$list_stat = 0;
							$output .= '<div class="agent-sc-wrap '. esc_attr( $class_names ) .'">';
							foreach( $agent_items as $element => $value ){
								switch( $element ) {
									case "image":
										if( $agent_layout == 'list' ){
											$list_stat = 1;
											$output .= '<div class="agent-left-wrap">';
										}
											$overlay_class = $overlay_stat ? ' agent-image-overlay-on' : '';
											$output .= '<div class="agent-image-wrap'. esc_attr( $overlay_class ) .'">';
												if( $img_size == "custom" ){
													$custom_opt = explode( "x", $img_csize );
													$img_prop = zoacres_custom_image_size_chk( $img_size, $custom_opt );
													$img_size = array( $img_prop[1], $img_prop[2] );
												}
												if( is_array( $img_size ) ){
													$img_prop = zoacres_custom_image_size_chk( "", $img_size, $agent_id );
													$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid" alt="'. esc_attr( get_the_title() ) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
												}else{
													$property_img_url = get_the_post_thumbnail_url( absint( $agent_id ), $img_size );
													$output .= '<img src="'. esc_url( $property_img_url ) .'" class="img-fluid" alt="'. esc_attr( get_the_title() ) .'" />';
												}
												
												if( $overlay_stat ){
													$output .= '<div class="agent-meta agent-overlay-meta">';
													if( isset( $overlay_meta['Left'] ) && !empty( $overlay_meta['Left'] ) ){
														$overlay_meta_items = $overlay_meta['Left'];
														$output .= '<ul class="nav agent-meta-left">'. zoacres_agent_shortcode_meta_items( $overlay_meta_items, $extra_args ) .'</ul>';
													}
													if( isset( $overlay_meta['Right'] ) && !empty( $overlay_meta['Right'] ) ){
														$overlay_meta_items = $overlay_meta['Right'];
														$output .= '<ul class="nav agent-meta-right pull-right">'. zoacres_agent_shortcode_meta_items( $overlay_meta_items, $extra_args ) .'</ul>';
													}
													$output .= '</div>';
												} // Overlay Meta
												
											$output .= '</div>';
										if( $agent_layout == 'list' ){
											$output .= '</div><!-- .agent-left-wrap -->';
											$output .= '<div class="agent-right-wrap align-self-center">';
										}
									break;
									
									case "name":
										$agent_desg = get_post_meta( absint( $agent_id ), 'zoacres_agent_position', true );
										$output .= '<div class="agent-title-wrap">';
											$output .= '<h5><a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'">'. esc_html( get_the_title() ) .'</a></h5>';
											$output .= '<p>'. esc_html( $agent_desg ) .'</p>';
										$output .= '</div>';
									break;
									
									case "excerpt":
										add_filter( 'excerpt_length', __return_value( $excerpt_length ) );
										$output .= '<div class="agent-excerpt-wrap">';
											$output .= get_the_excerpt();
										$output .= '</div>';
									break;
									
									case "contact":
										$contact_items = isset( $zoagent_contact_items ) ? zoacres_drag_and_drop_trim( $zoagent_contact_items ) : array( 'Enabled' => '' );
										$contact_items = isset( $contact_items['Enabled'] ) && !empty( $contact_items['Enabled'] ) ? $contact_items['Enabled'] : '';
										if( !empty( $contact_items ) ){
										
											$output .= '<div class="agent-contact-details">';	
												$output .= '<ul class="nav flex-column agent-details">';
										
											foreach( $contact_items as $element => $value ){
												switch( $element ) {
													case "mobile":
														$mobile = get_post_meta( absint( $agent_id ), 'zoacres_agent_mobile', true );
														$output .= $mobile != '' ? '<li><span class="agent-mobile"><i class="icon-screen-smartphone"></i> <a href="tel:'. esc_attr( preg_replace('/(\W*)/', '', $mobile) ) .'">'. esc_html( $mobile ) .'</a></span></li>' : '';
													break;
													
													case "phone":
														$tele = get_post_meta( absint( $agent_id ), 'zoacres_agent_telephone', true );
														$output .= $tele != '' ? '<li><span class="agent-telephone"><i class="icon-phone"></i> <a href="tel:'. esc_attr( preg_replace('/(\W*)/', '', $tele) ) .'">'. esc_html( $tele ) .'</a></span></li>' : '';
													break;
													
													case "skype":
														$skype = get_post_meta( absint( $agent_id ), 'zoacres_agent_skype', true );
														$output .= $skype != '' ? '<li><span class="agent-skype"><i class="icon-social-skype"></i> '. esc_html( $skype ) .'</span></li>' : '';
													break;
													
													case "email":
														$agent_email = get_post_meta( absint( $agent_id ), 'zoacres_agent_email', true );
														$output .= $agent_email != '' ? '<li><span class="agent-email"><i class="icon-envelope-open"></i> <a href="mailto:'. esc_attr( $agent_email ) .'">'. esc_html( $agent_email ) .'</a></span></li>' : '';
													break;
													
													case "website":
														$website = get_post_meta( absint( $agent_id ), 'zoacres_agent_website', true );
														$output .= $website != '' ? '<li><span class="agent-website"><i class="icon-link"></i> <a href="'. esc_url( $website ) .'">'. esc_html( $website ) .'</a></span></li>' : '';
													break;
													
													case "address":
														$address = get_post_meta( absint( $agent_id ), 'zoacres_agent_address', true );
														$output .= $address != '' ? '<li><span class="agent-address"><i class="icon-link"></i></span><div class="agent-address-inner">'. esc_html( $agent_email ) .'</div></li>' : '';
													break;
													
													case "rating":
														$ratings = get_post_meta( $agent_id, 'rated_users_ratings', true );
														$average_ratings = !empty( $ratings ) ? array_sum( $ratings ) / count( $ratings ) : '0';
														$rating_out = $average_ratings != '' && function_exists('zoacres_star_rating') ? zoacres_star_rating( $average_ratings ) : '';
														$output .= $ratings != '' ? '<li><span class="agent-rating">'. esc_html__( 'Rating', 'zoacres' ) .'</span> '. wp_kses_post( $rating_out ) .'</li>' : '';
													break;													
													
												}
											}
												$output .= '</ul>';
											$output .= '</div>';
										}
									break;
									
									case "tm":
										$output .= '<div class="agent-meta agent-top-meta">';
										if( isset( $top_meta['Left'] ) && !empty( $top_meta['Left'] ) ){
											$top_meta_items = $top_meta['Left'];
											$output .= '<ul class="nav agent-meta-left">'. zoacres_agent_shortcode_meta_items( $top_meta_items, $extra_args ) .'</ul>';
										}
										if( isset( $top_meta['Right'] ) && !empty( $top_meta['Right'] ) ){
											$top_meta_items = $top_meta['Right'];
											$output .= '<ul class="nav agent-meta-right pull-right">'. zoacres_agent_shortcode_meta_items( $top_meta_items, $extra_args ) .'</ul>';
										}
										$output .= '</div>';
									break;
									
									case "bm":
										$output .= '<div class="agent-meta agent-bottom-meta">';
										if( isset( $bottom_meta['Left'] ) && !empty( $bottom_meta['Left'] ) ){
											$bottom_meta_items = $bottom_meta['Left'];
											$output .= '<ul class="nav agent-meta-left">'. zoacres_agent_shortcode_meta_items( $bottom_meta_items, $extra_args ) .'</ul>';
										}
										if( isset( $bottom_meta['Right'] ) && !empty( $bottom_meta['Right'] ) ){
											$bottom_meta_items = $bottom_meta['Right'];
											$output .= '<ul class="nav agent-meta-right pull-right">'. zoacres_agent_shortcode_meta_items( $bottom_meta_items, $extra_args ) .'</ul>';
										}
										$output .= '</div>';
									break;
									
									case "rating":
										$ratings = get_post_meta( $agent_id, 'rated_users_ratings', true );
										$average_ratings = !empty( $ratings ) ? array_sum( $ratings ) / count( $ratings ) : '0';
										$rating_out = $average_ratings != '' && function_exists('zoacres_star_rating') ? zoacres_star_rating( $average_ratings ) : '';
										$output .= $ratings != '' ? '<div class="agent-rating-wrap"><span class="agent-rating">'. esc_html__( 'Rating', 'zoacres' ) .'</span> '. wp_kses_post( $rating_out ) .'</div>' : '';
									break;	
									
								}
							}
							
							if( $list_stat ){
								$output .= '</div><!-- .agent-right-wrap -->';
							}
							
						}
						
						$output .= '</div><!-- .agent-sc-wrap -->';
						
					$output .= '</div><!-- .col -->';
						
				}
			$output .= '</div><!-- .row -->';
			wp_reset_postdata();
		}
		
		return $output;
	}
}

function zoacres_agent_shortcode_meta_items( $agent_items, $extra_args ){

	$output = '';
	
	$agent_id = get_the_ID();
	
	//name, more, social, listings
	if( !empty( $agent_items ) && is_array( $agent_items ) ){
		foreach( $agent_items as $element => $value ){
			switch( $element ) {
				case "name":
					$output .= '<li class="nav-item"><h5 class="agent-title"><a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'">'. esc_html( get_the_title() ) .'</a></h5></li>';
				break;
				case "more":
					$output .= '<li class="nav-item"><a href="'. esc_url( get_the_permalink() ) .'" class="btn">'. esc_html( $extra_args['more_text'] ) .'</a></li>';
				break;
				case "social":
					//zoacres_agent_fb_link, zoacres_agent_twitter_link, zoacres_agent_linkedin_link, zoacres_agent_yt_link, zoacres_agent_instagram_link
					$fb = get_post_meta( $agent_id, 'zoacres_agent_fb_link', true );
					$twit = get_post_meta( $agent_id, 'zoacres_agent_twitter_link', true );
					$lnk = get_post_meta( $agent_id, 'zoacres_agent_linkedin_link', true );					
					$yt = get_post_meta( $agent_id, 'zoacres_agent_yt_link', true );
					$insta = get_post_meta( $agent_id, 'zoacres_agent_instagram_link', true );
					
					$output .= '<li class="nav-item"><ul class="nav agent-social-links">';
						$output .= $fb != '' ? '<li><a href="'. esc_url( $fb ) .'"><span class="fa fa-facebook"></span></a></li>' : '';
						$output .= $twit != '' ? '<li><a href="'. esc_url( $twit ) .'"><span class="fa fa-twitter"></span></a></li>' : '';
						$output .= $lnk != '' ? '<li><a href="'. esc_url( $lnk ) .'"><span class="fa fa-linkedin"></span></a></li>' : '';			
						$output .= $yt != '' ? '<li><a href="'. esc_url( $yt ) .'"><span class="fa fa-youtube-play"></span></a></li>' : '';
						$output .= $insta != '' ? '<li><a href="'. esc_url( $insta ) .'"><span class="fa fa-instagram"></span></a></li>' : '';
					$output .= '</ul></li>';

				break;
				case "listings":
					$agent_args = array(
						'post_type' => 'zoacres-property',
						'posts_per_page' => -1,
						'meta_key' => 'zoacres_property_agent_id',
						'meta_value' => $agent_id
					);
					$agent_query = new WP_Query( $agent_args );
					$property_count = $agent_query->found_posts;
					$output .= '<li class="nav-item"><a href="'. esc_url( get_the_permalink() ) .'" class="agent-listings">'. $property_count .' '. esc_html__( 'Listings', 'zoacres' ) .'</a></li>';
				break;
			}
		}
	}
	
	return $output;
}

if ( ! function_exists( "zoacres_vc_zoagent_shortcode_map" ) ) {
	function zoacres_vc_zoagent_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Agent", "zoacres" ),
				"description"			=> esc_html__( "Agent custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_zoagent",
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
						"heading"		=> esc_html__( "Agent Per Page", "zoacres" ),
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
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Filter By", "zoacres" ),
						"param_name"	=> "filter_by",
						"value"			=> array(
							esc_html__( "Agent", "zoacres" )	=> "agent",
							esc_html__( "Agency", "zoacres" )	=> "agency"
						),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Agent ID\'s', "zoacres" ),
						'param_name'	=> 'agent_id',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter agent id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "filter_by", "value" => 'agent' ),
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Agency ID\'s', "zoacres" ),
						'param_name'	=> 'agency_id',
						'value' 		=> '',
						'description'	=> esc_html__( 'Here you can enter agency id\'s like 4, 5, 6.', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' ),
						"dependency" => array( "element" => "filter_by", "value" => 'agency' ),
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Filter", "zoacres" ),
						"param_name"	=> "agent_filter",
						"value"			=> array(
							esc_html__( "Recent Agent(Descending)", "zoacres" )	=> "recent",
							esc_html__( "Older Agent(Ascending)", "zoacres" )		=> "asc",
							esc_html__( "Random", "zoacres" )					=> "random"
						),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Exclude Agent/Agency ID\'s', "zoacres" ),
						'param_name'	=> 'exclude_post_ids',
						'description'	=> esc_html__( 'Manually enter agent/agency id\'s for exclude. eg: 21, 15, 30', "zoacres" ),
						'group'			=> esc_html__( 'Filter', 'zoacres' )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Agent Grid Load Animation", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable agent/agency grid animate when load.", "zoacres" ),
						"param_name"	=> "animate_grid",
						"value"			=> "on",
						"group"			=> esc_html__( "Filter", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Agent Layout Modal", "zoacres" ),
						"description"	=> esc_html__( "This is option for agent layout style.", "zoacres" ),
						"param_name"	=> "zoagent_style",
						"value"			=> array(
							esc_html__( "Style 1", "zoacres" )	=> "1",
							esc_html__( "Style 2", "zoacres" )	=> "2",
							esc_html__( "Style 3", "zoacres" )	=> "3",
							esc_html__( "Style 4", "zoacres" )	=> "4"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Agent Layout", "zoacres" ),
						"description"	=> esc_html__( "This is option for agent layout grid or list.", "zoacres" ),
						"param_name"	=> "zoagent_layout",
						"value"			=> array(
							esc_html__( "Grid", "zoacres" )	=> "grid",
							esc_html__( "List", "zoacres" )	=> "list",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Agent Columns", "zoacres" ),
						"description"	=> esc_html__( "This is option for property columns.", "zoacres" ),
						"param_name"	=> "zoagent_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
						),
						"std"			=> "4",
						"dependency"	=> array(
							"element"	=> "zoagent_layout",
							"value"		=> "grid"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Agent Overlay Meta", "zoacres" ),
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
						'heading'		=> esc_html__( 'Agent Overlay Top Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is options for property overlay meta items. You can enable the items from drag and drop to enabled part like Left/Right.", "zoacres" ),
						'param_name'	=> 'overlay_meta',
						'dd_fields' => array ( 
							'Left'  => array(
							),
							'Right'  => array(
								'listings'	=> esc_html__( 'No.of Listings', 'zoacres' )						
							),
							'disabled' => array(
								'name'	=> esc_html__( 'Name', 'zoacres' ),
								'social'	=> esc_html__( 'Social Links', 'zoacres' ),
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								
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
						'heading'		=> esc_html__( 'Agent Top Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for agent/agency top meta.", "zoacres" ),
						'param_name'	=> 'top_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'name'	=> esc_html__( 'Name', 'zoacres' ),
							),
							'Right'  => array(
								
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'social'	=> esc_html__( 'Social Links', 'zoacres' ),
								'listings'	=> esc_html__( 'No.of Listings', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Agent Bottom Meta Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for agent/agency bottom meta.", "zoacres" ),
						'param_name'	=> 'bottom_meta',
						'dd_fields' => array ( 
							'Left'  => array(
								'social'	=> esc_html__( 'Social Links', 'zoacres' ),
							),
							'Right'  => array(
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								
							),
							'disabled' => array(
								'name'	=> esc_html__( 'Name', 'zoacres' ),
								'listings'	=> esc_html__( 'No.of Listings', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Agent Contact Details', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for agent contact details as drag and drop items. Drag and drop needed contact items to Enabled part.", "zoacres" ),
						'param_name'	=> 'zoagent_contact_items',
						'dd_fields' => array ( 
							'Enabled'  => array(
								'mobile'	=> esc_html__( 'Mobile', 'zoacres' ),
								'email'	=> esc_html__( 'Email', 'zoacres' )
							),
							'disabled' => array(
								'phone'	=> esc_html__( 'Phone', 'zoacres' ),
								'skype'	=> esc_html__( 'Skype', 'zoacres' ),
								'website'	=> esc_html__( 'Website', 'zoacres' ),
								'address'	=> esc_html__( 'Address', 'zoacres' ),
								'rating'	=> esc_html__( 'Rating', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Agent Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for property custom layout. here you can set your own layout. Drag and drop needed property items to Enabled part.", "zoacres" ),
						'param_name'	=> 'zoagent_items',
						'dd_fields' => array ( 
							'Enabled'  => array(
								'image'	=> esc_html__( 'Image', 'zoacres' ),
								'name'	=> esc_html__( 'Name', 'zoacres' ),
								'contact'	=> esc_html__( 'Contacts', 'zoacres' ),
								'bm'	=> esc_html__( 'Bottom Meta', 'zoacres' ),
							),
							'disabled' => array(
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' ),
								'tm'	=> esc_html__( 'Top Meta', 'zoacres' ),
								'rating'	=> esc_html__( 'Rating', 'zoacres' )
								
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is option for agent/agency grid text align", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_zoagent_shortcode_map" );
<?php 
/**
 * Zoacres Team
 */

if ( ! function_exists( "zoacres_vc_team_shortcode" ) ) {
	function zoacres_vc_team_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_team", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$class_names .= isset( $team_layout ) ? ' team-' . $team_layout : ' team-1';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' team-' . $variation : '';
		$cols = isset( $team_cols ) ? $team_cols : 12;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		
		$team_model = isset( $team_model ) && $team_model != '' ? 'team-'.$team_model : 'team-grid'; 
		
		$sclass_name = isset( $social_style ) && !empty( $social_style ) ? ' social-' . $social_style : '';
		$sclass_name .= isset( $social_color ) && !empty( $social_color ) ? ' social-' . $social_color : '';
		$sclass_name .= isset( $social_hcolor ) && !empty( $social_hcolor ) ? ' social-' . $social_hcolor : '';
		$sclass_name .= isset( $social_bg ) && !empty( $social_bg ) ? ' social-' . $social_bg : '';
		$sclass_name .= isset( $social_hbg ) && !empty( $social_hbg ) ? ' social-' . $social_hbg : '';
		
		$overlay_class = '';
		$overlay_class .= isset( $team_overlay_position ) ? ' overlay-'.$team_overlay_position : ' overlay-center';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper, .' . esc_attr( $rand_class ) . '.team-wrapper.team-dark .team-inner { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Overlay Styles
		$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
		$shortcode_css .= isset( $team_overlay_font_color ) && $team_overlay_font_color != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay { color: '. esc_attr( $team_overlay_font_color ) .'; }' : '';
		$shortcode_css .= isset( $team_overlay_custom_color ) && $team_overlay_custom_color != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper .team-thumb .overlay-custom { background: '. esc_attr( $team_overlay_custom_color ) .'; }' : '';
		
		$overlay_link = isset( $team_overlay_link_colors ) ? $team_overlay_link_colors : '';
		if( $overlay_link ){
			$overlay_link = preg_replace('/\s+/', '', $overlay_link);
			$overlay_link_arr = explode(",",$overlay_link);
			if( isset( $overlay_link_arr[0] ) && $overlay_link_arr[0] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay a.client-name { color: '. esc_attr( $overlay_link_arr[0] ) .'; }';
			}
			if( isset( $overlay_link_arr[1] ) && $overlay_link_arr[1] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay a.client-name:hover { color: '. esc_attr( $overlay_link_arr[1] ) .'; }';
			}
		}
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			if( $team_model == 'team-list' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . '.team-wrapper .team-inner .media-body >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.team-wrapper .team-inner >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$gal_atts = '';
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
		
		$args = array(
			'post_type' => 'zoacres-team',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
			
			$output .= '<div class="team-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$row_stat = 0;
				
					//Team Slide
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	

					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
						
						// Parameters Defined
						$post_id = get_the_ID();
						$team_array = array(
							'post_id' => $post_id,
							'excerpt_length' => $excerpt_length,
							'cols' => $cols,
							'more_text' => $more_text,
							'social_class' => $sclass_name,
							'list_stat' => true
						);
					
						//Overlay Output Formation
						$overlay_out = '';
						if( isset( $team_overlay_opt ) && $team_overlay_opt == 'enable' ) {
							if( isset( $team_overlay_type ) && $team_overlay_type != 'none' ){
								$overlay_out .= '<span class="overlay-bg overlay-'. esc_attr( $team_overlay_type ) .'"></span>';
							}
							$overlay_out .= '<div class="team-overlay'. esc_attr( $overlay_class ) .'">';
								
								$overlay_elemetns = isset( $overlay_team_items ) ? zoacres_drag_and_drop_trim( $overlay_team_items ) : array( 'Enabled' => '' );

								if( isset( $overlay_elemetns['Enabled'] ) ) :
									foreach( $overlay_elemetns['Enabled'] as $element => $value ){
										$overlay_out .= zoacres_team_shortcode_elements( $element, $team_array );
									}
								endif;
								
							$overlay_out .= '</div><!-- .team-overlay -->';
						}
					
						if( $row_stat == 0 && $slide_opt != 'on' ) :
							$output .= '<div class="row">';
						endif;
					
						//Team Slide Item
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="item">';	

						$col_class = "col-lg-". absint( $cols );
						
						if( $team_model == 'team-list' )
							$col_class .= " col-md-12";
						else
							$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
							
						$output .= '<div class="'. esc_attr( $col_class ) .'">';
							$inner_class = $overlay_out ? ' team-overlay-actived' : '';
							$output .= '<div class="team-inner'. esc_attr( $inner_class ) .'">';

							$elemetns = isset( $team_items ) ? zoacres_drag_and_drop_trim( $team_items ) : array( 'Enabled' => '' );

							if( isset( $elemetns['Enabled'] ) ) :
							
							
								if( $team_model == 'team-list' && array_key_exists( "thumb", $elemetns['Enabled'] ) ) {
									$output .= '<div class="media">';
										$output .= '<div class="team-left-wrap">';
										$team_array['list_stat'] = true;
										$output .= zoacres_team_shortcode_elements( 'thumb', $team_array );
										$team_array['list_stat'] = false;
										$output .= '</div><!-- .team-left-wrap -->';
										$output .= '<div class="media-body team-right-wrap">';
								}

								foreach( $elemetns['Enabled'] as $element => $value ){
									if( $element == 'thumb' ){
										$team_array['overlay'] = $overlay_out;
									}
									$output .= zoacres_team_shortcode_elements( $element, $team_array );
								}
								
								if( $team_model == 'team-list' && array_key_exists( "thumb", $elemetns['Enabled'] ) ) {
										$output .= '</div><!-- .media-body -->';
									$output .= '</div><!-- .media -->';							
								}
								
							endif;
							
							$output .= '</div><!-- .team-inner -->';
						$output .= '</div><!-- .cols -->';
						
						//Team Slide Item End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .item -->';	
									
						$row_stat++;
						if( $row_stat == ( 12/ $cols ) && $slide_opt != 'on' ) :
							$output .= '</div><!-- .row -->';
							$row_stat = 0;
						endif;
						
					endwhile;
					
					if( $row_stat != 0 && $slide_opt != 'on' ){
						$output .= '</div><!-- .row -->'; // Unexpected row close
					}
					
					//Team Slide End
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .owl-carousel -->';

			$output .= '</div><!-- .team-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}

function zoacres_team_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "name":
			$output .= '<div class="team-name">';
				$output .= '<p><a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. esc_html( get_the_title() ) .'</a></p>';
			$output .= '</div><!-- .team-name -->';		
		break;
		
		case "designation":
			$designation = get_post_meta( $opts['post_id'], 'zoacres_team_designation', true );
			if( $designation ) :
				
				$output .= '<div class="team-designation">';
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				$output .= '</div><!-- .team-designation -->';		
			endif;
		break;
		
		case "namedes":
			$output .= '<div class="team-name-designation">';
				$output .= '<p><a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. esc_html( get_the_title() ) .'</a></p>';
				$designation = get_post_meta( $opts['post_id'], 'zoacres_team_designation', true );
				if( $designation ) :
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				endif;
			$output .= '</div><!-- .team-name-designation -->';		
		break;
		
		case "thumb":
			if ( has_post_thumbnail() && isset( $opts['list_stat'] ) && $opts['list_stat'] == true ) {
			
				$thumb_size = 'large';
				if( ( 12 / absint( $opts['cols'] ) ) > 3 ){
					$thumb_size = 'zoacres-team-medium';
				}else{
					$thumb_size = 'large';
				}
				
				$output .= '<div class="team-thumb">';
					$output .= isset( $opts['overlay'] ) ? $opts['overlay'] : '';
					$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid' ) );
				$output .= '</div><!-- .team-thumb -->';
			}
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="team-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .team-excerpt -->';	
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'zoacres' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
		case "social":
			$output .= '<div class="team-social-wrap clearfix">';
				$output .= '<ul class="nav social-icons team-social'. esc_attr( $opts['social_class'] ) .'">';
					$taget = get_post_meta( get_the_ID(), 'zoacres_team_link_target', true );
					$social_media = array( 
						'social-fb' => 'fa fa-facebook', 
						'social-twitter' => 'fa fa-twitter', 
						'social-instagram' => 'fa fa-instagram',
						'social-linkedin' => 'fa fa-linkedin', 
						'social-pinterest' => 'fa fa-pinterest-p', 
						'social-youtube' => 'fa fa-youtube-play', 
						'social-vimeo' => 'fa fa-vimeo',
						'social-flickr' => 'fa fa-flickr', 
						'social-dribbble' => 'fa fa-dribbble'
					);
					$social_opt = array(
						'social-fb' => 'zoacres_team_facebook', 
						'social-twitter' => 'zoacres_team_twitter',
						'social-instagram' => 'zoacres_team_instagram',
						'social-linkedin' => 'zoacres_team_linkedin',
						'social-pinterest' => 'zoacres_team_pinterest',
						'social-youtube' => 'zoacres_team_youtube',
						'social-vimeo' => 'zoacres_team_vimeo',
						'social-flickr' => 'zoacres_team_flickr',
						'social-dribbble' => 'zoacres_team_dribbble',
					);
					// Actived social icons from theme option output generate via loop
					foreach( $social_media as $key => $class ){
						$social_url = get_post_meta( get_the_ID(), $social_opt[$key], true );
						if( $social_url ):
							$output .= '<li>';
								$output .= '<a class="'. esc_attr( $key ) .'" href="'. esc_url( $social_url ) .'" target="'. esc_attr( $taget ) .'">';
									$output .= '<i class="'. esc_attr( $class ) .'"></i>';
								$output .= '</a>';
							$output .= '</li>';
						endif;
					}
				$output .= '</ul>';
			$output .= '</div> <!-- .team-social-wrap -->';
		break;
		
	}
	return $output; 
}

if ( ! function_exists( "zoacres_vc_team_shortcode_map" ) ) {
	function zoacres_vc_team_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Team", "zoacres" ),
				"description"			=> esc_html__( "Team custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_team",
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
						"heading"		=> esc_html__( "Post Per Page", "zoacres" ),
						"description"	=> esc_html__( "Here you can define post limits per page. Example 10", "zoacres" ),
						"param_name"	=> "post_per_page",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Excerpt Length", "zoacres" ),
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
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put the font color.", "zoacres" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Team Layout", "zoacres" ),
						"param_name"	=> "team_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/team/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/team/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/team/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Variation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team variation either dark or light.", "zoacres" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "zoacres" )	=> "light",
							esc_html__( "Dark", "zoacres" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Model", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team model either grid or list.", "zoacres" ),
						"param_name"	=> "team_model",
						"value"			=> array(
							esc_html__( "Grid", "zoacres" )	=> "grid",
							esc_html__( "List", "zoacres" )	=> "list",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Columns", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team columns.", "zoacres" ),
						"param_name"	=> "team_cols",
						"value"			=> array(
							esc_html__( "1 Column", "zoacres" )	=> "12",
							esc_html__( "2 Columns", "zoacres" )	=> "6",
							esc_html__( "3 Columns", "zoacres" )	=> "4",
							esc_html__( "4 Columns", "zoacres" )	=> "3",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Team Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for team custom layout. here you can set your own layout. Drag and drop needed team items to Enabled part.", "zoacres" ),
						'param_name'	=> 'team_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Image', 'zoacres' ),
								'name'	=> esc_html__( 'Name', 'zoacres' ),
								'designation'	=> esc_html__( 'Designation', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' ),
								'social'	=> esc_html__( 'Social Links', 'zoacres' ),
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'namedes'	=> esc_html__( 'Name and Designation', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team text align", "zoacres" ),
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
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider option.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team image layout either normal, rounded, or circled", "zoacres" ),
						"param_name"	=> "img_layout",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "",
							esc_html__( "Rounded", "zoacres" )	=> "rounded",
							esc_html__( "Circle", "zoacres" )	=> "circle",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Team Option", "zoacres" ),
						"description"	=> esc_html__( "This is an option for enable overlay team option.", "zoacres" ),
						"param_name"	=> "team_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "zoacres" )	=> "disable",
							esc_html__( "Enable", "zoacres" )	=> "enable"
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Font Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put team overlay font color.", "zoacres" ),
						"param_name"	=> "team_overlay_font_color",
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Overlay Link Colors", "zoacres" ),
						"description"	=> esc_html__( "Here you can put team overlay link normal, hover colors. Example #ffffff, #cccccc", "zoacres" ),
						"param_name"	=> "team_overlay_link_colors",
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Team Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for team items(name, excerpt etc..) overlay on thumbnail. Drag and drop needed team items to Enabled part.", "zoacres" ),
						'param_name'	=> 'overlay_team_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'name'	=> esc_html__( 'Name', 'zoacres' )
							),
							'disabled' => array(
								'designation'	=> esc_html__( 'Designation', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' ),
								'social'	=> esc_html__( 'Social Links', 'zoacres' ),
								'namedes'	=> esc_html__( 'Name and Designation', 'zoacres' )
							)
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "zoacres" ),
						"description"	=> esc_html__( "This is an option for overlay items position.", "zoacres" ),
						"param_name"	=> "team_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Top Left", "zoacres" )	=> "top-left",
							esc_html__( "Top Right", "zoacres" )	=> "top-right",
							esc_html__( "Bottom Left", "zoacres" )	=> "bottom-left",
							esc_html__( "Bottom Right", "zoacres" )	=> "bottom-right",
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team text align", "zoacres" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Type", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team overlay type.", "zoacres" ),
						"param_name"	=> "team_overlay_type",
						"value"			=> array(
							esc_html__( "None", "zoacres" ) => "none",
							esc_html__( "Overlay Dark", "zoacres" ) => "dark",
							esc_html__( "Overlay White", "zoacres" ) => "light",
							esc_html__( "Custom Color", "zoacres" ) => "custom"
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Custom Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can put team overlay custom color.", "zoacres" ),
						"param_name"	=> "team_overlay_custom_color",
						'dependency' => array(
							'element' => 'team_overlay_type',
							'value' => 'custom',
						),
						"group"			=> esc_html__( "Overlay", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Style", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team social icons style.", "zoacres" ),
						"param_name"	=> "social_style",
						"value"			=> array(
							esc_html__( "Circled", "zoacres" )	=> "circled",
							esc_html__( "Square", "zoacres" )	=> "squared",
							esc_html__( "Rounded", "zoacres" )	=> "rounded",
							esc_html__( "Transparent", "zoacres" )		=> "transparent"
						),
						"group"			=> esc_html__( "Social", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Color", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team social icons color.", "zoacres" ),
						"param_name"	=> "social_color",
						"value"			=> array(
							esc_html__( "Black", "zoacres" )		=> "black",
							esc_html__( "White", "zoacres" )		=> "white",
							esc_html__( "Own Color", "zoacres" )	=> "own"
						),
						"group"			=> esc_html__( "Social", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Hover Color", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team social icons hover color.", "zoacres" ),
						"param_name"	=> "social_hcolor",
						"value"			=> array(
							esc_html__( "White", "zoacres" )		=> "h-white",
							esc_html__( "Black", "zoacres" )		=> "h-black",
							esc_html__( "Own Color", "zoacres" )	=> "h-own"
						),
						"group"			=> esc_html__( "Social", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team social icons background.", "zoacres" ),
						"param_name"	=> "social_bg",
						"value"			=> array(
							esc_html__( "White", "zoacres" )		=> "bg-white",
							esc_html__( "Black", "zoacres" )		=> "bg-black",
							esc_html__( "RGBA Light", "zoacres" )=> "bg-light",
							esc_html__( "RGBA Dark", "zoacres" )	=> "bg-dark",
							esc_html__( "Own Color", "zoacres" )	=> "bg-own"
						),
						"group"			=> esc_html__( "Social", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Hover Background Color", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team social icons hover background.", "zoacres" ),
						"param_name"	=> "social_hbg",
						"value"			=> array(
							esc_html__( "Own Color", "zoacres" )	=> "hbg-own",
							esc_html__( "Black", "zoacres" )		=> "hbg-black",
							esc_html__( "White", "zoacres" )		=> "hbg-white",
							esc_html__( "RGBA Light", "zoacres" )=> "hbg-light",
							esc_html__( "RGBA Dark", "zoacres" )	=> "hbg-dark",
							esc_html__( "Transparent", "zoacres" )	=> "hbg-trans"						
						),
						"group"			=> esc_html__( "Social", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for team slider scroll by.", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_team_shortcode_map" );
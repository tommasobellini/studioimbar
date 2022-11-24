<?php 
/**
 * Zoacres Testimonial
 */

if ( ! function_exists( "zoacres_vc_testimonial_shortcode" ) ) {
	function zoacres_vc_testimonial_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_testimonial", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$class_names .= isset( $testimonial_layout ) ? ' testimonial-' . $testimonial_layout : ' testimonial-1';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' testimonial-' . $variation : '';
		$cols = isset( $testi_cols ) ? $testi_cols : 1;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.testimonial-wrapper, .' . esc_attr( $rand_class ) . '.testimonial-wrapper.testimonial-dark .testimonial-inner { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;

			$space_class_name = '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-inner >';
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
			'post_type' => 'zoacres-testimonial',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
			
			$output .= '<div class="testimonial-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$output .= '<div class="row">';
				
					//Testimonial Slide
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
					
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
					
						//Testimonial Slide Item
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="item">';	
					
					
						$col_class = "col-lg-". absint( $cols );
						$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
						$output .= '<div class="'. esc_attr( $col_class ) .'">';
							$output .= '<div class="testimonial-inner rounded">';
							
							$post_id = get_the_ID();
							
							$testimoanil_array = array(
								'post_id' => $post_id,
								'excerpt_length' => $excerpt_length,
								'more_text' => $more_text
							);

							$elemetns = isset( $testimonial_items ) ? zoacres_drag_and_drop_trim( $testimonial_items ) : array( 'Enabled' => '' );

							if( isset( $elemetns['Enabled'] ) ) :
								foreach( $elemetns['Enabled'] as $element => $value ){
									$output .= zoacres_testimonial_shortcode_elements( $element, $testimoanil_array );
								}
							endif;
							
							$output .= '</div><!-- .testimonial-inner -->';
						$output .= '</div><!-- .cols -->';
						
						//Testimonial Slide Item End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .item -->';	
						
					endwhile;
					
					//Testimonial Slide End
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .owl-carousel -->';
					
				$output .= '</div><!-- .row -->';
			$output .= '</div><!-- .testimonial-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}

function zoacres_testimonial_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "name":
			$output .= '<div class="testimonial-name">';
				$output .= '<p><a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. esc_html( get_the_title() ) .'</a></p>';
			$output .= '</div><!-- .testimonial-name -->';		
		break;
		
		case "designation":
			$designation = get_post_meta( $opts['post_id'], 'zoacres_testimonial_designation', true );
			if( $designation ) :
				
				$output .= '<div class="testimonial-designation">';
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				$output .= '</div><!-- .testimonial-designation -->';		
			endif;
		break;
		
		case "info":
			$output .= '<div class="testimonial-info">';
				$output .= '<p>';
					$output .= '<a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. esc_html( get_the_title() ) .'</a>';
					
					$designation = get_post_meta( $opts['post_id'], 'zoacres_testimonial_designation', true );
					if( $designation ) :
						$output .= '<span class="client-designation">'. esc_html( $designation ) .'</span>';
					endif;
					
					$company_url = get_post_meta( $opts['post_id'], 'zoacres_testimonial_company_url', true );
					if( $company_url ) :
						$output .= '<a href="'. esc_url( $company_url ) .'" class="company-url">'. esc_url( $company_url ) .'</a>';
					endif;
				$output .= '</p>';
			$output .= '</div><!-- .testimonial-info -->';		
		break;
		
		case "thumb":
			if ( has_post_thumbnail() ) {
				$output .= '<div class="testimonial-thumb">';
					$output .= get_the_post_thumbnail( $opts['post_id'], 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) );
				$output .= '</div><!-- .testimonial-thumb -->';
			}
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="testimonial-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .testimonial-excerpt -->';	
		break;
		
		case "rate":
			$rate = get_post_meta( $opts['post_id'], 'zoacres_testimonial_rating', true );
			if( $rate ) :
				$output .= '<div class="testimonial-rating">';
					$output .= function_exists('zoacres_star_rating') ? '<p>'. zoacres_star_rating( $rate ) .'</p>' : '';
				$output .= '</div><!-- .testimonial-rating -->';
			endif;	
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'zoacres' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
	}
	return $output; 
}

if ( ! function_exists( "zoacres_vc_testimonial_shortcode_map" ) ) {
	function zoacres_vc_testimonial_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Testimonial", "zoacres" ),
				"description"			=> esc_html__( "Testimonial custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_testimonial",
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
						"heading"		=> esc_html__( "Testimonial Layout", "zoacres" ),
						"param_name"	=> "testimonial_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/testimonial/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/testimonial/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/testimonial/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Variation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial variation either dark or light.", "zoacres" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "zoacres" )	=> "light",
							esc_html__( "Dark", "zoacres" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Columns", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial columns.", "zoacres" ),
						"param_name"	=> "testi_cols",
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
						'heading'		=> esc_html__( 'Drag and Drop', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for testimonial custom layout. here you can set your own layout. Drag and drop needed testimonial items to Enabled part.", "zoacres" ),
						'param_name'	=> 'testimonial_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'name'	=> esc_html__( 'Name', 'zoacres' ),
								'designation'	=> esc_html__( 'Designation', 'zoacres' ),
								'thumb'	=> esc_html__( 'Image', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' ),
								'rate'	=> esc_html__( 'Star Rating', 'zoacres' ),
								'info'	=> esc_html__( 'Client Info', 'zoacres' ),
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial text align", "zoacres" ),
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
						"description"	=> esc_html__( "This is an option for testimonial slider option.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for testimonial slider scroll by.", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_testimonial_shortcode_map" );
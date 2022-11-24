<?php 
/**
 * Zoacres Portfolio
 */

if ( ! function_exists( "zoacres_vc_portfolio_shortcode" ) ) {
	function zoacres_vc_portfolio_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_portfolio", $atts );
		extract( $atts );

		$output = '';

		//Variable define
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $article_align ) && $article_align != 'default' ? ' text-' . $article_align : '';
		$cols = isset( $grid_cols ) && $grid_cols != '' ? $grid_cols : 2;
		$gutter = isset( $grid_gutter ) && $grid_gutter != '' ? $grid_gutter : 20;		
		$layout = isset( $portfolio_layout ) && $portfolio_layout != '' ? $portfolio_layout : 2; 
		$infinite = isset( $infinite ) && $infinite == 'on' ? "true" : "false";
		$thumb_size = $image_alt = $cropped_img = '';
		
		$portfolio_items = isset( $portfolio_items ) ? zoacres_drag_and_drop_trim( $portfolio_items ) : array( 'Enabled' => '' );
		
		$overlay_items = $overlay_class = '';		
		if( isset( $portfolio_overlay_opt ) && $portfolio_overlay_opt == 'enable' ){
			$overlay_items = isset( $overlay_portfolio_items ) ? zoacres_drag_and_drop_trim( $overlay_portfolio_items ) : array( 'Enabled' => '' );
			$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
			$overlay_class .= isset( $portfolio_overlay_position ) ? ' overlay-'.$portfolio_overlay_position : ' overlay-center';
		}
		
		$thumb_class = $overlay_items ? ' portfolio-overlay-wrap' : '';
		
		$filter_opt = isset( $filter_opt ) ? $filter_opt : '';
		$zoom_icon_opt = isset( $zoom_icon_opt ) ? $zoom_icon_opt : '';
		$link_icon_opt = isset( $link_icon_opt ) ? $link_icon_opt : '';
		$excerpt_length = isset( $excerpt_length ) ? $excerpt_length : 10;

		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $link_color ) && $link_color != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap a { color: '. esc_attr( $link_color ) .'; }' : '';
		$shortcode_css .= isset( $link_hcolor ) && $link_hcolor != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap a:hover { color: '. esc_attr( $link_hcolor ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;

			$space_class_name = '.' . esc_attr( $rand_class ) . '.portfolio-wrapper .portfolio-content-wrap >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}

		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
		
		//Query Start
		global $wp_query;
		$paged = 1;
		if( get_query_var('paged') ){
			$paged = esc_attr( get_query_var('paged') );
		}elseif( get_query_var('page') ){
			$paged = esc_attr( get_query_var('page') );
		}
		
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			
			$class_names .= isset( $article_style ) ? ' portfolio-' . $article_style : '';
						
			$gal_atts = array(
				'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' ? 1 : 0 ) .'"',
				'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' ? absint( $slide_margin ) : 0 ) .'"',
				'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' ? 1 : 0 ) .'"',
				'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
				'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' ? 1 : 0 ) .'"',
				'data-autoplay="'. ( isset( $slide_item_autoplay ) && $slide_item_autoplay == 'on' ? 1 : 0 ) .'"',
				'data-items="'. ( isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2 ) .'"',
				'data-items-tab="'. ( isset( $slide_item_tab ) && $slide_item_tab != '' ? absint( $slide_item_tab ) : 1 ) .'"',
				'data-items-mob="'. ( isset( $slide_item_mobile ) && $slide_item_mobile != '' ? absint( $slide_item_mobile ) : 1 ) .'"',
				'data-duration="'. ( isset( $slide_duration ) && $slide_duration != '' ? absint( $slide_duration ) : 5000 ) .'"',
				'data-smartspeed="'. ( isset( $slide_smart_speed ) && $slide_smart_speed != '' ? absint( $slide_smart_speed ) : 250 ) .'"',
				'data-scrollby="'. ( isset( $slide_slideby ) && $slide_slideby != '' ? absint( $slide_slideby ) : 1 ) .'"',
				'data-autoheight="false"',
			);
			$data_atts = implode( " ", $gal_atts );
			
			$cols = isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2;
			$slide_img_layout = isset( $slide_img_layout ) ? $slide_img_layout : 'normal';
			$class_names .= $cols == 1 ? ' owl-single-item' : '';
			
			if( $slide_img_layout == 'normal' ){
				if( $cols == 2 ){
					$thumb_size = 'medium';
				}elseif( $cols == 3 ){
					$thumb_size = 'zoacres-grid-large';
				}elseif( $cols >= 4 ){
					$thumb_size = 'zoacres-grid-medium';
				}else{
					$thumb_size = array( 1200, '640' );
				}
			}else{
				if( $cols <= 1 ){
					$thumb_size = array( 1200, '640' );
				}elseif( $cols <= 2 ){
					$thumb_size = array( 600, '980' );
				}elseif( $cols <= 3 ){
					$thumb_size = array( 400, '653' );
				}else{
					$thumb_size = array( 300, '490' );
				}
			}
			
			//Cats In
			$cats_in = array();
			if( isset( $include_cats ) && $include_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $include_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );	
						//post in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			
			//Cats Not In
			$cats_not_in = array();
			if( isset( $exclude_cats ) && $exclude_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $exclude_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );
						//post not in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_not_in, absint( $cat_term->term_id ) );	
					}
				}
			}

			$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
			$inc_cat_array = $cats_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_in ) : '';
			$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';

			$args = array(
				'post_type' => 'zoacres-portfolio',
				'posts_per_page' => absint( $ppp ),
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					$inc_cat_array,
					$exc_cat_array
				)
				
			);
			$query = new WP_Query( $args );
			
			$event = isset( $image_event ) ? $image_event : 'popup';
			$thumb_array = array(
				'thumb_size'	=> $thumb_size,
				'layout'		=> $layout,
				'event'			=> $event
			);
				
			$portfolio_array = array(
				'excerpt_length'=> $excerpt_length,
				'zoom_icon_opt' => $zoom_icon_opt,
				'link_icon_opt' => $link_icon_opt
			);
			
			if ( $query->have_posts() ) {
				
				$output .= '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					$output .= '<div class="owl-carousel portfolio-slide image-gallery" '. ( $data_atts ) .'>';
						while ( $query->have_posts() ) : $query->the_post();
							
							$post_id = get_the_ID();
							$thumb_array['post_id'] = $post_id;
							$portfolio_array['post_id'] = $post_id;
						
							$output .= '<div class="item">';
								$output .= '<div class="portfolio-wrap">';

									// Thumb
									$output .= '<div class="portfolio-img'. esc_attr( $thumb_class ) .'">';
										if( $overlay_items ){
											$output .= '<div class="portfolio-overlay'. esc_attr( $overlay_class ) .'">';
												if( isset( $overlay_items['Enabled'] ) ) :
													foreach( $overlay_items['Enabled'] as $element => $value ){
														$output .= zoacres_portfolio_shortcode_elements( $element, $portfolio_array );
													}
												endif;
											$output .= '</div><!-- .portfolio-overlay -->';
										}
										$output .= zoacres_portfolio_shortcode_elements( 'thumb', $thumb_array );
									$output .= '</div>';
									
									if( isset( $portfolio_items['Enabled'] ) && !empty( $portfolio_items['Enabled'] ) ) :
										$output .= '<div class="portfolio-content-wrap">';
											foreach( $portfolio_items['Enabled'] as $element => $value ){
												$output .= zoacres_portfolio_shortcode_elements( $element, $portfolio_array );
											}
										$output .= '</div><!-- .portfolio-content-wrap -->';	
									endif;
											
								
								$output .= '</div><!-- .portfolio-wrap -->';
							$output .= '</div><!-- .item -->';
						endwhile;
					$output .= '</div><!-- .owl-carousel -->';
				$output .= '</div><!-- .portfolio-wrapper -->';
				
			}
			wp_reset_postdata();
			//Query End
			
			
			//if slide end
			
		}else{

			if( $layout == 1 ){
				if( $cols == 2 ){
					$thumb_size = 'medium';
				}elseif( $cols == 3 ){
					$thumb_size = 'zoacres-grid-large';					
				}elseif( $cols >= 4 ){
					$thumb_size = 'zoacres-grid-medium';
				}else{
					$thumb_size = 'large';
				}
			}elseif( $layout == 2 || $layout == 3 ){
				if( $cols <= 1 ){
					$crop_width = 1200;
				}elseif( $cols <= 2 ){
					$crop_width = 600;
				}else{
					$crop_width = 400;
				}
				$thumb_size = array( $crop_width, '9999' );
			}else{
				$thumb_size = 'zoacres-grid-medium';
			}
			
			//IF Filter Enable
			$filter_stat = 0;
			$filter_first_cat = '';
			$cats_in = array();
			if( isset( $include_cats ) && $include_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $include_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				if( $filter ):
					$filter_model = isset( $filter_layout ) ? $filter_layout : '1';
					
					$filter_ul_class = isset( $filter_align ) && $filter_align != 'default' ? ' text-' . $filter_align : '';
					
					$filter_all = isset( $filter_all ) && $filter_all != '' ? $filter_all : '';
					if( $filter_all ){
						$filter_stat = 1;
					}
					
					$output .= '<div class="portfolio-filter filter-'. esc_attr( $filter_model ) .'">';
						$output .= '<ul class="nav m-auto d-block'. esc_attr( $filter_ul_class ) .'">';
							
							$output .= $filter_all != '' ? '<li class="active"><a href="#" class="portfolio-filter-item">'. esc_html( $filter_all ) .'</a></li>' : '';
							$c = 1; // Checksum for first category
							foreach( $filter as $cat ){
								if( term_exists( $cat, 'portfolio-categories' ) ){
								
									$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );
									$term_id = isset( $cat_term->term_id ) ? $cat_term->term_id : '';
									$term_name = isset( $cat_term->name ) ? $cat_term->name : '';
									if( $term_id ){
										array_push( $cats_in, absint( $cat_term->term_id ) );
										$output .= '<li><a href="#" class="portfolio-filter-item" data-filter=".'. esc_attr( $cat ) .'">'. esc_html( $cat_term->name ) .'</a></li>';
										if( $c && $filter_all == '' ){
											$filter_first_cat = $cat;
											$c = 0;
										}
										
									}
								}
							}
						$output .= '</ul>';
					$output .= '</div><!-- .portfolio-filter -->';
				endif;
			}
			
			$output = isset( $filter_opt ) && $filter_opt == 'on' ? '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">' . $output : '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			//Cats Not In
			$cats_not_in = array();
			if( isset( $exclude_cats ) && $exclude_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $exclude_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );	
						//post not in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_not_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			
			$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
			
			$inc_cat_array = $cats_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_in ) : '';
			$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';

			$args = array(
				'post_type' => 'zoacres-portfolio',
				'posts_per_page' => absint( $ppp ),
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					$inc_cat_array,
					$exc_cat_array
				)
				
			);
			$query = new WP_Query( $args );
	
			if ( $query->have_posts() ) {
				
				$chk = $isotope_stat = 1;
				$post_id = '';
				
				$layout_mode = $layout != 3 && $layout != 4 ? 'fitRows' : 'masonry';
				
				$portfolio_class = '';
				$portfolio_class .= $layout != 4 ? 'grid-layout' : '';
				$portfolio_class .= isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
				
				if( $layout == '2' ){
					$portfolio_class .= ' portfolio-fitrow-layout';
				}elseif( $layout == '3' ){
					$portfolio_class .= ' portfolio-masonry-layout';
				}else{
					$portfolio_class .= ' portfolio-grid-layout';
				}
				
				
				$output .= '<div class="image-gallery '. esc_attr( $portfolio_class ) .'" style="margin-bottom: -'. esc_attr( $gutter ) .'px;" data-filter-stat="'. esc_attr( $filter_stat ) .'" data-first-cat="'. esc_attr( $filter_first_cat ) .'">';
					$output .= '<div class="isotope" data-cols="'. esc_attr( $cols ) .'" data-gutter="'. esc_attr( $gutter ) .'" data-layout="'. esc_attr( $layout_mode ) .'" data-infinite="'. esc_attr( $infinite ) .'">';
					
				$event = isset( $image_event ) ? $image_event : 'popup';
				$thumb_array = array(
					'thumb_size'	=> $thumb_size,
					'layout'		=> $layout,
					'event'			=> $event
				);

				$portfolio_array = array(
					'excerpt_length'=> $excerpt_length,
					'zoom_icon_opt' => $zoom_icon_opt,
					'link_icon_opt' => $link_icon_opt
				);
	
				// Start the Loop
				while ( $query->have_posts() ) : $query->the_post();
					
					$post_id = get_the_ID();
					$thumb_array['post_id'] = $post_id;
					$portfolio_array['post_id'] = $post_id;
					
					$inner_class = 'vc-portfolio';
					
					$inner_class .= isset( $article_style ) ? ' portfolio-' . $article_style : '';
					
					//Filter Class Arrange
					if( isset( $include_cats ) && $include_cats != '' ){
						$cat_class = '';
						$terms = get_the_terms( $post_id, 'portfolio-categories' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							foreach ( $terms as $term ) {
								$cat_class .= ' ' . $term->slug;
							}
							$inner_class .= $cat_class;
						endif;
					}
					
					$output .= '<article id="post-'. esc_attr( $post_id ) .'" class="'. esc_attr( $inner_class ) .'">';
						$output .= '<div class="portfolio-wrap">';
							
							// Thumb
							$output .= '<div class="portfolio-img'. esc_attr( $thumb_class ) .'">';
								if( $overlay_items ){
									$output .= '<div class="portfolio-overlay'. esc_attr( $overlay_class ) .'">';
										if( isset( $overlay_items['Enabled'] ) ) :
											foreach( $overlay_items['Enabled'] as $element => $value ){
												$output .= zoacres_portfolio_shortcode_elements( $element, $portfolio_array );
											}
										endif;
									$output .= '</div><!-- .portfolio-overlay -->';
								}
								$output .= zoacres_portfolio_shortcode_elements( 'thumb', $thumb_array );
							$output .= '</div>';
							
							if( isset( $portfolio_items['Enabled'] ) && !empty( $portfolio_items['Enabled'] ) ) :
								$output .= '<div class="portfolio-content-wrap">';
									foreach( $portfolio_items['Enabled'] as $element => $value ){
										$output .= zoacres_portfolio_shortcode_elements( $element, $portfolio_array );
									}
								$output .= '</div><!-- .portfolio-content-wrap -->';
							endif;
								
							
							
						$output .= '</div><!-- .portfolio-wrap -->';
					$output .= '</article>';
					
					$chk++;
					
				endwhile;
	
					$output .= '</div><!-- .isotope -->';
				$output .= '</div><!-- .grid-layout -->';
					 
			} // end of check for query having posts
			
			$output .= '</div><!-- portfolio-wrapper -->';
			
			if( $infinite == "true" ){
				$output .= '<div class="infinite-load">';
					$aps = new ZoacresPostSettings;
					$output .= $aps->zoacresWpBootstrapPagination( $args, $query->max_num_pages, false );
				$output .= '</div><!-- infinite-load -->';
			}elseif( isset( $pagination ) && $pagination == 'on' ){
				$aps = new ZoacresPostSettings;
				$output .= $aps->zoacresWpBootstrapPagination( $args, $query->max_num_pages, false );
			}
			// use reset postdata to restore orginal query
			wp_reset_postdata();
		} // if slide not elable

		return $output;
	}
}

function zoacres_portfolio_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
		case "title":
			$output .= '<div class="portfolio-title">';
				$output .= '<h3><a href="'. esc_url( get_the_permalink() ) .'">'. esc_html( get_the_title() ) .'</a></h3>';
			$output .= '</div><!-- .portfolio-title -->';
		break;
		
		case "thumb":
			if ( has_post_thumbnail() ) {
				$output .= $opts['event'] == 'popup' ? '<a href="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) .'" class="image-gallery-link">' : '<a href="'. esc_url( get_the_permalink() ) .'">';
					if( isset( $opts['thumb_size'] ) && is_array( $opts['thumb_size'] ) ){
						$hard_crop = $opts['thumb_size'][1] == 9999 ? false : true;
						$cropped_img = aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $opts['thumb_size'][0], $opts['thumb_size'][1], $hard_crop, false );
						if( $cropped_img ){
							$image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
							$image_alt = $image_alt != '' ? $image_alt : get_the_title();
							$output .= '<img class="img-fluid cpt-img" src="'. esc_url( $cropped_img[0] ) .'" width="'. esc_attr( $cropped_img[1] ) .'" height="'. esc_attr( $cropped_img[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />';
						}else{
							$output .= get_the_post_thumbnail( $opts['post_id'], $opts['thumb_size'], array( 'class' => 'img-fluid' ) );
						}
					}else{	
						$output .= get_the_post_thumbnail( $opts['post_id'], $opts['thumb_size'], array( 'class' => 'img-fluid' ) );
					}
				$output .= '</a>';
			}
		break;
		
		case "category":
			$terms = get_the_terms( $opts['post_id'], 'portfolio-categories' );
			if ( $terms && ! is_wp_error( $terms ) ) : 
				$cat_links = array();
				foreach ( $terms as $term ) {
					$cat_links[] = '<span>' . $term->name . '</span>';
				}
				$cats = join( ",", $cat_links );
				$output .= '<div class="portfolio-categories">' . $cats . '</div>';
			endif;
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="portfolio-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .portfolio-excerpt -->';
		break;
		
		case "icons":
			$output .= '<div class="portfolio-icons">';
				$output .= '<p>';
					if( isset( $opts['zoom_icon_opt'] ) && $opts['zoom_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) .'" class="image-gallery-link zoom-icon"><i class="icon-magnifier-add"></i></a>';
					}
					if( isset( $opts['link_icon_opt'] ) && $opts['link_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( get_the_permalink() ) .'" class="link-icon"><i class="icon-link"></i></a>';
					}
				$output .= '</p>';
			$output .= '</div><!-- .portfolio-icons -->';		
		break;
	}
	return $output; 
}

if ( ! function_exists( "zoacres_vc_portfolio_shortcode_map" ) ) {
	function zoacres_vc_portfolio_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Portfolio", "zoacres" ),
				"description"			=> esc_html__( "Portfolio custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_portfolio",
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
						"heading"		=> esc_html__( "Include Categories", "zoacres" ),
						"description"	=> esc_html__( "This is filter categories. If you don't want portfolio filter, then leave this empty. Example slug: travel, web", "zoacres" ),
						"param_name"	=> "include_cats",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Exclude Categories", "zoacres" ),
						"description"	=> esc_html__( "Here you can mention unwanted categories. Example slug: travel, web", "zoacres" ),
						"param_name"	=> "exclude_cats",
						"value" 		=> "",
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is option for pagination show or hide.", "zoacres" ),
						"param_name"	=> "pagination",
						"value"			=> "off"
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Infinite Load", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio infinite load.", "zoacres" ),
						"param_name"	=> "infinite",
						"value"			=> "off"
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Portfolio Layout", "zoacres" ),
						"description"	=> esc_html__( "Choose portfolio layout normal grid( images or must be equal size ), fit row grid, masonry or list.", "zoacres" ),
						"param_name"	=> "portfolio_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/portfolio-layouts/grid.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/portfolio-layouts/fitrow.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/portfolio-layouts/masonry.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Choose Filter Layout", "zoacres" ),
						"param_name"	=> "filter_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/1.jpg",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/2.jpg",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/3.jpg"
						),
						"default"		=> "2",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Filter Align", "zoacres" ),
						"param_name"	=> "filter_align",
						"description"	=> esc_html__( "This is option for filter alignment style.", "zoacres" ),
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
						"heading"		=> esc_html__( "Grid Columns", "zoacres" ),
						"description"	=> esc_html__( "How many grid columns to show. Example 3", "zoacres" ),
						"param_name"	=> "grid_cols",
						"value"			=> array(
							esc_html__( "2 Columns", "zoacres" )	=> "2",
							esc_html__( "3 Columns", "zoacres" )	=> "3",
							esc_html__( "4 Columns", "zoacres" )	=> "4"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Gutter Size", "zoacres" ),
						"description"	=> esc_html__( "This is setting for grid column inter spacing. Example 20", "zoacres" ),
						"param_name"	=> "grid_gutter",
						"value" 		=> "20",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Filter All", "zoacres" ),
						"description"	=> esc_html__( "If need filter all tab, just fill the text box needed text to show instead of All text. If you leave this box blank, then all tab will disappear.", "zoacres" ),
						"param_name"	=> "filter_all",
						"value" 		=> "All",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Article Align", "zoacres" ),
						"param_name"	=> "article_align",
						"description"	=> esc_html__( "This is option for article alignment style.", "zoacres" ),
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Article Style", "zoacres" ),
						"param_name"	=> "article_style",
						"description"	=> esc_html__( "This is option for article style. Different article template.", "zoacres" ),
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Classic", "zoacres" )	=> "classic",
							esc_html__( "Creative", "zoacres" )	=> "creative",
							esc_html__( "Minimal", "zoacres" )	=> "minimal",
							esc_html__( "Angle", "zoacres" )	=> "angle"						
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image Click Event", "zoacres" ),
						"param_name"	=> "image_event",
						"description"	=> esc_html__( "This is option for pop up image or redirect to sigle portfolio.", "zoacres" ),
						"value"			=> array(
							esc_html__( "Pop Up", "zoacres" )	=> "popup",
							esc_html__( "Single Portfolio", "zoacres" )	=> "single"				
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Filter Hide/Show", "zoacres" ),
						"description"	=> esc_html__( "This is option for show or hide filter.", "zoacres" ),
						"param_name"	=> "filter_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Zoom Icon", "zoacres" ),
						"description"	=> esc_html__( "This is option for show or hide zoom icon to your choosed layout.", "zoacres" ),
						"param_name"	=> "zoom_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "External Link Icon", "zoacres" ),
						"description"	=> esc_html__( "This is option for show or hide zoom icon to your choosed layout.", "zoacres" ),
						"param_name"	=> "link_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Portfolio Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for portfolio custom layout. here you can set your own layout. Drag and drop needed portfolio items to Enabled part.", "zoacres" ),
						'param_name'	=> 'portfolio_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'category'	=> esc_html__( 'Category', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' )
							),
							'disabled' => array(
								'icons'	=> esc_html__( 'Icons', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Portfolio Option", "zoacres" ),
						"description"	=> esc_html__( "This is option for enable overlay portfolio option.", "zoacres" ),
						"param_name"	=> "portfolio_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "zoacres" )	=> "disable",
							esc_html__( "Enable", "zoacres" )	=> "enable"
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "zoacres" ),
						"description"	=> esc_html__( "This is option for overlay items position.", "zoacres" ),
						"param_name"	=> "portfolio_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Top Left", "zoacres" )	=> "top-left",
							esc_html__( "Top Right", "zoacres" )	=> "top-right",
							esc_html__( "Bottom Left", "zoacres" )	=> "bottom-left",
							esc_html__( "Bottom Right", "zoacres" )	=> "bottom-right",
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio text align", "zoacres" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "zoacres" )	=> "default",
							esc_html__( "Left", "zoacres" )		=> "left",
							esc_html__( "Center", "zoacres" )	=> "center",
							esc_html__( "Right", "zoacres" )		=> "right"
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Portfolio Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for portfolio custom layout. here you can set your own layout. Drag and drop needed portfolio items to Enabled part.", "zoacres" ),
						'param_name'	=> 'overlay_portfolio_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'category'	=> esc_html__( 'Category', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' )
							),
							'disabled' => array(
								'icons'	=> esc_html__( 'Icons', 'zoacres' )
							)
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose font color.", "zoacres" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Color Settings", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Link Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose link color.", "zoacres" ),
						"param_name"	=> "link_color",
						"group"			=> esc_html__( "Color Settings", "zoacres" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Link Hover Color", "zoacres" ),
						"description"	=> esc_html__( "Here you can choose link hover color.", "zoacres" ),
						"param_name"	=> "link_hcolor",
						"group"			=> esc_html__( "Color Settings", "zoacres" )
					), 
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Slide Image Layout", "zoacres" ),
						"param_name"	=> "slide_img_layout",
						"description"	=> esc_html__( "This is option for slide image layout either vertical or noraml.", "zoacres" ),
						"value"			=> array(
							esc_html__( "Normal", "zoacres" )	=> "normal",
							esc_html__( "Vertical", "zoacres" )	=> "vertical"
						),
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider option.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider margin space. Example 10", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider duration. Example 5000", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider smart speed. Example 500", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is option for portfolio slider scroll by. Example 500", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_portfolio_shortcode_map" );
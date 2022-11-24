<?php 
/**
 * Zoacres Blog
 */

if ( ! function_exists( "zoacres_vc_blog_shortcode" ) ) {
	function zoacres_vc_blog_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "zoacres_vc_blog", $atts );
		extract( $atts );

		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		$blog_pagination = isset( $blog_pagination ) && $blog_pagination == 'on' ? 'true' : 'false';
		$blog_masonry = isset( $blog_masonry ) && $blog_masonry != '' ? $blog_masonry : 'normal';
		$blog_infinite = isset( $blog_infinite ) && $blog_infinite == 'on' ? 'true' : 'false';
		$blog_gutter = isset( $blog_gutter ) && $blog_gutter != '' ? $blog_gutter : 20;
		
		$thumb_size = isset( $image_size ) ? $image_size : '';
		$cus_thumb_size = '';
		if( $thumb_size == 'custom' ){
			$cus_thumb_size = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '';
		}
		
		$top_meta = isset( $top_meta ) && $top_meta != '' ? $top_meta : array( 'Enabled' => '' );
		$bottom_meta = isset( $bottom_meta ) && $bottom_meta != '' ? $bottom_meta : array( 'Enabled' => '' );
		
		$class_names .= isset( $blog_layout ) ? ' blog-style-' . $blog_layout : ' blog-style-1';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' blog-' . $variation : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. zoacres_shortcode_rand_id();
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;

			$space_class_name = '.' . esc_attr( $rand_class ) . '.blog-wrapper .blog-inner >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$cols = isset( $blog_cols ) ? $blog_cols : 12;
		
		$list_layout = isset( $blog_layout ) && $blog_layout == 4 ? 1 : 0;

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
		
		//Cats In
		$cats_in = array();
		if( isset( $include_cats ) && $include_cats != '' ){
			$filter = preg_replace( '/\s+/', '', $include_cats );
			$filter = explode( ',', rtrim( $filter, ',' ) );
			foreach( $filter as $cat ){
				if( term_exists( $cat, 'category' ) ){
					$cat_term = get_term_by( 'slug', $cat, 'category' );	
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
				if( term_exists( $cat, 'category' ) ){
					$cat_term = get_term_by( 'slug', $cat, 'category' );	
					//post not in array push
					if( isset( $cat_term->term_id ) )
						array_push( $cats_not_in, absint( $cat_term->term_id ) );	
				}
			}
		}
		
		//Query Start
		global $wp_query;
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
		$inc_cat_array = $cats_in ? array( 'taxonomy' => 'category', 'field' => 'id', 'terms' => $cats_in ) : '';
		$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'category', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';

		$args = array(
			'post_type' => 'post',
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
		
			//Shortcode css ccde here
			$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.blog-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
			
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' zoacres-inline-css';
			
			$output .= '<div class="blog-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				
				if( $blog_masonry == 'normal' ): 
				
					$row_stat = 0;
					//Blog Slide
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
					
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
					
						if( $row_stat == 0 && $slide_opt != 'on' ) :
							$output .= '<div class="row">';
						endif;
					
						//Blog Slide Item
						if( isset( $slide_opt ) && $slide_opt == 'on' ){ $output .= '<div class="item">'; };	
						
						$col_class = "col-lg-". absint( $cols );
						$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
						$output .= '<div class="'. esc_attr( $col_class ) .'">';
							$output .= '<div class="blog-inner">';
							
							$post_id = get_the_ID();
							$blog_array = array(
								'post_id' => $post_id,
								'excerpt_length' => $excerpt_length,
								'cols' => $cols,
								'thumb_size' => $thumb_size,
								'cus_thumb_size' => $cus_thumb_size,
								'more_text' => $more_text,
								'top_meta' => $top_meta,
								'bottom_meta' => $bottom_meta,
								'list_layout' => 0,
								'list_stat' => $list_layout // set list layout default 0
							);
							
							if( $list_layout ){
								$output .= '<div class="media">';
									$output .= zoacres_blog_shortcode_elements('thumb', $blog_array);
									$output .= '<div class="media-body">';
							}
							
							$elemetns = isset( $blog_items ) ? zoacres_drag_and_drop_trim( $blog_items ) : array( 'Enabled' => '' );
							if( isset( $elemetns['Enabled'] ) ) :
								foreach( $elemetns['Enabled'] as $element => $value ){
									if( $list_layout ) $blog_array['list_layout'] = 1; // set list layout 1
									$output .= zoacres_blog_shortcode_elements( $element, $blog_array );
								}
							endif;
							
							if( $list_layout ){
									$output .= '</div><!-- .media -->';
								$output .= '</div><!-- .media-body -->';
							}
							
							$output .= '</div><!-- .blog-inner -->';
						$output .= '</div><!-- .cols -->';
						
						//Blog Slide Item End
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
					
					//Blog Slide End
					if( isset( $slide_opt ) && $slide_opt == 'on' ){ $output .= '</div><!-- .owl-carousel -->'; };
					
					if( $slide_opt != 'on' && $blog_pagination == 'true' ):
						$output .= '<div class="blog-pagination">';
							$aps = new ZoacresPostSettings;
							$output .= $aps->zoacresWpBootstrapPagination( $args, $query->max_num_pages, false );
						$output .= '</div><!-- blog-pagination -->';
					endif;
				
				elseif( $blog_masonry == 'masonry' ): // if $blog_masonry == masonry
					
					$output .= '<div class="grid-layout" data-filter-stat="0">';
						$output .= '<div class="isotope" data-cols="'. esc_attr( 12 / absint( $cols ) ) .'" data-gutter="'. esc_attr( $blog_gutter ) .'" data-layout="masonry" data-infinite="'. esc_attr( $blog_infinite ) .'">';
							
							while ( $query->have_posts() ) : $query->the_post();
								$output .= '<article class="blog-inner">';
									$post_id = get_the_ID();
									$blog_array = array(
										'post_id' => $post_id,
										'excerpt_length' => $excerpt_length,
										'thumb_size' => $thumb_size,
										'cus_thumb_size' => $cus_thumb_size,
										'cols' => $cols,
										'more_text' => $more_text,
										'top_meta' => $top_meta,
										'bottom_meta' => $bottom_meta,
										'list_layout' => 0,
										'list_stat' => $list_layout // set list layout default 0
									);
								
									$elemetns = isset( $blog_items ) ? zoacres_drag_and_drop_trim( $blog_items ) : array( 'Enabled' => '' );
									if( isset( $elemetns['Enabled'] ) ) :
										foreach( $elemetns['Enabled'] as $element => $value ){
											$output .= zoacres_blog_shortcode_elements( $element, $blog_array );
										}
									endif;
								$output .= '</article><!-- .blog-inner -->';
							endwhile;
							
						$output .= '</div><!-- .isotope -->';
					$output .= '</div><!-- .grid-layout -->';

					if( $blog_infinite == 'true' ):
						$output .= '<div class="infinite-load">';
							$aps = new ZoacresPostSettings;
							$output .= $aps->zoacresWpBootstrapPagination( $args, $query->max_num_pages, false );
						$output .= '</div><!-- infinite-load -->';
					endif;
					
				endif; // if $blog_masonry == normal endif;

			$output .= '</div><!-- .blog-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}

function zoacres_blog_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "title":
			$output .= '<div class="entry-title">';
				$output .= '<h5><a href="'. esc_url( get_the_permalink() ) .'" class="post-title">'. esc_html( get_the_title() ) .'</a></h5>';
			$output .= '</div><!-- .entry-title -->';		
		break;
		
		case "thumb":
			if( isset( $opts['list_layout'] ) && $opts['list_layout'] === 0 ){
				if ( has_post_thumbnail() ) {
					
					// Custom Thumb Code
					$thumb_size = $thumb_cond = $opts['thumb_size'];
					$cus_thumb_size = $opts['cus_thumb_size'];
					$custom_opt = $img_prop = '';
					if( $thumb_cond == 'custom' ){
						$custom_opt = $cus_thumb_size != '' ? explode( "x", $cus_thumb_size ) : array();
						$img_prop = zoacres_custom_image_size_chk( $thumb_size, $custom_opt );
						$thumb_size = array( $img_prop[1], $img_prop[2] );
					} 
					// Custom Thumb Code End
										
					$output .= '<div class="post-thumb">';
						if( $thumb_cond == 'custom' ){
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid" alt="'. esc_attr( get_the_title() ) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
						}else{
							$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid' ) );
						}
					$output .= '</div><!-- .post-thumb -->';
				}
			}
		break;
		
		case "category":
			$categories = get_the_category(); 
			if ( ! empty( $categories ) ){
				$coutput = '<div class="post-category">';
					$coutput .= '<span class="before-icon fa fa-folder-o theme-color"></span>';
					foreach ( $categories as $category ) {
						$coutput .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>,';
					}
					$output .= rtrim( $coutput, ',' );
				$output .= '</div>';
			}
		break;
		
		case "author":
			$output .= '<div class="post-author">';
				$output .= '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) .'">';
					$output .= '<span class="fa fa-user-circle theme-color"></span><span class="author-name">'. get_the_author() .'</span>';
				$output .= '</a>';
			$output .= '</div>';
		break;
		
		case "date":
			$archive_year  = get_the_time('Y');
			$archive_month = get_the_time('m'); 
			$archive_day   = get_the_time('d');
			$output = '<div class="post-date"><a href="'. esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) .'" ><span class="before-icon fa fa-calendar theme-color"></span> '. get_the_time( get_option( 'date_format' ) ) .'</a></div>';
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'zoacres' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
		case "comment":
			$comments_count = wp_count_comments(get_the_ID());
			$output = '<div class="post-comment"><a href="'. esc_url( get_comments_link( get_the_ID() ) ) .'" rel="bookmark" class="comments-count"><i class="fa fa-commenting theme-color"></i> '. esc_html( $comments_count->total_comments ) .'</a></div>';
		break;
		
		case "excerpt":
			$output = '';
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="post-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .post-excerpt -->';	
		break;		
		
		case "top-meta":
			$output = '';
			$top_meta = $opts['top_meta'];
			$elemetns = isset( $top_meta ) ? zoacres_drag_and_drop_trim( $top_meta ) : array( 'Enabled' => '' );
			if( isset( $elemetns['Enabled'] ) ) :
				$output .= '<div class="top-meta clearfix"><ul class="top-meta-list">';
					foreach( $elemetns['Enabled'] as $element => $value ){
						$blog_array = array( 'more_text' => $opts['more_text'] );
						$output .= '<li>'. zoacres_blog_shortcode_elements( $element, $blog_array ) .'</li>';
					}
				$output .= '</ul></div>';
			endif;
		break;
		
		case "bottom-meta":
			$output = '';
			$bottom_meta = $opts['bottom_meta'];
			$elemetns = isset( $bottom_meta ) ? zoacres_drag_and_drop_trim( $bottom_meta ) : array( 'Enabled' => '' );
			if( isset( $elemetns['Enabled'] ) ) :
				$output .= '<div class="bottom-meta clearfix"><ul class="bottom-meta-list">';
					foreach( $elemetns['Enabled'] as $element => $value ){
						$blog_array = array( 'more_text' => $opts['more_text'] );
						$output .= '<li>'. zoacres_blog_shortcode_elements( $element, $blog_array ) .'</li>';
					}
				$output .= '</ul></div>';
			endif;
		break;
	}
	return $output; 
}

if ( ! function_exists( "zoacres_vc_blog_shortcode_map" ) ) {
	function zoacres_vc_blog_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Blog", "zoacres" ),
				"description"			=> esc_html__( "Blog custom post type.", "zoacres" ),
				"base"					=> "zoacres_vc_blog",
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
						"description"	=> esc_html__( "Here you can define post excerpt length. Example 10", "zoacres" ),
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
						"heading"		=> esc_html__( "Blog Layout", "zoacres" ),
						"param_name"	=> "blog_layout",
						"img_lists" => array ( 
							"1"	=> ZOACRES_ADMIN_URL . "/assets/images/blog/1.png",
							"2"	=> ZOACRES_ADMIN_URL . "/assets/images/blog/2.png",
							"3"	=> ZOACRES_ADMIN_URL . "/assets/images/blog/3.png",
							"4"	=> ZOACRES_ADMIN_URL . "/assets/images/blog/4.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Blog Masonry", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog masonry or normal.", "zoacres" ),
						"param_name"	=> "blog_masonry",
						"value"			=> array(
							esc_html__( "Normal", "zoacres" )	=> "normal",
							esc_html__( "Masonry", "zoacres" )	=> "masonry"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Blog Masonry Infinite", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog masonry infinite scroll.", "zoacres" ),
						"param_name"	=> "blog_infinite",
						"value"			=> "off",
						"dependency" => array(
							"element" => "blog_masonry",
							"value"	=> "masonry"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Blog Masonry Gutter", "zoacres" ),
						"description"	=> esc_html__( "Here you can mention blog masonry gutter size. Example 30", "zoacres" ),
						"param_name"	=> "blog_gutter",
						"value" 		=> "20",
						"dependency" => array(
							"element" => "blog_masonry",
							"value"	=> "masonry"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Blog Variation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog variation either dark or light.", "zoacres" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "zoacres" )	=> "light",
							esc_html__( "Dark", "zoacres" )		=> "dark"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Blog Columns", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog columns.", "zoacres" ),
						"param_name"	=> "blog_cols",
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
						'heading'		=> esc_html__( 'Post Items', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for blog custom layout. here you can set your own layout. Drag and drop needed blog items to Enabled part.", "zoacres" ),
						'param_name'	=> 'blog_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Feature Image', 'zoacres' ),
								'title'	=> esc_html__( 'Title', 'zoacres' ),
								'category'	=> esc_html__( 'Category', 'zoacres' ),
								'author'	=> esc_html__( 'Author', 'zoacres' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'zoacres' )
							),
							'disabled' => array(
								'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
								'bottom-meta'	=> esc_html__( 'Bottom Meta', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Post Top Meta', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for blog shortcode post top meta.", "zoacres" ),
						'param_name'	=> 'top_meta',
						'dd_fields' => array ( 
							'Enabled' => array(),
							'disabled' => array(
								'category'	=> esc_html__( 'Category', 'zoacres' ),
								'author'	=> esc_html__( 'Author', 'zoacres' ),
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'date'	=> esc_html__( 'Date', 'zoacres' ),
								'comment'	=> esc_html__( 'Comment', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Post Bottom Meta', 'zoacres' ),
						"description"	=> esc_html__( "This is settings for blog shortcode post bottom meta.", "zoacres" ),
						'param_name'	=> 'bottom_meta',
						'dd_fields' => array ( 
							'Enabled' => array(),
							'disabled' => array(
								'category'	=> esc_html__( 'Category', 'zoacres' ),
								'author'	=> esc_html__( 'Author', 'zoacres' ),
								'more'	=> esc_html__( 'Read More', 'zoacres' ),
								'date'	=> esc_html__( 'Date', 'zoacres' ),
								'comment'	=> esc_html__( 'Comment', 'zoacres' )
							)
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog text align", "zoacres" ),
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
						"heading"		=> esc_html__( "Blog Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog pagination enable or disable. This option will work only, when blog slide option not enabled.", "zoacres" ),
						"param_name"	=> "blog_pagination",
						"value"			=> "off",
						"dependency" => array(
							"element" => "blog_masonry",
							"value"	=> "normal"
						),
						"group"			=> esc_html__( "Layouts", "zoacres" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Image Size", "zoacres" ),
						"param_name"	=> "image_size",
						'description'	=> esc_html__( 'Choose image size for display different size image.', 'zoacres' ),
						"value"			=> array(
							esc_html__( "Grid Large", "zoacres" )=> "zoacres-grid-large",
							esc_html__( "Grid Medium", "zoacres" )=> "zoacres-grid-medium",
							esc_html__( "Grid Small", "zoacres" )=> "zoacres-grid-small",
							esc_html__( "Medium", "zoacres" )=> "medium",
							esc_html__( "Large", "zoacres" )=> "large",
							esc_html__( "Thumbnail", "zoacres" )=> "thumbnail",
							esc_html__( "Custom", "zoacres" )=> "custom",
						),
						'std'			=> 'newsz_grid_2',
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
						"description"	=> esc_html__( "This is an option for blog slider option.", "zoacres" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slide items shown on large devices.", "zoacres" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slide items shown on tab.", "zoacres" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slide items shown on mobile.", "zoacres" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider auto play.", "zoacres" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider loop.", "zoacres" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider center, for this option must active loop and minimum items 2.", "zoacres" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider navigation.", "zoacres" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider pagination.", "zoacres" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider margin space.", "zoacres" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider duration.", "zoacres" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider smart speed.", "zoacres" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "zoacres" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "zoacres" ),
						"description"	=> esc_html__( "This is an option for blog slider scroll by.", "zoacres" ),
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
add_action( "vc_before_init", "zoacres_vc_blog_shortcode_map" );
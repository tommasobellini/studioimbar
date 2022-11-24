<?php
/**
 * Zoacres real estate functions
 */

/* Filtered Area */
if( ! function_exists('zoacres_search_filter_area') ) {
	function zoacres_search_filter_area(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-advance-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();

		$city_id = isset( $_POST['filter_city_id'] ) && $_POST['filter_city_id'] != '' ? $_POST['filter_city_id'] : '';
		
		$meta_qry = '';
		if( $city_id ){
			$meta_qry = array(
				 array(
					'key'       => 'area_parent_city',
					'value'     => esc_attr( $city_id ),
					'compare'   => '='
				 )
			);
		}
		
		$filtered_area = get_terms( array(
			'taxonomy' => 'property-area',
			'hide_empty' => false,
			'number' => 10,
			'meta_query' => $meta_qry
		) );
		
		$area_list = '<li>'. esc_html__( 'All Areas', 'zoacres' ) .'</li>';
		foreach( $filtered_area as $area ){
			$area_list .= '<li data-id="'. esc_attr( $area->term_id ) .'">'. esc_html( $area->name ) .'</li>';
		}
		
		$result['area_json'] = $area_list;
		
		echo json_encode( $result );
		
		die();
		
	}
	add_action('wp_ajax_nopriv_filter-area', 'zoacres_search_filter_area');
	add_action('wp_ajax_filter-area', 'zoacres_search_filter_area');
}

/* Filtered City */
if( ! function_exists('zoacres_search_filter_city') ) {
	function zoacres_search_filter_city(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-advance-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();
		
		$state_id = isset( $_POST['filter_state_id'] ) && $_POST['filter_state_id'] != '' ? $_POST['filter_state_id'] : '';
		
		$meta_qry = '';
		if( $state_id ){
			$meta_qry = array(
				 array(
					'key'       => 'city_parent_state',
					'value'     => esc_attr( $state_id ),
					'compare'   => '='
				 )
			);
		}
			
		$filtered_area = get_terms( array(
			'taxonomy' => 'property-city',
			'hide_empty' => false,
			'number' => 10,
			'meta_query' => $meta_qry
		) );
		
		$city_list = '<li>'. esc_html__( 'All Cities', 'zoacres' ) .'</li>';
		foreach( $filtered_area as $area ){
			$city_list .= '<li data-id="'. esc_attr( $area->term_id ) .'">'. esc_html( $area->name ) .'</li>';
		}
		
		$result['city_json'] = $city_list;
		
		echo json_encode( $result );
		
		die();
		
	}
	add_action('wp_ajax_nopriv_filter-city', 'zoacres_search_filter_city');
	add_action('wp_ajax_filter-city', 'zoacres_search_filter_city');
}


function zoacres_cpt_search( $query ) {
    $query->set('post_type', array('zoacres-property'));
    return $query;
};

/* Key Search Properties */
if( ! function_exists('zoacres_get_key_search_map') ) {
	function zoacres_get_key_search_map(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-key-search-map' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();
		
		$prop_list = '';
		
		if( isset( $_POST['key_val'] ) ) {
		
			$post_per_page = 3;
			$key_val = ''. $_POST['key_val'];
			$paged = isset( $_POST['paged'] ) ? $_POST['paged'] : 1;
		
			add_filter('pre_get_posts', 'zoacres_cpt_search');
			
			$args = array(
				'post_type'	=> 'zoacres-property',
				's'			=> esc_html( $key_val ),
				'order'		=> 'DESC',				
				'paged'		=> $paged,
				'posts_per_page' => $post_per_page,
				
			);
			
			$zpe = new ZoacresPropertyElements();
			
			ob_start();
			$zpe->zoacresHalfMapProperties( $args );
			$prop_list = ob_get_clean();
			$result['map_json'] = $prop_list;
			
		}
		
		echo json_encode( $result );
		
		die();

	
	}
	add_action('wp_ajax_nopriv_key_search_map', 'zoacres_get_key_search_map');
	add_action('wp_ajax_key_search_map', 'zoacres_get_key_search_map');
}

/* Key Search Properties */
if( ! function_exists('zoacres_get_key_search') ) {
	function zoacres_get_key_search(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-key-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();
		
		if( isset( $_POST['key_val'] ) ) {
		
			$post_per_page = 10;
			$key_val = ''. $_POST['key_val'];
			$paged = isset( $_POST['paged'] ) ? $_POST['paged'] : 1;
			
			$list = isset( $_POST['list'] ) && $_POST['list'] != '' ? true : false;
		
			add_filter('pre_get_posts', 'zoacres_cpt_search');

			$count_args = array(
				'post_type'	=> 'zoacres-property',
				'posts_per_page' => -1,
				's'			=> esc_html( $key_val ),
			);
			$count_query = new WP_Query( $count_args );
			
			$args = array(
				'post_type'	=> 'zoacres-property',
				's'			=> esc_html( $key_val ),
				'order'		=> 'DESC',				
				'paged'		=> $paged,
				'posts_per_page' => $post_per_page,
				
			);

			$prop_list = '';

			if( $list == true ):
				
				$zpe = new ZoacresPropertyElements();
				//$zpe::$cus_excerpt_len = 15;
				
				$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
				$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
				$zpe::$cus_excerpt_len = apply_filters( 'zoacres_property_list_excerpt_length', $arch_exc_len );
				
				$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
				$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
				if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
				
				ob_start();
				$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', 'col-md-6' );
				$prop_list = ob_get_clean();
				
			else:
			
				$zpe = new ZoacresPropertyElements();
				$units = $zpe->zoacresGetPropertyUnits();
			
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : 
					$prop_list = $paged <= 1 ? '<ul class="property-search-list">' : '';
					while ( $query->have_posts() ) : $query->the_post();
						
						$property_id = get_the_ID();
						$plot_area = get_post_meta( $property_id, 'zoacres_property_size', true );
						$bed_rooms = get_post_meta( $property_id, 'zoacres_property_no_bed_rooms', true );
						$bath_rooms = get_post_meta( $property_id, 'zoacres_property_no_bath_rooms', true );
						
						$prop_list .= '<li>';
							$prop_list .= '<div class="media">';
								$prop_list .= get_the_post_thumbnail( $property_id, 'thumbnail', array( 'class' => 'img-fluid img-thumbnail mr-3' ) );
								$prop_list .= '<div class="media-body">';
									$prop_list .= '<h6><a href="'. esc_url( get_the_permalink() ) .'">'. esc_html( get_the_title() ) .'</a></h6>';
									$prop_list .= '<ul class="nav key-search-list">';
										$prop_list .= $plot_area != '' ? '<li class="property-size"><span class="flaticon-area-chart"></span> '. esc_html( $plot_area .' '. $units ) .'</li>' : '';
										$prop_list .= $bed_rooms != '' ? '<li class="property-bed-rooms"><span class="flaticon-slumber"></span> '. esc_html( $bed_rooms ) .'</li>' : '';
										$prop_list .= $bath_rooms != '' ? '<li class="property-bath-rooms"><span class="flaticon-bathtub"></span> '. esc_html( $bath_rooms ) .'</li>' : '';
									$prop_list .= '</ul>';
								$prop_list .= '</div><!-- .media-body -->';
							$prop_list .= '</div><!-- .media -->';						
						$prop_list .= '</li>';
						
					endwhile;
					wp_reset_postdata();
					
					$total_out_prop = $post_per_page * $paged;
					$count = count( $count_query->posts );
					if( $total_out_prop < $count ){
						$prop_list .= '<li class="ajax-search-more-wrap text-center">';
							$prop_list .= '<p>'. $total_out_prop .'/'. $count .'</p>';
							$prop_list .= '<span class="ajax-search-more" data-page="'. absint( ++$paged ) .'">'. esc_html__( 'Load More', 'zoacres' ) .'</span>';
						$prop_list .= '</li>';
					}
					
					$prop_list .= $paged <= 1 ? '</ul>' : '';
				endif;
			endif; //list
			
			$result['property_json'] = $prop_list;
			
		}
		
		echo json_encode( $result );
		
		die();
		
	}
	add_action('wp_ajax_nopriv_key_search', 'zoacres_get_key_search');
	add_action('wp_ajax_key_search', 'zoacres_get_key_search');
}

function zoacresStaticPropertyTaxQuery( $tax_stat, $tmp_tax = array() ){
	static $tax_queryn = array( 'relation' => 'AND' );
	
	if( $tax_stat == 'set' ){
		array_push( $tax_queryn, $tmp_tax );
	}
	
	return $tax_queryn;
}

function zoacresStaticPropertyMetaQuery( $meta_stat, $tmp_meta = array() ){
	static $meta_queryn = array( 'relation' => 'AND' );
	
	if( $meta_stat == 'set' ){
		array_push( $meta_queryn, $tmp_meta );
	}
	
	return $meta_queryn;
}

function search_filter_get_property_list($query) {
    $taxquery = zoacresStaticPropertyTaxQuery( 'get' );
    $query->set( 'tax_query', $taxquery );
	$query->set('post_type', array( 'zoacres-property' ) );
	return $query;
}

function search_filter_get_property_listby_meta($query) {
	$metaquery = zoacresStaticPropertyMetaQuery( 'get' );
	$query->set( 'meta_query', $metaquery );
	$query->set('post_type', array( 'zoacres-property' ) );
	return $query;
}

/* Key Search Properties */
if( ! function_exists('zoacres_get_key_search_list') ) {
	function zoacres_get_key_search_list(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-key-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();
		
		$key_val = isset( $_POST['key_val'] ) ? $_POST['key_val'] : '';
		$paged = isset( $_POST['paged'] ) ? $_POST['paged'] : 1;
		
		$map_stat = isset( $_POST['map_stat'] ) ? $_POST['map_stat'] : "property";
		
		$meta_stat = 0;
		
		$rooms_id = isset( $_POST['rooms_id'] ) ? $_POST['rooms_id'] : "";
		if( $rooms_id != '' ){
			$no_rooms_arr = array(
				'key'     => 'zoacres_property_no_rooms',
				'value'   => esc_attr( $rooms_id ),
				'compare' => '>='
			);
			$no_rooms_qry = zoacresStaticPropertyMetaQuery( 'set', $no_rooms_arr ) ;
			$meta_stat = 1;
		}
				
		$bed_id = isset( $_POST['bed_id'] ) ? $_POST['bed_id'] : "";
		if( $bed_id != '' ){
			$t_arr = array(
				'key'     => 'zoacres_property_no_bed_rooms',
				'value'   => esc_attr( $bed_id ),
				'compare' => '>='
			);
			$t_qry = zoacresStaticPropertyMetaQuery( 'set', $t_arr ) ;
			$meta_stat = 1;
		}

		$bath_id = isset( $_POST['bath_id'] ) ? $_POST['bath_id'] : "";
		if( $bath_id != '' ){
			$t_arr = array(
				'key'     => 'zoacres_property_no_bath_rooms',
				'value'   => esc_attr( $bath_id ),
				'compare' => '>='
			);
			$t_qry = zoacresStaticPropertyMetaQuery( 'set', $t_arr ) ;
			$meta_stat = 1;
		}

		$minarea = isset( $_POST['minarea_id'] ) && $_POST['minarea_id'] != '' ? $_POST['minarea_id'] : "0";
		$maxarea = isset( $_POST['maxarea_id'] ) && $_POST['maxarea_id'] != '' ? $_POST['maxarea_id'] : "0";
		if( $minarea || $maxarea ){
			$t_arr = '';
			if( $minarea != '0' &&  $maxarea == '0' ){
				$t_arr = array(
					'key'     => 'zoacres_property_size',
					'value' => doubleval( esc_attr( $minarea ) ),
					'compare' => '>=',
				);
			}elseif( $maxarea != '0' &&  $minarea == '0' ){
				$t_arr = array(
					'key'     => 'zoacres_property_size',
					'value' => doubleval( esc_attr( $maxarea ) ),
					'compare' => '<=',			
				);
			}else{
				$t_arr = array(
					'key'     => 'zoacres_property_size',
					'value'   => array( doubleval( $minarea ), doubleval( $maxarea ) ),
					'type'	  => 'NUMERIC',
					'compare' => 'BETWEEN'				
				);
			}
			
			$t_qry = zoacresStaticPropertyMetaQuery( 'set', $t_arr ) ;
			$meta_stat = 1;
		}

		$price_min = isset( $_POST['price_min'] ) && $_POST['price_min'] != '' ? $_POST['price_min'] : "0";
		$price_max = isset( $_POST['price_max'] ) && $_POST['price_max'] != '' ? $_POST['price_max'] : "0";
		
		if( $price_min || $price_max ){
			$t_arr = '';
			if( $price_min != '0' &&  $price_max == '0' ){
				$t_arr = array(
					'key'     => 'zoacres_property_price',
					'value' => doubleval( esc_attr( $price_min ) ),
					'compare' => '>=',
				);
			}elseif( $price_max != '0' &&  $price_min == '0' ){
				$t_arr = array(
					'key'     => 'zoacres_property_price',
					'value' => doubleval( esc_attr( $price_max ) ),
					'compare' => '<=',			
				);
			}else{
				$t_arr = array(
					'key'     => 'zoacres_property_price',
					'value'   => array( doubleval( $price_min ), doubleval( $price_max ) ),
					'type'	  => 'NUMERIC',
					'compare' => 'BETWEEN'				
				);
			}
			
			$t_qry = zoacresStaticPropertyMetaQuery( 'set', $t_arr ) ;
			$meta_stat = 1;
		}
		
		$tax_qry = '';		
		$tax_stat = 0;
		$city_id = isset( $_POST['city_id'] ) ? $_POST['city_id'] : "";
		if( $city_id && $city_id != 'all' ){
			$city_tax_array = array(
				'taxonomy' => 'property-city',
				'field' => 'term_id',
				'terms' => array( $city_id ),
				'operator'=> 'IN'
			);
			$city_qry = zoacresStaticPropertyTaxQuery( 'set', $city_tax_array ) ;
			$tax_stat = 1;
		}
		
		$area_id = isset( $_POST['area_id'] ) ? $_POST['area_id'] : "";
		if( $area_id && $area_id != 'all' ){
			$area_tax_array = array(
				'taxonomy' => 'property-area',
				'field' => 'term_id',
				'terms' => array( $area_id ),
				'operator'=> 'IN'
			);
			$area_qry = zoacresStaticPropertyTaxQuery( 'set', $area_tax_array ) ;
			$tax_stat = 1;
		}
		
		$type_id = isset( $_POST['type_id'] ) ? $_POST['type_id'] : "";
		if( $type_id && $type_id != 'all' ){
			$type_tax_array = array(
				'taxonomy' => 'property-category',
				'field' => 'term_id',
				'terms' => array( $type_id ),
				'operator'=> 'IN'
			);
			$type_qry = zoacresStaticPropertyTaxQuery( 'set', $type_tax_array ) ;
			$tax_stat = 1;
		}
		
		$action_id = isset( $_POST['action_id'] ) ? $_POST['action_id'] : "";
		if( $action_id && $action_id != 'all' ){
			$action_tax_array = array(
				'taxonomy' => 'property-action',
				'field' => 'term_id',
				'terms' => array( $action_id ),
				'operator'=> 'IN'
			);
			$action_qry = zoacresStaticPropertyTaxQuery( 'set', $action_tax_array ) ;
			$tax_stat = 1;
		}
		
		if( $meta_stat ){
			add_filter( 'pre_get_posts', 'search_filter_get_property_listby_meta' );
		}
		
		if( $tax_stat ){
			add_filter( 'pre_get_posts', 'search_filter_get_property_list' );
		}else{
			add_filter( 'pre_get_posts', 'zoacres_cpt_search' );
		}
		
		$args = array(
			'post_type'	=> 'zoacres-property',
			's'			=> esc_html( $key_val ),
			'order'		=> 'DESC',				
			'paged'		=> absint( $paged ),
		);

		$prop_list = '';
		$zpe = new ZoacresPropertyElements();

		if( $map_stat == "property" || $map_stat == "property_map"  ):

			//$zpe::$cus_excerpt_len = 15;
			$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
			$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
			$zpe::$cus_excerpt_len = apply_filters( 'zoacres_property_map_excerpt_length', $arch_exc_len );
			
			$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
			$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
			if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
			
			ob_start();
			$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', 'col-md-6' );
			$prop_list = ob_get_clean();
			
			if( $map_stat == "property_map" ){
				
				$args['paged'] = 1;
				$args['posts_per_page'] = 6 * absint( $paged );
				
				$map_array = $zpe->zoacresHalfMapProperties( $args, true );

				ob_start();
				$zpe->zoacresHalfMapPropertiesMakeMap( $map_array );
				$prop_maps = ob_get_clean();
				
				$result['map_json'] = $prop_maps;
			}
			
			$result['property_eof'] = false;
			$result['property_json'] = $prop_list;
			if( $prop_list == '' ){
				$result['property_eof'] = true;
			};
			
			
			
			
		elseif( $map_stat == "map" ):

			$map_array = $zpe->zoacresHalfMapProperties( $args );
			
			ob_start();
			$zpe->zoacresHalfMapPropertiesMakeMap( $map_array );
			$prop_maps = ob_get_clean();
			
			$result['map_json'] = $prop_maps;
			
		endif; //list	

		echo json_encode( $result );
		
		die();
		
	}
	add_action('wp_ajax_nopriv_key_search_list', 'zoacres_get_key_search_list');
	add_action('wp_ajax_key_search_list', 'zoacres_get_key_search_list');
}

function search_filter_get_property_ppp($query) {
	$query->set('posts_per_page', 12 );
	$query->set('post_type', array( 'zoacres-property' ) );
	return $query;
}

/* get zoacres taxonomy links and name */
if( ! function_exists('zoacres_get_property_tax_link') ) {
	function zoacres_get_property_tax_link( $prop_id, $prop_tax ){
		
		$tax_arr = array( 'name' => '', 'link' => '' );
		$property_tax = get_the_terms( $prop_id, $prop_tax );
		if ( $property_tax ) {
			$term_link = get_term_link( $property_tax[0], array( $prop_tax) );
			if( !is_wp_error( $term_link ) ){
				$tax_arr['name'] = $property_tax[0]->name;
				$tax_arr['link'] = $term_link;
			}
		}
		
		return $tax_arr;
	}
}

/* get zoacres taxonomy links and name */
if( ! function_exists('zoacres_agent_contact_form') ) {
	
	function zoacres_agent_contact_form(){
		
		$nonce = sanitize_text_field($_POST['nonce']);
  
    	if ( ! wp_verify_nonce( $nonce, 'zoacres-agent-contact' ) ) die ( esc_html__( 'Busted!', 'zoacres' ) );
		
		$property_id = isset( $_POST['property-id'] ) ? $_POST['property-id'] : '';
		$agent_id = isset( $_POST['agent-id'] ) ? $_POST['agent-id'] : '';
		
		$schedule_date = isset( $_POST['property-customer-schedule-date'] ) ? $_POST['property-customer-schedule-date'] : '';
		$schedule_time = isset( $_POST['property-customer-schedule-time'] ) ? $_POST['property-customer-schedule-time'] : '';
		
		$property_name = isset( $_POST['property-customer-name'] ) ? $_POST['property-customer-name'] : '';
		$property_email = isset( $_POST['property-customer-email'] ) ? $_POST['property-customer-email'] : '';
		$property_tele = isset( $_POST['property-customer-tele'] ) ? $_POST['property-customer-tele'] : '';
		$property_msg = isset( $_POST['property-customer-msg'] ) ? $_POST['property-customer-msg'] : '';
		
		$property_link = get_permalink( absint( $property_id ) );
		
		$stat = 0;
		$stat_msg = '';
		if( $property_name == '' ){
			$stat = 1;
			$stat_msg = apply_filters( 'zoacres_name_validation_msg', esc_html__( 'Name field must not empty!', 'zoacres' ) );
		}elseif ( !is_email( $property_email ) ) {
			$stat = 1;
			$stat_msg = apply_filters( 'zoacres_email_validation_msg', esc_html__( 'Must put valid email id!', 'zoacres' ) );
		}elseif( preg_match( "/^[0-9-+ ]+$/", $property_tele ) != 1 ) {
			$stat = 1;
			$stat_msg = apply_filters( 'zoacres_tele_validation_msg', esc_html__( 'Must put valid phone number!', 'zoacres' ) );
		}
		
		$result = array();
		if( $stat ){
			$result['res_json'] = $stat_msg;
		}else{
			$result['res_json'] = apply_filters( 'zoacres_agent_mail_success', esc_html__( 'Your message successfully sent to agent!', 'zoacres' ) );
			
			$msg = '
			<h5>'. esc_html__( 'Customer Interested on Property:', 'zoacres' ) .'</h5>
			<table>';
			
			if( $schedule_date ){
				$msg .= '<tr><td>'. esc_html__( 'Schedule Day:', 'zoacres' ) .'</td><td>'. esc_html( $schedule_date ) .'</td></tr>';
			}
			if( $schedule_time ){
				$msg .= '<tr><td>'. esc_html__( 'Schedule Time:', 'zoacres' ) .'</td><td>'. esc_html( $schedule_time ) .'</td></tr>';
			}
			
			$agent_msg = '';
			
			if( $agent_id == '' ){
				$msg .= '
					<tr><td>'. esc_html__( 'Customer Email ID:', 'zoacres' ) .'</td><td>'. esc_html( $property_email ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Name:', 'zoacres' ) .'</td><td>'. esc_html( $property_name ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Phone:', 'zoacres' ) .'</td><td>'. esc_html( $property_tele ) .'</td></tr>
					<tr><td>'. esc_html__( 'Property ID:', 'zoacres' ) .'</td><td>'. esc_html( $property_id ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Message:', 'zoacres' ) .'</td><td>'. esc_html( $property_msg ) .'</td></tr>
					<tr><td>'. esc_html__( 'Property Link:', 'zoacres' ) .'</td><td>'. esc_url( $property_link ) .'</td></tr>
				</table>';
				
				$agent_msg =  apply_filters( 'zoacres_agent_mail_msg_format', $msg,
					$property_email,
					$property_name,
					$property_tele,
					$property_id,
					$property_msg,
					$schedule_date,
					$schedule_time );
					
				$agent_id = get_post_meta( absint( $property_id ), 'zoacres_property_agent_id', true );
			}else{
				$msg .= '
					<tr><td>'. esc_html__( 'Customer Email ID:', 'zoacres' ) .'</td><td>'. esc_html( $property_email ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Name:', 'zoacres' ) .'</td><td>'. esc_html( $property_name ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Phone:', 'zoacres' ) .'</td><td>'. esc_html( $property_tele ) .'</td></tr>
					<tr><td>'. esc_html__( 'Customer Message:', 'zoacres' ) .'</td><td>'. esc_html( $property_msg ) .'</td></tr>
				</table>';
				
				$agent_msg =  apply_filters( 'zoacres_agent_single_mail_msg_format', $msg,
					$property_email,
					$property_name,
					$property_tele,
					$property_msg );
			}
			$agent_email = get_post_meta( absint( $agent_id ), 'zoacres_agent_email', true );
			
			$to = esc_attr( $agent_email );
			$subject = apply_filters( 'zoacres_agent_contact_subject', esc_html__( 'Customer Interested on Property', 'zoacres' ) );
			$body = $agent_msg;
			$serv_http_host = class_exists( "ZoacresRedux" ) ? zoacres_get_http_host() : 'domain.com';
			$sender_email = apply_filters( 'zoacres_agent_contact_sender_email', '<noreply@'. esc_attr( $serv_http_host ) .'>' );
			$headers = array('Content-Type: text/html; charset=UTF-8', esc_html__( 'From: No Reply', 'zoacres' ) . ' '. $sender_email);
			 
			if( class_exists( "ZoacresRedux" ) ){
				$mail_res = zoacres_send_mail( $to, $subject, $body, $headers );
				if( $mail_res != '' ) $result['res_json'] = $mail_res;
			}else{
				$result['res_json'] = apply_filters( 'zoacres_agent_mail_problem', esc_html__( 'Mail sending problem!', 'zoacres' ) );
			}
			
		} // status check else part

		echo json_encode( $result );
		die();
	}
	add_action('wp_ajax_nopriv_agent_contact_form', 'zoacres_agent_contact_form');
	add_action('wp_ajax_agent_contact_form', 'zoacres_agent_contact_form');
	
}

/* Property Compare */
if( ! function_exists('zoacres_product_compare') ) {
	function zoacres_product_compare(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-property-compare' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();
		
		if( isset( $_POST['compare_ids'] ) ) {
		
			$property_ids = isset( $_POST['compare_ids'] ) ? $_POST['compare_ids'] : '';
			
			$out = '<div class="col"></div>';
			$fout = '';
			$cols = count( $property_ids );
			$cols = $cols >= 4 ? 3 : absint( 12/$cols );

			$prop_ele = array( 
				'title' => esc_html__( 'Title', 'zoacres' ),
				'image' => esc_html__( 'Image', 'zoacres' ),
				'price' => esc_html__( 'Price', 'zoacres' ),
				'cid' => esc_html__( 'Custom ID', 'zoacres' ),
				'type' => esc_html__( 'Type', 'zoacres' ),
				'city' => esc_html__( 'City', 'zoacres' ),
				'area' => esc_html__( 'Area', 'zoacres' ),
				'zip' => esc_html__( 'Zip', 'zoacres' ),
				'size' => esc_html__( 'Size', 'zoacres' ),
				'lotsize' => esc_html__( 'Lot Size', 'zoacres' ),
				'rooms' => esc_html__( 'Rooms', 'zoacres' ),
				'bedrooms' => esc_html__( 'Bed Rooms', 'zoacres' ),
				'bathrooms' => esc_html__( 'Bath Rooms', 'zoacres' ),
				'structure' => esc_html__( 'Structure', 'zoacres' )
			);

			$ftr_tbl = array();

			$zpe = new ZoacresPropertyElements;
			
			$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
			$property_features_arr = zoacres_trim_array_same_values( $property_features );
			if( $property_features_arr ):
				foreach( $property_features_arr as $feature => $value ){
					$prop_ele[$feature] = $value;
				}
			endif;
			
			$property_cf = $zpe->zoacresPropertyThemeOpt('property-custom-fields');
			$property_cf = json_decode( $property_cf, true );
			
			$cf_array = array();
			$cf_type_array = array();
			if( $property_cf ):
				foreach( $property_cf as $fields ){			
					$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
					$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
					$fld_type = $fields['Field Type'] ? $fields['Field Type'] : 'text';
					array_push( $cf_array, $fld_id);
					$cf_type_array[$fld_id] = $fld_type;
					$prop_ele[$fld_id] = $fld_name;
				}
			endif;
			
			$agrs = array( 
				'post_type' => 'zoacres-property', 
				'post__in' => $property_ids
			);
			$query = new WP_Query( $agrs );
			
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					
					$query->the_post();
					
					$pid = get_the_ID();

					$ftr_tbl[$pid] = array();
					$title = '<p class="text-center"><strong>'. get_the_title( absint( $pid ) ) .'</strong></p>';
					$ftr_tbl[$pid]['title'] = $title;
					
					$img  = get_the_post_thumbnail( $pid, 'grid-medium', array( 'class' => 'img-fluid' ) );
					$ftr_tbl[$pid]['image'] = $img;

					ob_start();
					$zpe->zoacresGetPropertyPrice( 'span' );
					$price = ob_get_clean();
					$ftr_tbl[$pid]['price'] = $price;
					
					$property_type = zoacres_get_property_tax_link( $pid, 'property-category' );
					$type = '<a href="'. esc_url( $property_type['link'] ) .'">'. esc_html( $property_type['name'] ) .'</a>';
					$ftr_tbl[$pid]['type'] = $type;
					
					$prop_id_label = $zpe->zoacresPropertyThemeOpt('property-id-before');
					$prop_custom_id = $prop_id_label . $pid;
					$ftr_tbl[$pid]['cid'] = $prop_custom_id;
					
					$property_city = zoacres_get_property_tax_link( $pid, 'property-city' );
					$city = '<a href="'. esc_url( $property_city['link'] ) .'">'. esc_html( $property_city['name'] ) .'</a>';
					$ftr_tbl[$pid]['city'] = $city;
					
					$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
					$area = '<a href="'. esc_url( $property_area['link'] ) .'">'. esc_html( $property_area['name'] ) .'</a>';
					$ftr_tbl[$pid]['area'] = $area;
					
					$property_zip = $zpe->zoacresGetPropertyMetaValue('zoacres_property_zip');
					$ftr_tbl[$pid]['zip'] = $property_zip;
					
					$size = $zpe->zoacresGetPropertyMetaValue('zoacres_property_size');
					$ftr_tbl[$pid]['size'] = $size;
					
					$lot_size = $zpe->zoacresGetPropertyMetaValue('zoacres_property_lot_size');
					$ftr_tbl[$pid]['lotsize'] = $lot_size;
					
					$no_rooms = $zpe->zoacresGetPropertyMetaValue('zoacres_property_no_rooms');
					$ftr_tbl[$pid]['rooms'] = $no_rooms;
					
					
					$no_bed_rooms = $zpe->zoacresGetPropertyMetaValue('zoacres_property_no_bed_rooms');
					$ftr_tbl[$pid]['bedrooms'] = $no_bed_rooms;
					
					$no_bath_rooms = $zpe->zoacresGetPropertyMetaValue('zoacres_property_no_bath_rooms');
					$ftr_tbl[$pid]['bathrooms'] = $no_bath_rooms;
					
					$structure = $zpe->zoacresGetPropertyMetaValue('zoacres_property_structures');
					$ftr_tbl[$pid]['structure'] = isset( $structure[0] ) ? $structure[0] : '';
					
					if( $property_features_arr ):
						foreach( $property_features_arr as $feature => $value ){
							$prop_features = $zpe->zoacresGetPropertyMetaValue('zoacres_property_features_'. sanitize_title( $feature ));
							if ( $prop_features ){
								$ftr_tbl[$pid][$feature] = '<i class="icon-check icons"></i>';
							}else{
								$ftr_tbl[$pid][$feature] = '-';
							}
						}
					endif;
					
					if( !empty( $cf_array ) ):
						foreach( $cf_array as $field ){
							$cf_value = $zpe->zoacresGetPropertyMetaValue('zoacres_property_custom_'.$field);
							$ftype = $cf_type_array[$field];
							if( $ftype == 'checkbox' ){
								$ftr_tbl[$pid][$field] = $cf_value != '' ? '<i class="icon-check icons"></i>' : '-';
							}else{
								$ftr_tbl[$pid][$field] = $cf_value != '' ? $cf_value : '-';
							}
						}
					endif;

					
				}
				/* Restore original Post Data */
				wp_reset_postdata();
			}
			
			$fout = '<table>';
				foreach( $prop_ele as $key => $val ){
					$fout .= '<tr>';
						$fout .= '<td class="compare-table-head">'. $val .'</td>';
						foreach( $ftr_tbl as $prop ){
							$val = isset( $prop[$key] ) ? $prop[$key] : '';
							$fout .= '<td>';
								$fout .= $val != '' ? $val : '-';
							$fout .= '</td>';
						}
					$fout .= '</tr>';
				}
			$fout .= '</table>';
			
			$output = '
			<div class="property-modal" id="property-compare-modal">
				<div class="property-modal-inner">
					<span class="close"></span>
					<div class="property-modal-body">
						<div class="row">';
				$output .= $fout;	
			$output .= '</div>
					</div>
				</div>
			</div>';
			
			$result['result'] = $output;
			
		}
		
		echo json_encode( $result );
		
		die();
		
	}
	add_action('wp_ajax_nopriv_zproduct_compare', 'zoacres_product_compare');
	add_action('wp_ajax_zproduct_compare', 'zoacres_product_compare');
}

/* Property Remove Favourite */
if( ! function_exists('zoacres_remove_favourite_property') ) {
	function zoacres_remove_favourite_property(){
		//zoacres-property-favourite
		$nonce = sanitize_text_field($_POST['nonce']);  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-property-favourite' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$proprty_id = esc_attr( $_POST['property_id'] );
		$author_id = get_current_user_id();
		
		if( $author_id ){
		
			$fav_array = get_user_meta( $author_id, 'zoacres_favourite_properties', true );
			if( isset( $fav_array ) && is_array( $fav_array ) ){

				if ( in_array( $proprty_id, $fav_array ) ){

					$ind = array_search( $proprty_id, $fav_array );
					unset( $fav_array[$ind] );
					$fav_array = array_values( $fav_array );
					update_user_meta( $author_id, 'zoacres_favourite_properties', $fav_array );
					
				}		

			}

		
			$result['result'] = "success";	
		}else{
			$result['result'] = "failure";	
		}
		
		echo json_encode( $result );
			
		die();
	}	
	add_action('wp_ajax_nopriv_zremove_fav', 'zoacres_remove_favourite_property');
	add_action('wp_ajax_zremove_fav', 'zoacres_remove_favourite_property');
}

/* Property Favourite */
if( ! function_exists('zoacres_add_favourite_property') ) {
	function zoacres_add_favourite_property(){
		//zoacres-property-favourite
		$nonce = sanitize_text_field($_POST['nonce']);  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-property-favourite' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$proprty_id = esc_attr( $_POST['property_id'] );
		$author_id = get_current_user_id();
		
		if( $author_id ){
		
			$fav_array = get_user_meta( $author_id, 'zoacres_favourite_properties', true );
			if( isset( $fav_array ) && is_array( $fav_array ) ){

				if ( ! in_array( $proprty_id, $fav_array ) ){
					array_push( $fav_array, $proprty_id );
				}		

			}else{
				$fav_array = array( $proprty_id );
			}
			
			update_user_meta( $author_id, 'zoacres_favourite_properties', $fav_array );
		
			$result['result'] = "success";	
		}else{
			$result['result'] = "failure";	
		}
		
		echo json_encode( $result );
			
		die();
	}	
	add_action('wp_ajax_nopriv_zadd_fav', 'zoacres_add_favourite_property');
	add_action('wp_ajax_zadd_fav', 'zoacres_add_favourite_property');
}


// Ajax Property Getting Function
/* Key Search Properties */
if( ! function_exists('zoacres_get_zpropertygetting') ) {
	function zoacres_get_zpropertygetting(){
				
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-key-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );

			
		$key_val = isset( $_POST['key_val'] ) ? $_POST['key_val'] : '';
		$paged = isset( $_POST['paged'] ) ? $_POST['paged'] : 1;
		$map_stat = isset( $_POST['map_stat'] ) ? $_POST['map_stat'] : "property";
		$cols = isset( $_POST['cols'] ) ? $_POST['cols'] : "6";

		// Property Agent
		$agent_id = isset( $_POST['agent'] ) ? $_POST['agent'] : "";
		$agent_arr = array();
		if( $agent_id ){
			$agent_arr = array(
				'key'     => 'zoacres_property_agent_id',
				'value'   => esc_attr( $agent_id ),
				'compare' => '='
			);
		}
		$agent_arr = !empty( $agent_arr ) ? $agent_arr : '';
			
		// Property rooms
		$rooms_id = isset( $_POST['rooms_id'] ) ? $_POST['rooms_id'] : "";
		$no_rooms_arr = array();
		if( $rooms_id ){
			$no_rooms_arr = array(
				'key'     => 'zoacres_property_no_rooms',
				'value'   => esc_attr( $rooms_id ),
				'compare' => '>='
			);
		}
		$no_rooms_arr = !empty( $no_rooms_arr ) ? $no_rooms_arr : '';

		// Property bed rooms
		$bed_id = isset( $_POST['bed_id'] ) ? $_POST['bed_id'] : "";
		$bed_arr = array();
		if( $bed_id ){
			$bed_arr = array(
				'key'     => 'zoacres_property_no_bed_rooms',
				'value'   => esc_attr( $bed_id ),
				'compare' => '>='
			);
		}
		$bed_arr = !empty( $bed_arr ) ? $bed_arr : '';
		
		// Property bath rooms
		$bath_id = isset( $_POST['bath_id'] ) ? $_POST['bath_id'] : "";
		$bath_arr = array();
		if( $bath_id ){
			$bath_arr = array(
				'key'     => 'zoacres_property_no_bath_rooms',
				'value'   => esc_attr( $bath_id ),
				'compare' => '>='
			);
		}
		$bath_arr = !empty( $bath_arr ) ? $bath_arr : '';
		
		// Property garage
		$garage_id = isset( $_GET['garage_id'] ) ? $_GET['garage_id'] : "";
		$garage_arr = array();
		if( $garage_id ){
			$garage_arr = array(
				'key'     => 'zoacres_property_no_garages',
				'value'   => esc_attr( $garage_id ),
				'compare' => '>='
			);
		}
		$garage_arr = !empty( $garage_arr ) ? $garage_arr : '';
			
		// Property area
		$minarea = isset( $_POST['minarea_id'] ) && $_POST['minarea_id'] != '' ? $_POST['minarea_id'] : "0";
		$maxarea = isset( $_POST['maxarea_id'] ) && $_POST['maxarea_id'] != '' ? $_POST['maxarea_id'] : "0";
		$property_size = array();
		if( $minarea || $maxarea ){
			if( $minarea != '0' &&  $maxarea == '0' ){
				$property_size = array(
					'key'     => 'zoacres_property_size',
					'value' => doubleval( esc_attr( $minarea ) ),
					'compare' => '>=',
				);
			}elseif( $maxarea != '0' &&  $minarea == '0' ){
				$property_size = array(
					'key'     => 'zoacres_property_size',
					'value' => doubleval( esc_attr( $maxarea ) ),
					'compare' => '<=',			
				);
			}else{
				$property_size = array(
					'key'     => 'zoacres_property_size',
					'value'   => array( doubleval( $minarea ), doubleval( $maxarea ) ),
					'type'	  => 'NUMERIC',
					'compare' => 'BETWEEN'				
				);
			}
		}
		$property_size = !empty( $property_size ) ? $property_size : '';
		
		// Property price
		$minprice = isset( $_POST['price_min'] ) && $_POST['price_min'] != '' ? $_POST['price_min'] : "0";
		$maxprice = isset( $_POST['price_max'] ) && $_POST['price_max'] != '' ? $_POST['price_max'] : "0";
		$property_price = array();
		if( $minprice || $maxprice ){
			$property_price = array(
				'key'     => 'zoacres_property_price',
				'value'   => array( doubleval( $minprice ), doubleval( $maxprice ) ),
				'type'	  => 'NUMERIC',
				'compare' => 'BETWEEN'				
			);
		}
		$property_price = !empty( $property_price ) ? $property_price : '';

		// Property Country
		$country_id = isset( $_POST['country_id'] ) ? $_POST['country_id'] : "";
		$country_tax_array = array();
		if( $country_id && $country_id != 'all' ){
			$country_tax_array = array(
				'taxonomy' => 'property-country',
				'field' => 'term_id',
				'terms' => array( $country_id ),
				'operator'=> 'IN'
			);
		}
		$country_tax_array = !empty( $country_tax_array ) ? $country_tax_array : '';
		
		// Property State
		$state_id = isset( $_POST['state_id'] ) ? $_POST['state_id'] : "";
		$state_tax_array = array();
		if( $state_id && $state_id != 'all' ){
			$state_tax_array = array(
				'taxonomy' => 'property-state',
				'field' => 'term_id',
				'terms' => array( $state_id ),
				'operator'=> 'IN'
			);
		}
		$state_tax_array = !empty( $state_tax_array ) ? $state_tax_array : '';
		
		// Property City
		$city_id = isset( $_POST['city_id'] ) ? $_POST['city_id'] : "";
		$city_tax_array = array();
		if( $city_id && $city_id != 'all' ){
			$city_tax_array = array(
				'taxonomy' => 'property-city',
				'field' => 'term_id',
				'terms' => array( $city_id ),
				'operator'=> 'IN'
			);
		}
		$city_tax_array = !empty( $city_tax_array ) ? $city_tax_array : '';
		
		// Property Area
		$area_id = isset( $_POST['area_id'] ) ? $_POST['area_id'] : "";
		$area_tax_array = array();
		if( $area_id && $area_id != 'all' ){
			$area_tax_array = array(
				'taxonomy' => 'property-area',
				'field' => 'term_id',
				'terms' => array( $area_id ),
				'operator'=> 'IN'
			);
		}
		$area_tax_array = !empty( $area_tax_array ) ? $area_tax_array : '';
		
		// Property Category
		$type_id = isset( $_POST['type_id'] ) ? $_POST['type_id'] : "";
		$type_tax_array = array();
		if( $type_id && $type_id != 'all' ){
			$type_tax_array = array(
				'taxonomy' => 'property-category',
				'field' => 'term_id',
				'terms' => array( $type_id ),
				'operator'=> 'IN'
			);
		}
		$type_tax_array = !empty( $type_tax_array ) ? $type_tax_array : '';
		
		// Property Action
		$action_id = isset( $_POST['action_id'] ) ? $_POST['action_id'] : "";
		$action_tax_array = array();
		if( $action_id && $action_id != 'all' ){
			$action_tax_array = array(
				'taxonomy' => 'property-action',
				'field' => 'term_id',
				'terms' => array( $action_id ),
				'operator'=> 'IN'
			);
		}
		$action_tax_array = !empty( $action_tax_array ) ? $action_tax_array : '';
		
		$zpe = new ZoacresPropertyElements();
		
		$ppp = isset( $_POST['ppp'] ) && $_POST['ppp'] != '' ? $_POST['ppp'] : '';
		if( $ppp == '' ){
			$ppp = $zpe->zoacresPropertyThemeOpt( 'property-per-page' );
		}		
		
		$full_map = isset( $_POST['full_map'] ) && $_POST['full_map'] == 'true' ? true : false;
		if( $full_map == true ){
			$ppp = 50;
		}
		
		$sort_val = isset( $_POST['sort_val'] ) && $_POST['sort_val'] != '' ? esc_attr( $_POST['sort_val'] ) : '';
		$orderby = 'date';
		$order = 'DESC';
		$featured_arr = array();
		if( $sort_val == 'low-high' || $sort_val == 'high-low' ){
			$orderby = 'meta_value_num';
			$order = $sort_val == 'low-high' ? 'ASC' : 'DESC';
		}elseif( $sort_val == 'oldest' ){
			$order = 'ASC';
		}elseif( $sort_val == 'featured' ){
			$featured_arr = array(
				'key'     => 'zoacres_post_featured_stat',
				'value'   => 1,
				'compare' => '='
			);
		}
		
		$meta_query = array(
			'relation' => 'AND',
			$property_price,
			$property_size,
			$no_rooms_arr,
			$bed_arr,
			$bath_arr,
			$garage_arr,
			$agent_arr,
			$featured_arr,
		);
		
		$more_features = isset( $_POST['more_search'] ) && !empty( $_POST['more_search'] ) ? $_POST['more_search'] : '';

		$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
		$property_features_arr = zoacres_trim_array_same_values( $property_features );
		$feat_final = $more_features;
		foreach( $feat_final as $feature ){
		
			$more_features_arr = array(
				'key'     => 'zoacres_property_features_' . $feature,
				'value'   => $feature,
				'compare' => '='
			);
			array_push( $meta_query, $more_features_arr );
		}
		
		add_filter( 'pre_get_posts', 'zoacres_cpt_search' );
		$args = array(
			'post_type'  => 'zoacres-property',
			'post_status' => 'publish',
			'orderby' => $orderby,
			'order'   => $order,
			'posts_per_page' => absint( $ppp ),
			'paged' => $paged,
			'meta_query' => $meta_query,
			'tax_query' => array(
				'relation' => 'AND',
				$country_tax_array,
				$state_tax_array,
				$city_tax_array,
				$area_tax_array,
				$type_tax_array,
				$action_tax_array				
			),
			's' => $key_val,
		);
		
		$args = apply_filters( 'zoacres_property_getting_common_args', $args );
		
		$result = array();
		
		$prop_list = '';
		$meta_args = isset( $_POST['meta_args'] ) && !empty( $_POST['meta_args'] ) ? json_decode( stripslashes( $_POST['meta_args'] ), true ) : array();
		
		$animation = isset( $_POST['animation'] ) && $_POST['animation'] ? true : false;
		$meta_layout = isset( $_POST['layout'] ) ? $_POST['layout'] : '';
		$meta_args['animation'] = $animation;
		if( $meta_layout ){
			$meta_args['layout'] = $meta_layout;
		}
		
		$prop_elements = '';
		
		if( $map_stat == "property" || $map_stat == "property_map"  ):
			
			if( isset( $_POST['excerpt'] ) && $_POST['excerpt'] != '' ){
				$zpe::$cus_excerpt_len = absint( $_POST['excerpt'] );
			}else{
				$zpe::$cus_excerpt_len = 15;
			}
			
			$field = 'archive';
			
			if( !empty( $agent_id ) ){
				$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-items' );
				$field = 'archive-agent';
				$meta_args['agent'] = true;
				$meta_args['agent_page'] = isset( $_POST['agent_page'] ) && $_POST['agent_page'] != '' ? true : false;
			}else{
				$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
			}
			
			if( isset( $meta_args['prop_elements'] ) && !empty( $meta_args['prop_elements'] ) ){
				$prop_elements = $meta_args['prop_elements'];
			}else{
				$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
				if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
			}
			
			$col_class = 'col-lg-' . esc_attr( $cols );
			$col_class .= $cols != '12' ? ' col-md-6' : ''; 
			
			ob_start();
			$zpe->zoacresPropertiesArchive( $args, $prop_elements, $field, $col_class, $meta_args );
			$prop_list = ob_get_clean();
			
			// Store properties list to property_json variable
			$result['property_json'] = $prop_list;
			
			// Check next set of property found or not
			$result['property_eof'] = false;
			$args_ch = $args;
			$args_ch['paged'] = $paged + 1;
			$ch_query = new WP_Query( $args_ch );
			$next_set = $ch_query->found_posts;
			if( $next_set ){
				$result['property_eof'] = false;
			}else{
				$result['property_eof'] = true;
			}

			// Store map properties to map_json
			if( $map_stat == "property_map" ){
				
				$args['posts_per_page'] = absint( $ppp ) * $paged;
				$args['paged'] = 1;
				
				$map_array = $zpe->zoacresHalfMapProperties( $args, true );
				$extra_args = isset( $_POST['extra_args'] ) ? $_POST['extra_args'] : array();
				
				ob_start();
				$zpe->zoacresHalfMapPropertiesMakeMap( $map_array, $extra_args );
				$prop_maps = ob_get_clean();
				
				$result['map_json'] = $prop_maps;
			};
			
		elseif( $map_stat == "map" ):
			
			$map_array = $zpe->zoacresHalfMapProperties( $args );
			$extra_args = isset( $_POST['extra_args'] ) ? $_POST['extra_args'] : array();
			
			ob_start();
			$zpe->zoacresHalfMapPropertiesMakeMap( $map_array, $extra_args );
			$prop_maps = ob_get_clean();
			
			$result['map_json'] = $prop_maps;

		endif; //list	

		echo json_encode( $result );
		
		die();
			
	}
	add_action('wp_ajax_nopriv_zpropertygetting', 'zoacres_get_zpropertygetting');
	add_action('wp_ajax_zpropertygetting', 'zoacres_get_zpropertygetting');
}

if( ! function_exists('zoacres_get_filtered_property') ) {
	function zoacres_get_filtered_property(){
		
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-filter-ajax' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
		
		$property_elements = isset( $_POST['prop_args'] ) ? json_decode( stripslashes( $_POST['prop_args'] ), true ) : '';

		$result = array();
		
		if( $property_elements ){
			
			$filter = isset( $_POST['filter'] ) ? $_POST['filter'] : '';
			$ppp = isset( $_POST['ppp'] ) ? $_POST['ppp'] : '4';
			$paged = isset( $_POST['paged'] ) ? $_POST['paged'] : 1;
			
			$excerpt_length = isset( $_POST['excerpt_length'] ) ? $_POST['excerpt_length'] : '15';
			$prop_elements = isset( $property_elements['prop_elements'] ) ? $property_elements['prop_elements'] : array();
			$col_class = isset( $property_elements['col_class'] ) ? $property_elements['col_class'] : 'col-md-4';
			$meta_args = isset( $property_elements['meta_args'] ) ? $property_elements['meta_args'] : array();
			
			$col_class .= isset( $property_elements['animate_grid'] ) && $property_elements['animate_grid'] == 'on' ? ' zoacres-animate' : '';
			
			//Property Category
			if( $filter ){
				$property_cat = zoacres_explode_array( $filter );
				$type_tax_array = array(
					'taxonomy' => 'property-category',
					'field' => 'term_id',
					'terms' => $property_cat,
					'operator'=> 'IN'
				);
			}
			
			$zpe = new ZoacresPropertyElements();
			$zpe::$cus_excerpt_len = $excerpt_length;
			
			$args = array(
				'post_type' => 'zoacres-property',
				'posts_per_page' => absint( $ppp ),
				'paged' => $paged,
				'order' => 'DESC',
				'tax_query' => array(
					'relation' => 'AND',
					$type_tax_array				
				)					
			);
	
			ob_start();
			$zpe->zoacresPropertiesArchiveShortcode( $args, $prop_elements, 'archive', $col_class, $meta_args );
			$output .= ob_get_clean();
				
			$result['property_json'] = $output;//$output;
		
			echo json_encode( $result );
		}
		
		die();
		
	}
	add_action('wp_ajax_nopriv_filtered_property', 'zoacres_get_filtered_property');
	add_action('wp_ajax_filtered_property', 'zoacres_get_filtered_property');
}

//User Profile Update
if( ! function_exists('zoacres_profile_update_fun') ) {
	function zoacres_profile_update_fun(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-profile-update' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
	
		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
	
		$agent_position = isset( $_POST['agent_position'] ) ? $_POST['agent_position'] : '';
		$agent_description = isset( $_POST['agent_description'] ) ? $_POST['agent_description'] : '';
		$agent_address = isset( $_POST['agent_address'] ) ? $_POST['agent_address'] : '';
		$agent_mobile = isset( $_POST['agent_mobile'] ) ? $_POST['agent_mobile'] : '';
		$agent_skype = isset( $_POST['agent_skype'] ) ? $_POST['agent_skype'] : '';
		$agent_tele = isset( $_POST['agent_tele'] ) ? $_POST['agent_tele'] : '';
		$agent_website = isset( $_POST['agent_website'] ) ? $_POST['agent_website'] : '';
		$agent_experience = isset( $_POST['agent_experience'] ) ? $_POST['agent_experience'] : '';
		$agent_mlsid = isset( $_POST['agent_mlsid'] ) ? $_POST['agent_mlsid'] : '';
		$agent_lang = isset( $_POST['agent_lang'] ) ? $_POST['agent_lang'] : '';
		$agent_schedule = isset( $_POST['agent_schedule'] ) ? $_POST['agent_schedule'] : '';
		$agent_facebook = isset( $_POST['agent_facebook'] ) ? $_POST['agent_facebook'] : '';
		$agent_twitter = isset( $_POST['agent_twitter'] ) ? $_POST['agent_twitter'] : '';
		$agent_youtube = isset( $_POST['agent_youtube'] ) ? $_POST['agent_youtube'] : '';
		$agent_linkedin = isset( $_POST['agent_linkedin'] ) ? $_POST['agent_linkedin'] : '';
		$agent_instagram = isset( $_POST['agent_instagram'] ) ? $_POST['agent_instagram'] : '';
		$agent_no_photo = isset( $_POST['agent_no_photo'] ) ? $_POST['agent_no_photo'] : '';
		$agent_photo = isset( $_FILES["agent_photo"]["type"] ) ? $_FILES['agent_photo'] : '';
		
		if( $agent_no_photo ){
			$old_agent_image = get_post_meta( $agent_id, '_thumbnail_id', true );
			if( $old_agent_image ) wp_delete_attachment( $old_agent_image );
		}elseif( !empty( $agent_photo["type"] ) ){
			$old_agent_image = get_post_meta( $agent_id, '_thumbnail_id', true );
			if( $old_agent_image ) wp_delete_attachment( $old_agent_image );
			$attach_id = zoacres_insert_attachment( agent_photo, $agent_id, true );
		}
		
		$post_arr = array(
			'ID'           => absint( $agent_id ),
			'post_content' => wp_kses_post( $agent_description ),
			'meta_input'   => array(
				'zoacres_agent_position' => esc_html( $agent_position ),
				'zoacres_agent_mobile' => esc_attr( $agent_mobile ),
				'zoacres_agent_telephone' => esc_attr( $agent_tele ),
				'zoacres_agent_address' => wp_kses_post( $agent_address ),
				'zoacres_agent_skype' => esc_html( $agent_skype ),
				'zoacres_agent_website' => esc_url( $agent_website ),
				'zoacres_agent_experience' => esc_html( $agent_experience ),
				'zoacres_agent_languages' => esc_html( $agent_lang ),
				'zoacres_agent_mlsid' => esc_html( $agent_mlsid ),
				'zoacres_agent_schedule' => esc_html( $agent_schedule ),
				'zoacres_agent_fb_link' => esc_url( $agent_facebook ),
				'zoacres_agent_twitter_link' => esc_url( $agent_twitter ),
				'zoacres_agent_linkedin_link' => esc_url( $agent_linkedin ),				
				'zoacres_agent_yt_link' => esc_url( $agent_youtube ),
				'zoacres_agent_instagram_link' => esc_url( $agent_instagram )
			),
		);
		wp_update_post( $post_arr );

		echo 'success';
		die();	
		
	}
	add_action('wp_ajax_nopriv_zoacres_profile_update', 'zoacres_profile_update_fun');
	add_action('wp_ajax_zoacres_profile_update', 'zoacres_profile_update_fun');
}

//User Profile Update
if( ! function_exists('zoacres_password_update_fun') ) {
	function zoacres_password_update_fun(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-profile-update' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
	
		$current_user = wp_get_current_user();
		$agent_id = $current_user->ID;
	
		$old_pass = isset( $_POST['old_pass'] ) ? $_POST['old_pass'] : '';
		$new_pass = isset( $_POST['new_pass'] ) ? $_POST['new_pass'] : '';
		
		if ( $current_user && wp_check_password( $old_pass, $current_user->data->user_pass, $agent_id ) ){
			$update_user = wp_update_user( array ( 'ID' => $agent_id, 'user_pass' => $new_pass ) );
			if( $update_user ) {
				echo 'success';	
			}else{
				echo 'failed';
			}
		}else{
			echo 'mismatch';
		}
		die();	
		
	}
	add_action('wp_ajax_nopriv_zoacres_pswd_update', 'zoacres_password_update_fun');
	add_action('wp_ajax_zoacres_pswd_update', 'zoacres_password_update_fun');
}

//User Role Change from Subscriber to Agent/Agency
if( ! function_exists('zoacres_sunscriber_role_change') ) {
	function zoacres_sunscriber_role_change(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-role-change' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$role = isset( $_POST['role'] ) ? $_POST['role'] : '';
		
		$current_user = wp_get_current_user();
		
		if( $current_user ){
			$agent_email = $current_user->user_email;
			$display_name = $current_user->display_name;
			
			$post_arr = array(
				'post_author' => 1,
				'post_type'    => 'zoacres-agent',
				'post_title'   => esc_attr( $display_name ),
				'post_content' => '',
				'post_status'  => 'publish',
				'meta_input'   => array(
					'zoacres_agent_email' => esc_attr( $agent_email ),
					'zoacres_agent_type' => esc_attr( $role ),
				)
			);
			wp_insert_post( $post_arr );
		}
	
		$result = array();
		$result['result'] = 'success';//$output;
		echo json_encode( $result );
		
		die();	
		
	}
	add_action('wp_ajax_nopriv_zoacres_role_change', 'zoacres_sunscriber_role_change');
	add_action('wp_ajax_zoacres_role_change', 'zoacres_sunscriber_role_change');
}

//Agent panel properties list
if( ! function_exists('zoacres_agent_panel_properties') ) {
	function zoacres_agent_panel_properties(){
		
		$nonce = sanitize_text_field($_POST['nonce']);
	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-get-agent-properties' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
	
		$zpe = new ZoacresPropertyElements();
		$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-agent-propery-excerpt-len' );
		$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
		$zpe::$cus_excerpt_len = apply_filters( 'zoacres_agent_properties_excerpt_length', $arch_exc_len );
											
		$ppp = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-per-page' );
		$paged = isset( $_POST['paged'] ) && $_POST['paged'] != '' ? esc_attr( $_POST['paged'] ) : '1';
		
		$meta_qry = array();

		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
		$meta_qry[0] = array(
			'key'     => 'zoacres_property_agent_id',
			'value'   => esc_attr( $agent_id ),
			'compare' => '='
		);
	
		$args = array(
			'post_type' => 'zoacres-property',
			'posts_per_page' => absint( $ppp ),
			'paged' => absint( $paged ),
			'order'   => 'DESC',
			'meta_query' => $meta_qry
		);
		
		//Load More Check
		$cargs = $args;
		$cpaged = isset( $cargs['paged'] ) && $cargs['paged'] != '' ? absint( $cargs['paged'] ) : '1';
		$cargs['paged'] = ++$cpaged;
		$query = new WP_Query( $cargs );
		$found_posts = $query->found_posts;
		$load_more_class = '';
		if( !$found_posts ) :
			$load_more_class = ' d-hide';
		endif;
	
		$cols = '4';
		$property_cols = 'col-lg-' . $cols;
		$property_cols .= $cols != '12' ? ' col-md-6' : ''; 
		$prop_ani = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-animation' );
		$prop_ani = $prop_ani ? true : false;
		ob_start();
	?>
	
		<div class="map-property-list" data-cols="<?php echo esc_attr( $cols ); ?>" data-layout="grid" data-ppp="<?php echo esc_attr( $ppp ); ?>" data-animation="<?php echo esc_attr( $prop_ani ); ?>">
			<?php
		
				$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-items' );
				$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
				if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
				
				$meta_args = array(
					'agent' => true,
					'layout' => 'grid',
					'animation' => esc_attr( $prop_ani )
				);

				$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive-agent', $property_cols, $meta_args );
				
			?>
			<div class="property-load-more-wrap text-center<?php echo esc_attr( $load_more_class ); ?>">
				<div class="property-load-more-inner">
					<a href="#" class="btn btn-default property-load-more" data-page="2"><?php esc_html_e( 'Load More', 'zoacres' ); ?></a>
					<?php
						$infinite = $zpe->zoacresPropertyThemeOpt( "infinite-loader-img" );
						$infinite_image = isset( $infinite['url'] ) && $infinite['url'] != '' ? $infinite['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
					?>
					<img src="<?php echo esc_url( $infinite_image ); ?>" class="img-fluid property-loader" alt="<?php esc_attr_e( 'Loader', 'zoacres' ); ?>" />
				</div>	
			</div>
			
		</div> <!-- .map-property-list -->
		<?php
		$output = ob_get_clean();
		
		$result = array();
		$result['result'] = $output;//$output;
		echo json_encode( $result );
		
		die();	
	}
	add_action('wp_ajax_nopriv_zoacres_agent_prop', 'zoacres_agent_panel_properties');
	add_action('wp_ajax_zoacres_agent_prop', 'zoacres_agent_panel_properties');
}

/* Get Favourite Properties by Author */
if( ! function_exists('zoacres_get_favourite_properties') ) {
	function zoacres_get_favourite_properties(){

		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-get-property-favourite' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$zpe = new ZoacresPropertyElements();
		
		$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-agent-propery-excerpt-len' );
		$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
		$zpe::$cus_excerpt_len = apply_filters( 'zoacres_agent_favorites_excerpt_length', $arch_exc_len );

		$author_id = get_current_user_id();
		
		$ppp = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-per-page' );
		$paged = isset( $_POST['paged'] ) && $_POST['paged'] != '' ? esc_attr( $_POST['paged'] ) : '1';
		$prop_list = '';
		
		if( $author_id ){
		
			$fav_array = get_user_meta( $author_id, 'zoacres_favourite_properties', true );
			if( isset( $fav_array ) && is_array( $fav_array ) ){

				$args = array(
					'post_type' => 'zoacres-property',
					'posts_per_page' => absint( $ppp ),
					'paged' => absint( $paged ),
					'order'   => 'DESC',
					'post__in' => $fav_array
				);
				
				//Load More Check
				$cargs = $args;
				$cpaged = isset( $cargs['paged'] ) && $cargs['paged'] != '' ? absint( $cargs['paged'] ) : '1';
				$cargs['paged'] = ++$cpaged;
				$query = new WP_Query( $cargs );
				$found_posts = $query->found_posts;
				$load_more_class = '';
				if( !$found_posts ) :
					$load_more_class = ' d-hide';
				endif;
			
				$cols = '6';
				$property_cols = 'col-lg-' . $cols;
				$property_cols .= $cols != '12' ? ' col-md-6' : ''; 
				$prop_ani = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-animation' );
				$prop_ani = $prop_ani ? true : false;
				ob_start();
			?>
			
				<div class="map-property-list" data-cols="<?php echo esc_attr( $cols ); ?>" data-layout="grid" data-ppp="<?php echo esc_attr( $ppp ); ?>" data-animation="<?php echo esc_attr( $prop_ani ); ?>">
					<?php
				
						$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-items' );
						$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
						if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
						
						$meta_args = array(
							'agent' => true,
							'layout' => 'grid',
							'animation' => esc_attr( $prop_ani ),
							'img_size' => 'medium'
						);
		
						$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive-agent', $property_cols, $meta_args );
						
					?>
					<div class="property-load-more-wrap text-center<?php echo esc_attr( $load_more_class ); ?>">
						<div class="property-load-more-inner">
							<a href="#" class="btn btn-default property-fav-load-more" data-page="2"><?php esc_html_e( 'Load More', 'zoacres' ); ?></a>
							<?php
								$infinite = $zpe->zoacresPropertyThemeOpt( "infinite-loader-img" );
								$infinite_image = isset( $infinite['url'] ) && $infinite['url'] != '' ? $infinite['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
							?>
							<img src="<?php echo esc_url( $infinite_image ); ?>" class="img-fluid property-loader" alt="<?php esc_attr_e( 'Loader', 'zoacres' ); ?>" />
						</div>	
					</div>
					
				</div> <!-- .map-property-list -->
				<?php
				$output = ob_get_clean();
				
				$args['paged'] = absint( ++$paged );
				$next_query = new WP_Query( $args );
				$prop_list = $next_query->found_posts;

			}

		}else{
			$output = 'none';
		}
		
		$result = array();
		$result['property_eof'] = false;
		$result['property_json'] = $output;
		if( $prop_list ){
			$result['property_eof'] = false;
		}else{
			$result['property_eof'] = true;
		}
		
		echo json_encode( $result );
		
		die();
	}
	add_action('wp_ajax_nopriv_zoacres_agent_fav_prop', 'zoacres_get_favourite_properties');
	add_action('wp_ajax_zoacres_agent_fav_prop', 'zoacres_get_favourite_properties');
}

/* Set Saved Search */
if( ! function_exists('zoacres_set_saved_search') ) {
	function zoacres_set_saved_search(){
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-set-saved-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$author_id = get_current_user_id();
		$saved_search = isset( $_POST['saved_search'] ) && !empty( $_POST['saved_search'] ) ? $_POST['saved_search'] : '';
		$saved_search = $saved_search ? json_encode( $saved_search ) : '';
		
		$output = '';
		$saved_array = get_user_meta( $author_id, 'zoacres_saved_searches', true );
		if( isset( $saved_array ) && is_array( $saved_array ) ){

			if ( !in_array( $saved_search, $saved_array ) ){
				array_push( $saved_array, $saved_search );
				update_user_meta( $author_id, 'zoacres_saved_searches', $saved_array );
				$output = 'success';
			}else{
				$output = 'exists';
			}

		}else{
			$s_array = array( $saved_search );
			update_user_meta( $author_id, 'zoacres_saved_searches', $s_array );
			$output = 'success';
		}
		
		$result = array();
		$result['status'] = $output;
		echo json_encode( $result );
		die();
			
	}
	add_action('wp_ajax_nopriv_zosave_search', 'zoacres_set_saved_search');
	add_action('wp_ajax_zosave_search', 'zoacres_set_saved_search');
}

if( ! function_exists('zoacres_get_agent_post_count') ) {
	function zoacres_get_agent_post_count( $agent_id ){
		$query = new WP_Query( array( 'post_type' => 'zoacres-property', 'post_status' => 'publish', 'meta_key' => 'zoacres_property_agent_id', 'meta_value' => $agent_id ) );
		return $query->found_posts;
	}
}

if( ! function_exists('zoacres_get_agent_featured_count') ) {
	function zoacres_get_agent_featured_count( $agent_id ){
		$args = array(
			'post_type' => 'zoacres-property',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => 'zoacres_property_agent_id',
					'value'   => $agent_id,
					'compare' => '=',
				),
				array(
					'key'     => 'zoacres_post_featured_stat',
					'value'   => true,
					'compare' => '=',
				)
			)
			
		);
		$query = new WP_Query( $args );
		return $query->found_posts;
	}
}

//Property Documents Upload
if( ! function_exists('zoacres_docs_upload') ) {
	function zoacres_docs_upload(){

		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-docs-upload' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
			
		$result = array();
		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
		$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
		$agent_eligible = zoacres_agent_eligible_check( $last_pack, $current_user->ID, $agent_email );
		if( !$agent_eligible ){
			$result['status'] = 'not eligible';
			echo json_encode( $result );
			die();
		}
		
		//This is for property edit only
		$docs_ids = isset( $_POST['docs_last'] ) ? $_POST['docs_last'] : '';	  
		if( $docs_ids ){
			$docs_ids = rtrim( $docs_ids, "," );
			$docs_ids = explode( ",", $docs_ids );
			foreach( $docs_ids as $doc_id ){
				wp_delete_attachment( $doc_id, true );
			}
		}
		
		$valid_formats = array( "pdf", "doc", "docx" ); // Supported file types
		$max_file_size = 1024 * 2000 ; // in kb max file size 2MB
		$wp_upload_dir = wp_upload_dir();
		$path = $wp_upload_dir['path'] . '/';
		$count = 0;
		
		$attach_ids = array();
		$req_method = class_exists( "ZoacresRedux" ) ? zoacres_get_request_method() : '';
		// Image upload handler
		if( $req_method == "POST" ){
			
			// Check if user is trying to upload more than the allowed number of images for the current post
			$docs_count = count( $_FILES['files']['name'] );
				
			foreach ( $_FILES['files']['name'] as $f => $name ) {
				$extension = pathinfo( $name, PATHINFO_EXTENSION );
				// Generate a randon code for each file name
				$new_filename = $name;
				
				if ( $_FILES['files']['error'][$f] == 4 ) {
					continue; 
				}
				
				if ( $_FILES['files']['error'][$f] == 0 ) {
					// Check if image size is larger than the allowed file size
					if ( $_FILES['files']['size'][$f] > $max_file_size ) {
						$upload_message[] = "$name is too large!.";
						continue;
					
					// Check if the file being uploaded is in the allowed file types
					} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
						$upload_message[] = "$name is not a valid format";
						continue; 
					
					} else{ 
						// If no errors, upload the file...
						
						$t_filename = $new_filename;
						$i = 0;
						while( file_exists( $path.$t_filename ) ){
							$t_fname = preg_replace( '/\.[^.]+$/', '', basename( $t_filename ) );
							$i++;
							$last2chars = substr( $t_fname, -2 ); 
							if( $last2chars[0] == '-' && ( isset( $last2chars[1] ) && is_numeric( $last2chars[1] ) ) ){
								$num_char = $last2chars[1];
								$num_char++;
								$t_fname = substr( $t_fname, 0, -2 );
								$t_filename = $t_fname . '-' . $num_char .'.'. $extension;
							}else{
								$t_filename = $t_fname . '-' . $i .'.'. $extension;
							}
						}
						
						if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$t_filename ) ) {
							
							$count++; 

							$filename = $path.$t_filename;
							$filetype = wp_check_filetype( basename( $filename ), null );
							$wp_upload_dir = wp_upload_dir();
							$attachment = array(
								'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
								'post_mime_type' => $filetype['type'],
								'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
								'post_content'   => '',
								'post_status'    => 'inherit'
							);
							// Insert attachment to the database
							$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
							array_push( $attach_ids, $attach_id );

							require_once ABSPATH . 'wp-admin/includes/image.php';
							
							// Generate meta data
							$attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
							wp_update_attachment_metadata( $attach_id, $attach_data );
							
						}
					}
				}
			}
			//
		}
		

		// Loop through each error then output it to the screen
		if ( isset( $upload_message ) ) :
			foreach ( $upload_message as $msg ){        
				$result['msg'] = $msg .' | ';
			}
		endif;
		
		// If no error, show success message
		if( $count != 0 ){
			$result['doc_ids'] = implode( ",", $attach_ids );
		}
		echo json_encode( $result );
		die();
	}
	add_action('wp_ajax_nopriv_zoacres_docs_upload', 'zoacres_docs_upload');
	add_action('wp_ajax_zoacres_docs_upload', 'zoacres_docs_upload');
}

if( ! function_exists('zoacres_img_test') ) {
	function zoacres_img_test(){

		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-img-test' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
			
		$result = array();
		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
		$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
		$agent_eligible = zoacres_agent_eligible_check( $last_pack, $current_user->ID, $agent_email );
		if( !$agent_eligible ){
			$result['status'] = 'not eligible';
			echo json_encode( $result );
			die();
		}
		
		//This is for property edit only
		$image_ids = isset( $_POST['gallery_last'] ) ? $_POST['gallery_last'] : '';	  
		if( $image_ids ){
			$image_ids = rtrim( $image_ids, "," );
			$image_ids = explode( ",", $image_ids );
			foreach( $image_ids as $image_id ){
				wp_delete_attachment( $image_id, true );
			}
		}
		
		$valid_formats = array( "jpg", "png", "gif", "bmp", "jpeg" ); // Supported file types
		$max_file_size = 1024 * 500; // in kb
		$wp_upload_dir = wp_upload_dir();
		$path = $wp_upload_dir['path'] . '/';
		$count = 0;
		
		$attach_ids = array();
		$req_method = class_exists( "ZoacresRedux" ) ? zoacres_get_request_method() : '';
		// Image upload handler
		if( $req_method == "POST" ){
			
			// Check if user is trying to upload more than the allowed number of images for the current post
			$image_count = count( $_FILES['files']['name'] );
			$gallery_eligible = zoacres_agent_gallery_eligible_check( $last_pack, $image_count );
			
			if( !$gallery_eligible ){
				$result['img_id'] = '';
				$result['status'] = 'limit overflow';
				echo json_encode( $result );
				die();
			}else {
				
				foreach ( $_FILES['files']['name'] as $f => $name ) {
					$extension = pathinfo( $name, PATHINFO_EXTENSION );
					// Generate a randon code for each file name
					$new_filename = $name;
					
					if ( $_FILES['files']['error'][$f] == 4 ) {
						continue; 
					}
					
					if ( $_FILES['files']['error'][$f] == 0 ) {
						// Check if image size is larger than the allowed file size
						if ( $_FILES['files']['size'][$f] > $max_file_size ) {
							$upload_message[] = "$name is too large!.";
							continue;
						
						// Check if the file being uploaded is in the allowed file types
						} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
							$upload_message[] = "$name is not a valid format";
							continue; 
						
						} else{ 
							// If no errors, upload the file...
							
							$t_filename = $new_filename;
							$i = 0;
							while( file_exists( $path.$t_filename ) ){
								$t_fname = preg_replace( '/\.[^.]+$/', '', basename( $t_filename ) );
								$i++;
								$last2chars = substr( $t_fname, -2 ); 
								if( $last2chars[0] == '-' && ( isset( $last2chars[1] ) && is_numeric( $last2chars[1] ) ) ){
									$num_char = $last2chars[1];
									$num_char++;
									$t_fname = substr( $t_fname, 0, -2 );
									$t_filename = $t_fname . '-' . $num_char .'.'. $extension;
								}else{
									$t_filename = $t_fname . '-' . $i .'.'. $extension;
								}
							}
							
							if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$t_filename ) ) {
								
								$count++; 
	
								$filename = $path.$t_filename;
								$filetype = wp_check_filetype( basename( $filename ), null );
								$wp_upload_dir = wp_upload_dir();
								$attachment = array(
									'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
									'post_mime_type' => $filetype['type'],
									'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
									'post_content'   => '',
									'post_status'    => 'inherit'
								);
								// Insert attachment to the database
								$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
								array_push( $attach_ids, $attach_id );
	
								require_once ABSPATH . 'wp-admin/includes/image.php';
								
								// Generate meta data
								$attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
								wp_update_attachment_metadata( $attach_id, $attach_data );
								
							}
						}
					}
				}
			}
		}
		

		// Loop through each error then output it to the screen
		if ( isset( $upload_message ) ) :
			foreach ( $upload_message as $msg ){        
				$result['msg'] = $msg .' | ';
			}
		endif;
		
		// If no error, show success message
		if( $count != 0 ){
			$result['img_id'] = implode( ",", $attach_ids );
		}
		echo json_encode( $result );
		die();
	}
	add_action('wp_ajax_nopriv_zoacres_img_test', 'zoacres_img_test');
	add_action('wp_ajax_zoacres_img_test', 'zoacres_img_test');
}

if( ! function_exists('zoacres_property_featured_img') ) {
	function zoacres_property_featured_img(){
		
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-img-test' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();

		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
		$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
		$agent_eligible = zoacres_agent_eligible_check( $last_pack, $current_user->ID, $agent_email );
		$image_count = isset( $_POST['gal_count'] ) ? $_POST['gal_count'] : '';
		$gallery_eligible = $image_count ? zoacres_agent_gallery_eligible_check( $last_pack, $image_count ) : true;
		
		if( !$agent_eligible ){
			$result['img_id'] = '';
			$result['msg'] = 'not eligible';
			echo json_encode( $result );
			die();
		}elseif( !$gallery_eligible ){
			$result['img_id'] = '';
			$result['status'] = 'limit overflow';
			echo json_encode( $result );
			die();
		}
		
		//This is for property edit only
		$img_id = isset( $_POST['images_last'] ) ? esc_attr( $_POST['images_last'] ) : '';
		if( $img_id ) wp_delete_attachment( $img_id );
		
		
		$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
		$max_file_size = 1024 * 500; // in kb
		$max_image_upload = 1; //Define how many images can be uploaded to the current post
		$wp_upload_dir = wp_upload_dir();
		$path = $wp_upload_dir['path'] . '/';
		$count = 0;
		
		$attach_id = '';
		$req_method = class_exists( "ZoacresRedux" ) ? zoacres_get_request_method() : '';
		// Image upload handler
		if( $req_method == "POST" ){

			$extension = pathinfo( $_FILES['files']['name'], PATHINFO_EXTENSION );
			// Generate a randon code for each file name
			$new_filename = $_FILES['files']['name'];
			
			if ( $_FILES['files']['error'] == 4 ) {
				$upload_message[] = "$name file error!.";
			}
			
			if ( $_FILES['files']['error'] == 0 ) {
				// Check if image size is larger than the allowed file size
				if ( $_FILES['files']['size'] > $max_file_size ) {
					$upload_message[] = "$name is too large!.";
				
				// Check if the file being uploaded is in the allowed file types
				} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
					$upload_message[] = "$name is not a valid format";
				
				} else{ 
					// If no errors, upload the file...
					
					$t_filename = $new_filename;
					$i = 0;
					while( file_exists( $path.$t_filename ) ){
						$t_fname = preg_replace( '/\.[^.]+$/', '', basename( $t_filename ) );
						$i++;
						$last2chars = substr( $t_fname, -2 ); 
						if( $last2chars[0] == '-' && ( isset( $last2chars[1] ) && is_numeric( $last2chars[1] ) ) ){
							$num_char = $last2chars[1];
							$num_char++;
							$t_fname = substr( $t_fname, 0, -2 );
							$t_filename = $t_fname . '-' . $num_char .'.'. $extension;
						}else{
							$t_filename = $t_fname . '-' . $i .'.'. $extension;
						}
					}
					
					if( move_uploaded_file( $_FILES["files"]["tmp_name"], $path.$t_filename ) ) {
						
						$count++; 

						$filename = $path.$t_filename;
						$filetype = wp_check_filetype( basename( $filename ), null );
						$wp_upload_dir = wp_upload_dir();
						$attachment = array(
							'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);
						// Insert attachment to the database
						$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

						require_once ABSPATH . 'wp-admin/includes/image.php';
						
						// Generate meta data
						$attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
						wp_update_attachment_metadata( $attach_id, $attach_data );
						
					}
				}
			}

		}
		
		
		// Loop through each error then output it to the screen
		if ( isset( $upload_message ) ) :
			foreach ( $upload_message as $msg ){        
				$result['msg'] = $msg;
			}
		endif;
		
		// If no error, show success message
		if( $count != 0 ){
			$result['img_id'] = $attach_id;
		}
		echo json_encode( $result );
		die();
		
	}
	add_action('wp_ajax_nopriv_zoacres_ftr_img', 'zoacres_property_featured_img');
	add_action('wp_ajax_zoacres_ftr_img', 'zoacres_property_featured_img');
}

if( ! function_exists('zoacres_property_featured_img_remove') ) {
	function zoacres_property_featured_img_remove(){
		$nonce = sanitize_text_field($_POST['nonce']);	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-img-test' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$img_id = isset( $_POST['img_id'] ) ? esc_attr( $_POST['img_id'] ) : '';
		if( $img_id ) wp_delete_attachment( $img_id );
			
		$result = array();
		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
			
	}
	add_action('wp_ajax_nopriv_zoacres_ftr_img_remove', 'zoacres_property_featured_img_remove');
	add_action('wp_ajax_zoacres_ftr_img_remove', 'zoacres_property_featured_img_remove');
}

/* Create New Property */
if( ! function_exists('zoacres_insert_new_property') ) {
	function zoacres_insert_new_property(){

		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-add-new-property' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();

		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
		$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
		$agent_eligible = zoacres_agent_eligible_check( $last_pack, $current_user->ID, $agent_email );
		if( !$agent_eligible ){
			$result['msg'] = $agent_eligible;
			echo json_encode( $result );
			die();
		}
			
		$property_title = isset( $_POST['property_title'] ) ? $_POST['property_title'] : '';
		$property_content = isset( $_POST['property_desc'] ) ? $_POST['property_desc'] : '';
		$featured_img_id = isset( $_POST['property_image_final'] ) ? $_POST['property_image_final'] : '';
		$gallery_ids = isset( $_POST['property_gallery_image_final'] ) ? $_POST['property_gallery_image_final'] : '';
		
		$property_address = isset( $_POST['property_address'] ) ? $_POST['property_address'] : '';
		$property_price = isset( $_POST['property_price'] ) ? $_POST['property_price'] : '';
		$property_price_before = isset( $_POST['property_price_before'] ) ? $_POST['property_price_before'] : '';
		$property_price_after = isset( $_POST['property_price_after'] ) ? $_POST['property_price_after'] : '';
		$property_virtual_tour = isset( $_POST['property_virtual_tour'] ) ? $_POST['property_virtual_tour'] : '';
		
		$property_size = isset( $_POST['property_size'] ) ? $_POST['property_size'] : '';
		$property_lot_size = isset( $_POST['property_lot_size'] ) ? $_POST['property_lot_size'] : '';
		$property_no_rooms = isset( $_POST['property_no_rooms'] ) ? $_POST['property_no_rooms'] : '';
		$property_no_bed_rooms = isset( $_POST['property_no_bed_rooms'] ) ? $_POST['property_no_bed_rooms'] : '';
		$property_no_bath_rooms = isset( $_POST['property_no_bath_rooms'] ) ? $_POST['property_no_bath_rooms'] : '';
		$property_no_garages = isset( $_POST['property_no_garages'] ) ? $_POST['property_no_garages'] : '';
		$property_zip = isset( $_POST['property_zip'] ) ? $_POST['property_zip'] : '';
		
		$property_structures = isset( $_POST['property_structures'] ) ? $_POST['property_structures'] : '';
		$property_map_latitude = isset( $_POST['property_map_latitude'] ) ? $_POST['property_map_latitude'] : '';
		$property_map_longitude = isset( $_POST['property_map_longitude'] ) ? $_POST['property_map_longitude'] : '';
		$property_video_type = isset( $_POST['property_video_type'] ) ? $_POST['property_video_type'] : '';
		$property_video_id = isset( $_POST['property_video_id'] ) ? $_POST['property_video_id'] : '';
		$property_ribbons = isset( $_POST['property_ribbons'] ) ? $_POST['property_ribbons'] : '';
		$property_360_image = isset( $_POST['property_360_image_final'] ) ? $_POST['property_360_image_final'] : '';
		$property_documents = isset( $_POST['property_docs_file_final'] ) ? $_POST['property_docs_file_final'] : '';
		
		$plan_ids = isset( $_POST['property_plan_ids'] ) ? $_POST['property_plan_ids'] : '';

		$zpe = new ZoacresPropertyElements();
		$property_cf = $zpe->zoacresPropertyThemeOpt( 'property-custom-fields' );
		$property_cf = json_decode( $property_cf, true );
		
		$user = get_user_by( 'email', $agent_email );
		$user_roles = $user->roles;
		$is_admin_role = false;
		$property_active_status = 'inactive';
		if( in_array( 'administrator', $user_roles, true ) ) {
			$is_admin_role = true;
			$property_active_status = 'active';
		}
								
		$meta_array = array(
			'zoacres_property_active_status' => $property_active_status,
			'zoacres_property_agent_id' => $agent_id,
			'zoacres_property_address' => wp_slash( nl2br( $property_address ) ),
			'zoacres_property_zip' => $property_zip,
			'zoacres_property_status' => $property_ribbons,
			'zoacres_property_price' => $property_price,
			'zoacres_property_before_price_label' => $property_price_before,
			'zoacres_property_after_price_label' => $property_price_after,
			'zoacres_property_size' => $property_size,
			'zoacres_property_lot_size' => $property_lot_size,
			'zoacres_property_structures' => $property_structures,
			'zoacres_property_no_rooms' => $property_no_rooms,
			'zoacres_property_no_bed_rooms' => $property_no_bed_rooms,
			'zoacres_property_no_bath_rooms' => $property_no_bath_rooms,
			'zoacres_property_no_garages' => $property_no_garages,
			'zoacres_property_video_type' => $property_video_type,
			'zoacres_property_gallery' => $gallery_ids,
			'zoacres_property_vitual_tour' => $property_virtual_tour,
			'zoacres_property_360_image' => $property_360_image,
			'zoacres_property_latitude' => $property_map_latitude,
			'zoacres_property_longitude' => $property_map_longitude,
			'zoacres_property_documents' => $property_documents
		);		
		
		//Property Features
		$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
		if( $property_features ):
			$property_features_arr = zoacres_trim_array_same_values( $property_features );
			foreach ( $property_features_arr as $value => $label ){
				$fld_key = str_replace("-","_", sanitize_title( $value ) );
				$field_value = isset( $_POST['property_features_'.$fld_key] ) ? $_POST['property_features_'.$fld_key] : '';
				$meta_array['zoacres_property_features_'. sanitize_title( $value )] = $field_value;
			}
		endif;
		
		//Property Custom Fields
		if( $property_cf ):
			foreach( $property_cf as $fields ){
				$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
				$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
				$cf_val = isset( $_POST['zoacres_property_custom_'.$fld_id] ) ? $_POST['zoacres_property_custom_'.$fld_id] : '';
				$meta_array['zoacres_property_custom_'.$fld_id] = $cf_val;
			}
		endif;
		
		//Property Plan Values
		$plan_ids = explode( ",", $plan_ids );
		$floor_plans = array();
		foreach( $plan_ids as $plan_id ){
			$plan_image = isset( $_POST['property_plan_image_final_'.$plan_id] ) ? $_POST['property_plan_image_final_'.$plan_id] : '';
			$plan_title = isset( $_POST['property_plan_title_'.$plan_id] ) ? $_POST['property_plan_title_'.$plan_id] : '';
			$plan_size = isset( $_POST['property_plan_size_'.$plan_id] ) ? $_POST['property_plan_size_'.$plan_id] : '';
			$plan_rooms = isset( $_POST['property_plan_rooms_'.$plan_id] ) ? $_POST['property_plan_rooms_'.$plan_id] : '';
			$plan_bathrooms = isset( $_POST['property_plan_bathrooms_'.$plan_id] ) ? $_POST['property_plan_bathrooms_'.$plan_id] : '';
			$plan_desc = isset( $_POST['property_plan_desc_'.$plan_id] ) ? $_POST['property_plan_desc_'.$plan_id] : '';
			$plan_price = isset( $_POST['property_plan_price_'.$plan_id] ) ? $_POST['property_plan_price_'.$plan_id] : '';
		
			$t_flr_plans = array(
				'plan_image' => $plan_image,
				'plan_title' => $plan_title,
				'plan_size' => $plan_size,
				'plan_rooms' => $plan_rooms,
				'plan_bathrooms' => $plan_bathrooms,
				'plan_desc' => $plan_desc,
				'plan_price' => $plan_price
			);
			
			array_push( $floor_plans, $t_flr_plans );
		}
		
		$meta_array['zoacres_property_floor_palns'] = $floor_plans;
		$meta_array = apply_filters( 'zoacres_property_add_meta_array', $meta_array );
		
		$property_category = isset( $_POST['property_category'] ) ? $_POST['property_category'] : '';
		$property_action = isset( $_POST['property_action'] ) ? $_POST['property_action'] : '';
		$property_area = isset( $_POST['property_area'] ) ? $_POST['property_area'] : '';
		$property_city = isset( $_POST['property_city'] ) ? $_POST['property_city'] : '';
		$property_state = isset( $_POST['property_state'] ) ? $_POST['property_state'] : '';
		$property_country = isset( $_POST['property_country'] ) ? $_POST['property_country'] : '';
				
		$post_data = array(
			'post_type' => 'zoacres-property',
			'post_title'   => esc_html( $property_title ),
			'post_content' => wp_slash( $property_content ),
			'post_status'  => 'publish',
			'post_author'   => 1,
			'zoacres_property_property-category' => $property_category,
			'meta_input'   => $meta_array,
		);

		

		$post_id = wp_insert_post( $post_data );
		
		global $wpdb;
		if( !$is_admin_role ) {
			$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
		}
		
		
		if( $featured_img_id ){
			$featured_img_stat = set_post_thumbnail( $post_id, $featured_img_id );
		}
		
		// Set Property Category
		if( $property_category ){
			$cat_ids = array_map( 'intval', $property_category );
			$cat_ids = array_unique( $cat_ids );
			wp_set_object_terms( $post_id, $cat_ids, 'property-category' );
		}
		
		// Set Property Action
		if( $property_action ){
			$action_ids = array_map( 'intval', $property_action );
			$action_ids = array_unique( $action_ids );
			wp_set_object_terms( $post_id, $action_ids, 'property-action' );
		}
		
		// Set Property Area
		if( $property_area ){
			$area_ids = array_map( 'intval', $property_area );
			$area_ids = array_unique( $area_ids );
			wp_set_object_terms( $post_id, $area_ids, 'property-area' );
		}
		
		// Set Property City
		if( $property_city ){
			$city_ids = array_map( 'intval', $property_city );
			$city_ids = array_unique( $city_ids );
			wp_set_object_terms( $post_id, $city_ids, 'property-city' );
		}
		
		// Set Property State
		if( $property_state ){
			$state_ids = array_map( 'intval', $property_state );
			$state_ids = array_unique( $state_ids );
			wp_set_object_terms( $post_id, $state_ids, 'property-state' );
		}
		
		// Set Property Country
		if( $property_state ){
			$country_ids = array_map( 'intval', $property_country );
			$country_ids = array_unique( $country_ids );
			wp_set_object_terms( $post_id, $country_ids, 'property-country' );
		}
		
		// store message for user inbox
		$msg = wp_sprintf( esc_html__( 'Hi, &#34;%1$s&#34; Property added successfully and waiting for approval.', 'zoacres' ), esc_html( $property_title ) );
		$process_datetime = time(); 
		$user_inbox_msg = get_user_meta( $current_user->ID, 'zoacres_user_messages', true );
		if( !empty( $user_inbox_msg ) && is_array( $user_inbox_msg ) ){
			$user_inbox_msg[$process_datetime] = array( 'msg' => $msg, 'vstat' => false );
		}else{
			$user_inbox_msg = array(
				$process_datetime => array( 'msg' => $msg, 'vstat' => false )
			);
		}
		$updated = update_user_meta( $current_user->ID, 'zoacres_user_messages', $user_inbox_msg );

		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
			
	}
	add_action('wp_ajax_nopriv_zoacres_add_new_property', 'zoacres_insert_new_property');
	add_action('wp_ajax_zoacres_add_new_property', 'zoacres_insert_new_property');
}

/* Update Property */
if( ! function_exists('zoacres_update_property') ) {
	function zoacres_update_property(){

		$nonce = sanitize_text_field($_POST['nonce']);  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-add-new-property' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$result = array();

		//Check Valid Property
		$current_user = wp_get_current_user();
		$agent_email = $current_user->user_email;
		$property_id = isset( $_POST['user_property_id'] ) ? $_POST['user_property_id'] : '';
		$stat = 0;
		if( $property_id ){
			$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );	
			$args = array(
				'post_type'  => 'zoacres-property',
				'post__in'   => array( $property_id ),
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'zoacres_property_agent_id',
						'value'   => $agent_id,
						'compare' => '=',
					),
				)
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				$stat = 1;
				wp_reset_postdata();
			}
		}else{
			$stat = 0;
			$result['msg'] = "invalid property";
			echo json_encode( $result );
			die();
		}
		
		if( $stat ):

			$current_user = wp_get_current_user();
			$agent_email = $current_user->user_email;
			$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
			$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
			$agent_eligible = zoacres_agent_eligible_check( $last_pack, $current_user->ID, $agent_email );
			if( !$agent_eligible ){
				$result['msg'] = $agent_eligible;
				echo json_encode( $result );
				die();
			}
	
			$property_title = isset( $_POST['property_title'] ) ? $_POST['property_title'] : '';
			$property_content = isset( $_POST['property_desc'] ) && !empty( $_POST['property_desc'] ) ? stripslashes( $_POST['property_desc'] ) : '';
			$featured_img_id = isset( $_POST['property_image_final'] ) ? $_POST['property_image_final'] : '';
			$gallery_ids = isset( $_POST['property_gallery_image_final'] ) ? $_POST['property_gallery_image_final'] : '';
			
			$property_address = isset( $_POST['property_address'] ) ? $_POST['property_address'] : '';
			$property_price = isset( $_POST['property_price'] ) ? $_POST['property_price'] : '';
			$property_price_before = isset( $_POST['property_price_before'] ) ? $_POST['property_price_before'] : '';
			$property_price_after = isset( $_POST['property_price_after'] ) ? $_POST['property_price_after'] : '';
			$property_virtual_tour = isset( $_POST['property_virtual_tour'] ) ? $_POST['property_virtual_tour'] : '';
			
			$property_size = isset( $_POST['property_size'] ) ? $_POST['property_size'] : '';
			$property_lot_size = isset( $_POST['property_lot_size'] ) ? $_POST['property_lot_size'] : '';
			$property_no_rooms = isset( $_POST['property_no_rooms'] ) ? $_POST['property_no_rooms'] : '';
			$property_no_bed_rooms = isset( $_POST['property_no_bed_rooms'] ) ? $_POST['property_no_bed_rooms'] : '';
			$property_no_bath_rooms = isset( $_POST['property_no_bath_rooms'] ) ? $_POST['property_no_bath_rooms'] : '';
			$property_no_garages = isset( $_POST['property_no_garages'] ) ? $_POST['property_no_garages'] : '';
			$property_zip = isset( $_POST['property_zip'] ) ? $_POST['property_zip'] : '';
			
			$property_structures = isset( $_POST['property_structures'] ) ? $_POST['property_structures'] : '';
			$property_map_latitude = isset( $_POST['property_map_latitude'] ) ? $_POST['property_map_latitude'] : '';
			$property_map_longitude = isset( $_POST['property_map_longitude'] ) ? $_POST['property_map_longitude'] : '';
			$property_video_type = isset( $_POST['property_video_type'] ) ? $_POST['property_video_type'] : '';
			$property_video_id = isset( $_POST['property_video_id'] ) ? $_POST['property_video_id'] : '';
			$property_ribbons = isset( $_POST['property_ribbons'] ) ? $_POST['property_ribbons'] : '';
			$property_360_image = isset( $_POST['property_360_image_final'] ) ? $_POST['property_360_image_final'] : '';
			$property_documents = isset( $_POST['property_docs_file_final'] ) ? $_POST['property_docs_file_final'] : '';
			
			$plan_ids = isset( $_POST['property_plan_ids'] ) ? $_POST['property_plan_ids'] : '';
	
			$zpe = new ZoacresPropertyElements();
			$property_cf = $zpe->zoacresPropertyThemeOpt( 'property-custom-fields' );
			$property_cf = json_decode( $property_cf, true );
									
			$meta_array = array(
				'zoacres_property_agent_id' => $agent_id,
				'zoacres_property_address' => wp_slash( nl2br( $property_address ) ),
				'zoacres_property_zip' => $property_zip,
				'zoacres_property_status' => $property_ribbons,
				'zoacres_property_price' => $property_price,
				'zoacres_property_before_price_label' => $property_price_before,
				'zoacres_property_after_price_label' => $property_price_after,
				'zoacres_property_size' => $property_size,
				'zoacres_property_lot_size' => $property_lot_size,
				'zoacres_property_no_rooms' => $property_no_rooms,
				'zoacres_property_no_bed_rooms' => $property_no_bed_rooms,
				'zoacres_property_no_bath_rooms' => $property_no_bath_rooms,
				'zoacres_property_no_garages' => $property_no_garages,
				'zoacres_property_video_type' => $property_video_type,
				'zoacres_property_gallery' => $gallery_ids,
				'zoacres_property_vitual_tour' => $property_virtual_tour,
				'zoacres_property_360_image' => $property_360_image,
				'zoacres_property_latitude' => $property_map_latitude,
				'zoacres_property_longitude' => $property_map_longitude,
				'zoacres_property_documents' => $property_documents
			);		
			
			//Property Structures
			$property_structures = $zpe->zoacresPropertyThemeOpt('property-structure');
			if( $property_structures ):
				$property_structures_arr = zoacres_trim_array_same_values( $property_structures );
				$prop_structures = '';
				foreach ( $property_structures_arr as $value => $label ){
					$field_value = isset( $_POST['zoacres_property_structures_'.$value] ) ? $_POST['zoacres_property_structures_'.$value] : '';
					$meta_array['zoacres_property_structures_'. $value ] = $field_value;
					if( $field_value ) $prop_structures .= $value . ',';
				}
				$prop_structures = $prop_structures ? rtrim( $prop_structures, ',' ) : '';
				$meta_array['zoacres_property_structures'] = $prop_structures;
			endif;
			
			//Property Features
			$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
			if( $property_features ):
				$property_features_arr = zoacres_trim_array_same_values( $property_features );
				$prop_ftrs = '';
				foreach ( $property_features_arr as $value => $label ){
					$field_value = isset( $_POST['zoacres_property_features_'.$value] ) ? $_POST['zoacres_property_features_'.$value] : '';
					$meta_array['zoacres_property_features_'. sanitize_title( $value )] = $field_value;
					if( $field_value ) $prop_ftrs .= sanitize_title( $value ) . ',';
				}
				$prop_ftrs = $prop_ftrs ? rtrim( $prop_ftrs, ',' ) : '';
				$meta_array['zoacres_property_features'] = $prop_ftrs;
			endif;
			
			//Property Custom Fields
			if( $property_cf ):
				foreach( $property_cf as $fields ){
					$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
					$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
					$cf_val = isset( $_POST['zoacres_property_custom_'.$fld_id] ) ? $_POST['zoacres_property_custom_'.$fld_id] : '';
					$meta_array['zoacres_property_custom_'.$fld_id] = $cf_val;
				}
			endif;
			
			//Property Plan Values
			$plan_ids = explode( ",", $plan_ids );
			$floor_plans = array();
			foreach( $plan_ids as $plan_id ){
				$plan_image = isset( $_POST['property_plan_image_final_'.$plan_id] ) ? $_POST['property_plan_image_final_'.$plan_id] : '';
				$plan_title = isset( $_POST['property_plan_title_'.$plan_id] ) ? $_POST['property_plan_title_'.$plan_id] : '';
				$plan_size = isset( $_POST['property_plan_size_'.$plan_id] ) ? $_POST['property_plan_size_'.$plan_id] : '';
				$plan_rooms = isset( $_POST['property_plan_rooms_'.$plan_id] ) ? $_POST['property_plan_rooms_'.$plan_id] : '';
				$plan_bathrooms = isset( $_POST['property_plan_bathrooms_'.$plan_id] ) ? $_POST['property_plan_bathrooms_'.$plan_id] : '';
				$plan_desc = isset( $_POST['property_plan_desc_'.$plan_id] ) ? $_POST['property_plan_desc_'.$plan_id] : '';
				$plan_price = isset( $_POST['property_plan_price_'.$plan_id] ) ? $_POST['property_plan_price_'.$plan_id] : '';
			
				$t_flr_plans = array(
					'plan_image' => $plan_image,
					'plan_title' => $plan_title,
					'plan_size' => $plan_size,
					'plan_rooms' => $plan_rooms,
					'plan_bathrooms' => $plan_bathrooms,
					'plan_desc' => $plan_desc,
					'plan_price' => $plan_price
				);
				
				array_push( $floor_plans, $t_flr_plans );
			}
			
			$meta_array['zoacres_property_floor_palns'] = $floor_plans;
			$meta_array = apply_filters( 'zoacres_property_update_meta_array', $meta_array );
			
			$property_category = isset( $_POST['property_category'] ) ? $_POST['property_category'] : '';
			$property_action = isset( $_POST['property_action'] ) ? $_POST['property_action'] : '';
			$property_area = isset( $_POST['property_area'] ) ? $_POST['property_area'] : '';
			$property_city = isset( $_POST['property_city'] ) ? $_POST['property_city'] : '';
			$property_state = isset( $_POST['property_state'] ) ? $_POST['property_state'] : '';
			$property_country = isset( $_POST['property_country'] ) ? $_POST['property_country'] : '';
					
			$post_data = array(
				'ID' => esc_attr( $property_id ),
				'post_title'   => esc_html( $property_title ),
				'post_content' => wp_slash( $property_content ),
				'post_author'   => 1,
				'zoacres_property_property-category' => $property_category,
				'meta_input'   => $meta_array,
			);
	
			wp_update_post( $post_data );
			if( $featured_img_id ){
				$featured_img_stat = set_post_thumbnail( $property_id, $featured_img_id );
			}
			
			// Set Property Category
			if( $property_category ){
				$cat_ids = array_map( 'intval', $property_category );
				$cat_ids = array_unique( $cat_ids );
				wp_set_object_terms( $property_id, $cat_ids, 'property-category' );
			}
			
			// Set Property Action
			if( $property_action ){
				$action_ids = array_map( 'intval', $property_action );
				$action_ids = array_unique( $action_ids );
				wp_set_object_terms( $property_id, $action_ids, 'property-action' );
			}
			
			// Set Property Area
			if( $property_area ){
				$area_ids = array_map( 'intval', $property_area );
				$area_ids = array_unique( $area_ids );
				wp_set_object_terms( $property_id, $area_ids, 'property-area' );
			}
			
			// Set Property City
			if( $property_city ){
				$city_ids = array_map( 'intval', $property_city );
				$city_ids = array_unique( $city_ids );
				wp_set_object_terms( $property_id, $city_ids, 'property-city' );
			}
			
			// Set Property State
			if( $property_state ){
				$state_ids = array_map( 'intval', $property_state );
				$state_ids = array_unique( $state_ids );
				wp_set_object_terms( $property_id, $state_ids, 'property-state' );
			}
			
			// Set Property Country
			if( $property_state ){
				$country_ids = array_map( 'intval', $property_country );
				$country_ids = array_unique( $country_ids );
				wp_set_object_terms( $property_id, $country_ids, 'property-country' );
			}
			
			$result['msg'] = 'success';
		else:
			$result['msg'] = 'invalid property';
		endif;

		echo json_encode( $result );
		die();
			
	}
	add_action('wp_ajax_nopriv_zoacres_update_property', 'zoacres_update_property');
	add_action('wp_ajax_zoacres_update_property', 'zoacres_update_property');
}

function zoacres_agent_eligible_check( $last_pack, $agent_id, $agent_email = '' ){
	
	if( user_can( $agent_id, 'manage_options' ) ) return 1;
	
	$active_stat = 0;
	$default_pack = 0;
	
	if( empty( $last_pack ) ){
	
		$zpe = new ZoacresPropertyElements();
		$def_listing_count = $zpe->zoacresPropertyThemeOpt('free-member-listings');
		$def_featured_count = $zpe->zoacresPropertyThemeOpt('free-member-featured');
		$def_image_limi = $zpe->zoacresPropertyThemeOpt('free-member-img-limit');
	
		$last_pack = array( 
			'transaction_id' => '',
			'pack_id' => '' ,
			'pack_details' => array( 
				'pack_time_limit' => '',
				'pack_time_units' => '', 
				'pack_listing_stat' => 'lim', 
				'pack_listing_count' => absint( $def_listing_count ),
				'pack_featured_count' => absint( $def_featured_count ),
				'pack_image_stat' => 'lim',
				'package_image_limit' => absint( $def_image_limi )
			), 
			'email' => '',
			'currency' => '',
			'transaction_amount' => '', 
			'transaction_datetime' => '', 
			'pack_expiry' => '', 
			'transaction_status' => '' 
		);	
		$default_pack = 1;
	}

	$pack_details = $last_pack['pack_details'];
	if( isset( $last_pack['pack_expiry'] ) && $last_pack['pack_expiry'] != '' ) {
		$exp_date = $last_pack['pack_expiry'];
		$date = date( 'Y-m-d', $exp_date );
		$date_now = time();
		if( $date_now < $exp_date ){
			$active_stat = 1;
		}
	}elseif( $default_pack ){
		$active_stat = 1;
	}
	
	$agent_post_count = zoacres_get_agent_post_count( $agent_id );

	$list_stat = $pack_details['pack_listing_stat'];
	$list_limit = 2;
	if( $list_stat == 'lim' ){
		$list_limit = $pack_details['pack_listing_count'];
	}else{
		$list_limit = absint( $agent_post_count ) + 1;
	}
	
	if( $agent_post_count < $list_limit ){
		$active_stat = 1;
	}else{
		$active_stat = 0;
	}
	
	return $active_stat;
}

function zoacres_agent_gallery_eligible_check( $last_pack, $image_count ){
	$active_stat = 0;	
	$default_pack = 0;

	if( empty( $last_pack ) ){
	
		$zpe = new ZoacresPropertyElements();
		$def_listing_count = $zpe->zoacresPropertyThemeOpt('free-member-listings');
		$def_featured_count = $zpe->zoacresPropertyThemeOpt('free-member-featured');
		$def_image_limi = $zpe->zoacresPropertyThemeOpt('free-member-img-limit');
	
		$last_pack = array( 
			'transaction_id' => '',
			'pack_id' => '' ,
			'pack_details' => array( 
				'pack_time_limit' => '',
				'pack_time_units' => '', 
				'pack_listing_stat' => 'lim', 
				'pack_listing_count' => absint( $def_listing_count ),
				'pack_featured_count' => absint( $def_featured_count ),
				'pack_image_stat' => 'lim',
				'package_image_limit' => absint( $def_image_limi )
			), 
			'email' => '',
			'currency' => '',
			'transaction_amount' => '', 
			'transaction_datetime' => '', 
			'pack_expiry' => '', 
			'transaction_status' => '' 
		);	
		$default_pack = 1;
	}
	
	$pack_details = $last_pack['pack_details'];
	$gallery_stat = $pack_details['pack_image_stat'];
	$gallery_limit = 2;
	if( $gallery_stat == 'lim' ){
		$gallery_limit = $pack_details['package_image_limit'];
	}else{
		$gallery_limit = $image_count + 1;
	}
	if( $image_count < $gallery_limit ){
		$active_stat = 1;
	}
	
	return $active_stat;
}

/* Create New Property */
if( ! function_exists('zoacres_delete_property') ) {
	function zoacres_delete_property(){
	
		$nonce = sanitize_text_field($_POST['nonce']);  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-property-remove' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$property_id = isset( $_POST['property_id'] ) ? $_POST['property_id'] : '';
		
		if( $property_id ):
		
			$current_user = wp_get_current_user();
			$agent_email = $current_user->user_email;
			$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );	
			
			$args = array(
				'post_type'  => 'zoacres-property',
				'post__in'   => array( $property_id ),
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'zoacres_property_agent_id',
						'value'   => $agent_id,
						'compare' => '=',
					),
				)
			);
			$query = new WP_Query( $args );
			$stat = 0;
			if ( $query->have_posts() ) {
				$stat = 1;
				wp_reset_postdata();
			}
			
			if( $stat ){
				// Remove Property Featured Images
				$post_thumbnail_id = get_post_thumbnail_id( $property_id );
				wp_delete_attachment( $post_thumbnail_id, true );
				
				// Remove Property Gallery Images
				$image_ids = get_post_meta( $property_id, 'zoacres_property_gallery', true );
				$plan_images = get_post_meta( $property_id, 'zoacres_property_floor_palns', true );
				
				if( !empty( $plan_images ) ){
					foreach( $plan_images as $plan_image ){
						$image_ids .= isset( $plan_image['plan_image'] ) && $plan_image['plan_image'] != '' ? ',' . $plan_image['plan_image'] : '';
					}
				}
				
				$image_360 = get_post_meta( $property_id, 'zoacres_property_360_image', true );
				$image_ids .= $image_360 != '' ? ',' . $image_360 : '';
				
				if( $image_ids ){
					$image_ids = rtrim( $image_ids, "," );
					$image_ids = explode( ",", $image_ids );
					foreach( $image_ids as $image_id ){
						wp_delete_attachment( $image_id, true );
					}
				}
				
				// Remove Property
				wp_delete_post( $property_id );
			}
		endif;
			
		$result = array();
		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
	
	}
	add_action('wp_ajax_nopriv_zoacres_property_remove', 'zoacres_delete_property');
	add_action('wp_ajax_zoacres_property_remove', 'zoacres_delete_property');
}

/* Create New Property */
if( ! function_exists('zoacres_property_featured_set_by_user') ) {
	function zoacres_property_featured_set_by_user(){
	
		$nonce = sanitize_text_field($_POST['nonce']);  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-property-featured' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$property_id = isset( $_POST['property_id'] ) ? $_POST['property_id'] : '';
		
		$result = array();
		
		if( $property_id ):
		
			$current_user = wp_get_current_user();
			$agent_email = $current_user->user_email;
			$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );	
			
			$args = array(
				'post_type'  => 'zoacres-property',
				'posts_per_page' => -1,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'zoacres_property_agent_id',
						'value'   => $agent_id,
						'compare' => '=',
					),
					array(
						'key'     => 'zoacres_post_featured_stat',
						'value'   => 1,
						'compare' => '=',
					),
				)
			);
			$query = new WP_Query( $args );
			$tot_featured = $query->found_posts;
			
			$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
			
			$featured_count = 2;
			if( !empty( $last_pack ) ){
				$featured_count = isset( $last_pack['pack_details'] ) && isset( $last_pack['pack_details']['pack_featured_count'] ) ? $last_pack['pack_details']['pack_featured_count'] : '';
			}
			
			if( $featured_count > $tot_featured ){
				// Set property status to featured/non-featured
				$featured_stat = get_post_meta( esc_attr( $property_id ), 'zoacres_post_featured_stat', true );
				if( $featured_stat ){
					update_post_meta( esc_attr( $property_id ), 'zoacres_post_featured_stat', 0 );
					$result['msg'] = 'inactive';
				}else{
					update_post_meta( esc_attr( $property_id ), 'zoacres_post_featured_stat', 1 );
					$result['msg'] = 'active';
				}
			}else{
				$result['msg'] = 'limit exceed';
			}

		else:
			$result['msg'] = 'invalid';
		endif;

		echo json_encode( $result );
		die();
	
	}
	add_action('wp_ajax_nopriv_zoacres_property_featured', 'zoacres_property_featured_set_by_user');
	add_action('wp_ajax_zoacres_property_featured', 'zoacres_property_featured_set_by_user');
}

/* Remove Inbox Message */
if( ! function_exists('zoacres_remove_inbox_message') ) {
	function zoacres_remove_inbox_message(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-remove-user-message' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$rowid = isset( $_POST['rowid'] ) ? $_POST['rowid'] : '';
		
		$result = array();
		
		if( $rowid ):
			$cur_user_id = get_current_user_id();
			$user_inbox_msg = get_user_meta( $cur_user_id, 'zoacres_user_messages', true );
			if( !empty( $user_inbox_msg ) && is_array( $user_inbox_msg ) ){
				unset($user_inbox_msg[$rowid]);
				$updated = update_user_meta( $cur_user_id, 'zoacres_user_messages', $user_inbox_msg );
			}			
		endif;
		
		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
	
	}
	add_action('wp_ajax_nopriv_zoacres_remove_inbox_msg', 'zoacres_remove_inbox_message');
	add_action('wp_ajax_zoacres_remove_inbox_msg', 'zoacres_remove_inbox_message');
}

/* Remove Saved Search */
if( ! function_exists('zoacres_remove_saved_search') ) {
	function zoacres_remove_saved_search(){
	
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-remove-saved-search' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$rowid = isset( $_POST['rowid'] ) ? $_POST['rowid'] : '';
		
		$result = array();
		
		if( $rowid != '' || $rowid === 0 ):
			$cur_user_id = get_current_user_id();
			$user_inbox_msg = get_user_meta( $cur_user_id, 'zoacres_saved_searches', true );
			if( !empty( $user_inbox_msg ) && is_array( $user_inbox_msg ) ){
				unset($user_inbox_msg[$rowid]);
				$updated = update_user_meta( $cur_user_id, 'zoacres_saved_searches', $user_inbox_msg );
			}			
		endif;
		
		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
	
	}
	add_action('wp_ajax_nopriv_zoacres_remove_saved_search', 'zoacres_remove_saved_search');
	add_action('wp_ajax_zoacres_remove_saved_search', 'zoacres_remove_saved_search');
}

/* Remove All Inbox Messages */
if( ! function_exists('zoacres_remove_all_inbox_message') ) {
	function zoacres_remove_all_inbox_message(){
	
		$nonce = sanitize_text_field($_POST['nonce']); 
		if ( ! wp_verify_nonce( $nonce, 'zoacres-remove-user-message' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
		
		$cur_user_id = get_current_user_id();
		$updated = update_user_meta( $cur_user_id, 'zoacres_user_messages', '' );
		
		$result['msg'] = 'success';
		echo json_encode( $result );
		die();
	
	}
	add_action('wp_ajax_nopriv_zoacres_remove_all_inbox_msg', 'zoacres_remove_all_inbox_message');
	add_action('wp_ajax_zoacres_remove_all_inbox_msg', 'zoacres_remove_all_inbox_message');
}

//Update membership
function zoacres_update_user_membership( $pack_id, $transaction_id = '', $currency = 'USD', $pay_by = '', $payer_email = '' ){
	//Transaction Details Save
	$time = time(); 
	$transaction_datetime = $time;
	
	$time_limit = get_post_meta( $pack_id, 'zoacres_package_time_limit', true );
	$time_val = '';
	if( $time_limit == 'week' ){
		$time_val = 7;
	}elseif( $time_limit == 'month' ){
		$time_val = 30;
	}elseif( $time_limit == 'year' ){
		$time_val = 365;
	}else{
		$time_val = 1;
	}
	$pack_name = get_the_title( $pack_id );
	$time_units = get_post_meta( $pack_id, 'zoacres_package_time_units', true );
	$transaction_amount = get_post_meta( $pack_id, 'zoacres_package_price', true );
	$time_units = !empty( $time_units ) ? $time_units : 1;
	$total_days = $time_val * $time_units;
	$pack_expiry = strtotime( date('Y-m-d H:i:s', strtotime('+'. $total_days .' day', $transaction_datetime)) );
	
	$pack_details = array(
		'pack_name' => $pack_name,
		'pack_time_limit' => get_post_meta( $pack_id, 'zoacres_package_time_limit', true ),
		'pack_time_units' => get_post_meta( $pack_id, 'zoacres_package_time_units', true ),
		'pack_listing_stat' => get_post_meta( $pack_id, 'zoacres_package_listing_count_stat', true ),
		'pack_listing_count' => get_post_meta( $pack_id, 'zoacres_package_listing_count', true ),
		'pack_featured_count' => get_post_meta( $pack_id, 'zoacres_package_featured_count', true ),
		'pack_image_stat' => get_post_meta( $pack_id, 'zoacres_package_image_max_stat', true ),
		'package_image_limit' => get_post_meta( $pack_id, 'zoacres_package_image_max', true )
	);
	
	$last_package = array(
		'transaction_id' => $transaction_id,
		'pack_id' => $pack_id,
		'pack_details' => $pack_details,
		'email' => $payer_email,
		'pay_by' => $pay_by,
		'currency' => $currency,
		'transaction_amount' => $transaction_amount,
		'transaction_datetime' => $transaction_datetime,
		'pack_expiry' => $pack_expiry,
		'transaction_status' => esc_html__( 'Succeeded', 'zoacres' )
	);
	
	// Update user invoice and last pack details
	$cur_user_id = get_current_user_id();
	$updated = update_user_meta( $cur_user_id, 'zoacres_package_last_updated', $last_package );
	
	$invoices = get_user_meta( $cur_user_id, 'zoacres_package_invoices', true );
	if( ! empty( $invoices ) && is_array( $invoices ) ) {
		$invoices[$transaction_datetime] = $last_package;
		$updated = update_user_meta( $cur_user_id, 'zoacres_package_invoices', $invoices );
	}else{
		$invoices = array( $transaction_datetime => $last_package );
		$updated = update_user_meta( $cur_user_id, 'zoacres_package_invoices', $invoices );
	}
	
	// store message for user inbox
	$msg = wp_sprintf( esc_html__( 'Hi, Your package( %1$s ) activated.', 'zoacres' ), esc_html( $pack_name ) );
	$user_inbox_msg = get_user_meta( $cur_user_id, 'zoacres_user_messages', true );
	if( !empty( $user_inbox_msg ) && is_array( $user_inbox_msg ) ){
		$user_inbox_msg[$transaction_datetime] = array( 'msg' => $msg, 'vstat' => false );
	}else{
		$user_inbox_msg = array(
			$transaction_datetime => array( 'msg' => $msg, 'vstat' => false )
		);
	}
	$updated = update_user_meta( $cur_user_id, 'zoacres_user_messages', $user_inbox_msg );
}

function zoacres_check_user_membership_grade( $pack_id, $user_email ){
	
	$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $user_email );
	$agent_args = array(
		'post_type' => 'zoacres-property',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key' => 'zoacres_property_agent_id',
		'meta_value' => $agent_id
	);
	$agent_query = new WP_Query( $agent_args );
	$property_count = $agent_query->found_posts;
	
	$current_stat = get_post_meta( $pack_id, 'zoacres_package_listing_count_stat', true );
	
	if( $current_stat == 'lim' ){
		$current_listing = get_post_meta( $pack_id, 'zoacres_package_listing_count', true );
		$listing_diff = $current_listing - $property_count;
		if( $listing_diff >= 0 ){
			return true;
		}else{
			return false;
		}
	}else{
		return true;
	}

}

function zoacres_down_user_membership_grade( $pack_id = '', $user_email ){
	
	$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $user_email );
	$agent_args = array(
		'post_type' => 'zoacres-property',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key' => 'zoacres_property_agent_id',
		'meta_value' => $agent_id
	);
	$agent_query = new WP_Query( $agent_args );
	$property_count = $agent_query->found_posts;
	
	if( $property_count ){
		$current_listing = $pack_id != '' ? get_post_meta( $pack_id, 'zoacres_package_listing_count', true ) : 2;
		$listing_diff = $property_count - $current_listing;
	
		$agent_args = array(
			'post_type' => 'zoacres-property',
			'posts_per_page' => absint( $listing_diff ),
			'post_status' => 'publish',
			'meta_key' => 'zoacres_property_agent_id',
			'meta_value' => $agent_id,
			'order'   => 'ASC',
		);
		$agent_query = new WP_Query( $agent_args );
		if ( $agent_query->have_posts() ) {
			while ( $agent_query->have_posts() ) {
				$agent_query->the_post();
				$post_id = get_the_ID();
				zoacres_property_deactive_process( $post_id );
			}
			wp_reset_postdata();
		}
	}//agent property found if
}

function zoacres_up_user_membership_grade( $pack_id, $user_email ){
	
	$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $user_email );
	$agent_args = array(
		'post_type' => 'zoacres-property',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key' => 'zoacres_property_agent_id',
		'meta_value' => $agent_id
	);
	$agent_query = new WP_Query( $agent_args );
	$property_count = $agent_query->found_posts;
	$current_listing = get_post_meta( $pack_id, 'zoacres_package_listing_count', true );
	if( $current_listing > $property_count ){
		$listing_diff = $current_listing - $property_count;
		
		$agent_args = array(
			'post_type' => 'zoacres-property',
			'posts_per_page' => absint( $listing_diff ),
			'post_status' => 'draft',
			'meta_key' => 'zoacres_property_agent_id',
			'meta_value' => $agent_id,
			'order'   => 'DESC',
		);
		$agent_query = new WP_Query( $agent_args );
		if ( $agent_query->have_posts() ) {
			while ( $agent_query->have_posts() ) {
				$agent_query->the_post();
				$post_id = get_the_ID();
				zoacres_property_active_process( $post_id );
			}
			wp_reset_postdata();
		}		
	}
	
}

function zoacres_property_deactive_process( $post_id ){
	update_post_meta( esc_attr( $post_id ), 'zoacres_property_active_status', 'inactive' );
	global $wpdb;
	$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
}

function zoacres_property_active_process( $post_id ){
	update_post_meta( esc_attr( $post_id ), 'zoacres_property_active_status', 'active' );
	global $wpdb;
	$wpdb->update( $wpdb->posts, array( 'post_status' => 'publish' ), array( 'ID' => $post_id ) );
}

//Set Agent Rating
if( ! function_exists('zoacres_set_agent_rate') ) {
	function zoacres_set_agent_rate(){
		$nonce = sanitize_text_field($_POST['nonce']); 
		if ( ! wp_verify_nonce( $nonce, 'zoacres-agent-rating' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$agent_id = isset( $_POST['agent_id'] ) ? $_POST['agent_id'] : '';
		$rating = isset( $_POST['rating'] ) ? $_POST['rating'] : '';
		
		$user = wp_get_current_user();
		if ( in_array( 'subscriber', (array) $user->roles ) ) {
			$user_id = $user->ID;
			
			$rated_users = get_post_meta( $agent_id, 'rated_users_list', true );
			$ratings = array();
			
			if( isset( $rated_users ) && is_array( $rated_users ) ){
				$rated_users['ag-'.$user_id] = $rating;
				$ratings = array_values( $rated_users );
			}else{
				$rated_users = array( 'ag-'.$user_id => $rating );
				$ratings = array_values( $rated_users );
			}

			$average_ratings = !empty( $ratings ) ? array_sum( $ratings ) / count( $ratings ) : '0';
			
			update_post_meta( $agent_id, 'rated_users_list', $rated_users );
			update_post_meta( $agent_id, 'rated_users_ratings', $ratings );
			update_post_meta( $agent_id, 'zoacres_agent_rating', $average_ratings );
		}
		
		echo 'success';
		die();
	}
	add_action( 'wp_ajax_nopriv_set_agent_rate', 'zoacres_set_agent_rate' );  
	add_action( 'wp_ajax_set_agent_rate', 'zoacres_set_agent_rate' ); 
}

//Remove Documents
if( ! function_exists('zoacres_remove_docs_final') ) {
	function zoacres_remove_docs_final(){
		$nonce = sanitize_text_field($_POST['nonce']);	  
		if ( ! wp_verify_nonce( $nonce, 'zoacres-remove-documents' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$attc_id = isset( $_POST['attc_id'] ) ? $_POST['attc_id'] : '';
		wp_delete_attachment( absint( $attc_id ), true );	
		
		echo 'success';
		die();
	}
	add_action( 'wp_ajax_nopriv_zoacres_remove_docs', 'zoacres_remove_docs_final' );  
	add_action( 'wp_ajax_zoacres_remove_docs', 'zoacres_remove_docs_final' ); 
}
<?php
   /**
    *	Template Name: User Property Edit
    */
if ( !is_user_logged_in() ) {
	$url = home_url( '/' );
	if ( wp_redirect( $url ) ) {
		exit;
	}
}

$is_agent = zoacres_check_is_agent();
if( !$is_agent ){
	$url = home_url( '/' );
	if ( wp_redirect( $url ) ) {
		exit;
	}
}
	
	get_header(); 
   
	$current_user = wp_get_current_user();
	
	$agent_email = $current_user->user_email;
	$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
	
	$post_object = get_post( $agent_id );        
	$agent_description = $post_object->post_content;
	$agent_image_url = get_the_post_thumbnail_url( $agent_id, 'thumbnail' );
	
	$zpe = new ZoacresPropertyElements();
  
?>
<div class="zoacres-content user-admin-template">
   <div class="zoacres-content-inner">
      	<div class="container zoacres_user_dashboard">
			<div class="row">
				<div class="col-md-3">
					<div class="user-details text-center typo-white">
						<?php if( $agent_image_url ): ?>
						<div class="user-image">
							<img src="<?php echo esc_url( $agent_image_url ); ?>" class="rounded-circle" height="80px" width="80px" alt="<?php esc_attr_e('User Image', 'zoacres'); ?>">
						</div><!-- .user-image -->
						<?php endif; ?>
						<div class="username">
							<h6><?php esc_html_e( 'Welcome back,', 'zoacres' ); ?><i class="icon-user icons"></i> <?php echo esc_html( $current_user->display_name ); ?></h6>
						</div><!-- .username -->
					</div><!-- .user-details -->
					<div class="user_tab_menu">
						<div class="user_dashboard_links">
							<?php
								$auth_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-user-profile.php'
								));
								if( $auth_pages ){
									$auth_dash_link = get_permalink( $auth_pages[0]->ID );
								}else{
									$auth_dash_link = home_url( '/' );
								} 
								$prop_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-property-new.php'
								));
								if( $prop_pages ){
									$prop_dash_link = get_permalink( $prop_pages[0]->ID );
								}else{
									$prop_dash_link = home_url( '/' );
								} 
								$prop_list_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-user-properties.php'
								));
								if( $prop_list_pages ){
									$prop_list_link = get_permalink( $prop_list_pages[0]->ID );
								}else{
									$prop_list_link = home_url( '/' );
								} 
								$agent_fav_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-user-fav.php'
								));
								if( $agent_fav_pages ){
									$prop_fav_link = get_permalink( $agent_fav_pages[0]->ID );
								}else{
									$prop_fav_link = home_url( '/' );
								} 
								$agent_saved_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-property-saved-search.php'
								));
								if( $agent_saved_pages ){
									$prop_saved_link = get_permalink( $agent_saved_pages[0]->ID );
								}else{
									$prop_saved_link = home_url( '/' );
								} 
								$agent_invoice_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-invoice-list.php'
								));
								if( $agent_invoice_pages ){
									$prop_invoice_link = get_permalink( $agent_invoice_pages[0]->ID );
								}else{
									$prop_invoice_link = home_url( '/' );
								} 
								//User Inbox Template
								$agent_inbox_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-user-inbox.php'
								));
								if( $agent_inbox_pages ){
									$prop_inbox_link = get_permalink( $agent_inbox_pages[0]->ID );
								}else{
									$prop_inbox_link = home_url( '/' );
								} 
								
								$user_inbox_msg = get_user_meta( $current_user->ID, 'zoacres_user_messages', true );
								$ntf = 0;
								if( !empty( $user_inbox_msg ) && is_array( $user_inbox_msg ) ){
									foreach( $user_inbox_msg as $msg_time => $msg ){
										if( is_array( $msg ) ) {
											$ntf += $msg['vstat'] == false ? 1 : 0;
										}
									}
								}
								
							?>
							<ul class="list-group">
								<li class="list-group-item"><a href="<?php echo esc_url( $auth_dash_link ); ?>" class="d-block "><i class="fa fa-cog"></i><?php esc_html_e('My Profile', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_list_link ); ?>" class="d-block"> <i class="fa fa-map-marker"></i><?php esc_html_e('My Properties List', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_dash_link ); ?>" class="d-block"> <i class="fa fa-plus"></i><?php esc_html_e('Add New Property', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_fav_link ); ?>" class="d-block"><i class="fa fa-heart"></i><?php esc_html_e('Favorites', 'zoacres'); ?></a></li><!-- .agent-fav-property-list removed this class. This class used for ajax -->
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_saved_link ); ?>" class="d-block"><i class="fa fa-search"></i><?php esc_html_e('Saved Searches', 'zoacres'); ?></a></li><!-- .user-saved-searches removed this class. This class used for ajax -->
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_invoice_link ); ?>" class="d-block"><i class="fa fa-file-text-o"></i><?php esc_html_e('My Invoices', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_inbox_link ); ?>" class="d-block"><i class="fa fa-envelope-o"></i><?php esc_html_e('Inbox', 'zoacres'); if( $ntf ) echo '<span class="message-notification">'. esc_html( $ntf ) .'</span>'; ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="d-block"><i class="fa fa-power-off"></i><?php esc_html_e('Log Out', 'zoacres'); ?></a></li>
							</ul>
						<!-- List Group -->
						</div><!-- .user_dashboard_links -->
					</div><!-- .user_tab_menu -->
				</div><!-- .col-md-3 -->
				<div class="col-md-9">
					<div class="col-md-12 top_dahsboard_wrapper dashboard_package_row">
						
						<!-- Property Edit-->
						<?php 
						
							//Get property id from url
							$property_id = isset( $_GET['property'] ) ? esc_attr( $_GET['property'] ) : '';
							
							$stat = 0;
							if( $property_id ){
								$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );	
								$args = array(
									'post_type'  => 'zoacres-property',
									'post__in'   => array( $property_id ),
									'post_status' => array( 'publish', 'draft' ),
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
							}
							
							if( $stat ): 

								$cproperty = get_post( $property_id ); ?>
							
								<div class="add-new-property">
									<form id="update-property-form" method="post" enctype="multipart/form-data">
										<h3 class="typo-white"><?php esc_html_e('Edit Property', 'zoacres'); ?></h3>
										<input type="hidden" value="<?php echo esc_attr( $property_id ); ?>" name="user_property_id" />
										<p>
											<label for="property-title"><?php esc_html_e('Property Title', 'zoacres'); ?></label>
											<input type="text" id="property-title" class="form-control" value="<?php echo esc_html( $cproperty->post_title );  ?>" name="property_title">
										</p>
										<p>
											<label for="property-desc"><?php esc_html_e('Property Description', 'zoacres'); ?></label>
											<textarea class="form-control" rows="10" name="property_desc" id="property-desc"><?php echo wp_kses_post( $cproperty->post_content ); ?></textarea>
										</p>
										<div class="row properties-input">
											<div class="col-md-6">
												<div class="property-fields">
													<label for="property-image"><?php esc_html_e('Property Categories', 'zoacres'); ?></label>
													<?php
														$terms = get_terms( 'property-category', array(
															'post_type' => array('zoacres-property'),
															'hide_empty' => false,
														) );
														$property_sel_cats = wp_get_object_terms( $property_id,  'property-category' );
														$selected_cats = array();
														if( $property_sel_cats ):
															foreach( $property_sel_cats as $cpt_term ){
																array_push( $selected_cats, $cpt_term->term_id );
															}
														endif;
			
														if( $terms ): ?>
															<div>
																<ul class="nav meta_box_items">
														<?php
															foreach( $terms as $cpt_term ){
																$checked = in_array( $cpt_term->term_id, $selected_cats ) ? 'checked' : '';
																echo '<li><input name="property_category[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
															}
														?>
																</ul>
															</div>
														<?php
														endif;
													?>
												</div>
												<div class="property-fields">
													<label for="property-image"><?php esc_html_e('Property Actions', 'zoacres'); ?></label>
													<?php
														$terms = get_terms( 'property-action', array(
															'post_type' => array('zoacres-property'),
															'hide_empty' => false,
														) );
														
														$property_sel_actions = wp_get_object_terms( $property_id,  'property-action' );
														$selected_action = array();
														if( $property_sel_actions ):
															foreach( $property_sel_actions as $cpt_term ){
																array_push( $selected_action, $cpt_term->term_id );
															}
														endif;
														
														if( $terms ): ?>
															<div>
																<ul class="nav meta_box_items">
														<?php
															foreach( $terms as $cpt_term ){
																$checked = in_array( $cpt_term->term_id, $selected_action ) ? 'checked' : '';
																echo '<li><input name="property_action[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
															}
														?>
																</ul>
															</div>
														<?php
														endif;
													?>
												</div>
												<div class="property-fields">
													<label for="property-image"><?php esc_html_e('Property Area', 'zoacres'); ?></label>
													<?php
														$terms = get_terms( 'property-area', array(
															'post_type' => array('zoacres-property'),
															'hide_empty' => false,
														) );
														
														$property_sel_area = wp_get_object_terms( $property_id,  'property-area' );
														$selected_area = array();
														if( $property_sel_area ):
															foreach( $property_sel_area as $cpt_term ){
																array_push( $selected_area, $cpt_term->term_id );
															}
														endif;
														
														if( $terms ): ?>
															<div>
																<ul class="nav meta_box_items">
														<?php
															foreach( $terms as $cpt_term ){
																$checked = in_array( $cpt_term->term_id, $selected_area ) ? 'checked' : '';
																echo '<li><input name="property_area[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
															}
														?>
																</ul>
															</div>
														<?php
														endif;
													?>
												</div>
												<?php
													$property_bound = $zpe->zoacresPropertyThemeOpt('property-boundary');
													if( $property_bound >= 2 ):
												?>
														<div class="property-fields">
															<label for="property-image"><?php esc_html_e('Property City', 'zoacres'); ?></label>
															<?php
																$terms = get_terms( 'property-city', array(
																	'post_type' => array('zoacres-property'),
																	'hide_empty' => false,
																) );
																
																$property_sel_city = wp_get_object_terms( $property_id,  'property-city' );
																$selected_city = array();
																if( $property_sel_city ):
																	foreach( $property_sel_city as $cpt_term ){
																		array_push( $selected_city, $cpt_term->term_id );
																	}
																endif;
																
																if( $terms ): ?>
																	<div>
																		<ul class="nav meta_box_items">
																<?php
																	foreach( $terms as $cpt_term ){
																		$checked = in_array( $cpt_term->term_id, $selected_city ) ? 'checked' : '';
																		echo '<li><input name="property_city[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
																	}
																?>
																		</ul>
																	</div>
																<?php
																endif;
															?>
														</div>
												<?php
													endif;
			
													if( $property_bound >= 3 ):
												?>
														<div class="property-fields">
															<label for="property-image"><?php esc_html_e('Property State', 'zoacres'); ?></label>
															<?php
																$terms = get_terms( 'property-state', array(
																	'post_type' => array('zoacres-property'),
																	'hide_empty' => false,
																) );
																
																$property_sel_state = wp_get_object_terms( $property_id,  'property-state' );
																$selected_state = array();
																if( $property_sel_state ):
																	foreach( $property_sel_state as $cpt_term ){
																		array_push( $selected_state, $cpt_term->term_id );
																	}
																endif;
																
																if( $terms ): ?>
																	<div>
																		<ul class="nav meta_box_items">
																<?php
																	foreach( $terms as $cpt_term ){
																		$checked = in_array( $cpt_term->term_id, $selected_state ) ? 'checked' : '';
																		echo '<li><input name="property_state[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
																	}
																?>
																		</ul>
																	</div>
																<?php
																endif;
															?>
														</div>
												<?php
													endif;
													
														if( $property_bound == 4 ):
												?>
														<div class="property-fields">
															<label for="property-image"><?php esc_html_e('Property Country', 'zoacres'); ?></label>
															<?php
																$terms = get_terms( 'property-country', array(
																	'post_type' => array('zoacres-property'),
																	'hide_empty' => false,
																) );
																
																$property_sel_country = wp_get_object_terms( $property_id,  'property-country' );
																$selected_country = array();
																if( $property_sel_country ):
																	foreach( $property_sel_country as $cpt_term ){
																		array_push( $selected_country, $cpt_term->term_id );
																	}
																endif;
																
																if( $terms ): ?>
																	<div>
																		<ul class="nav meta_box_items">
																<?php
																	foreach( $terms as $cpt_term ){
																		$checked = in_array( $cpt_term->term_id, $selected_country ) ? 'checked' : '';
																		echo '<li><input name="property_country[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" '. esc_attr( $checked ) .'> '. esc_html( $cpt_term->name ) .'</li>';
																	}
																?>
																		</ul>
																	</div>
																<?php
																endif;
															?>
														</div>
												<?php
													endif;
												?>
												
											   <div class="property-fields">
													<label for="property-image"><?php esc_html_e('Property Featured Image', 'zoacres'); ?></label>
													<div>
														<?php
															$post_thumbnail_id = get_post_thumbnail_id( $property_id );
															echo '<ul class="nav image-list">';
																$img_attr = wp_get_attachment_image_src( $post_thumbnail_id, "thumbnail" );
																echo '<li><img class="admin-no-image img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="50" height="50" alt="'. esc_attr__( 'No Image', 'zoacres' ) .'" /></li>';
															echo '</ul>';
														?>
														<input type="file" class="property-image-file" />
														<input type="hidden" class="property-image-final" name="property_image_final" value="<?php echo esc_attr( $post_thumbnail_id ); ?>" />
														<span class="d-block"><?php esc_html_e('Must choose image files only and images should not exists 500kb', 'zoacres'); ?></span>
													</div>	
											   </div>
											   <div class="property-fields">
													<?php
														$property_address = get_post_meta( $property_id, 'zoacres_property_address', true );
													?>
													<label for="property_address"><?php esc_html_e('Property Address', 'zoacres'); ?></label>
													<div>
														<textarea class="form-control" name="property_address" rows="5"><?php echo wp_kses_post( $property_address ); ?></textarea>
													</div>
											   </div>
											   <div class="property-fields">
													<?php
														$virtual_tour = get_post_meta( $property_id, 'zoacres_property_vitual_tour', true );
													?>
													<label for="property_virtual_tour"><?php esc_html_e('Virtual Tour Iframe URL', 'zoacres'); ?></label>
													<div>
														<input class="form-control" name="property_virtual_tour" type="text" value="<?php echo esc_url( $virtual_tour ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property-360-image"><?php esc_html_e( '360&deg; Image URL', 'zoacres' ); ?></label>
													<div>
														<?php
															$image_360 = get_post_meta( $property_id, 'zoacres_property_360_image', true );
															echo '<ul class="nav image-list">';
																$img_attr = wp_get_attachment_image_src( $image_360, "thumbnail" );
																echo '<li><img class="admin-no-image img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="50" height="50" alt="'. esc_attr__( 'No Image', 'zoacres' ) .'" /></li>';
															echo '</ul>';
														?>
														<input type="file" class="property-360-image-file" />
														<input type="hidden" class="property-360-image-final" name="property_360_image_final" value="<?php echo esc_attr( $image_360 ); ?>" />
														<span class="d-block"><?php esc_html_e('Enter property 360&#176; image url for single property page.', 'zoacres'); ?></span>
													</div>	
												</div>
												<div class="property-fields">
													<label for="property_ribbon"><?php esc_html_e('Property Features', 'zoacres'); ?></label>
													<div>
														<ul class="nav meta_box_items">
														<?php
														
														$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
														$property_features_arr = zoacres_trim_array_same_values( $property_features );
														
														foreach ( $property_features_arr as $value => $label ){
															$feature_val = get_post_meta( $property_id, 'zoacres_property_features_'. sanitize_title( $value ), true );
															$checked = $feature_val ? 'checked' : '';
															echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="zoacres_property_features_'. sanitize_title( $value ) .'" '. esc_attr( $checked ) .'>'. esc_html( $label ) .'</li>';
														}
														
														?>
														</ul>
													</div>
												</div>
												<div class="property-fields">
													<div class="d-inline-child">
														<?php
															$floor_plans = get_post_meta( $property_id, 'zoacres_property_floor_palns', true );		
															$floor_plans_count = is_array( $floor_plans ) ? count( $floor_plans ) : '1';
															$plan_ids = '';
															for( $c = 1; $c <= $floor_plans_count; $c++ ) $plan_ids .= $c . ',';
															$plan_ids = rtrim( $plan_ids, "," );
														?>
														<label for="property_floor_plans"><?php esc_html_e('Floor Plans', 'zoacres'); ?></label>
														<a href="#" class="btn btn-default pull-right property-plan-add"><?php esc_html_e('Add More', 'zoacres'); ?></a>
														<input type="hidden" class="property-plan-ids" name="property_plan_ids" value="<?php echo esc_attr( $plan_ids ); ?>" />
													</div>
													<div id="property-plan" class="property-plan" role="tablist" aria-multiselectable="false">
														
														<?php
														$i = 1;
														foreach( $floor_plans as $floor_plan ){
														?>
														<div class="card<?php echo ( ''. $i == 1 ) ? ' original-card' : ''; ?>">
															<div class="card-header" role="tab">
																<h5 class="mb-0">
																	<a data-toggle="collapse" data-parent="#property-plan" href="#property-plan-<?php echo esc_attr( $i ); ?>" aria-expanded="true" aria-controls="collapseOne">
																		<?php
																			echo isset( $floor_plan['plan_title'] ) && $floor_plan['plan_title'] != '' ? esc_html( $floor_plan['plan_title'] ) : esc_html__('Property Plan', 'zoacres');
																		?>
																	</a>
																	<?php
																	if( $i != 1 ){
																		echo '<span class="close property-plan-close"></span>';
																	}
																	?>
																</h5>
															</div>
													
															<div id="property-plan-<?php echo esc_attr( $i ); ?>" class="collapse" role="tabpanel">
																<div class="card-block">
																	<div class="property-fields">
																		<label for=""><?php esc_html_e('Property Image', 'zoacres'); ?></label>
																		<?php
																			$plan_image = isset( $floor_plan['plan_image'] ) ? $floor_plan['plan_image'] : '';
																			echo '<ul class="nav image-list">';
																				$img_attr = wp_get_attachment_image_src( $plan_image, "thumbnail" );
																				echo '<li><img class="admin-no-image img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="50" height="50" alt="'. esc_attr__( 'No Image', 'zoacres' ) .'" /></li>';
																			echo '</ul>';
																		?>
																		<input type="file" name="property-plan-image-<?php echo esc_attr( $i ); ?>" class="property-plan-image-file property-plan-image-file-<?php echo esc_attr( $i ); ?>" />
																		<input type="hidden" class="property-plan-image-final property-plan-image-final-<?php echo esc_attr( $i ); ?>" name="property_plan_image_final_<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $plan_image ); ?>" />
																	</div>
																	<div class="property-fields">
																		<label for="property-plan-title"><?php esc_html_e('Plan Title', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_title = isset( $floor_plan['plan_title'] ) ? $floor_plan['plan_title'] : '';
																			?>
																			<input class="form-control" name="property_plan_title_<?php echo esc_attr( $i ); ?>" type="text" value="<?php echo esc_html( $plan_title ); ?>" />
																		</div>
																	</div>
																	<div class="property-fields">
																		<label for="property-plan-size"><?php esc_html_e('Plan Size', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_size = isset( $floor_plan['plan_size'] ) ? $floor_plan['plan_size'] : '';
																			?>
																			<input class="form-control" name="property_plan_size_<?php echo esc_attr( $i ); ?>" type="text" value="<?php echo esc_attr( $plan_size ); ?>" />
																		</div>
																	</div>
																	<div class="property-fields">
																		<label for="property-plan-rooms"><?php esc_html_e('Plan Rooms', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_rooms = isset( $floor_plan['plan_rooms'] ) ? $floor_plan['plan_rooms'] : '';
																			?>
																			<input class="form-control" name="property_plan_rooms_<?php echo esc_attr( $i ); ?>" type="text" value="<?php echo esc_attr( $plan_rooms ); ?>" />
																		</div>
																	</div>
																	<div class="property-fields">
																		<label for="property-plan-bathrooms"><?php esc_html_e('Plan Bathrooms', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_bathrooms = isset( $floor_plan['plan_bathrooms'] ) ? $floor_plan['plan_bathrooms'] : '';
																			?>
																			<input class="form-control" name="property_plan_bathrooms_<?php echo esc_attr( $i ); ?>" type="text" value="<?php echo esc_attr( $plan_bathrooms ); ?>" />
																		</div>
																	</div>
																	<div class="property-fields">
																		<label for="property_plan_desc_1"><?php esc_html_e('Plan Description', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_desc = isset( $floor_plan['plan_desc'] ) ? $floor_plan['plan_desc'] : '';
																			?>
																			<textarea class="form-control" name="property_plan_desc_<?php echo esc_attr( $i ); ?>" rows="5">
																			<?php echo wp_kses_post( $plan_desc ); ?>
																			</textarea>
																		</div>
																	</div>
																	<div class="property-fields">
																		<label for="property-plan-price"><?php esc_html_e('Plan Price', 'zoacres'); ?></label>
																		<div>
																			<?php
																				$plan_price = isset( $floor_plan['plan_price'] ) ? $floor_plan['plan_price'] : '';
																			?>
																			<input class="form-control" name="property_plan_price_<?php echo esc_attr( $i ); ?>" type="text" value="<?php echo esc_attr( $plan_price ); ?>" />
																		</div>
																	</div>
																</div>
															</div>
														</div><!-- .original-card -->
														<?php
															$i++;
														} // end foreach
														?>
													</div>
												</div>
												<div class="property-fields">
													<label for="property_map_latitude"><?php esc_html_e('Select Latitude and Longitude with Map', 'zoacres'); ?></label>
													<?php
														$map_lat = get_post_meta( $property_id, 'zoacres_property_latitude', true );
														$map_lng = get_post_meta( $property_id, 'zoacres_property_longitude', true );
													?>
													<div class="property-gmap" id="zoacres_property_location" data-lat="<?php echo esc_attr( $map_lat ); ?>" data-lang="<?php echo esc_attr( $map_lng ); ?>"></div>
													<?php wp_enqueue_script( 'zoacres-gmaps' ); ?>
												</div>									
												<div class="property-fields">
													<label for="property_map_latitude"><?php esc_html_e('Map Latitude', 'zoacres'); ?></label>
													<div>
														<input class="form-control" id="zoacres_property_latitude" name="property_map_latitude" type="text" value="<?php echo esc_attr( $map_lat ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_map_latitude"><?php esc_html_e('Map Longitude', 'zoacres'); ?></label>
													<div>
														<input class="form-control" id="zoacres_property_longitude" name="property_map_longitude" type="text" value="<?php echo esc_attr( $map_lng ); ?>" />
													</div>
												</div>
												<?php
													$property_cf = $zpe->zoacresPropertyThemeOpt('property-custom-fields');
													$property_cf = json_decode( $property_cf, true );
													
													if( $property_cf ):
														$cfi = 0;
														foreach( $property_cf as $fields ){
															
															$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
															$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
															$fld_type = $fields['Field Type'] ? $fields['Field Type'] : 'text';
															$fld_type = $fld_type == 'dropdown' ? 'select' : $fld_type;
			
															$field_value = get_post_meta( $property_id, 'zoacres_property_custom_' . $fld_id, true );
															switch( $fld_type ){
																
																case "text":
																?>
																	<div class="property-fields">
																		<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
																		<div>
																			<input class="form-control" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" type="text" value="<?php echo esc_html( $field_value ); ?>" />
																		</div>
																	</div>
																<?php
																break;
																
																case "textarea":
																?>
																	<div class="property-fields">
																		<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
																		<div>
																			<textarea class="form-control" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>">
																				<?php echo wp_kses_post( $field_value ); ?>
																			</textarea>
																		</div>
																	</div>
																<?php
																break;
																
																case "checkbox":
																?>
																	<div class="property-fields">
																		<div>
																			<?php 
																				$checked = $field_value ? 'checked' : '';
																			?>
																			<input type="checkbox" value="" id="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" <?php echo esc_attr( $checked ); ?>>
																			<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
																		</div>
																	</div>
																<?php
																break;
																
																case "select":
																?>
																	<div class="property-fields">
																		<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
																		<div>
																			<select class="form-control" id="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>">
																			<?php
																				$fld_dd = isset( $fields['Dropdown Values'] ) ? $fields['Dropdown Values'] : '';
																				$dd_array = array();
																				if( $fld_dd ){
																					$dd_values = explode( ",", $fld_dd );
																					foreach( $dd_values as $dd_val ){
																						$dd_key = sanitize_title( $dd_val );
																						$dd_value = esc_html( $dd_val );
																						$dd_array[$dd_key] = $dd_value;
																						$checked = $field_value == $dd_key ? ' selected="selected"' : '';
																						echo '<option value="'. esc_attr( $dd_key ) .'" '. $checked .'>'. esc_html( $dd_value ) .'</option>';
																					}		
																				}
																			?>
																			</select>
																		</div>
																	</div>
																<?php
																break;
																
															}
															
														}
													endif;
												?>
											</div>
											<div class="col-md-6">
												<div class="property-fields">
													<label for="property-gallery-image"><?php esc_html_e('Property Gallery Image', 'zoacres'); ?></label>
													<div>
														<?php
															$galery_ids = get_post_meta( $property_id, 'zoacres_property_gallery', true );
															if( $galery_ids ){
																$tgalery_ids = explode( ",", $galery_ids );
																echo '<ul class="nav image-list">';
																foreach( $tgalery_ids as $galid ){
																	$img_attr = wp_get_attachment_image_src( $galid, "thumbnail" );
																	echo '<li><img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="50" height="50" /></li>';
																}
																echo '</ul>';
															}
														?>
														<input type="file" id="property-gallery-image" multiple="" class="property-gallery-file" />
														<p class="property-gallery-image-status"></p>
														<input type="hidden" class="property-gallery-image-final" name="property_gallery_image_final" value="<?php echo esc_attr( $galery_ids ); ?>" />
														<span class="d-block"><?php esc_html_e('Must choose image files only and images should not exists 500kb', 'zoacres'); ?></span>
													</div>
												</div>
												<div class="property-fields">
													<label for="property_price"><?php esc_html_e('Property Price', 'zoacres'); ?></label>
													<div>
														<?php
															$property_price = get_post_meta( $property_id, 'zoacres_property_price', true );
														?>
														<input class="form-control" name="property_price" type="text" value="<?php echo esc_attr( $property_price ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_price_before"><?php esc_html_e('Property Before Price Label', 'zoacres'); ?></label>
													<div>
														<?php
															$before_label = get_post_meta( $property_id, 'zoacres_property_before_price_label', true );
														?>
														<input class="form-control" name="property_price_before" type="text" value="<?php echo esc_attr( $before_label ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_price_after"><?php esc_html_e('Property After Price Label', 'zoacres'); ?></label>
													<div>
														<?php
															$after_label = get_post_meta( $property_id, 'zoacres_property_after_price_label', true );
														?>
														<input class="form-control" name="property_price_after" type="text" value="<?php echo esc_attr( $after_label ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_size"><?php esc_html_e('Property Size', 'zoacres'); ?></label>
													<div>
														<?php
															$property_size = get_post_meta( $property_id, 'zoacres_property_size', true );
														?>
														<input class="form-control" name="property_size" type="text" value="<?php echo esc_attr( $property_size ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_lot_size"><?php esc_html_e('Property Lot Size', 'zoacres'); ?></label>
													<div>
														<?php
															$property_lot_size = get_post_meta( $property_id, 'zoacres_property_lot_size', true );
														?>
														<input class="form-control" name="property_lot_size" type="text" value="<?php echo esc_attr( $property_lot_size ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_no_rooms"><?php esc_html_e('Number of Rooms', 'zoacres'); ?></label>
													<div>
														<?php
															$no_rooms = get_post_meta( $property_id, 'zoacres_property_no_rooms', true );
														?>
														<input class="form-control" name="property_no_rooms" type="text" value="<?php echo esc_attr( $no_rooms ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_no_bed_rooms"><?php esc_html_e('Number of Bed Rooms', 'zoacres'); ?></label>
													<div>
														<?php
															$no_bed_rooms = get_post_meta( $property_id, 'zoacres_property_no_bed_rooms', true );
														?>
														<input class="form-control" name="property_no_bed_rooms" type="text" value="<?php echo esc_attr( $no_bed_rooms ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_no_bath_rooms"><?php esc_html_e('Number of Bath Rooms', 'zoacres'); ?></label>
													<div>
														<?php
															$no_bath_rooms = get_post_meta( $property_id, 'zoacres_property_no_bath_rooms', true );
														?>
														<input class="form-control" name="property_no_bath_rooms" type="text" value="<?php echo esc_attr( $no_bath_rooms ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_no_garages"><?php esc_html_e('Number of Garages', 'zoacres'); ?></label>
													<div>
														<?php
															$no_garages = get_post_meta( $property_id, 'zoacres_property_no_garages', true );
														?>
														<input class="form-control" name="property_no_garages" type="text" value="<?php echo esc_attr( $no_garages ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_zip"><?php esc_html_e('Property ZIP', 'zoacres'); ?></label>
													<div>
														<?php
															$property_zip = get_post_meta( $property_id, 'zoacres_property_zip', true );
														?>
														<input class="form-control" name="property_zip" type="text" value="<?php echo esc_attr( $property_zip ); ?>" />
													</div>
												</div>
												<div class="property-fields">
													<label for="property_structure"><?php esc_html_e('Property Structure', 'zoacres'); ?></label>
													<div>
														<!--<ul class="meta_box_items">-->
														<?php
			
														/*$property_structures = $zpe->zoacresPropertyThemeOpt('property-structure');
														$property_structures_arr = zoacres_trim_array_same_values( $property_structures );
														
														$property_sel_structures = get_post_meta( $property_id, 'zoacres_property_structures', true );
														$selected_structures = !empty( $property_sel_structures ) ? $property_sel_structures : array(); 
														
														foreach ( $property_structures_arr as $value => $label ){
															$checked = in_array( $value, $selected_structures ) ? 'checked' : '';
															echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="property_structures[]" '. esc_attr( $checked ) .'>'. esc_html( $label ) .'</li>';
														}*/
														
														?>
														<!--</ul>-->
														
														<ul class="nav meta_box_items">
														<?php
															$property_structures = $zpe->zoacresPropertyThemeOpt('property-structure');
															$property_structures_arr = zoacres_trim_array_same_values( $property_structures );
															foreach ( $property_structures_arr as $value => $label ){
																$structure_val = get_post_meta( $property_id, 'zoacres_property_structures_'. sanitize_title( $value ), true );
																$checked = $structure_val ? 'checked' : '';
																echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="zoacres_property_structures_'. sanitize_title( $value ) .'" '. esc_attr( $checked ) .'>'. esc_html( $label ) .'</li>';
															}
														?>
														</ul>
													</div>
												</div>
												<div class="property-fields">
													<label for="property_video_type"><?php esc_html_e('Video Type', 'zoacres'); ?></label>
													<div>
														<?php
															$video_type = get_post_meta( $property_id, 'zoacres_property_video_type', true );
														?>
														<select class="form-control" id="property_video_type" name="property_video_type">
															<option value="none" <?php echo ( ''. $video_type == "none" ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'zoacres' ); ?></option>
															<option value="youtube" <?php echo ( ''. $video_type == "youtube" ) ? 'selected"selected"' : ''; ?>><?php esc_html_e( 'Youtube', 'zoacres' ); ?></option>
															<option value="vimeo" <?php echo ( ''. $video_type == "vimeo" ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Vimeo', 'zoacres' ); ?></option>
															<option value="custom" <?php echo ( ''. $video_type == "custom" ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Custom Video', 'zoacres' ); ?></option>
														</select>			
													</div>
													<span class="d-block"><?php esc_html_e('Choose video type for property. You can explain customers via video about your property features.', 'zoacres'); ?></span>
												</div>
												<div data-opr="!=" data-equal="none" data-req="property_video_type" class="meta-req property-fields">
													<label for="property_zip"><?php esc_html_e('Property Video ID', 'zoacres'); ?></label>
													<div>
														<?php
															$video_id = get_post_meta( $property_id, 'zoacres_property_video_id', true );
														?>
														<input class="form-control" name="property_video_id" type="text" value="<?php echo esc_attr( $video_id ); ?>" />
													</div>
													<span class="d-block"><?php esc_html_e('Enter Video ID Example: ZSt9tm3RoUU. If you choose custom video type then you enter custom video url and video must be mp4 format.', 'zoacres'); ?></span>
												</div>
												<div class="property-fields">
													<label for="property_ribbon"><?php esc_html_e('Property Ribbons', 'zoacres'); ?></label>
													<div>
														<ul class="meta_box_items">
														<?php
														
														$property_ribbon = $zpe->zoacresPropertyThemeOpt('property-ribbon-colors');
														$property_ribbon_arr = zoacres_trim_array_color_labels( $property_ribbon );
														
														$property_status = get_post_meta( $property_id, 'zoacres_property_status', true );
														$selected_status = !empty( $property_status ) ? $property_status : array();
														
														foreach ( $property_ribbon_arr as $value => $label ){
															$checked = in_array( $value, $selected_status ) ? 'checked' : '';
															echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="property_ribbons[]"'. esc_attr( $checked ) .'>'. esc_html( $label ) .'</li>';
														}
														
														?>
														</ul>
													</div>
												</div>
												<div class="property-fields">
													<label for="property-docs-file"><?php esc_html_e('Property Documents', 'zoacres'); ?></label>
													<div class="property-docs-file-inner">
														<input type="file" id="property-docs-file" multiple="" class="property-docs-file" />
														<p class="property-docs-file-status"></p>
														<?php 
															$doc_ids = get_post_meta( $property_id, 'zoacres_property_documents', true );
															
															$attc_out = '';
															if( $doc_ids ){
																$attc_ids = explode(",", $doc_ids);
																echo '<ul class="zoacres-docs-list">';
																foreach( $attc_ids as $attc_id ){
																	$attc_url = wp_get_attachment_url( $attc_id );
																	$attc_ids = explode("/", $attc_url);
																	$attc_name = $attc_ids[count($attc_ids) - 1];
																	echo '<li data-id="'. esc_attr( $attc_id  ) .'">'. esc_html( $attc_name ) .' <span class="fa fa-close"></span></li>';
																}
																echo '</ul>';
															}
														?>
														<input type="hidden" class="property-docs-file-final" name="property_docs_file_final" value="<?php echo esc_attr( $doc_ids ); ?>" />
														<span class="d-block"><?php esc_html_e('You can upload property documents like pdf.', 'zoacres'); ?></span>
													</div>
												</div>
												<div class="property-fields property-upload-parent">
													<a href="#" class="btn btn-default update-property-ajax"><?php echo apply_filters( 'zoacres_property_upload_button', esc_html__( 'Update Property', 'zoacres' ) ); ?></a>										
													<img class="property-new-process" src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>" alt="<?php esc_attr_e('Loader', 'zoacres'); ?>" />
												</div>
											</div>
										
										</div>
									</form>
								</div><!-- .add-new-property -->
						<?php 
							else: 
						?>
							<div class="invalide-product-wrap">
								<h3><?php esc_html_e('Invalid Product', 'zoacres'); ?></h3>
							</div>
						<?php
							endif; //stat check 
						?>
					</div><!-- Dashboard Package row -->
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
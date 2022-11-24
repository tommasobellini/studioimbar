<?php
/**
*	Template Name: User Add New Property
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
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_dash_link ); ?>" class="d-block user_tab_active"> <i class="fa fa-plus"></i><?php esc_html_e('Add New Property', 'zoacres'); ?></a></li>
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
						<div class="pack_description">
							<?php
								
								$last_pack = get_user_meta( $current_user->ID, 'zoacres_package_last_updated', true );
								
								$def_listing_count = $zpe->zoacresPropertyThemeOpt('free-member-listings');
								$def_featured_count = $zpe->zoacresPropertyThemeOpt('free-member-featured');
								$def_image_limi = $zpe->zoacresPropertyThemeOpt('free-member-img-limit');
								
								if( empty( $last_pack ) ){
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
								}
								
								$pack_details = $last_pack['pack_details'];
								
								$pack_id = $last_pack['pack_id'];
								$pack_title = $pack_id != '' ? get_the_title( $pack_id ) : esc_html__( 'Free Package', 'zoacres' );
								$duration = $date = '';
								
								if( $pack_details['pack_time_limit'] ) {
									$time_units = $pack_details['pack_time_units'];
									$time_units = !empty( $time_units ) ? $time_units : 1;
									$time_limit = $pack_details['pack_time_limit'];
									$time_val = '';
									if( $time_limit == 'week' ){
										$time_val = $time_units == 1 ? esc_html__( 'Week', 'zoacres' ) : esc_html__( 'Weeks', 'zoacres' ) ;
									}elseif( $time_limit == 'month' ){
										$time_val = $time_units == 1 ? esc_html__( 'Month', 'zoacres' ) : esc_html__( 'Months', 'zoacres' ) ;
									}elseif( $time_limit == 'year' ){
										$time_val = $time_units == 1 ? esc_html__( 'Year', 'zoacres' ) : esc_html__( 'Years', 'zoacres' ) ;
									}else{
										$time_val = $time_units == 1 ? esc_html__( 'Day', 'zoacres' ) : esc_html__( 'Days', 'zoacres' ) ;
									}
									$duration = $time_units .' '. $time_val;
								
								}

								$active_stat = 0;
								$exp_date = '';
								if( $last_pack ):

									$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
									$agent_post_count = zoacres_get_agent_post_count( $agent_id );
									
									$list_stat = $pack_details['pack_listing_stat'];
									$list_limit = 2;
									if( $list_stat == 'lim' ){
										$list_limit = $pack_details['pack_listing_count'];
										$remaining_properties = $list_limit - $agent_post_count;
									}else{
										$remaining_properties = '-';
										$list_limit = absint( $agent_post_count ) + 1;
									}

									if( $agent_post_count < $list_limit ){
										$active_stat = 1;
									}
									
									if( isset( $last_pack['pack_expiry'] ) && $last_pack['pack_expiry'] != '' ) {
										$exp_date = $last_pack['pack_expiry'];
										$date = date( 'Y-m-d', $exp_date );
										
										$days_diff = 0;
										if( $exp_date ){
											$date_now = time();
											$datediff = $exp_date - $date_now;
											$days_diff = round( $datediff / (60 * 60 * 24) );
										}
										if( $active_stat ){
											if( $days_diff >= 0 ){
												$active_stat = 1;
											}else{
												$active_stat = 0;
											}
										}								
										
									}
								endif;
								
								$listing_stat = $pack_details['pack_listing_stat'];
								$limit_count = '';
								if( $listing_stat == 'lim'){
									$limit_count = $pack_details['pack_listing_count'];
									$limit_count = $limit_count;
								}else{
									$limit_count = esc_html__( 'Unlimited', 'zoacres' );
								}
								
								$featured_count = $pack_details['pack_featured_count'];
								$featured_count = $featured_count . esc_html__( ' Featured', 'zoacres' );
								$agent_featured_count = zoacres_get_agent_featured_count( $agent_id );
								$remains_featured = $featured_count - $agent_featured_count;
								
								$img_stat = $pack_details['pack_image_stat'];
								$img_count = '';
								if( $img_stat == 'lim'){
									$img_count = $pack_details['package_image_limit'];
									$img_count = $img_count . esc_html__( ' Images / Per Listing', 'zoacres' );
								}else{
									$img_count = esc_html__( 'Unlimited Images / Per Listing', 'zoacres' );
								}

							?>
							<div class="pack-unit">
								<div class="pack_description_unit_head">
									<h4 class="align-middle"><?php esc_html_e('Your Current Package:', 'zoacres'); ?> <?php echo esc_html( $pack_title ); ?></h4>
								</div>
								<!-- Pack description unit -->
								<table class="table">
									<tr>
										<td class="pack-duration"><?php esc_html_e('Duration:', 'zoacres'); ?> <?php echo esc_html( $duration ); ?></td>
										<td>
											<div class="day-counter" data-date="<?php echo esc_attr( $date ); ?>">
												<div class="counter-day">
													<div class="counter-item">
														<h3 class="typo-white"></h3>
														<span><?php echo esc_html__( 'Days', 'zoacres' ); ?></span>
													</div>
												</div><!-- .counter-hour -->
												<div class="counter-hour">
													<div class="counter-item">
														<h3 class="typo-white"></h3>
														<span><?php echo esc_html__( 'Hours', 'zoacres' ); ?></span>
													</div>
												</div><!-- .counter-min -->
												<div class="counter-min">
													<div class="counter-item">
														<h3 class="typo-white"></h3>
														<span><?php echo esc_html__( 'Minutes', 'zoacres' ); ?></span>
													</div>
												</div><!-- .counter-day -->
											</div><!-- .day-counter -->
										</td>
									</tr>
									<tr>
										<td><?php esc_html_e('Listings:', 'zoacres'); ?> <?php echo esc_html( $limit_count ); ?></td>
										<td><?php esc_html_e('Remaining:', 'zoacres'); ?> <?php echo esc_html( $remaining_properties ); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Featured Listings:', 'zoacres'); ?> <?php echo esc_html( $featured_count ); ?></td>
										<td><?php esc_html_e('Remaining:', 'zoacres'); ?> <?php echo esc_html( $remains_featured ); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Images Count:', 'zoacres'); ?> <?php echo esc_html( $img_count ); ?></td>
										<td><?php echo esc_html( $img_count ); ?></td>
									</tr>
								</table>
							</div>
							<!-- Pack Unit -->
							
							<?php
							
							$premium_stat = $zpe->zoacresPropertyThemeOpt('package-premium-status');
							if( $premium_stat ): // Premium stat check
							
								if( $pack_id ):
									$pack_stripe_id = get_post_meta( $pack_id, 'zoacres_package_stripe_id', true );
									if( $pack_stripe_id ){
										
										$days_diff = 8;
										if( $exp_date ){
											$date_now = time();
											$datediff = $exp_date - $date_now;
											$days_diff = round( $datediff / (60 * 60 * 24) );
										}
										
										if( $days_diff < 8 ){
							?>
											<div class="package-renewal-wrap">
												<div class="get-package">
													
													<a href="#" class="btn btn-default package-renewal-toggle-trigger"><?php esc_html_e( 'Package Renewal', 'zoacres' ); ?></a>
													<span class="package-renewal-trigger" data-pack-id="<?php echo esc_attr( $pack_stripe_id ); ?>" data-toggle="modal" data-target="#paymentModal<?php echo esc_attr( $pack_id ); ?>"></span>
												</div><!-- .get-package -->
											</div>
							<?php
										}//Days diff less than 7
									} // pack_stripe_id
								endif; // pack_id
							endif; // Premium stat check end
							?>
						</div>

						<?php
							if( $premium_stat ): // Premium stat check
						?>
						<div class="available-pack clearfix">
							<p><a class="package-toggle-org" data-toggle="collapse" href="#package-toggle" role="button" aria-expanded="false" aria-controls="package-toggle"><?php esc_html_e( 'See Available Packages and Payment Methods', 'zoacres' ); ?> <i class="fa fa-angle-up"></i></a></p>
							<div class="collapse" id="package-toggle">
								<div class="pack_description_row">
									<div class="pack_description_unit_head">
										<h4><?php esc_html_e( 'Packages Available', 'zoacres' ); ?></h4>
									</div>
									<div class="pack-unit">
										<?php
										
											$sel_pack = $pack_id;
										
											$currency = $zpe->zoacresPropertyThemeOpt('package-currencies');
											if( $currency ){
												if( $currency != 'custom' ){
													$currency = $zpe->zoacresPropertyThemeOpt('package-currencies');
												}else if( $currency == 'custom' ){
													$currency = $zpe->zoacresPropertyThemeOpt('package-custom-currency');
												}
											}else{
												$currency = 'USD';
											}
											
											
											$site_title = get_bloginfo( 'name' );
																			
											$stripe_page = get_pages(array(
												'meta_key' => '_wp_page_template',
												'meta_value' => 'stripecharge.php'
											));
											if( $stripe_page ){
												$stripe_dash_link = get_permalink( $stripe_page[0]->ID );
											}else{
												$stripe_dash_link = home_url( '/' );
											} 
											
											$stirpe_public = $zpe->zoacresPropertyThemeOpt('stirpe-public-key');
											
											//Paypal dashboard link
											$paypal_page = get_pages(array(
												'meta_key' => '_wp_page_template',
												'meta_value' => 'paypalcharge.php'
											));
											if( $paypal_page ){
												$paypal_dash_link = get_permalink( $paypal_page[0]->ID );
											}else{
												$paypal_dash_link = home_url( '/' );
											} 
											
											
											$args = array(
												'post_type' => 'zoacres-package',
												'posts_per_page' => -1
											);											
											// The Query
											$the_query = new WP_Query( $args );
											
											// The Loop
											if ( $the_query->have_posts() ) {
												while ( $the_query->have_posts() ) {
													$the_query->the_post();
													$pack_id = get_the_ID();
													
													$pack_price_set = '';
													$pack_price = get_post_meta( $pack_id, 'zoacres_package_price', true );
													
													$pack_time_lmt = get_post_meta( $pack_id, 'zoacres_package_time_limit', true );
													$pack_units = get_post_meta( $pack_id, 'zoacres_package_time_units', true );
													$pack_price_set = $currency .' '. $pack_price .' / '. $pack_units .' '. $pack_time_lmt;
													
													$listing_stat = get_post_meta( $pack_id, 'zoacres_package_listing_count_stat', true );
													$limit_count = '';
													if( $listing_stat == 'lim'){
														$limit_count = get_post_meta( $pack_id, 'zoacres_package_listing_count', true );
														$limit_count = $limit_count . esc_html__( ' Listings ', 'zoacres' );
													}else{
														$limit_count = esc_html__( 'Unlimited Listings', 'zoacres' );
													}
													
													$featured_count = get_post_meta( $pack_id, 'zoacres_package_featured_count', true );
													$featured_count = $featured_count . esc_html__( ' Featured', 'zoacres' );
													
													$img_stat = get_post_meta( $pack_id, 'zoacres_package_image_max_stat', true );
													$img_count = '';
													if( $img_stat == 'lim'){
														$img_count = get_post_meta( $pack_id, 'zoacres_package_image_max', true );
														$img_count = $img_count . esc_html__( ' Images ', 'zoacres' );
													}else{
														$img_count = esc_html__( 'Unlimited Images / Per Listing', 'zoacres' );
													}
													
													$pack_stripe_id = get_post_meta( $pack_id, 'zoacres_package_stripe_id', true );
													
													$pack_title = get_the_title();
													
													$pack_price_final = $pack_price * 100;
													$pack_desc = $pack_title .' ('. $currency .' '. $pack_price .')';
													
													$classes = $sel_pack == $pack_id ? ' running-pack' : '';
													
													echo '<div class="pack-listing'. esc_attr( $classes ) .'">
															<div class="pack-listing-title">'. esc_html( $pack_title ) .'</div>
															<div class="submit-price">'. esc_html( $pack_price_set ) .'</div>
															<div class="pack-listing-period">'. esc_html( $limit_count ) .'</div>
															<div class="pack-listing-period">'. esc_html( $featured_count ) .'</div>
															<div class="pack-listing-period">'. esc_html( $img_count ) .'</div>
															<div class="get-package">
																<a href="#" class="btn btn-default" data-pack-id="'. esc_attr( $pack_stripe_id ) .'" data-toggle="modal" data-target="#paymentModal'. esc_attr( $pack_id ) .'">'. esc_html__( 'Choose Package', 'zoacres' ) .'</a>
															</div><!-- .get-package -->
														</div><!-- .pack-listing -->';
														
													echo '<!-- Modal -->
														<div class="modal fade" id="paymentModal'. esc_attr( $pack_id ) .'" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title">'. esc_html__( 'Choose Payment Method', 'zoacres' ) .'</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="'. esc_html__( 'Close', 'zoacres' ) .'"></button>
																	</div>
																	<div class="modal-body paypal-modal-body">';
																	
																	$stirpe_status = $zpe->zoacresPropertyThemeOpt('package-stirpe-status');
																	if( $stirpe_status ):
																		echo '<div class="package-stripe-wrap">
																			<form action="'. esc_url( $stripe_dash_link ) .'" id="package-form" method="POST">
																				<script src="'. esc_url( 'https://checkout.stripe.com/checkout.js' ) .'" class="stripe-button"
																					data-key="'. esc_attr( $stirpe_public ) .'"
																					data-name="'. esc_attr( $site_title ) .'"
																					data-description="'. esc_attr( $pack_desc ) .'"
																					data-amount="'. esc_attr( $pack_price_final ) .'"
																					data-currency="'. esc_attr( $currency ) .'">
																				</script>
																				<input type="hidden" name="pay_amount" value="'. esc_attr( $pack_price_final ) .'">
																				<input type="hidden" name="pack_id" value="'. esc_attr( $pack_id ) .'">
																				<input type="hidden" name="currency" value="'. esc_attr( $currency ) .'">
																			</form>
																		</div>';
																	endif;
																	
																	$paypal_status = $zpe->zoacresPropertyThemeOpt('package-paypal-status');
																	if( $paypal_status ):
																		echo '<div class="package-paypal-wrap">
																			<form action="'. esc_url( $paypal_dash_link ) .'" id="paypal-package-form" method="POST">
																				<button type="submit" class="paypal-pay-trigger" />
																					<img src="'. esc_url( ZOACRES_ASSETS . '/images/paypal.png' ) .'" class="img-fulid" alt="'. esc_attr__( 'paypal', 'zoacres' ) .'" />
																				</button>
																				'. wp_nonce_field( 'paypal_nonce', 'paypal_security' ) .'
																				<input type="checkbox" name="paypal_recurring" class="form-check-input" value="yes"> '. esc_html__( 'Recurring', 'zoacres' ) .' 
																				<input type="hidden" name="pack_id" class="paypal-pack-id" value="'. esc_attr( $pack_id ) .'">
																				<input type="hidden" name="pack_name" class="paypal-pack-name" value="'. esc_attr( $pack_title ) .'">
																				<input type="hidden" name="currency" class="paypal-currency" value="'. esc_attr( $currency ) .'">
																			</form>
																		</div>';
																	endif;
																echo '</div>
																</div>
															</div>
														</div>';

												}
												wp_reset_postdata();
											}
										?>

									</div>
									<!-- Pack Unit -->
									
								</div>
								<!-- Pack Description Row -->
							</div>
							<!-- Collapse -->
						</div>
						<!-- Available pack -->
						<?php 
						
							endif; // Premium stat check end
							
							
							$active_stat = zoacres_agent_eligible_check( $last_pack, $agent_id );
						
							if( $active_stat ): 
						?>
							
						<div class="add-new-property">
							<form id="add-new-property-form" method="post" enctype="multipart/form-data">
							<h3 class="typo-white"><?php esc_html_e('Add Property', 'zoacres'); ?></h3>
							<p>
								<label for="property-title"><?php esc_html_e('Property Title', 'zoacres'); ?></label>
								<input type="text" id="property-title" class="form-control" value="" name="property_title">
								<span class="field-description"><?php esc_html_e( 'Here you can add your property title.', 'zoacres' ); ?></span>
							</p>
							<p>
								<label for="property-desc"><?php esc_html_e('Property Description', 'zoacres'); ?></label>
								<textarea class="form-control" rows="10" name="property_desc" id="property-desc"></textarea>
								<span class="field-description"><?php esc_html_e( 'Here you can explain about your property details and etc.', 'zoacres' ); ?></span>
							</p>
							<div class="row properties-input">
								<div class="col-md-6">
									<div class="property-fields">
										<label for="property-image"><?php esc_html_e('Property Categories', 'zoacres'); ?></label>
										<?php
											ob_start();
											$terms = get_terms( 'property-category', array(
												'post_type' => array('zoacres-property'),
												'hide_empty' => false,
											) );
											if( $terms ): ?>
												<div>
													<ul class="nav meta_box_items">
											<?php
												foreach( $terms as $cpt_term ){
													echo '<li><input name="property_category[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
												}
											?>
													</ul>
												</div>
												<span class="field-description"><?php esc_html_e( 'Select your property category.', 'zoacres' ); ?></span>
											<?php
											endif;
											$cats_out = ob_get_clean();
											echo apply_filters( 'zoacres_property_add_new_categories', $cats_out );
										?>
									</div>
									<div class="property-fields">
										<label for="property-image"><?php esc_html_e('Property Actions', 'zoacres'); ?></label>
										<?php
											$terms = get_terms( 'property-action', array(
												'post_type' => array('zoacres-property'),
												'hide_empty' => false,
											) );
											if( $terms ): ?>
												<div>
													<ul class="nav meta_box_items">
											<?php
												foreach( $terms as $cpt_term ){
													echo '<li><input name="property_action[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
												}
											?>
													</ul>
												</div>
												<span class="field-description"><?php esc_html_e( 'Select your Actions details.', 'zoacres' ); ?></span>
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
											if( $terms ): ?>
												<div>
													<ul class="nav meta_box_items">
											<?php
												foreach( $terms as $cpt_term ){
													echo '<li><input name="property_area[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
												}
											?>
													</ul>
												</div>
												<span class="field-description"><?php esc_html_e( 'Here you can select your property located Area.', 'zoacres' ); ?></span>
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
													if( $terms ): ?>
														<div>
															<ul class="nav meta_box_items">
													<?php
														foreach( $terms as $cpt_term ){
															echo '<li><input name="property_city[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
														}
													?>
															</ul>
														</div>
														<span class="field-description"><?php esc_html_e( 'Here you can select your property located City.', 'zoacres' ); ?></span>
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
													if( $terms ): ?>
														<div>
															<ul class="nav meta_box_items">
													<?php
														foreach( $terms as $cpt_term ){
															echo '<li><input name="property_state[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
														}
													?>
															</ul>
														</div>
														<span class="field-description"><?php esc_html_e( 'Here you can select your Property located State.', 'zoacres' ); ?></span>
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
													if( $terms ): ?>
														<div>
															<ul class="nav meta_box_items">
													<?php
														foreach( $terms as $cpt_term ){
															echo '<li><input name="property_country[]" type="checkbox" value="'. esc_attr( $cpt_term->term_id ) .'" /> '. esc_html( $cpt_term->name ) .'</li>';
														}
													?>
															</ul>
														</div>
														<span class="field-description"><?php esc_html_e( 'Here you can select your Property located country.', 'zoacres' ); ?></span>
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
											<input type="file" class="property-image-file" />
											<input type="hidden" class="property-image-final" name="property_image_final" value="" />
											<span class="d-block"><?php esc_html_e('Must choose image files only and images should not exists 500kb', 'zoacres'); ?></span>
										</div>
								   </div>
								   <div class="property-fields">
										<label for="property_address"><?php esc_html_e('Property Address', 'zoacres'); ?></label>
										<div>
											<textarea class="form-control" name="property_address" rows="5"></textarea>
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add address details of your property.', 'zoacres' ); ?></span>
								   </div>
								   <div class="property-fields">
										<label for="property_virtual_tour"><?php esc_html_e('Virtual Tour Iframe URL', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_virtual_tour" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can show your virtual tour 360. Virtual tour iframe available here: https://matterport.com/gallery/', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property-360-image"><?php esc_html_e( '360&deg; Image URL', 'zoacres' ); ?></label>
										<div>
											<input type="file" class="property-360-image-file" />
											<input type="hidden" class="property-360-image-final" name="property_360_image_final" value="" />
											<span class="d-block"><?php esc_html_e('Enter property 360&#176; image url for single property page.', 'zoacres'); ?></span>
										</div>	
										<span class="field-description"><?php esc_html_e( 'Enter property 360&deg; image url for single property page.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_ribbon"><?php esc_html_e('Property Features', 'zoacres'); ?></label>
										<div>
											<ul class="nav meta_box_items">
											<?php
											
											$property_features = $zpe->zoacresPropertyThemeOpt('property-features');
											$property_features_arr = zoacres_trim_array_same_values( $property_features );
											
											foreach ( $property_features_arr as $value => $label ){
												echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="property_features_'. sanitize_title( $value ) .'" />'. esc_html( $label ) .'</li>';
											}
											
											?>
											</ul>
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can select Features and amenities of your property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<div class="d-inline-child">
											<label for="property_floor_plans"><?php esc_html_e('Floor Plans', 'zoacres'); ?></label>
											<a href="#" class="btn btn-default pull-right property-plan-add"><?php esc_html_e('Add More', 'zoacres'); ?></a>
											<input type="hidden" class="property-plan-ids" name="property_plan_ids" value="1" />
										</div>
										<div id="property-plan" class="property-plan" role="tablist" aria-multiselectable="false">
											
											<div class="card original-card">
												<div class="card-header" role="tab">
													<h5 class="mb-0">
														<a data-toggle="collapse" data-parent="#property-plan" href="#property-plan-1" aria-expanded="true" aria-controls="collapseOne">
															<?php esc_html_e('Property Plan', 'zoacres'); ?>
														</a>
													</h5>
													<span class="field-description"><?php esc_html_e( 'Here you can upload your property floor plans and details.', 'zoacres' ); ?></span>
												</div>
												
										
												<div id="property-plan-1" class="collapse" role="tabpanel">
													<div class="card-block">
														<div class="property-fields">
															<label for=""><?php esc_html_e('Property Image', 'zoacres'); ?></label>
															<input type="file" name="property-plan-image-1" class="property-plan-image-file property-plan-image-file-1" />
															<input type="hidden" class="property-plan-image-final property-plan-image-final-1" name="property_plan_image_final_1" value="" />
														</div>
														<div class="property-fields">
															<label for="property-plan-title"><?php esc_html_e('Plan Title', 'zoacres'); ?></label>
															<div>
																<input class="form-control" name="property_plan_title_1" type="text" />
															</div>
														</div>
														<div class="property-fields">
															<label for="property-plan-size"><?php esc_html_e('Plan Size', 'zoacres'); ?></label>
															<div>
																<input class="form-control" name="property_plan_size_1" type="text" />
															</div>
														</div>
														<div class="property-fields">
															<label for="property-plan-rooms"><?php esc_html_e('Plan Rooms', 'zoacres'); ?></label>
															<div>
																<input class="form-control" name="property_plan_rooms_1" type="text" />
															</div>
														</div>
														<div class="property-fields">
															<label for="property-plan-bathrooms"><?php esc_html_e('Plan Bathrooms', 'zoacres'); ?></label>
															<div>
																<input class="form-control" name="property_plan_bathrooms_1" type="text" />
															</div>
														</div>
														<div class="property-fields">
															<label for="property_plan_desc_1"><?php esc_html_e('Plan Description', 'zoacres'); ?></label>
															<div>
																<textarea class="form-control" name="property_plan_desc_1" rows="5"></textarea>
															</div>
														</div>
														<div class="property-fields">
															<label for="property-plan-price"><?php esc_html_e('Plan Price', 'zoacres'); ?></label>
															<div>
																<input class="form-control" name="property_plan_price_1" type="text" />
															</div>
														</div>
													</div>
												</div>
											</div><!-- .original-card -->
											
										</div>
									</div>
									<div class="property-fields">
										<label for="property_map_latitude"><?php esc_html_e('Select Latitude and Longitude with Map', 'zoacres'); ?></label>
										<div class="property-gmap" id="zoacres_property_location" data-lat="-34.397" data-lang="150.644"></div>
										<?php wp_enqueue_script( 'zoacres-gmaps' ); ?>
										<span class="field-description"><?php esc_html_e( 'Here you can choose your property location by clicking on Google map or also you can add Latitude and Longitude manually.', 'zoacres' ); ?></span>
									</div>									
									<div class="property-fields">
										<label for="property_map_latitude"><?php esc_html_e('Map Latitude', 'zoacres'); ?></label>
										<div>
											<input class="form-control" id="zoacres_property_latitude" name="property_map_latitude" type="text" />
										</div>
										
									</div>
									<div class="property-fields">
										<label for="property_map_latitude"><?php esc_html_e('Map Longitude', 'zoacres'); ?></label>
										<div>
											<input class="form-control" id="zoacres_property_longitude" name="property_map_longitude" type="text" />
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
												
												switch( $fld_type ){
													
													case "text":
													?>
														<div class="property-fields">
															<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
															<div>
																<input class="form-control" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" type="text" />
															</div>
														</div>
													<?php
													break;
													
													case "textarea":
													?>
														<div class="property-fields">
															<label for="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"><?php echo esc_html( $fld_name ); ?></label>
															<div>
																<textarea class="form-control" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>"></textarea>
															</div>
														</div>
													<?php
													break;
													
													case "checkbox":
													?>
														<div class="property-fields">
															<div>
																<input type="checkbox" value="" id="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>" name="<?php echo esc_attr( 'zoacres_property_custom_' . $fld_id ); ?>">
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
																			echo '<option value="'. esc_attr( $dd_key ) .'">'. esc_html( $dd_value ) .'</option>';
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
											<input type="file" id="property-gallery-image" multiple="" class="property-gallery-file" />
											<p class="property-gallery-image-status"></p>
											<input type="hidden" class="property-gallery-image-final" name="property_gallery_image_final" value="" />
											<span class="field-description"><?php esc_html_e( 'Must choose image files only and images should not exists 500kb.', 'zoacres' ); ?></span>
										</div>
									</div>
									<div class="property-fields">
										<label for="property_price"><?php esc_html_e('Property Price', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_price" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add pricing of your property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_price_before"><?php esc_html_e('Property Before Price Label', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_price_before" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add before price label example: Monthly , Yearly etc.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_price_after"><?php esc_html_e('Property After Price Label', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_price_after" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add after price label example: Per month , Per week , Per Year etc.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_size"><?php esc_html_e('Property Size', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_size" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add your property Area size.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_lot_size"><?php esc_html_e('Property Lot Size', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_lot_size" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add your property Total Lot area size.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_no_rooms"><?php esc_html_e('Number of Rooms', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_no_rooms" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can mention total number rooms in your property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_no_bed_rooms"><?php esc_html_e('Number of Bed Rooms', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_no_bed_rooms" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can mention total number Bed rooms in your property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_no_bath_rooms"><?php esc_html_e('Number of Bath Rooms', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_no_bath_rooms" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can mention total number Bathrooms in your property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_no_garages"><?php esc_html_e('Number of Garages', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_no_garages" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add Total Garages count of your Property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_zip"><?php esc_html_e('Property ZIP', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_zip" type="text" />
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can add your Property Location zip.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_structure"><?php esc_html_e('Property Structure', 'zoacres'); ?></label>
										<div>
											<ul class="meta_box_items">
											<?php

											$property_structures = $zpe->zoacresPropertyThemeOpt('property-structure');
											$property_structures_arr = zoacres_trim_array_same_values( $property_structures );
											
											foreach ( $property_structures_arr as $value => $label ){
												echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="property_structures[]" />'. esc_html( $label ) .'</li>';
											}
											
											?>
											</ul>
										</div>
										<span class="field-description"><?php esc_html_e( 'You can select here you property structure type.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property_video_type"><?php esc_html_e('Video Type', 'zoacres'); ?></label>
										<div>
											<select class="form-control" id="property_video_type" name="property_video_type">
												<option value="none"><?php esc_html_e( 'None', 'zoacres' ); ?></option>
												<option value="youtube"><?php esc_html_e( 'Youtube', 'zoacres' ); ?></option>
												<option value="vimeo"><?php esc_html_e( 'Vimeo', 'zoacres' ); ?></option>
												<option value="custom"><?php esc_html_e( 'Custom Video', 'zoacres' ); ?></option>
											</select>			
										</div>
										<span class="d-block"><?php esc_html_e('Choose video type for property. You can explain customers via video about your property features.', 'zoacres'); ?></span>
									</div>
									<div data-opr="!=" data-equal="none" data-req="property_video_type" class="meta-req property-fields">
										<label for="property_zip"><?php esc_html_e('Property Video ID', 'zoacres'); ?></label>
										<div>
											<input class="form-control" name="property_video_id" type="text" />
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
											
											foreach ( $property_ribbon_arr as $value => $label ){
												echo '<li><input type="checkbox" value="' . esc_attr( $value ) . '" name="property_ribbons[]" />'. esc_html( $label ) .'</li>';
											}
											
											?>
											</ul>
										</div>
										<span class="field-description"><?php esc_html_e( 'Here you can select your property status like Sold, For sale, For rent etc.. This will display on every property.', 'zoacres' ); ?></span>
									</div>
									<div class="property-fields">
										<label for="property-docs-file"><?php esc_html_e('Property Documents', 'zoacres'); ?></label>
										<div class="property-docs-file-inner">
											<input type="file" id="property-docs-file" multiple="" class="property-docs-file" />
											<p class="property-docs-file-status"></p>
											<input type="hidden" class="property-docs-file-final" name="property_docs_file_final" value="" />
											<span class="d-block"><?php esc_html_e('You can upload property documents like pdf.', 'zoacres'); ?></span>
										</div>
									</div>
									<?php do_action( 'zoacres_add_property_button_before' ); ?>
									<div class="property-fields property-upload-parent">
										<a href="#" class="btn btn-default insert-property-ajax"><?php echo apply_filters( 'zoacres_property_upload_button', esc_html__( 'Upload Property', 'zoacres' ) ); ?></a>										
										<img class="property-new-process" src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>" alt="<?php esc_attr_e('Loader', 'zoacres'); ?>" />
									</div>
								</div>
							
							</div>
							</form>
                        </div><!-- .add-new-property -->
						</div>
						<?php endif; //active pack ?>
						
					</div>
					<!-- Dashboard Package row -->
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
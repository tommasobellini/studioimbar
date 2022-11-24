<?php
   /**
    *	Template Name: User Profile
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
   
	global $current_user;   
	
	$agent_email = $current_user->user_email;
	$agent_id = zoacres_get_post_id_by_meta_key_and_value( 'zoacres_agent_email', $agent_email );
	
	$agent_position = get_post_meta( $agent_id, 'zoacres_agent_position', true );
	$agent_mobile = get_post_meta( $agent_id, 'zoacres_agent_mobile', true );
	$agent_tele = get_post_meta( $agent_id, 'zoacres_agent_telephone', true );
	$agent_address = get_post_meta( $agent_id, 'zoacres_agent_address', true );
	$agent_skype = get_post_meta( $agent_id, 'zoacres_agent_skype', true );
	$agent_website = get_post_meta( $agent_id, 'zoacres_agent_website', true );
	$agent_experience = get_post_meta( $agent_id, 'zoacres_agent_experience', true );
	$agent_lang = get_post_meta( $agent_id, 'zoacres_agent_languages', true );
	$agent_mlsid = get_post_meta( $agent_id, 'zoacres_agent_mlsid', true );
	$agent_schedule = get_post_meta( $agent_id, 'zoacres_agent_schedule', true );
	
	$agent_facebook = get_post_meta( $agent_id, 'zoacres_agent_fb_link', true );
	$agent_twitter = get_post_meta( $agent_id, 'zoacres_agent_twitter_link', true );
	$agent_linkedin = get_post_meta( $agent_id, 'zoacres_agent_linkedin_link', true );
	$agent_youtube = get_post_meta( $agent_id, 'zoacres_agent_yt_link', true );
	$agent_instagram = get_post_meta( $agent_id, 'zoacres_agent_instagram_link', true );
	
	$post_object = get_post( $agent_id );        
	$agent_description = $post_object->post_content;
	$agent_image_url = get_the_post_thumbnail_url( $agent_id, 'thumbnail' );
  
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
								<li class="list-group-item"><a href="<?php echo esc_url( $auth_dash_link ); ?>" class="d-block user_tab_active "><i class="fa fa-cog"></i><?php esc_html_e('My Profile', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_list_link ); ?>" class="d-block"> <i class="fa fa-map-marker"></i><?php esc_html_e('My Properties List', 'zoacres'); ?></a></li><!-- .agent-property-list removed this class. This class used for ajax -->
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
					<div class="process-change-overlay"><span><?php esc_html_e('Processing...', 'zoacres'); ?></span></div>
					<input type="hidden" class="map-property-agent" value="<?php echo esc_attr( $agent_id ); ?>" />
					<div class="zoacres-agent-panel">
						<div class="zoacres-user-details-wrap">
							<h3 class="entry-title"><?php esc_html_e('My profile', 'zoacres'); ?></h3>
							<form id="profile-form" method="post" enctype="multipart/form-data">
			
								<div class="add-estate profile-page profile-onprofile">
									<div class="row">
										<div class="col-md-3 profile_label">
											<div class="user_details_row">
												<?php esc_html_e('Photo', 'zoacres'); ?>
											</div>
											<div class="user_profile_explain">
												<?php esc_html_e('Upload your profile photo.', 'zoacres'); ?>
											</div>
										</div><!-- .profile_label -->	
										<div class="col-md-9 profile_div">
											<?php
												if( !$agent_image_url ){
													$agent_image_url = ZOACRES_ASSETS . '/images/no-img.jpg';
												}
											?>
											<img class="profile-preview-image" src="<?php echo esc_url( $agent_image_url ); ?>" alt="<?php esc_attr_e('User Image', 'zoacres'); ?>" />
											<input type="file" name="agent_photo" class="profile-image-file" />
											<input type="hidden" name="agent_no_photo" class="agent-no-photo" value="0" />
											<div class="upload-container">
												<button class="btn btn-default profile-image-trigger"><?php esc_html_e('Upload profile image.', 'zoacres'); ?></button>	
												<button class="btn btn-default profile-rem-image-trigger"><?php esc_html_e('Remove image.', 'zoacres'); ?></button>				
											</div><!-- .upload-container -->
											<span class="upload_explain">
												<?php esc_html_e('*minimum 500px x 500px', 'zoacres'); ?>
											</span>
										</div><!-- .profile_div -->
									</div><!-- .row -->
								</div>	
								
								<div class="add-estate profile-page profile-onprofile">
									<div class="row">
										<div class="col-md-3 profile_label">
											<div class="user_details_row">
											<?php esc_html_e('Agent/Agency Details', 'zoacres'); ?>
											</div><!-- .user_details_row -->	
											<div class="user_profile_explain">
											<?php esc_html_e('Add your contact information.', 'zoacres'); ?>
											</div><!-- .profile_label -->	
										</div>
										<div class="col-md-9 profile_div">
											<div class="row">
												<div class="col-md-12">
													<p>
														<label for="agent-position"><?php esc_html_e('Agent/Agency Description', 'zoacres'); ?></label>
														<textarea class="form-control" rows="10" name="agent_description"><?php echo wp_kses_post( $agent_description ); ?></textarea>
													</p>
												</div><!-- col-md-12 -->	
												<div class="col-md-6">
													<p>
														<label for="agent-position"><?php esc_html_e('Agent/Agency Position', 'zoacres'); ?></label>
														<input type="text" id="agent-position" class="form-control" value="<?php echo esc_attr( $agent_position ); ?>" name="agent_position">
													</p>
													<p>
														<label for="agent-mobile"><?php esc_html_e('Mobile', 'zoacres'); ?></label>
														<input type="text" id="agent-mobile" class="form-control" value="<?php echo esc_attr( $agent_mobile ); ?>" name="agent_mobile">
													</p>
													<p>
														<label for="agent-tele"><?php esc_html_e('Telephone', 'zoacres'); ?></label>
														<input type="text" id="agent-tele" class="form-control" value="<?php echo esc_attr( $agent_tele ); ?>" name="agent_tele">
													</p>
												</div><!-- .col-md-6 -->	
												<div class="col-md-6">
													<p>
														<label for="agent-address"><?php esc_html_e('Address', 'zoacres'); ?></label>
														<textarea rows="5" id="agent-address" class="form-control" name="agent_address"><?php echo wp_kses_post( $agent_address ); ?></textarea>
													</p>
													<p>
														<label for="agent-skype"><?php esc_html_e('Skype ID', 'zoacres'); ?></label>
														<input type="text" id="agent-skype" class="form-control" value="<?php echo esc_attr( $agent_skype ); ?>" name="agent_skype">
													</p>
													<p>
														<label for="agent-website"><?php esc_html_e('Website', 'zoacres'); ?></label>
														<input type="text" id="agent-website" class="form-control" value="<?php echo esc_url( $agent_website ); ?>" name="agent_website">
													</p>
												</div><!-- .col-md-6 -->
											</div><!-- .row -->
										</div><!-- .profile_div -->
									</div>	
								</div>
			
								<div class="add-estate profile-page profile-onprofile">
									<div class="row">
										<div class="col-md-3 profile_label">
											<div class="user_details_row">
												<?php esc_html_e('Additional Details', 'zoacres'); ?>
											</div>
											<div class="user_profile_explain">
												<?php esc_html_e('Add your additional information.', 'zoacres'); ?>
											</div>
										</div><!-- .col-md-4 -->	
										<div class="col-md-9 profile_div">
											<div class="row">
												<div class="col-md-6">
													<p>
														<label for="agent-experience"><?php esc_html_e('Agent Experience', 'zoacres'); ?></label>
														<input type="text" id="agent-experience" class="form-control" value="<?php echo esc_attr( $agent_experience ); ?>" name="agent_experience">
													</p>
													<p>
														<label for="agent-lang"><?php esc_html_e('Agent Languages', 'zoacres'); ?></label>
														<input type="text" id="agent-lang" class="form-control" value="<?php echo esc_attr( $agent_lang ); ?>" name="agent_lang">
													</p>
												</div><!-- .col-md-6 -->	
												<div class="col-md-6">
													<p>
														<label for="agent-mlsid"><?php esc_html_e('Agent MLS ID', 'zoacres'); ?></label>
														<input type="text" id="agent-mlsid" class="form-control" value="<?php echo esc_attr( $agent_mlsid ); ?>" name="agent_mlsid">
													</p>
													<p>
														<label for="agent-schedule"><?php esc_html_e('Agent Schedule', 'zoacres'); ?></label>
														<input type="text" id="agent-schedule" class="form-control" value="<?php echo esc_attr( $agent_schedule ); ?>" name="agent_schedule">
													</p>
												</div><!-- .col-md-6 -->	
											</div><!-- .row -->
										</div><!-- .profile_div -->
									</div><!-- .row -->	
								</div>
	
								<div class="add-estate profile-page profile-social">
									<div class="row">
										<div class="col-md-3 profile_social_label">
											<div class="user_details_row">
												<?php esc_html_e('Agent/Agency Social Links', 'zoacres'); ?>
											</div><!-- .user_details_row -->	
											<div class="user_profile_explain">
												<?php esc_html_e('Add your social links here.', 'zoacres'); ?>
											</div><!-- .user_profile_explain -->	
										</div><!-- .col-md-4 -->	
										<div class="col-md-9 profile_div">
											<div class="row">
												<div class="col-md-6">
													<p>
														<label for="agent-facebook"><?php esc_html_e('Facebook URL', 'zoacres'); ?></label>
														<input type="text" id="agent-facebook" class="form-control" value="<?php echo esc_url( $agent_facebook ); ?>" name="agent_facebook">
													</p>
													<p>
														<label for="agent-twitter"><?php esc_html_e('Twitter URL', 'zoacres'); ?></label>
														<input type="text" id="agent-twitter" class="form-control" value="<?php echo esc_url( $agent_twitter ); ?>" name="agent_twitter">
													</p>
													<p>
														<label for="agent-linkedin"><?php esc_html_e('Linkedin URL', 'zoacres'); ?></label>
														<input type="text" id="agent-linkedin" class="form-control" value="<?php echo esc_url( $agent_linkedin ); ?>" name="agent_linkedin">
													</p>
												</div><!-- .col-md-6 -->	
												<div class="col-md-6">					
													<p>
														<label for="agent-youtube"><?php esc_html_e('Youtube URL', 'zoacres'); ?></label>
														<input type="text" id="agent-youtube" class="form-control" value="<?php echo esc_url( $agent_youtube ); ?>" name="agent_youtube">
													</p>
													<p>
														<label for="agent-instagram"><?php esc_html_e('Instagram URL', 'zoacres'); ?></label>
														<input type="text" id="agent-instagram" class="form-control" value="<?php echo esc_url( $agent_instagram ); ?>" name="agent_instagram">
													</p>
												</div><!-- .col-md-6 -->
											</div><!-- .row -->
										</div><!-- .profile_div -->
									</div><!-- .row -->
								</div>
		
								<div class="add-estate profile-page profile-onprofile">
									<div class="row">
										<div class="col-md-3 profile_label">
											<div class="change_pass">
												<?php esc_html_e('Save', 'zoacres'); ?>
											</div>
											<div class="user_profile_explain">
												<?php esc_html_e('Save your details.', 'zoacres'); ?> 
											</div>
										</div><!-- .col-md-4 -->	
										<div class="col-md-9">
											<div class="save-profile-wrap">
												<input type="submit" class="btn zoacres_button" id="save-profile" value="<?php esc_html_e('Update Profile', 'zoacres'); ?>" />
												<div class="process-status-wrap">
													<img class="process-loader" src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>"  />
													<span class="profile-updated-status"></span>
												</div>
											</div>
										</div><!-- .col-md-8 -->	
									</div><!-- .row -->	
								</div>	
								
							</form>
							
							<div class="add-estate profile-page profile-onprofile">
								<div class="row">
									<div class="col-md-3 profile_label">
										<div class="change_pass">
											<?php esc_html_e('Change Password', 'zoacres'); ?>
										</div>
										<div class="user_profile_explain">
											<?php esc_html_e('*After you change the password you will have to login again.', 'zoacres'); ?> 
										</div>
									</div>
									<div class="col-md-9 dashboard_password">
										<div class="row">
											<p class="col-md-12">
												<label for="oldpass"><?php esc_html_e('Old Password', 'zoacres'); ?></label>
												<input id="oldpass" value="" class="form-control" name="oldpass" type="password">
											</p>
											<p class="col-md-6">
												<label for="newpass"><?php esc_html_e('New Password', 'zoacres'); ?></label>
												<input id="newpass" value="" class="form-control" name="newpass" type="password">
											</p>
											<p class="col-md-6">
												<label for="renewpass"><?php esc_html_e('Confirm New Password', 'zoacres'); ?></label>
												<input id="renewpass" value="" class="form-control" name="renewpass" type="password">
											</p>
											<div class="col-md-12 fullp-button">
												<a href="#" class="btn btn-sm" id="change_pass"><?php esc_html_e('Reset Password', 'zoacres'); ?></a>
												<div class="pswd-status-wrap">
													<img class="process-loader" src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>"  />
													<span class="pswd-updated-status"></span>
												</div>
											</div>
										</div><!-- row -->	
									</div><!-- col-md-8 -->	
								</div><!-- row -->	
							</div>	
							
						</div><!-- .zoacres-user-details-wrap -->
					</div><!-- .zoacres-agent-panel -->
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
<?php
   /**
    *	Template Name: Subscriber Profile
    */
if ( !is_user_logged_in() ) {
	$url = home_url( '/' );
	if ( wp_redirect( $url ) ) {
		exit;
	}
}

$is_agent = zoacres_check_is_agent();
if( $is_agent ){
	$url = home_url( '/' );
	if ( wp_redirect( $url ) ) {
		exit;
	}
}

	get_header(); 
	global $current_user;   
  
?>
<div class="zoacres-content user-admin-template">
   <div class="zoacres-content-inner">
      	<div class="container dashboard_password subscriber-profile-page zoacres_user_dashboard">
			<div class="row">
				<div class="col-md-3">
					<div class="user-details text-center typo-white">
						<div class="user-image">
							<h3><span class="icon-user"></span></h3>
						</div><!-- .user-image -->
						<div class="username">
						  <h6><?php esc_html_e( 'Welcome back,', 'zoacres' ); ?><i class="icon-user icons"></i> <?php echo esc_html( $current_user->display_name ); ?></h6>
						</div><!-- .username -->
					</div>
					<div class="user_tab_menu">
					   <div class="user_dashboard_links">
					   		<?php
								$auth_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-subscriber-profile.php'
								));
								if( $auth_pages ){
									$auth_dash_link = get_permalink( $auth_pages[0]->ID );
								}else{
									$auth_dash_link = home_url( '/' );
								} 
								$agent_fav_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-subscriber-fav.php'
								));
								if( $agent_fav_pages ){
									$prop_fav_link = get_permalink( $agent_fav_pages[0]->ID );
								}else{
									$prop_fav_link = home_url( '/' );
								} 
								$agent_saved_pages = get_pages(array(
									'meta_key' => '_wp_page_template',
									'meta_value' => 'zoacres-subscriber-saved-search.php'
								));
								if( $agent_saved_pages ){
									$prop_saved_link = get_permalink( $agent_saved_pages[0]->ID );
								}else{
									$prop_saved_link = home_url( '/' );
								} 
							?>
						  <ul class="list-group">
							 <li class="list-group-item"><a href="<?php echo esc_url( $auth_dash_link ); ?>" class="d-block user_tab_active"><i class="fa fa-cog"></i><?php esc_html_e('My Profile', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_fav_link ); ?>" class="d-block"><i class="fa fa-heart"></i><?php esc_html_e('Favorites', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_saved_link ); ?>" class="d-block"><i class="fa fa-search"></i><?php esc_html_e('Saved Searches', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="#" class="d-block" data-toggle="modal" data-target="#subscriber-confirm-modal"><i class="fa fa-clone"></i><?php esc_html_e('Change as Agent/Agency', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="d-block"><i class="fa fa-power-off"></i><?php esc_html_e('Log Out', 'zoacres'); ?></a></li>
						  </ul>
					   </div><!-- .user_dashboard_links -->
					</div><!-- .user_tab_menu -->
				</div><!-- .col-md-3 -->
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-4">
							<div class="change_pass">
								<?php esc_html_e('Change Password', 'zoacres'); ?>
							</div><!-- .change_pass -->
							<div class="user_profile_explain">
								<?php esc_html_e('*After you change the password you will have to login again.', 'zoacres'); ?> 
								<p> <?php esc_html_e('*If you are created this profile via social login and you want to know password means, just use forget password.', 'zoacres'); ?> </p>
							</div><!-- .user_profile_explain -->
						</div>
						<div class="col-md-8">
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
								<p class="col-md-12 fullp-button">
									<a href="#" class="btn btn-sm" id="change_pass"><?php esc_html_e('Reset Password', 'zoacres'); ?></a>
									<div class="pswd-status-wrap">
										<img class="process-loader" src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>"  />
										<span class="pswd-updated-status"></span>
									</div>
								</p>
							</div><!-- .row -->
												 
							<!-- The Modal -->
							<div class="role-change-overlay"><span><?php esc_html_e('Processing...', 'zoacres'); ?></span></div>
							<div class="modal fade" id="subscriber-confirm-modal">
								<div class="modal-dialog">
									<div class="modal-content">
		
										<!-- Modal Header -->
										<div class="modal-header">
											<h4 class="modal-title"><?php esc_html_e('Confirmation', 'zoacres'); ?></h4>
											<span class="modal-close icon-close" data-dismiss="modal"></span>
										</div>
		
										<!-- Modal body -->
										<div class="modal-body">
											<div class="modal-desc"><?php esc_html_e('Are you sure want to change your role from "Subscriber" to "Agent/Agency"?', 'zoacres'); ?>
											</div>	
											<div class="form-group">
												<h6><?php esc_html_e('Choose Your Role', 'zoacres'); ?></h6> 
												<select class="form-control subscriber-confirm-role">
													<option value="agent"><?php esc_html_e('Agent', 'zoacres'); ?></option>
													<option value="agency"><?php esc_html_e('Agency', 'zoacres'); ?></option>
												</select>
											</div>
										</div>
		
										<!-- Modal footer -->
										<div class="modal-footer">
											<?php	
												$dash_link = '#';
												$pages = get_pages(array(
													'meta_key' => '_wp_page_template',
													'meta_value' => 'zoacres-user-profile.php'
												));
												if( $pages ){
													$dash_link = get_permalink( $pages[0]->ID );
												}
											?>
											<button type="button" class="btn btn-primary subscriber-confirm-change" data-url="<?php echo esc_url( $dash_link ); ?>"><?php esc_html_e('Confirm', 'zoacres'); ?></button>
											<button type="button" class="btn btn-primary" data-dismiss="modal"><?php esc_html_e('Close', 'zoacres'); ?></button>
										</div>
		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div>   <!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->
<?php get_footer();
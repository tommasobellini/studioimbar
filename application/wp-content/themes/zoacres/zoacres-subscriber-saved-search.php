<?php
   /**
    *	Template Name: Subscriber Saved Search
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
							 <li class="list-group-item"><a href="<?php echo esc_url( $auth_dash_link ); ?>" class="d-block"><i class="fa fa-cog"></i><?php esc_html_e('My Profile', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_fav_link ); ?>" class="d-block"><i class="fa fa-heart"></i><?php esc_html_e('Favorites', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_saved_link ); ?>" class="d-block user_tab_active"><i class="fa fa-search"></i><?php esc_html_e('Saved Searches', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="#" class="d-block" data-toggle="modal" data-target="#subscriber-confirm-modal"><i class="fa fa-clone"></i><?php esc_html_e('Change as Agent/Agency', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="d-block"><i class="fa fa-power-off"></i><?php esc_html_e('Log Out', 'zoacres'); ?></a></li>
						  </ul>
					   </div><!-- .user_dashboard_links -->
					</div><!-- .user_tab_menu -->
				</div><!-- .col-md-3 -->
				<div class="col-md-9">
					<div class="col-md-12 zoacres-agent-panel">
						
						<h3 class="entry-title"><?php esc_html_e('Saved Searches', 'zoacres'); ?></h3>
						
						<div class="zoacres-saved-search-wrap">
						<?php
							$author_id = $current_user->ID;
							$saved_array = get_user_meta( $author_id, 'zoacres_saved_searches', true );
							
							if( !empty( $saved_array ) && is_array( $saved_array ) ){
								echo '<div id="saved-search-accordion" class="accordion">';
								$i = 1;
								foreach( $saved_array as $ssearch ){
								
									$acco_key = 'collapse-acco-' . $i;
								
									$srch_filter = json_decode( $ssearch, true );
									
									echo '<div class="card">
										<div class="card-header">
											<h5 class="mb-0 saved-search-acco-trigger" data-toggle="collapse" data-target="#'. esc_attr( $acco_key ) .'" aria-expanded="true" aria-controls="'. esc_attr( $acco_key ) .'" data-params="'. htmlspecialchars( json_encode( $srch_filter ), ENT_QUOTES, 'UTF-8' ) .'">
												'. esc_html__( 'Saved Search', 'zoacres' ) .' #'. esc_attr( $i ) .'
											</h5>
										</div>
								
										<div id="'. esc_attr( $acco_key ) .'" class="collapse" aria-labelledby="'. esc_attr( $acco_key ) .'" data-parent="#saved-search-accordion">
											<div class="card-body">
												<img class="saved-search-loader" src="'. esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ) .'" alt="'. esc_attr__( 'Loader', 'zoacres' ) .'" />
											</div>
										</div>
									</div>';	
									
									$i++;	
								}
								echo'</div>';
							}
						?>
                        </div><!-- .add-new-property -->
					</div>
					<!-- Dashboard Package row -->
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
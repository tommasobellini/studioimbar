<?php
   /**
    *	Template Name: User Saved Search
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
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_saved_link ); ?>" class="d-block user_tab_active"><i class="fa fa-search"></i><?php esc_html_e('Saved Searches', 'zoacres'); ?></a></li><!-- .user-saved-searches removed this class. This class used for ajax -->
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_invoice_link ); ?>" class="d-block"><i class="fa fa-file-text-o"></i><?php esc_html_e('My Invoices', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_inbox_link ); ?>" class="d-block"><i class="fa fa-envelope-o"></i><?php esc_html_e('Inbox', 'zoacres'); if( $ntf ) echo '<span class="message-notification">'. esc_html( $ntf ) .'</span>'; ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="d-block"><i class="fa fa-power-off"></i><?php esc_html_e('Log Out', 'zoacres'); ?></a></li>
							</ul>
						<!-- List Group -->
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
								foreach( $saved_array as $key => $ssearch ){
								
									$acco_key = 'collapse-acco-' . $i;
								
									$srch_filter = json_decode( $ssearch, true );
									
									echo '<div class="card">
										<div class="card-header">
											<h5 class="mb-0 saved-search-acco-trigger" data-toggle="collapse" data-target="#'. esc_attr( $acco_key ) .'" aria-expanded="true" aria-controls="'. esc_attr( $acco_key ) .'" data-params="'. htmlspecialchars( json_encode( $srch_filter ), ENT_QUOTES, 'UTF-8' ) .'">
												'. esc_html__( 'Saved Search', 'zoacres' ) .' #'. esc_attr( $i ) .'
											</h5>
											<a href="#" class="saved-search-remove" data-key="'. esc_attr( $key ) .'"><span class="icon-trash icons"></span></a>
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
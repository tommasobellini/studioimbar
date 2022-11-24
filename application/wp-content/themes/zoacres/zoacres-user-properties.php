<?php
   /**
    *	Template Name: Agent/Agency Properties
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
								<li class="list-group-item"><a href="<?php echo esc_url( $auth_dash_link ); ?>" class="d-block"><i class="fa fa-cog"></i><?php esc_html_e('My Profile', 'zoacres'); ?></a></li>
								<li class="list-group-item"><a href="<?php echo esc_url( $prop_list_link ); ?>" class="d-block user_tab_active"> <i class="fa fa-map-marker"></i><?php esc_html_e('My Properties List', 'zoacres'); ?></a></li><!-- .agent-property-list removed this class. This class used for ajax -->
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
							<h3 class="entry-title"><?php esc_html_e('Approved Properties', 'zoacres'); ?></h3>
							<?php 

								$zpe = new ZoacresPropertyElements();
								
								$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
								$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
								$zpe::$cus_excerpt_len = apply_filters( 'zoacres_user_properties_excerpt_length', $arch_exc_len );
																	
								$ppp = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-per-page' );
								$paged = 1;
		
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
								
								$cargs = $args;
								$query = new WP_Query( $cargs );
								$found_posts = $query->found_posts;
								if( !$found_posts ) :
									echo "<h6>". esc_html__( 'No property found.', 'zoacres' ) ."</h6>";
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
										'img_size' => 'medium',
										'agent_page' => true
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
							
							<div class="user-pending-properties-wrap">
							
								<?php
									$args = array(
										'post_type' => 'zoacres-property',
										'posts_per_page' => absint( $ppp ),
										'post_status' => 'draft',
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
								?>
							
								<h3 class="entry-title"><?php esc_html_e('Pending or Unapproved Properties', 'zoacres'); ?></h3>
								<div class="map-property-list" data-cols="<?php echo esc_attr( $cols ); ?>" data-layout="grid" data-ppp="<?php echo esc_attr( $ppp ); ?>" data-animation="<?php echo esc_attr( $prop_ani ); ?>">
									<?php
										
										$cargs = $args;
										$query = new WP_Query( $cargs );
										$found_posts = $query->found_posts;
										if( !$found_posts ) :
											echo "<h6>". esc_html__( 'No property found.', 'zoacres' ) ."</h6>";
										endif;
										
										$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-items' );
										$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
										if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
										
										$meta_args = array(
											'agent' => true,
											'layout' => 'grid',
											'animation' => esc_attr( $prop_ani ),
											'img_size' => 'medium',
											'agent_page' => true
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
									
								</div> <!-- .user-pending-properties-wrap -->
							</div>
							
						</div><!-- .zoacres-user-details-wrap -->
					</div><!-- .zoacres-agent-panel -->
					
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
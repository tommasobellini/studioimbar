<?php
   /**
    *	Template Name: Subscribers Favorites
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
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_fav_link ); ?>" class="d-block user_tab_active"><i class="fa fa-heart"></i><?php esc_html_e('Favorites', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( $prop_saved_link ); ?>" class="d-block"><i class="fa fa-search"></i><?php esc_html_e('Saved Searches', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="#" class="d-block" data-toggle="modal" data-target="#subscriber-confirm-modal"><i class="fa fa-clone"></i><?php esc_html_e('Change as Agent/Agency', 'zoacres'); ?></a></li>
							 <li class="list-group-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="d-block"><i class="fa fa-power-off"></i><?php esc_html_e('Log Out', 'zoacres'); ?></a></li>
						  </ul>
					   </div><!-- .user_dashboard_links -->
					</div><!-- .user_tab_menu -->
				</div><!-- .col-md-3 -->
				<div class="col-md-9">
					<div class="zoacres-agent-panel">
						<div class="zoacres-user-details-wrap">
							<h3 class="entry-title"><?php esc_html_e('My Favourite Properties', 'zoacres'); ?></h3>
							<?php 
								$zpe = new ZoacresPropertyElements();
								$arch_exc_len = $zpe->zoacresPropertyThemeOpt( 'archive-propery-excerpt-len' );
								$arch_exc_len = $arch_exc_len != '' ? $arch_exc_len : 15;
								$zpe::$cus_excerpt_len = apply_filters( 'zoacres_subscribers_favorites_excerpt_length', $arch_exc_len );
						
								$author_id = get_current_user_id();
								
								$ppp = $zpe->zoacresPropertyThemeOpt( 'archive-agent-property-per-page' );
								$paged = 1;
								
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
										
										$properties_list = implode( ",", $fav_array );
									?>
									
										<div class="map-property-list" data-cols="<?php echo esc_attr( $cols ); ?>" data-layout="grid" data-ppp="<?php echo esc_attr( $ppp ); ?>" data-animation="<?php echo esc_attr( $prop_ani ); ?>" data-properties="<?php echo esc_attr( $properties_list ); ?>">
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
									}
								}
							?>
						</div><!-- .zoacres-user-details-wrap -->
					</div><!-- .zoacres-agent-panel -->
					
				</div><!-- .col-md-9 -->
			</div>
		</div>
   </div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
<?php
$zozo_theme = wp_get_theme();
if($zozo_theme->parent_theme) {
    $template_dir =  basename( get_template_directory() );
    $zozo_theme = wp_get_theme($template_dir);
}
$zozo_theme_version = $zozo_theme->get( 'Version' );
$zozo_theme_name = $zozo_theme->get('Name');

$zozothemes_url = 'http://zozothemes.com/';
$ins_demo_stat = get_theme_mod( 'zoacres_demo_installed' );
$ins_demo_id = get_theme_mod( 'zoacres_installed_demo_id' );

$plugins = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
$active_action = '';
if( isset( $_GET['plugin_status'] ) ) {
	$active_action = $_GET['plugin_status'];
}
$tgm_obj = new Zoacres_Zozo_Admin_Page();
?>
<div class="wrap about-wrap welcome-wrap zozothemes-wrap">
	<h1 class="hide" style="display:none;"></h1>
	<div class="zozothemes-welcome-inner">
		<div class="welcome-wrap">
			<h1><?php echo esc_html__( "Welcome to", "zoacres" ) . ' ' . '<span>'. $zozo_theme_name .'</span>'; ?></h1>
			<div class="theme-logo"><span class="theme-version"><?php echo esc_attr( $zozo_theme_version ); ?></span></div>
			
			<div class="about-text"><?php echo esc_html__( "Nice!", "zoacres" ) . ' ' . $zozo_theme_name . ' ' . esc_html__( "is now installed and ready to use. Get ready to build your site with more powerful WordPress theme. We hope you enjoy using it.", "zoacres" ); ?></div>
		</div>
		<h2 class="zozo-nav-tab-wrapper nav-tab-wrapper">
			<?php
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=zoacres' ), esc_html__( "System Status", "zoacres" ) );
			printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "Plugin and Demo", "zoacres" ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=zoacres-support' ),  esc_html__( "Support", "zoacres" ) );		
			?>
		</h2>
	</div>
		
	<div class="zozothemes-required-notices">
		<p class="notice-description"><?php echo esc_html__( "These are the plugins we recommended for Zoacres. Currently Zoacres Core, Visual Composer and Slider Revolutions are required plugins that is needed to use in Zoacres. You can activate, deactivate or update the plugins from this tab.", "zoacres" ); ?></p>
	</div>
	
	<div class="zozothemes-demo-wrapper zozothemes-install-plugins">
		
		<div class="zozo-col-2">
			<div class="feature-section install-plugins-parent rendered">
			
				<h4><?php esc_html_e( 'Theme plugins', 'zoacres' ); ?></h4>
			
				<?php
				
				$plugin_custom_order = array(
					'zoacres-core' 		=> $plugins['zoacres-core'],
					'js_composer' 		=> $plugins['js_composer'],
					'revslider' 		=> $plugins['revslider'],
					'envato-market' 	=> $plugins['envato-market'],
					'contact-form-7' 	=> $plugins['contact-form-7']
				);
				$plugins = $plugin_custom_order;
				
				foreach( $plugins as $plugin ):
					$class = '';
					$plugin_status = '';
					$active_action_class = '';
					$file_path = $plugin['file_path'];
					$plugin_action = $tgm_obj->zoacres_plugin_link( $plugin );
					foreach( $plugin_action as $action => $value ) {
						if( $active_action == $action ) {
							$active_action_class = ' plugin-' .$active_action. '';
						}
					}
					
					$is_plug_act = 'is_plugin_active';
					if( $is_plug_act( $file_path ) ) {
						$plugin_status = 'active';
						$class = 'active';
					}
				?>			
				<div class="install-plugin-wrap theme <?php echo esc_attr( $class . $active_action_class ); ?>" data-id="<?php echo esc_attr( $plugin['slug'] ); ?>">
					<div class="install-plugin-inner">
						<div class="theme-screenshot">
							<img src="<?php echo esc_url( $plugin['image_url'] ); ?>" alt="<?php echo esc_attr( $plugin['name'] ); ?>" />
						</div>
						<div class="install-plugin-right">
							<div class="install-plugin-right-inner">
								<?php if( $plugin['required'] ): ?>
								<div class="plugin-required">
									<?php esc_html_e( 'Required', 'zoacres' ); ?>
								</div>
								<?php endif; ?>
								<h3 class="theme-name">
									<?php
									echo esc_html( $plugin['name'] );
									?>
								</h3>

								<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
								<div class="plugin-info">
									<?php echo sprintf('Version %s | %s', $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
								</div>
								<?php endif; ?>
								<div class="theme-actions--">
									<?php foreach( $plugin_action as $action ) { echo ( ''. $action ); } ?>
								</div>
								<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
								<div class="theme-update"><?php echo esc_html__('Update Available: Version', 'zoacres'); ?> <?php echo esc_attr( $plugin['version'] ); ?></div>
								<?php endif; ?>
								<div class="plugin-bulk-action-trigger">
									<span class="bulk-action-txt"><?php esc_html_e( 'Bulk Actions', 'zoacres' ); ?></span>
									<div class="bulk-action-svg">
										<span class="bulk-action-empty-svg"></span>
										<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
									</div>
								</div>
							</div><!-- .install-plugin-right-inner -->
						</div><!-- .install-plugin-right -->
					</div>
				</div>
				<?php endforeach; ?>
				<div class="plugin-install-loader"><span class="plugin-install-loader-img"><img src="<?php echo esc_url( ZOACRES_ADMIN_URL .'/welcome-page/assets/images/gear.gif' ); ?>" alt="<?php esc_html_e( 'Loader', 'zoacres' ); ?>"/></span></div>
			</div>
			
			<div class="plugin-bulk-action-all-trigger">
				<span class="bulk-action-txt"><?php esc_html_e( 'Bulk Select', 'zoacres' ); ?></span>
				<div class="bulk-action-svg">
					<span class="bulk-action-empty-svg"></span>
					<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
				</div>
			</div>
			
			<a href="#" class="button button-primary tgm-custom-plugin-install" data-nounce="<?php echo wp_create_nonce( 'tgmpa-install' ); ?>" data-plugins="<?php echo htmlspecialchars( json_encode( $plugins ), ENT_QUOTES, 'UTF-8' ) ?>"><?php esc_html_e( 'Plugin Install and Activation', 'zoacres' ); ?></a>
		</div><!-- .zozo-col-2 -->
		<div class="zozo-col-2">
			<div class="feature-section theme-demos rendered theme-demo-installation-wrap">
			
				<h4><?php esc_html_e( 'Theme Demo\'s', 'zoacres' ); ?></h4>
			
			<?php 
				
				//Zoacres Main
				$demo_array = array(
					'demo_id' 	=> 'demo-classic',
					'demo_name' => esc_html__( 'Zoacres Main Demo', 'zoacres' ),
					'demo_img'	=> 'demo-1.png',
					'demo_url'	=> 'http://demo.zozothemes.com/zoacres/',
					'revslider'	=> '1',
					'media_parts'	=> '46',
					'general'	=> array(
						'media' 		=> esc_html__( "Media", "zoacres" ),
						'theme-options' => esc_html__( "Theme Options", "zoacres" ),
						'widgets' 		=> esc_html__( "Widgets", "zoacres" ),
						'revslider' 	=> esc_html__( "Revolution Sliders", "zoacres" ),
						'post' 			=> esc_html__( "All Posts", "zoacres" )
					),
					'pages'=> array(
						'1'		=> esc_html__( "Home", "zoacres" ),
						'2' 	=> esc_html__( "Blog List", "zoacres" ),
						'3'		=> esc_html__( "Circle Progress", "zoacres" ),
						'4' 	=> esc_html__( "Client", "zoacres" ),
						'5' 	=> esc_html__( "Company history", "zoacres" ),
						'6'		=> esc_html__( "Compate Pricing", "zoacres" ),
						'7' 	=> esc_html__( "Contact Forms", "zoacres" ),
						'8' 	=> esc_html__( "Contact Info", "zoacres" ),
						'9' 	=> esc_html__( "Content Carousel", "zoacres" ),
						'10'	=> esc_html__( "Counters", "zoacres" ),
						
						'11'	=> esc_html__( "Day Counter", "zoacres" ),
						'12'	=> esc_html__( "Feature Box", "zoacres" ),
						'13'	=> esc_html__( "Flipbox", "zoacres" ),
						'14'	=> esc_html__( "Google Map", "zoacres" ),
						'15'	=> esc_html__( "Icons", "zoacres" ),
						'16'	=> esc_html__( "Mail chimp", "zoacres" ),
						'17'	=> esc_html__( "Modal Box", "zoacres" ),
						'18'	=> esc_html__( "Progress Bar", "zoacres" ),
						'19'	=> esc_html__( "Social Icons", "zoacres" ),
						'20'	=> esc_html__( "Team", "zoacres" ),
						
						'21'	=> esc_html__( "User Invoices", "zoacres" ),
						'22'	=> esc_html__( "Half Map Page", "zoacres" ),
						'23'	=> esc_html__( "property Search Full Map", "zoacres" ),
						'24'	=> esc_html__( "Property Search With Right sidebar", "zoacres" ),
						'25'	=> esc_html__( "Property Search With Right sidebar", "zoacres" ),
						'26'	=> esc_html__( "User Profile", "zoacres" ),
						'27'	=> esc_html__( "Agent / Agency Properties", "zoacres" ),
						'28'	=> esc_html__( "Stripe charge", "zoacres" ),
						'29'	=> esc_html__( "User Invoice", "zoacres" ),
						'30'	=> esc_html__( "Properties short code", "zoacres" ),
						
						'31'	=> esc_html__( "Agent Slider", "zoacres" ),
						'32'	=> esc_html__( "Property slider", "zoacres" ),
						'33'	=> esc_html__( "User inbox", "zoacres" ),
						'34'	=> esc_html__( "Subscriber Profile", "zoacres" ),
						'35'	=> esc_html__( "User Add New Property", "zoacres" ),
						'36'	=> esc_html__( "User Property Edit", "zoacres" ),
						'37'	=> esc_html__( "Timeline", "zoacres" ),
						'38'	=> esc_html__( "Twitter", "zoacres" ),
						'39'	=> esc_html__( "Testimonials", "zoacres" ),
						'40'	=> esc_html__( "Coming Soon", "zoacres" ),
						
						'41'	=> esc_html__( "Property Search Results", "zoacres" ),
						'42'	=> esc_html__( "Property Grid 2 Columns", "zoacres" ),
						'43'	=> esc_html__( "Property Grid With Left Sidebar", "zoacres" ),
						'44'	=> esc_html__( "Subscriber Profile", "zoacres" ),
						'45'	=> esc_html__( "Property Category filter Grid", "zoacres" ),
						'46'	=> esc_html__( "Property Category Filter List", "zoacres" ),
						'47'	=> esc_html__( "Property Grid Style 1", "zoacres" ),
						'48'	=> esc_html__( "Property Grid Style 2", "zoacres" ),
						'49'	=> esc_html__( "Property Grid Style 3", "zoacres" ),
						'50'	=> esc_html__( "Property List Style 1", "zoacres" ),
						
						'51'	=> esc_html__( "Property List Style 2", "zoacres" ),
						'52'	=> esc_html__( "Agent Grid Style 1", "zoacres" ),
						'53'	=> esc_html__( "Agent Grid Style 2", "zoacres" ),
						'54'	=> esc_html__( "Agent Grid Style 3", "zoacres" ),
						'55'	=> esc_html__( "Agent List Style 1", "zoacres" ),
						'56'	=> esc_html__( "Agent List Style 2", "zoacres" ),
						'57'	=> esc_html__( "Agent List Style 3", "zoacres" ),
						'58'	=> esc_html__( "Property Search With Left sidebar", "zoacres" ),
						'59'	=> esc_html__( "Featured Property", "zoacres" ),
						'60'	=> esc_html__( "Property Grid width Sidebar", "zoacres" ),
						
						'61'	=> esc_html__( "User Saved Search", "zoacres" ),
						'62'	=> esc_html__( "Property Archive", "zoacres" ),
						'63'	=> esc_html__( "Home 2", "zoacres" ),
						'64'	=> esc_html__( "Property city slider", "zoacres" ),
						'65'	=> esc_html__( "Latest Property with 2 Column", "zoacres" ),
						'66'	=> esc_html__( "Home 3", "zoacres" ),
						'67'	=> esc_html__( "Home 4", "zoacres" ),
						'68'	=> esc_html__( "Home 5", "zoacres" ),
						'69'	=> esc_html__( "Home 6", "zoacres" ),
						'70'	=> esc_html__( "Home 7", "zoacres" ),
						
						'71'	=> esc_html__( "Home 8", "zoacres" ),
						'72'	=> esc_html__( "Home 9", "zoacres" ),
						'73'	=> esc_html__( "Home 10", "zoacres" ),
						'74'	=> esc_html__( "Idx Template", "zoacres" ),
						'75'	=> esc_html__( "Property List Style 3", "zoacres" ),
						'76'	=> esc_html__( "Property Full Slider", "zoacres" ),
						'77'	=> esc_html__( "Slide With List", "zoacres" ),
						'78'	=> esc_html__( "Blog", "zoacres" ),
						'79'	=> esc_html__( "Contact Us", "zoacres" ),
						'80'	=> esc_html__( "Agency List Style", "zoacres" ),
						
						'81'	=> esc_html__( "About Us", "zoacres" ),
						'82'	=> esc_html__( "Sample Page", "zoacres" ),
						'83'	=> esc_html__( "Property full slider center", "zoacres" ),
						'84'	=> esc_html__( "Search Property", "zoacres" ),
						'85'	=> esc_html__( "Search Property List sidebar", "zoacres" ),
						'86'	=> esc_html__( "Map With Search shortcode", "zoacres" ),
						'87'	=> esc_html__( "Map With Floating Search", "zoacres" ),
						'88'	=> esc_html__( "Faq", "zoacres" ),
						'89'	=> esc_html__( "Pricing Tables", "zoacres" ),
						'90'	=> esc_html__( "Blog  Fullwidth", "zoacres" ),
						
						'91'	=> esc_html__( "Blog Grid With Sidebar", "zoacres" ),
						'92'	=> esc_html__( "Blog Grid Fullwidth", "zoacres" ),
						'93'	=> esc_html__( "Agent / Agency Favorites", "zoacres" ),
						'94'	=> esc_html__( "Subscriber Saved Search", "zoacres" ),
						'95'	=> esc_html__( "Subscribers Favorites", "zoacres" ),
						'96'	=> esc_html__( "Property List Style 4", "zoacres" )
					)
					
				);
				zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id);
				
				//Zoacres City Demo
				$demo_array = array(
					'demo_id' 	=> 'demo-city-new',
					'demo_name' => esc_html__( 'Zoacres City Demo', 'zoacres' ),
					'demo_img'	=> 'demo-2.png',
					'demo_url'	=> 'http://demo.zozothemes.com/zoacres/city-demo/',
					'media_parts'	=> '30',
					'general'	=> array(
						'media' 		=> esc_html__( "Media", "zoacres" ),
						'theme-options' => esc_html__( "Theme Options", "zoacres" ),
						'widgets' 		=> esc_html__( "Widgets", "zoacres" ),
						'post' 			=> esc_html__( "All Posts", "zoacres" )
					),
					'pages'=> array(					
						'1'		=> esc_html__( "Blog List", "zoacres" ),
						'2'		=> esc_html__( "About Us 3", "zoacres" ),
						'3'		=> esc_html__( "Gutter 4 column", "zoacres" ),
						'4'		=> esc_html__( "Contact Form", "zoacres" ),
						'5'		=> esc_html__( "Agent Favourites", "zoacres" ),
						'6'		=> esc_html__( "Agent Properties", "zoacres" ),
						'7'		=> esc_html__( "Full Map", "zoacres" ),
						'8'		=> esc_html__( "Full Property Archive", "zoacres" ),
						'9'		=> esc_html__( "Half Map", "zoacres" ),
						'10'	=> esc_html__( "Property Search Result", "zoacres" ),
						
						'11'	=> esc_html__( "Subscriber Profile", "zoacres" ),
						'12'	=> esc_html__( "User Add New Property", "zoacres" ),
						'13'	=> esc_html__( "User Inbox", "zoacres" ),
						'14'	=> esc_html__( "User Invoices", "zoacres" ),
						'15'	=> esc_html__( "User Profile", "zoacres" ),
						'16'	=> esc_html__( "User Property Edit", "zoacres" ),
						'17'	=> esc_html__( "User Saved Search", "zoacres" ),
						'18'	=> esc_html__( "Property Grid 2 Columns", "zoacres" ),
						'19'	=> esc_html__( "Property Grid 3 Columns", "zoacres" ),
						'20'	=> esc_html__( "Property Grid With Right Sidebar", "zoacres" ),
						
						'21'	=> esc_html__( "Google Map", "zoacres" ),
						'22'	=> esc_html__( "Team", "zoacres" ),
						'23'	=> esc_html__( "Testimonials", "zoacres" ),
						'24'	=> esc_html__( "Coming Soon", "zoacres" ),
						'25'	=> esc_html__( "Property Grid With Left Sidebar", "zoacres" ),
						'26'	=> esc_html__( "Property List Left Sidebar", "zoacres" ),
						'27'	=> esc_html__( "Property List Right Sidebar", "zoacres" ),
						'28'	=> esc_html__( "Property List Both Sidebar", "zoacres" ),
						'29'	=> esc_html__( "Property List - Fullwidth", "zoacres" ),
						'30'	=> esc_html__( "Property Archive With Right Sidebar", "zoacres" ),
						
						'31'	=> esc_html__( "Property Archive With Left Sidebar", "zoacres" ),
						'32'	=> esc_html__( "Full Map With Left Sidebar", "zoacres" ),
						'33'	=> esc_html__( "Full Map With Right Sidebar", "zoacres" ),
						'34'	=> esc_html__( "Featured Properties", "zoacres" ),
						'35'	=> esc_html__( "Area / City Grid", "zoacres" ),
						'36'	=> esc_html__( "Properties By City Style 1", "zoacres" ),
						'37'	=> esc_html__( "Properties By City Style 2", "zoacres" ),
						'38'	=> esc_html__( "Slide With 2 Columns", "zoacres" ),
						'39'	=> esc_html__( "Slide With 3 Columns", "zoacres" ),
						'40'	=> esc_html__( "Slide With Overlay", "zoacres" ),
						
						'41'	=> esc_html__( "Slide With Fullwidth", "zoacres" ),
						'42'	=> esc_html__( "Slide With Featured Items", "zoacres" ),
						'43'	=> esc_html__( "Slide With 4 Columns", "zoacres" ),
						'44'	=> esc_html__( "Slide With List", "zoacres" ),
						'45'	=> esc_html__( "Agents Grid Style", "zoacres" ),
						'46'	=> esc_html__( "Agents List With Right Sidebar", "zoacres" ),
						'47'	=> esc_html__( "Agents Grid With Left Sidebar", "zoacres" ),
						'48'	=> esc_html__( "Agents Grid With Right Sidebar", "zoacres" ),
						'49'	=> esc_html__( "Agents List With Left Sidebar", "zoacres" ),
						'50'	=> esc_html__( "Home", "zoacres" ),
						
						'51'	=> esc_html__( "Blog", "zoacres" ),
						'52'	=> esc_html__( "Contact Us", "zoacres" ),
						'53'	=> esc_html__( "Home 2", "zoacres" ),
						'54'	=> esc_html__( "Home 4", "zoacres" ),
						'55'	=> esc_html__( "Home 3", "zoacres" ),
						'56'	=> esc_html__( "Home 5", "zoacres" ),
						'57'	=> esc_html__( "Home 6", "zoacres" ),
						'58'	=> esc_html__( "Agency List Style", "zoacres" ),
						'59'	=> esc_html__( "About Us", "zoacres" ),
						'60'	=> esc_html__( "About Us 2", "zoacres" ),
						
						'61'	=> esc_html__( "Blog  Fullwidth", "zoacres" ),
						'62'	=> esc_html__( "Blog Grid With Sidebar", "zoacres" ),
						'63'	=> esc_html__( "Blog Grid Fullwidth", "zoacres" ),
						'64'	=> esc_html__( "Agency Template", "zoacres" )						
					)
					
				);
				zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id);
				
				//Single Single Agency
				$demo_array = array(
					'demo_id' 	=> 'demo-agency-new',
					'demo_name' => esc_html__( 'Single Agency Demo', 'zoacres' ),
					'demo_img'	=> 'demo-4.png',
					'demo_url'	=> 'https://demo.zozothemes.com/zoacres/single-agency/',
					'revslider'	=> '1',
					'media_parts'	=> '19',
					'general'	=> array(
						'media' 		=> esc_html__( "Media", "zoacres" ),
						'theme-options' => esc_html__( "Theme Options", "zoacres" ),
						'widgets' 		=> esc_html__( "Widgets", "zoacres" ),
						'revslider' 	=> esc_html__( "Revolution Sliders", "zoacres" ),
						'post' 			=> esc_html__( "All Posts", "zoacres" )
					),
					'pages'=> array(
						'1'		=> esc_html__( "Agents", "zoacres" ),
						'2' 	=> esc_html__( "Home", "zoacres" ),
						'3'		=> esc_html__( "Blog", "zoacres" ),
						'4' 	=> esc_html__( "Blog List", "zoacres" ),
						'5' 	=> esc_html__( "Services", "zoacres" ),
						'6'		=> esc_html__( "Contact Us", "zoacres" ),
						'7' 	=> esc_html__( "About Us", "zoacres" ),
						'8' 	=> esc_html__( "Blog  Fullwidth", "zoacres" ),
						'9' 	=> esc_html__( "Blog Grid With Sidebar", "zoacres" ),
						'10'	=> esc_html__( "Blog Grid Fullwidth", "zoacres" ),
						'11'	=> esc_html__( "Properties", "zoacres" )
					)
					
				);
				zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id);
				
				//Single Agent
				$demo_array = array(
					'demo_id' 	=> 'demo-agent-new',
					'demo_name' => esc_html__( 'Single Agent Demo', 'zoacres' ),
					'demo_img'	=> 'demo-3.png',
					'demo_url'	=> 'https://demo.zozothemes.com/zoacres/agent-demo/',
					'revslider'	=> '1',
					'media_parts'	=> '15',
					'general'	=> array(
						'media' 		=> esc_html__( "Media", "zoacres" ),
						'theme-options' => esc_html__( "Theme Options", "zoacres" ),
						'widgets' 		=> esc_html__( "Widgets", "zoacres" ),
						'revslider' 	=> esc_html__( "Revolution Sliders", "zoacres" ),
						'post' 			=> esc_html__( "All Posts", "zoacres" )
					),
					'pages'=> array(
						'1'		=> esc_html__( "Agent Favourites", "zoacres" ),
						'2' 	=> esc_html__( "Stripe charge", "zoacres" ),
						'3' 	=> esc_html__( "User Invoice", "zoacres" ),
						'4' 	=> esc_html__( "User inbox", "zoacres" ),
						'5' 	=> esc_html__( "Blog List", "zoacres" ),
						'6' 	=> esc_html__( "User Profile", "zoacres" ),
						'7' 	=> esc_html__( "Sample Page", "zoacres" ),
						'8' 	=> esc_html__( "User Invoices", "zoacres" ),
						'9' 	=> esc_html__( "Home", "zoacres" ),						
						'10' 	=> esc_html__( "Property sees rise in demand", "zoacres" ),
						
						'11'	=> esc_html__( "Subscriber Profile", "zoacres" ),
						'12' 	=> esc_html__( "User Add New Property", "zoacres" ),
						'13' 	=> esc_html__( "User Property Edit", "zoacres" ),
						'14' 	=> esc_html__( "User Saved Search", "zoacres" ),
						'15' 	=> esc_html__( "Contact Us", "zoacres" ),
						'16' 	=> esc_html__( "About Us", "zoacres" ),
						'17' 	=> esc_html__( "Blog Grid With Sidebar", "zoacres" ),
						'18' 	=> esc_html__( "Properties", "zoacres" ),
						'19' 	=> esc_html__( "Featured properties", "zoacres" ),						
						'20' 	=> esc_html__( "For Sale", "zoacres" ),
						'21' 	=> esc_html__( "For Rent", "zoacres" )
					)
					
				);
				zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id);
				
				//Single Property
				$demo_array = array(
					'demo_id' 	=> 'demo-single-property-new',
					'demo_name' => esc_html__( 'Single Property Demo', 'zoacres' ),
					'demo_img'	=> 'demo-5.png',
					'demo_url'	=> 'https://demo.zozothemes.com/zoacres/single-property/',
					'revslider'	=> '1',
					'media_parts'	=> '8',
					'general'	=> array(
						'media' 		=> esc_html__( "Media", "zoacres" ),
						'theme-options' => esc_html__( "Theme Options", "zoacres" ),
						'widgets' 		=> esc_html__( "Widgets", "zoacres" ),
						'revslider' 	=> esc_html__( "Revolution Sliders", "zoacres" ),
						'post' 			=> esc_html__( "All Posts", "zoacres" )
					),
					'pages'=> array(
						'1'		=> esc_html__( "Blog List", "zoacres" ),
						'2'		=> esc_html__( "Home", "zoacres" ),
						'3'		=> esc_html__( "Blog", "zoacres" ),
						'4'		=> esc_html__( "Contact Us", "zoacres" ),
						'5'		=> esc_html__( "About", "zoacres" ),
						'6'		=> esc_html__( "Blog Grid With Sidebar", "zoacres" ),
						'7'		=> esc_html__( "Gallery", "zoacres" ),
						'8'		=> esc_html__( "Take A Tour", "zoacres" ),
					)
					
				);
				zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id);
				
			?>
			
		</div>
		</div><!-- .zozo-col-2 -->
		
	</div><!-- .zozothemes-demo-wrapper -->
	
	<div class="zozothemes-thanks">
        <hr />
    	<p class="description"><?php echo esc_html__( "Thank you for choosing", "zoacres" ) . ' ' . $zozo_theme_name . '.'; ?></p>
    </div>
</div>
<?php
function zoacres_demo_div_generater($demo_array, $ins_demo_stat, $ins_demo_id){
	$demo_class = '';
	if( $ins_demo_stat == 1 ){
		if( $ins_demo_id == $demo_array['demo_id'] ){
			$demo_class .= ' demo-actived';
		}else{
			$demo_class .= ' demo-inactive';
		}
	}else{
		$demo_class .= ' demo-active';
	}
	
	$revslider = isset( $demo_array['revslider'] ) && $demo_array['revslider'] != '' ? $demo_array['revslider'] : '';
	$media_parts = isset( $demo_array['media_parts'] ) && $demo_array['media_parts'] != '' ? $demo_array['media_parts'] : '';
	
?>
	<div class="install-plugin-wrap theme zozothemes-demo-item<?php echo esc_attr( $demo_class ); ?>">
		<div class="install-plugin-inner">
		
			<div class="zozo-demo-import-loader zozo-preview-<?php echo esc_attr( $demo_array['demo_id'] ); ?>"><img src="<?php echo esc_url( ZOACRES_ADMIN_URL .'/welcome-page/assets/images/gear.gif' ); ?>" alt="<?php esc_html_e( 'Loader', 'zoacres' ); ?>"/><!--<i class="dashicons dashicons-admin-generic"></i>--></div>
		
			<div class="theme-screenshot zozotheme-screenshot">
				<a href="<?php echo esc_url( $demo_array['demo_url'] ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/demo/' . $demo_array['demo_img'] ); ?>" /></a>
			</div>
			<div class="install-plugin-right">
				<div class="install-plugin-right-inner">
					<h3 class="theme-name" id="<?php echo esc_attr( $demo_array['demo_id'] ); ?>"><?php echo esc_attr( $demo_array['demo_name'] ); ?></h3>
					
					<a href="#" class="theme-demo-install-custom"><?php esc_html_e( "Custom Selection", "zoacres" ); ?></a>
					
					<div class="theme-demo-install-parts" id="<?php echo esc_attr( 'demo-install-parts-'. $demo_array['demo_id'] ); ?>">
					
						<div class="demo-install-instructions">
							<ul class="install-instructions">
								<li><strong><?php esc_html_e( "General", "zoacres" ); ?></strong></li>
								<li><?php esc_html_e( 'Choose "Media" -> All the media\'s are ready to be import.', "zoacres" ); ?></li>
								<li><?php esc_html_e( 'Choose "Theme Options" -> Theme options are ready to be import.', "zoacres" ); ?></li>
								<li><?php esc_html_e( 'Choose "Widgets" -> Custom sidebars and widgets are ready to be import.', "zoacres" ); ?></li>
								<?php if( $revslider ) : ?>
								<li><?php esc_html_e( 'Choose "Revolution Sliders" -> Revolution slides are ready to be import.', "zoacres" ); ?></li>
								<?php endif; ?>
								<li><?php esc_html_e( 'Choose "All Posts" -> Posts, menus, custom post types are ready to be import.', "zoacres" ); ?></li>
								<li><p class="lead"><strong>*</strong><?php esc_html_e( 'If you check "All Posts" and Uncheck any of page, then menu will not imported.', "zoacres" ); ?></p></li>
								
								<li><strong><?php esc_html_e( "Pages", "zoacres" ); ?></strong></li>
								<li><?php esc_html_e( 'Choose pages which you want to show on your site. If you choose all the pages and check "All Post" menu will be import. If any one will not check even page or All posts, then menu will not import.', "zoacres" ); ?></li>
							</ul>
						</div>
					
						<div class="zozo-col-2">
							<h5><?php esc_html_e( "General", "zoacres" ); ?></h5>
							<?php
							if( isset( $demo_array['general'] )	 ){
								echo '<ul class="general-install-parts-list">';
								foreach( $demo_array['general'] as $key => $value ){
									echo '<li><input type="checkbox" value="'. esc_attr( $key ) .'" data-text="'. esc_attr( $value ) .'" /> '. esc_html( $value ) .'</li>';
								}
								echo '</ul>';
							}						
							?>
						</div><!-- .zozo-col-2 -->
						<div class="zozo-col-2">
							<h5><?php esc_html_e( "Pages", "zoacres" ); ?></h5>
							<?php
							if( isset( $demo_array['pages'] )	 ){
								echo '<ul class="page-install-parts-list">';
								foreach( $demo_array['pages'] as $key => $value ){
									echo '<li><input type="checkbox" value="'. esc_attr( $key ) .'" data-text="'. esc_attr( $value ) .'" /> '. esc_html( $value ) .'</li>';
								}
								echo '</ul>';
							}						
							?>
						</div><!-- .zozo-col-2 -->
						<a href="#" class="theme-demo-install-checkall"><?php esc_html_e( "Check/Uncheck All", "zoacres" ); ?></a>
						<p><?php esc_html_e( "Leave empty/uncheck all to full install.", "zoacres" ); ?></p>
					</div><!-- .theme-demo-install-parts -->

					<div class="theme-actions theme-buttons">
						<a class="button button-primary button-install-demo" data-demo-id="<?php echo esc_attr( $demo_array['demo_id'] ); ?>" data-revslider="<?php echo esc_attr( $revslider ); ?>" data-media="<?php echo esc_attr( $media_parts ); ?>" href="#">
						<?php esc_html_e( "Install", "zoacres" ); ?>
						</a>
						<a class="button button-primary button-uninstall-demo" data-demo-id="<?php echo esc_attr( $demo_array['demo_id'] ); ?>" href="#">
						<?php esc_html_e( "Uninstall", "zoacres" ); ?>
						</a>
						<a class="button button-primary" target="_blank" href="<?php echo esc_url( $demo_array['demo_url'] ); ?>">
						<?php esc_html_e( "Preview", "zoacres" ); ?>
						</a>
					</div>
					
					<div class="theme-requirements" data-requirements="<?php 
						printf( '<h2>%1$s</h2> <p>%2$s</p> <h3>%3$s</h3> <ol><li>%4$s</li></ol>', 
							esc_html__( 'WARNING:', 'zoacres' ), 
							esc_html__( 'Importing demo content will give you pages, posts, theme options, sidebars and other settings. This will replicate the live demo. Clicking this option will replace your current theme options and widgets. It can also take a minutes to complete.', 'zoacres' ),
							esc_html__( 'DEMO REQUIREMENTS:', 'zoacres' ),
							esc_html__( 'Memory Limit of 128 MB and max execution time (php time limit) of 300 seconds.', 'zoacres' )
						);
					?>">
					</div>
					
					<div class="installation-progress">
						<p></p>
						<div class="progress">
							<div class="progress-bar progress-bar-success progress-bar-striped active" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
						</div>
					</div>
					
					<div class="demo-installed-notice-wrap">
					<?php
						printf( '<p class="demo-installed-notice">%4$s <strong><a href="%1$s" class="regenerate-thumbnails-plugin-url" target="_blank" title="%2$s">%2$s</a></strong> %3$s</p>',
							esc_url( admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472' ),
							esc_html__( "Regenerate Thumbnails", "zoacres" ),
							esc_html__( "plugin once.", "zoacres" ),
							esc_html__( "This demo was imported well. So for exact image cropping use", "zoacres" )
						); //thickbox
					?>
					</div><!-- .demo-installed-notice-wrap -->
					
				</div><!-- .install-plugin-right-inner -->
			</div><!-- .install-plugin-right -->
		</div>
	</div>
<?php
}
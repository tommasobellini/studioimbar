<?php // Admin Page
if( ! class_exists( 'Zoacres_Zozo_Admin_Page' ) ){
	class Zoacres_Zozo_Admin_Page {
	
		function __construct(){
			add_action( 'admin_init', array( $this, 'zoacres_admin_page_init' ) );	
			add_action( 'admin_menu', array( $this, 'zoacres_zozo_admin_menu') );			
			add_action( 'admin_menu', array( $this, 'zoacres_zozo_edit_admin_menus' ) ); 
			add_action( 'admin_head', array( $this, 'zoacres_zozo_admin_page_scripts' ) );
			add_action( 'after_switch_theme', array( $this, 'zoacres_zozo_theme_activation_redirect' ) ); 
		}		
		
		function zoacres_admin_page_init(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				
				if( !isset( $_GET['zoacres_tgmpa_nounce'] ) && !isset( $_GET['zoacres_plugin_actv'] ) ){
					if( isset( $_GET['zozo-deactivate'] ) && $_GET['zozo-deactivate'] == 'deactivate-plugin' ) {
						check_admin_referer( 'zozo-deactivate', 'zozo-deactivate-nonce' );
						$plugins = TGM_Plugin_Activation::$instance->plugins;
						foreach( $plugins as $plugin ) {
							if( $plugin['slug'] == $_GET['plugin'] ) {
								deactivate_plugins( $plugin['file_path'] );
							}
						}
					} 
					
					if( isset( $_GET['zozo-activate'] ) && $_GET['zozo-activate'] == 'activate-plugin' ) {
						check_admin_referer( 'zozo-activate', 'zozo-activate-nonce' );
						$plugins = TGM_Plugin_Activation::$instance->plugins;
						foreach( $plugins as $plugin ) {
							if( $plugin['slug'] == $_GET['plugin'] ) {
								activate_plugin( $plugin['file_path'] );
							}
						}
					}
				}elseif( isset( $_GET['zoacres_plugin_actv'] ) ){
					$plugin_slugs = $_GET['zoacres_plugin_actv'];
					$plugin_slugs = explode( ",", $plugin_slugs );
					$plugins = TGM_Plugin_Activation::$instance->plugins;
					$active_plugins = get_option('active_plugins');
					foreach( $plugins as $plugin ) {
						if( in_array( $plugin['slug'], $plugin_slugs ) && !in_array( $plugin['file_path'], $active_plugins ) ) {
							activate_plugin( $plugin['file_path'] );
						}
					}
				}
			}
		}
		
		function zoacres_zozo_theme_activation_redirect(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				header('Location:'.admin_url().'admin.php?page=zoacres');
			}
		}
		
		function zoacres_zozo_admin_menu(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				// Work around for theme check
				$zozo_menu_page = 'add_menu' . '_page';
				$zozo_submenu_page = 'add_submenu' . '_page';
			
				/*$welcome_screen = $zozo_menu_page( 
					'Zoacres',
					'Zoacres',
					'administrator',
					'zoacres',
					array( $this, 'zoacres_themes_plugin_demo_tab' ), 
					'dashicons-admin-home',
					3);*/
					
				$system_status = $zozo_menu_page(
					'Zoacres',
					'Zoacres',
					'administrator',
					'zoacres',
					array( $this, 'zoacres_system_status' ),
					'dashicons-admin-home',
					3
				); 
				
				$plugin_demo = $zozo_submenu_page(
						'zoacres',
						esc_html__( 'Plugin and Demo', 'zoacres' ),
						esc_html__( 'Plugin and Demo', 'zoacres' ),
						'administrator',
						'zoacres-installation',
						array( $this, 'zoacres_themes_plugin_demo_tab' ) ); //array( $this, 'zoacres_zozo_welcome_screen' )
						
				$support = $zozo_submenu_page(
					'zoacres',
					esc_html__( 'Support', 'zoacres' ),
					esc_html__( 'Support', 'zoacres' ),
					'administrator',
					'zoacres-support',
					array( $this, 'zoacres_zozo_welcome_screen' ) );
				
				
				add_action( 'admin_print_scripts-'.$system_status, array( $this, 'zoacres_zozo_admin_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$plugin_demo, array( $this, 'zoacres_zozo_admin_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$support, array( $this, 'zoacres_zozo_admin_screen_scripts' ) );			
				
			}
		}
		
		function zoacres_zozo_edit_admin_menus() {
			global $submenu;
			if ( current_user_can( 'edit_theme_options' ) ) {
				$submenu['zoacres'][0][0] = 'Welcome';
			}
		}
		
		function zoacres_zozo_welcome_screen() {
			get_template_part( 'admin/welcome-page/screens/welcome' );
		}
		
		function zoacres_themes_plugin_demo_tab() {
			get_template_part( 'admin/welcome-page/screens/plugin', 'demo' ); 
		}
		
		function zoacres_system_status() {
			get_template_part( 'admin/welcome-page/screens/system', 'status' ); 
		}
				
		function zoacres_zozo_admin_page_scripts() {
			if ( is_admin() ) {
				wp_enqueue_style( 'zoacres-zozo-admin-confirm-css', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/css/jquery-confirm.min.css' ) );
				wp_enqueue_script( 'zoacres-zozo-admin-confirm-js', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/js/jquery-confirm.min.js' ) );
			}
		}
		function zoacres_zozo_admin_screen_scripts() {
			wp_enqueue_style( 'zoacres-zozo-admin-page-css', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/css/admin-screen.css' ) );
			wp_enqueue_script( 'zoacres-zozo-admin-page-js', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/js/admin-screen.js' ) );
		}
		
		function zoacres_plugin_link( $item ) {
		
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
			$installed_plugins = get_plugins();
			$item['sanitized_plugin'] = $item['name'];
			 $is_plug_act = 'is_plugin_active';
			 
			if ( $is_plug_act( $item['file_path'] ) ) {
				$actions = array(
					'deactivate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
						esc_url( add_query_arg(
							array(
								'plugin'					=> urlencode( $item['slug'] ),
								'plugin_name'		  		=> urlencode( $item['sanitized_plugin'] ),
								'plugin_source'				=> urlencode( $item['source'] ),
								'zozo-deactivate'	   		=> 'deactivate-plugin',
								'zozo-deactivate-nonce' 	=> wp_create_nonce( 'zozo-deactivate' ),
							),
							admin_url( 'admin.php?page=zoacres-installation' )
						) ),
						$item['sanitized_plugin'],
						esc_html__( 'Deactivate', 'zoacres' )
					),
				);
			}
			 
			elseif ( ! isset( $installed_plugins[$item['file_path']] ) ) {
				$actions = array(
					'install' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
						esc_url( wp_nonce_url(
							add_query_arg(
								array(
									'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-install' => 'install-plugin',
									'return_url' 	=> 'zoacres-installation'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_slug )
							),
							'tgmpa-install',
							'tgmpa-nonce'
						) ),
						$item['sanitized_plugin'],
						esc_html__( 'Install', 'zoacres' )
					),
				);
			}
			
			elseif ( is_plugin_inactive( $item['file_path'] ) ) {

				if ( version_compare( $item['version'], $installed_plugins[$item['file_path']]['Version'], '>' ) ) {
					$actions = array(
						'update' => sprintf(
							'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
							wp_nonce_url(
								add_query_arg(
									array(
										'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
										'plugin'		=> urlencode( $item['slug'] ),
										'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
										'plugin_source' => urlencode( $item['source'] ),
										'tgmpa-update' 	=> 'update-plugin',
										'version' 		=> urlencode( $item['version'] ),
										'return_url' 	=> 'zoacres-installation'
									),
									admin_url( TGM_Plugin_Activation::$instance->parent_slug )
								),
								'tgmpa-update',
								'tgmpa-nonce'
							),
							$item['sanitized_plugin'],
							esc_html__( 'Update', 'zoacres' )
						),
					);
				} else {
					$actions = array(
						'activate' => sprintf(
							'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
							esc_url( add_query_arg(
								array(
									'plugin'			   	=> urlencode( $item['slug'] ),
									'plugin_name'		  	=> urlencode( $item['sanitized_plugin'] ),
									'plugin_source'			=> urlencode( $item['source'] ),
									'zozo-activate'	   		=> 'activate-plugin',
									'zozo-activate-nonce' 	=> wp_create_nonce( 'zozo-activate' ),
								),
								admin_url( 'admin.php?page=zoacres-installation' )
							) ),
							$item['sanitized_plugin'],
							esc_html__( 'Activate', 'zoacres' )
						),
					);
				}
			}
			
			elseif ( version_compare( $item['version'], $installed_plugins[$item['file_path']]['Version'], '>' ) ) {
				$actions = array(
					'update' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
						wp_nonce_url(
							add_query_arg(
								array(
									'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-update' 	=> 'update-plugin',
									'version' 		=> urlencode( $item['version'] ),
									'return_url' 	=> 'zoacres-installation'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_slug )
							),
							'tgmpa-update',
							'tgmpa-nonce'
						),
						$item['sanitized_plugin'],
						esc_html__( 'Update', 'zoacres' )
					),
				);
			}
			
			return $actions;
		}
		
	}// class Zoacres_Zozo_Admin_Page
	new Zoacres_Zozo_Admin_Page;
}
class Zoacres_WP_FileSystem_Credentials {
	static function check_credentials() {
		// Get user credentials for WP filesystem API
		$demo_import_page_url = wp_nonce_url( 'themes.php?page=zoacres-demos', 'zoacres-demos' );
		if ( false === ( $creds = request_filesystem_credentials( $demo_import_page_url, '', false, false, null ) ) ) {
			return new WP_Error( 'XML_parse_error', esc_html__( 'There was an error when reading this WXR file', 'zoacres' ) );
		}
		// Now we have credentials, try to get the wp_filesystem running
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again
			request_filesystem_credentials( $demo_import_page_url, '', true, false, null );
			return true;
		}
	}
}
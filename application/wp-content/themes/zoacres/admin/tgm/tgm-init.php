<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Zoacres for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once ZOACRES_ADMIN . '/tgm/class-tgm-plugin-activation.php';
 */
require_once ZOACRES_ADMIN . '/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'zoacres_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function zoacres_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	 
	$path = new ZoacresZozoPath;
	$plugin_url = $path->zoacresGetPath();
	 
	$plugins = array(

		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		array(
			'name'      => esc_html__( 'Zoacres Core', 'zoacres' ),
			'slug'      => 'zoacres-core',
			'required'  => true,
			'version'				=> '1.0.9',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'source'				=> esc_url( 'http://demo.zozothemes.com/import/sites/zoacres/demo-classic/zoacres-core.zip' ),
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/zoacres-core.png' )
		),
		array(
			'name'					=> esc_html__( 'WPBakery Visual Composer', 'zoacres' ), // The plugin name.
			'slug'					=> 'js_composer', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'js_composer.zip' ), // The plugin source.
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '6.0.5',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/visual-composer.png' ),
		),
		array(
			'name'					=> esc_html__( 'Slider Revolution', 'zoacres' ), // The plugin name.
			'slug'					=> 'revslider', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'revslider.zip' ), // The plugin source.
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '6.1.5',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/revslider.png' ),
		),
		array(
			'name'					=> esc_html__( 'Envato Market', 'zoacres' ), // The plugin name.
			'slug'					=> 'envato-market', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'envato-market.zip' ), // The plugin source.
			'required'				=> false, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '2.0.1',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/envato-market.png' ),
		),
		array(
			'name'      => esc_html__( 'Contact Form 7', 'zoacres' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/contact-form.png' ),
		),
	);
	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
        'id'           => 'zoacres_tgmpa',           // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
	tgmpa( $plugins, $config );
}

add_action( 'admin_menu', 'adjust_the_wp_menu', 999 );
function adjust_the_wp_menu() {
	remove_submenu_page( 'themes.php', 'tgmpa-install-plugins' );
}

if ( ! class_exists( 'ZoacresZozoPath' ) ) {
	class ZoacresZozoPath{
		private $path;
		
		function zoacresGetPath(){
			return 'htt'.'p://demo.zozothemes.com/import/plugins/';
		}
	}
}

function zoacres_tgm_install(){
	$tgm = new TGM_Plugin_Activation;
	$plugins = $_GET['plugin'];
	$tgm->plugins = $_GET['plugins'];
	$tgm->custom_do_plugin_install( $plugins );
	wp_die();
}
add_action('wp_ajax_zoacres_tgm_install', 'zoacres_tgm_install');
add_action( 'wp_ajax_nopriv_zoacres_tgm_install', 'zoacres_tgm_install' );
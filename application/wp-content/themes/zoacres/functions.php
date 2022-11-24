<?php
/**
 * Zoacres functions and definitions
 *
 */

/**
 * Zoacres predifined vars
 */
define('ZOACRES_ADMIN', get_template_directory().'/admin');
define('ZOACRES_INC', get_template_directory().'/inc');
define('ZOACRES_THEME_ELEMENTS', get_template_directory().'/admin/theme-elements');
define('ZOACRES_ADMIN_URL', get_template_directory_uri().'/admin');
define('ZOACRES_INC_URL', get_template_directory_uri().'/inc');
define('ZOACRES_ASSETS', get_template_directory_uri().'/assets');
define('ZOACRES_DIR', get_template_directory());
define('ZOACRES_URL', get_template_directory_uri());

/* Custom Inline Css */
$zoacres_custom_styles = "";

//Theme Options
require_once ZOACRES_THEME_ELEMENTS . '/theme-options.php';

//Theme Default
require_once ZOACRES_ADMIN . '/theme-default/theme-default.php';

//Other Theme Files
require_once ZOACRES_INC . '/theme-class/theme-class.php';
require_once ZOACRES_INC . '/walker/wp_bootstrap_navwalker.php';
require_once ZOACRES_ADMIN . '/mega-menu/custom_menu.php';

//PROPERTY CLASS
require_once ZOACRES_INC . '/property-class/property-class.php';

//CUSTOM SIDEBAR
require_once ZOACRES_ADMIN . '/custom-sidebar/sidebar-generator.php';

//TGM
require_once ZOACRES_ADMIN . '/tgm/tgm-init.php'; 
require_once ZOACRES_ADMIN . '/welcome-page/welcome.php';

//METABOX
if( class_exists( 'ZoacresRedux' ) ){
	require_once ZOACRES_ADMIN . '/metabox/zoacres-metabox.php'; 	
}

//ZOZO IMPORTER
if( class_exists( 'Zoacres_Zozo_Admin_Page' ) ){
	require_once ZOACRES_ADMIN . '/welcome-page/importer/zozo-importer.php'; 	
}

//VC SHORTCODES
if ( class_exists( 'Vc_Manager' ) ) {
	require_once ZOACRES_INC . '/vc/vc-init.php'; 	
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function zoacres_setup() {
	/* Zoacres Text Domain */
	load_theme_textdomain( 'zoacres', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	
	/* Custom background */
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );
	
	/* Custom header */
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );
	
	/* Content width */
	if ( ! isset( $content_width ) ) $content_width = 640;
	
	$ao = new ZoacresThemeOpt;
	$grid_large = $ao->zoacresThemeOpt('zoacres_grid_large');
	$grid_medium = $ao->zoacresThemeOpt('zoacres_grid_medium');
	$grid_small = $ao->zoacresThemeOpt('zoacres_grid_small');
	$port_masonry = $ao->zoacresThemeOpt('zoacres_portfolio_masonry');
	
	if( !empty( $grid_large ) && is_array( $grid_large ) ) add_image_size( 'zoacres-grid-large', $grid_large['width'], $grid_large['height'], true );
	if( !empty( $grid_medium ) && is_array( $grid_medium ) ) add_image_size( 'zoacres-grid-medium', $grid_medium['width'], $grid_medium['height'], true );
	if( !empty( $grid_small ) && is_array( $grid_small ) ) add_image_size( 'zoacres-grid-small', $grid_small['width'], $grid_small['height'], true );
	
	//Team
	$team_medium = $ao->zoacresThemeOpt('zoacres_team_medium');
	if( !empty( $team_medium ) && is_array( $team_medium ) ) add_image_size( 'zoacres-team-medium', $team_medium['width'], $team_medium['height'], true );

	update_option( 'large_size_w', 1170 );
	update_option( 'large_size_h', 694 );
	update_option( 'large_crop', 1 );
	update_option( 'medium_size_w', 768 );
	update_option( 'medium_size_h', 456 );
	update_option( 'medium_crop', 1 );
	update_option( 'thumbnail_size_w', 80 );
	update_option( 'thumbnail_size_h', 80 );
	update_option( 'thumbnail_crop', 1 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top-menu'		=> esc_html__( 'Top Bar Menu', 'zoacres' ),
		'primary-menu'	=> esc_html__( 'Primary Menu', 'zoacres' ),
		'footer-menu'	=> esc_html__( 'Footer Menu', 'zoacres' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style-editor.css' );

	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Dark Gray', 'zoacres' ),
				'slug'  => 'dark-gray',
				'color' => '#111',
			),
			array(
				'name'  => __( 'Light Gray', 'zoacres' ),
				'slug'  => 'light-gray',
				'color' => '#767676',
			),
			array(
				'name'  => __( 'White', 'zoacres' ),
				'slug'  => 'white',
				'color' => '#FFF',
			),
		)
	);

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
	
}
add_action( 'after_setup_theme', 'zoacres_setup' );

/**
 * Register widget area.
 *
 */
function zoacres_widgets_init() {
	
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'zoacres' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Menu Sidebar', 'zoacres' ),
		'id'            => 'secondary-menu-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your secondary menu area.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'zoacres' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'zoacres' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'zoacres' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'IDX Sidebar', 'zoacres' ),
		'id'            => 'idx-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in idex template sidebar.', 'zoacres' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'zoacres_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Zoacres 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function zoacres_excerpt_more( $link ) {
	return '';
}
add_filter( 'excerpt_more', 'zoacres_excerpt_more' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function zoacres_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'zoacres_pingback_header' );

/**
 * Admin Enqueue scripts and styles.
 */
function zoacres_enqueue_admin_script() { 

	//Themify Icons
	wp_register_style( 'themify-icons', get_theme_file_uri( '/assets/css/themify-icons.css' ), array(), '1.0' );
	wp_enqueue_style( 'themify-icons' );

	wp_enqueue_style( 'zoacres-admin-style', get_theme_file_uri( '/admin/assets/css/admin-style.css' ), array(), '1.0' );
	
	// Meta Drag and Drop Script
	wp_enqueue_script( 'zoacres-admin-scripts', get_theme_file_uri( '/admin/assets/js/admin-scripts.js' ), array( 'jquery' ), '1.0', true ); 
	
	//Table to JSON
	wp_enqueue_script( 'table-to-json', get_theme_file_uri( '/admin/assets/js/jquery.tabletojson.min.js' ), array( 'jquery' ), '0.13.0', true ); 

	//Admin Localize Script
	wp_localize_script('zoacres-admin-scripts', 'zoacres_admin_ajax_var', array(
		'admin_ajax_url' => esc_url( admin_url('admin-ajax.php') ),
		'featured_nonce' => wp_create_nonce('zoacres-post-featured'), 
		'sidebar_nounce' => wp_create_nonce('zoacres-sidebar-featured'), 
		'redux_themeopt_import' => wp_create_nonce('zoacres-redux-import'),
		'zoacres_tgmpa_nounce' => wp_create_nonce('zoacres-tgmpa-plugins-install'),
		'unins_confirm' => esc_html__('Please backup your files and database before uninstall. Are you sure want to uninstall current demo?.', 'zoacres'),
		'yes' => esc_html__('Yes', 'zoacres'),
		'no' => esc_html__('No', 'zoacres'),
		'proceed' => esc_html__('Proceed', 'zoacres'),
		'cancel' => esc_html__('Cancel', 'zoacres'),
		'process' => esc_html__( 'Processing', 'zoacres' ),
		'uninstalling' => esc_html__('Uninstalling...', 'zoacres'),
		'uninstalled' => esc_html__('Uninstalled.', 'zoacres'),
		'unins_pbm' => esc_html__('Uninstall Problem!.', 'zoacres'),
		'downloading' => esc_html__('Demo import process running...', 'zoacres'), 
		'zoacres_installation_url' => admin_url( 'admin.php?page=zoacres-installation' ),
		'import_xml' => esc_html__('Importing Xml...', 'zoacres'),
		'import_theme_opt' => esc_html__('Importing Theme Option...', 'zoacres'),
		'import_widg' => esc_html__('Importing Widgets...', 'zoacres'),
		'import_sidebars' => esc_html__('Importing Sidebars...', 'zoacres'),
		'import_revslider' => esc_html__('Importing Revolution Sliders...', 'zoacres'),
		'imported' => esc_html__('Successfully Imported, Check Above Message.', 'zoacres'),
		'import_pbm' => esc_html__('Import Problem.', 'zoacres'),
		'access_pbm' => esc_html__('File access permission problem.', 'zoacres'),
		'cf_field_name' => esc_html__('Field Name', 'zoacres'),
		'cf_field_type' => esc_html__('Field Type', 'zoacres'),
		'cf_dd_values' => esc_html__('Dropdown Values', 'zoacres'),
		'cf_delete' => esc_html__('Delete', 'zoacres'),
		'cf_add_new' => esc_html__('Add New', 'zoacres'),
		'cf_text' => esc_html__('Text', 'zoacres'),
		'cf_textarea' => esc_html__('Text Area', 'zoacres'),
		'cf_checkbox' => esc_html__('Checkbox', 'zoacres'),
		'cf_dd' => esc_html__('Dropdown', 'zoacres'),
		'cf_separate_txt' => esc_html__('Enter list values separate by comma(,).', 'zoacres'),
		'cf_add' => esc_html__('Add', 'zoacres'),
		'cf_index' => esc_html__('Index', 'zoacres'),
		'cf_close' => esc_html__('Close', 'zoacres'),
		'cf_update' => esc_html__('Update', 'zoacres'),
		'agent_properties' => wp_create_nonce('zoacres-agent-properties-time'),
		'property_active' => wp_create_nonce('zoacres-active-deactive'),
		'over_limit' => esc_html__('Limit Crossed', 'zoacres')
	));
	
}
add_action( 'admin_enqueue_scripts', 'zoacres_enqueue_admin_script' );

/**
 * Enqueue scripts and styles.
 */
function zoacres_scripts() { 


	/*Visual Composer CSS*/
	if ( class_exists( 'Vc_Manager' ) ) {
		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_style( 'js_composer_custom_css' );
	}

	/* Zoacres Theme Styles */

	// Zoacres Style Libraries
	
	$rto = new ZoacresThemeOpt;
	$minify_js = $rto->zoacresThemeOpt('js-minify');
	$minify_css = $rto->zoacresThemeOpt('css-minify');
	
	if( $minify_css ){
		wp_enqueue_style( 'zoacres-min', get_theme_file_uri( '/assets/css/theme.min.css' ), array(), '1.0' );
	}else{
		wp_enqueue_style( 'bootstrap-beta', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), '4.1.0' );
		wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/css/font-awesome.min.css' ), array(), '4.7.0' );
		wp_enqueue_style( 'flaticon', get_theme_file_uri( '/assets/css/flaticon.css' ), array(), '1.0' );
		wp_enqueue_style( 'simple-line-icons', get_theme_file_uri( '/assets/css/simple-line-icons.min.css' ), array(), '1.0' );
		wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/assets/css/owl-carousel.min.css' ), array(), '2.2.1' );
		wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ), array(), '1.0' );
		wp_enqueue_style( 'image-hover', get_theme_file_uri( '/assets/css/image-hover.min.css' ), array(), '1.0' );
		wp_enqueue_style( 'ytplayer', get_theme_file_uri( '/assets/css/ytplayer.min.css' ), array(), '1.0' );
		wp_enqueue_style( 'animate', get_theme_file_uri( '/assets/css/animate.min.css' ), array(), '3.5.1' );
		wp_enqueue_style( 'lightslider', get_theme_file_uri( '/assets/css/lightslider.css' ), array(), '1.1.3' );
	}
	
	wp_register_style( 'slick', get_theme_file_uri( '/assets/css/slick.min.css' ) );
	
	// Theme stylesheet.
	wp_enqueue_style( 'zoacres-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
	
	// Shortcode Styles
	wp_enqueue_style( 'zoacres-shortcode', get_theme_file_uri( '/assets/css/shortcode.css' ), array(), '1.0' );

	
	/* Zoacres theme script files */
	
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	
	wp_enqueue_script( 'jquery-ui', get_theme_file_uri( '/assets/js/jquery-ui.min.js' ), array('jquery'), '1.0', true );
	
	// Zoacres JS Libraries
	if( $minify_js ){
		wp_enqueue_script( 'zoacres-theme-min', get_theme_file_uri( '/assets/js/theme.min.js' ), array( 'jquery' ), '1.0', true );
	}else{
		wp_enqueue_script( 'popper', get_theme_file_uri( '/assets/js/popper.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), '4.0.0', true );
		wp_enqueue_script( 'owl-carousel', get_theme_file_uri( '/assets/js/owl.carousel.min.js' ), array( 'jquery' ), '2.2.1', true );
		wp_enqueue_script( 'isotope', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), '3.0.3', true );
		wp_enqueue_script( 'infinite-scroll', get_theme_file_uri( '/assets/js/infinite-scroll.pkgd.min.js' ), array( 'jquery' ), '2.0', true );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'jquery-stellar', get_theme_file_uri( '/assets/js/jquery.stellar.min.js' ), array( 'jquery' ), '0.6.2', true );
		wp_enqueue_script( 'sticky-kit', get_theme_file_uri( '/assets/js/sticky-kit.min.js' ), array( 'jquery' ), '1.1.3', true );
		wp_enqueue_script( 'jquery-mb-YTPlayer', get_theme_file_uri( '/assets/js/jquery.mb.YTPlayer.min.js' ), array( 'jquery' ), '1.0', true );	
		wp_enqueue_script( 'jquery-magnific', get_theme_file_uri( '/assets/js/jquery.magnific.popup.min.js' ), array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'jquery-easy-ticker', get_theme_file_uri( '/assets/js/jquery.easy.ticker.min.js' ), array( 'jquery' ), '2.0', true );
		wp_enqueue_script( 'jquery-easing', get_theme_file_uri( '/assets/js/jquery.easing.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'jquery-countdown', get_theme_file_uri( '/assets/js/jquery.countdown.min.js' ), array( 'jquery' ), '2.2.0', true );
		wp_enqueue_script( 'jquery-circle-progress', get_theme_file_uri( '/assets/js/jquery.circle.progress.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'jquery-appear', get_theme_file_uri( '/assets/js/jquery.appear.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'smoothscroll', get_theme_file_uri( '/assets/js/smoothscroll.min.js' ), array( 'jquery' ), '1.20.2', true );
	}
	
	//Panorama	
	if( is_singular( 'zoacres-property' ) ){
		wp_register_script( 'lightslider', get_theme_file_uri( '/assets/js/lightslider.js' ), array('jquery'), '1.0', true );
		wp_register_style( 'pannellum', get_theme_file_uri( '/assets/css/pannellum.min.css' ), array(), '1.0' );
		wp_register_script( 'pannellum', get_theme_file_uri( '/assets/js/pannellum.min.js' ), array('jquery'), '1.0', true );
		wp_register_script( 'zoacres-chart', get_theme_file_uri( '/assets/js/zoacres-chart.js' ), array('jquery'), '1.0', true );
	}
	
	//Slick js for property archive gallery
	wp_register_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jquery'), '1.8.0', true );
	//Rain Drops
	wp_register_script( 'raindrops', get_theme_file_uri( '/assets/js/raindrops.js' ), array( 'jquery', 'jquery-ui' ), '1.0', true );

	// Theme Js
	wp_enqueue_script( 'zoacres-theme', get_theme_file_uri( '/assets/js/theme.js' ), array( 'jquery' ), '1.0', true );
	
	// Property Script
	wp_enqueue_script( 'zoacres-functional', get_theme_file_uri( '/assets/js/zoacres-functional.js' ), array( 'jquery' ), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Theme option stylesheet.
	$upload_dir = zoacres_fn_get_upload_dir_var('baseurl');
	$zoacres = wp_get_theme();
	$theme_style = $upload_dir . '/zoacres/theme_'.get_current_blog_id().'.css';
	wp_enqueue_style( 'zoacres-theme-style', esc_url( $theme_style ), array(), $zoacres->get( 'Version' ) );
	
	$zoacres_option = get_option( 'zoacres_options' );	
	$map_stat = 0;
	//Google Map Script
	if( isset( $zoacres_option['google-api'] ) && $zoacres_option['google-api'] != '' ){
		$map_stat = 1;
		wp_register_script( 'marker-clusterer', get_theme_file_uri( '/assets/js/markerclusterer.js' ), array('jquery'), null, true );
		wp_register_script( 'zoacres-gmaps', '//maps.googleapis.com/maps/api/js?key='. esc_attr( $zoacres_option['google-api'] ) .'&libraries=places', array('jquery'), null, true ); //googleapis
		wp_register_script( 'infobox', get_theme_file_uri( '/assets/js/infobox.js' ), array('jquery'), null, true );
	}
	
	

	$infinite_image = isset( $zoacres_option['infinite-loader-img']['url'] ) && $zoacres_option['infinite-loader-img']['url'] != '' ? $zoacres_option['infinite-loader-img']['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
	
	$log_stat = is_user_logged_in() ? true : false;
	$theme_color = isset( $zoacres_option['theme-color'] ) && !empty( $zoacres_option['theme-color'] ) ? $zoacres_option['theme-color'] : '';
	
	//Localize Script
	wp_localize_script('zoacres-theme', 'zoacres_ajax_var', array(
		'admin_ajax_url' => esc_url( admin_url('admin-ajax.php') ),
		'like_nonce' => wp_create_nonce('zoacres-post-like'), 
		'fav_nonce' => wp_create_nonce('zoacres-post-fav'),
		'infinite_loader' => $infinite_image,
		'load_posts' => apply_filters( 'infinite_load_msg', esc_html__( 'Loading next set of posts.', 'zoacres' ) ),
		'no_posts' => apply_filters( 'infinite_finished_msg', esc_html__( 'No more posts to load.', 'zoacres' ) ),
		'cmt_nonce' => wp_create_nonce('zoacres-comment-like'),
		'mc_nounce' => wp_create_nonce('zoacres-mailchimp'),
		'agent_nounce' => wp_create_nonce('zoacres-agent-contact'),		
		'agent_rate' => wp_create_nonce('zoacres-agent-rating'),
		'filter_area' => wp_create_nonce('zoacres-advance-search'),
		'adv_search' => wp_create_nonce('zoacres-advance-search'),
		'key_search' => wp_create_nonce('zoacres-key-search'),
		'filter_ajax' => wp_create_nonce('zoacres-filter-ajax'),
		'profile_update' => wp_create_nonce('zoacres-profile-update'),
		'key_search_map' => wp_create_nonce('zoacres-key-search-map'),
		'role_change' => wp_create_nonce('zoacres-role-change'),
		'agent_properties' => wp_create_nonce('zoacres-get-agent-properties'),
		'agent_fav_properties' => wp_create_nonce('zoacres-get-property-favourite'),
		'property_add_new' => wp_create_nonce('zoacres-add-new-property'),
		'img_test' => wp_create_nonce('zoacres-img-test'),
		'docs_upload' => wp_create_nonce('zoacres-docs-upload'),
		'remove_docs' => wp_create_nonce('zoacres-remove-documents'),
		'save_search' => wp_create_nonce('zoacres-set-saved-search'),
		'wait' => esc_html__('Wait..', 'zoacres'),
		'del' => esc_html__('Deleting..', 'zoacres'),
		'must_fill' => esc_html__('Must Fill Required Details.', 'zoacres'),
		'valid_email' => esc_html__('Enter Valid Email ID.', 'zoacres'),
		'cart_update_pbm' => esc_html__('Cart Update Problem.', 'zoacres'),
		'search_load' => esc_url( ZOACRES_ASSETS . '/images/search/loader.gif' ),
		'assets_url' => ZOACRES_ASSETS,
		'try_again' => esc_html__('Try again!.', 'zoacres'),
		'all_state' => esc_html__('All State', 'zoacres'),
		'all_cities' => esc_html__('All Cities', 'zoacres'),
		'all_areas' => esc_html__('All Areas', 'zoacres'),
		'prop_not_found' => esc_html__('No such a property found!', 'zoacres'),
		'prop_compare' => esc_html__('Compare', 'zoacres'),
		'prop_compare_msg' => esc_html__('Property compare need at least 2 properties!', 'zoacres'),
		'property_featured' => wp_create_nonce('zoacres-property-featured'),
		'property_remove' => wp_create_nonce('zoacres-property-remove'),
		'property_compare' => wp_create_nonce('zoacres-property-compare'),
		'add_fav' => wp_create_nonce('zoacres-property-favourite'),
		'social_login' => wp_create_nonce('zoacres-social-login'),
		'fb_login' => wp_create_nonce('zoacres-socialfb-login'),
		'not_found' => esc_html__('Nothing Found!', 'zoacres'),
		'no_more_property' => esc_html__('No more property to load!', 'zoacres'),
		'details_updated' => esc_html__('Details are updated.', 'zoacres'),
		'not_equal_pswd' => esc_html__('Passwords are not equal.', 'zoacres'),
		'pswd_changed' => esc_html__('Password changed.', 'zoacres'),
		'pswd_mismatch' => esc_html__('Old password mismatch.', 'zoacres'),
		'user_log_stat' => $log_stat,
		'theme_color' => $theme_color,
		'name_required' => esc_html__('Name field must not empty!', 'zoacres'),
		'email_required' => esc_html__('"Must put valid email id!', 'zoacres'),
		'phone_required' => esc_html__('Must put valid phone number!', 'zoacres'),
		'mortgage_pay' => esc_html__('Mortgage Payments:', 'zoacres'),
		'cost_of_loan' => esc_html__('Annual cost of Loan:', 'zoacres'),
		'finance' => esc_html__('Amount Financed:', 'zoacres'),
		'gallery_limit' => esc_html__('Images Count Overflow. Please Check Your Package.', 'zoacres'),
		'too_large' => esc_html__('This file size overflow the max file size limit.', 'zoacres'),
		'remove_user_msg' => wp_create_nonce('zoacres-remove-user-message'),
		'remove_saved_search' => wp_create_nonce('zoacres-remove-saved-search'),
		'my_location_pointer' => esc_url( ZOACRES_ASSETS . '/images/my-location-pointer.png' ),
		'paypal_nonce' => wp_create_nonce('zoacres-paypal-transaction'),
		'no_user_img' => esc_url( ZOACRES_ASSETS . '/images/no-img.jpg' ),
		'map_stat' => $map_stat
	));
	
}
add_action( 'wp_enqueue_scripts', 'zoacres_scripts' );

/**
 * Enqueue supplemental block editor styles.
 */
function zoacres_editor_customizer_styles() {
	wp_enqueue_style( 'google-fonts', zoacres_redux_fonts_url(), array(), null, 'all' );
	wp_enqueue_style( 'zoacres-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.0', 'all' );
	
	ob_start();
	require_once ZOACRES_THEME_ELEMENTS . '/theme-customizer-styles.php';
	$custom_styles = ob_get_clean();
	
	wp_add_inline_style( 'zoacres-editor-customizer-styles', $custom_styles );
}
add_action( 'enqueue_block_editor_assets', 'zoacres_editor_customizer_styles' );

/**

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Real estate functionalities.
 */
require get_parent_theme_file_path( '/inc/zoacres-functions.php' );

/*Theme Code*/
/*Search Form Filter*/
if( ! function_exists('zoacres_zozo_search_form') ) {
	function zoacres_zozo_search_form( $form ) {
		
		$search_out = '
		<form method="get" class="search-form" action="'. esc_url( home_url( '/' ) ) .'">
			<div class="input-group">
				<input type="text" class="form-control" name="s" value="'. get_search_query() .'" placeholder="'. esc_attr__('Search for...', 'zoacres') .'">
				<span class="input-group-btn">
					<button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>';
		return $search_out;
	}
	add_filter( 'get_search_form', 'zoacres_zozo_search_form' );
}

$aps = new ZoacresPostSettings;
add_action( 'wp_ajax_post_like_act', array( &$aps, 'zoacresMetaLikeCheck' ) );
add_action( 'wp_ajax_nopriv_post_like_act', array( &$aps, 'zoacresMetaLikeCheck' ) ); 
add_action( 'wp_ajax_post_fav_act', array( &$aps, 'zoacresMetaFavouriteCheck' ) );
add_action( 'wp_ajax_nopriv_post_fav_act', array( &$aps, 'zoacresMetaFavouriteCheck' ) );

if( $aps->zoacresGetThemeOpt( 'comments-like' ) ){
	add_action('wp_ajax_nopriv_comment_like', array( &$aps, 'zoacresCommentsLike' ) );
	add_action('wp_ajax_comment_like', array( &$aps, 'zoacresCommentsLike' ) );
}

if( ! function_exists('zoacresPostComments') ) {
	function zoacresPostComments( $comment, $args, $depth ) {
	
		$GLOBALS['comment'] = $comment;
		
		$aps = new ZoacresPostSettings;		
		
		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			)
		);
		
		?>
		<li <?php comment_class('clearfix'); ?> id="comment-<?php comment_ID() ?>">
			
			<div class="media thecomment">
						
				<div class="media-left author-img">
					<?php echo get_avatar($comment,$args['avatar_size']); ?>
				</div>
				
				<div class="media-body comment-text">
					<p class="comment-meta">
					<?php if( $depth < $args['max_depth'] ) : ?>
					<span class="reply pull-right">
						<?php comment_reply_link( array_merge( $args, array('reply_text' => '<span class="fa fa-reply theme-color"></span> ' . esc_html__('Reply', 'zoacres'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID ); ?>
					</span>
					<?php endif; ?>
					<span class="author"><?php echo get_comment_author_link(); ?></span>
					<span class="date"><?php printf( wp_kses( __( '%1$s at %2$s', 'zoacres' ), $allowed_html ), get_comment_date(),  get_comment_time()) ?></span>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><i class="icon-info-sign"></i> <?php esc_html_e( 'Comment awaiting approval', 'zoacres' ); ?></em>
						<br />
					<?php endif; ?>
					</p>
					<?php comment_text(); ?>
					<!-- Custom Comments Meta -->
					<?php if( $aps->zoacresGetThemeOpt( 'comments-like' ) || $aps->zoacresGetThemeOpt( 'comments-share' ) ) : ?>
						<div class="comment-meta-wrapper clearfix">
							<ul class="list-inline">
								<?php if( $aps->zoacresGetThemeOpt( 'comments-like' ) ) : ?>
								<li class="comment-like-wrapper"><?php echo do_shortcode( $aps->zoacresCommentLikeOut( $comment->comment_ID ) ); ?></li>
								<?php endif; ?>
								<?php if( $aps->zoacresGetThemeOpt( 'comments-social-shares' )) : ?>
								<li class="comment-share-wrapper pull-right"><?php echo do_shortcode( $aps->zoacresCommentShare( $comment->comment_ID ) ); ?></li>
								<?php endif; ?>
							</ul>
						</div>
					<?php endif; // if comment meta need ?>
				</div>
						
			</div>
			
			
		</li>
		<?php
		
	} 
}
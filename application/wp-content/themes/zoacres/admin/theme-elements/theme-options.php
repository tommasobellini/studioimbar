<?php

if( class_exists( 'ZoacresRedux' ) ){
	
	require_once ZOACRES_INC . '/theme-class/theme-style-class.php';
	
	add_action('redux/options/zoacres_options/saved', 'zoacres_save_theme_options', 10, 2);
	add_action('redux/options/zoacres_options/import', 'zoacres_save_theme_options', 10, 1);
	add_action('redux/options/zoacres_options/reset', 'zoacres_save_theme_options');
	add_action('redux/options/zoacres_options/section/reset', 'zoacres_save_theme_options');
	
}

function zoacres_save_theme_options() {

	if( function_exists( 'zoacres_check_user_package_expiry' ) ){
		zoacres_check_user_package_expiry();
	}

	$theme_id = get_current_blog_id();
	$upload_dir = wp_upload_dir();
	$cus_dir_name = $upload_dir['basedir'] . '/zoacres';

	if ( ! file_exists( $cus_dir_name ) ) {
		wp_mkdir_p( $cus_dir_name );
	}

	// Custom Styles File
	ob_start();
	require_once ZOACRES_THEME_ELEMENTS . '/theme-styles.php';
	$custom_content = ob_get_clean();
	$filename =  $cus_dir_name . '/theme_'. esc_attr( $theme_id ) .'.css';
	$custom_content = preg_replace("/[\r\n]+/", "\n", $custom_content);
	zoacres_file_access_permission($filename, $custom_content);
	
}

function zoacres_file_access_permission( $filename, $custom_content ){

	global $wp_filesystem;
	if( empty( $wp_filesystem ) ) {
		include_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}
	
	if( $wp_filesystem ) {
	
		$wp_filesystem->put_contents(
			$filename,
			$custom_content,
			FS_CHMOD_FILE // predefined mode settings for WP files
		);
		
	}
	
}

add_action( 'wp_ajax_zoacres-redux-themeopt-import', 'zoacres_redux_themeopt_import' );
function zoacres_redux_themeopt_import(){

	$nonce = sanitize_text_field($_POST['nonce']);
	  
	if ( ! wp_verify_nonce( $nonce, 'zoacres-redux-import' ) )
		die ( esc_html__( 'Busted', 'zoacres' ) );
	
	$json_data = $json_url = '';isset( $_POST['json_data'] ) ? $_POST['json_data'] : '';
	if( isset( $_POST['stat'] ) && $_POST['stat'] == 'data' ){
		$json_data = isset( $_POST['json_data'] ) ? stripslashes( urldecode( $_POST['json_data'] ) ): '';
	}elseif( isset( $_POST['stat'] ) && $_POST['stat'] == 'url' ){
		$json_url = isset( $_POST['json_data'] ) ? urldecode( $_POST['json_data'] ) : '';
		$json_data = zoacres_get_server_files( $json_url );
	}
	// Reset new theme option values
	delete_option( 'zoacres_options' );
	$zoacres_options = json_decode( $json_data, true );
	update_option( 'zoacres_options', $zoacres_options );

	wp_die();
}



function zoacres_redux_fonts_url() {



    // global variable

    $fonts_url = '';

	$font_families = array();

	$font_subsets = array();

	

	$fonts_lists = array( 'body-typography', 'h1-typography', 'h2-typography', 'h3-typography', 'h4-typography', 'h5-typography', 'h6-typography' );

	foreach( $fonts_lists as $fonts_list ){

		$font_n = zoacresThemeOpt::zoacresStaticThemeOpt($fonts_list);

		$font_n_family = $font_n['font-family'];

		$font_n_weight = $font_n['font-weight'];

		$font_n_subset = $font_n['subsets'];

	

		if ( 'false' !== $font_n['google'] ){

			$font_families[] = $font_n_family . ':' . $font_n_weight;

			if( !empty( $font_n_subset ) ){

				$font_subsets[]	= $font_n_subset;

			}

		}

	}



    // Remove duplicate values

    $font_families = array_unique($font_families);

    $font_subsets = array_unique($font_subsets);



    // Combine multiple fonts into one request

	$query_args = array(

		'family' => urlencode( implode( '|', $font_families ) ),

		'subset' => urlencode( implode( ',', $font_subsets )),

	);

	$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );



    return $fonts_url;

}
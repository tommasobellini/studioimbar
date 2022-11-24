<?php
/**
 * Additional features to allow styling of the templates
 */

function zoacres_custom_scripts() {
	
	global $zoacres_custom_styles;
	
	if( zoacres_po_exists() ):
		// Page Styles
		require_once ZOACRES_THEME_ELEMENTS . '/page-styles.php';
		ob_start();
		zoacres_page_custom_styles();
		$zoacres_custom_styles = ob_get_clean();
		wp_add_inline_style( 'zoacres-theme-style', $zoacres_custom_styles );
		
	elseif( is_single() && has_post_format( 'quote' ) ):
		$meta_opt = get_post_meta( get_the_ID(), 'zoacres_post_quote_modal', true );
		if( $meta_opt != '' && $meta_opt != 'theme-default' ) :
			$aps = new ZoacresPostSettings;
			$theme_color = $aps->zoacresThemeColor();
			$rgba_08 = $aps->zoacresHex2Rgba( $theme_color, '0.8' ); 
			$blockquote_bg_opt = $aps->zoacresCheckMetaValue( 'zoacres_post_quote_modal', 'single-post-quote-format' );
			ob_start();
			$aps->zoacresQuoteDynamicStyle( 'single-post', $blockquote_bg_opt, $theme_color, $rgba_08 );
			$zoacres_custom_styles .= ob_get_clean();
		endif;
	elseif( is_single() && has_post_format( 'link' ) ):
		$meta_opt = get_post_meta( get_the_ID(), 'zoacres_post_link_modal', true );
		if( $meta_opt != '' && $meta_opt != 'theme-default' ) :
			$aps = new ZoacresPostSettings;
			$theme_color = $aps->zoacresThemeColor();
			$rgba_08 = $aps->zoacresHex2Rgba( $theme_color, '0.8' ); 
			$blockquote_bg_opt = $aps->zoacresCheckMetaValue( 'zoacres_post_link_modal', 'single-post-link-format' );
			ob_start();
			$aps->zoacresLinkDynamicStyle( 'single-post', $blockquote_bg_opt, $theme_color, $rgba_08 );
			$zoacres_custom_styles .= ob_get_clean();
		endif;
	endif;
	
	if( !zoacres_po_exists() && is_single() ){
		// Page Styles
		require_once ZOACRES_THEME_ELEMENTS . '/page-styles.php';
		ob_start();
		zoacres_post_custom_styles();
		$zoacres_custom_styles .= ob_get_clean();
	}
	
	if( is_single() && !empty( $zoacres_custom_styles ) ):
		wp_add_inline_style( 'zoacres-theme-style', $zoacres_custom_styles );
	endif;
	
}
add_action( 'wp_enqueue_scripts', 'zoacres_custom_scripts' );

function zoacres_rtl_body_classes( $classes ) {
    $classes[] = 'rtl';
    return $classes;     
}

add_action('wp_ajax_zoacres-custom-sidebar-export', 'zoacres_custom_sidebar_export');
function zoacres_custom_sidebar_export(){

	$nonce = sanitize_text_field($_POST['nonce']);
  
    if ( ! wp_verify_nonce( $nonce, 'zoacres-sidebar-featured' ) )
        die ( esc_html__( 'Busted!', 'zoacres' ) );
	
	$sidebar = get_option('zoacres_custom_sidebars');
	echo ( ''. $sidebar );
	
	exit;
}

if( ! function_exists('zoacres_ads_out') ) {
	function zoacres_ads_out( $field ){
		$ato = new ZoacresThemeOpt;
		$output = '';
		if( $ato->zoacresThemeOpt( $field.'-ads-text' ) ){
			$ads_hide = '';
			if( $ato->zoacresThemeOpt( $field.'-ads-md' ) == 'no' ){
				$ads_hide .= 'hidden-xs-up ';
			}
			if( $ato->zoacresThemeOpt( $field.'-ads-sm' ) == 'no' ){
				$ads_hide .= 'hidden-md-down ';
			}
			if( $ato->zoacresThemeOpt( $field.'-ads-xs' ) == 'no' ){
				$ads_hide .= 'hidden-sm-down ';
			}
			$output = '<div class="adv-wrapper '. esc_attr( $ads_hide ) .'">'. apply_filters( 'zoacres_ads_output_form', $ato->zoacresThemeOpt( $field.'-ads-text' ) ) .'</div>';
		}
		return $output;
	}
}

function zoacres_po_exists( $post_id = '' ){
	$post_id = $post_id ? $post_id : get_the_ID();
	$stat = get_post_meta( $post_id, 'zoacres_page_layout', true );
	
	if( $stat )
		return true;
	else
		return false;
}

/*Search Options*/
if( ! function_exists('zoacres_search_post') ) {
	function zoacres_search_post($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}
	return $query;
	}
}
if( ! function_exists('zoacres_search_page') ) {
	function zoacres_search_page($query) {
		if ($query->is_search) {
			$query->set('post_type',array('page'));
		}
	return $query;
	}
}
if( ! function_exists('zoacres_search_setup') ) {
	function zoacres_search_setup(){
		$ato = new ZoacresThemeOpt;
		$search_cont = $ato->zoacresThemeOpt( 'search-content' );
		if( $search_cont == "post" ){
			add_filter('pre_get_posts','zoacres_search_post');
		}elseif( $search_cont == "page" ){
			add_filter('pre_get_posts','zoacres_search_page');
		}
	}
	add_action( 'after_setup_theme', 'zoacres_search_setup' );
}

//Return same value for filter
if( ! function_exists('__return_value') ) {
	function __return_value( $value ) {
		return function () use ( $value ) {
			return $value; 
		};
	}
}

if( !function_exists( 'zoacresGetCSSAnimation' ) && class_exists( 'Vc_Manager' ) ) {
	function zoacresGetCSSAnimation( $css_animation ) {
		$output = '';
		if ( '' !== $css_animation && 'none' !== $css_animation ) {
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_style( 'vc_animate-css' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
		}
	
		return $output;
	}
}

/*Facebook Comments Code*/
if( ! function_exists('zoacres_fb_comments_code') ) {
	function zoacres_fb_comments_code(){
		$ato = new ZoacresThemeOpt;
		$fb_width = $ato->zoacresThemeOpt( 'fb-comments-width' );
		$fb_width = isset( $fb_width['width'] ) && $fb_width['width'] != '' ? esc_attr( $fb_width['width'] ) : '300px';
		$comment_num = $ato->zoacresThemeOpt( 'fb-comments-number' );
		$fb_number = $comment_num != '' ? absint( $comment_num ) : '5';
?>
		<div class="fb-comments" data-href="<?php esc_url( the_permalink() ); ?>" data-width="<?php echo esc_attr( $fb_width ); ?>" data-numposts="<?php echo esc_attr( $fb_number ); ?>"></div>
	<?php
	}
}

if( !function_exists( 'zoacres_shortcode_rand_id' ) ) {
	function zoacres_shortcode_rand_id() {
		static $shortcode_rand = 1;
		return $shortcode_rand++;
	}
}

/*Image Size Check*/
function zoacres_custom_image_size_chk( $thumb_size, $custom_size = array(), $pid = '' ){
	$img_sizes = $img_width = $img_height = $src = '';
	$img_stat = 0;
	$custom_img_size = '';

	if( ! $pid ) $pid = get_the_ID();
		
	if( class_exists('Aq_Resize') ) {
		
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), "full", false, '' );
		$img_width = $img_height = '';
		if( !empty( $custom_size ) ){
			$img_width = isset( $custom_size[0] ) ? $custom_size[0] : '';
			$img_height = isset( $custom_size[1] ) ? $custom_size[1] : '';
		}else{
			$custom_img_size = ZoacresThemeOpt::zoacresStaticThemeOpt($thumb_size);
			$img_width = isset( $custom_img_size['width'] ) ? $custom_img_size['width'] : '';
			$img_height = isset( $custom_img_size['height'] ) ? $custom_img_size['height'] : '';
		}
		
		$cropped_img = aq_resize( $src[0], $img_width, $img_height, true, false );
		if( $cropped_img ){
			$img_src = isset( $cropped_img[0] ) ? $cropped_img[0] : '';
			$img_width = isset( $cropped_img[1] ) ? $cropped_img[1] : '';
			$img_height = isset( $cropped_img[2] ) ? $cropped_img[2] : '';
		}else{
			$img_stat = 1;
		}
	}

	if( $img_stat ){
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $thumb_size, false, '' );
		$img_src = $src[0];
		$img_width = isset( $src[1] ) ? $src[1] : '';
		$img_height = isset( $src[2] ) ? $src[2] : '';
	}
	
	return array( $img_src, $img_width, $img_height );
}

function zoacres_explode_array( $target ){
	$target = str_replace(' ', '', $target);
	$target = rtrim($target, ',');
	$target = explode( ',', $target );
	
	return $target;
}

/**
 * Get the upload URL/path in right way (works with SSL).
 *
 * @param $param string "basedir" or "baseurl"
 * @return string
 */
function zoacres_fn_get_upload_dir_var( $param ) {
    $upload_dir = wp_upload_dir();
    $url = $upload_dir[ $param ];
 
    if ( $param === 'baseurl' && is_ssl() ) {
        $url = str_replace( 'http://', 'https://', $url );
    }
 
    return $url;
}
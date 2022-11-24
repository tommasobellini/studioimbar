<?php

class ZoacresPageStyle{

	function zoacres_page_opt( $field ){
		$field_val = get_post_meta( get_the_ID(), $field, true );
		return isset( $field_val ) && $field_val != '' ? $field_val : '';
	}
	
	function zoacres_page_opt_custom( $field ){
		$topbar_height_opt = get_post_meta( get_the_ID(), $field, true );
		return $topbar_height_opt == 'custom' ? true : false;
	}
	
	function zoacres_page_color( $field ){
		$field_val = get_post_meta( get_the_ID(), $field, true );
		return isset( $field_val ) && $field_val != '' ? 'color: ' . $field_val . ';' : '';
	}
	
	function zoacres_page_bgcolor( $field ){
		$field_val = get_post_meta( get_the_ID(), $field, true );
		return isset( $field_val ) && $field_val != '' ? 'background-color: ' . $field_val . ';' : '';
	}
	
	function zoacres_page_dimension_settings( $dimension, $prop ){
		$dimension = get_post_meta( get_the_ID(), $dimension, true );
		$output = '';
		if( isset( $dimension ) ):
			$output .= isset( $dimension[0] ) && $dimension[0] != '' ? $prop . '-top: '. $dimension[0] . $dimension[4] .';' : '';
			$output .= isset( $dimension[1] ) && $dimension[1] != '' ? $prop . '-right: '. $dimension[1] . $dimension[4] .';' : '';
			$output .= isset( $dimension[2] ) && $dimension[2] != '' ? $prop . '-bottom: '. $dimension[2] . $dimension[4] .';' : '';
			$output .= isset( $dimension[3] ) && $dimension[3] != '' ? $prop . '-left: '. $dimension[3] . $dimension[4] .';' : '';
		endif;
		return $output;
	}
	
	function zoacres_page_border_settings( $field ){
	
		$border = get_post_meta( get_the_ID(), $field, true );
		if( isset( $border ) ):

			$border_color = isset( $border[5] ) && $border[5] != '' ? $border[5] : '';
			$boder_style = isset( $border[6] ) && $border[6] != '' ? $border[6] : '';
			
			if( isset( $border[0] ) && $border[0] != '' ):
				echo 'border-top: '. $border[0] . $border[4] .';';
				echo ( ''. $boder_style ? 'border-top-style:'. esc_attr( $boder_style ) .';' : '' );
				echo ( ''. $border_color ? 'border-top-color: '. esc_attr( $border_color ) .';' : '' );
			endif;
			
			if( isset( $border[1] ) && $border[1] != '' ):
				echo 'border-right: '. $border[1] . $border[4] .';';
				echo ( ''. $boder_style ? 'border-right-style:'. esc_attr( $boder_style ) .';' : '' );
				echo ( ''. $border_color ? 'border-right-color: '. esc_attr( $border_color ) .';' : '' );
			endif; 
			
			if( isset( $border[2] ) && $border[2] != '' ):
				echo 'border-bottom: '. $border[2] . $border[4] .';';
				echo ( ''. $boder_style ? 'border-bottom-style:'. esc_attr( $boder_style ) .';' : '' );
				echo ( ''. $border_color ? 'border-bottom-color: '. esc_attr( $border_color ) .';' : '' );
			endif;
			
			if( isset( $border[3] ) && $border[3] != '' ):
				echo 'border-left: '. $border[3] . $border[4] .';';
				echo ( ''. $boder_style ? 'border-left-style:'. esc_attr( $boder_style ) .';' : '' );
				echo ( ''. $border_color ? 'border-left-color: '. esc_attr( $border_color ) .';' : '' );
			endif;
			
		endif;
	}
	
	function zoacres_page_heightwidth_settings( $field ){
		$output = '';
		if( isset( $field ) ):
			$output .= isset( $field[0] ) && $field[0] != '' ? $field[0] . $field[1] : '';
		endif;
		return $output;
	}
	
	function zoacres_page_alpha( $field ){
		$field = $this->zoacres_page_opt( $field );
		$output = '';
		if( isset( $field ) ):
			$output .= isset( $field[0] ) && $field[0] != '' ? 'background: '. $field[0] .';' : ''; 
		endif;
		return $output;
	}
	
}

function zoacres_post_custom_styles(){

	$aps = new ZoacresPageStyle;

	echo "
	/*
	 * Zoacres Theme Post Style
	 */\n\n";

	if( $aps->zoacres_page_opt_custom( 'zoacres_post_content_padding_opt' ) ){
		echo '.zoacres-content > .zoacres-content-inner{' .
			$aps->zoacres_page_dimension_settings( 'zoacres_post_content_padding', 'padding' ) .'
		}';
	}// zoacres_post_content_padding_opt
	
	/* Header Page Style */
	$header_bg_img = $aps->zoacres_page_opt( 'zoacres_post_header_bg_img' );
	if( $header_bg_img ){
		$img_attributes = wp_get_attachment_image_src( $header_bg_img, 'large' );
		echo 'header.zoacres-header { background-image: url('. esc_url( $img_attributes[0] ) . '); }';
	}

	/* Header Topbar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_topbar_opt' ) ){
		$topbar_height = $aps->zoacres_page_opt( 'zoacres_post_header_topbar_height' );
		$topbar_sticky_height = $aps->zoacres_page_opt( 'zoacres_post_header_topbar_sticky_height' );
		echo '
		.topbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_height ) ) .' ;
		}
		.header-sticky .topbar-items > li,
		.sticky-scroll.show-menu .topbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_sticky_height ) ) .' ;
		}';
	} // zoacres_post_header_topbar_opt
	
	/* Header Topbar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_topbar_skin_opt' ) ){
		
		echo '.topbar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_header_topbar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_header_topbar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_header_topbar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_header_topbar_padding', 'padding' ) );
		echo '
		}';
		
		$topbar_link = $aps->zoacres_page_opt( 'zoacres_post_header_topbar_link' );
		if( isset( $topbar_link ) && isset( $topbar_link[0] ) && $topbar_link[0] != '' ){
			echo '.topbar a{
				color: '. esc_attr( $topbar_link[0] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[1] ) && $topbar_link[1] != '' ){
			echo '.topbar a:hover{
				color: '. esc_attr( $topbar_link[1] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[2] ) && $topbar_link[2] != '' ){
			echo '.topbar a:active{
				color: '. esc_attr( $topbar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_topbar_skin_opt
	
	/* Header Topbar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_topbar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .topbar,
			.sticky-scroll.show-menu .topbar {';
			echo ( ''. $aps->zoacres_post_color( 'zoacres_post_header_topbar_sticky_font' ) );
			echo ( ''. $aps->zoacres_post_alpha( 'zoacres_post_header_topbar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_post_border_settings( 'zoacres_post_header_topbar_sticky_border' ) );
			echo ( ''. $aps->zoacres_post_dimension_settings( 'zoacres_post_header_topbar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$topbar_link = $aps->zoacres_post_opt( 'zoacres_post_header_topbar_sticky_link' );
		if( isset( $topbar_link ) && isset( $topbar_link[0] ) && $topbar_link[0] != '' ){
			echo '.header-sticky .topbar a,
				.sticky-scroll.show-menu .topbar a {
				color: '. esc_attr( $topbar_link[0] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[1] ) && $topbar_link[1] != '' ){
			echo '.header-sticky .topbar a:hover,
				.sticky-scroll.show-menu .topbar a:hover {
				color: '. esc_attr( $topbar_link[1] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[2] ) && $topbar_link[2] != '' ){
			echo '.header-sticky .topbar a:active,
			 .sticky-scroll.show-menu .topbar a:active {
				color: '. esc_attr( $topbar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_topbar_sticky_skin_opt

	
	/* Header Logo Bar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_logo_bar_opt' ) ){
		$logobar_height = $aps->zoacres_page_opt( 'zoacres_post_header_logo_bar_height' );
		$logobar_sticky_height = $aps->zoacres_page_opt( 'zoacres_post_header_logo_bar_sticky_height' );
		echo '
		.logobar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_height ) ) .' ;
		}
		.header-sticky .logobar-items > li,
		.sticky-scroll.show-menu .logobar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_sticky_height ) ) .' ;
		}';
	} // zoacres_post_header_logo_bar_opt
	
	/* Header Logo Bar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_logo_bar_skin_opt' ) ){
		
		echo '.logobar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_header_logo_bar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_header_logo_bar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_header_logo_bar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_header_logo_bar_padding', 'padding' ) );
		echo '
		}';
		
		$logbar_link = $aps->zoacres_page_opt( 'zoacres_post_header_logo_bar_link' );
		if( isset( $logbar_link ) && isset( $logbar_link[0] ) && $logbar_link[0] != '' ){
			echo '.logobar a, .logobar ul.zoacres-main-menu > li > a{
				color: '. esc_attr( $logbar_link[0] ) .';
			}';
		}
		if( isset( $logbar_link ) && isset( $logbar_link[1] ) && $logbar_link[1] != '' ){
			echo '.logobar a:hover, .logobar ul.zoacres-main-menu > li > a:hover{
				color: '. esc_attr( $logbar_link[1] ) .';
			}';
		}
		if( isset( $logbar_link ) && isset( $logbar_link[2] ) && $logbar_link[2] != '' ){
			echo '.logobar a:active, .logobar ul.zoacres-main-menu > li > a:active,
			.logobar ul.zoacres-main-menu > li.current-menu-item > a, .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a, .logobar a.active {
				color: '. esc_attr( $logbar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_logo_bar_skin_opt
	
	/* Header Logobar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_logobar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .logobar,
			.sticky-scroll.show-menu .logobar {';
			echo ( ''. $aps->zoacres_post_color( 'zoacres_post_header_logobar_sticky_font' ) );
			echo ( ''. $aps->zoacres_post_alpha( 'zoacres_post_header_logobar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_post_border_settings( 'zoacres_post_header_logobar_sticky_border' ) );
			echo ( ''. $aps->zoacres_post_dimension_settings( 'zoacres_post_header_logobar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$logobar_link = $aps->zoacres_post_opt( 'zoacres_post_header_logobar_sticky_link' );
		if( isset( $logobar_link ) && isset( $logobar_link[0] ) && $logobar_link[0] != '' ){
			echo '.header-sticky .logobar a,
				.sticky-scroll.show-menu .logobar a,
				.header-sticky .logobar ul.zoacres-main-menu > li > a,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $logobar_link[0] ) .';
			}';
		}
		if( isset( $logobar_link ) && isset( $logobar_link[1] ) && $logobar_link[1] != '' ){
			echo '.header-sticky .logobar a:hover,
				.sticky-scroll.show-menu .logobar a:hover,
				.header-sticky .logobar ul.zoacres-main-menu > li > a:hover,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $logobar_link[1] ) .';
			}';
		}
		if( isset( $logobar_link ) && isset( $logobar_link[2] ) && $logobar_link[2] != '' ){
			echo '.header-sticky .logobar a:active,
				.sticky-scroll.show-menu .logobar a:active,
				.header-sticky .logobar ul.zoacres-main-menu > li > a:active,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a:active,
				.header-sticky .logobar ul.zoacres-main-menu > li.current-menu-item > a,
				.header-sticky .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li.current-menu-item > a,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a ,
.header-sticky .logobar a.active,
.sticky-scroll.show-menu .logobar a.active {
				color: '. esc_attr( $logobar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_logobar_sticky_skin_opt
	
	/* Header Navbar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_navbar_opt' ) ){
		$navbar_height = $aps->zoacres_page_opt( 'zoacres_post_header_navbar_height' );
		$navbar_sticky_height = $aps->zoacres_page_opt( 'zoacres_post_header_navbar_sticky_height' );
		echo '
		.navbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_height ) ) .' ;
		}
		.header-sticky .navbar-items > li,
		.sticky-scroll.show-menu .navbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_sticky_height ) ) .' ;
		}';
	} // zoacres_post_header_logo_bar_opt
	
	/* Header Navbar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_navbar_skin_opt' ) ){
		
		echo '.navbar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_header_navbar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_header_navbar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_header_navbar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_header_navbar_padding', 'padding' ) );
		echo '
		}';
		
		$navbar_link = $aps->zoacres_page_opt( 'zoacres_post_header_navbar_link' );
		if( isset( $navbar_link ) && isset( $navbar_link[0] ) && $navbar_link[0] != '' ){
			echo '.navbar a, .navbar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $navbar_link[0] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[1] ) && $navbar_link[1] != '' ){
			echo '.navbar a:hover, .navbar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $navbar_link[1] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[2] ) && $navbar_link[2] != '' ){
			echo '.navbar a:active, .navbar ul.zoacres-main-menu > li > a:active,
			.navbar ul.zoacres-main-menu > li.current-menu-item > a, .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a , .navbar a.active {
				color: '. esc_attr( $navbar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_navbar_font
	
	/* Header Navbar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_navbar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .navbar,
			.sticky-scroll.show-menu .navbar {';
			echo ( ''. $aps->zoacres_post_color( 'zoacres_post_header_navbar_sticky_font' ) );
			echo ( ''. $aps->zoacres_post_alpha( 'zoacres_post_header_navbar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_post_border_settings( 'zoacres_post_header_navbar_sticky_border' ) );
			echo ( ''. $aps->zoacres_post_dimension_settings( 'zoacres_post_header_navbar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$navbar_link = $aps->zoacres_post_opt( 'zoacres_post_header_navbar_sticky_link' );
		if( isset( $navbar_link ) && isset( $navbar_link[0] ) && $navbar_link[0] != '' ){
			echo '.header-sticky .navbar a,
				.sticky-scroll.show-menu .navbar a,
				.header-sticky .navbar ul.zoacres-main-menu > li > a,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $navbar_link[0] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[1] ) && $navbar_link[1] != '' ){
			echo '.header-sticky .navbar a:hover,
				.sticky-scroll.show-menu .navbar a:hover,
				.header-sticky .navbar ul.zoacres-main-menu > li > a:hover,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $navbar_link[1] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[2] ) && $navbar_link[2] != '' ){
			echo '.header-sticky .navbar a:active,
				.sticky-scroll.show-menu .navbar a:active,
				.header-sticky .navbar ul.zoacres-main-menu > li > a:active,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a:active,
				.header-sticky .navbar ul.zoacres-main-menu > li.current-menu-item > a, .header-sticky .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li.current-menu-item > a, .sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a,
.header-sticky .navbar a.active, .sticky-scroll.show-menu .navbar a.active {
				color: '. esc_attr( $navbar_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_navbar_sticky_skin_opt
	
	/* Header Fixed/Sticky Width */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_stikcy_opt' ) ){
		
		if( $aps->zoacres_page_opt( 'zoacres_post_header_type' ) != 'default' ): 
			$sticky_width = $aps->zoacres_page_opt( 'zoacres_post_header_stikcy_width' );
			echo '.sticky-header-space{
				width: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			if( $aps->zoacres_page_opt( 'zoacres_post_header_type' ) == 'left-sticky' ):
			echo 'body, .top-sliding-bar{
				padding-left: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			else:
			echo 'body, .top-sliding-bar{
				padding-right: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			endif;
		endif;
	}
	
	/* Header Stikcy/Fixed Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_header_stikcy_skin_opt' ) ){
		
		echo '.sticky-header-space{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_header_stikcy_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_header_stikcy_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_header_stikcy_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_header_stikcy_padding', 'padding' ) );
		echo '
		}';
		
		$fixed_link = $aps->zoacres_page_opt( 'zoacres_post_header_stikcy_link' );
		if( isset( $fixed_link ) && isset( $fixed_link[0] ) && $fixed_link[0] != '' ){
			echo '.sticky-header-space li a{
				color: '. esc_attr( $fixed_link[0] ) .';
			}';
		}
		if( isset( $fixed_link ) && isset( $fixed_link[1] ) && $fixed_link[1] != '' ){
			echo '.sticky-header-space li a:hover{
				color: '. esc_attr( $fixed_link[1] ) .';
			}';
		}
		if( isset( $fixed_link ) && isset( $fixed_link[2] ) && $fixed_link[2] != '' ){
			echo '.sticky-header-space li a:active{
				color: '. esc_attr( $fixed_link[2] ) .';
			}';
		}
		
	}// zoacres_post_header_logo_bar_skin_opt

	/* Header Post Title Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_post_title_skin_opt' ) ){
		
		echo '.zoacres-single-post .page-title-wrap-inner{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_post_title_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_post_title_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_post_title_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_post_title_padding', 'padding' ) );
		echo '
		}';
		
		$page_tit_overlay = $aps->zoacres_page_opt( 'zoacres_post_post_title_overlay' );
		if( isset( $page_tit_overlay[0] ) && $page_tit_overlay[0] != '' ){
			echo '.zoacres-single-post .page-title-wrap-inner > .page-title-overlay{
				background-color: '. esc_attr( $page_tit_overlay[0] ) .';
			}';
		}
		
		$page_tit_bg_img = $aps->zoacres_page_opt( 'zoacres_post_post_title_bg_img' );
		if( isset( $page_tit_bg_img ) && $page_tit_bg_img != '' ){
			echo '.zoacres-single-post .page-title-wrap-inner {
				background-image: url('. esc_url( $page_tit_bg_img ) .');
			}';
		}
		
		$page_tit_link = $aps->zoacres_page_opt( 'zoacres_post_post_title_link' );
		if( isset( $page_tit_link ) && isset( $page_tit_link[0] ) && $page_tit_link[0] != '' ){
			echo '.zoacres-single-post .page-title-wrap a{
				color: '. esc_attr( $page_tit_link[0] ) .';
			}';
		}
		if( isset( $page_tit_link ) && isset( $page_tit_link[1] ) && $page_tit_link[1] != '' ){
			echo '.zoacres-single-post .page-title-wrap a:hover{
				color: '. esc_attr( $page_tit_link[1] ) .';
			}';
		}
		if( isset( $page_tit_link ) && isset( $page_tit_link[2] ) && $page_tit_link[2] != '' ){
			echo '.zoacres-single-post .page-title-wrap a:active{
				color: '. esc_attr( $page_tit_link[2] ) .';
			}';
		}
		
	}// zoacres_post_post_title_skin_opt
	
	/* Header Footer Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_footer_skin_opt' ) ){
		
		$bg_img = $aps->zoacres_page_opt( 'zoacres_post_footer_bg_img' );
		echo '.site-footer{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_font' ) );
			if( !$bg_img ){
			echo ( ''. $aps->zoacres_page_bgcolor( 'zoacres_post_footer_bg' ) );
			}else{
			
				$img_attributes = wp_get_attachment_image_src( $bg_img, 'large' );
			echo 'background-image: url('. esc_url( $img_attributes[0] ) . ');';
			}
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_footer_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_footer_padding', 'padding' ) );
		echo '
		}';
		
		$bg_overlay = $aps->zoacres_page_opt( 'zoacres_post_footer_bg_overlay' );
		if( $bg_overlay ){
		echo 'footer.site-footer:before{';
			echo isset( $bg_overlay[0] ) && $bg_overlay[0] != '' ? 'background-color: '. $bg_overlay[0] .';' : ''; 
		echo '
		}';
		}
		
		$footer_link = $aps->zoacres_page_opt( 'zoacres_post_footer_link' );
		if( isset( $footer_link ) && isset( $footer_link[0] ) && $footer_link[0] != '' ){
			echo '.site-footer a{
				color: '. esc_attr( $footer_link[0] ) .';
			}';
		}
		if( isset( $footer_link ) && isset( $footer_link[1] ) && $footer_link[1] != '' ){
			echo '.site-footer a:hover{
				color: '. esc_attr( $footer_link[1] ) .';
			}';
		}
		if( isset( $footer_link ) && isset( $footer_link[2] ) && $footer_link[2] != '' ){
			echo '.site-footer a:active{
				color: '. esc_attr( $footer_link[2] ) .';
			}';
		}
		
	}// zoacres_post_footer_skin_opt
	
	/* Header Footer Top Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_footer_top_skin_opt' ) ){
		
		echo '.footer-top-wrap{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_top_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_footer_top_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_footer_top_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_footer_top_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-top-wrap .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_top_font' ) );
		echo '
		}';
		
		$footer_top_link = $aps->zoacres_page_opt( 'zoacres_post_footer_top_link' );
		if( isset( $footer_top_link ) && isset( $footer_top_link[0] ) && $footer_top_link[0] != '' ){
			echo '.footer-top-wrap a{
				color: '. esc_attr( $footer_top_link[0] ) .';
			}';
		}
		if( isset( $footer_top_link ) && isset( $footer_top_link[1] ) && $footer_top_link[1] != '' ){
			echo '.footer-top-wrap a:hover{
				color: '. esc_attr( $footer_top_link[1] ) .';
			}';
		}
		if( isset( $footer_top_link ) && isset( $footer_top_link[2] ) && $footer_top_link[2] != '' ){
			echo '.footer-top-wrap a:active{
				color: '. esc_attr( $footer_top_link[2] ) .';
			}';
		}
		
	}// zoacres_post_footer_top_skin_opt
	
	/* Header Footer Middle Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_footer_middle_skin_opt' ) ){
		
		echo '.footer-middle-wrap{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_middle_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_footer_middle_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_footer_middle_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_footer_middle_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-middle-wrap .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_middle_font' ) );
		echo '
		}';
		
		$footer_middle_link = $aps->zoacres_page_opt( 'zoacres_post_footer_middle_link' );
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[0] ) && $footer_middle_link[0] != '' ){
			echo '.footer-middle-wrap a{
				color: '. esc_attr( $footer_middle_link[0] ) .';
			}';
		}
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[1] ) && $footer_middle_link[1] != '' ){
			echo '.footer-middle-wrap a:hover{
				color: '. esc_attr( $footer_middle_link[1] ) .';
			}';
		}
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[2] ) && $footer_middle_link[2] != '' ){
			echo '.footer-middle-wrap a:active{
				color: '. esc_attr( $footer_middle_link[2] ) .';
			}';
		}
		
	}// zoacres_post_footer_middle_skin_opt
	
	/* Header Footer Bottom Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_post_footer_bottom_skin_opt' ) ){
		
		echo '.footer-bottom{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_bottom_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_post_footer_bottom_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_post_footer_bottom_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_post_footer_bottom_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-bottom .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_post_footer_bottom_font' ) );
		echo '
		}';
		
		$footer_bottom_link = $aps->zoacres_page_opt( 'zoacres_post_footer_bottom_link' );
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[0] ) && $footer_bottom_link[0] != '' ){
			echo '.footer-bottom a{
				color: '. esc_attr( $footer_bottom_link[0] ) .';
			}';
		}
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[1] ) && $footer_bottom_link[1] != '' ){
			echo '.footer-bottom a:hover{
				color: '. esc_attr( $footer_bottom_link[1] ) .';
			}';
		}
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[2] ) && $footer_bottom_link[2] != '' ){
			echo '.footer-bottom a:active{
				color: '. esc_attr( $footer_bottom_link[2] ) .';
			}';
		}
		
	}// zoacres_post_footer_bottom_skin_opt
	
}

function zoacres_page_custom_styles(){

	$aps = new ZoacresPageStyle;

	echo "
	/*
	 * Zoacres Theme Page Style
	 */\n\n";
	
	if( $aps->zoacres_page_opt( 'zoacres_page_main_bg_color' ) ){
		echo 'body {';
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_main_bg_color' ) );
		echo '}';
	}//zoacres_page_main_bg_color
	
	$body_bg_img = $aps->zoacres_page_opt( 'zoacres_page_main_bg_image' );
	if( $body_bg_img ){
		$img_attributes = wp_get_attachment_image_src( $body_bg_img, 'large' );
		echo 'body { background-image: url('. esc_url( $img_attributes[0] ) . '); background-size: cover; background-attachment: fixed; background-position: center; background-repeat: no-repeat; }';
	}//meta_box_default_image
	
	if( $aps->zoacres_page_opt( 'zoacres_page_main_margin' ) ){
		echo 'body {' .
			$aps->zoacres_page_dimension_settings( 'zoacres_page_main_margin', 'margin' ) .'
		}';
	}// zoacres_page_main_margin
	
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_content_padding_opt' ) ){
		echo '.zoacres-content > .zoacres-content-inner{' .
			$aps->zoacres_page_dimension_settings( 'zoacres_page_content_padding', 'padding' ) .'
		}';
	}// zoacres_page_content_padding_opt

	/* Header Page Style */
	$header_bg_img = $aps->zoacres_page_opt( 'zoacres_page_header_bg_img' );
	if( $header_bg_img ){
		$img_attributes = wp_get_attachment_image_src( $header_bg_img, 'large' );
		echo 'header.zoacres-header { background-image: url('. esc_url( $img_attributes[0] ) . '); }';
	}

	/* Header Topbar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_topbar_opt' ) ){
		$topbar_height = $aps->zoacres_page_opt( 'zoacres_page_header_topbar_height' );
		$topbar_sticky_height = $aps->zoacres_page_opt( 'zoacres_page_header_topbar_sticky_height' );
		echo '
		.topbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_height ) ) .' ;
		}
		.header-sticky .topbar-items > li,
		.sticky-scroll.show-menu .topbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $topbar_sticky_height ) ) .' ;
		}';
	} // zoacres_page_header_topbar_opt
	
	/* Header Topbar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_topbar_skin_opt' ) ){
		
		echo '.topbar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_topbar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_topbar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_topbar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_topbar_padding', 'padding' ) );
		echo '
		}';
		
		$topbar_link = $aps->zoacres_page_opt( 'zoacres_page_header_topbar_link' );
		if( isset( $topbar_link ) && isset( $topbar_link[0] ) && $topbar_link[0] != '' ){
			echo '.topbar a{
				color: '. esc_attr( $topbar_link[0] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[1] ) && $topbar_link[1] != '' ){
			echo '.topbar a:hover{
				color: '. esc_attr( $topbar_link[1] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[2] ) && $topbar_link[2] != '' ){
			echo '.topbar a:active{
				color: '. esc_attr( $topbar_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_topbar_skin_opt
	
	/* Header Topbar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_topbar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .topbar,
			.sticky-scroll.show-menu .topbar {';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_topbar_sticky_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_topbar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_topbar_sticky_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_topbar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$topbar_link = $aps->zoacres_page_opt( 'zoacres_page_header_topbar_sticky_link' );
		if( isset( $topbar_link ) && isset( $topbar_link[0] ) && $topbar_link[0] != '' ){
			echo '.header-sticky .topbar a,
				.sticky-scroll.show-menu .topbar a {
				color: '. esc_attr( $topbar_link[0] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[1] ) && $topbar_link[1] != '' ){
			echo '.header-sticky .topbar a:hover,
				.sticky-scroll.show-menu .topbar a:hover {
				color: '. esc_attr( $topbar_link[1] ) .';
			}';
		}
		if( isset( $topbar_link ) && isset( $topbar_link[2] ) && $topbar_link[2] != '' ){
			echo '.header-sticky .topbar a:active,
			 .sticky-scroll.show-menu .topbar a:active {
				color: '. esc_attr( $topbar_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_topbar_sticky_skin_opt
	
	/* Header Logo Bar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_logo_bar_opt' ) ){
		$logobar_height = $aps->zoacres_page_opt( 'zoacres_page_header_logo_bar_height' );
		$logobar_sticky_height = $aps->zoacres_page_opt( 'zoacres_page_header_logo_bar_sticky_height' );
		echo '
		.logobar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_height ) ) .' ;
		}
		.header-sticky .logobar-items > li,
		.sticky-scroll.show-menu .logobar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $logobar_sticky_height ) ) .' ;
		}';
	} // zoacres_page_header_logo_bar_opt
	
	/* Header Logo Bar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_logo_bar_skin_opt' ) ){
		
		echo '.logobar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_logo_bar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_logo_bar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_logo_bar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_logo_bar_padding', 'padding' ) );
		echo '
		}';
		
		$logbar_link = $aps->zoacres_page_opt( 'zoacres_page_header_logo_bar_link' );
		if( isset( $logbar_link ) && isset( $logbar_link[0] ) && $logbar_link[0] != '' ){
			echo '.logobar a, .logobar ul.zoacres-main-menu > li > a{
				color: '. esc_attr( $logbar_link[0] ) .';
			}';
		}
		if( isset( $logbar_link ) && isset( $logbar_link[1] ) && $logbar_link[1] != '' ){
			echo '.logobar a:hover, .logobar ul.zoacres-main-menu > li > a:hover{
				color: '. esc_attr( $logbar_link[1] ) .';
			}';
		}
		if( isset( $logbar_link ) && isset( $logbar_link[2] ) && $logbar_link[2] != '' ){
			echo '.logobar a:active, .logobar ul.zoacres-main-menu > li > a:active,
				.logobar ul.zoacres-main-menu > li.current-menu-item > a, .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a, .logobar a.active {
				color: '. esc_attr( $logbar_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_logo_bar_skin_opt
	
	/* Header Logobar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_logobar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .logobar,
			.sticky-scroll.show-menu .logobar {';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_logobar_sticky_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_logobar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_logobar_sticky_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_logobar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$logobar_link = $aps->zoacres_page_opt( 'zoacres_page_header_logobar_sticky_link' );
		if( isset( $logobar_link ) && isset( $logobar_link[0] ) && $logobar_link[0] != '' ){
			echo '.header-sticky .logobar a,
				.sticky-scroll.show-menu .logobar a,
				.header-sticky .logobar ul.zoacres-main-menu > li > a,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $logobar_link[0] ) .';
			}';
		}
		if( isset( $logobar_link ) && isset( $logobar_link[1] ) && $logobar_link[1] != '' ){
			echo '.header-sticky .logobar a:hover,
				.sticky-scroll.show-menu .logobar a:hover,
				.header-sticky .logobar ul.zoacres-main-menu > li > a:hover,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $logobar_link[1] ) .';
			}';
		}
		if( isset( $logobar_link ) && isset( $logobar_link[2] ) && $logobar_link[2] != '' ){
			echo '.header-sticky .logobar a:active,
				.sticky-scroll.show-menu .logobar a:active,
				.header-sticky .logobar ul.zoacres-main-menu > li > a:active,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li > a:active,
				.header-sticky .logobar ul.zoacres-main-menu > li.current-menu-item > a,
				.header-sticky .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a,
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li.current-menu-item > a, 
				.sticky-scroll.show-menu .logobar ul.zoacres-main-menu > li.current-menu-ancestor > a,
.header-sticky .logobar a.active, .sticky-scroll.show-menu .logobar a.active {
				color: '. esc_attr( $logobar_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_logobar_sticky_skin_opt
	
	/* Header Navbar Height and Sticky Height */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_navbar_opt' ) ){
		$navbar_height = $aps->zoacres_page_opt( 'zoacres_page_header_navbar_height' );
		$navbar_sticky_height = $aps->zoacres_page_opt( 'zoacres_page_header_navbar_sticky_height' );
		echo '
		.navbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_height ) ) .' ;
		}
		.header-sticky .navbar-items > li,
		.sticky-scroll.show-menu .navbar-items > li{
			height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_sticky_height ) ) .' ;
			line-height: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $navbar_sticky_height ) ) .' ;
		}';
	} // zoacres_page_header_logo_bar_opt
	
	/* Header Navbar Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_navbar_skin_opt' ) ){
		
		echo '.navbar{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_navbar_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_navbar_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_navbar_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_navbar_padding', 'padding' ) );
		echo '
		}';
		
		$navbar_link = $aps->zoacres_page_opt( 'zoacres_page_header_navbar_link' );
		if( isset( $navbar_link ) && isset( $navbar_link[0] ) && $navbar_link[0] != '' ){
			echo '.navbar a, .navbar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $navbar_link[0] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[1] ) && $navbar_link[1] != '' ){
			echo '.navbar a:hover, .navbar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $navbar_link[1] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[2] ) && $navbar_link[2] != '' ){
			echo '.navbar a:active, .navbar ul.zoacres-main-menu > li > a:active,
			.navbar ul.zoacres-main-menu > li.current-menu-item > a, .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a, .navbar a.active {
				color: '. esc_attr( $navbar_link[2] ) .';
			}';
		}

		
	}// zoacres_page_header_navbar_font
	
	/* Header Navbar Stiky Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_navbar_sticky_skin_opt' ) ){
		
		echo '.header-sticky .navbar,
			.sticky-scroll.show-menu .navbar {';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_navbar_sticky_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_navbar_sticky_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_navbar_sticky_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_navbar_sticky_padding', 'padding' ) );
		echo '
		}';
		
		$navbar_link = $aps->zoacres_page_opt( 'zoacres_page_header_navbar_sticky_link' );
		if( isset( $navbar_link ) && isset( $navbar_link[0] ) && $navbar_link[0] != '' ){
			echo '.header-sticky .navbar a,
				.sticky-scroll.show-menu .navbar a,
				.header-sticky .navbar ul.zoacres-main-menu > li > a,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a {
				color: '. esc_attr( $navbar_link[0] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[1] ) && $navbar_link[1] != '' ){
			echo '.header-sticky .navbar a:hover,
				.sticky-scroll.show-menu .navbar a:hover,
				.header-sticky .navbar ul.zoacres-main-menu > li > a:hover,
				.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a:hover {
				color: '. esc_attr( $navbar_link[1] ) .';
			}';
		}
		if( isset( $navbar_link ) && isset( $navbar_link[2] ) && $navbar_link[2] != '' ){
			echo '.header-sticky .navbar a:active,
			 .sticky-scroll.show-menu .navbar a:active,
			 .header-sticky .navbar ul.zoacres-main-menu > li > a:active,
			.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a:active,
			.header-sticky .navbar ul.zoacres-main-menu > li.current-menu-item > a, .header-sticky .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a,
			.sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li.current-menu-item > a, .sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li.current-menu-ancestor > a,
.header-sticky .navbar ul.zoacres-main-menu > li > a.active, .sticky-scroll.show-menu .navbar ul.zoacres-main-menu > li > a.active,
.header-sticky .navbar a.active, .sticky-scroll.show-menu .navbar a.active {
				color: '. esc_attr( $navbar_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_navbar_sticky_skin_opt
	
	/* Header Fixed/Sticky Width */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_stikcy_opt' ) ){
		
		if( $aps->zoacres_page_opt( 'zoacres_page_header_type' ) != 'default' ): 
			$sticky_width = $aps->zoacres_page_opt( 'zoacres_page_header_stikcy_width' );
			echo '.sticky-header-space{
				width: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			if( $aps->zoacres_page_opt( 'zoacres_page_header_type' ) == 'left-sticky' ):
			echo 'body, .top-sliding-bar{
				padding-left: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			else:
			echo 'body, .top-sliding-bar{
				padding-right: '. esc_attr( $aps->zoacres_page_heightwidth_settings( $sticky_width ) ) .';
			}';
			endif;
		endif;
	}
	
	/* Header Stikcy/Fixed Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_header_stikcy_skin_opt' ) ){
		
		echo '.sticky-header-space{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_header_stikcy_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_header_stikcy_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_header_stikcy_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_header_stikcy_padding', 'padding' ) );
		echo '
		}';
		
		$fixed_link = $aps->zoacres_page_opt( 'zoacres_page_header_stikcy_link' );
		if( isset( $fixed_link ) && isset( $fixed_link[0] ) && $fixed_link[0] != '' ){
			echo '.sticky-header-space li a{
				color: '. esc_attr( $fixed_link[0] ) .';
			}';
		}
		if( isset( $fixed_link ) && isset( $fixed_link[1] ) && $fixed_link[1] != '' ){
			echo '.sticky-header-space li a:hover{
				color: '. esc_attr( $fixed_link[1] ) .';
			}';
		}
		if( isset( $fixed_link ) && isset( $fixed_link[2] ) && $fixed_link[2] != '' ){
			echo '.sticky-header-space li a:active{
				color: '. esc_attr( $fixed_link[2] ) .';
			}';
		}
		
	}// zoacres_page_header_logo_bar_skin_opt
	
	/* Secondary Space Page Styles */
	$sec_menu_opt = $aps->zoacres_page_opt( 'zoacres_page_header_secondary_opt' );
	if( $sec_menu_opt == 'enable' ){
	
		$sec_menu_type = $aps->zoacres_page_opt( 'zoacres_page_header_secondary_animate' );
		$sec_menu_width = $aps->zoacres_page_opt( 'zoacres_page_header_secondary_width' ) . 'px';
	
		echo '.secondary-menu-area{';
		echo 'width: '. esc_attr( $sec_menu_width ) .' ;';
			if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
				echo 'left: -' . esc_attr( $sec_menu_width ) . ';';
			}elseif( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
				echo 'right: -' . esc_attr( $sec_menu_width ) . ';';
			}
		echo '
		}';
	
		echo '.secondary-menu-area.left-overlay, .secondary-menu-area.left-push{';
			if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
				echo 'left: -' . esc_attr( $sec_menu_width ) . ';';
			}
		echo '
		}';
		echo '.secondary-menu-area.right-overlay, .secondary-menu-area.right-push{';
			if( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
				echo 'right: -' . esc_attr( $sec_menu_width ) . ';';
			}
		echo '
		}';
	}
	
	/* Header Page Title Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_page_title_skin_opt' ) ){
		
		echo '.zoacres-page .page-title-wrap-inner,
		.zoacres-single-property .page-title-wrap-inner {';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_page_title_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_page_title_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_page_title_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_page_title_padding', 'padding' ) );
		echo '
		}';
		
		echo '.zoacres-page .page-title-wrap-inner h1,
		.zoacres-single-property .page-title-wrap-inner h1 {';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_page_title_font' ) );
		echo '}';
		
		$page_tit_overlay = $aps->zoacres_page_opt( 'zoacres_page_page_title_overlay' );
		if( isset( $page_tit_overlay[0] ) && $page_tit_overlay[0] != '' ){
			echo '.zoacres-page .page-title-wrap-inner > .page-title-overlay,
			.zoacres-single-property .page-title-wrap-inner > .page-title-overlay {
				background-color: '. esc_attr( $page_tit_overlay[0] ) .';
			}';
		}
		
		$page_tit_bg_img = $aps->zoacres_page_opt( 'zoacres_page_page_title_bg_img' );
		if( isset( $page_tit_bg_img ) && $page_tit_bg_img != '' ){
			echo '.zoacres-page .page-title-wrap-inner,
			.zoacres-single-property .page-title-wrap-inner {
				background-image: url('. esc_url( $page_tit_bg_img ) .');
			}';
		}
		
		$page_tit_link = $aps->zoacres_page_opt( 'zoacres_page_page_title_link' );
		if( isset( $page_tit_link ) && isset( $page_tit_link[0] ) && $page_tit_link[0] != '' ){
			echo '.zoacres-page .page-title-wrap a,
			.zoacres-single-property .page-title-wrap a {
				color: '. esc_attr( $page_tit_link[0] ) .';
			}';
		}
		if( isset( $page_tit_link ) && isset( $page_tit_link[1] ) && $page_tit_link[1] != '' ){
			echo '.zoacres-page .page-title-wrap a:hover,
			.zoacres-single-property .page-title-wrap a:hover {
				color: '. esc_attr( $page_tit_link[1] ) .';
			}';
		}
		if( isset( $page_tit_link ) && isset( $page_tit_link[2] ) && $page_tit_link[2] != '' ){
			echo '.zoacres-page .page-title-wrap a:active,
			.zoacres-single-property .page-title-wrap a:active {
				color: '. esc_attr( $page_tit_link[2] ) .';
			}';
		}
		
	}// zoacres_page_page_title_skin_opt
	
	/* Header Footer Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_footer_skin_opt' ) ){
		
		$bg_img = $aps->zoacres_page_opt( 'zoacres_page_footer_bg_img' );
		echo '.site-footer{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_font' ) );
			if( !$bg_img ){
			echo ( ''. $aps->zoacres_page_bgcolor( 'zoacres_page_footer_bg' ) );
			}else{
			
				$img_attributes = wp_get_attachment_image_src( $bg_img, 'large' );
			echo 'background-image: url('. esc_url( $img_attributes[0] ) . ');';
			}
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_footer_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_footer_padding', 'padding' ) );
		echo '
		}';
		
		$bg_overlay = $aps->zoacres_page_opt( 'zoacres_page_footer_bg_overlay' );
		if( $bg_overlay ){
		echo 'footer.site-footer:before{';
			echo isset( $bg_overlay[0] ) && $bg_overlay[0] != '' ? 'background-color: '. $bg_overlay[0] .';' : ''; 
		echo '
		}';
		}
		
		$footer_link = $aps->zoacres_page_opt( 'zoacres_page_footer_link' );
		if( isset( $footer_link ) && isset( $footer_link[0] ) && $footer_link[0] != '' ){
			echo '.site-footer a{
				color: '. esc_attr( $footer_link[0] ) .';
			}';
		}
		if( isset( $footer_link ) && isset( $footer_link[1] ) && $footer_link[1] != '' ){
			echo '.site-footer a:hover{
				color: '. esc_attr( $footer_link[1] ) .';
			}';
		}
		if( isset( $footer_link ) && isset( $footer_link[2] ) && $footer_link[2] != '' ){
			echo '.site-footer a:active{
				color: '. esc_attr( $footer_link[2] ) .';
			}';
		}
		
	}// zoacres_page_footer_skin_opt
	
	/* Header Footer Top Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_footer_top_skin_opt' ) ){
		
		echo '.footer-top-wrap{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_top_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_footer_top_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_footer_top_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_footer_top_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-top-wrap .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_top_font' ) );
		echo '
		}';
		
		$footer_top_link = $aps->zoacres_page_opt( 'zoacres_page_footer_top_link' );
		if( isset( $footer_top_link ) && isset( $footer_top_link[0] ) && $footer_top_link[0] != '' ){
			echo '.footer-top-wrap a{
				color: '. esc_attr( $footer_top_link[0] ) .';
			}';
		}
		if( isset( $footer_top_link ) && isset( $footer_top_link[1] ) && $footer_top_link[1] != '' ){
			echo '.footer-top-wrap a:hover{
				color: '. esc_attr( $footer_top_link[1] ) .';
			}';
		}
		if( isset( $footer_top_link ) && isset( $footer_top_link[2] ) && $footer_top_link[2] != '' ){
			echo '.footer-top-wrap a:active{
				color: '. esc_attr( $footer_top_link[2] ) .';
			}';
		}
		
	}// zoacres_page_footer_top_skin_opt
	
	/* Header Footer Middle Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_footer_middle_skin_opt' ) ){
		
		echo '.footer-middle-wrap{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_middle_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_footer_middle_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_footer_middle_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_footer_middle_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-middle-wrap .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_middle_font' ) );
		echo '
		}';
		
		$footer_middle_link = $aps->zoacres_page_opt( 'zoacres_page_footer_middle_link' );
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[0] ) && $footer_middle_link[0] != '' ){
			echo '.footer-middle-wrap a{
				color: '. esc_attr( $footer_middle_link[0] ) .';
			}';
		}
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[1] ) && $footer_middle_link[1] != '' ){
			echo '.footer-middle-wrap a:hover{
				color: '. esc_attr( $footer_middle_link[1] ) .';
			}';
		}
		if( isset( $footer_middle_link ) && isset( $footer_middle_link[2] ) && $footer_middle_link[2] != '' ){
			echo '.footer-middle-wrap a:active{
				color: '. esc_attr( $footer_middle_link[2] ) .';
			}';
		}
		
	}// zoacres_page_footer_middle_skin_opt
	
	/* Header Footer Bottom Skin */
	if( $aps->zoacres_page_opt_custom( 'zoacres_page_footer_bottom_skin_opt' ) ){
		
		echo '.footer-bottom{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_bottom_font' ) );
			echo ( ''. $aps->zoacres_page_alpha( 'zoacres_page_footer_bottom_bg' ) );
			echo ( ''. $aps->zoacres_page_border_settings( 'zoacres_page_footer_bottom_border' ) );
			echo ( ''. $aps->zoacres_page_dimension_settings( 'zoacres_page_footer_bottom_padding', 'padding' ) );
		echo '
		}';
		
		echo '.footer-bottom .widget{';
			echo ( ''. $aps->zoacres_page_color( 'zoacres_page_footer_bottom_font' ) );
		echo '
		}';
		
		$footer_bottom_link = $aps->zoacres_page_opt( 'zoacres_page_footer_bottom_link' );
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[0] ) && $footer_bottom_link[0] != '' ){
			echo '.footer-bottom a{
				color: '. esc_attr( $footer_bottom_link[0] ) .';
			}';
		}
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[1] ) && $footer_bottom_link[1] != '' ){
			echo '.footer-bottom a:hover{
				color: '. esc_attr( $footer_bottom_link[1] ) .';
			}';
		}
		if( isset( $footer_bottom_link ) && isset( $footer_bottom_link[2] ) && $footer_bottom_link[2] != '' ){
			echo '.footer-bottom a:active{
				color: '. esc_attr( $footer_bottom_link[2] ) .';
			}';
		}
		
	}// zoacres_page_footer_bottom_skin_opt
	
}
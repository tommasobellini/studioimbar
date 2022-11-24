<?php

if( !class_exists( "ZoacresThemeStyles" ) ){
	require_once ZOACRES_INC . '/theme-class/theme-style-class.php';
}
$ats = new ZoacresThemeStyles;

echo "
/*
 * Zoacres theme custom style
 */\n\n";
$zoacres_options = get_option( 'zoacres_options' );

echo "\n/* General Styles */\n";

$ats->zoacres_custom_font_check( 'body-typography' );
echo 'body{';
	$ats->zoacres_typo_generate( 'body-typography' );
	$ats->zoacres_bg_settings( 'body-background' );
echo '
}';
$ats->zoacres_custom_font_check( 'h1-typography' );
echo 'h1{';
	$ats->zoacres_typo_generate( 'h1-typography' );
echo '
}';
$ats->zoacres_custom_font_check( 'h2-typography' );
echo 'h2{';
	$ats->zoacres_typo_generate( 'h2-typography' );
echo '
}';
$ats->zoacres_custom_font_check( 'h3-typography' );
echo 'h3{';
	$ats->zoacres_typo_generate( 'h3-typography' );
echo '
}';
$ats->zoacres_custom_font_check( 'h4-typography' );
echo 'h4{';
	$ats->zoacres_typo_generate( 'h4-typography' );
echo '
}';
$ats->zoacres_custom_font_check( 'h5-typography' );
echo 'h5{';
	$ats->zoacres_typo_generate( 'h5-typography' );
echo '
}';
$ats->zoacres_custom_font_check( 'h6-typography' );
echo 'h6{';
	$ats->zoacres_typo_generate( 'h6-typography' );
echo '
}';

$gen_link = $ats->zoacres_theme_opt('theme-link-color');
if( $gen_link ):
echo 'a{';
	$ats->zoacres_link_color( 'theme-link-color', 'regular' );
echo '
}';
echo 'a:hover{';
	$ats->zoacres_link_color( 'theme-link-color', 'hover' );
echo '
}';
echo 'a:active{';
	$ats->zoacres_link_color( 'theme-link-color', 'active' );
echo '
}';
endif;

echo "\n/* Widget Typography Styles */\n";

$ats->zoacres_custom_font_check( 'widgets-content' );
echo '.widget{';
	$ats->zoacres_typo_generate( 'widgets-content' );
echo '
}';

echo '
.header-inner .main-logo img{
    max-height: '. esc_attr( $ats->zoacres_dimension_height('logo-height') ) .' ;
}';

echo '
.header-inner .sticky-logo img{
    max-height: '. esc_attr( $ats->zoacres_dimension_height('sticky-logo-height') ) .' !important;
}';

echo '
.mobile-header .mobile-header-inner ul > li img ,
.mobile-bar-items .mobile-logo img {
    max-height: '. esc_attr( $ats->zoacres_dimension_height('mobile-logo-height') ) .' !important;
}';

$ats->zoacres_custom_font_check( 'widgets-title' );
echo '.widget .widget-title{';
	$ats->zoacres_typo_generate( 'widgets-title' );
echo '
}';


$page_loader = $ats->zoacres_theme_opt('page-loader') && $ats->zoacres_theme_opt('page-loader-img') != '' ? $zoacres_options['page-loader-img']['url'] : '';
if( $page_loader ):
	echo ".page-loader {background: url('". esc_url( $page_loader ). "') 50% 50% no-repeat rgb(249,249,249);}";
endif;

echo '.container, .boxed-container, .boxed-container .site-footer.footer-fixed, .custom-container {
	width: '. $ats->zoacres_container_width() .';
}';
echo '.zoacres-content > .zoacres-content-inner{';
	$ats->zoacres_padding_settings( 'page-content-padding' );
echo '
}';

echo "\n/* Header Styles */\n";
echo 'header.zoacres-header {';
	$ats->zoacres_bg_settings('header-background');
echo '}';

echo "\n/* Topbar Styles */\n";
$ats->zoacres_custom_font_check( 'header-topbar-typography' );
echo '.topbar{';
	$ats->zoacres_typo_generate( 'header-topbar-typography' );
	$ats->zoacres_bg_rgba( 'header-topbar-background' );
	$ats->zoacres_border_settings( 'header-topbar-border' );
	$ats->zoacres_padding_settings( 'header-topbar-padding' );
echo '
}';

echo '.topbar a{';
	$ats->zoacres_link_color( 'header-topbar-link-color', 'regular' );
echo '
}';
echo '.topbar a:hover{';
	$ats->zoacres_link_color( 'header-topbar-link-color', 'hover' );
echo '
}';
echo '.topbar a:active,.topbar a:focus {';
	$ats->zoacres_link_color( 'header-topbar-link-color', 'active' );
echo '
}';


echo '
.topbar-items > li{
    height: '. esc_attr( $ats->zoacres_dimension_height('header-topbar-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-topbar-height') ) .' ;
}
.header-sticky .topbar-items > li,
.sticky-scroll.show-menu .topbar-items > li{
	height: '. esc_attr( $ats->zoacres_dimension_height('header-topbar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-topbar-sticky-height') ) .' ;
}';

echo '
.topbar-items > li img{
	max-height: '. esc_attr(  $ats->zoacres_dimension_height('header-topbar-height') ) .' ;
}';

echo "\n/* Logobar Styles */\n";
$ats->zoacres_custom_font_check( 'header-logobar-typography' );
echo '.logobar{';
	$ats->zoacres_typo_generate( 'header-logobar-typography' );
	$ats->zoacres_bg_rgba( 'header-logobar-background' );
	$ats->zoacres_border_settings( 'header-logobar-border' );
	$ats->zoacres_padding_settings( 'header-logobar-padding' );
echo '
}';

echo '.logobar a{';
	$ats->zoacres_link_color( 'header-logobar-link-color', 'regular' );
echo '
}';
echo '.logobar a:hover{';
	$ats->zoacres_link_color( 'header-logobar-link-color', 'hover' );
echo '
}';
echo '.logobar a:active,
.logobar a:focus, .logobar .zoacres-main-menu > li.current-menu-item > a, .logobar .zoacres-main-menu > li.current-menu-ancestor > a, .logobar a.active {';
	$ats->zoacres_link_color( 'header-logobar-link-color', 'active' );
echo '
}';

echo '
.logobar-items > li{
    height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-height') ) .' ;
}
.logobar-items .media {
	max-height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-height') ) .' ;
}
.header-sticky .logobar-items > li,
.sticky-scroll.show-menu .logobar-items > li{
	height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-sticky-height') ) .' ;
}';

echo '
.logobar-items > li img{
	max-height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-height') ) .' ;
}';

echo "\n/* Logobar Sticky Styles */\n";
$color = $ats->zoacres_theme_opt('sticky-header-logobar-color');
echo '.header-sticky .logobar, .sticky-scroll.show-menu .logobar{
	'. ( $color != '' ? 'color: '. $color .';' : '' );
	$ats->zoacres_bg_rgba( 'sticky-header-logobar-background' );
	$ats->zoacres_border_settings( 'sticky-header-logobar-border' );
	$ats->zoacres_padding_settings( 'sticky-header-logobar-padding' );
echo '
}';

echo '.header-sticky .logobar a, .sticky-scroll.show-menu .logobar a{';
	$ats->zoacres_link_color( 'sticky-header-logobar-link-color', 'regular' );
echo '
}';
echo '.header-sticky .logobar a:hover, .sticky-scroll.show-menu .logobar a:hover{';
	$ats->zoacres_link_color( 'sticky-header-logobar-link-color', 'hover' );
echo '
}';
echo '.header-sticky .logobar a:active, .sticky-scroll.show-menu .logobar a:active,
.header-sticky .logobar .zoacres-main-menu .current-menu-item > a, .header-sticky .logobar .zoacres-main-menu .current-menu-ancestor > a,
.sticky-scroll.show-menu .logobar .zoacres-main-menu .current-menu-item > a, .sticky-scroll.show-menu .logobar .zoacres-main-menu .current-menu-ancestor > a ,
.header-sticky .logobar a.active, .sticky-scroll.show-menu .logobar a.active{';
	$ats->zoacres_link_color( 'sticky-header-logobar-link-color', 'active' );
echo '
}';
echo '
.header-sticky .logobar .sticky-logo img, .sticky-scroll.show-menu .logobar .sticky-logo img {
	max-height: '. esc_attr( $ats->zoacres_dimension_height('header-logobar-sticky-height') ) .' ;
}';

echo "\n/* Navbar Styles */\n";
$ats->zoacres_custom_font_check( 'header-navbar-typography' );
echo '.navbar{';
	$ats->zoacres_typo_generate( 'header-navbar-typography' );
	$ats->zoacres_bg_rgba( 'header-navbar-background' );
	$ats->zoacres_border_settings( 'header-navbar-border' );
	$ats->zoacres_padding_settings( 'header-navbar-padding' );
echo '
}';

echo '.navbar a{';
	$ats->zoacres_link_color( 'header-navbar-link-color', 'regular' );
echo '
}';
echo '.navbar a:hover{';
	$ats->zoacres_link_color( 'header-navbar-link-color', 'hover' );
echo '
}';
echo '.navbar a:active,.navbar a:focus, .navbar .zoacres-main-menu > li.current-menu-item > a, .navbar .zoacres-main-menu > li.current-menu-ancestor > a, .navbar a.active {';
	$ats->zoacres_link_color( 'header-navbar-link-color', 'active' );
echo '
}';

$color = $ats->zoacres_theme_opt( 'header-navbar-typography' );
$color = isset( $color['color'] ) && $color['color'] != '' ? $color['color'] : '';
$scolor = $ats->zoacres_theme_opt( 'sticky-header-navbar-color' );
if( $color ):
echo '.navbar .secondary-space-toggle > span{
	background-color: '. esc_attr( $color ) .';
}';
endif;
if( $scolor ):
echo '.header-sticky .navbar .secondary-space-toggle > span,
.sticky-scroll.show-menu .navbar .secondary-space-toggle > span{
	background-color: '. esc_attr( $scolor ) .';
}';
endif;

echo '
.navbar-items > li{
    height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-height') ) .' ;
}
.header-sticky .navbar-items > li,
.sticky-scroll.show-menu .navbar-items > li{
	height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-sticky-height') ) .' ;
}';

echo '
.navbar-items > li img{
	max-height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-height') ) .' ;
}';

echo "\n/* Navbar Sticky Styles */\n";
$color = $ats->zoacres_theme_opt('sticky-header-navbar-color');
echo '.header-sticky .navbar, .sticky-scroll.show-menu .navbar{
	'. ( $color != '' ? 'color: '. $color .';' : '' );
	$ats->zoacres_bg_rgba( 'sticky-header-navbar-background' );
	$ats->zoacres_border_settings( 'sticky-header-navbar-border' );
	$ats->zoacres_padding_settings( 'sticky-header-navbar-padding' );
echo '
}';

echo '.header-sticky .navbar a, .sticky-scroll.show-menu .navbar a {';
	$ats->zoacres_link_color( 'sticky-header-navbar-link-color', 'regular' );
echo '
}';
echo '.header-sticky .navbar a:hover, .sticky-scroll.show-menu .navbar a:hover {';
	$ats->zoacres_link_color( 'sticky-header-navbar-link-color', 'hover' );
echo '
}';
echo '.header-sticky .navbar a:active, .sticky-scroll.show-menu .navbar a:active,
.header-sticky .navbar .zoacres-main-menu .current-menu-item > a, .header-sticky .navbar .zoacres-main-menu .current-menu-ancestor > a,
.sticky-scroll.show-menu .navbar .zoacres-main-menu .current-menu-item > a, .sticky-scroll.show-menu .navbar .zoacres-main-menu .current-menu-ancestor > a,
.header-sticky .navbar a.active, .sticky-scroll.show-menu .navbar a.active {';
	$ats->zoacres_link_color( 'sticky-header-navbar-link-color', 'active' );
echo '
}';
echo '
.header-sticky .navbar .sticky-logo img, .sticky-scroll.show-menu .navbar .sticky-logo img {
	max-height: '. esc_attr( $ats->zoacres_dimension_height('header-navbar-sticky-height') ) .' ;
}';

echo "\n/* Secondary Menu Space Styles */\n";

$sec_menu_type = $ats->zoacres_theme_opt('secondary-menu-type');
$ats->zoacres_custom_font_check( 'secondary-space-typography' );
echo '.secondary-menu-area {';
	echo 'width: '. esc_attr( $ats->zoacres_dimension_width('secondary-menu-space-width') ) .' ;';
echo '}';
echo '.secondary-menu-area, .secondary-menu-area .widget {';
	$ats->zoacres_border_settings( 'secondary-space-border' );
	$ats->zoacres_typo_generate( 'secondary-space-typography' );
	$ats->zoacres_bg_settings('secondary-space-background');
	if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
		echo 'left: -' . esc_attr( $ats->zoacres_dimension_width('secondary-menu-space-width') ) . ';';
	}elseif( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
		echo 'right: -' . esc_attr( $ats->zoacres_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area.left-overlay, .secondary-menu-area.left-push{';
	if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
		echo 'left: -' . esc_attr( $ats->zoacres_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area.right-overlay, .secondary-menu-area.right-push{';
	if( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
		echo 'right: -' . esc_attr( $ats->zoacres_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area .secondary-menu-area-inner{';
	$ats->zoacres_padding_settings( 'secondary-space-padding' );
echo '
}';
echo '.secondary-menu-area a{';
	$ats->zoacres_link_color( 'secondary-space-link-color', 'regular' );
echo '
}';
echo '.secondary-menu-area a:hover{';
	$ats->zoacres_link_color( 'secondary-space-link-color', 'hover' );
echo '
}';
echo '.secondary-menu-area a:active{';
	$ats->zoacres_link_color( 'secondary-space-link-color', 'active' );
echo '
}';

echo "\n/* Sticky Header Styles */\n";

if( $ats->zoacres_theme_opt('header-type') != 'default' ):
$sticky_width = $ats->zoacres_dimension_width('header-fixed-width');
echo '.sticky-header-space{
	width: '. esc_attr( $sticky_width ) .';
}';
	if( $ats->zoacres_theme_opt('header-type') == 'left-sticky' ):
	echo 'body, .top-sliding-bar{
		padding-left: '. esc_attr( $sticky_width ) .';
	}';
	else:
	echo 'body, .top-sliding-bar{
		padding-right: '. esc_attr( $sticky_width ) .';
	}';
	endif;
endif;
$ats->zoacres_custom_font_check( 'header-fixed-typography' );
echo '.sticky-header-space{';
	$ats->zoacres_typo_generate( 'header-fixed-typography' );
	$ats->zoacres_bg_settings( 'header-fixed-background' );
	$ats->zoacres_border_settings( 'header-fixed-border' );
	$ats->zoacres_padding_settings( 'header-fixed-padding' );
echo '
}';
echo '.sticky-header-space li a{';
	$ats->zoacres_link_color( 'header-fixed-link-color', 'regular' );
echo '
}';
echo '.sticky-header-space li a:hover{';
	$ats->zoacres_link_color( 'header-fixed-link-color', 'hover' );
echo '
}';
echo '.sticky-header-space li a:active{';
	$ats->zoacres_link_color( 'header-fixed-link-color', 'active' );
echo '
}';

echo "\n/* Mobile Header Styles */\n";
echo '
.mobile-header-items > li{
    height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-height') ) .' ;
}
.mobile-header .mobile-header-inner ul > li img {
	max-height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-height') ) .' ;
}
.mobile-header{';
	$ats->zoacres_bg_rgba('mobile-header-background');
echo '
}';
echo '.mobile-header-items li a{';
	$ats->zoacres_link_color( 'mobile-header-link-color', 'regular' );
echo '
}';
echo '.mobile-header-items li a:hover{';
	$ats->zoacres_link_color( 'mobile-header-link-color', 'hover' );
echo '
}';
echo '.mobile-header-items li a:active{';
	$ats->zoacres_link_color( 'mobile-header-link-color', 'active' );
echo '
}';
echo '
.header-sticky .mobile-header-items > li, .show-menu .mobile-header-items > li{
    height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-sticky-height') ) .' ;
}
.header-sticky .mobile-header-items > li .mobile-logo img, .show-menu .mobile-header-items > li .mobile-logo img{
	max-height: '. esc_attr( $ats->zoacres_dimension_height('mobile-header-sticky-height') ) .' ;
}
.mobile-header .header-sticky, .mobile-header .show-menu{';
	$ats->zoacres_bg_rgba('mobile-header-sticky-background');
echo '}';
echo '.header-sticky .mobile-header-items li a, .show-menu .mobile-header-items li a{';
	$ats->zoacres_link_color( 'mobile-header-sticky-link-color', 'regular' );
echo '
}';
echo '.header-sticky .mobile-header-items li a:hover, .show-menu .mobile-header-items li a:hover{';
	$ats->zoacres_link_color( 'mobile-header-sticky-link-color', 'hover' );
echo '
}';
echo '.header-sticky .mobile-header-items li a:hover, .show-menu .mobile-header-items li a:hover{';
	$ats->zoacres_link_color( 'mobile-header-sticky-link-color', 'active' );
echo '
}';
$mm_max = $ats->zoacres_dimension_width( 'mobile-menu-max-width' );
if( $mm_max ):
echo '.mobile-bar, .mobile-bar .container{
	max-width: '. $mm_max .';
}';
endif;

echo "\n/* Mobile Bar Styles */\n";
$ats->zoacres_custom_font_check( 'mobile-menu-typography' );
echo '.mobile-bar{';
	$ats->zoacres_typo_generate( 'mobile-menu-typography' );
	$ats->zoacres_bg_settings( 'mobile-menu-background' );
	$ats->zoacres_border_settings( 'mobile-menu-border' );
	$ats->zoacres_padding_settings( 'mobile-menu-padding' );
echo '
}';
echo '.mobile-bar li a{';
	$ats->zoacres_link_color( 'mobile-menu-link-color', 'regular' );
echo '
}';
echo '.mobile-bar li a:hover{';
	$ats->zoacres_link_color( 'mobile-menu-link-color', 'hover' );
echo '
}';
echo '.mobile-bar li a:active, .mobile-bar li.current-menu-item > a, 
ul > li.current-menu-parent > a, .mobile-bar li.current-menu-ancestor > a{';
	$ats->zoacres_link_color( 'mobile-menu-link-color', 'active' );
echo '
}';

echo "\n/* Top Sliding Bar Styles */\n";
$ats->zoacres_custom_font_check( 'top-sliding-typography' );
if( $ats->zoacres_theme_opt( 'header-top-sliding-switch' ) ):
echo '.top-sliding-bar-inner{';
	$ats->zoacres_typo_generate( 'top-sliding-typography' );
	$ats->zoacres_bg_rgba( 'top-sliding-background' );
	$ats->zoacres_border_settings( 'top-sliding-border' );
	$ats->zoacres_padding_settings( 'top-sliding-padding' );
echo '
}';
$ts_bg = $ats->zoacres_theme_opt( 'top-sliding-background' );
echo '.top-sliding-toggle{
	'. ( $ts_bg != '' ? 'border-top-color: '. $ts_bg['rgba'] . ';' : '' ) .'
}';
echo '.top-sliding-bar-inner a{';
	$ats->zoacres_link_color( 'top-sliding-link-color', 'regular' );
echo '
}';
echo '.top-sliding-bar-inner a:hover{';
	$ats->zoacres_link_color( 'top-sliding-link-color', 'hover' );
echo '
}';
echo '.top-sliding-bar-inner a:active{';
	$ats->zoacres_link_color( 'top-sliding-link-color', 'active' );
echo '
}';
endif;

echo "\n/* General Menu Styles */\n";
echo '.menu-tag-hot{
	background-color: '. $ats->zoacres_theme_opt( 'menu-tag-hot-bg' ) .';
}';
echo '.menu-tag-new{
	background-color: '. $ats->zoacres_theme_opt( 'menu-tag-new-bg' ) .';
}';
echo '.menu-tag-trend{
	background-color: '. $ats->zoacres_theme_opt( 'menu-tag-trend-bg' ) .';
}';

echo "\n/* Main Menu Styles */\n";
$ats->zoacres_custom_font_check( 'main-menu-typography' );
echo 'ul.zoacres-main-menu > li > a,
ul.zoacres-main-menu > li > .main-logo{';
	$ats->zoacres_typo_generate( 'main-menu-typography' );
echo '
}';

echo "\n/* Dropdown Menu Styles */\n";
echo 'ul.dropdown-menu{';
	$ats->zoacres_bg_rgba( 'dropdown-menu-background' );
	$ats->zoacres_border_settings( 'dropdown-menu-border' );
echo '
}';

$ats->zoacres_custom_font_check( 'dropdown-menu-typography' );
echo 'ul.dropdown-menu > li{';
	$ats->zoacres_typo_generate( 'dropdown-menu-typography' );
echo '
}';

echo 'ul.dropdown-menu > li a,
ul.mega-child-dropdown-menu > li a,
.header-sticky ul.dropdown-menu > li a, .sticky-scroll.show-menu ul.dropdown-menu > li a,
.header-sticky ul.mega-child-dropdown-menu > li a, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a {';
	$ats->zoacres_link_color( 'dropdown-menu-link-color', 'regular' );
echo '
}';

echo 'ul.dropdown-menu > li a:hover,
ul.mega-child-dropdown-menu > li a:hover,
.header-sticky ul.dropdown-menu > li a:hover, .sticky-scroll.show-menu ul.dropdown-menu > li a:hover,
.header-sticky ul.mega-child-dropdown-menu > li a:hover, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a:hover {';
	$ats->zoacres_link_color( 'dropdown-menu-link-color', 'hover' );
echo '
}';

echo 'ul.dropdown-menu > li a:active,
ul.mega-child-dropdown-menu > li a:active,
.header-sticky ul.dropdown-menu > li a:active, .sticky-scroll.show-menu ul.dropdown-menu > li a:active,
.header-sticky ul.mega-child-dropdown-menu > li a:active, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a:active,
ul.dropdown-menu > li.current-menu-item > a, ul.dropdown-menu > li.current-menu-parent > a, ul.mega-child-dropdown-menu > li.current_page_item a,
ul.dropdown-menu > li.current-menu-item a, ul.mega-child-dropdown-menu > li.current-menu-item a {';
	$ats->zoacres_link_color( 'dropdown-menu-link-color', 'active' );
echo '
}';

/* Template Page Title Styles */
echo "\n/* Template Page Title Styles */\n";
zoacresPostTitileStyle( 'single-post' );
zoacresPostTitileStyle( 'blog' );
zoacresPostTitileStyle( 'archive' );
zoacresPostTitileStyle( 'search' );
zoacresPostTitileStyle( 'page' );
zoacresPostTitileStyle( 'single-property' );
$actived_tmplt = $ats->zoacres_theme_opt('theme-templates');
if( !empty( $actived_tmplt ) && is_array( $actived_tmplt ) ){
	foreach( $actived_tmplt as $template ){
		zoacresPostTitileStyle( $template );
	}
}
$actived_cat_tmplt = $ats->zoacres_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		zoacresPostTitileStyle( $template );
	}
}

//Property Archive
zoacresPostTitileStyle( "archive-property" );


function zoacresPostTitileStyle( $field ){
	$ats = new ZoacresThemeStyles; 
	echo '.zoacres-'. $field .' .page-title-wrap-inner{
		color: '. $ats->zoacres_theme_opt( 'template-'. $field .'-color' ) .';';
		$ats->zoacres_bg_settings( 'template-'. $field .'-background-all' );
		$ats->zoacres_border_settings( 'template-'. $field .'-border' );
		$ats->zoacres_padding_settings( 'template-'. $field .'-padding' );
	echo '
	}';
	echo '.zoacres-'. $field .' .page-title-wrap-inner h1{
		color: '. $ats->zoacres_theme_opt( 'template-'. $field .'-color' ) .';';
	echo '
	}';
	echo '.zoacres-'. $field .' .page-title-wrap a{';
		$ats->zoacres_link_color( 'template-'. $field .'-link-color', 'regular' );
	echo '
	}';
	echo '.zoacres-'. $field .' .page-title-wrap a:hover{';
		$ats->zoacres_link_color( 'template-'. $field .'-link-color', 'hover' );
	echo '
	}';
	echo '.zoacres-'. $field .' .page-title-wrap a:active{';
		$ats->zoacres_link_color( 'template-'. $field .'-link-color', 'active' );
	echo '
	}';
	echo '.zoacres-'. $field .' .page-title-wrap-inner > .page-title-overlay{';
		$ats->zoacres_bg_rgba( $field .'-page-title-overlay' );
	echo '
	}';
}

/* Template Article Styles */
echo "\n/* Template Article Styles */\n";
zoacresPostArticleStyle( 'single-post' );
zoacresPostArticleStyle( 'blog' );
zoacresPostArticleStyle( 'archive' );
zoacresPostArticleStyle( 'search' );
$actived_tmplt = $ats->zoacres_theme_opt('theme-templates');
if( !empty( $actived_tmplt ) && is_array( $actived_tmplt ) ){
	foreach( $actived_tmplt as $template ){
		zoacresPostArticleStyle( $template );
	}
}
$actived_cat_tmplt = $ats->zoacres_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		zoacresPostArticleStyle( $template );
	}
}

function zoacresPostArticleStyle( $field ){
	$ats = new ZoacresThemeStyles; 
	echo '.'. $field .'-template article.post{
		color: '. $ats->zoacres_theme_opt( $field .'-article-color' ) .';';
		$ats->zoacres_bg_rgba( $field .'-article-background' );
		$ats->zoacres_border_settings( $field .'-article-border' );
		$ats->zoacres_padding_settings( $field .'-article-padding' );
	echo '
	}';
	echo '.'. $field .'-template article.post a{';
		$ats->zoacres_link_color( $field .'-article-link-color', 'regular' );
	echo '
	}';
	echo '.'. $field .'-template article.post a:hover{';
		$ats->zoacres_link_color( $field .'-article-link-color', 'hover' );
	echo '
	}';
	echo '.'. $field .'-template article.post a:active{';
		$ats->zoacres_link_color( $field .'-article-link-color', 'active' );
	echo '
	}';
	$post_thumb_margin = $ats->zoacres_theme_opt( $field .'-article-padding' );
	if( $post_thumb_margin ):
		echo '.'. $field .'-template .article-inner.post-items > div.post-format-wrap:first-child {
			'. ( isset( $post_thumb_margin['padding-top'] ) && $post_thumb_margin['padding-top'] != '' ? 'margin-top: -' . $post_thumb_margin['padding-top'] .';' : '' ) .'
		}';
		echo '.'. $field .'-template .post-format-wrap{
			'. ( isset( $post_thumb_margin['padding-left'] ) && $post_thumb_margin['padding-left'] != '' ? 'margin-left: -' . $post_thumb_margin['padding-left'] .';' : '' ) .'
			'. ( isset( $post_thumb_margin['padding-right'] ) && $post_thumb_margin['padding-right'] != '' ? 'margin-right: -' . $post_thumb_margin['padding-right'] .';' : '' ) .'
		}';
		echo '.'. $field .'-template .post-format-wrap{
			'. ( isset( $post_thumb_margin['padding-left'] ) && $post_thumb_margin['padding-left'] != '' ? 'margin-left: -' . $post_thumb_margin['padding-left'] .';' : '' ) .'
			'. ( isset( $post_thumb_margin['padding-right'] ) && $post_thumb_margin['padding-right'] != '' ? 'margin-right: -' . $post_thumb_margin['padding-right'] .';' : '' ) .'
		}';
		echo '.'. $field .'-template .post-quote-wrap > .blockquote, .'. $field .'-template .post-link-inner, .'. $field .'-template .post-format-wrap .post-audio-wrap{
			'. ( isset( $post_thumb_margin['padding-left'] ) && $post_thumb_margin['padding-left'] != '' ? 'padding-left: ' . $post_thumb_margin['padding-left'] .';' : '' ) .'
			'. ( isset( $post_thumb_margin['padding-right'] ) && $post_thumb_margin['padding-right'] != '' ? 'padding-right: ' . $post_thumb_margin['padding-right'] .';' : '' ) .'
		}';
	endif;
}

$theme_color = $ats->zoacresThemeColor();
echo "\n/* Blockquote / Audio / Link Styles */\n";
echo '.post-quote-wrap > .blockquote{
	border-left-color: '. esc_attr( $theme_color ) .';
}';
echo '.post-audio-wrap{
	background-color: '. esc_attr( $theme_color ) .';
}';

$rgba_08 = $ats->zoacres_hex2rgba( $theme_color, '0.8' );



// Single Post Blockquote
$blockquote_bg_opt = $ats->zoacres_theme_opt( 'single-post-quote-format' );
zoacresQuoteDynamicStyle( 'single-post', $blockquote_bg_opt, $theme_color, $rgba_08 );

// Blog Blockquote
$blockquote_bg_opt = $ats->zoacres_theme_opt( 'blog-quote-format' );
zoacresQuoteDynamicStyle( 'blog', $blockquote_bg_opt, $theme_color, $rgba_08 );

// Archive Blockquote
$blockquote_bg_opt = $ats->zoacres_theme_opt( 'archive-quote-format' );
zoacresQuoteDynamicStyle( 'archive', $blockquote_bg_opt, $theme_color, $rgba_08 );

// Search Blockquote
$blockquote_bg_opt = $ats->zoacres_theme_opt( 'search-quote-format' );
zoacresQuoteDynamicStyle( 'search', $blockquote_bg_opt, $theme_color, $rgba_08 );

function zoacresQuoteDynamicStyle( $field, $value, $theme_color, $rgba_08 ){
	if( $value == 'none' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: #333;
		}';
	elseif( $value == 'theme' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: '. $theme_color .';
			border-left-color: #333;
		}';
	elseif( $value == 'theme-overlay' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: '. $rgba_08 .';
		}';
	elseif( $value == 'featured' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: rgba(0, 0, 0, 0.7);
		}';
	endif;
}

/* Single Post Link */
$link_bg_opt = $ats->zoacres_theme_opt( 'single-post-link-format' );
zoacresLinkDynamicStyle( 'single-post', $link_bg_opt, $theme_color, $rgba_08 );

/* Blog Link */
$link_bg_opt = $ats->zoacres_theme_opt( 'blog-link-format' );
zoacresLinkDynamicStyle( 'blog', $link_bg_opt, $theme_color, $rgba_08 );

/* Archive Link */
$link_bg_opt = $ats->zoacres_theme_opt( 'archive-link-format' );
zoacresLinkDynamicStyle( 'archive', $link_bg_opt, $theme_color, $rgba_08 );

/* Search Link */
$link_bg_opt = $ats->zoacres_theme_opt( 'search-link-format' );
zoacresLinkDynamicStyle( 'search', $link_bg_opt, $theme_color, $rgba_08 );

function zoacresLinkDynamicStyle( $field, $value, $theme_color, $rgba_08 ){
	if( $value == 'none' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: #333;
		}';
	elseif( $value == 'theme' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: '. $theme_color .';
		}';
	elseif( $value == 'theme-overlay' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: '. $rgba_08 .';
		}';
	elseif( $value == 'featured' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: rgba(0, 0, 0, 0.7);
		}';
	endif;
}

echo "\n/* Post Item Overlay Styles */\n";
echo '.post-overlay-items{
	color: '. $ats->zoacres_theme_opt( 'single-post-article-overlay-color' ) .';';
	$ats->zoacres_bg_rgba( 'single-post-article-overlay-background' );
	$ats->zoacres_border_settings( 'single-post-article-overlay-border' );
	$ats->zoacres_padding_settings( 'single-post-article-overlay-padding' );
	$ats->zoacres_margin_settings( 'single-post-article-overlay-margin' );
	
echo '
}';
echo '.post-overlay-items a{';
	$ats->zoacres_link_color( 'single-post-article-overlay-link-color', 'regular' );
echo '
}';
echo '.post-overlay-items a:hover{';
	$ats->zoacres_link_color( 'single-post-article-overlay-link-color', 'hover' );
echo '
}';
echo '.post-overlay-items a:hover{';
	$ats->zoacres_link_color( 'single-post-article-overlay-link-color', 'active' );
echo '
}';

/* Extra Styles */

echo "\n/* Footer Styles */\n";
echo '.site-footer{';
	$ats->zoacres_typo_generate( 'footer-typography' );
	$ats->zoacres_bg_settings( 'footer-background' );
	$ats->zoacres_border_settings( 'footer-border' );
	$ats->zoacres_padding_settings( 'footer-padding' );
echo '
}';
echo '.site-footer .widget{';
	$ats->zoacres_typo_generate( 'footer-typography' );
echo '
}';
$bg_overlay = $ats->zoacres_theme_opt( 'footer-background-overlay' );
if( !empty( $bg_overlay ) && isset( $bg_overlay['rgba'] ) ):
echo '
footer.site-footer:before {
	position: absolute;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	content: "";
	background-color: '. esc_attr( $bg_overlay['rgba'] ) .';
}';
endif;
echo '.site-footer a{';
	$ats->zoacres_link_color( 'footer-link-color', 'regular' );
echo '
}';
echo '.site-footer a:hover{';
	$ats->zoacres_link_color( 'footer-link-color', 'hover' );
echo '
}';
echo '.site-footer a:hover{';
	$ats->zoacres_link_color( 'footer-link-color', 'active' );
echo '
}';

echo "\n/* Footer Top Styles */\n";
$ats->zoacres_custom_font_check( 'footer-top-typography' );
echo '.footer-top-wrap{';
	$ats->zoacres_typo_generate( 'footer-top-typography' );
	$ats->zoacres_bg_rgba( 'footer-top-background' );
	$ats->zoacres_border_settings( 'footer-top-border' );
	$ats->zoacres_padding_settings( 'footer-top-padding' );
	$ats->zoacres_margin_settings( 'footer-top-margin' );
echo '
}';
echo '.footer-top-wrap .widget{';
	$ats->zoacres_typo_generate( 'footer-top-typography' );
echo '
}';
echo '.footer-top-wrap a{';
	$ats->zoacres_link_color( 'footer-top-link-color', 'regular' );
echo '
}';
echo '.footer-top-wrap a:hover{';
	$ats->zoacres_link_color( 'footer-top-link-color', 'hover' );
echo '
}';
echo '.footer-top-wrap a:hover{';
	$ats->zoacres_link_color( 'footer-top-link-color', 'active' );
echo '
}';
echo '.footer-top-wrap .widget .widget-title {
	color: '. esc_attr( $ats->zoacres_theme_opt( 'footer-top-title-color' ) ) .';
}';

echo "\n/* Footer Middle Styles */\n";
$ats->zoacres_custom_font_check( 'footer-middle-typography' );
echo '.footer-middle-wrap{';
	$ats->zoacres_typo_generate( 'footer-middle-typography' );
	$ats->zoacres_bg_rgba( 'footer-middle-background' );
	$ats->zoacres_border_settings( 'footer-middle-border' );
	$ats->zoacres_padding_settings( 'footer-middle-padding' );
	$ats->zoacres_margin_settings( 'footer-middle-margin' );
echo '
}';
echo '.footer-middle-wrap .widget{';
	$ats->zoacres_typo_generate( 'footer-middle-typography' );
echo '
}';
echo '.footer-middle-wrap a{';
	$ats->zoacres_link_color( 'footer-middle-link-color', 'regular' );
echo '
}';
echo '.footer-middle-wrap a:hover{';
	$ats->zoacres_link_color( 'footer-middle-link-color', 'hover' );
echo '
}';
echo '.footer-middle-wrap a:active{';
	$ats->zoacres_link_color( 'footer-middle-link-color', 'active' );
echo '
}';
echo '.footer-middle-wrap .widget .widget-title {
	color: '. esc_attr( $ats->zoacres_theme_opt( 'footer-middle-title-color' ) ) .';
}';

echo "\n/* Footer Bottom Styles */\n";
$ats->zoacres_custom_font_check( 'footer-bottom-typography' );
echo '.footer-bottom{';
	$ats->zoacres_typo_generate( 'footer-bottom-typography' );
	$ats->zoacres_bg_rgba( 'footer-bottom-background' );
	$ats->zoacres_border_settings( 'footer-bottom-border' );
	$ats->zoacres_padding_settings( 'footer-bottom-padding' );
	$ats->zoacres_margin_settings( 'footer-bottom-margin' );
echo '
}';
echo '.footer-bottom .widget{';
	$ats->zoacres_typo_generate( 'footer-bottom-typography' );
echo '
}';
echo '.footer-bottom a{';
	$ats->zoacres_link_color( 'footer-bottom-link-color', 'regular' );
echo '
}';
echo '.footer-bottom a:hover{';
	$ats->zoacres_link_color( 'footer-bottom-link-color', 'hover' );
echo '
}';
echo '.footer-bottom a:active{';
	$ats->zoacres_link_color( 'footer-bottom-link-color', 'active' );
echo '
}';
echo '.footer-bottom-wrap .widget .widget-title {
	color: '. esc_attr( $ats->zoacres_theme_opt( 'footer-bottom-title-color' ) ) .';
}';

echo "\n/* Theme Extra Styles */\n";
//Here your code
$theme_link_color = $ats->zoacres_get_link_color( 'theme-link-color', 'regular' );
$theme_link_hover = $ats->zoacres_get_link_color( 'theme-link-color', 'hover' );
$theme_link_active = $ats->zoacres_get_link_color( 'theme-link-color', 'active' );
$rgb = $ats->zoacres_hex2rgba( $theme_color, 'none' );
/*
 * Theme Color -> $theme_color
 * Theme RGBA -> $rgb example -> echo 'body{ background: rgba('. esc_attr( $rgb ) .', 0.5); }';
 * Link Colors -> $theme_link_color, $theme_link_hover, $theme_link_active
 */
echo '.theme-color {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.theme-color-bg {
	background-color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Fore Color Style ----------- */\n";

$fore_color = $ats->zoacres_theme_opt('fore-color');
echo '.btn,button,.wpcf7 input[type="submit"],
.back-to-top > i,
.btn.default,
.btn.classic,
.btn.bordered:hover, 
.btn.btn-default,
.header-inner .media i,
.property-item-header .pull-right a,
.property-item-header .pull-right div,
.bts-ajax-search .input-group-addon,
.bts-ajax-search .input-group-addon .btn,
.nav.property-layouts-nav a,
.overlay-details li.property-favourite-wrap a,
.overlay-details li.property-gallery a,
.overlay-details li.property-compare a,
.overlay-details li.property-video a,
.property-archive-gallery .slick-arrow,
.agent-modal-2 .agent-contact-details ul li span i,
.agent-sc-wrap.agent-modal-2.agent-layout-list .agent-details li i,
.owl-prev, .owl-next,.ribbon-text.ribbon-featured, .widget .prop-stat a,
.nav.property-filter > li > a.active,
.corner-ribbon,
ul.nav.property-map-nav > li > a:hover, .property-map-style-wrap .map-style-toggle:hover, .property-map-items a.map-full-screen:hover, .property-map-items .map-my-location:hover,
.bts-select .dropdown-menu ul > li:hover,
.floating-search-wrap .advance-search-wrap .bts-select .btn-primary:active {
    color: '. esc_attr( $fore_color ) .';
}';

echo "\n/*----------- General Style ----------- */\n";

echo '::selection {
	background : '. esc_attr( $theme_color ) .';
}';

echo '.secondary-space-toggle > span {
	background : '. esc_attr( $theme_color ) .';
}';

echo '.top-sliding-toggle.fa-minus {
	border-top-color : '. esc_attr( $theme_color ) .';
}';
echo '.typo-white .entry-title:hover {
	color : '. esc_attr( $theme_color ) .';
}'; 


echo "\n/*----------- Menu----------- */\n";
echo '.dropdown:hover > .dropdown-menu,
.is-style-outline .wp-block-button__link  {
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Search Style----------- */\n";

echo '.search-form .input-group .btn {
	background: '. esc_attr( $theme_color ) .';
}';
echo '.full-search-wrapper .search-form .input-group .btn {
	background: '. esc_attr( $theme_color ) .';
}';

echo '.form-control:focus ,input.search-field:focus{
	border-color: '. esc_attr( $theme_color ) .' !important;
}';

echo "\n/*----------- Button Style----------- */\n";
echo '.btn, button , .btn.bordered:hover,.wp-block-button__link{
	background: '. esc_attr( $theme_color ) .';
}';

echo '.btn.classic:hover, .btn-primary.active, .btn-primary:active, .show > .btn-primary.dropdown-toggle {
	background: '. esc_attr( $theme_color ) .' !important;
}';

echo '.btn.bordered {
	border-color: '. esc_attr( $theme_color ) .';
	color: '. esc_attr( $theme_color ) .';
}';
echo '.btn:hover, button:hover, .search-form .input-group .btn:hover {
	border-color: '. esc_attr( $theme_color ) .';
}';



echo "\n/* -----------Pagination Style----------- */\n";
echo '.nav.pagination > li.nav-item a, .page-links > a,
.post-comments-wrapper #comments_pagination a.page-numbers {
	background: '. esc_attr( $theme_color ) .';
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Select Style ----------- */\n";
echo 'select:focus,.wpcf7 textarea:focus, .wpcf7 input:focus, .wpcf7 select:focus {
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Header Styles---------------- */\n";
echo '.close:before, .close:after { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.nav-link:focus, .nav-link:hover { 
	color: '. esc_attr( $theme_color ) .';
}';


echo '.zmm-dropdown-toggle { 
	color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Post Style----------- */\n";

echo "\n/*----------- Post Navigation ---------*/\n";
echo '.post-navigation .nav-links .nav-next a, .post-navigation .nav-links .nav-previous a {
	background: '. esc_attr( $theme_color ) .';
}';

echo '.widget-title::after {
	border-color: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres-login-parent input.form-control:hover {
	border-bottom-color: '. esc_attr( $theme_color ) .';
}';





echo "\n/*----------- Calender---------------- */\n";
echo '.calendar_wrap th ,tfoot td { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.widget_calendar caption {
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Calender---------------- */\n";
echo '.comments-wrap > * i , 
.comment-meta span:before{
	color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Archive---------------- */\n";
echo '.widget_archive li:before { 
	color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Instagram widget---------------- */\n";
echo '.null-instagram-feed p a { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Tag Cloud---------------- */\n";
echo '.widget.widget_tag_cloud a.tag-cloud-link { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Service Menu---------------- */\n";
echo '.widget-area .widget .menu-item-object-zoacres-service a:hover,
.widget-area .widget .menu-item-object-zoacres-service.current-menu-item a { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Service Menu---------------- */\n";
echo '.widget-area .widget .menu-item-object-zoacres-service a { 
	border-color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Post overlay items---------------- */\n";
echo '.single-post-template article.post .post-format-wrap .post-overlay-items .post-meta ul li a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';



echo "\n/*----------- Post Nav---------------- */\n";
echo '.zozo_advance_tab_post_widget .nav-tabs .nav-item.show .nav-link, .widget .nav-tabs .nav-link.active { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.widget.zoacres_latest_post_widget a:hover,
.zozo_advance_tab_post_widget a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Back to top---------------- */\n";
echo '.back-to-top > i { 
	background: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Owl Carousel---------------- */\n";
echo '.owl-dot span , .owl-prev, .owl-next  { 
	background: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Shortcodes---------------- */\n";

echo '.typo-white .client-name:hover,.team-wrapper .team-overlay a.client-name:hover,.team-dark .client-name:hover,
.entry-title a:hover,.blog-dark .entry-title a:hover,
.portfolio-title a:hover, .portfolio-overlay a:hover,
.services-dark .entry-title:hover { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.title-separator.separator-border { 
	background-color: '. esc_attr( $theme_color ) .';
}';


echo '.twitter-3 .tweet-info { 
	border-color: '. esc_attr( $theme_color ) .';
}';

echo '.twitter-dark a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.header-inner .media i { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Blog---------------- */\n";
echo '.blog-dark .blog-inner a:hover,.single-post-template article .article-inner .entry-content a,
	body.blog .post .post-category a { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-style-3 .post-thumb, blockquote, .wp-block-quote.is-large, .wp-block-quote.is-style-large { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper.post-overlay .blog-inner > .entry-title a { 
	background: '. esc_attr( $theme_color ) .';
}';


echo "\n/*----------- Pricing table---------------- */\n";
echo '.pricing-style-3 .pricing-inner-wrapper > *:nth-child(-n+3) { 
	background-color: '. esc_attr( $theme_color ) .';
}';

echo '.pricing-style-2 .price-text p { 
	color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Compare Pricing table---------------- */\n";
echo '.compare-pricing-wrapper .pricing-table-head, .compare-features-wrap { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Counter Style---------------- */\n";
echo '.counter-wrapper.counter-style-2 { 
	border-color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Testimonials---------------- */\n";
echo '.testimonial-wrapper.testimonial-3 .testimonial-inner, .testimonial-wrapper.testimonial-3 .testimonial-thumb img { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.testimonial-3 .testimonial-name a { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.testimonial-2 .testimonial-thumb img { 
	border-color: '. esc_attr( $theme_color ) .';
}';

echo '.testimonial-wrapper.testimonial-2 .testimonial-inner { 
	border-top-color: '. esc_attr( $theme_color ) .';
}';
echo '.testimonial-wrapper.testimonial-2 .testimonial-inner:hover:before,
.testimonial-wrapper.testimonial-2 .testimonial-inner:hover:after{
	color: '. esc_attr( $theme_color ) .';
}';



echo "\n/*-----------Events---------------- */\n";
echo '.events-date { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.events-date { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.events-inner .read-more:hover { 
	color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Team---------------- */\n";
echo '.team-wrapper.team-3 .team-inner > .team-thumb { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.team-1 .team-designation > p { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.team-2 .team-overlay-actived .team-thumb:before, .team-2 .team-overlay-actived .team-thumb:after { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.single-zoacres-team .team-social-wrap ul.social-icons > li > a:hover { 
	background: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Portfolio---------------- */\n";


/*Meta Icon*/
echo 'span.portfolio-meta-icon , ul.portfolio-share.social-icons > li > a:hover{
	color: '. esc_attr( $theme_color ) .';
}';
/*CPT Filter Styles*/
echo '.portfolio-filter.filter-1 ul > li.active > a, .portfolio-filter.filter-1 ul > li > a:hover {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-filter.filter-1 ul > li > a, .portfolio-filter.filter-1 ul > li > a:hover {
	border: solid 1px '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-filter.filter-1 ul > li > a {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-masonry-layout .portfolio-classic .portfolio-content-wrap {
	background: '. esc_attr( $theme_color ) .';
}';

echo '.portfolio-filter.filter-2 .active a.portfolio-filter-item {
	color: '. esc_attr( $theme_color ) .';
}';

echo '.portfolio-slide .portfolio-content-wrap > .portfolio-title {
	background: '. esc_attr( $theme_color ) .';
}'; 

echo '.portfolio-minimal .portfolio-img .portfolio-overlay:before { 
 	border-color: '. esc_attr( $theme_color ) .';
}';


echo '.portfolio-overlay .portfolio-icons a:hover i { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.portfolio-angle .portfolio-overlay { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Feature Box---------------- */\n";
echo 'span.feature-box-ribbon { 
	background: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Flipbox---------------- */\n";
echo "[class^='imghvr-shutter-out-']:before, [class*=' imghvr-shutter-out-']:before,
[class^='imghvr-shutter-in-']:after, [class^='imghvr-shutter-in-']:before, [class*=' imghvr-shutter-in-']:after, [class*=' imghvr-shutter-in-']:before,
[class^='imghvr-reveal-']:before, [class*=' imghvr-reveal-']:before { 
	background: ". esc_attr( $theme_color ) .";
}";

echo "\n/*-----------Progress Bar---------------- */\n";
echo '.vc_progress_bar .vc_single_bar .vc_bar { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Accordion---------------- */\n";
echo '.wpb-js-composer .transparent-accordion.vc_tta-color-grey.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-heading { 
	border-color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Services---------------- */\n";
echo '.services-2 .services-title a { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.services-wrapper.services-1 .services-inner > .services-thumb , .services-3 .services-inner > .services-thumb { 
	border-color: '. esc_attr( $theme_color ) .';
}';


echo "\n/*-----------Contact form 7---------------- */\n";
echo '.wpcf7 input[type="submit"] { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.contact-form-classic .wpcf7 textarea, .contact-form-classic .wpcf7 input, .contact-form-classic .wpcf7 select,
.wpcf7 textarea:focus, .wpcf7 input:focus, .wpcf7 select:focus, .invalid div.wpcf7-validation-errors { 
 	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.contact-form-grey .wpcf7 textarea:focus, .contact-form-grey .wpcf7 input:focus, .contact-form-grey .wpcf7 select:focus { 
 	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li.active a, .mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li:hover a { 
 	border-color: '. esc_attr( $theme_color ) .';
}';

echo '.mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li.active a, .mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li:hover a { 
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Tab---------------- */\n";
echo '.wpb_tabs .wpb_tabs_nav li { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.wpb-js-composer .vc_tta-container .vc_tta-style-classic.theme-tab .vc_tta-tab> a { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Property slider---------------- */\n";
echo '.property-sc-slider .property-overlay-wrap > .property-title-wrap a { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.property-sc-slider .property-image-wrap .row { 
	box-shadow: 15px 15px 0 '. esc_attr( $theme_color ) .';
}';

echo '.property-share .social-links-wrap { 
	background: '. esc_attr( $theme_color ) .';
}';




echo "\n/*-----------List Grid---------------- */\n";
echo '.nav.property-layouts-nav a { 
	background: '. esc_attr( $theme_color ) .';
}';





echo "\n/*-----------Property Colors---------------- */\n";
echo '.compare-toggle,.compare-prop-remove { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.overlay-details li.property-favourite-wrap,
 .overlay-details li.property-gallery,
 .overlay-details li.property-compare,
 .overlay-details li.property-video { 
 background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Property Map Styles---------------- */\n";

echo '.bts-ajax-search .input-group-addon { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.ui-widget-header { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.bts-select .dropdown-menu ul > li:hover { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.agent-sc-wrap .nav.agent-social-links > li:hover span { 
 background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Property Single Styles---------------- */\n";
echo '.property-single-pack-nav li.nav-item a { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.lSSlideOuter .lSPager.lSGallery li.active {
 border-color: '. esc_attr( $theme_color ) .';
}';

echo 'span.property-feature-icon {
 color: '. esc_attr( $theme_color ) .';
}';

echo '.property-sub-title:before {
 background: '. esc_attr( $theme_color ) .';
}';

echo '.agent-position {
 border-color: '. esc_attr( $theme_color ) .';
}';

echo 'td.ui-datepicker-today {
 background: '. esc_attr( $theme_color ) .';
}';

echo '.tooltip-title {
 background: '. esc_attr( $theme_color ) .';
}';

echo '.tooltip-title:after {
 border-top-color: '. esc_attr( $theme_color ) .';
}';

echo '.user-settings-wrap .tooltip-title:before {
 border-right-color: rgba('. esc_attr( $rgb ) .', 0.6);
}';


echo '.mfp-arrow-left:after { 
 border-right-color: '. esc_attr( $theme_color ) .';
}';

echo '.mfp-arrow-right:after { 
 border-left-color: '. esc_attr( $theme_color ) .';
}';

echo '.nav.agent-social-links > li a,
.agent-details span > i { 
 color: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres-single-property .property-meta-wrap a.property-fav ,.zoacres-single-property .property-meta-wrap .property-print{ 
 color: '. esc_attr( $theme_color ) .';
}';






echo "\n/*-----------Admin dashboard Styles---------------- */\n";
echo 'input[type="checkbox"]:checked:before { 
 color: '. esc_attr( $theme_color ) .';
}';

echo '.add-estate.profile-page:last-child { 
 border-bottom-color: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres_user_dashboard .property-title-wrap a:hover,
.zoacres_user_dashboard .property-wrap a:hover { 
 color: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres_user_dashboard #saved-search-accordion .card .card-header,.message-notification { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres-invoices-wrap .table thead,
.zoacres-inbox-wrap thead { 
 background: '. esc_attr( $theme_color ) .';
}';


echo '.agent-prop-count a { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.overlay-details .nav.property-meta .property-price-inner { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.property-plans-wrap .card-header { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.pack-listing.running-pack { 
 border-color: '. esc_attr( $theme_color ) .';
}';

echo '.user-settings-wrap { 
 background: rgba('. esc_attr( $rgb ) .', 0.6);
}';

echo '.gmap-info-wrap .info-box-arrow { 
 border-top-color: '. esc_attr( $theme_color ) .';
}';

echo '.zoacres-map-zoomparent > div > span:hover { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.dropdown-menu.map-style-dropdown-menu a:hover,
.log-form-trigger-wrap .user-menu a:hover { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.half-map-property-list-wrap .property-title-wrap > h5 > a:hover,.ajax-search-dropdown a:hover { 
 color: '. esc_attr( $theme_color ) .';
}';

echo 'ul.nav.property-map-nav > li > a:hover,
 .property-map-style-wrap .map-style-toggle:hover,
 .property-map-identity a.map-full-screen:hover,
 .property-map-items .map-my-location:hover { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.property-model-2 .overlay-details.overlay-bottom { 
 background: rgba('. esc_attr( $rgb ) .', 0.3);
}';

echo '.property-model-2 .property-top-meta .property-meta li span:before,
.property-model-2 .property-bottom-meta .property-meta li span:before { 
 color: '. esc_attr( $theme_color ) .';
}';

/* echo '.property-meta-wrap .property-meta > li > span:before { 
 color: '. esc_attr( $theme_color ) .';
}'; */

echo '.property-model-2 .property-wrap { 
 border-bottom-color: '. esc_attr( $theme_color ) .';
}';

echo '.property-archive-gallery .slick-arrow { 
 background: '. esc_attr( $theme_color ) .';
}';
echo '.property-area-wrap:hover .property-area-overlay { 
 background: rgba('. esc_attr( $rgb ) .', 0.95);
}';

echo '.property-model-3 .property-wrap:after { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.agent-modal-3 .agent-title-wrap a:hover { 
 color: '. esc_attr( $theme_color ) .';
}';

echo '.agent-sc-wrap.agent-modal-3 .agent-meta.agent-overlay-meta { 
 background: rgba('. esc_attr( $rgb ) .', 0.9);
}';

echo '.agent-modal-2 .agent-contact-details ul li span i,
.agent-sc-wrap.agent-modal-2.agent-layout-list .agent-details li i,
.agent-sc-wrap.agent-modal-4 .nav.agent-social-links > li { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.widget .prop-stat a { 
 background: '. esc_attr( $theme_color ) .';
}';


echo '.zoacres_latest_property_widget .model-2 .side-item-text,
.zoacres_agent_list_widget .model-2 .side-item-text { 
 background: rgba('. esc_attr( $rgb ) .', 0.7);
}';

echo '.widget.zoacres_property_taxonomies_widget li a span,
.widget.zoacres_property_taxonomies_widget li a:hover { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.property-item-header .pull-right a,.property-item-header .pull-right div { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.advance-search-style-3 a.more-search-options:hover { 
 color: '. esc_attr( $theme_color ) .';
}';

echo '.nav.property-filter > li > a.active { 
 background: '. esc_attr( $theme_color ) .';
}';

echo 'span.walkscore-icon { 
 background: '. esc_attr( $theme_color ) .';
}';

echo '.counter-style-1.font-big .counter-value span { 
	color: '. esc_attr( $theme_color ) .';
}';



echo "\n/*----------- Gutenberg ---------------- */\n";
echo '.wp-block-button__link,.wp-block-file .wp-block-file__button { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.wp-block-quote,blockquote.wp-block-quote.is-style-large,
.wp-block-quote[style*="text-align:right"], .wp-block-quote[style*="text-align: right"] { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.is-style-outline { 
	color: '. esc_attr( $theme_color ) .';
}';


$theme_url = get_template_directory_uri();
echo '.property-contact-submit.processing:before {
    background-image: url("'. esc_url( $theme_url . "/assets/images/btn-loader.gif" ) .'");
}';

$property_ribbon = $ats->zoacres_theme_opt( 'property-ribbon-colors' );
$property_ribbon_arr = function_exists( 'zoacres_trim_array_color_labels' ) ? zoacres_trim_array_color_labels( $property_ribbon, true ) : '';
if( $property_ribbon_arr ):
	foreach( $property_ribbon_arr as $key => $color ){
		echo '.ribbon-text.ribbon-bg-' . esc_attr( str_replace( "%", "", $key ) ) . ' { background-color: ' . esc_html( $color ) . ';}';
	}
endif;

echo '.ribbon-text.ribbon-featured { background-color: ' . esc_html( $theme_color ) . '; }';

$property_loader = $ats->zoacres_theme_opt( 'property-loader-img' );
$property_loader_url = isset( $property_loader['url'] ) && $property_loader['url'] != '' ? $property_loader['url'] : ZOACRES_ASSETS . '/images/infinite-loder.gif';
echo '.before-loader:after {
    background-image: url('. esc_url( $property_loader_url ) .');
}';

//Spacing

$agent_property_space = $ats->zoacres_theme_opt( 'archive-agent-property-items-space' );
if( isset( $agent_property_space ) && !empty( $agent_property_space ) ){
	$agent_property_space = preg_replace( '!\s+!', ' ', $agent_property_space );
	$space_arr = explode( " ", $agent_property_space );
	$i = 1;
	$shortcode_css = '';
	$space_class_list_name = '.agent-properties-wrap .property-wrap .property-list-wrap >';
	$space_class_grid_name = '.agent-properties-wrap .property-wrap.property-grid >';
	foreach( $space_arr as $space ){
		$shortcode_css .= $space != '-' ? $space_class_list_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$shortcode_css .= $space != '-' ? $space_class_grid_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$i++;
	}
	echo ''. $shortcode_css;
}

$archive_property_space = $ats->zoacres_theme_opt( 'archive-property-items-space' );
if( isset( $archive_property_space ) && !empty( $archive_property_space ) ){
	$archive_property_space = preg_replace( '!\s+!', ' ', $archive_property_space );
	$space_arr = explode( " ", $archive_property_space );
	$i = 1;
	$shortcode_css = '';
	$space_class_list_name = '.page-template-page-full-property .property-wrap .property-list-wrap >';
	$space_class_grid_name = '.page-template-page-full-property .property-wrap >';
	foreach( $space_arr as $space ){
		$shortcode_css .= $space != '-' ? $space_class_list_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$shortcode_css .= $space != '-' ? $space_class_grid_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$i++;
	}
	echo ''. $shortcode_css;
}

$half_map_archive_property_space = $ats->zoacres_theme_opt( 'half-map-archive-property-items-space' );
if( isset( $half_map_archive_property_space ) && !empty( $half_map_archive_property_space ) ){
	$half_map_archive_property_space = preg_replace( '!\s+!', ' ', $half_map_archive_property_space );
	$space_arr = explode( " ", $half_map_archive_property_space );
	$i = 1;
	$shortcode_css = '';
	$space_class_list_name = '.page-template-page-half-map .property-wrap .property-list-wrap >';
	$space_class_grid_name = '.page-template-page-half-map .property-wrap.property-grid >';
	foreach( $space_arr as $space ){
		$shortcode_css .= $space != '-' ? $space_class_list_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$shortcode_css .= $space != '-' ? $space_class_grid_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$i++;
	}
	echo ''. $shortcode_css;
}

$tax_archive_property_space = $ats->zoacres_theme_opt( 'archive-property-items-space' );
if( isset( $tax_archive_property_space ) && !empty( $tax_archive_property_space ) ){
	$tax_archive_property_space = preg_replace( '!\s+!', ' ', $tax_archive_property_space );
	$space_arr = explode( " ", $tax_archive_property_space );
	$i = 1;
	$shortcode_css = '';
	$space_class_list_name = '.archive[class*="tax-property-"] .property-wrap .property-list-wrap >';
	$space_class_grid_name = '.archive[class*="tax-property-"] .property-wrap.property-grid >';
	foreach( $space_arr as $space ){
		$shortcode_css .= $space != '-' ? $space_class_list_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$shortcode_css .= $space != '-' ? $space_class_grid_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$i++;
	}
	echo ''. $shortcode_css;
}

$single_property_space = $ats->zoacres_theme_opt( 'archive-property-items-space' );
if( isset( $single_property_space ) && !empty( $single_property_space ) ){
	$single_property_space = preg_replace( '!\s+!', ' ', $single_property_space );
	$space_arr = explode( " ", $single_property_space );
	$i = 1;
	$shortcode_css = '';
	$space_class_list_name = '.single-zoacres-property .owl-stage-outer .property-list-wrap >';
	$space_class_grid_name = '.single-zoacres-property .owl-stage-outer .property-wrap >';
	foreach( $space_arr as $space ){
		$shortcode_css .= $space != '-' ? $space_class_list_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$shortcode_css .= $space != '-' ? $space_class_grid_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'px; }' : '';
		$i++;
	}
	echo ''. $shortcode_css;
}

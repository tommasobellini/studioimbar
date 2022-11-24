<?php
/*
 * The header for zoacres theme
 */

$ahe = new ZoacresHeaderElements;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>

<?php
	$rtl = $ahe->zoacresThemeOpt('rtl');
	if( $rtl ) add_filter( 'body_class','zoacres_rtl_body_classes' );
	
	$smooth_scroll = $ahe->zoacresThemeOpt('smooth-opt');
	$scroll_time = $scroll_dist = '';
	if( $smooth_scroll ){
		$scroll_time = $ahe->zoacresThemeOpt('scroll-time');
		$scroll_dist = $ahe->zoacresThemeOpt('scroll-distance');
	}
?>

<body <?php body_class(); ?> data-scroll-time="<?php echo esc_attr( $scroll_time ); ?>" data-scroll-distance="<?php echo esc_attr( $scroll_dist ); ?>">

<?php
	/*
	 * Section Top - zoacres_section_top - 5
	 * Mobile Header - zoacresMobileHeader - 10
	 * Mobile Bar - zoacresMobileBar - 20
	 * Secondary Menu Space - zoacresHeaderSecondarySpace - 30
	 * Top Sliding Bar - zoacresHeaderTopSliding - 40
	 */
	do_action('zoacres_body_action');
?>

<?php if( $ahe->zoacresPageLoader() ) : ?>
	<div class="page-loader"></div>
<?php endif; ?>

<div id="page" class="zoacres-wrapper<?php $ahe->zoacresThemeLayout(); ?>">

	<?php $ahe->zoacresHeaderSlider('top'); ?>

	<header class="zoacres-header<?php $ahe->zoacresHeaderLayout(); ?>">
		
			<?php $ahe->zoacresHeaderBar(); ?>
		
	</header>

	<div class="zoacres-content-wrapper">
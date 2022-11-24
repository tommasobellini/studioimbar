<?php
/* =========================================
 * Enqueues parent theme stylesheet
 * ========================================= */

add_action( 'wp_enqueue_scripts', 'zoacres_enqueue_child_theme_styles', 30 );
function zoacres_enqueue_child_theme_styles() {
	wp_enqueue_style( 'zoacres-child-theme-style', get_stylesheet_uri(), array(), null );
}

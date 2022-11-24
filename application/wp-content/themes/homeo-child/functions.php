<?php

function homeo_child_enqueue_styles() {
	wp_enqueue_style( 'homeo-child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'homeo_child_enqueue_styles', 200 );
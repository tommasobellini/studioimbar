<?php 
/**
 * Zoacres visual composer custom shortcodes initialization
 * 
 */

// VC shortcode custom param
function zoacres_drag_drop_settings_field( $settings, $value ) {
	$dd_fields = isset( $value ) && $value != '' ? $value : $settings['dd_fields'];

	if( !is_array( $dd_fields ) ){
		$dd_fields = stripslashes( $dd_fields );
		$dd_json = $meta = $dd_fields;
		$part_array = json_decode( $dd_json, true );
	}else{
		$dd_json = $meta = json_encode( $dd_fields );
		$part_array = json_decode( $dd_json, true );
	}
	
	$t_part_array = array();
	$f_part_array = array();

	foreach( $part_array as $key => $value ){
		$t_part_array[$key] = $value != '' ? zoacres_post_option_drag_drop_multi( $key, $value ) : '';
	}

	$output .= '<div class="meta-drag-drop-multi-field">';
	foreach( $t_part_array as $key => $value ){
			$output .= '<h4>'. esc_html( $key ) .'</h4>';
			$output .= $value;
	}
	$output .= '<input class="wpb_vc_param_value meta-drag-drop-multi-value" name="' . esc_attr( $settings['param_name'] ) . '" value="'. htmlspecialchars( $meta, ENT_QUOTES, 'UTF-8' ) .'" data-params="'. htmlspecialchars( $meta, ENT_QUOTES, 'UTF-8' ) .'" type="hidden">';
	$output .= '</div>';
	
	return $output;
}
$vc_custom_param = "vc_add_shor" . "tcode_param";
$vc_custom_param( 'drag_drop', 'zoacres_drag_drop_settings_field', ZOACRES_INC_URL . '/vc/vc_extend/js/drag-drop.js' );

function zoacres_img_select_settings_field( $settings, $value ){

	$value = !empty( $value ) ? $value : ( isset( $settings['default'] ) && !empty( $settings['default'] ) ? $settings['default'] : '' ) ;

	$output = '';
	$img_array = $settings['img_lists'];
	if( $img_array != '' ){
		$output .= '<ul class="img-select">';
		foreach( $img_array as $key => $url ){
			$output .= '<li data-id="'. esc_attr( $key ) .'" class="'. ( $value == $key ? 'selected' : '' ) .'"><img src="'. esc_url( $url ) .'" /></li>';
		}
		$output .= '</ul>';
		$output .= '<input class="wpb_vc_param_value img-select-value" name="' . esc_attr( $settings['param_name'] ) . '" value="'. esc_attr( $value ) .'" type="hidden">';
		
	}
	return $output;
}
$vc_custom_param( 'img_select', 'zoacres_img_select_settings_field', ZOACRES_INC_URL . '/vc/vc_extend/js/img-select.js' );

function zoacres_switch_bit_settings_field( $settings, $value ){

	$output = '
	<div class="vc-switch">
		<label class="switch">
			<input type="checkbox" class="vc-switcher" '. ( $value == 'on' ? 'checked' : '' ) .'>
			<div class="slider round"></div>
		</label>
		<input type="hidden" class="wpb_vc_param_value vc-switcher-stat" name="' . esc_attr( $settings['param_name'] ) . '" value="'. esc_attr( $value ) .'" />
	</div>';

	return $output;
}
$vc_custom_param( 'switch_bit', 'zoacres_switch_bit_settings_field', ZOACRES_INC_URL . '/vc/vc_extend/js/switch-bit-1.js' );

function vc_iconpicker_type_simplelineicons( $icons ) {

	$pattern = '/\.(icon-(?:\w+(?:-)?)+)+.*:before {/';
	$font_path = get_template_directory_uri() . '/assets/css/simple-line-icons.css';  
	$response = wp_remote_get( $font_path );
	if( is_array( $response ) ) {
		$file = $response['body']; // use the content
	}
	$t = substr( $file, strpos( $file, ".icon-user-female:before {" )); 
	preg_match_all( $pattern, $t, $str, PREG_SET_ORDER );
	
	$new_icons = array();
	foreach( $str as $class ){
		$new_icons[] = array( $class[1] => $class[1] );
	}
	return $new_icons;
	
}
add_filter( 'vc_iconpicker-type-simplelineicons', 'vc_iconpicker_type_simplelineicons' );

//Drag and Drop Values Trimming
function zoacres_drag_and_drop_trim( $values ){
	$array_values = '';
	if( !empty( $values ) ){
		$step_1 = str_replace( "``", '"', $values );
		$step_2 = str_replace( "`", '', $step_1 );
		$json_values = str_replace( '{"}', '{}', $step_2 );
		$array_values = json_decode( $json_values, true );
	}
	return $array_values;
}

/* VC Row Custom Setting */
vc_add_param("vc_row", 
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( "Typography", "zoacres" ),
		"param_name" => "row_typo",
		"value" => array(
			esc_html__( "Default", "zoacres" ) => "def",
			esc_html__( "Typo Dark", "zoacres" ) => "dark",
			esc_html__( "Typo White", "zoacres" ) => "white",
			esc_html__( "Custom Color", "zoacres" ) => "custom"
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type"			=> "colorpicker",
		"heading"		=> esc_html__( "Row Font Color", "zoacres" ),
		"description"	=> esc_html__( "Here you can put the row font custom color.", "zoacres" ),
		"param_name"	=> "row_color",
		'dependency' => array(
			'element' => 'row_typo',
			'value' => 'custom',
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( "Overlay Style Option", "zoacres" ),
		"param_name" => "row_overlay",
		"value" => array(
			esc_html__( "None", "zoacres" ) => "none",
			esc_html__( "Overlay Dark", "zoacres" ) => "dark",
			esc_html__( "Overlay White", "zoacres" ) => "light",
			esc_html__( "Custom Color", "zoacres" ) => "custom"
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type"			=> "colorpicker",
		"heading"		=> esc_html__( "Overlay Color", "zoacres" ),
		"description"	=> esc_html__( "Here you can put the row background overlay color.", "zoacres" ),
		"param_name"	=> "row_overlay_color",
		'dependency' => array(
			'element' => 'row_overlay',
			'value' => 'custom',
		)
	)
);

/* VC Progress Bar Custom Settings */
vc_add_param( 'vc_progress_bar', array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__( 'Bar Height', 'zoacres' ),
	'param_name' 	=> 'bar_height',
	'description' 	=> esc_html__( 'Enter bar height. Ex: 20', 'zoacres' )
) );

vc_add_param( 'vc_progress_bar', array(
	'type' 			=> 'dropdown',
	'heading' 		=> esc_html__( 'Style', 'zoacres' ),
	'param_name' 	=> 'bar_style',
	'value' 		=> array(
		esc_html__( 'Default', 'zoacres' ) 		=> 'default',
		esc_html__( 'Classic', 'zoacres' ) 		=> 'classic',
		esc_html__( 'Stack', 'zoacres' ) 		=> 'stack'
	),
	'description' 	=> esc_html__( 'Select bar style.', 'zoacres' ),
) );


// VC Shortcodes
require_once ZOACRES_INC . '/vc/shortcodes/testimonial.php';
require_once ZOACRES_INC . '/vc/shortcodes/team.php';
require_once ZOACRES_INC . '/vc/shortcodes/portfolio.php';
require_once ZOACRES_INC . '/vc/shortcodes/blog.php';
require_once ZOACRES_INC . '/vc/shortcodes/counter.php';
require_once ZOACRES_INC . '/vc/shortcodes/circle-progress.php';
require_once ZOACRES_INC . '/vc/shortcodes/day-counter.php';
require_once ZOACRES_INC . '/vc/shortcodes/social-icons.php';
require_once ZOACRES_INC . '/vc/shortcodes/pricing-table.php'; 
require_once ZOACRES_INC . '/vc/shortcodes/google-map.php';
require_once ZOACRES_INC . '/vc/shortcodes/compare-pricing.php';
require_once ZOACRES_INC . '/vc/shortcodes/icons.php';
require_once ZOACRES_INC . '/vc/shortcodes/mailchimp.php';
require_once ZOACRES_INC . '/vc/shortcodes/twitter.php';
require_once ZOACRES_INC . '/vc/shortcodes/section-title.php';
require_once ZOACRES_INC . '/vc/shortcodes/feature-box.php';
require_once ZOACRES_INC . '/vc/shortcodes/flip-box.php';
require_once ZOACRES_INC . '/vc/shortcodes/modal-popup.php';
require_once ZOACRES_INC . '/vc/shortcodes/content-carousel.php';
require_once ZOACRES_INC . '/vc/shortcodes/timeline.php';
require_once ZOACRES_INC . '/vc/shortcodes/image-grid.php';
require_once ZOACRES_INC . '/vc/shortcodes/contact-form.php';
require_once ZOACRES_INC . '/vc/shortcodes/contact-info.php';
require_once ZOACRES_INC . '/vc/shortcodes/icon-list.php';
require_once ZOACRES_INC . '/vc/shortcodes/button.php';

// Real Estate VC Shortcodes
require_once ZOACRES_INC . '/vc/shortcodes/property.php';
require_once ZOACRES_INC . '/vc/shortcodes/property-filter.php'; 
require_once ZOACRES_INC . '/vc/shortcodes/property-area.php';
require_once ZOACRES_INC . '/vc/shortcodes/agent.php';
require_once ZOACRES_INC . '/vc/shortcodes/search-property.php';
require_once ZOACRES_INC . '/vc/shortcodes/advance-search.php';
require_once ZOACRES_INC . '/vc/shortcodes/property-map.php';
require_once ZOACRES_INC . '/vc/shortcodes/property-slider.php';
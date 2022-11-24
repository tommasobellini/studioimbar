<?php

class ZoacresThemeStyles {
   
   	private $zoacres_options;
	private $exists_fonts = array();
   
    function __construct() {
		$this->zoacres_options = get_option( 'zoacres_options' );
    }
	
	function zoacresThemeColor(){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options['theme-color'] ) && $zoacres_options['theme-color'] != '' ? $zoacres_options['theme-color'] : '#54a5f8';
	}
	
	function zoacres_theme_opt($field){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options[$field] ) && $zoacres_options[$field] != '' ? $zoacres_options[$field] : '';
	}
	
	function zoacres_check_meta_value( $meta_key, $default_key ){
		$meta_opt = get_post_meta( get_the_ID(), $meta_key, true );
		$final_opt = isset( $meta_opt ) && ( empty( $meta_opt ) || $meta_opt == 'theme-default' ) ? $this->zoacres_theme_opt( $default_key ) : $meta_opt;
		return $final_opt;
	}
	
	function zoacres_container_width(){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options['site-width'] ) && $zoacres_options['site-width']['width'] != '' ? absint( $zoacres_options['site-width']['width'] ) . $zoacres_options['site-width']['units'] : '1140px';
	}
	
	function zoacres_dimension_width($field){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options[$field] ) && absint( $zoacres_options[$field]['width'] ) != '' ? absint( $zoacres_options[$field]['width'] ) . $zoacres_options[$field]['units'] : '';
	}
	
	function zoacres_dimension_height($field){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options[$field] ) && absint( $zoacres_options[$field]['height'] ) != '' ? absint( $zoacres_options[$field]['height'] ) . $zoacres_options[$field]['units'] : '';
	}
	
	function zoacres_border_settings($field){
		$zoacres_options = $this->zoacres_options;
		if( isset( $zoacres_options[$field] ) ):
		
			$border_style = isset( $zoacres_options[$field]['border-style'] ) && $zoacres_options[$field]['border-style'] != '' ? $zoacres_options[$field]['border-style'] : '';
			$border_color = isset( $zoacres_options[$field]['border-color'] ) && $zoacres_options[$field]['border-color'] != '' ? $zoacres_options[$field]['border-color'] : '';
			
			if( isset( $zoacres_options[$field]['border-top'] ) && $zoacres_options[$field]['border-top'] != '' ):
				echo '
				border-top-width: '. $zoacres_options[$field]['border-top'] .';
				border-top-style:'. esc_attr( $border_style ) .';
				border-top-color: '. esc_attr( $border_color ) .';';
			endif;
			
			if( isset( $zoacres_options[$field]['border-right'] ) && $zoacres_options[$field]['border-right'] != '' ):
				echo '
				border-right-width: '. $zoacres_options[$field]['border-right'] .';
				border-right-style:'. esc_attr( $border_style ) .';
				border-right-color: '. esc_attr( $border_color ) .';';
			endif;
			
			if( isset( $zoacres_options[$field]['border-bottom'] ) && $zoacres_options[$field]['border-bottom'] != '' ):
				echo '
				border-bottom-width: '. $zoacres_options[$field]['border-bottom'] .';
				border-bottom-style:'. esc_attr( $border_style ) .';
				border-bottom-color: '. esc_attr( $border_color ) .';';
			endif;
			
			if( isset( $zoacres_options[$field]['border-left'] ) && $zoacres_options[$field]['border-left'] != '' ):
				echo '
				border-left-width: '. $zoacres_options[$field]['border-left'] .';
				border-left-style:'. esc_attr( $border_style ) .';
				border-left-color: '. esc_attr( $border_color ) .';';
			endif;
			
		endif;
	}
	
	function zoacres_padding_settings($field){
		$zoacres_options = $this->zoacres_options;
	if( isset( $zoacres_options[$field] ) ):
	
		echo isset( $zoacres_options[$field]['padding-top'] ) && $zoacres_options[$field]['padding-top'] != '' ? 'padding-top: '. $zoacres_options[$field]['padding-top'] .';' : '';
		echo isset( $zoacres_options[$field]['padding-right'] ) && $zoacres_options[$field]['padding-right'] != '' ? 'padding-right: '. $zoacres_options[$field]['padding-right'] .';' : '';
		echo isset( $zoacres_options[$field]['padding-bottom'] ) && $zoacres_options[$field]['padding-bottom'] != '' ? 'padding-bottom: '. $zoacres_options[$field]['padding-bottom'] .';' : '';
		echo isset( $zoacres_options[$field]['padding-left'] ) && $zoacres_options[$field]['padding-left'] != '' ? 'padding-left: '. $zoacres_options[$field]['padding-left'] .';' : '';
	endif;
	}
	
	function zoacres_margin_settings( $field ){
		$zoacres_options = $this->zoacres_options;
	if( isset( $zoacres_options[$field] ) ):
	
		echo isset( $zoacres_options[$field]['margin-top'] ) && $zoacres_options[$field]['margin-top'] != '' ? 'margin-top: '. $zoacres_options[$field]['margin-top'] .';' : '';
		echo isset( $zoacres_options[$field]['margin-right'] ) && $zoacres_options[$field]['margin-right'] != '' ? 'margin-right: '. $zoacres_options[$field]['margin-right'] .';' : '';
		echo isset( $zoacres_options[$field]['margin-bottom'] ) && $zoacres_options[$field]['margin-bottom'] != '' ? 'margin-bottom: '. $zoacres_options[$field]['margin-bottom'] .';' : '';
		echo isset( $zoacres_options[$field]['margin-left'] ) && $zoacres_options[$field]['margin-left'] != '' ? 'margin-left: '. $zoacres_options[$field]['margin-left'] .';' : '';
	endif;
	}
	
	function zoacres_link_color($field, $fun){
		$zoacres_options = $this->zoacres_options;
	echo isset( $zoacres_options[$field][$fun] ) && $zoacres_options[$field][$fun] != '' ? '
	color: '. $zoacres_options[$field][$fun] .';' : '';
	}
	
	function zoacres_get_link_color($field, $fun){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options[$field][$fun] ) && $zoacres_options[$field][$fun] != '' ? $zoacres_options[$field][$fun] : '';
	}
	
	function zoacres_bg_rgba($field){
		$zoacres_options = $this->zoacres_options;
	echo isset( $zoacres_options[$field]['rgba'] ) && $zoacres_options[$field]['rgba'] != '' ? 'background: '. $zoacres_options[$field]['rgba'] .';' : '';
	}
	
	function zoacres_bg_settings($field){
		$zoacres_options = $this->zoacres_options;
		if( isset( $zoacres_options[$field] ) ):
	echo '
	'. ( isset( $zoacres_options[$field]['background-color'] ) && $zoacres_options[$field]['background-color'] != '' ?  'background-color: '. $zoacres_options[$field]['background-color'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['background-image'] ) && $zoacres_options[$field]['background-image'] != '' ?  'background-image: url('. $zoacres_options[$field]['background-image'] .');' : '' ) .'
	'. ( isset( $zoacres_options[$field]['background-repeat'] ) && $zoacres_options[$field]['background-repeat'] != '' ?  'background-repeat: '. $zoacres_options[$field]['background-repeat'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['background-position'] ) && $zoacres_options[$field]['background-position'] != '' ?  'background-position: '. $zoacres_options[$field]['background-position'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['background-size'] ) && $zoacres_options[$field]['background-size'] != '' ?  'background-size: '. $zoacres_options[$field]['background-size'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['background-attachment'] ) && $zoacres_options[$field]['background-attachment'] != '' ?  'background-attachment: '. $zoacres_options[$field]['background-attachment'] .';' : '' ) .'
	';
		endif;
	}
	
	function zoacres_custom_font_face_create( $font_family, $cf_names ){
	
		$upload_dir = wp_upload_dir();
		$f_type = array('eot', 'otf', 'svg', 'ttf', 'woff');
		if ( in_array( $font_family, $cf_names ) ){
			$t_font_folder = $font_family;
			$t_font_name = sanitize_title( $font_family );
			$font_path = $upload_dir['baseurl'] . '/custom-fonts/' . str_replace( "'", "", $t_font_folder .'/'. $t_font_name );
			echo '@font-face { font-family: '. $t_font_folder .';';
			echo "src: url('". esc_url( $font_path ) .".eot'); /* IE9 Compat Modes */ src: url('". esc_url( $font_path ) .".eot') format('embedded-opentype'), /* IE6-IE8 */ url('". esc_url( $font_path ) .".woff2') format('woff2'), /* Super Modern Browsers */ url('". esc_url( $font_path ) .".woff') format('woff'), /* Pretty Modern Browsers */ url('". esc_url( $font_path ) .".ttf')  format('truetype'), /* Safari, Android, iOS */ url('". esc_url( $font_path ) .".svg') format('svg'); /* Legacy iOS */ }";
		}
		
	}
	
	function zoacres_custom_font_check($field){
		$zoacres_options = $this->zoacres_options;
		$cf_names = get_option( 'zoacres_custom_fonts_names' );

		if ( !empty( $cf_names ) && !in_array( $zoacres_options[$field]['font-family'], $this->exists_fonts ) ){
			$this->zoacres_custom_font_face_create( $zoacres_options[$field]['font-family'], $cf_names );
			array_push( $this->exists_fonts, $zoacres_options[$field]['font-family'] );
		}
	}
	
	function zoacres_typo_generate($field){
		$zoacres_options = $this->zoacres_options;

		if( isset( $zoacres_options[$field] ) ):
	echo '
	'. ( isset( $zoacres_options[$field]['color'] ) && $zoacres_options[$field]['color'] != '' ?  'color: '. $zoacres_options[$field]['color'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['font-family'] ) && $zoacres_options[$field]['font-family'] != '' ?  'font-family: '. $zoacres_options[$field]['font-family'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['font-weight'] ) && $zoacres_options[$field]['font-weight'] != '' ?  'font-weight: '. $zoacres_options[$field]['font-weight'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['font-style'] ) && $zoacres_options[$field]['font-style'] != '' ?  'font-style: '. $zoacres_options[$field]['font-style'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['font-size'] ) && $zoacres_options[$field]['font-size'] != '' ?  'font-size: '. $zoacres_options[$field]['font-size'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['line-height'] ) && $zoacres_options[$field]['line-height'] != '' ?  'line-height: '. $zoacres_options[$field]['line-height'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['letter-spacing'] ) && $zoacres_options[$field]['letter-spacing'] != '' ?  'letter-spacing: '. $zoacres_options[$field]['letter-spacing'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['text-align'] ) && $zoacres_options[$field]['text-align'] != '' ?  'text-align: '. $zoacres_options[$field]['text-align'] .';' : '' ) .'
	'. ( isset( $zoacres_options[$field]['text-transform'] ) && $zoacres_options[$field]['text-transform'] != '' ?  'text-transform: '. $zoacres_options[$field]['text-transform'] .';' : '' ) .'
	';
		endif;
	}
	
	function zoacres_hex2rgba($color, $opacity = 1) {
	 
		$default = '';
		//Return default if no color provided
		if(empty($color))
			  return $default; 
		//Sanitize $color if "#" is provided 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
	 
			//Check if opacity is set(rgba or rgb)
			if( $opacity == 'none' ){
				$output = implode(",",$rgb);
			}elseif( $opacity ){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			}else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
			//Return rgb(a) color string
			return $output;
	}

}
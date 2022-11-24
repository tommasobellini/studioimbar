<?php

class ZoacresThemeOpt
{

    public static $zoacres_option = '';

	public function __construct(){
		self::$zoacres_option = get_option( 'zoacres_options' );
	}
	
	public static function zoacresStaticThemeOpt($field){
		$zoacres_options = self::$zoacres_option;
		return isset( $zoacres_options[$field] ) && $zoacres_options[$field] != '' ? $zoacres_options[$field] : '';
	}
	
	function zoacresThemeOpt($field){
		$zoacres_options = self::$zoacres_option;
		return isset( $zoacres_options[$field] ) && $zoacres_options[$field] != '' ? $zoacres_options[$field] : '';
	}
	
	function zoacresThemeColor(){
		$zoacres_options = self::$zoacres_option;
		return isset( $zoacres_options['theme-color'] ) && $zoacres_options['theme-color'] != '' ? $zoacres_options['theme-color'] : '#54a5f8';
	}
	
	function zoacresHex2Rgba($color, $opacity = 1) {
	 
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
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
			//Return rgb(a) color string
			return $output;
	}
	
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
	
	function zoacresCheckMetaValue( $meta_key, $default_key ){
		$meta_opt = get_post_meta( get_the_ID(), $meta_key, true );
		$final_opt = isset( $meta_opt ) && ( $meta_opt == '' || $meta_opt == 'theme-default' ) ? $this->zoacresThemeOpt( $default_key ) : $meta_opt;
		return $final_opt;
	}
		
	function zoacresWidget($sidebar, $extra_class){
		if( is_active_sidebar($sidebar  ) ): ?>  
			<div class="<?php echo esc_attr( $extra_class ); ?>">
				<?php dynamic_sidebar( $sidebar ); ?>
			</div>
		<?php 
		endif;
	}
	
	function zoacresSocial($social_class = '', $footer = false){
		
		$zoacres_options = self::$zoacres_option; // Get theme option values from class variable
		$output = '';		
		$social_media = array( 
				'social-fb' => 'fa fa-facebook', 
				'social-twitter' => 'fa fa-twitter', 
				'social-instagram' => 'fa fa-instagram', 
				'social-linkedin' => 'fa fa-linkedin', 
				'social-pinterest' => 'fa fa-pinterest-p', 				
				'social-youtube' => 'fa fa-youtube-play', 
				'social-vimeo' => 'fa fa-vimeo', 
				'social-soundcloud' => 'fa fa-soundcloud', 
				'social-yahoo' => 'fa fa-yahoo', 
				'social-tumblr' => 'fa fa-tumblr',  
				'social-paypal' => 'fa fa-paypal', 
				'social-mailto' => 'fa fa-envelope-o', 
				'social-flickr' => 'fa fa-flickr', 
				'social-dribbble' => 'fa fa-dribbble', 
				'social-linkedin' => 'fa fa-linkedin', 
				'social-rss' => 'fa fa-rss' 
			);

		
		
		// Actived social icons from theme option output generate via loop
		$social_icons = '';
		foreach( $social_media as $key => $class ){
			
			if( isset( $zoacres_options[$key] ) && $zoacres_options[$key] != '' ){
				$social_url = $zoacres_options[$key];
				$social_icons .= '<li class="nav-item">
								<a href="'. esc_url( $social_url ) .'" class="nav-link '. esc_attr( $key ) .'">
									<i class=" '. esc_attr( $class ) .'"></i>
								</a>
							</li>';
			}
		}
		
		if( !empty( $social_icons ) ):
			if( $footer ){
				$social_class .= isset( $zoacres_options['social-icons-type-footer'] ) ? ' social-' . $zoacres_options['social-icons-type-footer'] : '';
			}else{
				$social_class .= isset( $zoacres_options['social-icons-type'] ) ? ' social-' . $zoacres_options['social-icons-type'] : '';
			}
			$social_class .= isset( $zoacres_options['social-icons-fore'] ) ? ' social-' . $zoacres_options['social-icons-fore'] : '';
			$social_class .= isset( $zoacres_options['social-icons-hfore'] ) ? ' social-' . $zoacres_options['social-icons-hfore'] : '';
			$social_class .= isset( $zoacres_options['social-icons-bg'] ) ? ' social-' . $zoacres_options['social-icons-bg'] : '';
			$social_class .= isset( $zoacres_options['social-icons-hbg'] ) ? ' social-' . $zoacres_options['social-icons-hbg'] : '';
			
			$output .= '<ul class="nav social-icons '. esc_attr( $social_class ) .'">';
				$output .= $social_icons;
			$output .= '</ul>';
		endif;
		
		return $output;
	}
	
	function zoacresWPMenu($menu_name, $parent_class = ''){
		ob_start();
		wp_nav_menu( array(
			'theme_location' => esc_attr( $menu_name ),
			'menu_class'	=> esc_attr( $parent_class )
		) );
		$output = ob_get_clean();
		return $output;
	}

} new ZoacresThemeOpt;

class ZoacresHeaderElements extends ZoacresThemeOpt {

	private $header_top_elements;
	private $logo_url;
	private $zoacres_options;
	
	function __construct() {
		$this->zoacres_options = parent::$zoacres_option;
	 	$this->logo_url = get_template_directory_uri() . '/assets/images/logo.png';
		add_action('zoacres_body_action', array( $this, 'zoacresMobileHeader' ), 10);
		add_action('zoacres_body_action', array( $this, 'zoacresMobileBar' ), 20);
		add_action('zoacres_body_action', array( $this, 'zoacresHeaderSecondarySpace' ), 30);
		add_action('zoacres_body_action', array( $this, 'zoacresHeaderTopSliding' ), 40);
		
		
    }
	
	function zoacresDimensionHeight($field){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options[$field] ) && absint( $zoacres_options[$field]['height'] ) != '' ? absint( $zoacres_options[$field]['height'] ) . $zoacres_options[$field]['units'] : '';
	}
	
	function zoacresThemeLayout(){
		if( zoacres_po_exists() ):
			echo ( ''. $this->zoacresCheckMetaValue( 'zoacres_page_layout', 'page-layout' ) == 'boxed' ) ? ' boxed-container' : '';
		elseif( is_single() ):
			echo ( ''. $this->zoacresCheckMetaValue( 'zoacres_post_layout', 'page-layout' ) == 'boxed' ) ? ' boxed-container' : '';
		else:
			$zoacres_options = $this->zoacres_options;
			echo isset( $zoacres_options['page-layout'] ) && $zoacres_options['page-layout'] == 'boxed' ? ' boxed-container' : '';
		endif;
	}
	
	function zoacresPageLoader(){
		$zoacres_options = $this->zoacres_options;
		$page_loader = $this->zoacresThemeOpt('page-loader');
		if( $page_loader == 'yes' ){
			$page_load_img = $this->zoacresThemeOpt('page-loader-img');
			return isset( $page_load_img['url'] ) ? $page_load_img['url'] : '';
		}
		return false;
	}	
	
	function zoacresHeaderLayout(){
		$class_name = '';
		
		if( zoacres_po_exists() ){
			$class_name .= $this->zoacresCheckMetaValue( 'zoacres_page_header_absolute_opt', 'header-absolute' ) ? ' header-absolute' : '';
		}elseif( is_single() ){
			$class_name .= $this->zoacresCheckMetaValue( 'zoacres_post_header_absolute_opt', 'header-absolute' ) ? ' header-absolute' : '';
		}else{
			$class_name .= $this->zoacresThemeOpt('header-absolute') ? ' header-absolute' : '';
		}
		
		if( zoacres_po_exists() ):
			$class_name .= $this->zoacresCheckMetaValue( 'zoacres_page_header_layout', 'header-layout' ) == 'boxed' ? ' boxed-container' : '';
		elseif( is_single() ):
			$class_name .= $this->zoacresCheckMetaValue( 'zoacres_post_header_layout', 'header-layout' ) == 'boxed' ? ' boxed-container' : '';
		else:
			$zoacres_options = $this->zoacres_options;
			if( $this->zoacresThemeOpt('header-type') == 'default' ):
				$class_name .= isset( $zoacres_options['header-layout'] ) && $zoacres_options['header-layout'] == 'boxed' ? ' boxed-container' : '';
			endif;
		endif;
		
		echo esc_attr( $class_name );
	}

	function zoacresHeaderMenu($menu_name, $parent_class = ''){
		ob_start();
		wp_nav_menu( array(
			'theme_location' => esc_attr( $menu_name ),
			'menu_class'	=> esc_attr( $parent_class ),
			'zoacres_primary_stat'		=> 0,
			'fallback_cb'       => 'zoacres_wp_bootstrap_navwalker::fallback',
			'walker'            => new zoacres_wp_bootstrap_navwalker()
		) );
		$output = ob_get_clean();
		return $output;
	}
	
	function zoacresHeaderMainMenu(){
		
		$menu_class = 'nav zoacres-main-menu';
	
		ob_start();
		
		$page_menu = get_post_meta( get_the_ID(), 'zoacres_page_nav_menu', true );
		
		if( isset( $page_menu ) && $page_menu != 'none' && $page_menu != '' ){
			wp_nav_menu( array(
				'menu'				=> $page_menu,
				'menu_id'			=> 'zoacres-main-menu',
				'depth'             => 5,
				'container'         => '',
				'container_class'   => '',
				'menu_class'        => esc_attr( $menu_class ),
				'fallback_cb'       => 'zoacres_wp_bootstrap_navwalker::fallback',
				'walker'            => new zoacres_wp_bootstrap_navwalker())
			);
		}else{
			wp_nav_menu( array(
				'theme_location'    => 'primary-menu',
				'menu_id'			=> 'zoacres-main-menu',
				'depth'             => 5,
				'container'         => '',
				'container_class'   => '',
				'menu_class'        => esc_attr( $menu_class ),
				'fallback_cb'       => 'zoacres_wp_bootstrap_navwalker::fallback',
				'walker'            => new zoacres_wp_bootstrap_navwalker())
			);
		}
		$output = ob_get_clean();
		return $output;
	}
	
	function zoacresHeaderLogo(){
		$zoacres_options = $this->zoacres_options;
		$logo_url = isset( $zoacres_options['logo']['url'] ) && $zoacres_options['logo']['url'] != '' ? $zoacres_options['logo']['url'] : '';
		
		$custom_logo = get_post_meta( get_the_ID(), 'zoacres_page_custom_logo', true );
		$site_title = get_bloginfo( 'name' );
		
		if( $custom_logo ){
			$img_attributes = wp_get_attachment_image_src( $custom_logo, 'large' );
			$output = '
			<div class="main-logo">
				<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" ><img class="custom-logo img-responsive" src="'. esc_url( $img_attributes[0] ) .'" alt="'. esc_attr( $site_title ) .'" title="'. esc_attr( $site_title ) .'" /></a>
			</div>';
		}elseif( $logo_url ){
			$logo_height = isset( $zoacres_options['logo']['height'] ) && $zoacres_options['logo']['height'] != '' ? $zoacres_options['logo']['height'] : '';
			$logo_width = isset( $zoacres_options['logo']['width'] ) && $zoacres_options['logo']['width'] != '' ? $zoacres_options['logo']['width'] : '';
			$output = '
			<div class="main-logo">
				<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" ><img class="custom-logo img-responsive" src="'. esc_url( $logo_url ) .'" alt="'. esc_attr( $site_title ) .'" title="'. esc_attr( $site_title ) .'" width="'. esc_attr( $logo_width ) .'" height="'. esc_attr( $logo_height ) .'" /></a>
			</div>';
		}else{
			$output = '
			<div class="main-logo">
				<a class="site-title" href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" >'. esc_html( $site_title ) .'</a>
			</div>';
		}
		return $output;
	}
	
	function zoacresAdditionalLogo($field){
		$zoacres_options = $this->zoacres_options;
		$logo_url = isset( $zoacres_options[$field]['url'] ) && $zoacres_options[$field]['url'] != '' ? $zoacres_options[$field]['url'] : '';
		
		$custom_sticky_logo = get_post_meta( get_the_ID(), 'zoacres_page_custom_sticky_logo', true );
		$site_title = get_bloginfo( 'name' );
		
		if( $field == 'sticky-logo' && $custom_sticky_logo ){
			$img_attributes = wp_get_attachment_image_src( $custom_sticky_logo, 'large' );
			$output = '<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" ><img class="custom-logo img-responsive" src="'. esc_url( $img_attributes[0] ) .'" alt="'. esc_attr( $site_title ) .'" title="'. esc_attr( $site_title ) .'" /></a>';
		}elseif( $logo_url ){
			$output = '<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" ><img class="img-responsive" src="'. esc_url( $logo_url ) .'" alt="'. esc_attr( $site_title ) .'" title="'. esc_attr( $site_title ) .'" /></a>';
		}else{
			$output = '<a class="site-title" href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( $site_title ) .'" >'. esc_html( $site_title ) .'</a>';
		}
		return $output;
	}
	
	function zoacresHeaderDate(){
		$zoacres_options = $this->zoacres_options;
		return isset( $zoacres_options['header-topbar-date'] ) && $zoacres_options['header-topbar-date'] != '' ? $zoacres_options['header-topbar-date'] : 'l, F j, Y';
	}
	
	function zoacresHeaderCustomText($key){
		$zoacres_options = get_option( 'zoacres_options' ); //$this->zoacres_options;
		return isset( $zoacres_options[$key] ) ? $zoacres_options[$key] : '';
	}
	
	function zoacresToggleSearchBarOut(){
		$output = '
				<div class="full-bar-search-wrap">
					<form method="get" class="search-form" action="'. esc_url( home_url( '/' ) ) .'">
						<div class="input-group">
							<input type="text" name="s" class="form-control" value="'. get_search_query() .'" placeholder="'. esc_attr__('Search hit enter..', 'zoacres') .'">
						</div>
					</form>
					<a href="#" class="close full-bar-search-toggle"></a>
				</div>';
		return $output;
	}
	
	function zoacresHeaderSearchModal(){
		$zoacres_options = $this->zoacres_options;
		$serach_opt = $this->zoacresThemeOpt('search-toggle-form');
		$output = '';
		switch( $serach_opt ){
		
			case '1':
				$output .= '<a class="full-search-toggle" href="#"><i class="fa fa-search"></i></a>';
				add_filter( 'zoacres_footer_search_filter', array( $this, 'zoacresFullSearchWrap' ), 10 );
			break;
			
			case '2':
				$output .= '
				<div class="textbox-search-wrap">
					<form method="get" class="search-form" action="'. esc_url( home_url( '/' ) ) .'">
						<div class="input-group">
							<input type="text" name="s" class="form-control" value="'. get_search_query() .'" placeholder="'. esc_attr__('Search hit enter..', 'zoacres') .'">
						</div>
					</form>
				</div>
				<a class="textbox-search-toggle" href="#"><i class="fa fa-search"></i></a>
				';
			break;
			
			case '3':
				add_filter( "zoacres_toggle_search_bar", array( $this , "zoacresToggleSearchBarOut" ) , 10 );
				$output .= '<a class="full-bar-search-toggle" href="#"><i class="fa fa-search"></i></a>';
			break;
			
			case '4':
				ob_start();
				get_search_form();
				$form_out = ob_get_clean();
				$output .= '<div class="bottom-search-wrap">';
				$output .= $form_out;
				$output .= '</div>
				<a class="bottom-search-toggle" href="#"><i class="fa fa-search"></i></a>';
			break;
			
			default:
				 get_search_form();
			break; 
			
		}
		
		return $output;
	}
	
	function zoacresHeaderSecondarySpace(){
		$zoacres_options = $this->zoacres_options;
		$sec_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_secondary_opt', true );
		if( $sec_opt != 'disable' && ( $sec_opt == 'enable' || ( $this->zoacresThemeOpt('secondary-menu') == true && $this->zoacresThemeOpt('header-type') == 'default' ) ) ):
			if ( is_active_sidebar( 'secondary-menu-sidebar' ) ) :
				$menu_type = '';
				if( $sec_opt == 'enable' ){
					$menu_type = get_post_meta( get_the_ID(), 'zoacres_page_header_secondary_animate', true );
				}else{
					$menu_type = $this->zoacresThemeOpt('secondary-menu-type');
				}
				$secondary_pos = '';
				if( $menu_type == 'left-push' || $menu_type == 'left-overlay' ) 
					$secondary_pos = 'left';
				elseif( $menu_type == 'full-overlay' )
					$secondary_pos = 'overlay';
				else
					$secondary_pos = 'right';
			?>
				<div class="secondary-menu-area <?php echo esc_attr( $menu_type ); ?>" data-pos="<?php echo esc_attr($secondary_pos); ?>">
					<span class="close secondary-space-toggle" title="<?php esc_attr_e( 'Close', 'zoacres' ); ?>"></span>
					<div class="secondary-menu-area-inner">
						<?php dynamic_sidebar( 'secondary-menu-sidebar' ); ?>
					</div>
				</div>
			<?php
			endif;
		endif;
	}
	
	function zoacresHeaderTopSliding(){
		$zoacres_options = $this->zoacres_options;
		if( $this->zoacresThemeOpt('header-top-sliding-switch') ):
		
			$cols = $this->zoacresThemeOpt('header-top-sliding-cols');
			$cols = $cols != '' ? $cols : '4';
			
			
			$enable_devices = $this->zoacresThemeOpt('header-top-sliding-device');

			$en_dev_array = array();
			$class = '';
			if( $enable_devices ):
				foreach ( $enable_devices as $key => $value ) {
					array_push( $en_dev_array, $value );
				}
			endif;
			
			if( !in_array( "desktop", $en_dev_array ) ):
				$class = ' hidden-xl-down';
			elseif( !in_array( "tab", $en_dev_array ) ):
				$class = ' hidden-md-down';
			elseif( !in_array( "mobile", $en_dev_array ) ):
				$class = ' hidden-sm-down';
			endif;

		?>
			<div class="top-sliding-bar<?php echo esc_attr( $class ); ?>">
				<div class="top-sliding-bar-inner">
					<div class="container">
						<div class="row" data-col="<?php echo esc_attr( $cols ); ?>">
						
							<?php if( $cols <= 12 && is_active_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-1') ) ): ?>
							<div class="col-sm-<?php echo esc_attr( $cols ); ?>">
								<?php dynamic_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-1') ); ?>
							</div>
							<?php endif; ?>
							
							<?php if( $cols <= 6 && is_active_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-2') ) ): ?> 
							<div class="col-sm-<?php echo esc_attr( $cols ); ?>">
								<?php dynamic_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-2') ); ?>
							</div>
							<?php endif; ?>
							
							<?php if( $cols <= 4 && is_active_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-3') ) ): ?> 
							<div class="col-sm-<?php echo esc_attr( $cols ); ?>">
								<?php dynamic_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-3') ); ?>
							</div>
							<?php endif; ?>
							
							<?php if( $cols <= 3 && is_active_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-4') ) ): ?> 
							<div class="col-sm-<?php echo esc_attr( $cols ); ?>">
								<?php dynamic_sidebar( $this->zoacresThemeOpt('header-top-sliding-sidebar-4') ); ?>
							</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
				<a href="#" class="top-sliding-toggle"></a>
			</div>
		<?php
		endif;
	}
	
	function zoacresHeaderTopBarElementsOut($key) {

		switch($key) {
		
			case 'header-topbar-menu':
				echo ( ''. $this->zoacresHeaderMenu('top-menu', 'topbar-items nav') );
			break;
		
			case 'header-topbar-social':
				echo ( ''. $this->zoacresSocial() );
			break;
		
			case 'header-topbar-date':
				echo date_i18n( stripslashes( $this->zoacresHeaderDate() ) );
			break;
		
			case 'header-topbar-search':
				 get_search_form();
			break; 
			
			case 'header-topbar-text-1':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-topbar-text-1') ); 
			break; 
			
			case 'header-topbar-text-2':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-topbar-text-2') ); 
			break; 
			
			case 'header-topbar-ads-list':
				 echo zoacres_ads_out( $this->zoacresThemeOpt( 'header-topbar-ads-list' ) );
			break; 
			
			case 'header-phone':
				$header_phone = $this->zoacresThemeOpt( 'header-phone-text' );
				if( $header_phone )
				echo '<div class="header-phone"><span class="fa fa-phone-square"></span> <a href="tel:'. esc_attr( $header_phone ) .'">'. esc_attr( $header_phone ) .'</a></div>';
			break;
			
			case 'header-address':
				$header_address = $this->zoacresThemeOpt( 'header-address-text' );
				if( $header_address )
				echo '<div class="header-address"><span class="fa fa-map-marker"></span> '. wp_kses_post( $header_address ) .'</div>';
			break;
			
			case 'header-email':
				$header_email = $this->zoacresThemeOpt( 'header-email-text' );
				if( $header_email )
				echo '<div class="header-email"><span class="fa fa-envelope-o"></span> <a href="mailto:'. esc_attr( $header_email ) .'">'. esc_attr( $header_email ) .'</a></div>';
			break; 
		
		}
	}	
	
	function zoacresHeaderTopBarElements($item, $class = '') {
		
		$topbar_elements = '';
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_topbar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$topbar_elements_json = get_post_meta( get_the_ID(), 'zoacres_page_header_topbar_items', true );
				$topbar_elements = json_decode( stripslashes( $topbar_elements_json ), true );
				$topbar_elements = $topbar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
				$topbar_elements = $zoacres_options['header-topbar-items'][$item];
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_topbar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$topbar_elements_json = get_post_meta( get_the_ID(), 'zoacres_post_header_topbar_items', true );
				$topbar_elements = json_decode( stripslashes( $topbar_elements_json ), true );
				$topbar_elements = $topbar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
				$topbar_elements = $zoacres_options['header-topbar-items'][$item];
			}
		}else{		
			$zoacres_options = $this->zoacres_options;
			$topbar_elements = $zoacres_options['header-topbar-items'][$item];
		}
		if( array_key_exists( "placebo", $topbar_elements ) ) unset( $topbar_elements['placebo'] );
		if ($topbar_elements): 
		?>
			<ul class="topbar-items nav <?php echo esc_attr( $class ); ?>">
		<?php foreach ($topbar_elements as $element => $value ) {?>
				<li class="nav-item">
					<div class="nav-item-inner">
				<?php $this->zoacresHeaderTopBarElementsOut($element); ?>
					</div>
				</li>
		<?php }	?>
			</ul>
		<?php
		endif;
		
	}
	
	function zoacresHeaderLogoBarElementsOut($key, $sticky_logo_chk) {

		switch($key) {
			
			case 'header-logobar-logo':
				echo ( ''. $this->zoacresHeaderLogo() );
				if( $sticky_logo_chk ){
					echo '<div class="sticky-logo">' . $this->zoacresAdditionalLogo( 'sticky-logo' ) . '</div>';
				}
			break;
			
			case 'header-logobar-menu':
				echo ( ''. $this->zoacresHeaderMainMenu() );
			break;
		
			case 'header-logobar-social':
				echo ( ''. $this->zoacresSocial() );
			break;
		
			case 'header-logobar-search':
				 get_search_form();
			break; 
			
			case 'header-logobar-text-1':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-logobar-text-1') ); 
			break; 
			
			case 'header-logobar-text-2':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-logobar-text-2') ); 
			break; 
			
			case 'header-logobar-search-toggle':
				 echo '<div class="search-toggle-wrap">' . $this->zoacresHeaderSearchModal() . '</div>';
			break;
			
			case 'header-logobar-secondary-toggle':
				echo '<a class="secondary-space-toggle" href="#"><span></span><span></span><span></span></a>';
			break;
			
			case 'header-logobar-ads-list':
				 echo zoacres_ads_out( $this->zoacresThemeOpt( 'header-logobar-ads-list' ) );
			break; 
			
			case 'header-property':
				$submit_prop_text = apply_filters( 'zoacres_submit_property_text', esc_html__( '+ Submit Property', 'zoacres' ) );
				echo do_shortcode( '[zoacres_signin_trigger signin_text="'. esc_html( $submit_prop_text ) .'"]' );
			break;
			
			case 'header-phone':
				$header_phone = $this->zoacresThemeOpt( 'header-phone-text' );
				if( $header_phone )
				echo '<div class="header-phone"><span class="fa fa-phone-square"></span> '. wp_kses_post( $header_phone ) .'</div>';
			break;
			
			case 'header-address':
				$header_address = $this->zoacresThemeOpt( 'header-address-text' );
				if( $header_address )
				echo '<div class="header-address"><span class="fa fa-map-marker"></span> '. wp_kses_post( $header_address ) .'</div>';
			break;
			
			case 'header-email':
				$header_email = $this->zoacresThemeOpt( 'header-email-text' );
				if( $header_email )
				echo '<div class="header-email"><span class="fa fa-envelope-o"></span> '. wp_kses_post( $header_email ) .'</div>';
			break; 
		
		}
	}	
	
	function zoacresHeaderLogoBarElements($item, $class = '') {
	
		$logobar_elements = '';
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_logo_bar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$logobar_elements_json = get_post_meta( get_the_ID(), 'zoacres_page_header_logo_bar_items', true );
				$logobar_elements = json_decode( stripslashes( $logobar_elements_json ), true );
				$logobar_elements = $logobar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
				$logobar_elements = $zoacres_options['header-logobar-items'][$item];
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_logo_bar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$logobar_elements_json = get_post_meta( get_the_ID(), 'zoacres_post_header_logo_bar_items', true );
				$logobar_elements = json_decode( stripslashes( $logobar_elements_json ), true );
				$logobar_elements = $logobar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
				$logobar_elements = $zoacres_options['header-logobar-items'][$item];
			}
		}else{		
			$zoacres_options = $this->zoacres_options;
			$logobar_elements = $zoacres_options['header-logobar-items'][$item];
		}
		
		if( array_key_exists( "placebo", $logobar_elements ) ) unset( $logobar_elements['placebo'] );
		if ($logobar_elements): 
		?>
			<ul class="logobar-items nav <?php echo esc_attr( $class ); ?>">
		<?php 
			$sticky_logo_chk = isset( $logobar_elements['header-logobar-sticky-logo'] ) ? true : false;
			foreach ($logobar_elements as $element => $value ) {?>
				<li class="nav-item">
					<div class="nav-item-inner">
				<?php $this->zoacresHeaderLogoBarElementsOut($element, $sticky_logo_chk); ?>
					</div>
				</li>
		<?php }	?>
			</ul>
		<?php
		endif;
		
	}
	
	/* Header Navbar Items */
	function zoacresHeaderNavBarElementsOut($key, $sticky_logo_chk) {

		switch($key) {
			
			case 'header-navbar-logo':
				echo ( ''. $this->zoacresHeaderLogo() );
				if( $sticky_logo_chk ){
					echo '<div class="sticky-logo">' . $this->zoacresAdditionalLogo( 'sticky-logo' ) . '</div>';
				}
			break;
			
			case 'header-navbar-menu':
				echo ( ''. $this->zoacresHeaderMainMenu() );
			break;
		
			case 'header-navbar-social':
				echo ( ''. $this->zoacresSocial() );
			break;
		
			case 'header-navbar-search':
				 get_search_form();
			break;
			
			case 'header-navbar-search-toggle':
				 echo '<div class="search-toggle-wrap">' . $this->zoacresHeaderSearchModal() . '</div>';
			break;
			
			case 'header-navbar-text-1':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-navbar-text-1') ); 
			break; 
			
			case 'header-navbar-text-2':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-navbar-text-2') );
			break; 
			
			case 'header-navbar-secondary-toggle':
				echo '<a class="secondary-space-toggle" href="#"><span></span><span></span><span></span></a>';
			break; 
			
			case 'header-property':
				$submit_prop_text = apply_filters( 'zoacres_submit_property_text', esc_html__( '+ Submit Property', 'zoacres' ) );
				echo do_shortcode( '[zoacres_signin_trigger signin_text="'. esc_html( $submit_prop_text ) .'"]' );
			break;
			
			case 'header-navbar-ads-list':
				 echo zoacres_ads_out( $this->zoacresThemeOpt( 'header-navbar-ads-list' ) );
			break;
			
			case 'header-phone':
				$header_phone = $this->zoacresThemeOpt( 'header-phone-text' );
				if( $header_phone )
				echo '<div class="header-phone"><span class="fa fa-phone-square"></span> '. wp_kses_post( $header_phone ) .'</div>';
			break;
			
			case 'header-address':
				$header_address = $this->zoacresThemeOpt( 'header-address-text' );
				if( $header_address )
				echo '<div class="header-address"><span class="fa fa-map-marker"></span> '. wp_kses_post( $header_address ) .'</div>';
			break;
			
			case 'header-email':
				$header_email = $this->zoacresThemeOpt( 'header-email-text' );
				if( $header_email )
				echo '<div class="header-email"><span class="fa fa-envelope-o"></span> '. wp_kses_post( $header_email ) .'</div>';
			break; 

		}
	}	
	
	function zoacresHeaderNavBarElements($item, $class = '') {
	
		$navbar_elements = '';
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_navbar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$navbar_elements_json = get_post_meta( get_the_ID(), 'zoacres_page_header_navbar_items', true );
				$navbar_elements = json_decode( stripslashes( $navbar_elements_json ), true );
				$navbar_elements = $navbar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
			$navbar_elements = $zoacres_options['header-navbar-items'][$item];
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_navbar_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$navbar_elements_json = get_post_meta( get_the_ID(), 'zoacres_post_header_navbar_items', true );
				$navbar_elements = json_decode( stripslashes( $navbar_elements_json ), true );
				$navbar_elements = $navbar_elements[$item];
			}else{
				$zoacres_options = $this->zoacres_options;
			$navbar_elements = $zoacres_options['header-navbar-items'][$item];
			}
		}else{		
			$zoacres_options = $this->zoacres_options;
			$navbar_elements = $zoacres_options['header-navbar-items'][$item];
		}
	
		if( array_key_exists( "placebo", $navbar_elements ) ) unset( $navbar_elements['placebo'] );
		if ($navbar_elements): 
		?>
			<ul class="navbar-items nav <?php echo esc_attr( $class ); ?>">
		<?php 
			$sticky_logo_chk = isset( $navbar_elements['header-navbar-sticky-logo'] ) ? true : false;
			foreach ($navbar_elements as $element => $value ) {?>
				<li class="nav-item">
					<div class="nav-item-inner">
				<?php $this->zoacresHeaderNavBarElementsOut($element, $sticky_logo_chk); ?>
					</div>
				</li>
		<?php }	?>
			</ul>
		<?php
		endif;
		
	}
	
	function zoacresHeaderBarElements($state = '', $elements) {
		$zoacres_options = $this->zoacres_options;
		$header_elements = $elements;
		
		if( array_key_exists( "placebo", $header_elements ) ) unset( $header_elements['placebo'] );
		
		if ($header_elements): 
			
			$sticky_opt = '';
			$sticky = $sticky_scroll = '';
			
			if( zoacres_po_exists() ){
				$sticky_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_sticky_opt', true );
			}elseif( is_single() ){
				$sticky_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_sticky_opt', true );
			}else{
				$sticky_opt = 'theme-default';
			}
			
			
			if( $sticky_opt == '' || $sticky_opt == 'theme-default' ){
				$sticky = $this->zoacresThemeOpt('sticky-part');
				$sticky_scroll = $this->zoacresThemeOpt('sticky-part-scrollup');
			}elseif( $sticky_opt == 'sticky' ){
				$sticky = 1;
				$sticky_scroll = 0;
			}elseif( $sticky_opt == 'sticky-scroll' ){
				$sticky = 1;
				$sticky_scroll = 1;
			}else{
				$sticky = 0;
			}
			
			if( $state == 'sticky' && $sticky == 1 ):
			?> <div class="sticky-outer"> <?php
				if( $sticky_scroll == 1 ):
				?> <div class="sticky-scroll"> <?php
				else:
				?> <div class="sticky-head"> <?php
				endif;
			endif;
		
			foreach ($header_elements as $element => $value ) {
				switch($element){
					case 'header-topbar':
					?>
						<div class="topbar clearfix">
							<div class="custom-container topbar-inner">
								<?php
									$this->zoacresHeaderTopBarElements('Left', 'pull-left');
									$this->zoacresHeaderTopBarElements('Center', 'pull-center text-center');
									$this->zoacresHeaderTopBarElements('Right', 'pull-right');
								?>
							</div>
						</div>
					<?php
					break;
					
					case 'header-logo':
					?>
						<div class="logobar clearfix">
							<div class="custom-container logobar-inner">
								<?php
									$this->zoacresHeaderLogoBarElements('Left', 'pull-left');
									$this->zoacresHeaderLogoBarElements('Center', 'pull-center text-center');
									$this->zoacresHeaderLogoBarElements('Right', 'pull-right');
								?>
							</div>
							<?php
								echo apply_filters( 'zoacres_toggle_search_bar', '');
							?>
						</div>
					<?php
					break;
					
					case 'header-nav':
					?>
						<nav class="navbar clearfix">
							<div class="custom-container navbar-inner">
								<?php
									$this->zoacresHeaderNavBarElements('Left', 'pull-left');
									$this->zoacresHeaderNavBarElements('Center', 'pull-center text-center');
									$this->zoacresHeaderNavBarElements('Right', 'pull-right');
								?>
							</div>
							<?php
								echo apply_filters( 'zoacres_toggle_search_bar', '');
							?>
						</nav>
					<?php
					break;
				}
			}
			
			if( $state == 'sticky' && $sticky == 1 ):
				?> </div><!--stikcy outer--> 
				</div><!-- sticky-head or sticky-scroll --> <?php
			endif;
			
		endif;
	}
	
	/* Header Navbar Items */
	function zoacresStickyHeaderSpaceElements($key) {

		switch($key) {
			
			case 'header-fixed-logo':
				echo ( ''. $this->zoacresHeaderLogo() );
			break;
			
			case 'header-fixed-menu':
				echo ( ''. $this->zoacresWPMenu('primary-menu', 'zoacres-main-menu') );
			break;
		
			case 'header-fixed-social':
				echo ( ''. $this->zoacresSocial() );
			break;
		
			case 'header-fixed-search':
				 get_search_form();
			break; 
			
			case 'header-fixed-text-1':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-navbar-text-1') );
			break; 
			
			case 'header-fixed-text-2':
				echo do_shortcode( $this->zoacresHeaderCustomText('header-navbar-text-2') );
			break; 

		}
	}
	
	function zoacresStickyHeaderSpace(){
		//$zoacres_options = $this->zoacres_options;
		$elements = array( 'Top', 'Middle', 'Bottom' );
		
		$class_name = '';
		if( zoacres_po_exists() ):
			$class_name = $this->zoacresCheckMetaValue( 'zoacres_page_header_type', 'header-type' );
		elseif( is_single() ):
			$class_name = $this->zoacresCheckMetaValue( 'zoacres_post_header_type', 'header-type' );
		else:
			$class_name = $this->zoacresThemeOpt('header-type');
		endif;
		
	?>
		<div class="sticky-header-space <?php echo esc_attr( $class_name ); ?>">
			<div class="sticky-header-space-inner">
	<?php
		foreach( $elements as $part ){
			
			$header_fixed_array = $header_fixed_elements = '';
			
			if( zoacres_po_exists() ){
				$header_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_stikcy_items_opt', true );
				if( $header_items_opt == 'custom' ){
					$header_items = get_post_meta( get_the_ID(), 'zoacres_page_header_stikcy_items', true );
					$header_fixed_array = json_decode( stripslashes( $header_items ), true );
				}else{
					$header_fixed_array = $this->zoacresThemeOpt( 'header-fixed-items' );
				}
			}elseif( is_single() ){
				$header_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_stikcy_items_opt', true );
				if( $header_items_opt == 'custom' ){
					$header_items = get_post_meta( get_the_ID(), 'zoacres_post_header_stikcy_items', true );
					$header_fixed_array = json_decode( stripslashes( $header_items ), true );
				}else{
					$header_fixed_array = $this->zoacresThemeOpt( 'header-fixed-items' );
				}
			}else{
				$header_fixed_array = $this->zoacresThemeOpt( 'header-fixed-items' );
			}
			
			if( is_array( $header_fixed_array ) ){
				$header_fixed_elements = $header_fixed_array[$part];
				//unset unwanted redux auto generate item
				if( array_key_exists( "placebo", $header_fixed_elements ) ) unset( $header_fixed_elements['placebo'] );
			}
			
			if ($header_fixed_elements): 
			?>
				<ul class="header-fixed-items nav flex-column header-fixed-<?php echo sanitize_title( $part ); ?>">
			<?php foreach ($header_fixed_elements as $element => $value ) {?>
					<li class="nav-item">
						<div class="nav-item-inner">
							<?php $this->zoacresStickyHeaderSpaceElements($element); ?>
						</div>
					</li>
			<?php } ?>	
				</ul>
			<?php
			endif;
			
		}// end foreach
	?>
			</div>
		</div>
	<?php
	}
	
	function zoacresFullSearchWrap(){
	?>
		<div class="full-search-wrapper">
			<a class="full-search-toggle close" href="#"></a>
			<?php get_search_form(); ?>
		</div>
	<?php
	}
	
	/* Header Navbar Items */
	function zoacresMobileHeaderElements($key) {

		switch($key) {
			
			case 'mobile-header-logo':
				echo '<div class="mobile-logo">' . $this->zoacresAdditionalLogo( 'mobile-logo' ) . '</div>';
			break;
			
			case 'mobile-header-cart':
				if ( class_exists( 'WooCommerce' ) ) {
					global $woocommerce;
					$cart_link = wc_get_cart_url();
					$cart_count = WC()->cart->get_cart_contents_count();
					if( $cart_count ){
						echo '<a class="cart-bar-toggle" href="'. esc_url( $cart_link ) .'"><i class="icon-basket"></i> ('. esc_html( $cart_count ) .')</a>';
					}else{
						echo '<a class="cart-bar-toggle" href="'. esc_url( $cart_link ) .'"><i class="icon-basket"></i></a>';
					}
				}
			break;
			
			case 'mobile-header-menu':
				echo '<a class="mobile-bar-toggle" href="#"><i class="fa fa-bars"></i></a>';
			break;

			case 'mobile-header-search':
				echo '<a class="full-search-toggle" href="#"><i class="fa fa-search"></i></a>';
				add_filter( 'zoacres_footer_search_filter', array( $this, 'zoacresFullSearchWrap' ), 10 );
			break; 

		}
	}
	
	/* Header Mobile Bar Items */
	function zoacresMobileBarElements($key) {

		switch($key) {
			
			case 'mobile-menu-logo':
				echo '<div class="mobile-logo">' . $this->zoacresAdditionalLogo( 'mobile-logo' ) . '</div>';
			break;
			
			case 'mobile-menu-mainmenu':
				echo '<div class="zoacres-mobile-main-menu"></div>';
			break;
		
			case 'mobile-menu-social':
				echo ( ''. $this->zoacresSocial() );
			break;
		
			case 'mobile-menu-search':
				 get_search_form();
			break; 
			
			case 'mobile-menu-text-1':
				echo do_shortcode( $this->zoacresHeaderCustomText('mobile-menu-text-1') );
			break; 
			
			case 'mobile-menu-text-2':
				echo do_shortcode( $this->zoacresHeaderCustomText('mobile-menu-text-2') );
			break; 

		}
	}
	
	function zoacresMobileBar(){
		$zoacres_options = $this->zoacres_options;
		$animate_from = ' animate-from-'. $this->zoacresThemeOpt('mobile-menu-animate-from');
		$elements = array( 'Top', 'Middle', 'Bottom' );
		?>
		<div class="mobile-bar<?php echo esc_attr( $animate_from ); ?>">
			<a class="mobile-bar-toggle close" href="#"></a>
			<div class="mobile-bar-inner">
				<div class="container">
		<?php
			foreach( $elements as $part ){
			
				$mobile_bar_elements = isset( $zoacres_options['mobile-menu-items'][$part] ) ? $zoacres_options['mobile-menu-items'][$part] : '';
				if( is_array( $mobile_bar_elements ) && array_key_exists( "placebo", $mobile_bar_elements ) ) unset( $mobile_bar_elements['placebo'] );
				if ($mobile_bar_elements): 
				?>
					<ul class="mobile-bar-items nav flex-column mobile-bar-<?php echo sanitize_title( $part ); ?>">
				<?php foreach ($mobile_bar_elements as $element => $value ) {?>
						<li class="nav-item">
							<div class="nav-item-inner">
						<?php $this->zoacresMobileBarElements($element); ?>
							</div>
						</li>
				<?php }	?>
					</ul>
				<?php
				endif;
				
			} // end foreach
		?>
				</div><!-- container -->
			</div>
		</div>
		<?php
	}
	
	function zoacresMobileHeader(){
		$zoacres_options = $this->zoacres_options;
		$mh_array = array( 'Left' => 'pull-left', 'Center' => 'pull-center', 'Right' => 'pull-right' );
		$mobile_sticky = '';
		
		if( $this->zoacresThemeOpt('mobile-header-sticky') ){
			if( $this->zoacresThemeOpt('mobile-header-sticky-scrollup') )
				$mobile_sticky = 'sticky-scroll';
			else
				$mobile_sticky = 'sticky-head';
		}
		
		$mh_from = $this->zoacresThemeOpt('mobile-header-from');
		$mh_class = '';
		
		if( $mh_from == 'mobile' ){
			$mh_class = 'hidden-md-up';
		}elseif( $mh_from == 'tab-port' ){
			$mh_class = 'hidden-lg-up';
		}else{
			$mh_class = 'hidden-lg-up hidden-lg-land-up';
		}
		
		?>
		<div class="mobile-header">
			<div class="mobile-header-inner <?php echo esc_attr( $mh_class ); ?>">
				<?php echo ( ''. $mobile_sticky != '' ? '<div class="sticky-outer"><div class="'. esc_attr( $mobile_sticky ) .'">' : '' ); ?>
						<div class="container">
		<?php
		foreach( $mh_array as $item => $class ){
		
			$mobile_header_elements = isset( $zoacres_options['mobile-header-items'][$item] ) ? $zoacres_options['mobile-header-items'][$item] : '';
			if( is_array( $mobile_header_elements ) && array_key_exists( "placebo", $mobile_header_elements ) ) unset( $mobile_header_elements['placebo'] );
			if ($mobile_header_elements): 
			?>
				<ul class="mobile-header-items nav <?php echo esc_attr( $class ); ?>">
			<?php foreach ($mobile_header_elements as $element => $value ) {?>
					<li class="nav-item">
						<div class="nav-item-inner">
					<?php $this->zoacresMobileHeaderElements($element); ?>
						</div>
					</li>
			<?php }	?>
				</ul>
			<?php
			endif;
		
		}
		?>
						</div><!-- container -->
				<?php echo ( ''. $mobile_sticky != '' ? '</div></div>' : '' ); ?>
			</div>
		</div>
		<?php
	}
	
	function zoacresHeaderBar(){
		$zoacres_options = $this->zoacres_options;
		
		$hide_from = $this->zoacresThemeOpt('mobile-header-from');
		$hide_class = '';
		
		if( $hide_from == 'mobile' ){
			$hide_class = ' hidden-sm-down';
		}elseif( $hide_from == 'tab-port' ){
			$hide_class = ' hidden-md-down';
		}else{
			$hide_class =  ' hidden-md-down hidden-md-land-down';
		}
		
		$header_type = $header_items = '';
		
		if( zoacres_po_exists() ){
			$header_type = $this->zoacresCheckMetaValue( 'zoacres_page_header_type', 'header-type' );
			$header_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_items_opt', true );
			if( $header_items_opt == 'custom' ){
				$header_items = get_post_meta( get_the_ID(), 'zoacres_page_header_items', true );
				$header_items = json_decode( stripslashes( $header_items ), true );
			}else{
				$header_items = $this->zoacresThemeOpt( 'header-items' );
			}
		}elseif( is_single() ){
			$header_type = $this->zoacresCheckMetaValue( 'zoacres_post_header_type', 'header-type' );
			$header_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_items_opt', true );
			if( $header_items_opt == 'custom' ){
				$header_items = get_post_meta( get_the_ID(), 'zoacres_post_header_items', true );
				$header_items = json_decode( stripslashes( $header_items ), true );
			}else{
				$header_items = $this->zoacresThemeOpt( 'header-items' );
			}
		}else{
			$header_type = $this->zoacresThemeOpt( 'header-type' );
			$header_items = $this->zoacresThemeOpt( 'header-items' );
		}
		
	?>
		<div class="header-inner<?php echo esc_attr( $hide_class ); ?>">
	<?php
		if( $header_type == 'default' ):
			/* Header Normal Elements */
			echo isset( $header_items['Normal'] ) ? $this->zoacresHeaderBarElements( 'normal', $header_items['Normal'] ) : '';
			
			/* Header Sticky Elements */
			echo isset( $header_items['Sticky'] ) ? $this->zoacresHeaderBarElements( 'sticky', $header_items['Sticky'] ) : '';
			
		else:
			$this->zoacresStickyHeaderSpace();
		endif;
	?>
		</div>
	<?php
	}
	
	function zoacresFeaturedSlider($template){
	?>
		<div class="featured-slider-wrapper">
			<?php echo get_template_part('template-parts/slider/featured'); ?>
		</div>
	<?php
	}
	
	function zoacresHeaderSlider( $cur_position ){
		$slide_shortcode = $slide_opt = '';
		
		if( zoacres_po_exists() ){
			$slide_opt = $this->zoacresCheckMetaValue( 'zoacres_page_header_slider_opt', 'header-slider-position' );
			$slide_shortcode = get_post_meta( get_the_ID(), 'zoacres_page_header_slider', true );
		}elseif( is_single() ){
			$slide_opt = $this->zoacresCheckMetaValue( 'zoacres_post_header_slider_opt', 'header-slider-position' );
			$slide_shortcode = get_post_meta( get_the_ID(), 'zoacres_post_header_slider', true );
		}
		
		if( $slide_opt != 'none' && !empty( $slide_shortcode ) && $cur_position == $slide_opt ) :
	?>
		<div class="header-slider-wrapper">
			<?php echo do_shortcode( $slide_shortcode ); ?>
		</div>
	<?php
		endif;
	}
	
	function zoacresBreadcrumbs() {
	 
	  $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
	  $delimiter = ''; // delimiter between crumbs
	  $home = esc_html__('Home', 'zoacres'); // text for the 'Home' link
	  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	  $before = '<span class="current">'; // tag before the current crumb
	  $after = '</span>'; // tag after the current crumb
	 
	  global $post;
	  $homeLink = home_url( '/' );
	  echo '<div id="breadcrumb" class="breadcrumb">';
	
	  if (is_home() || is_front_page()) {
		
		if ($showOnHome == 1) echo wp_kses_post( $before . $home . $after );//'<a href="' . $homeLink . '">' . $home . '</a>';
	 
	  } else {
	
		echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
	 
		if ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			
			$post_type = get_post_type_object(get_post_type());
			if( $post_type ){
				echo wp_kses_post( $before . $post_type->labels->singular_name . $after );
			}else{
				$queried_object = get_queried_object();
				if( $queried_object )
				echo wp_kses_post( $before . $queried_object->name . $after );
			}
			
	 
		} elseif ( is_category() ) {
		  $thisCat = get_category(get_query_var('cat'), false);
		  if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
		  echo wp_kses_post( $before . single_cat_title('', false) . $after );
	 
		} elseif ( is_search() ) {
		  echo wp_kses_post( $before . get_search_query() . $after );
	 
		} elseif ( is_day() ) {
		  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
		  echo wp_kses_post( $before . get_the_time('d') . $after );
	 
		} elseif ( is_month() ) {
		  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		  echo wp_kses_post( $before . get_the_time('F') . $after );
	 
		} elseif ( is_year() ) {
		  echo wp_kses_post( $before . get_the_time('Y') . $after );
	 
		} elseif ( is_single() && !is_attachment() ) {
		  if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a href="' . $homeLink . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
		  } else {
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
			echo wp_kses_post( $cats );
			if ($showCurrent == 1) echo wp_kses_post( $before . get_the_title() . $after );
		  }
	 
		} elseif ( is_attachment() ) {
		  if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;	 
		} elseif ( is_page() && !$post->post_parent ) {
		  if ($showCurrent == 1) echo wp_kses_post( $before . get_the_title() . $after );
	 
		} elseif ( is_page() && $post->post_parent ) {
		  $parent_id  = $post->post_parent;
		  $breadcrumbs = array();
		  while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
			$parent_id  = $page->post_parent;
		  }
		  $breadcrumbs = array_reverse($breadcrumbs);
		  for ($i = 0; $i < count($breadcrumbs); $i++) {
			echo wp_kses_post( $breadcrumbs[$i] );
			if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
		  }
		  if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
	 
		} elseif ( is_tag() ) {
		  echo wp_kses_post( $before . single_tag_title('', false) . $after );
	 
		} elseif ( is_author() ) {
		   global $author;
		  $userdata = get_userdata($author);
		  echo wp_kses_post( $before . esc_html__('Posts by ', 'zoacres') . $userdata->display_name . $after );
	 
		} elseif ( is_404() ) {
		  echo wp_kses_post( $before . esc_html__('Error 404', 'zoacres') . $after );
		}
	 
		if ( get_query_var('paged') ) {
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		  echo esc_html__('Page', 'zoacres') . ' ' . get_query_var('paged');
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
	  }
	  echo '</div>';
	} 
	
	function zoacresAuthorPageTitleOut(){
	?>
		<div class="author-info-wrapper">
			<?php get_template_part('template-parts/author/biography'); ?>
		</div>
	<?php
	}
	
	function zoacresPageTitleForm($template, $custom_title = ''){
		
		$page_title = $page_title_desc = $page_tit_opt = '';
		$post_id = get_the_ID();
		$current_title = $custom_title ? $custom_title : esc_html( get_the_title() );

		if( is_singular() ):
			
			if( zoacres_po_exists() ){			

				$page_tit_opt = get_post_meta( $post_id, 'zoacres_page_header_page_title_opt', true );
				if( $page_tit_opt == '1' ){
					$page_title = esc_html( get_post_meta( $post_id, 'zoacres_page_header_page_title_text', true ) );
					$page_title_desc = esc_html( get_post_meta( $post_id, 'zoacres_page_header_page_title_desc', true ) );
					if( empty( $page_title ) ){
						$page_title = $current_title;
					}
				}else{
					$page_title = $current_title;
				}
						
			}elseif( is_single() ){			

				$page_tit_opt = get_post_meta( $post_id, 'zoacres_post_header_post_title_opt', true );
				if( $page_tit_opt == '1' ){
					$page_title = esc_html( get_post_meta( $post_id, 'zoacres_post_header_post_title_text', true ) );
					$page_title_desc = esc_html( get_post_meta( $post_id, 'zoacres_post_header_post_title_desc', true ) );
					if( empty( $page_title ) ){
						$page_title = $current_title;
					}
				}else{
					$page_title = $current_title;
				}
						
			}else{
				$page_title = $current_title;
			}
			
		elseif( $template == 'blog' ):
			$page_title = $this->zoacresThemeOpt('blog-page-title');
			$page_title_desc = $this->zoacresThemeOpt('blog-page-desc');
		elseif( $template == 'category' ):
			$page_title = single_cat_title( '', false );
			$page_title_desc = category_description();
		elseif( $template == 'tag' ):
			$page_title = single_tag_title( '', false );
			$page_title_desc = tag_description();
		elseif( $template == 'search' ):
			$page_title = esc_html__( 'Search Result for: ', 'zoacres' ) . sprintf( '%s', esc_attr( get_search_query() ) );
		else:
			$page_title = get_the_archive_title();
			$page_title_desc = get_the_archive_description();
		endif;	
		
		return array( 'title' => $page_title, 'description' => $page_title_desc );

	}	
	
	function zoacresPageTitle( $template = 'archive', $custom_title = '', $tax_id = '' ){
		$zoacres_options = $this->zoacres_options;
			
		$parallax = '';
		if( zoacres_po_exists() ){
			$parallax = $this->zoacresCheckMetaValue( 'zoacres_page_header_page_title_parallax', $template.'-page-title-parallax' );
		}elseif( is_single() ){
			$parallax = $this->zoacresCheckMetaValue( 'zoacres_post_header_post_title_parallax', $template.'-page-title-parallax' );
		}else{
			$parallax = $this->zoacresThemeOpt($template.'-page-title-parallax');
		}

		$page_tit_opt = '';
		if( zoacres_po_exists() ){
			$page_tit_opt = $this->zoacresCheckMetaValue( 'zoacres_page_header_page_title_opt', $template.'-page-title-opt' );
		}elseif( is_single() ){
			$page_tit_opt = $this->zoacresCheckMetaValue( 'zoacres_post_header_post_title_opt', $template.'-page-title-opt' );
		}else{
			$page_tit_opt = $this->zoacresThemeOpt($template.'-page-title-opt');
		}
		
		if( $page_tit_opt == 1 ) :
			$id = 'page-title';
			$property = 'no-video';
			
			if( zoacres_po_exists() ){
				$video_opt = get_post_meta( get_the_ID(), 'zoacres_page_header_page_title_video_opt', true );
				if( $video_opt == '0' ){
					$video_id = '';
				}elseif( $video_opt == '1' ){
					$video_id = get_post_meta( get_the_ID(), 'zoacres_page_header_page_title_video', true );
				}else{
					$video_opt = $this->zoacresThemeOpt( $template.'-page-title-bg' );
					$video_id = $this->zoacresThemeOpt( $template.'-page-title-video' );
				}
			}elseif( is_single() ){
				$video_opt = get_post_meta( get_the_ID(), 'zoacres_post_header_post_title_video_opt', true );
				if( $video_opt == '0' ){
					$video_id = '';
				}elseif( $video_opt == '1' ){
					$video_id = get_post_meta( get_the_ID(), 'zoacres_post_header_post_title_video', true );
				}else{
					$video_opt = $this->zoacresThemeOpt( $template.'-page-title-bg' );
					$video_id = $this->zoacresThemeOpt( $template.'-page-title-video' );
				}
			}else{
				$video_opt = $this->zoacresThemeOpt( $template.'-page-title-bg' );
				$video_id = $this->zoacresThemeOpt( $template.'-page-title-video' );
			}
			if(  $video_opt && $video_id ){
				$id = 'page-title-bg';
				$property = "{videoURL:'http://youtu.be/". esc_attr( $video_id ) ."',containment:'self',autoPlay:true, mute:true, startAt:0, opacity:1, loop:1, showControls:0}";
			}
			
			$cus_class = $parallax == 1 ? ' parallax-item' : '';
			$bg_img = '';
			if( $template == 'archive-property' ){
				$cus_class .= ' page-title-bg-img';
				$img_id = get_term_meta ( $tax_id, 'bg-image-id', true );
				$img_attr = wp_get_attachment_image_src( $img_id, 'full' );
				$bg_img = isset( $img_attr[0] ) ? $img_attr[0] : '';
			}
	?>
		<header id="<?php echo esc_attr( $id ); ?>" class="page-title-wrap">
			<div class="page-title-wrap-inner<?php echo esc_attr( $cus_class ); ?>" <?php echo ( ''. $parallax == 1 ? ' data-stellar-background-ratio="0.5"' : '' ); ?> data-property="<?php echo ( ''. $property ); ?>" data-img="<?php echo esc_url( $bg_img ); ?>">
				<?php 
				if( zoacres_po_exists() ){
					$page_tit_opt = get_post_meta( get_the_ID(), 'zoacres_page_page_title_skin_opt', true );
					if( $page_tit_opt == 'custom' ){
						$page_tit_overlay = get_post_meta( get_the_ID(), 'zoacres_page_page_title_overlay', true );
						if( $page_tit_overlay ){
							echo '<span class="page-title-overlay"></span>';
						}
					}else{
						if( $this->zoacresThemeOpt( $template.'-page-title-overlay' ) ){
							echo '<span class="page-title-overlay"></span>';
						}
					}
				}elseif( is_single() ){
					$page_tit_opt = get_post_meta( get_the_ID(), 'zoacres_post_post_title_skin_opt', true );
					if( $page_tit_opt == 'custom' ){
						$page_tit_overlay = get_post_meta( get_the_ID(), 'zoacres_post_post_title_overlay', true );
						if( $page_tit_overlay ){
							echo '<span class="page-title-overlay"></span>';
						}
					}else{
						if( $this->zoacresThemeOpt( $template.'-page-title-overlay' ) ){
							echo '<span class="page-title-overlay"></span>';
						}
					}
				}else{
					if( $this->zoacresThemeOpt( $template.'-page-title-overlay' ) ){
						echo '<span class="page-title-overlay"></span>';
					}
				}
				?>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="page-title-inner">
							<?php
							
								$pt_out = $this->zoacresPageTitleForm($template, $custom_title);
								$pt_array = array( 'Left' => 'pull-left', 'Center' => 'pull-center', 'Right' => 'pull-right' );
								foreach( $pt_array as $item => $class ){
									if( zoacres_po_exists() ){
										$page_tit_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_page_title_items_opt', true );
										if( $page_tit_items_opt == 'custom' ){
											$page_tit_items = get_post_meta( get_the_ID(), 'zoacres_page_page_title_items', true );
											$pt_elements = json_decode( stripslashes( $page_tit_items ), true );
											$pt_elements = isset( $pt_elements[$item] ) ? $pt_elements[$item] : array();
										}else{
											$pt_elements = isset( $zoacres_options['template-'. $template .'-pagetitle-items'][$item] ) ? $zoacres_options['template-'. $template .'-pagetitle-items'][$item] : array();
										}
									}elseif( is_single() ){
										$page_tit_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_post_title_items_opt', true );
										if( $page_tit_items_opt == 'custom' ){
											$page_tit_items = get_post_meta( get_the_ID(), 'zoacres_post_post_title_items', true );
											$pt_elements = json_decode( stripslashes( $page_tit_items ), true );
											$pt_elements = isset( $pt_elements[$item] ) ? $pt_elements[$item] : array();
										}else{
											$pt_elements = isset( $zoacres_options['template-'. $template .'-pagetitle-items'][$item] ) ? $zoacres_options['template-'. $template .'-pagetitle-items'][$item] : array();
										}
									}else{
										$pt_elements = isset( $zoacres_options['template-'. $template .'-pagetitle-items'][$item] ) ? $zoacres_options['template-'. $template .'-pagetitle-items'][$item] : array();
									}
									if( array_key_exists( "placebo", $pt_elements ) ) unset( $pt_elements['placebo'] );
									if( $pt_elements ):
								?>
									<div class="<?php echo esc_attr( $class ); ?>">
								<?php
									foreach ( $pt_elements as $element => $value ) {
										switch($element) {
					
											case 'title':
												if( $template == 'archive-property' ){
													$current_term = single_term_title( "", false );
													
													if( $current_term == '' ){
														$obj = get_post_type_object( 'zoacres-property' );
														$current_term = $obj->labels->singular_name;
													}
													
													if( $current_term ){
														echo '<h1 class="page-title">'. esc_html( $current_term ) .'</h1>';
													}
												}else{
													if( $pt_out[$element] ){
											?>
													<h1 class="page-title"><?php echo do_shortcode( $pt_out[$element] ); ?></h1>
											<?php
													}
												}
											break;
											
											case 'description':
												if( $pt_out[$element] ){
											?>
												<div class="page-title-desc"><?php echo do_shortcode( $pt_out[$element] ); ?></div>
											<?php
												}
											break;
											
											case 'breadcrumb':
												$this->zoacresBreadcrumbs();
											break;
											
											case 'author-info':
												$this->zoacresAuthorPageTitleOut();
											break;
												
										}
										
									} // inner foreach
								?>
									</div>
								<?php
									endif;
								} //main foreach
							?>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- .page-title-wrap-inner -->
		</header>
	<?php
		endif;
	}

}

class ZoacresPostSettings extends ZoacresThemeOpt {
	
	private $zoacres_options;
	private static $c_template; // current template i.e blog, archive..
	private static $c_sidebars_layout; // get sidebar layout
	private $c_layout;	// current layout i.e standard, grid or list
	private $thumb_guess;
	public static $unique_key = 1; // Unique Key generate random
	public static $top_standard; // Top standard post status
	
	function __construct() {
		$this->zoacres_options = parent::$zoacres_option;
    }
	
	function zoacresGetThemeOpt( $field ){
		return $this->zoacresThemeOpt( $field );
	}
	
	function zoacresSetPostTemplate( $template ){
		self::$c_template = $template;
	}
	
	function zoacresSetPageLayout( $template ){
		self::$c_sidebars_layout = $template;
	}
	
	function zoacresGetPageLayout(){
		return self::$c_sidebars_layout;
	}
	
	function zoacresGetThumbSize(){
	
		$main_layout = self::$c_template;
		$layout = $this->zoacresGetPageLayout();
		$post_layout = $this->c_layout;
		$top_standard = self::$top_standard;

		if( is_single() ){
			
			$this->thumb_guess = 'large';
			
		}elseif( $post_layout == 'standard' || $top_standard == true ){
			
			if( $layout == 'right-sidebar' || $layout == 'left-sidebar' ){
				$this->thumb_guess = 'large';
			}elseif( $layout == 'both-sidebar' ){
				$this->thumb_guess = 'medium';
			}else{
				$this->thumb_guess = 'large';
			}
			
		}elseif( $post_layout == 'grid' ){
			
			$cols = $this->zoacresThemeOpt( $main_layout . '-grid-cols' );
			
			if( $layout == 'no-sidebar' ){
				if( $cols == 2 ){
					$this->thumb_guess = 'medium';
				}elseif( $cols == 3 ){
					$this->thumb_guess = 'zoacres-grid-large';
				}else{
					$this->thumb_guess = 'zoacres-grid-medium';
				}
			}else{
				if( $cols == 2 ){
					$this->thumb_guess = 'zoacres-grid-medium';
				}else{
					$this->thumb_guess = 'zoacres-grid-small';
				}
			}
			
		}elseif( $post_layout == 'list' ){

			if( $layout == 'no-sidebar' ){
				$this->thumb_guess = 'medium';
			}else{
				$this->thumb_guess = 'zoacres-grid-medium';
			}
			
		}else{
		
			$this->thumb_guess = 'large';
			
		}		
		
	}
	
	function zoacresCheckTemplateExists( $field ){
		$theme_templates = $this->zoacresThemeOpt( 'theme-templates' );
		if( !empty( $theme_templates ) && in_array( $field, $theme_templates ) )
			return 1;
		else
			return 0;
	}
	
	function zoacresCheckCategoryTemplateExists( $field ){
		$theme_templates = $this->zoacresThemeOpt( 'theme-categories' );
		if( !empty( $theme_templates ) && in_array( $field, $theme_templates ) )
			return 1;
		else
			return 0;
	}
	
	public function zoacresUniqueKey() {
        return self::$unique_key++;
    }
	
	function zoacresGetCurrentLayout(){
		$layout = $this->zoacresThemeOpt( self::$c_template.'-post-template' );
		$this->c_layout = $layout;
		$layout .= '-layout';
		$this->zoacresGetThumbSize();
		return $layout;
	}
	
	function zoacresGetExcerptLength() {
		 $template = self::$c_template;
	}
	
	function zoacresSetTopPostExcerptLength( $length ) {
		$zoacres_options = $this->zoacres_options;
		$excerpt_length = $this->zoacresThemeOpt( self::$c_template.'-top-post-excerpt' );
		return $excerpt_length;
	}
	
	function zoacresSetExcerptLength( $length ) {
		$zoacres_options = $this->zoacres_options;
		$excerpt_length = $this->zoacresThemeOpt( self::$c_template.'-excerpt' );
		return $excerpt_length;
	}	

	function zoacresTemplateContentClass( $post_id = '' ){
		$zoacres_options = $this->zoacres_options;
		$template = self::$c_template;
		
		$hide_sidebar_opt = '';
		if( zoacres_po_exists() ){
			$hide_sidebar_opt = $this->zoacresCheckMetaValue( 'zoacres_page_sidebar_mobile', $template.'-page-hide-sidebar' );
		}elseif( is_single() ){
			$hide_sidebar_opt = $this->zoacresCheckMetaValue( 'zoacres_post_sidebar_mobile', $template.'-page-hide-sidebar' );
		}else{
			$hide_sidebar_opt = $this->zoacresThemeOpt( $template.'-page-hide-sidebar' );
		}
		
		$sidebar_class = '';
		$sticky_class = $this->zoacresThemeOpt( $template.'-sidebar-sticky' ) ? ' zoacres-sticky-obj' : '';
		$sidebar_class .= $hide_sidebar_opt == 0 ? ' hidden-sm-down' : '';
		
		$template_cls = array( 'content_class' => '', 'rsidebar_class' => '', 'lsidebar_class' => '', 'right_sidebar' => '', 'left_sidebar' => '', 'sticky_class' => $sticky_class );
		
		$page_template = '';
		
		$post_id = $post_id ? $post_id : get_the_ID();
				
		if( zoacres_po_exists( $post_id ) ){
			$page_template_opt = get_post_meta( $post_id, 'zoacres_page_template_opt', true );
			if( $page_template_opt == '' || $page_template_opt == 'theme-default' ){
				$page_template = $this->zoacresThemeOpt( $template.'-page-template' );
			}else{
				$page_template = get_post_meta( $post_id, 'zoacres_page_template', true );
			}
		}elseif( is_single() ){
			$page_template_opt = get_post_meta( $post_id, 'zoacres_post_template_opt', true );
			if( $page_template_opt == '' || $page_template_opt == 'theme-default' ){
				$page_template = $this->zoacresThemeOpt( $template.'-page-template' );
			}else{
				$page_template = get_post_meta( $post_id, 'zoacres_post_template', true );
			}
		}else{
			$page_template = $this->zoacresThemeOpt( $template.'-page-template' );
		}
		
		if( $page_template == 'right-sidebar' ){
			$this->zoacresSetPageLayout( 'right-sidebar' );
			
			if( zoacres_po_exists() ){
				$template_cls['right_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_page_right_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-right-sidebar' );
			}elseif( is_single() ){
				$template_cls['right_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_post_right_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-right-sidebar' );
			}else{
				$template_cls['right_sidebar'] = $this->zoacresThemeOpt( $template.'-right-sidebar' );
			}
			
			if( is_active_sidebar( $template_cls['right_sidebar'] ) ){
				$template_cls['content_class'] = 'col-lg-8';
				$template_cls['rsidebar_class'] = 'col-lg-4'.$sidebar_class;
			}else{
				$template_cls['content_class'] = 'col-lg-12 page-has-no-sidebar';
				$template_cls['rsidebar_class'] = '';
			}
			
		}elseif( $page_template == 'left-sidebar' ){
			$this->zoacresSetPageLayout( 'left-sidebar' );
			if( zoacres_po_exists() ){
				$template_cls['left_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_page_left_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-left-sidebar' );
			}elseif( is_single() ){
				$template_cls['left_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_post_left_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-left-sidebar' );
			}else{
				$template_cls['left_sidebar'] = $this->zoacresThemeOpt( $template.'-left-sidebar' );
			}
			
			if( is_active_sidebar( $template_cls['left_sidebar'] ) ){
				$template_cls['content_class'] = 'col-lg-8 push-lg-4';
				$template_cls['lsidebar_class'] = 'col-md-4 pull-lg-8'.$sidebar_class;
			}else{
				$template_cls['content_class'] = 'col-lg-12 page-has-no-sidebar';
				$template_cls['lsidebar_class'] = '';
			}
			
		}elseif( $page_template == 'both-sidebar' ){
			$this->zoacresSetPageLayout( 'both-sidebar' );
					
			if( zoacres_po_exists() ){
				$template_cls['right_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_page_right_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-right-sidebar' );
				$template_cls['left_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_page_left_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-left-sidebar' );
			}elseif( is_single() ){
				$template_cls['right_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_post_right_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-right-sidebar' );
				$template_cls['left_sidebar'] = $page_template_opt != '' && $page_template_opt != 'theme-default' ? 
					get_post_meta( $post_id, 'zoacres_post_left_sidebar', true ) :
					$this->zoacresThemeOpt( $template.'-left-sidebar' );
			}else{
				$template_cls['right_sidebar'] = $this->zoacresThemeOpt($template.'-right-sidebar');
				$template_cls['left_sidebar'] =  $this->zoacresThemeOpt($template.'-left-sidebar');
			}
			
			if( is_active_sidebar( $template_cls['left_sidebar'] ) || is_active_sidebar( $template_cls['right_sidebar'] ) ){
				if( is_active_sidebar( $template_cls['left_sidebar'] ) && is_active_sidebar( $template_cls['right_sidebar'] ) ){
					$template_cls['content_class'] = 'col-lg-6 push-lg-3';
					$template_cls['rsidebar_class'] = 'col-lg-3'.$sidebar_class;
					$template_cls['lsidebar_class'] = 'col-lg-3 pull-lg-6'.$sidebar_class;
				}elseif( is_active_sidebar( $template_cls['left_sidebar'] ) ){
					$template_cls['content_class'] = 'col-lg-8 push-lg-4';
					$template_cls['rsidebar_class'] = '';
					$template_cls['lsidebar_class'] = 'col-lg-4 pull-lg-8'.$sidebar_class;
				}elseif( is_active_sidebar( $template_cls['right_sidebar'] ) ){
					$template_cls['content_class'] = 'col-lg-8';
					$template_cls['rsidebar_class'] = 'col-lg-4'.$sidebar_class;
					$template_cls['lsidebar_class'] = '';
				}
			}else{
				$template_cls['content_class'] = 'col-lg-12 page-has-no-sidebar';
				$template_cls['lsidebar_class'] = '';
				$template_cls['rsidebar_class'] = '';
			}
			
		}else{
			$this->zoacresSetPageLayout( 'no-sidebar' );
			$template_cls['content_class'] = 'col-md-12 page-has-no-sidebar';
		}
		
		return $template_cls;
	}
	
	function zoacresPostTitle($layout){
		if ( is_single() ) {
			return '<h1 class="entry-title">'. esc_html( get_the_title() ) .'</h1>';
		}else{
			if( $layout == 'grid' || $layout == 'list' )
				return '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">'. esc_html( get_the_title() ) .'</a></h3>';
			else
				return '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">'. esc_html( get_the_title() ) .'</a></h2>';
		}
	}
	
	function zoacresSetPostViewCount( $postID ){
		$count_key = 'zoacres_post_views_count';
		$count = get_post_meta( $postID, $count_key, true );
		if($count==''){
			$count = 0;
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
		}else{
			$count++;
			update_post_meta( $postID, $count_key, $count );
		}
	}
	
	function zoacresLikeIPVerify( $postID ){
		// Retrieve post votes IPs
		$meta_IP = get_post_meta( $postID, 'zoacres_liked_IP', true );

		if( isset( $meta_IP ) && is_array( $meta_IP ) ){
			// Retrieve current user IP
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';

			// If user has already voted
			if( array_key_exists($ip, $meta_IP) ){
				return true;
			}else{
				return false;
			}
		}
		 
		return false;
	}
	
	function zoacresMetaLikes($postID){
		$output = '';
		$meta_IP = get_post_meta( $postID, 'zoacres_liked_IP', true );

		$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';
		
		$meta_count = get_post_meta( $postID, 'zoacres_post_like_count', true );
		$meta_count = $meta_count != '' ? $meta_count : '0';
		$meta_dcount = get_post_meta( $postID, 'zoacres_post_dislike_count', true );
		$meta_dcount = $meta_dcount != '' ? $meta_dcount : '0';
		$output .= '<ul class="nav post-like-wrap">';
		if( $this->zoacresLikeIPVerify( $postID ) ){
			if( isset( $meta_IP[$ip] ) && $meta_IP[$ip] == 'like' ){
				$output .= '<li class="nav-item tooltip-parent">
								<a href="#" class="fa fa-thumbs-up post-liked theme-color" data-stat="1" data-id="'. esc_attr( $postID ) .'"></a>
								<span class="tooltip-title">'. esc_html( $meta_count ) .'</span>
							</li>
							<li class="tooltip-parent">
								<a href="#" class="fa fa-thumbs-o-down post-dislike" data-stat="2" data-id="'. esc_attr( $postID ) .'"></a>
								<span class="tooltip-title">'. esc_html( $meta_dcount ) .'</span>
							</li>';
			}else{
				$output .= '<li class="nav-item tooltip-parent">
								<a href="#" class="fa fa-thumbs-o-up post-like" data-stat="1" data-id="'. esc_attr( $postID ) .'"></a>
								<span class="tooltip-title">'. esc_html( $meta_count ) .'</span>
							</li>
							<li class="tooltip-parent">
								<a href="#" class="fa fa-thumbs-down post-disliked theme-color" data-stat="2" data-id="'. esc_attr( $postID ) .'"></a>
								<span class="tooltip-title">'. esc_html( $meta_dcount ) .'</span>
							</li>';
			}
		}else{
			$output .= '<li class="nav-item tooltip-parent">
							<a href="#" class="fa fa-thumbs-o-up post-like" data-stat="1" data-id="'. esc_attr( $postID ) .'"></a>
							<span class="tooltip-title">'. esc_html( $meta_count ) .'</span>
						</li>
						<li class="tooltip-parent">
							<a href="#" class="fa fa-thumbs-down post-dislike" data-stat="2" data-id="'. esc_attr( $postID ) .'"></a>
							<span class="tooltip-title">'. esc_html( $meta_dcount ) .'</span>
						</li>';
		}
		$output .= '</ul>';
		return $output;
	}

	function zoacresMetaLikeCheck()
	{
		// Check for nonce security
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-post-like' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
		$postID = isset( $_POST['post_id'] ) ? esc_attr( $_POST['post_id'] ) : '';
		
		if( isset( $_POST['like_stat'] ) && $postID != '' )
		{
			// Retrieve user IP address
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';
			$post_stat = isset( $_POST['like_stat'] ) ? esc_attr( $_POST['like_stat'] ) : '1';
			
			// Get voters'IPs for the current post
			$meta_IP = get_post_meta( $postID, 'zoacres_liked_IP', true );
			 
			// Get votes count for the current post
			$meta_key = '';
			$meta_count = 0;
			if( $post_stat == '1' ){
				$meta_key = 'zoacres_post_like_count';
				$meta_count = get_post_meta( $postID, $meta_key, true );
			}else{
				$meta_key = 'zoacres_post_dislike_count';
				$meta_count = get_post_meta( $postID, $meta_key, true );
			}
	 		
			// Use has already voted ?
			if( ! $this->zoacresLikeIPVerify( $postID ) )
			{
				if( isset( $meta_IP ) && is_array( $meta_IP ) ){
					if( $post_stat == '1' ){
						$meta_IP[$ip] = 'like';
					}else{
						$meta_IP[$ip] = 'dislike';
					}
				}else{
					if( $post_stat == '1' ){
						$meta_IP = array( $ip => 'like' );
					}else{
						$meta_IP = array( $ip => 'dislike' );
					}
				}
				
				$meta_count = $meta_count != '' ? $meta_count : 0;
				// Save IP and increase votes count
				update_post_meta( $postID, "zoacres_liked_IP", $meta_IP );
				update_post_meta( $postID, $meta_key, ++$meta_count );
	
				// Display count (ie jQuery return value)
				echo ( ''. $this->zoacresMetaLikes( $postID ) );
				
			}else{
				
				$like_count = get_post_meta( $postID, 'zoacres_post_like_count', true );
				$dislike_count = get_post_meta( $postID, 'zoacres_post_dislike_count', true );
				
				if( $post_stat == '1' ){
					if( $meta_IP[$ip] == 'dislike' ){
						//going to like 
						$meta_IP[$ip] = 'like';
						update_post_meta( $postID, "zoacres_liked_IP", $meta_IP );
						update_post_meta( $postID, 'zoacres_post_dislike_count', --$dislike_count );
						update_post_meta( $postID, 'zoacres_post_like_count', ++$like_count );
						echo ( ''. $this->zoacresMetaLikes( $postID ) );
					}else{
						echo "already liked";
					}
				}else{
					if( $meta_IP[$ip] == 'like' ){
						//going to dislike
						$meta_IP[$ip] = 'dislike';
						update_post_meta( $postID, "zoacres_liked_IP", $meta_IP );
						update_post_meta( $postID, 'zoacres_post_like_count', --$like_count );
						update_post_meta( $postID, 'zoacres_post_dislike_count', ++$dislike_count );
						echo ( ''. $this->zoacresMetaLikes( $postID ) );
					}else{
						echo "already disliked";
					}
				}
				
			}
		}
		exit;
	}
	
	function zoacresFavouriteIPVerify( $postID ){
		// Retrieve post votes IPs
		$meta_IP = get_post_meta( $postID, 'zoacres_favourite_IP', true );

		if( isset( $meta_IP ) && is_array( $meta_IP ) ){
			// Retrieve current user IP
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';

			// If user has already voted
			if( in_array($ip, $meta_IP) ){
				return true;
			}else{
				return false;
			}
		}
		 
		return false;
	}
	
	function zoacresMetaFavourite($postID){
		$output = '';
		$meta_IP = get_post_meta( $postID, 'zoacres_favourite_IP', true );

		$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';
		
		$meta_count = get_post_meta( $postID, 'zoacres_post_fav_count', true );
		$meta_count = $meta_count != '' ? $meta_count : '0';

		$output .= '<ul class="nav post-fav-wrap">';
		if( $this->zoacresFavouriteIPVerify( $postID ) ){
			$output .= '<li class="nav-item">
							<a href="#" class="fa fa-heart post-fav-done theme-color" data-toggle="tooltip" title="'. esc_attr( $meta_count ) .'"></a>
						</li>';
		}else{
			$output .= '<li class="nav-item">
								<a href="#" class="fa fa-heart post-favourite theme-color" data-toggle="tooltip" title="'. esc_attr( $meta_count ) .'" data-id="'. esc_attr( $postID ) .'"></a>
							</li>';
		}
		$output .= '</ul>';
		return $output;
		
	}
	
	function zoacresMetaFavouriteCheck()
	{
		// Check for nonce security
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-post-fav' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
			
		$postID = isset( $_POST['post_id'] ) ? esc_attr( $_POST['post_id'] ) : '';
		
		if( $postID != '' )
		{
			// Retrieve user IP address
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';
		
			// Get voters'IPs for the current post
			$meta_IP = get_post_meta( $postID, 'zoacres_favourite_IP', true );
			
			// Get votes count for the current post
			$meta_key = '';
			$meta_count = 0;
			$meta_key = 'zoacres_post_fav_count';
			$meta_count = get_post_meta( $postID, $meta_key, true );
	 		
			// Use has already voted ?
			if( ! $this->zoacresFavouriteIPVerify( $postID ) )
			{
				$meta_IP = array($ip);
				$meta_count = $meta_count != '' ? $meta_count : 0;
				// Save IP and increase votes count
				update_post_meta( $postID, "zoacres_favourite_IP", $meta_IP );
				update_post_meta( $postID, $meta_key, ++$meta_count );
				
			}else{
				array_push($meta_IP, $ip);
				update_post_meta( $postID, "zoacres_favourite_IP", $meta_IP );
				update_post_meta( $postID, $meta_key, ++$meta_count );
			}
			echo ( ''. $this->zoacresMetaFavourite( $postID ) );
		}
		exit;
	}
	
	function zoacresMetaDate(){
		$archive_year  = get_the_time('Y');
		$archive_month = get_the_time('m'); 
		$archive_day   = get_the_time('d');
		return '<div class="post-date"><span class="before-icon fa fa-calendar theme-color"></span><a href="'.get_day_link( $archive_year, $archive_month, $archive_day).'" >'. get_the_date() .'</a></div>';
		//get_the_time( get_option('date_format') )
	}
	
	function zoacresMetaComment(){
		$comments_count = wp_count_comments(get_the_ID());
		return '<div class="post-comment"><span class="before-icon fa fa-commenting theme-color"></span><a href="'.get_comments_link( get_the_ID() ).'" rel="bookmark" class="comments-count">'.$comments_count->total_comments.'</a></div>';
	}
	
	function zoacresMetaAuthor(){
		return '<div class="post-author"><a href="'. get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) .'"><span class="fa fa-user-circle theme-color"></span><span class="author-name">'. get_the_author() .'</span></a></div>';
	}
	
	function zoacresMetaMore($read_more_text){
		return '<div class="post-more"><a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'. esc_html( $read_more_text ) .'</a></div>';
	}
	
	function zoacresMetaViews(){
		if( get_post_meta( get_the_ID(), 'zoacres_post_views_count', true ) )
			return '<div class="post-views"><span class="before-icon fa fa-eye theme-color"></span><span>'. esc_attr( get_post_meta( get_the_ID(), 'zoacres_post_views_count', true ) ) .'</span></div>';
		
		return '';
	}
	
	function zoacresMetaCategory(){
		$categories = get_the_category(); 
		$output = '';
		if ( ! empty( $categories ) ){
			$output = '<div class="post-category"><span class="before-icon fa fa-folder-o theme-color"></span>';
			foreach ( $categories as $category ) {
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>, ';
			}
			$output = rtrim( $output, ', ' );
			$output .= '</div>';
		}
		return $output;
	}
	
	function zoacresMetaTags(){
		$tags = get_the_tags(); 
		$output = '';
		if ( ! empty( $tags ) ){
			$output = '<div class="post-tags"><span class="before-icon fa fa-tags theme-color"></span>'; 
			foreach ( $tags as $tag ) {
				$output .= '<a href="' . esc_url( get_category_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>,';
			}
			$output = rtrim( $output, ',' );
			$output .= '</div>';
		}
		return $output;
	}
	
	function zoacresMetaSocial(){
		ob_start();
		$posts_shares = $this->zoacresThemeOpt( 'post-social-shares' );
		$post_id = get_the_ID();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id), 'large' );
		?>
		<div class="post-social">
			<ul class="nav social-icons">
				<?php 
				if( $posts_shares ):
					foreach ( $posts_shares as $social_share ){
			
						switch( $social_share ){
						
							case "fb": 
						?>
								<li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink( $post_id ) ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="blank" class="social-fb share-fb"><i class="fa fa-facebook"></i></a></li>
							
						<?php
							break; // fb
							case "twitter":
						?>
					
								<li><a href="http://twitter.com/home?status=Reading:<?php echo urlencode(get_the_title()); ?>-<?php echo  esc_url( home_url( '/' ) )."/?p=". esc_attr( $post_id ); ?>" class="social-twitter share-twitter" title="<?php esc_attr_e( 'Click to send this page to Twitter!', 'zoacres' ); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
					
						<?php
							break; // twitter
							case "linkedin":
						?>
					
								<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( the_permalink() ); ?>&title=<?php echo urlencode( get_the_title() ); ?>&summary=&source=<?php echo urlencode( get_bloginfo('name') ); ?>" class="social-linkedin share-linkedin" target="blank"><i class="fa fa-linkedin"></i></a></li>
					
						<?php
							break; // linkedin
							
							case "pinterest":
						?>
					
							<li><a href="http://pinterest.com/pin/create/button/?url=<?php urlencode( the_permalink() ); ?>&amp;media=<?php echo ( ! empty( $image[0] ) ? $image[0] : '' ); ?>&description=<?php echo urlencode(get_the_title()); ?>" class="social-pinterest share-pinterest" target="blank"><i class="fa fa-pinterest"></i></a></li>
					
						<?php
							break; // pinterest
						?>
					
				<?php 
						} //switch
					} // foreach
					
				endif;
				?>

			</ul>
		</div>
		<?php
			$output = ob_get_clean(); 
			return $output;
	}
	
	function zoacresPostMeta($meta_place){
		$zoacres_options = $this->zoacres_options;
		$template = self::$c_template;
		$postID = get_the_ID();
		
		$post_metas = array( 'Left' => 'pull-left', 'Right' => 'pull-right' );
		foreach( $post_metas as $meta => $class ){

			$meta_elements = isset( $zoacres_options[$template .'-'. $meta_place .'-items'][$meta] ) ? $zoacres_options[$template .'-'. $meta_place .'-items'][$meta] : array();
			if( array_key_exists( "placebo", $meta_elements ) ) unset( $meta_elements['placebo'] );
			if( $meta_elements ): ?>
				<div class="post-meta <?php echo esc_attr( $class ); ?>">
					<ul class="nav">
					<?php
					foreach ( $meta_elements as $element => $value ) {
						switch($element) {
							case 'date':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaDate() );
								echo '</li>';
							break;
							
							case 'category':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaCategory() );
								echo '</li>';
							break;
							
							case 'social':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaSocial() );
								echo '</li>';
							break;
							
							case 'comments':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaComment() );
								echo '</li>';
							break;
							
							case 'likes':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaLikes($postID) );
								echo '</li>';
							break;
							
							case 'author':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaAuthor() );
								echo '</li>';
							break;
							
							case 'views':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaViews() );
								echo '</li>';
							break;
							
							case 'favourite':
								echo '<li class="nav-item">';
								echo ( ''. $this->zoacresMetaFavourite($postID) );
								echo '</li>';
							break; 
							
							case 'more':
								echo '<li class="nav-item">';
								$read_more_text = $this->zoacresThemeOpt($template.'-more-text');
								echo ( ''. $this->zoacresMetaMore($read_more_text) );
								echo '</li>';
							break;
							
							case 'tag':
								$tags = $this->zoacresMetaTags();
								if( $tags ):
								echo '<li class="nav-item">';
									echo ( ''. $tags );
								echo '</li>';
								endif;
							break;
							
						}//post meta items switch
					}
				?>
					</ul>
				</div>
				<?php
			endif;
		}
	}
	
	function zoacresVideoFormat( $video_atts ){

		extract( $video_atts );
		switch( $video_modal ){
		
			case 'onclick':
				$video_url = '';
				if( $video_type == 'youtube' ){
					$video_url = 'https://www.youtube.com/embed/';
					$video_url .= esc_attr( $video_id );
				}elseif( $video_type == 'vimeo' ){
					$video_url = 'https://player.vimeo.com/video/';
					$video_url .= esc_attr( $video_id );
				}else{
					$video_url = esc_url( $video_id );
				}

				if( $video_type != 'custom' ){ ?>
					<a class="onclick-video-post" href="<?php echo esc_url( $video_url ); ?>">
						<div class="video-play-icon text-center"><span class="fa fa-play-circle"></span></div>
						<?php 
							if( '' !== get_the_post_thumbnail() ):
								the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) );
							endif;
						?>
					</a>
				<?php
				}else{
				?>
					<a class="onclick-custom-video" href="#" data-url="<?php echo esc_url( $video_url ); ?>">
						<div class="video-play-icon text-center"><span class="fa fa-play-circle"></span></div>
						<?php 
							if( '' !== get_the_post_thumbnail() ):
								the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) ); 
							endif;
						?>
					</a>
					<?php
				}
			break;
			
			case 'overlay': 
				$video_url = '';
				if( $video_type == 'youtube' ){
					$video_url = 'http://www.youtube.com/watch?v=';
					$video_url .= esc_attr( $video_id );
				}elseif( $video_type == 'vimeo' ){
					$video_url = 'https://vimeo.com/';
					$video_url .= esc_attr( $video_id );
				}else{
					$video_url = esc_url( $video_id );
				}
			
				if( $video_type != 'custom' ){ ?>
					<a class="popup-video-post" href="<?php echo esc_url( $video_url ); ?>">
						<div class="video-play-icon text-center"><span class="fa fa-play-circle"></span></div>
						<?php 
							if( '' !== get_the_post_thumbnail() ):
								the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) ); 
							endif;
						?>
					</a>
				<?php
				}else{
					$u_key = $this->zoacresUniqueKey();
				?>
					<a class="popup-video-post popup-with-zoom-anim popup-custom-video" href="#popup-custom-video-<?php echo esc_attr( $u_key ); ?>">
						<div class="video-play-icon text-center"><span class="fa fa-play-circle"></span></div>
						<?php 
							if( '' !== get_the_post_thumbnail() ):
								the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) ); 
							endif;
						?>
					</a>
					<div id="popup-custom-video-<?php echo esc_attr( $u_key ); ?>" class="zoom-anim-dialog mfp-hide">
						<span data-url="<?php echo esc_url( $video_url ); ?>"></span>
					</div>
					<?php
				}
			break;
			
			default: 
				$video_url = '';
				if( $video_type == 'youtube' ){
					$video_url = 'https://www.youtube.com/embed/';
					$video_url .= esc_attr( $video_id );
				}elseif( $video_type == 'vimeo' ){
					$video_url = 'https://player.vimeo.com/video/';
					$video_url .= esc_attr( $video_id );
				}else{
					$video_url = esc_url( $video_id );
				}
				
				if( $video_type != 'custom' ){
					echo do_shortcode( '[videoframe url="'. esc_url( $video_url ).'" width="100%" height="100%" params="byline=0&portrait=0&badge=0" /]' );
				}else{
					echo do_shortcode( '[video url="'. esc_url( $video_url ).'" width="100%" height="100%" /]' );
				}
			break;
		}
	}
	
	function zoacresGalleryFormat(){
		
		$template = self::$c_template;
			
		$gallery_ids = get_post_meta( get_the_ID(), 'zoacres_post_gallery', true );
		if( $gallery_ids ):
			$gallery_array = explode( ",", $gallery_ids );
			$slide_id = '';
			
			$slide_template = 'blog';
			if( is_single() ) $slide_template = 'single';

			$gal_atts = array(
				'data-loop="'. $this->zoacresThemeOpt( $slide_template.'-slide-infinite' ) .'"',
				'data-margin="'. $this->zoacresThemeOpt( $slide_template.'-slide-margin' ) .'"',
				'data-center="'. $this->zoacresThemeOpt( $slide_template.'-slide-center' ) .'"',
				'data-nav="'. $this->zoacresThemeOpt( $slide_template.'-slide-navigation' ) .'"',
				'data-dots="'. $this->zoacresThemeOpt( $slide_template.'-slide-pagination' ) .'"',
				'data-autoplay="'. $this->zoacresThemeOpt( $slide_template.'-slide-autoplay' ) .'"',
				'data-items="'. $this->zoacresThemeOpt( $slide_template.'-slide-items' ) .'"',
				'data-items-tab="'. $this->zoacresThemeOpt( $slide_template.'-slide-tab' ) .'"',
				'data-items-mob="'. $this->zoacresThemeOpt( $slide_template.'-slide-mobile' ) .'"',
				'data-duration="'. $this->zoacresThemeOpt( $slide_template.'-slide-duration' ) .'"',
				'data-smartspeed="'. $this->zoacresThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',
				'data-scrollby="'. $this->zoacresThemeOpt( $slide_template.'-slide-scrollby' ) .'"',
				'data-autoheight="'. $this->zoacresThemeOpt( $slide_template.'-slide-autoheight' ) .'"',
			);
			$data_atts = implode( " ", $gal_atts );
			$gallery_modal = $this->zoacresCheckMetaValue( 'zoacres_post_gallery_modal', $template.'-gallery-format' );
			if( $gallery_modal == 'default' ): // Gallery Model Default
				?>
				<div class="owl-carousel" <?php echo ( ''. $data_atts ); ?>>
				<?php
				foreach( $gallery_array as $gal_id ): ?>
					<div class="item">
						<?php echo wp_get_attachment_image( $gal_id, $this->thumb_guess, "", array( "class" => "img-fluid" ) ); ?>
					</div>
				<?php
				endforeach;?>
				</div><!-- .owl-carousel -->
			<?php
			elseif( $gallery_modal == 'popup' ): // Gallery Model Popup
				?>
				<div class="zoom-gallery">
					<div class="owl-carousel" <?php echo ( ''. $data_atts ); ?>>
					<?php
					foreach( $gallery_array as $gal_id ): ?>
						<div class="item">
								<?php $image_url = wp_get_attachment_url( $gal_id ); ?>
								<a href="<?php echo esc_url( $image_url ); ?>" title="<?php echo esc_attr( get_the_title( $gal_id ) ); ?>">
									<?php $t = wp_get_attachment_image( $gal_id, $this->thumb_guess, "", array( "class" => "img-fluid" ) ); 
										if( $t ){
											echo wp_kses_post( $t );
										}else{
											echo esc_html__( 'Image Crop not exists.', 'zoacres' );
										}
									?>
								</a>
						</div>
					<?php
					endforeach;?>
					</div><!-- .owl-carousel -->
				</div><!-- .zoom-gallery -->
			<?php
			else: // Gallery Model Grid Popup
			?>
				<div class="zoom-gallery grid-zoom-gallery clearfix">
					<?php
					$chk = 1;
					foreach( $gallery_array as $gal_id ): 
						if( $chk ): echo '<div class="left-gallery-grid">'; endif;
						?>
							<div class="grid-popup">
								<?php $image_url = wp_get_attachment_url( $gal_id ); ?>
								<a href="<?php echo esc_url( $image_url ); ?>" title="<?php echo esc_attr( get_the_title( $gal_id ) ); ?>">
									<?php echo wp_get_attachment_image( $gal_id, $this->thumb_guess, "", array( "class" => "img-fluid" ) ); ?>
								</a>
							</div>
					<?php
						if( $chk ): echo '</div><!-- .left-gallery-grid --><div class="right-gallery-grid">';  $chk = 0; endif;
					endforeach;
					?>
					</div><!-- .right-gallery-grid -->
				</div><!-- .zoom-gallery -->
				<?php
			endif;
		endif;
	}
	
	function zoacresLinkFormat(){
		$link_text = get_post_meta( get_the_ID(), 'zoacres_post_link_text', true );
		$link = get_post_meta( get_the_ID(), 'zoacres_post_extrenal_link', true );
		$thumbnail = '' !== get_the_post_thumbnail() ? get_the_post_thumbnail_url() : '';
		if( !empty( $link_text ) ):
		?>
			<div class="post-link-wrap" data-url="<?php echo esc_url( $thumbnail ); ?>">
				<div class="post-link-inner">
					<h4><a href="<?php echo esc_url( $link ); ?>" class="post-link" title="<?php echo esc_attr( $link_text ); ?>"><?php echo esc_html( $link_text ); ?></a></h4>
				</div>
			</div>
		<?php
		endif;
	}
	
	function zoacresQuoteFormat(){
		$quote_text = get_post_meta( get_the_ID(), 'zoacres_post_quote_text', true );
		$quote_author = get_post_meta( get_the_ID(), 'zoacres_post_quote_author', true );
		$thumbnail = '' !== get_the_post_thumbnail() ? get_the_post_thumbnail_url() : '';
		if( !empty( $quote_text ) ):
		?>
			<div class="post-quote-wrap" data-url="<?php echo esc_url( $thumbnail ); ?>">
				<blockquote class="blockquote">
					<p class="mb-0"><h4><?php echo esc_html( $quote_text ); ?></h4></p>
					<footer class="blockquote-footer"><?php echo esc_html( $quote_author ); ?></footer>
				</blockquote>
			</div>
		<?php
		endif;
	}
	
	function zoacresAudioFormat(){
		$audio_type = get_post_meta( get_the_ID(), 'zoacres_post_audio_type', true );
		$audio_id = get_post_meta( get_the_ID(), 'zoacres_post_audio_id', true );
		if( !empty( $audio_type ) && !empty( $audio_id ) ): ?>
			<div class="post-audio-wrap">
				<?php if( $audio_type == 'soundcloud' ): ?>
						<?php echo do_shortcode('[soundcloud url="https://api.soundcloud.com/tracks/'. esc_attr( $audio_id ) .'" params="auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true" width="100%" height="150" /]'); ?>
				<?php else: ?>
					<audio preload="none" controls style="max-width:100%;">
						<source src="<?php echo esc_url( $audio_id ); ?>" type="audio/mp3">
					</audio>
				<?php endif; ?>
			</div>
		<?php
		endif;
	}
	
	function zoacresPostFormat(){

		$template = self::$c_template;
		ob_start();
		
		if ( has_post_format( 'image' ) && '' !== get_the_post_thumbnail() ) :
		?>
			<div class="post-thumb-wrap">
				<?php echo the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) ); ?>
				
				<?php if( is_single() ): 
					$theme_opt_overlay = $this->zoacresThemeOpt( 'single-post-overlay-opt' );
					$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
					if( $theme_opt_overlay == 1 || $post_oitems_opt == 1 ): ?>
				
					<div class="post-overlay-items"><?php
						$post_elements = array();
						$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
						if( $post_oitems_opt == '' || $post_oitems_opt == 'theme-default' ){
							$post_elements = $this->zoacresThemeOpt( 'single-post-overlay-items' );  
							$post_elements = $post_elements['Enabled'];  
							if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );      
						}else{
							$overlay_post_items = get_post_meta( get_the_ID(), 'zoacres_post_overlay_items', true );
							$t_post_items = explode( ',', $overlay_post_items );
							foreach ( $t_post_items as $element ) 
								$post_elements[$element] = $element;
						}
						$this->zoacresPostOverlayItems( $post_elements );?>
					</div>
				
					<?php endif;
				endif; ?>
								
			</div>
		<?php
		
		elseif ( has_post_format( 'video' ) ) :
			$video_type = get_post_meta( get_the_ID(), 'zoacres_post_video_type', true );
			$video_id = get_post_meta( get_the_ID(), 'zoacres_post_video_id', true );
			if( !empty( $video_type ) ):
				
				$video_modal = '';
				if( is_single() ){
					$video_modal = $this->zoacresCheckMetaValue( 'zoacres_post_video_modal', $template.'-video-format' );
				}else{
					$video_modal = $this->zoacresThemeOpt($template.'-video-format');
				}

				$video_atts = array(
					'video_type'	=> $video_type,
					'video_id'		=> $video_id,
					'video_modal'	=> $video_modal
				);
			?>
				<div class="post-video-wrap">
					<?php $this->zoacresVideoFormat( $video_atts ); ?>
				</div>
			<?php
			endif;
		
		elseif ( has_post_format( 'gallery' ) ) :
			$this->zoacresGalleryFormat();
		
		elseif ( has_post_format( 'audio' ) ) :
			$this->zoacresAudioFormat();
		
		elseif ( has_post_format( 'quote' ) ) :
			$this->zoacresQuoteFormat();
		
		elseif ( has_post_format( 'link' ) ) :
			$this->zoacresLinkFormat();
		elseif( get_the_post_thumbnail() ) :
		?>
			<div class="post-thumb-wrap">
				<?php echo the_post_thumbnail( $this->thumb_guess, array( 'class' => 'img-fluid' ) ); ?>
				
				<?php if( is_single() ): 

					$theme_opt_overlay = $this->zoacresThemeOpt( 'single-post-overlay-opt' );
					$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
					if( $theme_opt_overlay == 1 || $post_oitems_opt == 1 ): ?>
				
					<div class="post-overlay-items"><?php
						$post_elements = array();
						$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
						if( $post_oitems_opt == '' || $post_oitems_opt == 'theme-default' ){
							$post_elements = $this->zoacresThemeOpt( 'single-post-overlay-items' );  
							$post_elements = $post_elements['Enabled'];  
							if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );      
						}else{
							$overlay_post_items = get_post_meta( get_the_ID(), 'zoacres_post_overlay_items', true );
							$t_post_items = explode( ',', $overlay_post_items );
							foreach ( $t_post_items as $element ) 
								$post_elements[$element] = $element;
						}
						$this->zoacresPostOverlayItems( $post_elements );?>
					</div>
				
					<?php endif;
				endif; ?>
				
			</div><!-- .post-thumb-wrap -->
		<?php
		endif;
		
		
		if( !has_post_format( 'image' ) && is_single() && $this->zoacresCheckMetaValue( 'zoacres_post_overlay_opt', 'single-post-overlay-opt' ) == 1 ): ?>
			<div class="post-overlay-items">
			<?php
			
				$post_elements = array();
				$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
				if( $post_oitems_opt == '' || $post_oitems_opt == 'theme-default' ){
					$post_elements = $this->zoacresThemeOpt( 'single-post-overlay-items' );		
					$post_elements = $post_elements['Enabled'];		
					if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );						
				}else{
					$overlay_post_items = get_post_meta( get_the_ID(), 'zoacres_post_overlay_items', true );
					$t_post_items = explode( ',', $overlay_post_items );
					foreach ( $t_post_items as $element ) 
						$post_elements[$element] = $element;
				}
				$this->zoacresPostOverlayItems( $post_elements );
			?>
			</div>	
		<?php endif;
		
		//Overlay items for non single
		if( !is_single() && $this->zoacresThemeOpt( $template.'-overlay-opt' ) == 1 ): ?>	
			<div class="post-overlay-items">
				<?php
					$post_elements = array();
					$post_elements = $this->zoacresThemeOpt( $template.'-overlay-items' );		
					$post_elements = $post_elements['Enabled'];	
					if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );						
					$this->zoacresPostOverlayItems( $post_elements );
				?>
			</div>
		<?php
		endif;		
		
		return ob_get_clean();
	}
	
	function zoacresPostOverlayItems( $post_elements ){

		foreach ( $post_elements as $element => $value ) {
			switch($element) {
			
				case 'title':
					if( get_the_title() ){
				?>
					<header class="entry-header">
						<?php echo ( ''. $this->zoacresPostTitle( 'standard' ) ); ?>
					</header>
				<?php	
					}							
				break;
				
				case 'top-meta':
				?>
					<div class="entry-meta top-meta clearfix">
						<?php $this->zoacresPostMeta( 'topmeta' ); ?>
					</div>
				<?php
				break;
				
				case 'bottom-meta':
				?>
					<footer class="entry-footer">
						<div class="entry-meta bottom-meta clearfix">
							<?php $this->zoacresPostMeta( 'bottommeta' ); ?>
						</div>
					</footer>
				<?php
				break;
				
				
			} // switch					
		} //foreach 
		
	}
	
	function zoacresPostItems(){
		$zoacres_options = $this->zoacres_options;
		
		$template = self::$c_template;
		$top_standard = self::$top_standard;
		
		$layout = $this->zoacresGetCurrentLayout();
		$extra_class = $layout == 'list-layout' ? ' clearfix' : '';
		$post_elements = isset( $zoacres_options[$template .'-items']['Enabled'] ) ? $zoacres_options[$template .'-items']['Enabled'] : array();
		if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );
		if( $post_elements ): ?>
			<div class="article-inner post-items<?php echo esc_attr( $extra_class ); ?>">
				<?php
									
					$format = get_post_format( get_the_ID() );
					if( isset( $post_elements['thumb'] ) && $layout == 'list-layout' && !$top_standard ): ?>
						
					<?php
							$post_format = $this->zoacresPostFormat();
							if( !empty( $post_format  ) ){
							?>
								<div class="post-list-left-part">
									<div class="post-format-wrap">
										<?php echo ( ''. $post_format ); ?>
									</div>
								</div><!-- .post-list-left-part -->
							<?php
							}
					?>
						
						<div class="post-list-right-part">
					<?php
					elseif( $layout == 'list-layout' ):
						$list_class = empty( $format ) ? ' post-list-full' : '';
					?>
						<div class="post-list-right-part<?php echo esc_attr( $list_class ); ?>">
					<?php
					endif; // list-layout endif
					
				foreach ( $post_elements as $element => $value ) {
					switch($element) {
					
						case 'title':
							if( get_the_title() ){
							$layout = $this->zoacresThemeOpt($template.'-post-template');
						?>
							<header class="entry-header">
								<?php echo ( ''. $this->zoacresPostTitle($layout) ); ?>
							</header>
						<?php		
							}							
						break;
						
						case 'top-meta':
						?>
							<div class="entry-meta top-meta clearfix">
								<?php $this->zoacresPostMeta('topmeta'); ?>
							</div>
						<?php
						break;
						
						case 'thumb':
							if( ( $layout != 'list-layout' && $layout != 'list' ) || $top_standard ):
								$post_format = $this->zoacresPostFormat();
								if( !empty( $post_format  ) ){
								?>
									<div class="post-format-wrap">
										<?php echo ( ''. $post_format ); ?>
									</div>
								<?php
								}
							endif;
						break;
						
						case 'content':
						
							if( '' !== get_the_content() ) {
						?>
								<div class="entry-content">
									<?php 
									if( !is_single() ):
										the_excerpt();
									else:
										the_content();
										
										wp_link_pages( array(
											'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'zoacres' ),
											'after'       => '</div>',
											'link_before' => '<span class="page-number">',
											'link_after'  => '</span>',
										) );
										
									endif;
									
									?>
								</div>
						<?php
							}
						break;
						
						case 'bottom-meta':
						?>
							<footer class="entry-footer">
								<div class="entry-meta bottom-meta clearfix">
									<?php $this->zoacresPostMeta('bottommeta'); ?>
								</div>
							</footer>
						<?php
						break;
						
						
					} // switch					
				} //foreach ?>
				<?php if( $layout == 'list-layout' ): ?>
					</div><!-- post-list-right-part -->
				<?php endif; ?>
			</div>
		<?php
		endif;
	}
	
	function zoacresWpBootstrapPagination( $args = array(), $max = '', $print = true ) {
    	
		
		
		$defaults = array(
			'range'           => 4,
			'custom_query'    => false,
			'first_string' => esc_html__( 'First', 'zoacres' ),
			'previous_string' => esc_html__( 'Prev', 'zoacres' ),
			'next_string'     => esc_html__( 'Next', 'zoacres' ),
			'last_string'     => esc_html__( 'Last', 'zoacres' ),
			'before_output'   => '<div class="post-pagination-wrap"><ul class="nav pagination post-pagination justify-content-center">',
			'after_output'    => '</ul></div>'
		);
		
		$args = wp_parse_args( 
			$args, 
			apply_filters( 'zoacres_wp_bootstrap_pagination_defaults', $defaults )
		);
		
		 
		$args['range'] = (int) $args['range'] - 1;
		if ( !$args['custom_query'] ){
			$args['custom_query'] = $GLOBALS['wp_query'];
		}
		$count = (int) $args['custom_query']->max_num_pages;
		$count = absint( $count ) ? absint( $count ) : (int) $max;
		$page  = 1;
		if ( get_query_var( 'paged' ) ) { $page = get_query_var( 'paged' ); }
		elseif ( get_query_var( 'page' ) ) { $page = get_query_var( 'page' ); }
		
		$ceil  = ceil( $args['range'] / 2 );
		
		if ( $count <= 1 )
			return FALSE;
		
		if ( !$page )
			$page = 1;
		
		if ( $count > $args['range'] ) {
			if ( $page <= $args['range'] ) {
				$min = 1;
				$max = $args['range'] + 1;
			} elseif ( $page >= ($count - $ceil) ) {
				$min = $count - $args['range'];
				$max = $count;
			} elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
				$min = $page - $ceil;
				$max = $page + $ceil;
			}
		} else {
			$min = 1;
			$max = $count;
		}
		
		$echo = '';
		$previous = intval($page) - 1;
		$previous = esc_attr( get_pagenum_link($previous) );
		
		// For theme check
		$t_next_post_link = get_next_posts_link();
		$t_prev_post_link = get_previous_posts_link();
		
		$firstpage = esc_attr( get_pagenum_link(1) );
		if ( $firstpage && (1 != $page) && isset( $args['first_string'] ) && $args['first_string'] != '' )
			$echo .= '<li class="nav-item previous"><a href="' . $firstpage . '" title="' . esc_attr__( 'First', 'zoacres') . '">' . $args['first_string'] . '</a></li>';
		if ( $previous && (1 != $page) )
			$echo .= '<li class="nav-item"><a href="' . $previous . '" title="' . esc_attr__( 'previous', 'zoacres') . '">' . $args['previous_string'] . '</a></li>';
		
		if ( !empty($min) && !empty($max) ) {
			for( $i = $min; $i <= $max; $i++ ) {
				if ($page == $i) {
					$echo .= '<li class="nav-item active"><span class="active">' . esc_html( absint( $i ) ) . '</span></li>';
				} else {
					$echo .= sprintf( '<li class="nav-item"><a href="%1$s">%2$d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
				}
			}
		}
		
		$next = intval($page) + 1;
		$next = esc_attr( get_pagenum_link($next) );
		if ($next && ($count != $page) )
			$echo .= '<li class="nav-item"><a href="' . $next . '" class="next-page" title="' . esc_attr__( 'next', 'zoacres') . '">' . $args['next_string'] . '</a></li>';
		
		$lastpage = esc_attr( get_pagenum_link($count) );
		if ( $lastpage && isset( $args['last_string'] ) && $args['last_string'] != '' ) {
			$echo .= '<li class="nav-item next"><a href="' . $lastpage . '" title="' . esc_attr__( 'Last', 'zoacres') . '">' . $args['last_string'] . '</a></li>';
		}
		if ( isset($echo) && $print ){
			echo ( ''. $args['before_output'] . $echo . $args['after_output'] );
		}else{
			return $args['before_output'] . $echo . $args['after_output'];
		}
	}
	
	function zoacresCommentIDVerify( $comment_id )
	{
		// Retrieve post votes IPs
		$meta_IP = get_comment_meta( $comment_id, 'comment_voted_IP', true );
		if( isset( $meta_IP ) && is_array( $meta_IP ) ){
			// Retrieve current user IP
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';

			// If user has already voted
			if( array_key_exists($ip, $meta_IP) ){
				return true;
			}else{
				return false;
			}
		}
		 
		return false;
	}
	
	function zoacresCommentsLike()
	{
		// Check for nonce security
		$nonce = sanitize_text_field($_POST['nonce']);
		if ( ! wp_verify_nonce( $nonce, 'zoacres-comment-like' ) )
			die ( esc_html__( 'Busted', 'zoacres' ) );
		 
		if(isset($_POST['cmt_id']))
		{
			// Retrieve user IP address
			$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';

			$comment_id = isset( $_POST['cmt_id'] ) ? esc_attr( $_POST['cmt_id'] ) : '';
			$comment_meta = isset( $_POST['cmt_meta'] ) ? esc_attr( $_POST['cmt_meta'] ) : '1';
			
			
			// Get voters'IPs for the current post
			$meta_IP = get_comment_meta( $comment_id, 'comment_voted_IP', true );
			 
			// Get votes count for the current post
			$meta_key = '';
			$meta_count = 0;
			if( $comment_meta == '1' ){
				$meta_key = 'comment_like_count';
				$meta_count = get_comment_meta( $comment_id, 'comment_like_count', true );
			}else{
				$meta_key = 'comment_dislike_count';
				$meta_count = get_comment_meta( $comment_id, 'comment_dislike_count', true );
			}
	 
			// Use has already voted ?
			if( !$this->zoacresCommentIDVerify( $comment_id ) )
			{
				if( isset( $meta_IP ) && is_array( $meta_IP ) ){
					if( $comment_meta == '1' ){
						$meta_IP[$ip] = 'like';
					}else{
						$meta_IP[$ip] = 'dislike';
					}
				}else{
					if( $comment_meta == '1' ){
						$meta_IP = array( $ip => 'like' );
					}else{
						$meta_IP = array( $ip => 'dislike' );
					}
				}
				$meta_count = $meta_count != '' ? $meta_count : 0;
				// Save IP and increase votes count
				update_comment_meta( $comment_id, "comment_voted_IP", $meta_IP );
				update_comment_meta( $comment_id, $meta_key, ++$meta_count );
	
				// Display count (ie jQuery return value)
				echo ( ''. $this->zoacresCommentLikeOut( $comment_id ) );
			}else{
				
				$like_count = get_comment_meta( $comment_id, 'comment_like_count', true );
				$dislike_count = get_comment_meta( $comment_id, 'comment_dislike_count', true );
				
				if( $comment_meta == '1' ){
					if( $meta_IP[$ip] == 'dislike' ){
						//echo 'going to like'; 
						$meta_IP[$ip] = 'like';
						update_comment_meta( $comment_id, "comment_voted_IP", $meta_IP );
						update_comment_meta( $comment_id, 'comment_dislike_count', --$dislike_count );
						update_comment_meta( $comment_id, 'comment_like_count', ++$like_count );
						echo ( ''. $this->zoacresCommentLikeOut( $comment_id ) );
					}else{
						echo "already liked";
					}
				}else{
					if( $meta_IP[$ip] == 'like' ){
						//echo 'going to dislike';
						$meta_IP[$ip] = 'dislike';
						update_comment_meta( $comment_id, "comment_voted_IP", $meta_IP );
						update_comment_meta( $comment_id, 'comment_like_count', --$like_count );
						update_comment_meta( $comment_id, 'comment_dislike_count', ++$dislike_count );
						echo ( ''. $this->zoacresCommentLikeOut( $comment_id ) );
					}else{
						echo "already disliked";
					}
				}
				
			}
		}
		exit;
	}
	
	function zoacresCommentLikeOut( $comment_id )
	{
		$output = '';
		$meta_IP = get_comment_meta( $comment_id, 'comment_voted_IP', true );
		//print_r($meta_IP);
		$ip = class_exists( "ZoacresRedux" ) ? zoacres_get_remote_ip() : '1';
		
		$meta_count = get_comment_meta( $comment_id, 'comment_like_count', true );
		$meta_dcount = get_comment_meta( $comment_id, 'comment_dislike_count', true );
		$output .= '<ul class="nav comments-like-nav">';
		if( $this->zoacresCommentIDVerify( $comment_id ) ){
			if( $meta_IP[$ip] == 'like' ){
				$output .= '<li><span class="fa fa-thumbs-up comment-liked theme-color" data-id="1" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_count .'</li><li><span class="icon-dislike comment-like" data-id="2" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_dcount .'</li>';
			}else{
				$output .= '<li><span class="icon-like comment-like" data-id="1" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_count .'</li><li><span class="fa fa-thumbs-down comment-liked theme-color" data-id="2" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_dcount .'</li>';
			}
		}else{
			$output .= '<li><span class="icon-like comment-like" data-id="1" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_count .'</li><li><span class="icon-dislike comment-like" data-id="2" data-cmt-id="'. esc_attr( $comment_id ) .'"></span> '. $meta_dcount .'</li>';
		}
		$output .= '</ul>';
		return $output;
	}
	
	function zoacresCommentShare( $comment_id ){
		$output = '';
		$comments_shares = $this->zoacresThemeOpt( 'comments-social-shares' );
		ob_start();
	?>
		<ul class="nav comments-share social-icons social-circle">
			<?php foreach ( $comments_shares as $social_share ){
			
					switch( $social_share ){
					
						case "fb": 
					?>
							<li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_comment_link( $comment_id ) ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="blank" class="social-fb share-fb"><i class="fa fa-facebook"></i></a></li>
						
					<?php
						break; // fb
						case "twitter":
					?>
				
							<li><a href="http://twitter.com/home?status=Reading:<?php echo urlencode( get_the_title() ); ?>-<?php echo urlencode(  get_comment_link( $comment_id ) ); ?>" class="social-twitter share-twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
				
					<?php
						break; // twitter
						case "linkedin":
					?>
				
							<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_comment_link( $comment_id ) ); ?>&title=<?php echo urlencode( get_the_title() ); ?>&summary=&source=<?php echo urlencode( get_bloginfo('name') ); ?>" class="social-linkedin share-linkedin" target="_new"><i class="fa fa-linkedin"></i></a></li>
				
					<?php
						break; // linkedin
						
						case "pinterest":
					?>
				
						<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_comment_link( $comment_id ) ); ?>&description=<?php echo urlencode( get_the_title() ); ?>" class="social-pinterest share-pinterest" target="blank"><i class="fa fa-pinterest"></i></a></li>
				
					<?php
						break; // pinterest
					?>
				
			<?php 
					} //switch
				} // foreach?>
		</ul>
	<?php 
		$output .= ob_get_clean();
		return $output;
	}
}

class ZoacresFooterElements extends ZoacresThemeOpt {
	
	private $zoacres_options;
	
	function __construct() {
		$this->zoacres_options = parent::$zoacres_option;
    }
	
	function zoacresFooterLayout(){
		$zoacres_options = $this->zoacres_options;
		$footer_class = '';
		if( zoacres_po_exists() ){
			if( $this->zoacresCheckMetaValue( 'zoacres_page_hidden_footer', 'hidden-footer' ) == 1 )
				$footer_class .= ' footer-fixed';
			
			if( $this->zoacresCheckMetaValue( 'zoacres_page_footer_layout', 'footer-layout' ) == 'boxed' )
				$footer_class .= ' boxed-container';
		}elseif( is_single() ){
			if( $this->zoacresCheckMetaValue( 'zoacres_post_hidden_footer', 'hidden-footer' ) == 1 )
				$footer_class .= ' footer-fixed';
			
			if( $this->zoacresCheckMetaValue( 'zoacres_post_footer_layout', 'footer-layout' ) == 'boxed' )
				$footer_class .= ' boxed-container';
		}else{
			if( $this->zoacresThemeOpt('hidden-footer') == 1 )
				$footer_class .= ' footer-fixed';
			
			if( $this->zoacresThemeOpt('footer-layout') == 'boxed' )
				$footer_class .= ' boxed-container';
		}
		echo esc_attr( $footer_class );
	}
	
	function zoacresFooterTopElements(){
	
		$boxed = $this->zoacresThemeOpt('footer-top-container');
		$container = $boxed == 'wide' ? 'container-fluid' : 'container';
	
	?>
		<div class="footer-top-wrap">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="row">	
	<?php
		$layout = ''; $page_opt_stat = 0;
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_footer_top_layout_opt', true );
			if( $post_items_opt == 'custom' ){
				$page_opt_stat = 1;
				$layout = $this->zoacresCheckMetaValue( 'zoacres_page_footer_top_layout', 'footer-top-layout' );
			}else{
				$layout = $this->zoacresThemeOpt('footer-top-layout');
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_footer_top_layout_opt', true );
			if( $post_items_opt == 'custom' ){
				$page_opt_stat = 1;
				$layout = $this->zoacresCheckMetaValue( 'zoacres_post_footer_top_layout', 'footer-top-layout' );
			}else{
				$layout = $this->zoacresThemeOpt('footer-top-layout');
			}
		}else{
			$layout = $this->zoacresThemeOpt('footer-top-layout');
		}
		$cols = preg_split("/[\s-]+/", $layout);
		$i = 1;
		foreach( $cols as $col ){
			
			$sidebar = '';
			if( $page_opt_stat ){
				if( zoacres_po_exists() ){
					$sidebar = $this->zoacresCheckMetaValue( 'zoacres_page_footer_top_sidebar_'.$i, 'footer-top-sidebar-'.$i );
				}elseif( is_single() ){
					$sidebar = $this->zoacresCheckMetaValue( 'zoacres_post_footer_top_sidebar_'.$i, 'footer-top-sidebar-'.$i );
				}else{
					$sidebar = $this->zoacresThemeOpt('footer-top-sidebar-'.$i);
				}
				$i++;
			}else{
				$sidebar = $this->zoacresThemeOpt('footer-top-sidebar-'.$i++);
			}
			
			if ( is_active_sidebar( $sidebar ) ) : ?>
			<div class="col-lg-<?php echo absint( $col ); ?>">
				<div class="footer-top-sidebar">
					<?php dynamic_sidebar( $sidebar ); ?>
				</div>
			</div>
			<?php endif; ?>
		<?php } ?>
				</div>
			</div>
		</div>
	<?php
	}
	
	function zoacresFooterMiddleElements(){
	
		$boxed = $this->zoacresThemeOpt('footer-middle-container');
		$container = $boxed == 'wide' ? 'container-fluid' : 'container';
		ob_start();
	
		$layout = ''; $page_opt_stat = 0;
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_footer_middle_layout_opt', true );
			if( $post_items_opt == 'custom' ){
				$page_opt_stat = 1;
				$layout = $this->zoacresCheckMetaValue( 'zoacres_page_footer_middle_layout', 'footer-middle-layout' );
			}else{
				$layout = $this->zoacresThemeOpt('footer-middle-layout');
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_footer_middle_layout_opt', true );
			if( $post_items_opt == 'custom' ){
				$page_opt_stat = 1;
				$layout = $this->zoacresCheckMetaValue( 'zoacres_post_footer_middle_layout', 'footer-middle-layout' );
			}else{
				$layout = $this->zoacresThemeOpt('footer-middle-layout');
			}
		}else{
			$layout = $this->zoacresThemeOpt('footer-middle-layout');
		}
		$cols = preg_split("/[\s-]+/", $layout);
		$i = 1;
		foreach( $cols as $col ){
			
			$sidebar = '';
			if( $page_opt_stat ){
				if( zoacres_po_exists() ){
					$sidebar = $this->zoacresCheckMetaValue( 'zoacres_page_footer_middle_sidebar_'.$i, 'footer-middle-sidebar-'.$i );
				}elseif( is_single() ){
					$sidebar = $this->zoacresCheckMetaValue( 'zoacres_post_footer_middle_sidebar_'.$i, 'footer-middle-sidebar-'.$i );
				}else{
					$sidebar = $this->zoacresThemeOpt('footer-middle-sidebar-'.$i);
				}
				$i++;
			}else{
				$sidebar = $this->zoacresThemeOpt('footer-middle-sidebar-'.$i++);
			}
						
			if ( is_active_sidebar( $sidebar ) ) : ?>
			<div class="col-lg-<?php echo absint( $col ); ?>">
				<div class="footer-middle-sidebar">
					<?php dynamic_sidebar( $sidebar ); ?>
				</div>
			</div>
			<?php endif; ?>
		<?php } 
		$footer_mid_out = ob_get_clean();
		$footer_mid_out = trim( $footer_mid_out );
		if( !empty( $footer_mid_out ) ):
		?>
			<div class="footer-middle-wrap">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">	
						<?php echo ( ''. $footer_mid_out ); ?>
					</div>
				</div>
			</div>
	<?php
		endif;
	}
	
	function zoacresFooterBottomElements( $key ){
		switch( $key ) {
			
			case 'social':
				echo ( ''. $this->zoacresSocial('footer-bottom-social', true) ); 
			break;
			
			case 'copyright':
				echo do_shortcode( $this->zoacresThemeOpt('copyright-text') );
			break;
		
			case 'menu':
				echo ( ''. $this->zoacresWPMenu('footer-menu', 'footer-menu') );
			break;
			
			case 'widget':
				$footer_bottom_widget = '';
				if( zoacres_po_exists() ){
					$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_footer_bottom_widget_opt', true );
					if( $post_items_opt == 'custom' ){
						$footer_bottom_widget = get_post_meta( get_the_ID(), 'zoacres_page_footer_bottom_widget', true );
					}else{
						$footer_bottom_widget = $this->zoacresThemeOpt('footer-bottom-widget');
					}
				}elseif( is_single() ){
					$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_footer_bottom_widget_opt', true );
					if( $post_items_opt == 'custom' ){
						$footer_bottom_widget = get_post_meta( get_the_ID(), 'zoacres_post_footer_bottom_widget', true );
					}else{
						$footer_bottom_widget = $this->zoacresThemeOpt('footer-bottom-widget');
					}
				}else{
					$footer_bottom_widget = $this->zoacresThemeOpt('footer-bottom-widget');
				}
				echo ( ''. $this->zoacresWidget( $footer_bottom_widget, 'footer-bottom-widget' ) );
			break;

		}
	}
	
	function zoacresFooterBottomParts(){
		$zoacres_options = $this->zoacres_options;
		$fb_parts = array( 'Left' => 'pull-left', 'Center' => 'pull-center', 'Right' => 'pull-right' );
		
		$fixed_class = '';
		if( zoacres_po_exists() ){
			if( $this->zoacresCheckMetaValue( 'zoacres_page_footer_bottom_fixed', 'footer-bottom-fixed' ) ){
				$fixed_class = ' footer-bottom-fixed';
			}
		}elseif( is_single() ){
			if( $this->zoacresCheckMetaValue( 'zoacres_post_footer_bottom_fixed', 'footer-bottom-fixed' ) ){
				$fixed_class = ' footer-bottom-fixed';
			}
		}else{
			$fixed_class = $this->zoacresThemeOpt('footer-bottom-fixed') ? ' footer-bottom-fixed' : '';
		}
		
		
		$boxed = $this->zoacresThemeOpt('footer-bottom-container');
		$container = $boxed == 'wide' ? 'container-fluid' : 'container';
		
	?>
		<div class="footer-bottom<?php echo esc_attr( $fixed_class ); ?>">
			<div class="footer-bottom-inner <?php echo esc_attr( $container ); ?>">
				<div class="row">
					<div class="col-md-12">
	<?php
	
		foreach( $fb_parts as $part => $class ){
			
			$fb_elements = '';
			if( zoacres_po_exists() ){
				$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_footer_bottom_items_opt', true );
				if( $post_items_opt == 'custom' ){
					$fb_elements_json = get_post_meta( get_the_ID(), 'zoacres_page_footer_bottom_items', true );
					$fb_elements = json_decode( stripslashes( $fb_elements_json ), true );
					$fb_elements = $fb_elements[$part];
				}else{
					$fb_elements = $zoacres_options['footer-bottom-items'][$part];
				}
			}elseif( is_single() ){
				$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_footer_bottom_items_opt', true );
				if( $post_items_opt == 'custom' ){
					$fb_elements_json = get_post_meta( get_the_ID(), 'zoacres_post_footer_bottom_items', true );
					$fb_elements = json_decode( stripslashes( $fb_elements_json ), true );
					$fb_elements = $fb_elements[$part];
				}else{
					$fb_elements = $zoacres_options['footer-bottom-items'][$part];
				}
			}else{
				$fb_elements = $zoacres_options['footer-bottom-items'][$part];
			}
			
			if( array_key_exists( "placebo", $fb_elements ) ) unset( $fb_elements['placebo'] );
			if ($fb_elements): 
			?>
				<ul class="footer-bottom-items nav <?php echo esc_attr( $class ); ?>">
			<?php foreach ($fb_elements as $element => $value ) {?>
					<li class="nav-item">
						<div class="nav-item-inner">
					<?php $this->zoacresFooterBottomElements($element); ?>
						</div>
					</li>
			<?php }	?>
				</ul>
			<?php
			endif;
		}
	?>				
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	
	function zoacresFooterElementsSwitch($key){
		switch( $key ) {
			
			case 'footer-top':
				$this->zoacresFooterTopElements();
			break;
			
			case 'footer-middle':
				$this->zoacresFooterMiddleElements();
			break;
		
			case 'footer-bottom':
				$this->zoacresFooterBottomParts();
			break;

		}
	}
	
	function zoacresFooterBacktoTop(){
		$back_to_top = $this->zoacresThemeOpt('back-to-top');
		if( $back_to_top == 1 ){ ?>
			<a href="#" class="back-to-top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
		<?php
		}
	}
	
	function zoacresFooterElements(){
	
		$footer_elements = '';
		if( zoacres_po_exists() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_page_footer_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$footer_elements_json = get_post_meta( get_the_ID(), 'zoacres_page_footer_items', true );
				$footer_elements = json_decode( stripslashes( $footer_elements_json ), true );
				$footer_elements = $footer_elements['Enabled'];
			}else{
				$zoacres_options = $this->zoacres_options;
				$footer_elements = $zoacres_options['footer-items']['Enabled'];
			}
		}elseif( is_single() ){
			$post_items_opt = get_post_meta( get_the_ID(), 'zoacres_post_footer_items_opt', true );
			if( $post_items_opt == 'custom' ){
				$footer_elements_json = get_post_meta( get_the_ID(), 'zoacres_post_footer_items', true );
				$footer_elements = json_decode( stripslashes( $footer_elements_json ), true );
				$footer_elements = $footer_elements['Enabled'];
			}else{
				$zoacres_options = $this->zoacres_options;
				$footer_elements = $zoacres_options['footer-items']['Enabled'];
			}
		}else{		
			$zoacres_options = $this->zoacres_options;
			$footer_elements = isset( $zoacres_options['footer-items']['Enabled'] ) ? $zoacres_options['footer-items']['Enabled'] : '';
		}		
		
		if( is_array( $footer_elements ) && array_key_exists( "placebo", $footer_elements ) ) unset( $footer_elements['placebo'] );
		if ($footer_elements): 
			foreach ($footer_elements as $element => $value ) {
				$this->zoacresFooterElementsSwitch($element);
			}
		endif;
	}
}

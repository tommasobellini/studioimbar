<?php
if( !class_exists( 'ZoacresProperty' ) ){
	class ZoacresProperty
	{

		public static $zoacres_option = '';
		public static $fav_properties;
		public static $cus_excerpt_len;

		public function __construct(){
			self::$zoacres_option = get_option( 'zoacres_options' );
			self::$fav_properties = array();
		}
		
		public static function zoacresPropertyStaticThemeOpt($field){
			$zoacres_options = self::$zoacres_option;
			return isset( $zoacres_options[$field] ) && $zoacres_options[$field] != '' ? $zoacres_options[$field] : '';
		}
		
		function zoacresPropertyThemeOpt($field){
			$zoacres_options = self::$zoacres_option;
			return isset( $zoacres_options[$field] ) && $zoacres_options[$field] != '' ? $zoacres_options[$field] : '';
		}
		
		function zoacresGetPropertyMetaValue( $meta_key ){
			$meta_value = get_post_meta( get_the_ID(), $meta_key, true );
			$property_meta = isset( $meta_value ) ? $meta_value : '';
			return $property_meta;
		}
		
		function zoacresGetFavProperties( $author_id ){
			$fav_properties = self::$fav_properties;
			$fav_final = $fav_properties;
			if( !empty( $fav_properties ) ){
				if( !array_key_exists( $author_id, $fav_properties ) ){
					$fav_array = get_user_meta( $author_id, 'zoacres_favourite_properties', true );
					if( $fav_array ){
						$fav_final = $fav_array;
						$fav_properties[$author_id] = $fav_array;
					}else{
						$fav_final = '';
					}
				}else{
					$fav_final = $fav_properties[$author_id];
				}
				
			}else{
				$fav_array = get_user_meta( $author_id, 'zoacres_favourite_properties', true );
				if( $fav_array ){
					$fav_final = $fav_array;
					$fav_properties[$author_id] = $fav_array;
				}else{
					$fav_final = '';
				}
			}
			
			//Finally Assign fav_properties for cache purpose
			self::$fav_properties = $fav_properties;
			
			return $fav_final;
		}
		
		function zoacresSetPropertyExcerptLength( $length ) {
			$excerpt_len = self::$cus_excerpt_len;
			$excerpt_len = $excerpt_len != '' ? $excerpt_len : 20;
			return $excerpt_len;
		}

	} new ZoacresProperty;
}

if( !class_exists( 'ZoacresPropertyElements' ) ){
	
	class ZoacresPropertyElements extends ZoacresProperty {

		private $zoacres_options;
		private $property_pagination;
		
		function __construct() {
			$this->zoacres_options = parent::$zoacres_option;
		}
		
		function zoacresGetPropertyUnits(){
			$units = $this->zoacresPropertyThemeOpt('property-measure-units');
			if( $units == 'custom' ){
				$units = $this->zoacresPropertyThemeOpt('property-measure-units-custom');
			}	
			return $units;	
		}
		
		function zoacresGetCheckboxGroupValues( $meta_id ){
			$gvalues = $this->zoacresGetPropertyMetaValue($meta_id);
			
			$output = '';
			if( !empty( $gvalues ) && is_array( $gvalues ) ){
				foreach( $gvalues as $group ){
					$output .= $group .', ';
				}
				$output = rtrim( $output, ", " );
			}
			
			return $output;
		}
		
		function zoacresSetRecentViewedProperty( $property_id ){
			global $current_user; 
			if ( $current_user ) {
				$recent_viewed = get_user_meta( $current_user->ID, 'zoacres_recent_viewed_properties' , true );
				$viewed_arr = array();
				if ( ! empty( $recent_viewed ) ){
					array_unshift( $recent_viewed, $property_id );
					$recent_viewed = array_unique( $recent_viewed );
					$viewed_arr = array_slice( $recent_viewed, 0, 20 );
				}else{
					$viewed_arr = array( $property_id );
				}
				$updated = update_user_meta( $current_user->ID, 'zoacres_recent_viewed_properties', $viewed_arr );
			}
		}
		
		function zoacresSetPropertyDaysViewsCount( $property_id ){

			$day_views = get_post_meta( $property_id, 'zoacres_properties_days_views' , true );

			$to_date = date("Y-m-d");
			if ( ! empty( $day_views ) && is_array( $day_views ) ){
				if( array_key_exists( $to_date, $day_views ) ){
					$old_views = $day_views[$to_date];
					$day_views[$to_date] = ++$old_views;
				}else{
					$day_views[$to_date] = '1';
				}
				$day_views = array_slice( $day_views, 0, 20 );
			}else{
				$day_views = array( $to_date => '1' );
			}
			$updated = update_post_meta( $property_id, 'zoacres_properties_days_views', $day_views );
		}

		
		function zoacresGetPropertyPrice( $price_ele, $parent = 'div' ){
			$output = '';
			$property_price = $this->zoacresGetPropertyMetaValue('zoacres_property_price');
			
			if( $property_price ):
			
				$price_sep = esc_attr( $this->zoacresPropertyThemeOpt('price-separator') );
				$decimal_char = esc_attr( $this->zoacresPropertyThemeOpt('price-decimal-char') );
				$decimal_len = esc_attr( $this->zoacresPropertyThemeOpt('price-decimals') );
				$decimal_len = $decimal_len == '' ? 0 : $decimal_len;
				
				$property_price = $property_price != '' && is_numeric( $property_price ) ? number_format( $property_price, $decimal_len, $decimal_char, $price_sep ) : '';
				
				$remv_chars = $decimal_char . "00";
				$property_price = str_replace( $remv_chars, "", $property_price );
				
				$price_icon = $this->zoacresPropertyThemeOpt('currency-label');
				
				$price_before_lable = $this->zoacresGetPropertyMetaValue('zoacres_property_before_price_label');
				$price_after_lable = $this->zoacresGetPropertyMetaValue('zoacres_property_after_price_label');
				if( $price_before_lable ){
					$price_before_lable = '<span class="price-before-label">'. esc_html( $price_before_lable ) .'</span>';
				}
				if( $price_after_lable ){
					$price_after_lable = '<span class="price-after-label">'. esc_html( $price_after_lable ) .'</span>';
				}
				if( $price_icon ){
					$price_allowed_html = array(
						'i' => array(
							'class' => array()
						),
						'span' => array(
							'class' => array()
						),
						'img' => array(
							'src' => array(),
							'title' => array(),
							'alt' => array()
						)
					);
					
					$curency_pos = $this->zoacresPropertyThemeOpt('currency-position');
					
					echo '<'. esc_attr( $parent ) .' class="property-price-inner">';
						echo wp_kses( $price_before_lable, $price_allowed_html );
						if( $curency_pos == 'before' ) echo '<span class="price-icon">'. wp_kses( $price_icon, $price_allowed_html ) .'</span>';
						echo ' <'. esc_attr( $price_ele ) .' class="property-price">'. esc_html( $property_price ) .'</'. esc_attr( $price_ele ) .'> ';
						if( $curency_pos == 'after' ) echo '<span class="price-icon">'. wp_kses( $price_icon, $price_allowed_html ) .'</span>';
						echo wp_kses( $price_after_lable, $price_allowed_html );
					echo '</'. esc_attr( $parent ) .'><!-- .property-price-inner -->';
				}
				
			endif;
			
			return $output;
		}
		
		function zoacresGetPropertyPriceLabel( $price ){
			$output = '';
			$price_icon = $this->zoacresPropertyThemeOpt('currency-label');		
			$curency_pos = $this->zoacresPropertyThemeOpt('currency-position');
			
			$price_allowed_html = array(
				'i' => array(
					'class' => array()
				),
				'span' => array(
					'class' => array()
				),
				'img' => array(
					'src' => array(),
					'title' => array(),
					'alt' => array()
				)
			);
			
			if( $curency_pos == 'before' ) $output .= '<span class="price-icon">'. wp_kses( $price_icon, $price_allowed_html ) .'</span>';
			$output .= '<span> '. esc_html( $price ) .'</span>';
			if( $curency_pos == 'after' ) $output .= '<span class="price-icon">'. wp_kses( $price_icon, $price_allowed_html ) .'</span>';
			
			return $output;
		}
		
		function zoacresPropertyAddress( $property_id ){
			$property_address = $this->zoacresGetPropertyMetaValue('zoacres_property_address');
			$property_zip = $this->zoacresGetPropertyMetaValue('zoacres_property_zip');
			
			$cols = $this->zoacresPropertyThemeOpt('property-address-col');
			$address_items = $this->zoacresPropertyThemeOpt('property-address-items');
			if( is_array( $address_items ) && array_key_exists( "placebo", $address_items ) ) unset( $address_items['placebo'] );
			if( $address_items['Enabled'] ): 
				$prop_layout = $this->zoacresPropertyThemeOpt( 'single-property-layout-type' );
				$prop_stat = $prop_layout == 'accordion' ? 'collapse': '';
			?>
				
				<div class="property-item-header clearfix" role="tabpanel" data-toggle="<?php echo esc_attr( $prop_stat ); ?>" data-target="#property-single-address" aria-expanded="true" aria-controls="property-single-address">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_address_subtitle_label', esc_html__( 'Address', 'zoacres' ) ); ?></h4>
					<div class="pull-right">
						<?php
							$map_lat = $this->zoacresGetPropertyMetaValue('zoacres_property_latitude');
							$map_lng = $this->zoacresGetPropertyMetaValue('zoacres_property_longitude');
							$map_url = 'https://www.google.com/maps/search/?api=1&query='. esc_attr( $map_lat ) .','. esc_attr( $map_lng );
						?>
						<a href="<?php echo esc_url( $map_url ); ?>"><?php echo apply_filters( 'zoacres_property_open_map_label', esc_html__( 'Open via Google Maps', 'zoacres' ) ); ?></a>
					</div>
				</div>
				<div id="property-single-address" class="property-details-wrap <?php echo esc_attr( $prop_stat ); ?>">
					<ul class="nav col-<?php echo esc_attr( $cols ); ?>-list">
					<?php
					foreach( $address_items['Enabled'] as $element => $value ){
		
						switch( $element ) {
							
							case 'address': 
								if( $property_address ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_address_label', esc_html__( 'Address:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $property_address ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'zip': 
								if( $property_zip ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_zip_label', esc_html__( 'Zip/Postal Code:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $property_zip ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'area': 
								$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
								if( isset( $property_area['link'] ) && !empty( $property_area['link'] ) ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_area_label', esc_html__( 'Area:', 'zoacres' ) ); ?></span> <strong><a href="<?php echo esc_url( $property_area['link'] ); ?>"><?php echo esc_html( $property_area['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
							case 'city': 
								$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
								if( isset( $property_city['link'] ) && !empty( $property_city['link'] ) ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_city_label', esc_html__( 'City:', 'zoacres' ) ); ?></span><strong><a href="<?php echo esc_url( $property_city['link'] ); ?>"><?php echo esc_html( $property_city['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
							case 'state': 
								$property_state = zoacres_get_property_tax_link( $property_id, 'property-state' );
								if( isset( $property_state['link'] ) && !empty( $property_state['link'] ) ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_state_label', esc_html__( 'State:', 'zoacres' ) ); ?></span> <strong><a href="<?php echo esc_url( $property_state['link'] ); ?>"><?php echo esc_html( $property_state['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
							case 'country': 
								$property_country = zoacres_get_property_tax_link( $property_id, 'property-country' );
								if( isset( $property_country['link'] ) && !empty( $property_country['link'] ) ):
							?>
								<li><span><?php echo apply_filters( 'zoacres_property_country_label', esc_html__( 'Country:', 'zoacres' ) ); ?></span> <strong><a href="<?php echo esc_url( $property_country['link'] ); ?>"><?php echo esc_html( $property_country['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
						}
					}?>
					</ul><!-- .property-details-address -->
				</div><!-- .property-details-wrap -->
			<?php
			endif;

		}
		
		function zoacresPropertyDetails( $property_id ){
		
			$prop_id_label = $this->zoacresPropertyThemeOpt('property-id-before');
			$prop_custom_id = $prop_id_label . $property_id;
			$size = $this->zoacresGetPropertyMetaValue('zoacres_property_size');
			$lot_size = $this->zoacresGetPropertyMetaValue('zoacres_property_lot_size');
			$no_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_rooms');
			$no_bed_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bed_rooms');
			$no_bath_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bath_rooms');
			$no_garages = $this->zoacresGetPropertyMetaValue('zoacres_property_no_garages');		
			$property_type = zoacres_get_property_tax_link( $property_id, 'property-category' );
			$property_status = zoacres_get_property_tax_link( $property_id, 'property-action' );
			$units = $this->zoacresGetPropertyUnits();
			
			$cols = $this->zoacresPropertyThemeOpt('property-details-col');
			$detail_items = $this->zoacresPropertyThemeOpt('property-details-items');
			if( is_array( $detail_items ) && array_key_exists( "placebo", $detail_items ) ) unset( $detail_items['placebo'] );
			if( $detail_items['Enabled'] ): 
				
				$prop_layout = $this->zoacresPropertyThemeOpt( 'single-property-layout-type' );
				$prop_stat = $prop_layout == 'accordion' ? 'collapse': '';
			?>
			
				<div class="property-item-header clearfix" role="tabpanel" data-toggle="<?php echo esc_attr( $prop_stat ); ?>" data-target="#property-single-details" aria-expanded="true" aria-controls="property-single-details">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_details_subtitle_label', esc_html__( 'Details', 'zoacres' ) ); ?></h4>
					<?php
						$prop_structure = $this->zoacresGetPropertyMetaValue('zoacres_property_structures');
						$property_structure_arr = zoacres_trim_array_same_values( $prop_structure );
						$prop_structure_opts = $this->zoacresPropertyThemeOpt('property-structure');
						$prop_structure_opts_arr = zoacres_trim_array_same_values( $prop_structure_opts );		
						$prop_structure_out = '';				
						if( !empty( $property_structure_arr ) ):
							foreach( $property_structure_arr as $structure => $value ){
								$prop_structure_out .= $prop_structure_opts_arr[$structure] . ', ';
							}
							$prop_structure_out = $prop_structure_out ? rtrim( $prop_structure_out, ", " ) : '';
						endif;
						
						if( $prop_structure_out ):
					?>
					<div class="pull-right">
						<div class="property-structures-wrap">
							<strong><?php echo apply_filters( 'zoacres_property_structure_label', esc_html__( 'Property Structure:', 'zoacres' ) ); ?></strong> 
							<span class="property-structures">
								<?php echo esc_html( $prop_structure_out ); ?>	
							</span>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<div id="property-single-details" class="property-details-wrap <?php echo esc_attr( $prop_stat ); ?>">
					<ul class="nav property-details-list col-<?php echo esc_attr( $cols ); ?>-list">
					<?php
					foreach( $detail_items['Enabled'] as $element => $value ){
						switch( $element ) {
							
							case 'id': ?>
								<li><span><?php echo apply_filters( 'zoacres_property_id_label', esc_html__( 'Property ID:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $prop_custom_id ); ?></strong></li>
							<?php
							break;
							
							case 'price': ?>
								<li><span><?php echo apply_filters( 'zoacres_property_price_label', esc_html__( 'Property Price:', 'zoacres' ) ); ?></span> <strong><?php $this->zoacresGetPropertyPrice('span'); ?></strong></li>
							<?php
							break;
							
							case 'type': if( isset( $property_type['name'] ) && $property_type['name'] != '' ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_type_label', esc_html__( 'Property Type:', 'zoacres' ) ); ?></span><strong><a href="<?php echo esc_url( $property_type['link'] ); ?>"><?php echo esc_html( $property_type['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
							case 'status': if( $prop_custom_id ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_status_label', esc_html__( 'Property Status:', 'zoacres' ) ); ?></span> <strong><a href="<?php echo esc_url( $property_status['link'] ); ?>"><?php echo esc_html( $property_status['name'] ); ?></a></strong></li>
							<?php
								endif;
							break;
							
							case 'size': if( $size ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_size_label', esc_html__( 'Property Size:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $size ); ?></span> <span class="property-units"><?php echo esc_html( $units ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'lot': if( $lot_size ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_lot_size_label', esc_html__( 'Lot Size:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $lot_size ); ?></span> <span class="property-units"><?php echo esc_html( $units ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'rooms': if( $no_rooms ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_rooms_label', esc_html__( 'Rooms:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $no_rooms ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'bedrooms': if( $no_bed_rooms ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_bedrooms_label', esc_html__( 'Bed Rooms:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $no_bed_rooms ); ?></strong></li>
							<?php
								endif;
							break;
							
							case 'bathrooms': if( $no_bath_rooms ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_bathrooms_label', esc_html__( 'Bath Rooms:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $no_bath_rooms ); ?></strong></li>
							<?php
								endif;
							break;	
							
							case 'garage': if( $no_garages ): ?>
								<li><span><?php echo apply_filters( 'zoacres_property_garages_label', esc_html__( 'Garages:', 'zoacres' ) ); ?></span> <strong><?php echo esc_html( $no_garages ); ?></strong></li>
							<?php
								endif;
							break;					
							
						}			
					}
					?>
					</ul><!-- .property-details-list -->
				</div><!-- .property-details-wrap -->
				<?php
			endif;
		}
		
		function zoacresPropertyAdditionalDetailsCheck( $property_id ){
			$property_cf = $this->zoacresPropertyThemeOpt('property-custom-fields');
			$stat = 0;
			if( $property_cf ):
				$property_cf = json_decode( $property_cf, true );
				foreach( $property_cf as $fields ){			
					$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
					$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
					$meta_value = $this->zoacresGetPropertyMetaValue('zoacres_property_custom_'.$fld_id);
					if( $meta_value ) $stat = 1;
				}
			endif;
			return $stat;
		}
		
		function zoacresPropertyAdditionalDetails( $property_id ){
			$property_cf = $this->zoacresPropertyThemeOpt('property-custom-fields');
			$property_cf = json_decode( $property_cf, true );
			$additional_fields = array();
			if( $property_cf ):
				$cfi = 0;
				
				foreach( $property_cf as $fields ){			

					$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
					$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
					$fld_type = $fields['Field Type'] ? $fields['Field Type'] : 'text';
					$meta_value = '';
					if( $fld_type == 'checkbox' ){
						$chk_value = $this->zoacresGetPropertyMetaValue('zoacres_property_custom_'.$fld_id);
						$meta_value = $chk_value ? '<i class="icon-check icons"></i>' : '';
					}elseif( $fld_type == 'dropdown' ){
						$cur_meta_value = $this->zoacresGetPropertyMetaValue('zoacres_property_custom_'.$fld_id);
						if( $cur_meta_value ){
							$fld_dd = isset( $fields['Dropdown Values'] ) ? $fields['Dropdown Values'] : '';
							if( $fld_dd ){
							
								$dd_array = array();
								$dd_values = explode( ",", $fld_dd );
								foreach( $dd_values as $dd_val ){
									$dd_key = sanitize_title( $dd_val );
									$dd_value = esc_html( $dd_val );
									$dd_array[$dd_key] = $dd_value;
								}		
								$meta_value = isset( $dd_array[$cur_meta_value] ) ? $dd_array[$cur_meta_value] : '';
							}
						}
					}else{
						$meta_value = $this->zoacresGetPropertyMetaValue('zoacres_property_custom_'.$fld_id);
					}
					
					$additional_fields[ absint( $fields['Index'] ) ] = array( $fld_name, $meta_value );
					
				}//foreach
				
				ksort( $additional_fields );
				
			endif;
			
			if( !empty( $additional_fields ) ){		

				$allowed_html = array(
					'i' => array(
						'class' => array()
					),
					'span' => array(
						'class' => array()
					)
				);
				$cols = $this->zoacresPropertyThemeOpt('property-addetails-col');
				$prop_layout = $this->zoacresPropertyThemeOpt( 'single-property-layout-type' );
				$prop_stat = $prop_layout == 'accordion' ? 'collapse': '';
			?>
				<div class="property-addflds-header clearfix" data-toggle="<?php echo esc_attr( $prop_stat ); ?>" data-target="#property-single-add" aria-expanded="true" aria-controls="property-single-add">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_additional_details_subtitle_label', esc_html__( 'Additional Details', 'zoacres' ) ); ?></h4>
				</div>
				<div id="property-single-add" class="property-details-wrap <?php echo esc_attr( $prop_stat ); ?>">
					<ul class="nav col-<?php echo esc_attr( $cols ); ?>-list">
				<?php
					foreach( $additional_fields as $cf ){
						if( isset( $cf[1] ) && $cf[1] != '' ):
				?>
						<li><strong><?php echo esc_html( $cf[0] ); ?></strong> <span><?php echo wp_kses( $cf[1], $allowed_html ); ?></span></li>
				<?php
						endif;
					}
				?>
					</ul>	<!-- .property-additional-inner -->
				</div>	<!-- .property-Additional-wrap -->
			<?php
			}
		}
		
		function zoacresPropertyFeatures( $property_id ){
			$property_features = $this->zoacresPropertyThemeOpt('property-features');
			$property_features_arr = zoacres_trim_array_same_values( $property_features );
			$features_arr = $this->zoacresGetPropertyMetaValue('zoacres_property_features');
			$cols = $this->zoacresPropertyThemeOpt('property-features-col');
			if( !empty( $features_arr ) ):
			
				$prop_layout = $this->zoacresPropertyThemeOpt( 'single-property-layout-type' );
				$prop_stat = $prop_layout == 'accordion' ? 'collapse': '';
			
			?>		
				<div class="property-item-header clearfix" role="tabpanel" data-toggle="<?php echo esc_attr( $prop_stat ); ?>" data-target="#property-single-feature" aria-expanded="true" aria-controls="property-single-feature">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_features_subtitle_label', esc_html__( 'Property Features', 'zoacres' ) ); ?></h4>
				</div>
				<div id="property-single-feature" class="property-details-wrap <?php echo esc_attr( $prop_stat ); ?>">
					<ul class="nav col-<?php echo esc_attr( $cols ); ?>-list">
					<?php
					$feat_final = explode( ",", $features_arr );
					foreach( $feat_final as $feature ){ 
						if( isset( $property_features_arr[$feature] ) ){
							$val = $property_features_arr[$feature];
					?>
						<li><span class="property-feature-icon"><i class="fa fa-check"></i></span> <span class="property-feature-text"><?php echo esc_html( $val ); ?></span></li>
					<?php
						}
					}	
					?>
					</ul>
				</div>
			<?php
			endif;
		}
		
		function zoacresGetPropertyFavMeta( $property_id ){
		
			$author_id = get_current_user_id();
			$fav_array = $this->zoacresGetFavProperties( $author_id );
			
			$fav_stat = 0;
			
			if( is_user_logged_in() && isset( $fav_array ) && is_array( $fav_array ) ){
				if ( in_array( $property_id, $fav_array ) ){
					$fav_stat = 1;
				}		
			}
			
			if( $fav_stat ){
				echo '<li class="property-favourite-wrap"><div class="property-favourite tooltip-parent"><a href="#" class="property-fav-done" data-id="'. esc_attr( $property_id ) .'"><span class="fa fa-heart"></span></a><span class="tooltip-title">'. esc_html__( 'Unfavourite', 'zoacres' ) .' </span></div></li>';
			}else{
				echo '<li class="property-favourite-wrap"><div class="property-favourite tooltip-parent"><a href="#" class="property-fav" data-id="'. esc_attr( $property_id ) .'"><span class="fa fa-heart"></span></a><span class="tooltip-title">'. esc_html__( 'Favourite', 'zoacres' ) .' </span></div></li>';
			}
			
		}
		
		function zoacresPropertySingleMeta( $property_id, $position ){
		
			$zps = new ZoacresPostSettings;

			$size = $this->zoacresGetPropertyMetaValue('zoacres_property_size');
			$units = $this->zoacresGetPropertyUnits();
			
			$property_elements = '';
			
			$field_id = 'zoacres_property_'. esc_attr( $position ) .'meta_opt';
			$prop_elements_opt = get_post_meta( get_the_ID(), $field_id, true );
			if( $prop_elements_opt == 'custom' ){
				$field_id = 'zoacres_property_'. esc_attr( $position ) .'meta_items';
				$property_elements = get_post_meta( get_the_ID(), $field_id, true );
				$property_elements = json_decode( stripslashes( $property_elements ), true );
			}else{
				$field_id = 'single-property-'. esc_attr( $position ) .'meta-items';
				$property_elements = $this->zoacresPropertyThemeOpt($field_id);
			}		
			
			$pos = array( 'Left', 'Right' );
			
			foreach ( $pos as $ot_pos ){
			
				$property_items = isset( $property_elements[$ot_pos] ) ? $property_elements[$ot_pos] : '';
				if( is_array( $property_items ) && array_key_exists( "placebo", $property_items ) ) unset( $property_items['placebo'] );
				
				if( $property_items ):
					
					$ul_class = $ot_pos == 'Right' ? ' pull-right' : ' pull-left';
				
					echo '<ul class="nav property-meta'. esc_attr( $ul_class ) .'">';
					foreach( $property_items as $element => $value ){
						switch( $element ) {
						
							case 'title': ?>
								<li class="property-meta-title"><h2><?php the_title(); ?></h2></li>
							<?php
							break;
							
							case 'price': ?>
								<li><?php $this->zoacresGetPropertyPrice('span'); ?></li>
							<?php
							break;
							
							case 'size': if( $size ): ?>
								<li><strong><span><?php echo esc_html( $size ); ?></span> <span class="property-units"><?php echo esc_html( $units ); ?></span></li>
							<?php
								endif;
							break;
							
							case 'date':
								$archive_year  = get_the_time('Y');
								$archive_month = get_the_time('m'); 
								$archive_day   = get_the_time('d');
								echo '<li><div class="property-date"><span class="before-icon fa fa-calendar theme-color"></span><a href="'.get_day_link( $archive_year, $archive_month, $archive_day).'" >'. get_the_time( get_option('date_format') ) .'</a></div></li>';
							break;	
							
							case 'category':
								$property_type = zoacres_get_property_tax_link( $property_id, 'property-category' );
								$property_status = zoacres_get_property_tax_link( $property_id, 'property-action' );
								if( $property_type ){
									
									$status_out = $property_status ? ' <a href="' . esc_url( $property_status['link'] ) . '">' . esc_html( $property_status['name'] ) . '</a>' : '';
									
									echo '<li><div class="property-category"><span class="before-icon icon icon-folder-alt theme-color"></span><a href="' . esc_url( $property_type['link'] ) . '">' . esc_html( $property_type['name'] ) . '</a> '. esc_html__( 'in', 'zoacres' ) . $status_out.'</div></li>';
								}
							break;	
							
							
							case 'social':
								echo '<li>' . $zps->zoacresMetaSocial() . '</li>';
							break;	
							
							case 'views':
								echo '<li>' . $zps->zoacresMetaViews() . '</li>';
							break;
							
							case 'likes':
								echo '<li>' . $zps->zoacresMetaLikes( $property_id ) . '</li>';
							break;
							
							case 'print':
								echo '<li><a href="#" class="property-print" data-id="'. esc_attr( $property_id ) .'"><i class="icon-printer"></i></a></li>';
							break;
							
							case "address":
								$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
								$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
								$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
								$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
								$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
								$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
								echo '<li><div class="property-area"><span class="icon-location-pin theme-color"></span> <a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, <a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a></div></li>';
							break;
							
							case "favourite":
								
								$this->zoacresGetPropertyFavMeta( $property_id );
								
							break;
							
							case "agent":
								$agent_id = $this->zoacresGetPropertyMetaValue('zoacres_property_agent_id');
								if( $agent_id != '1' ){
									$agent_name = get_the_title( absint( $agent_id ) );
									$agent_url = get_post_permalink( absint( $agent_id ) );
									$agent_img_url = get_the_post_thumbnail_url( absint( $agent_id ), 'thumbnail' ); 
									if( empty( $agent_img_url ) ) $agent_img_url = ZOACRES_ASSETS . "/images/no-img.jpg";
									echo '<li><div class="property-agent"><img src="'. esc_url( $agent_img_url ) .'" class="img-fluid" alt="'. esc_attr( $agent_name ) .'" /> <a href="'. esc_url( $agent_url ) .'" class="agent-name" title="'. esc_attr( $agent_name ) .'">'. esc_html( $agent_name ) .'</a></div></li>';
								}else{
									echo '<li><div class="property-agent">'. get_avatar( get_the_author_meta('email'), '30' ) .' <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) .'">'. get_the_author() .'</a></div></li>';
								}
							break;
							
							case 'breadcrumb':
								$zhe = new ZoacresHeaderElements;
								echo '<li>';
									$zhe->zoacresBreadcrumbs();
								echo '</li>';	
							break;
							
						}			
					}
					echo '</ul>';
				endif;
				
			}//Left, Right foreach

		}
		
		function zoacresPropertyStickyNavigation( $property_id ){
			$prev_post = get_previous_post();
			if( $prev_post ):
			?>
			<div class="property-previous-nav">
				<?php $property_img_url = get_the_post_thumbnail_url( $prev_post->ID, 'medium'); ?>
				<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="property-previous-link" title="<?php echo esc_attr( $prev_post->post_title ); ?>">
					<div class="property-previous set-by-bg-img" data-bg-img="<?php echo esc_url( $property_img_url ); ?>">
						<?php echo esc_html( $prev_post->post_title ); ?> <span class="fa fa-angle-right"></span>
					</div><!-- .property-previous -->
				</a>
			</div><!-- .property-previous-nav -->
			<?php
			endif;
			
			$next_post = get_next_post();
			if( $next_post ):
			?>
			<div class="property-next-nav">
				<?php $property_img_url = get_the_post_thumbnail_url( $next_post->ID, 'medium'); ?>
				<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="property-next-link" title="<?php echo esc_attr( $next_post->post_title ); ?>">
					<div class="property-next set-by-bg-img" data-bg-img="<?php echo esc_url( $property_img_url ); ?>">
						<span class="fa fa-angle-left"></span> <?php echo esc_html( $next_post->post_title ); ?>
					</div><!-- .property-next -->
				</a>
			</div><!-- .property-previous-next -->
			<?php
			endif;
		}
		
		function zoacresPropertySingleBgImage( $property_id ){
			$featured_img_url = get_the_post_thumbnail_url($property_id, 'full'); 
		?>
			<div class="property-img page-title-bg-img" data-img="<?php echo esc_url( $featured_img_url ); ?>"></div>
		<?php
		}
		
		function zoacresPropertySingleImage( $property_id ){
		?>
			<div class="property-img">
				<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) );  ?>
			</div>
		<?php
		}
		
		function zoacresPropertyStreetView( $property_id, $title_stat = true ){
			if( $title_stat ):
		?>
				<div class="property-street-view-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_street_view_subtitle_label', esc_html__( 'Street View', 'zoacres' ) ); ?></h4>
				</div>
		<?php endif; ?>
			<div id="zoacres-street-view"></div>
		<?php
		}
		
		function zoacresPropertySinglePack( $property_id, $full_state = false ){
		?>
			<ul class="nav property-single-pack-nav" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" href="#" data-id="property-single-pack-gallery"><span class="icon-picture"></span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#" data-id="property-single-pack-map"><span class="icon-location-pin"></span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#" data-id="property-single-pack-sview"><span class="icon-compass"></span></a>
				</li>
			</ul>
			<div class="property-single-pack-content">
				<?php 
					$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
					if( $gallery ):
				?>
				<div class="property-single-pack property-single-pack-gallery" role="tabpanel">
				<?php 
					if( $full_state ){
						$this->zoacresPropertySingleBgGallery( $property_id ); 
					}else{
						$this->zoacresPropertySingleGallery( $property_id, false ); 
					}
				?>
				</div>
				<?php
					endif;
					$lat = $this->zoacresGetPropertyMetaValue('zoacres_property_latitude');
					$longi = $this->zoacresGetPropertyMetaValue('zoacres_property_longitude');
					if( $lat && $longi ):
				?>
				<div class="property-single-pack property-single-pack-map" role="tabpanel"><?php $this->zoacresPropertyNearbyMap( $property_id, false ); ?></div>
				<div class="property-single-pack property-single-pack-sview" role="tabpanel"><?php $this->zoacresPropertyStreetView( $property_id, false ); ?></div>
				<?php
					endif;
				?>
			</div>
		<?php
		}
		
		function zoacresPropertySingleBgGallery( $property_id ){
		
			$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
			
			if( $gallery ){
				$gallery_array = explode( ",", $gallery ); ?>
				<ul class="property-single-gallery gallery list-unstyled cS-hidden">
				<?php
					foreach( $gallery_array as $gal_id ): 
						$image = wp_get_attachment_image_src( $gal_id, 'zoacres-grid-small' );
						$big_image = wp_get_attachment_image_src( $gal_id, 'full' ); ?>
						<li class="property-img page-title-bg-img" data-thumb="<?php echo esc_url( $image[0] ); ?>" data-img="<?php echo esc_url( $big_image[0] ); ?>"></li>
					<?php
					endforeach;											
				?>
				</ul><!-- .zoom-gallery -->
				<?php
			}
			if( is_singular( 'zoacres-property' ) ){
				wp_enqueue_script( 'lightslider' );
			}
		}
		
		function zoacresPropertySingleGallery( $property_id, $title_stat = true ){
		
			if( $title_stat ):
		?>
				<div class="property-single-gallery-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_single_gallery_subtitle_label', esc_html__( 'Property Gallery', 'zoacres' ) ); ?></h4>
				</div>
		<?php endif;
		
			$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
			
			if( $gallery ){
				$gallery_array = explode( ",", $gallery ); ?>
				<ul class="property-single-gallery gallery list-unstyled cS-hidden">
					<?php
					foreach( $gallery_array as $gal_id ): 
						$image = wp_get_attachment_image_src( $gal_id, 'zoacres-grid-small' ); ?>
						<li data-thumb="<?php echo esc_url( $image[0] ); ?>"> 
							<?php $big_image = wp_get_attachment_image_src( $gal_id, 'large' ); ?>
							<img src="<?php echo esc_url( $big_image[0] ); ?>" alt="<?php esc_attr_e( 'Property Gallery', 'zoacres' ); ?>" />
						</li>
					
					<?php
					endforeach;											
					?>
				</ul><!-- .zoom-gallery -->
				<?php
				if( is_singular( 'zoacres-property' ) ){
					wp_enqueue_script( 'lightslider' );
				}
			}
		}
		
		function zoacresPropertyPlans( $property_id ){
			$plans = $this->zoacresGetPropertyMetaValue('zoacres_property_floor_palns');
			$units = $this->zoacresGetPropertyUnits();
			if( isset( $plans[0]['plan_title'] ) && $plans[0]['plan_title'] != '' ){
				?>
				
				<div class="property-item-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_plans_subtitle_label', esc_html__( 'Floor Plans', 'zoacres' ) ); ?></h4>
				</div>
				
				<?php
				echo '<div id="property-plan-accordion" role="tablist">';
				$i = 0;
				$plan_content = '';
				foreach( $plans as $plan ){		
		
					if( isset( $plan['plan_title'] ) && $plan['plan_title'] != '' ){
						$plan_size = isset( $plan['plan_size'] ) && $plan['plan_size'] != '' ? $plan['plan_size'] : '';
						$active = $i == 0 ? ' show' : '';
						echo '<div class="card">';
							echo '<div class="card-header" role="tab" id="floor-heading-'. sanitize_title( $plan['plan_title'] ) .'">';
								echo '<h5><a class="mb-0" data-toggle="collapse" data-parent="#property-plan-accordion" href="#floor-plan-'. sanitize_title( $plan['plan_title'] ) .'" aria-expanded="true" aria-controls="floor-plan-'. sanitize_title( $plan['plan_title'] ) .'">';
									echo '<span class="floor-plan-title">'. esc_html( $plan['plan_title'] ) . '</span>';
									if( $plan_size ):
										echo '<span class="pull-right plan-size-parent">'. apply_filters( 'zoacres_property_plan_size_label', esc_html__( 'Size', 'zoacres' ) ) ." ". esc_html( $plan_size ) . ' '. esc_html( $units ) .'</span>';
									endif;
								echo '</a></h5>';	
							echo '</div>';					
						
							echo '<div id="floor-plan-'. sanitize_title( $plan['plan_title'] ) .'" class="collapse'. esc_attr( $active ) .'" role="tabpanel" aria-labelledby="floor-heading-'. sanitize_title( $plan['plan_title'] ) .'">';
								echo '<div class="card-block zoom-gallery">';
									//plan_image
									if( isset( $plan['plan_image'] ) && $plan['plan_image'] != '' ){
										$plan_image_url = wp_get_attachment_url( absint( $plan['plan_image'] ) );
										echo '<a href="'. esc_url( $plan_image_url ) .'" title="'. esc_attr( get_the_title( absint( $plan['plan_image'] ) ) ) .'">';
											echo wp_get_attachment_image( absint( $plan['plan_image'] ), 'full', "", array( "class" => "img-fluid" ) );
										echo '</a>';
									}
									echo '<div class="plan-details-wrap">';
										echo '<h6>'.apply_filters( 'zoacres_property_plan_details_label', esc_html__( 'Plan Details', 'zoacres' ) ).'</h6>';
										echo '<ul class="nav extra-plan-details">';
										if( isset( $plan['plan_rooms'] ) && $plan['plan_rooms'] != '' ){
											echo '<li><span class="floor-plan-subtitle">'.  apply_filters( 'zoacres_property_plan_rooms_label', esc_html__( 'Rooms', 'zoacres' ) ) ."</span> ". esc_html( $plan['plan_rooms'] ) .'</li>';
										}
										if( isset( $plan['plan_bathrooms'] ) && $plan['plan_bathrooms'] != '' ){
											echo '<li><span class="floor-plan-subtitle">'. apply_filters( 'zoacres_property_plan_bathrooms_label', esc_html__( 'Bath Rooms', 'zoacres' ) ) ."</span> ". esc_html( $plan['plan_bathrooms'] ) .'</li>';
										}
										if( isset( $plan['plan_price'] ) && $plan['plan_price'] != '' ){
											echo '<li><span class="floor-plan-subtitle">'. apply_filters( 'zoacres_property_plan_price_label', esc_html__( 'Plan Price', 'zoacres' ) ) ."</span> ". $this->zoacresGetPropertyPriceLabel( $plan['plan_price'] ) .'</li>';
										}
										echo '</ul>';
									echo '</div>';
									
									if( isset( $plan['plan_desc'] ) && $plan['plan_desc'] != '' ){
										echo '<div class="plan-description">';
											echo '<h6>'.apply_filters( 'zoacres_property_plan_desc_label', esc_html__( 'Plan Description', 'zoacres' ) ).'</h6>';
											echo esc_html( $plan['plan_desc'] );
										echo '</div><!-- .plan-description -->';
									}
								echo '</div>';
							echo '</div>';
						echo '</div><!-- .card -->';
					}
					$i=1;
				}
				echo '</div>';
			}

		}
		
		function zoacresPropertyDaysViewsChart( $property_id, $day_views ){
			?>
			<div class="property-item-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_days_chart_subtitle_label', esc_html__( 'Property Views', 'zoacres' ) ); ?></h4>
			</div>
			<?php
			wp_enqueue_script( 'zoacres-chart' );
			
			$color = $this->zoacresPropertyThemeOpt('theme-color');
			$limit = $this->zoacresPropertyThemeOpt('property-chart-days-limit');
			$limit = !empty( $limit ) && $limit < 20 ? $limit : 20;
			
			echo '<canvas id="property-days-views" data-options="'. htmlspecialchars( json_encode( $day_views ), ENT_QUOTES, 'UTF-8' ) .'" data-limit="'. esc_attr( $limit ) .'" data-color="'. esc_attr( $color ) .'"></canvas>';
		}
		
		function zoacresPropertyWalkScoreCall( $property_id, $walkscore_key ){
			
			$ws_api = $this->zoacresPropertyThemeOpt('wsapikey');
			$property_zip = $this->zoacresGetPropertyMetaValue('zoacres_property_zip');
			$property_address = $this->zoacresGetPropertyMetaValue('zoacres_property_address');
			$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
			$property_city = isset( $property_city['name'] ) ? $property_city['name'] : '';
			$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
			$property_area = isset( $property_area['name'] ) ? $property_area['name'] : '';
			$property_address = $property_address .' '. $property_area .' '. $property_city .' '. $property_zip;
			
			$property_lat = $this->zoacresGetPropertyMetaValue('zoacres_property_latitude');
			$property_lng = $this->zoacresGetPropertyMetaValue('zoacres_property_longitude');
			
			$walkscore_transient = '';
			$args = array( 'timeout' => 500 );
			$response = wp_remote_get( 'http://api.walkscore.com/score?format=json&address='. $property_address .'&lat='. $property_lat .'&lon='. $property_lng .'&transit=1&bike=1&wsapikey='. $ws_api, $args );
			$body = wp_remote_retrieve_body( $response );

			if ( $body ) {
				$walkscore_transient = $body; // use the content
			}
			
			if( $walkscore_transient ){
				set_transient( $walkscore_key, wp_slash( $walkscore_transient ), 2 * HOUR_IN_SECONDS );
			}
			return $walkscore_transient;
		}
		
		function zoacresPropertyWalkScore( $property_id ){
			?>
			<div class="property-item-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_walk_score_subtitle_label', esc_html__( 'Walk Score', 'zoacres' ) ); ?></h4>
			</div>
			<?php
				$walkscore_transient_key = 'zoacres_walkscore_' . $property_id;
				if ( false === ( $walkscore_transient = get_transient( $walkscore_transient_key ) ) ) {
					// Call for walk score details
					$walkscore_transient = $this->zoacresPropertyWalkScoreCall($property_id, $walkscore_transient_key);
				}
				
				//Walk score json
				if( $walkscore_transient  ):
					$walkscore_content = json_decode( stripslashes( $walkscore_transient ), true );
					if( isset( $walkscore_content['status'] ) && $walkscore_content['status'] == '1' ){
						?>
						<div class="media walk-score-details">
							<span class="fa fa-heart walkscore-icon"></span>
							<div class="media-body align-self-center">
								<?php $ws_logo = isset( $walkscore_content['logo_url'] ) ? $walkscore_content['logo_url'] : ''; ?>
								<img src="<?php echo esc_url( $ws_logo ); ?>" alt="<?php esc_attr_e( 'Walk Score', 'zoacres' ); ?>" class="img-fluid" />
								<?php $ws_rank = isset( $walkscore_content['walkscore'] ) ? $walkscore_content['walkscore'] : ''; ?>
								<span class="walk-score-rank"><strong><?php echo esc_html( $ws_rank ); ?></strong> / </span>
								<?php $ws_desc = isset( $walkscore_content['description'] ) ? $walkscore_content['description'] : ''; ?>
								<span class="walk-score-desc"><?php echo esc_html( $ws_desc ); ?> - </span>
								<?php $ws_link = isset( $walkscore_content['ws_link'] ) ? $walkscore_content['ws_link'] : '#'; ?>
								<a href="<?php echo esc_url( $ws_link ); ?>" title="<?php esc_attr_e( 'Walk Score', 'zoacres' ); ?>"><?php esc_html_e( 'More info', 'zoacres' ); ?></a>
							</div>		
						</div>
						<?php if( isset( $walkscore_content['transit']['score'] ) && !empty( $walkscore_content['transit']['score'] ) ): ?>
						<div class="media transist-score-details">
							<span class="fa fa-bus walkscore-icon"></span>
							<div class="media-body align-self-center">
								<span class="transist-score-title"><?php esc_html_e( 'Transist Score:', 'zoacres' ); ?></span>
								<?php $transist_rank = isset( $walkscore_content['transit']['score'] ) ? $walkscore_content['transit']['score'] : ''; ?>
								<span class="transist-score-rank"><strong><?php echo esc_html( $transist_rank ); ?></strong> / </span>
								<?php $transist_desc = isset( $walkscore_content['transit']['description'] ) ? $walkscore_content['transit']['description'] : ''; ?>
								<span class="transist-score-desc"><?php echo esc_html( $transist_desc ); ?></span>
							</div>	
						</div>
						<?php endif; ?>
						<?php if( isset( $walkscore_content['bike']['score'] ) && !empty( $walkscore_content['bike']['score'] ) ): ?>
						<div class="media bike-score-details">
							<span class="fa fa-motorcycle walkscore-icon"></span>
							<div class="media-body align-self-center">
								<span class="bike-score-title"><?php esc_html_e( 'Bike Score:', 'zoacres' ); ?></span>
								<?php $bike_rank = isset( $walkscore_content['bike']['score'] ) ? $walkscore_content['bike']['score'] : ''; ?>
								<span class="bike-score-rank"><strong><?php echo esc_html( $bike_rank ); ?></strong> / </span>
								<?php $bike_desc = isset( $walkscore_content['bike']['description'] ) ? $walkscore_content['bike']['description'] : ''; ?>
								<span class="bike-score-desc"><?php echo esc_html( $bike_desc ); ?></span>
							</div>	
						</div>
						<?php endif; ?>
						<?php
					}else{
						// Call for walk score details
						$walkscore_transient = $this->zoacresPropertyWalkScoreCall($property_id, $walkscore_transient_key);
					}
				else:
					$walkscore_transient = $this->zoacresPropertyWalkScoreCall($property_id, $walkscore_transient_key);
				endif;
		}
		
		function zoacresPropertySmilar( $property_id, $chk = false ){
		
			// Similar property slider options
			
			$slide_template = 'related';
			$gal_atts = array(
				'data-loop="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-infinite' ) .'"',
				'data-margin="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-margin' ) .'"',
				'data-center="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-center' ) .'"',
				'data-nav="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-navigation' ) .'"',
				'data-dots="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-pagination' ) .'"',
				'data-autoplay="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-autoplay' ) .'"',
				'data-items="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-items' ) .'"',
				'data-items-tab="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-tab' ) .'"',
				'data-items-mob="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-mobile' ) .'"',
				'data-duration="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-duration' ) .'"',
				'data-smartspeed="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',
				'data-scrollby="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-scrollby' ) .'"',
				'data-autoheight="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-autoheight' ) .'"',
			);
			$data_atts = implode( " ", $gal_atts );
		
			$terms = get_the_terms( $property_id, 'property-category' );
			$tax_id = '';
			if ( $terms && ! is_wp_error( $terms ) ){
				if( isset( $terms[0] ) ){
					$tax_id = $terms[0]->term_id;
				}
			}
			
			$ppp = $this->zoacresPropertyThemeOpt("property-related-max");
			
			$args = array(
				'post_type' => 'zoacres-property',
				'posts_per_page' => absint( $ppp ),
				'order'   => 'DESC',
				'post__not_in' => array( $property_id ),
				'tax_query' => array(
					array(
						'taxonomy' => 'property-category',
						'field'    => 'term_id',
						'terms'    => array( absint( $tax_id ) ),
					)
				)
			);
			
			$args = apply_filters( 'zoacres_property_similar_args', $args );
			
			$field_prefix = 'archive';
			$meta_args = array();
			
			$prop_elements = $this->zoacresPropertyThemeOpt( 'archive-property-items' );
			$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
			if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );

			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
			
				if( $chk ) return true;
				// The Loop
			?>
				<div class="property-item-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_similar_subtitle_label', esc_html__( 'Similar Listings', 'zoacres' ) ); ?></h4>
				</div>
			
				<div class="related-property-slider owl-carousel" <?php echo ( ''. $data_atts ); ?>>
			<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$property_id = get_the_ID();

				?>
					<div class="related-property-item">
						<div class="property-wrap">
							<?php
							
							if ( $prop_elements ): 
								foreach ( $prop_elements as $element => $value ) {
									switch( $element ) {
										case "image":
											echo '<div class="property-image-wrap">';
												$img_size = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-size" );
												if( $img_size == "custom" ){
													$img_csize = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-csize");
													$wdth = isset( $img_csize['width'] ) ? $img_csize['width'] : '';
													$hgt = isset( $img_csize['height'] ) ? $img_csize['height'] : '';
													$img_size = array( $wdth, $hgt );
												}
												$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix );
											echo '</div>';
										break;
										
										case "title":
										?>
											<div class="property-title-wrap">
												<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
											</div>
										<?php
										break;
										
										case "price":
										?>
											<div class="property-price-wrap">
												<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
											</div>
										<?php
										break;
										
										case "excerpt":
											$excerpt_len = $this->zoacresSetPropertyExcerptLength( 15 );
											add_filter( 'excerpt_length', __return_value( $excerpt_len ) );
										?>
											<div class="property-excerpt-wrap">
												<?php the_excerpt(); ?>
											</div>
										<?php
										break;
										
										case "tm":
											$this->zoacresPropertyImageMeta( $property_id, 'top', $field_prefix );
										break;
										
										case "bm":
											$this->zoacresPropertyImageMeta( $property_id, 'bottom', $field_prefix );
										break;
										
									}
								}
							endif;

							?>						
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<?php
				wp_reset_postdata();
			}else{
				if( $chk ) return false;
			}
		
		}
		
		function zoacresPropertyTrending( $property_id, $chk = false ){
		
			// Similar property slider options
			
			$slide_template = 'trending';
			$gal_atts = array(
				'data-loop="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-infinite' ) .'"',
				'data-margin="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-margin' ) .'"',
				'data-center="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-center' ) .'"',
				'data-nav="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-navigation' ) .'"',
				'data-dots="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-pagination' ) .'"',
				'data-autoplay="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-autoplay' ) .'"',
				'data-items="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-items' ) .'"',
				'data-items-tab="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-tab' ) .'"',
				'data-items-mob="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-mobile' ) .'"',
				'data-duration="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-duration' ) .'"',
				'data-smartspeed="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',
				'data-scrollby="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-scrollby' ) .'"',
				'data-autoheight="'. $this->zoacresPropertyThemeOpt( $slide_template.'-slide-autoheight' ) .'"',
			);
			$data_atts = implode( " ", $gal_atts );
			
			$trending_by = $this->zoacresPropertyThemeOpt( 'single-property-trending-by' );
			$trending_by = $trending_by != '' ? $trending_by : 'property-city';
		
			$terms = get_the_terms( $property_id, $trending_by );
			$tax_id = '';
			if ( $terms && ! is_wp_error( $terms ) ){
				if( isset( $terms[0] ) ){
					$tax_id = $terms[0]->term_id;
				}
			}
			
			$ppp = $this->zoacresPropertyThemeOpt("property-trending-max");
			
			$args = array(
				'post_type' => 'zoacres-property',
				'posts_per_page' => absint( $ppp ),
				'order'   => 'DESC',
				'orderby'   => 'meta_value_num',
				'meta_key'  => 'zoacres_post_views_count',
				'post__not_in' => array( $property_id ),
				'tax_query' => array(
					array(
						'taxonomy' => $trending_by,
						'field'    => 'term_id',
						'terms'    => array( absint( $tax_id ) ),
					)
				)
			);
			
			$args = apply_filters( 'zoacres_property_trending_args', $args );
			
			$field_prefix = 'archive';
			$meta_args = array();
			
			$prop_elements = $this->zoacresPropertyThemeOpt( 'archive-property-items' );
			$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
			if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );

			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
			
				if( $chk ) return true;
				// The Loop
			?>
				<div class="property-item-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_similar_subtitle_label', esc_html__( 'Trending Listings', 'zoacres' ) ); ?></h4>
				</div>
			
				<div class="trending-property-slider owl-carousel" <?php echo ( ''. $data_atts ); ?>>
			<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$property_id = get_the_ID();

				?>
					<div class="trending-property-item">
						<div class="property-wrap">
							<?php
							
							if ( $prop_elements ): 
								foreach ( $prop_elements as $element => $value ) {
									switch( $element ) {
										case "image":
											echo '<div class="property-image-wrap">';
												$img_size = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-size" );
												if( $img_size == "custom" ){
													$img_csize = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-csize");
													$wdth = isset( $img_csize['width'] ) ? $img_csize['width'] : '';
													$hgt = isset( $img_csize['height'] ) ? $img_csize['height'] : '';
													$img_size = array( $wdth, $hgt );
												}
												$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix );
											echo '</div>';
										break;
										
										case "title":
										?>
											<div class="property-title-wrap">
												<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
											</div>
										<?php
										break;
										
										case "price":
										?>
											<div class="property-price-wrap">
												<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
											</div>
										<?php
										break;
										
										case "excerpt":
											$excerpt_len = $this->zoacresSetPropertyExcerptLength( 15 );
											add_filter( 'excerpt_length', __return_value( $excerpt_len ) );
										?>
											<div class="property-excerpt-wrap">
												<?php the_excerpt(); ?>
											</div>
										<?php
										break;
										
										case "tm":
											$this->zoacresPropertyImageMeta( $property_id, 'top', $field_prefix );
										break;
										
										case "bm":
											$this->zoacresPropertyImageMeta( $property_id, 'bottom', $field_prefix );
										break;
										
									}
								}
							endif;

							?>						
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<?php
				wp_reset_postdata();
			}else{
				if( $chk ) return false;
			}
			
		
		}
		
		function zoacresPropertyNearbyMap( $property_id, $title_stat = true, $search_stat = false ){
			if( $title_stat ):
		?>
			<div class="property-nearby-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_nearby_subtitle_label', esc_html__( 'Property Nearby', 'zoacres' ) ); ?></h4>
			</div>
		<?php
			endif; 
			
			$args = array( 'post_type' => 'zoacres-property', 'post__in' => array( $property_id ) );
			$map_array = $this->zoacresHalfMapProperties( $args );
			$map_args = array(
				'zoom' => 15,
				'height' => '500px',
				'zoom_control' => true
			);
			echo '<div class="zoacres-nearby-map">';
				$this->zoacresHalfMapPropertiesMakeMap( $map_array, $map_args );
			?>
				<ul class="nav flex-column zoacres-nearby-icon-nav">
					<li><a href="#" class="near-by" data-ind="1" data-id="bus_station" title="<?php esc_attr_e( 'Bus', 'zoacres' ); ?>"><span class="fa fa-bus"></span></a></li>
					<li><a href="#" class="near-by" data-ind="2" data-id="school"  title="<?php esc_attr_e( 'School', 'zoacres' ); ?>"><span class="fa fa-graduation-cap"></span></a></li>
					<li><a href="#" class="near-by" data-ind="3" data-id="bar"  title="<?php esc_attr_e( 'Bar', 'zoacres' ); ?>"><span class="fa fa-glass"></span></a></li>
					<li><a href="#" class="near-by" data-ind="4" data-id="gym"  title="<?php esc_attr_e( 'Gym', 'zoacres' ); ?>"><span class="fa fa-child"></span></a></li>
					<li><a href="#" class="near-by" data-ind="5" data-id="bank"  title="<?php esc_attr_e( 'Bank', 'zoacres' ); ?>"><span class="fa fa-money"></span></a></li>
					<li><a href="#" class="near-by" data-ind="6" data-id="train_station"  title="<?php esc_attr_e( 'Train', 'zoacres' ); ?>"><span class="fa fa-train"></span></a></li>
					<li><a href="#" class="near-by" data-ind="7" data-id="subway_station"  title="<?php esc_attr_e( 'Subway Station', 'zoacres' ); ?>"><span class="fa fa-subway"></span></a></li>
					<li><a href="#" class="near-by" data-ind="8" data-id="hospital"  title="<?php esc_attr_e( 'Hospital', 'zoacres' ); ?>"><span class="fa fa-hospital-o"></span></a></li>
				</ul>
			<?php
			echo '</div>';
			
			wp_enqueue_script( 'zoacres-gmaps' );
			wp_enqueue_script( 'infobox' );
			wp_enqueue_script( 'marker-clusterer' );
			
			if( $search_stat ):
				//Advanced search form
				$searcg_args = array(
					'toggle' => false,
					'key_search' => false,
					'location' => false,
					'radius' => false,
					'action' => true,
					'types' => true,
					'city' => true,
					'area' => true,
					'min_rooms' => true,
					'max_rooms' => true,
					'min_bath' => true,
					'min_garage' => true,
					'min_area' => false,
					'max_area' => false,
					'price_range' => false,
					'more_search' => true
				);
				$searcg_args = apply_filters( 'zoacres_floating_search_template_args', $searcg_args );
				//Floating search 
				$float_search = $this->zoacresPropertyThemeOpt( 'single-property-floating-search' );
				if( $float_search ){
					echo '<div class="floating-search-wrap">';
						echo '<div class="container">';
							echo '<a class="btn btn-primary" data-toggle="collapse" href="#advance-search-form" aria-expanded="false">'. esc_html__( 'Advance Search', 'zoacres' ) .'</a>';
							echo '<div id="advance-search-form" class="collapse advance-search-form-accordion">';
								$this->zoacresAdvanceSearch( "", $searcg_args, "search-form-redirect" ); //"ajax-key-search"
							echo '</div>';
						echo '</div>';
					echo '</div><!-- .floating-search-wrap -->';
				}
			endif;
		}
		
		function zoacresPropertyVirtualTour( $property_id ){
			$virtual_tour_url = $this->zoacresGetPropertyMetaValue('zoacres_property_vitual_tour');
			if( $virtual_tour_url != '' ){
		?>
			<div class="property-virtual-tour-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_virtual_tour_subtitle_label', esc_html__( 'Virtual Tour', 'zoacres' ) ); ?></h4>
			</div>
		<?php
				echo do_shortcode( '[frame class="virtual-tour-frame" url="'. esc_url( $virtual_tour_url ).'" width="853" height="480" /]' );
			}
		
		}
		
		function zoacresPropertyPanorama( $property_id ){
			$image = $this->zoacresGetPropertyMetaValue('zoacres_property_360_image');
			if( $image ) {
		?>
				<div class="property-panorama-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_panorama_subtitle_label', esc_html__( '360&deg;', 'zoacres' ) ); ?></h4>
				</div>
		<?php
		
				$image_atts = wp_get_attachment_image_src( $image, 'full' );
				if( isset( $image_atts[0] ) ){
				
					echo '<div id="zoacres-panorama" data-src="'. esc_url( $image_atts[0] ) .'"></div>';
					if( is_singular( 'zoacres-property' ) ){
						wp_enqueue_style( 'pannellum' );
						wp_enqueue_script( 'pannellum' );
						
					}
				
				}
			}
		
		}
		
		function zoacresPropertyVideo( $property_id ){
			$video_type = $this->zoacresGetPropertyMetaValue('zoacres_property_video_type');
			$video_id = $this->zoacresGetPropertyMetaValue('zoacres_property_video_id');
			
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
			
			if( $video_url ){
			?>
				<div class="property-video-header clearfix">
					<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_video_subtitle_label', esc_html__( 'Property Video', 'zoacres' ) ); ?></h4>
				</div>
				<div class="property-video">
				<?php			
				if( $video_type != 'custom' ){
					echo do_shortcode( '[videoframe url="'. esc_url( $video_url ).'" width="100%" height="100%" params="byline=0&portrait=0&badge=0" /]' );
				}else{
					echo do_shortcode( '[video url="'. esc_url( $video_url ).'" width="100%" height="100%" /]' );
				}
				?>
				</div><!-- .property-video -->
				<?php
			}
		}
		
		function zoacresPropertyAgent( $property_id, $agent_id = '' ){
			$single_stat = 1;
			$col_left = 5;
			$col_right = 7;
			if( $agent_id == '' ){
				$agent_id = $this->zoacresGetPropertyMetaValue('zoacres_property_agent_id');
				$single_stat = 0;
				$col_left = 5;
				$col_right = 7;
			}
			
			$agent_type = get_post_meta( absint( $agent_id ), 'zoacres_agent_type', true );
			$agent_name = get_the_title( absint( $agent_id ) );
			
			$agent_email = get_post_meta( absint( $agent_id ), 'zoacres_agent_email', true );
			if( !$agent_email ) return;		
			
			$mobile = get_post_meta( absint( $agent_id ), 'zoacres_agent_mobile', true );
			$tele = get_post_meta( absint( $agent_id ), 'zoacres_agent_telephone', true );
			$address = get_post_meta( absint( $agent_id ), 'zoacres_agent_address', true );
			$skype = get_post_meta( absint( $agent_id ), 'zoacres_agent_skype', true );
			$website = get_post_meta( absint( $agent_id ), 'zoacres_agent_website', true );
			
			$average_ratings = get_post_meta( $agent_id, 'zoacres_agent_rating', true );
			$rating_out = $average_ratings != '' && function_exists('zoacres_star_rating') ? zoacres_star_rating( $average_ratings ) : '';
			
			$agent_title = $agent_type == 'agent' ? esc_html__( 'Agent', 'zoacres' ) : esc_html__( 'Agency', 'zoacres' );
			$agent_img_url = get_the_post_thumbnail_url( absint( $agent_id ), 'full' ); 
			$agent_url = get_post_permalink( absint( $agent_id ) );

		?>
			<?php if( !$single_stat ): ?>
			<div class="property-agent-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_agent_subtitle_label', $agent_title ." ". esc_html__( 'Details', 'zoacres' ) ); ?></h4>
			</div>
			<?php endif; ?>
			<div class="row agent-info-wrap">
				<?php if( $agent_img_url ): ?>
				<div class="col-md-<?php echo absint( $col_left ); ?>">
					<div class="agent-img-wrap">
						<img class="agent-img" src="<?php echo esc_url( $agent_img_url ); ?>" alt="<?php echo esc_attr( $agent_name ); ?>">
						<div class="agent-social-links-wrap">
							<?php
							
							if( is_singular( 'zoacres-property' ) ){
								$agent_post_id = $agent_id;
							}else{
								$agent_post_id = get_the_ID();
							}
							
							$fb = get_post_meta( $agent_post_id, 'zoacres_agent_fb_link', true );
							$twit = get_post_meta( $agent_post_id, 'zoacres_agent_twitter_link', true );
							$lnk = get_post_meta( $agent_post_id, 'zoacres_agent_linkedin_link', true );							
							$yt = get_post_meta( $agent_post_id, 'zoacres_agent_yt_link', true );
							$insta = get_post_meta( $agent_post_id, 'zoacres_agent_instagram_link', true );
						
							echo '<ul class="nav agent-social-links">';
								echo ( ''. $fb != '' ) ? '<li><a href="'. esc_url( $fb ) .'"><span class="fa fa-facebook"></span></a></li>' : '';
								echo ( ''. $twit != '' ) ? '<li><a href="'. esc_url( $twit ) .'"><span class="fa fa-twitter"></span></a></li>' : '';
								echo ( ''. $lnk != '' ) ? '<li><a href="'. esc_url( $lnk ) .'"><span class="fa fa-linkedin"></span></a></li>' : '';					
								echo ( ''. $yt != '' ) ? '<li><a href="'. esc_url( $yt ) .'"><span class="fa fa-youtube-play"></span></a></li>' : '';
								echo ( ''. $insta != '' ) ? '<li><a href="'. esc_url( $insta ) .'"><span class="fa fa-instagram"></span></a></li>' : '';
							echo '</ul>';
							?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div class="col-md-<?php echo absint( $col_right ); ?>">
					<?php if( $single_stat ): ?>
					<h5 class="mb-0 agent-name"><?php echo esc_html( $agent_name ); ?></h5>
					<?php
						$agent_position = get_post_meta( absint( $agent_id ), 'zoacres_agent_position', true );
						if( $agent_position ) echo '<span class="small-text agent-position">'. esc_html( $agent_position ) .'</span>';
					?>
					<?php else: ?>
					<h5 class="agent-name"><a href="<?php echo esc_url( $agent_url ); ?>"><?php echo esc_html( $agent_name ); ?></a></h5>
					<?php endif; ?>
					<ul class="nav flex-column bottom-space-list agent-details">
						<?php if( $mobile ): ?><li><span class="agent-mobile"><i class="icon-screen-smartphone"></i> <a href="tel:<?php echo esc_attr( preg_replace('/(\W*)/', '', $mobile) ); ?>"><?php echo esc_html( $mobile ); ?></a></span></li><?php endif; ?>
						<?php if( $tele ): ?><li><span class="agent-telephone"><i class="icon-phone"></i> <a href="tel:<?php echo esc_attr( preg_replace('/(\W*)/', '', $tele) ); ?>"><?php echo esc_html( $tele ); ?></a></span></li><?php endif; ?>
						<?php if( $address ): ?><li><span class="agent-address"><i class="icon-location-pin"></i> <?php echo esc_html( $address ); ?></span></li><?php endif; ?>
						<?php if( $skype ): ?><li><span class="agent-skype"><i class="icon-social-skype"></i> <?php echo esc_html( $skype ); ?></span></li><?php endif; ?>
						<?php if( $agent_email ): ?><li><span class="agent-email"><i class="icon-envelope-open"></i> <a href="mailto:<?php echo esc_attr( $agent_email ); ?>"><?php echo esc_html( $agent_email ); ?></a></span></li><?php endif; ?>
						<?php if( $website ): ?><li><span class="agent-website"><i class="icon-link"></i> <a href="<?php echo esc_url( $website ); ?>"><?php echo esc_html( $website ); ?></a></span></li><?php endif; ?>
						<?php if( $rating_out ): ?><li><span class="agent-rating"><?php echo esc_html__( 'Rating', 'zoacres' ); ?> <?php echo wp_kses_post( $rating_out ); ?></span></li><?php endif; ?>
					</ul>
				</div>
			</div>
		<?php
		}
		
		function zoacresPropertyAgentContent( $agent_id ){
		?>
			<div class="property-agent-desc-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_agent_desc_subtitle_label', esc_html__( 'About Me', 'zoacres' ) ); ?></h4>
			</div>
			<div class="property-agent-desc">
				<?php the_content(); ?>
				
				<?php

				$user = wp_get_current_user();
				$agent_email = $user->user_email;
				
				if( in_array( 'subscriber', (array) $user->roles ) ){
					$user_id = $user->ID;				
					
					$rated_users = get_post_meta( $agent_id, 'rated_users_list', true );
					$current_rate = 0;
					if( is_array( $rated_users ) && isset( $rated_users['ag-'.$user_id] ) ){
						$current_rate = $rated_users['ag-'.$user_id];
					}
				?>
				<div class="agent-rating-wrap">
					<h5 class="property-sub-title-inner"><?php echo apply_filters( 'zoacres_property_agent_rating_subtitle_label', esc_html__( 'Feedback', 'zoacres' ) ); ?></h5>
					<ul class="zoacres-meta-rating star-rating" data-agent="<?php echo esc_attr( $agent_id ); ?>">
						<li><span class="fa fa-minus-circle"></span></li>
						<li><span class="fa fa-star-o"></span></li>
						<li><span class="fa fa-star-o"></span></li>
						<li><span class="fa fa-star-o"></span></li>
						<li><span class="fa fa-star-o"></span></li>
						<li><span class="fa fa-star-o"></span></li>
					</ul>
					<input type="hidden" class="zoacres-meta-rating-value" value="<?php echo esc_attr( $current_rate ); ?>">
				</div>
				<?php } ?>
			</div>
		<?php		
		}
		
		function zoacresAgentAdditionalDetails( $agent_id ){
		
			$agent_experience = $this->zoacresGetPropertyMetaValue('zoacres_agent_experience');
			$agent_languages = $this->zoacresGetPropertyMetaValue('zoacres_agent_languages');
			$agent_mlsid = $this->zoacresGetPropertyMetaValue('zoacres_agent_mlsid');
			$agent_schedule = $this->zoacresGetPropertyMetaValue('zoacres_agent_schedule');
		?>
			<ul class="nav flex-column bottom-space-list agent-additional-details">
				<?php if( $agent_experience ): ?><li>
					<h6><?php echo apply_filters( 'zoacres_property_agent_experience_label', esc_html__( 'Experience:', 'zoacres' ) ); ?></h6>
					<span class="agent-experience"><?php echo esc_html( $agent_experience ); ?></span></li>
				<?php endif; ?>
				<?php if( $agent_languages ): ?><li>
					<h6><?php echo apply_filters( 'zoacres_property_agent_languages_label', esc_html__( 'Languages:', 'zoacres' ) ); ?></h6>
					<span class="agent-languages"><?php echo esc_html( $agent_languages ); ?></span></li>
				<?php endif; ?>
				<?php if( $agent_mlsid ): ?><li>
					<h6><?php echo apply_filters( 'zoacres_property_agent_mlsid_label', esc_html__( 'MLS ID:', 'zoacres' ) ); ?></h6>
					<span class="agent-mlsid"><?php echo esc_html( $agent_mlsid ); ?></span></li>
				<?php endif; ?>
				<?php if( $agent_schedule ): ?><li>
					<h6><?php echo apply_filters( 'zoacres_property_agent_schedule_label', esc_html__( 'Schedule:', 'zoacres' ) ); ?></h6>
					<span class="agent-schedule"><?php echo esc_html( $agent_schedule ); ?></span></li>
				<?php endif; ?>
			</ul>
		<?php
		}
		
		function zoacresPropertyAgentContact( $property_id, $agent_id = '' ){
		?>	
			<div class="property-item-header clearfix">
				<h4 class="property-sub-title"><?php echo apply_filters( 'zoacres_property_contact_subtitle_label', esc_html__( 'Contact', 'zoacres' ) ); ?></h4>
				<div class="pull-right">
					<a data-toggle="collapse" href="#collapseContactSchedule" role="button" aria-expanded="false" aria-controls="collapseContactSchedule"><?php echo apply_filters( 'zoacres_property_schedule_subtitle_label', esc_html__( 'Schedule to visit', 'zoacres' ) ); ?></a>
				</div>
			</div>
			<form id="agent-contact-form" name="agent-contact-form">
				<div class="agent-contact-form row">
					<span class="validatation-status"></span>
					<div class="col-md-12 collapse" id="collapseContactSchedule">
						<?php
							wp_enqueue_script( 'jquery-ui' );
							wp_enqueue_script( 'jquery-ui-datepicker' );
						?>
						<div class="row">	
							<div class="form-group col-sm-6">
								<input class="form-control" type="text" value="" id="property-customer-schedule-date" name="property-customer-schedule-date" placeholder="<?php echo esc_attr__( 'Date', 'zoacres' ); ?>">
							</div>
							<div class="form-group col-sm-6">
								<input class="form-control" type="time" value="" id="property-customer-schedule-time" name="property-customer-schedule-time">
							</div>
						</div><!-- .card -->
					</div><!-- .Collapse -->
				
					<div class="form-group col-sm-4">
						<input class="form-control" type="text" value="" id="property-customer-name" name="property-customer-name" placeholder="<?php echo esc_attr__( 'Name', 'zoacres' ); ?>">
						<?php if( $agent_id == '' ): ?>
							<input type="hidden" value="<?php echo esc_attr( $property_id ); ?>" id="property-id" name="property-id">
						<?php else: ?>
							<input type="hidden" value="<?php echo esc_attr( $agent_id ); ?>" id="agent-id" name="agent-id">
						<?php endif; ?>
					</div>
					<div class="form-group col-sm-4">
						<input class="form-control" type="email" value="" id="property-customer-email" name="property-customer-email" placeholder="<?php echo esc_attr__( 'Email', 'zoacres' ); ?>">
					</div>
					<div class="form-group col-sm-4">
						<input class="form-control" type="tel" value="" id="property-customer-tele" name="property-customer-tele" placeholder="<?php echo esc_attr__( 'Phone', 'zoacres' ); ?>">
					</div>
					<div class="form-group col-sm-12">
						<?php 
							$def_msg = '';
							if( $agent_id == '' ){
								$def_msg = esc_html__( 'Hello, I am interested in', 'zoacres' ) . "[" . get_the_title() . "]";
							}
						?>
						<textarea class="form-control" id="property-customer-msg" name="property-customer-msg" rows="3" placeholder="<?php echo esc_attr__( 'you Message', 'zoacres' ); ?>"><?php echo esc_html( $def_msg ); ?></textarea>
					</div>
					<div class="form-group col-sm-12">
						<button type="button" class="btn btn-primary property-contact-submit"><?php echo esc_html__( 'Send Email', 'zoacres' ); ?></button>
					</div>
				
				</div>
			</form>
		<?php
		}
		
		function zoacresPropertyAgentFilter( $agent_id ){

			$filter_array = array( "all" => esc_html__( 'All', 'zoacres' ) );
			
			$args = array(
				'post_type' => 'zoacres-property',
				'meta_key'   => 'zoacres_property_agent_id',
				'meta_query' => array(
					array(
						'key' => 'zoacres_property_agent_id',
						'value' => array ( $agent_id ),
						'compare' => 'IN'
					)
				)
			);
			
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				// The Loop
				
				while ( $query->have_posts() ) {
					$query->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'property-category' );
					$i = 1;
					foreach ( $terms as $term ) {
						if( array_key_exists( $term->term_id, $filter_array ) ) $i++;
						$filter_array[$term->term_id] = $term->name . " (" . $i . ")";
					}

				}
				wp_reset_postdata();
			}
			
			return $filter_array;

		}
		
		function zoacresPropertyGallery( $gallery, $thumb_size = '' ){

			$gallery_array = explode( ",", $gallery ); ?>
				<div class="zoom-gallery">
				<?php
				foreach( $gallery_array as $gal_id ): 
					$image_url = wp_get_attachment_url( $gal_id ); ?>
					<a href="<?php echo esc_url( $image_url ); ?>" title="<?php echo esc_attr( get_the_title( $gal_id ) ); ?>">
						<?php $t = wp_get_attachment_image( $gal_id, $thumb_size, "", array( "class" => "img-fluid" ) ); 
							if( $t ){
								echo wp_kses_post( $t );
							}
						?>
					</a>
				<?php
				endforeach;											
				?>
				</div><!-- .zoom-gallery -->
			<?php
		
		}
		
		function zoacresPropertyImageOverlayMetaFinal( $property_id, $place, $field_prefix = 'archive', $meta_args = array() ){
		
			if( !empty( $meta_args ) && isset( $meta_args['overlay_'. $place .'_meta'] ) ){
				$ovly_elements = isset( $meta_args['overlay_'. $place .'_meta'] ) ? $meta_args['overlay_'. $place. '_meta'] : '';
			}else{ 
				$opt_key = $field_prefix.'-propoverlay-'. esc_attr( $place ) .'meta-items';
				$ovly_elements = $this->zoacresPropertyThemeOpt($opt_key);
			}
			if( $ovly_elements ):
				$pos = array( 'Left', 'Right' );
				$stat = 0;
				
				if( !empty( $meta_args ) ){
					if( count( $ovly_elements['Left'] ) >= 1 || count( $ovly_elements['Right'] ) >= 1 ) $stat = 1;
				}else{
					if( count( $ovly_elements['Left'] ) > 1 || count( $ovly_elements['Right'] ) > 1 ) $stat = 1;
				}

				foreach ( $pos as $ot_pos ){
					$class = $ot_pos == 'Right' ? ' pull-right' : ' pull-left';
					
					$ot_elements = isset( $ovly_elements[$ot_pos] ) ? $ovly_elements[$ot_pos] : '';
					if( is_array( $ot_elements ) && array_key_exists( "placebo", $ot_elements ) ) unset( $ot_elements['placebo'] );
					if ( $ot_elements ): 
						echo '<ul class="nav property-meta'. esc_attr( $class ) .'">';
						foreach ( $ot_elements as $element => $value ) {
							switch( $element ) {
								case "featured-ribb":
									$featured_status = $this->zoacresGetPropertyMetaValue('zoacres_post_featured_stat');
									if( $featured_status ): 
										echo '<li class="property-ribbon"><span class="ribbon-text ribbon-featured">'. esc_html__( 'Featured', 'zoacres' ) .'</span></li>';
									endif;
								break;
								
								case "other-ribb":
									$property_ribbon = $this->zoacresPropertyThemeOpt( 'property-ribbon-colors' );
									$property_ribbon_arr = zoacres_trim_array_color_labels( $property_ribbon );
									$property_status = $this->zoacresGetPropertyMetaValue('zoacres_property_status');
									if( $property_status ):
										foreach( $property_status as $status ){
											if( isset( $property_ribbon_arr[$status] ) ){
												echo '<li class="property-ribbon"><span class="ribbon-text ribbon-bg-'. esc_attr( $status ) .'">'. esc_html( $property_ribbon_arr[$status] ) .'</span></li>';
											}
										}
									endif;
								break;
								
								case "address":
									$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
									$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
									$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
									$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
									$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
									$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
									echo '<li class="property-area"><span class="icon-location-pin"></span> <a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, <a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a></li>';
								break;
								
								case "gallery":
									$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
									if( $gallery  ): 
										echo '<li class="property-gallery">';
											echo '<a href="#" title="'. esc_attr__( 'Gallery', 'zoacres' ) .'"><span class="fa fa-camera"></span></a>';
											echo '<div class="property-gallery-container">';
												echo '<div class="property-gallery-inner">';
													$this->zoacresPropertyGallery( $gallery, "thumbnail" );
												echo '</div><!-- .property-gallery-inner -->';
											echo '</div>';
										echo '</li>';
									endif;
								break;
								
								case "favourite":
									
									$this->zoacresGetPropertyFavMeta( $property_id );
									
								break;
								
								case "video":
									$video_type = $this->zoacresGetPropertyMetaValue('zoacres_property_video_type');
									$video_id = $this->zoacresGetPropertyMetaValue('zoacres_property_video_id');
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
									if( $video_url ):
										echo '<li class="property-video tooltip-parent"><a class="popup-video-post" href="'. esc_url( $video_url ) .'"><span class="icon-camrecorder"></span>
										</a><span class="tooltip-title">'. esc_html__( 'Video', 'zoacres' ) .' </span></li>';
									endif;								
								break;
								
								case "compare":
									$prop_img_url = get_the_post_thumbnail_url( $property_id, 'medium' );
									echo '<li class="property-compare tooltip-parent"><a class="prop-compare" href="#" data-id="'. esc_attr( $property_id ) .'" data-img="'. esc_url( $prop_img_url ) .'"><span class="icon-equalizer"></span></a><span class="tooltip-title">'. esc_html__( 'Compare', 'zoacres' ) .' </span></li>';
								break;
								
								case "price":
								?>
									<li class="property-price">
										<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
									</li>
								<?php
								break;
							}
						}
						echo '</ul>';
					endif;
				}
			endif;
			
		}
		
		function zoacresPropertyImageOverlayMeta( $property_id, $field_prefix = 'archive', $meta_args = array() ){
		
			$overlay_items = isset( $meta_args['overlay_items'] ) ? $meta_args['overlay_items'] : array( 'Top', 'Bottom' );
			if( $overlay_items ):
				$pos = array( 'Top', 'Bottom' );
				foreach ( $pos as $element ){

					$top_elements = $overlay_items[$element];
					$place = $element == 'Top' ? 'top' : 'bottom';
					echo '<div class="overlay-details overlay-'. esc_attr( $place ) .'">';
					foreach ( $top_elements as $key => $val ){
						switch( $key ){
							case "top-meta":
								echo '<div class="overlay-top-meta-wrap">';
									$this->zoacresPropertyImageOverlayMetaFinal( $property_id, "top", $field_prefix, $meta_args );
								echo '</div>';
							break;
							
							case "bottom-meta":
								echo '<div class="overlay-bottom-meta-wrap">';
									$this->zoacresPropertyImageOverlayMetaFinal( $property_id, "bottom", $field_prefix, $meta_args );
								echo '</div>';
							break;
							
							case "title":
								echo '<div class="property-overlay-title">
									<h5><a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'">'. esc_html( get_the_title() ) .'</a></h5>
								</div>';
							break;
						}
					}
					echo '</div>';

				}
			endif;
			
		}
		
		function zoacresPropertyImageMeta( $property_id, $place, $field_prefix = 'archive', $meta_args = array() ){
			if( !empty( $meta_args ) && isset( $meta_args[$place.'_meta'] ) ){
				$ovly_elements = isset( $meta_args[$place.'_meta'] ) ? $meta_args[$place.'_meta'] : '';
			}else{ 
				$opt_key = $field_prefix.'-property-'. esc_attr( $place ) .'meta-items';
				$ovly_elements = $this->zoacresPropertyThemeOpt($opt_key);
			}
			if( $ovly_elements ):
				$pos = array( 'Left', 'Right' );
				$stat = 0;
				
				if( !empty( $meta_args ) ){
					if( count( $ovly_elements['Left'] ) >= 1 || count( $ovly_elements['Right'] ) >= 1 ) $stat = 1;
				}else{
					if( count( $ovly_elements['Left'] ) > 1 || count( $ovly_elements['Right'] ) > 1 ) $stat = 1;
				}
				
				if( $stat ){
					$parent_class = ' property-' . esc_attr( $place ) . '-meta';
					echo '<div class="property-meta-wrap'. esc_attr( $parent_class ) .'">';
				}
				foreach ( $pos as $ot_pos ){
					$class = $ot_pos == 'Right' ? ' pull-right' : ' pull-left';
					
					$ot_elements = isset( $ovly_elements[$ot_pos] ) ? $ovly_elements[$ot_pos] : '';
					if( is_array( $ot_elements ) && array_key_exists( "placebo", $ot_elements ) ) unset( $ot_elements['placebo'] );
					if ( $ot_elements ): 
						echo '<ul class="nav property-meta'. esc_attr( $class ) .'">';
						foreach ( $ot_elements as $element => $value ) {
							switch( $element ) {
								case "bed":
									$bed_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bed_rooms');
									if( $bed_rooms ):
										echo '<li class="property-bed-rooms"><span class="flaticon-slumber"></span> '. esc_html__( 'Beds', 'zoacres' ) .' '. esc_html( $bed_rooms ) .'</li>';
									endif;
								break;
								
								case "bath":
									$bath_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bath_rooms');
									if( $bath_rooms ):
										echo '<li class="property-bath-rooms"><span class="flaticon-bathtub"></span> '. esc_html__( 'Baths', 'zoacres' ) .' '. esc_html( $bath_rooms ) .'</li>';
									endif;
								break;
								
								case "size":
									$size = $this->zoacresGetPropertyMetaValue('zoacres_property_size');
									$units = $this->zoacresGetPropertyUnits();
									if( $size ):
										echo '<li class="property-size"><span class="flaticon-area-chart"></span> '. esc_html( $size ) .' <span class="property-units">'. esc_html( $units ) .'</span></li>';
									endif;
								break;
								
								case "price":
								?>
									<li class="property-price">
										<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
									</li>
								<?php
								break;
								
								case 'garage': 
									$no_garages = $this->zoacresGetPropertyMetaValue('zoacres_property_no_garages');
									if( $no_garages ): 
										echo '<li class="property-garages"><span class="flaticon-car-engine"></span> '. esc_html( $no_garages ) .'</li>';
									endif;
								break;
								
								case "more":
									$read_more = '';
									if( isset( $meta_args['more_text'] ) && $meta_args['more_text'] != '' ){
										$read_more = $meta_args['more_text'];
									}else{
										$read_more = $this->zoacresPropertyThemeOpt( $field_prefix.'-propery-more' );
									}
									if( $read_more ):
										echo '<li class="property-read-more"><a href="'. esc_url( get_the_permalink() ) .'" class="btn btn-sm btn-primary">'. esc_html( $read_more ) .'</a></li>';
									endif;
								break;	
								
								case "agent":
									$agent_id = $this->zoacresGetPropertyMetaValue('zoacres_property_agent_id');
									if( $agent_id != '1' ){
										$agent_name = get_the_title( absint( $agent_id ) );
										$agent_url = get_post_permalink( absint( $agent_id ) );
										$agent_img_url = get_the_post_thumbnail_url( absint( $agent_id ), 'thumbnail' ); 
										
										if( empty( $agent_img_url ) ) $agent_img_url = ZOACRES_ASSETS . "/images/no-img.jpg";
		
										echo '<li><div class="property-agent"><img src="'. esc_url( $agent_img_url ) .'" class="img-fluid" alt="'. esc_attr( $agent_name ) .'" /> <a href="'. esc_url( $agent_url ) .'" class="agent-name" title="'. esc_attr( $agent_name ) .'">'. esc_html( $agent_name ) .'</a></div></li>';
									}else{
										echo '<li><div class="property-agent">'. get_avatar( get_the_author_meta('email'), '30' ) .' <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) .'">'. get_the_author() .'</a></div></li>';
									}
								break;	
								
								case "social":
									
									$posts_shares = $this->zoacresPropertyThemeOpt( 'post-social-shares' );
									
									if( $posts_shares ){
										echo '<li class="property-share">
												<span class="icon-share share-toggle"></span>
												<div class="social-links-wrap">
													<ul class="nav flex-column social-links">';
										
										$prop_link = get_the_permalink();
										$prop_title = get_the_title();
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $property_id ), 'large' );
										$img_url = isset( $image[0] ) ? $image[0] : '';
									
										foreach ( $posts_shares as $social_share ){
											switch( $social_share ){
												case "fb": 
													echo '<li><a href="http://www.facebook.com/sharer.php?u='. esc_url( $prop_link ) .'&t='. esc_url( $prop_title ) .'" title="'. esc_attr__( 'Share with facebook', 'zoacres' ) .'" target="_blank"><span class="fa fa-facebook"></span></a></li>';
												break; // fb
												
												case "twitter": 
													echo '<li><a href="http://twitter.com/home?status=Reading:'. urlencode( $prop_title ) .'-'.  esc_url( home_url( '/' ) )."/?p=". esc_attr( $property_id ) .'" title="'. esc_attr__( 'Share with twitter', 'zoacres' ) .'" target="_blank"><span class="fa fa-twitter"></span></a></li>';
												break; // twitter
												
												case "linkedin": 
													echo '<li><a href="http://www.linkedin.com/shareArticle?mini=true&url='. urlencode( $prop_link ) .'&title='. urlencode( $prop_title ) .'&summary=&source='. urlencode( get_bloginfo('name') ) .'" title="'. esc_attr__( 'Share with linkedin', 'zoacres' ) .'" target="_blank"><span class="fa fa-linkedin"></span></a></li>';	
												break; // linkedin
											
												
												case "pinterest": 
													echo '<li><a href="http://pinterest.com/pin/create/button/?url='. urlencode( $prop_link ) .'&amp;media='. esc_url( $img_url ) .'&description='. urlencode( $prop_title ) .'" title="'. esc_attr__( 'Share with pinterest', 'zoacres' ) .'" target="_blank"><span class="fa fa-pinterest"></span></a></li>';
												break; // pinterest											
												
											}
										}
										echo '		</ul>
												</div>
											</li>';
									} //posts_shares
								break;
								
								case "address":
									$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
									$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
									$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
									$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
									$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
									$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
									echo '<li class="property-area"><span class="icon-location-pin"></span> <a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, <a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a></li>';
								break;
								
								case "gallery":
									$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
									if( $gallery  ): 
										echo '<li class="property-gallery">';
											echo '<a href="#" title="'. esc_attr__( 'Gallery', 'zoacres' ) .'"><span class="icon-camera"></span></a>';
											echo '<div class="property-gallery-container">';
												echo '<div class="property-gallery-inner">';
													$this->zoacresPropertyGallery( $gallery, "thumbnail" );
												echo '</div><!-- .property-gallery-inner -->';
											echo '</div>';
										echo '</li>';
									endif;
								break;
								
								case "favourite":
									
									$this->zoacresGetPropertyFavMeta( $property_id );
									
								break;
								
								case "video":
									$video_type = $this->zoacresGetPropertyMetaValue('zoacres_property_video_type');
									$video_id = $this->zoacresGetPropertyMetaValue('zoacres_property_video_id');
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
									if( $video_url ):
										echo '<li class="property-video tooltip-parent"><a class="popup-video-post" href="'. esc_url( $video_url ) .'"><span class="icon-camrecorder"></span>
										</a><span class="tooltip-title">'. esc_html__( 'Video', 'zoacres' ) .' </span></li>';
									endif;								
								break;
								
								case "compare":
									$prop_img_url = get_the_post_thumbnail_url( $property_id, 'medium' );
									echo '<li class="property-compare tooltip-parent"><a class="prop-compare" href="#" data-id="'. esc_attr( $property_id ) .'" data-img="'. esc_url( $prop_img_url ) .'"><span class="icon-equalizer"></span></a><span class="tooltip-title">'. esc_html__( 'Compare', 'zoacres' ) .' </span></li>';
								break;
													
							}//switch
						}
						echo '</ul>';
					endif;
				}
				if( $stat ){
					echo '</div>';
				}
			endif;
		}
		
		function zoacresPropertyImage( $property_id, $thumb_size, $field_prefix = 'archive', $meta_args = array() ) {
			/* grab the url for the full size featured image */
			
			$img_out = '';
			if( is_array( $thumb_size ) ){
				$img_prop = zoacres_custom_image_size_chk( "", $thumb_size, $property_id );
				$img_out = '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid" alt="'. esc_attr( get_the_title() ) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
			}else{
				$property_img_url = get_the_post_thumbnail_url( absint( $property_id ), $thumb_size );
				$img_out = '<img src="'. esc_url( $property_img_url ) .'" alt="'. esc_attr( get_the_title() ) .'" class="img-fluid" />';
			}
			
			echo apply_filters( 'zoacres_property_img_without_link', $img_out );
			
			if( !isset( $meta_args['shortcode_stat'] ) ){//&& isset( $meta_args['overlay_opt'] ) && $meta_args['overlay_opt'] == true ){
				echo '<div class="overlay-details overlay-top">';
					echo '<div class="overlay-top-meta-wrap">';
						$this->zoacresPropertyImageOverlayMetaFinal( $property_id, "top", $field_prefix, $meta_args );
					echo '</div>';
				echo '</div>';
				echo '<div class="overlay-details overlay-bottom">';
					echo '<div class="overlay-bottom-meta-wrap">';
						$this->zoacresPropertyImageOverlayMetaFinal( $property_id, "bottom", $field_prefix, $meta_args );
					echo '</div>';
				echo '</div>';
			}elseif( isset( $meta_args['overlay_opt'] ) && $meta_args['overlay_opt'] == true ){
				$this->zoacresPropertyImageOverlayMeta( $property_id, $field_prefix, $meta_args );
			}
		}
		
		function zoacresPropertiesArchive( $args, $prop_elements, $field_prefix = 'archive', $col_class = 'col-md-4', $meta_args = array() ){
			
			$property_layout = '';
			$list_stat = 0;
			
			$prop_lay = '';
			$prop_lay = $this->zoacresPropertyThemeOpt( "property-layout" );
			
			if( isset( $meta_args['agent'] ) && $meta_args['agent'] == true ){
				$prop_lay = $this->zoacresPropertyThemeOpt( "archive-agent-property-layout" );
			}
			
			if( isset( $meta_args['layout'] ) && $meta_args['layout'] != '' ){
				$prop_lay = $meta_args['layout'];
			}
			
			$property_layout = ' property-' . $prop_lay;
			if( $prop_lay == 'list' ){
				$list_stat = 1;
				$col_class = 'col-md-12';
			}
			
			$img_size = '';
			if( isset( $meta_args['img_size'] ) && $meta_args['img_size'] != '' ){
				$img_size = $meta_args['img_size'];
			}else{
				$img_size = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-size" );
			}
			
			$property_layout .= isset( $meta_args['animation'] ) && $meta_args['animation'] == true ? ' zoacres-animate' : '';
			
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				// The Loop
						
			?>
				<div class="row">
			<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$property_id = get_the_ID();

				?>
					<div class="<?php echo esc_attr( $col_class ); ?>">
						<div class="property-wrap<?php echo esc_attr( $property_layout ); ?>">
							
							<?php

								if( $list_stat ){
									if( isset( $prop_elements['image'] ) ){
										echo '<div class="property-image-wrap">';
											if( $img_size == "custom" ){
												$img_csize = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-csize");
												$wdth = isset( $img_csize['width'] ) ? $img_csize['width'] : '';
												$hgt = isset( $img_csize['height'] ) ? $img_csize['height'] : '';
												$img_size = array( $wdth, $hgt );
											}
											$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix, $meta_args );
										echo '</div>';
									}
									echo '<div class="property-list-wrap">';
								}
							
								if ( $prop_elements ): 
									foreach ( $prop_elements as $element => $value ) {
										switch( $element ) {
											case "image":
												if( !$list_stat ){
													echo '<div class="property-image-wrap">';
														if( $img_size == "custom" ){
															$img_csize = $this->zoacresPropertyThemeOpt( $field_prefix."-propery-thumb-csize");
															$wdth = isset( $img_csize['width'] ) ? $img_csize['width'] : '';
															$hgt = isset( $img_csize['height'] ) ? $img_csize['height'] : '';
															$img_size = array( $wdth, $hgt );
														}
														$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix, $meta_args );
													echo '</div>';
												}
											break;
											
											case "title":
											?>
												<div class="property-title-wrap">
													<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
												</div>
											<?php
											break;
											
											case "price":
											?>
												<div class="property-price-wrap">
													<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
												</div>
											<?php
											break;
											
											case "excerpt":
												$excerpt_len = $this->zoacresSetPropertyExcerptLength( 15 );
												add_filter( 'excerpt_length', __return_value( $excerpt_len ) );
											?>
												<div class="property-excerpt-wrap">
													<?php the_excerpt(); ?>
												</div>
											<?php
											break;
											
											case "tm":
												$this->zoacresPropertyImageMeta( $property_id, 'top', $field_prefix, $meta_args );
											break;
											
											case "bm":
												$this->zoacresPropertyImageMeta( $property_id, 'bottom', $field_prefix, $meta_args );
											break;
											
										}
									}
								endif;
								
								if( $list_stat ){
									echo '</div><!-- .property-list-wrap -->';
								}
								
								if( isset( $meta_args['agent_page'] ) && $meta_args['agent_page'] && is_user_logged_in() ){
								?>
									<div class="user-settings-wrap" data-id="<?php echo esc_attr( $property_id ); ?>">
										<div class="user-settings-inner">
											<div class="user-settings-icons">
												<ul class="nav settings-icons">
													<li class="nav-item">
														<div class="tooltip-parent">
															<a href="#" class="user-property-remove"><span class="icon-close icons" data-toggle="modal" data-target="#propertyDeleteModal"></span></a>
															<span class="tooltip-title"><?php esc_html_e( 'Remove', 'zoacres' ); ?></span>
														</div>
													</li>
													<li class="nav-item">
														<div class="tooltip-parent">
															<?php
																$auth_pages = get_pages(array(
																	'meta_key' => '_wp_page_template',
																	'meta_value' => 'zoacres-property-edit.php'
																));
																if( $auth_pages ){
																	$auth_dash_link = get_permalink( $auth_pages[0]->ID );
																	$auth_dash_link = add_query_arg( 'property', $property_id, $auth_dash_link );
																}else{
																	$auth_dash_link = '#';
																} 
															?>
															<a href="<?php echo esc_attr( $auth_dash_link ); ?>" class="user-property-edit"><span class="icon-pencil icons"></span></a>
															<span class="tooltip-title"><?php esc_html_e( 'Edit', 'zoacres' ); ?></span>
														</div>
													</li>
													<li class="nav-item">
														<div class="tooltip-parent">
															<?php 
																$featured_status = $this->zoacresGetPropertyMetaValue('zoacres_post_featured_stat');	
																$featured_class = $featured_status ? ' featured-active' : '';
															?>
															<a href="#" class="user-property-featured<?php echo esc_attr( $featured_class ); ?>"><span class="fa fa-star"></span></a>
															<span class="tooltip-title"><?php esc_html_e( 'Featured', 'zoacres' ); ?></span>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- Modal -->
									<div class="modal fade property-delete-modal" id="propertyDeleteModal" tabindex="-1" role="dialog" aria-labelledby="propertyDeleteModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
										<div class="modal-content">
										<div class="modal-header">
										<h5 class="modal-title" id="propertyDeleteModalLabel"><?php esc_html_e( 'Delete', 'zoacres' ); ?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_html_e( 'Close', 'zoacres' ); ?>"></button>
										</div>
											<div class="modal-body">
												<?php esc_html_e( 'Are you sure want to delete?', 'zoacres' ); ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary user-property-remove-confirm" data-dismiss="modal"><?php esc_html_e( 'Yes', 'zoacres' ); ?></button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e( 'No', 'zoacres' ); ?></button>
											</div>
										</div>
										</div>
									</div>
									<div class="property-agent-process">
										<div class="property-agent-process-inner">
											<img src="<?php echo esc_url( ZOACRES_ASSETS . '/images/infinite-loder.gif' ); ?>" alt="<?php esc_attr_e('Loader', 'zoacres'); ?>" />
										</div>
									</div>
								<?php
								}
								
							?>						
							
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<?php

				if( isset( $meta_args['pagination'] ) && $meta_args['pagination'] == 'on' ){
					$aps = new ZoacresPostSettings;
					$args = array( 'custom_query' => $query );
					$aps->zoacresWpBootstrapPagination($args);
				}
				
				wp_reset_postdata();
			}
				
		}
		
		function zoacresPropertiesArchiveShortcode( $args, $prop_elements, $field_prefix = 'archive', $col_class = 'col-md-4', $meta_args = array() ){
			
			$property_layout = '';
			$list_stat = 0;
			$slide_stat = 0; $data_atts = '';
			
			if( !empty( $meta_args ) ){
				if( isset( $meta_args['layout'] ) ){
					$property_layout = ' property-' . $meta_args['layout'];
					if( $meta_args['layout'] == 'list' ){
						$list_stat = 1;
					}
				}			
				$property_layout .= isset( $meta_args['text_align'] ) && $meta_args['text_align'] != '' ? ' text-'.$meta_args['text_align'] : '';
				$slide_stat = isset( $meta_args['slide_stat'] ) ? $meta_args['slide_stat'] : 0;
				$data_atts = isset( $meta_args['data_atts'] ) ? $meta_args['data_atts'] : '';
			}

			if( isset( $meta_args['slide_stat'] ) && $meta_args['slide_stat'] ){
				$slide_stat = 1;
				$data_atts = isset( $meta_args['data_atts'] ) ? $meta_args['data_atts'] : '';
				if( strpos( $col_class, "zoacres-animate" ) ){
					$col_class = ' property-item zoacres-animate';
				}else{
					$col_class = ' property-item';
				}
				
			}
			
			if( isset( $meta_args['pagination'] ) && $meta_args['pagination'] == 'on' ){
				if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
				elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
				else { $paged = 1; }
				$args['paged'] = $paged;
			}
			
			$meta_args['shortcode_stat'] = true;
			
			$image_wrap_class = isset( $meta_args['dark_overlay'] ) ? $meta_args['dark_overlay'] : '';

			$query = new WP_Query( $args );
			//print_r( $query );
			if ( $query->have_posts() ) {
				// The Loop
			
				if( $slide_stat ){
					echo '<div class="owl-carousel" '. ( $data_atts ) .'>';	
				}else{
					echo '<div class="row">';
				}
			
				while ( $query->have_posts() ) {
					$query->the_post();
					$property_id = get_the_ID();

				?>
					<div class="<?php echo esc_attr( $col_class ); ?>">
						<div class="property-wrap<?php echo esc_attr( $property_layout ); ?>">
							
							<?php
								if ( $prop_elements ): 

									if( $list_stat && is_array( $prop_elements ) && !isset( $prop_elements['image'] ) ){
										echo '<div class="property-list-wrap property-list-no-image">';
									}
								
									foreach ( $prop_elements as $element => $value ) {
									
										switch( $element ) {
											case "image":
												if ( has_post_thumbnail() ) {
													echo '<div class="property-image-wrap'. esc_attr( $image_wrap_class ) .'">';
														$img_size = isset( $meta_args['img_size'] ) ? $meta_args['img_size'] : 'medium';
														if( $img_size == "custom" ){
															$cus_thumb_size = isset( $meta_args['img_csize'] ) ? $meta_args['img_csize'] : '500x500';
															$custom_opt = $cus_thumb_size != '' ? explode( "x", $cus_thumb_size ) : array();
															$img_prop = zoacres_custom_image_size_chk( $img_size, $custom_opt );
															$img_size = array( $img_prop[1], $img_prop[2] );
														}
														if( isset( $meta_args['gallery_opt'] ) && $meta_args['gallery_opt'] == 'yes' ){
															//Gallery Part
															
															$gallery = $this->zoacresGetPropertyMetaValue('zoacres_property_gallery');
															if( $gallery  ): 
																$gallery_array = explode( ",", $gallery ); ?>
																<div class="property-archive-gallery">
																	<?php
																	foreach( $gallery_array as $gal_id ): 
																		$image_url = wp_get_attachment_url( $gal_id );
																		$t = wp_get_attachment_image( $gal_id, $img_size, "", array( "class" => "img-fluid" ) ); 
																		if( $t ){
																			echo '<div class="item">';
																				echo wp_kses_post( $t );
																			echo '</div>';
																		}
																	endforeach;
																	?>
																</div><!-- .zoom-gallery --> <?php
																//connect the slick js
																wp_enqueue_style( 'slick' );
																wp_enqueue_script( 'slick' );
																
																if( !isset( $meta_args['shortcode_stat'] ) ){
																	echo '<div class="overlay-details overlay-top">';
																		echo '<div class="overlay-top-meta-wrap">';
																			$this->zoacresPropertyImageOverlayMetaFinal( $property_id, 'top', 'archive', $meta_args );
																		echo '</div>';
																	echo '</div>';
																	echo '<div class="overlay-details overlay-bottom">';
																		echo '<div class="overlay-bottom-meta-wrap">';
																			$this->zoacresPropertyImageOverlayMetaFinal( $property_id, 'bottom', 'archive', $meta_args );
																		echo '</div>';
																	echo '</div>';
																}elseif( isset( $meta_args['overlay_opt'] ) && $meta_args['overlay_opt'] == true ){
																	$this->zoacresPropertyImageOverlayMeta( $property_id, $field_prefix, $meta_args );
																};
																
															else:
																$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix, $meta_args );
															endif;
															
														}else{
															$this->zoacresPropertyImage( $property_id, $img_size, $field_prefix, $meta_args );
														}
													echo '</div>';
												}
												if( $list_stat ){
													echo '<div class="property-list-wrap">';
												}
											break;
											
											case "title":
											?>
												<div class="property-title-wrap">
													<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
												</div>
											<?php
											break;
											
											case "price":
											?>
												<div class="property-price-wrap">
													<?php $this->zoacresGetPropertyPrice('span', 'div'); ?>
												</div>
											<?php
											break;
											
											case "excerpt":
												$excerpt_len = $this->zoacresSetPropertyExcerptLength( 15 );
												add_filter( 'excerpt_length', __return_value( $excerpt_len ) );
											?>
												<div class="property-excerpt-wrap">
													<?php the_excerpt(); ?>
												</div>
											<?php
											break;
											
											case "tm":
												$this->zoacresPropertyImageMeta( $property_id, 'top', $field_prefix, $meta_args );
											break;
											
											case "bm":
												$this->zoacresPropertyImageMeta( $property_id, 'bottom', $field_prefix, $meta_args );
											break;
											
											case "address":
												$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
												$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
												$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
												$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
												$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
												$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
												echo '<div class="property-area"><span class="icon-location-pin"></span> ';
												echo ( ''. $property_area_link != '' ) ? '<a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, ' : '';
												echo ( ''. $property_city_link != '' ) ? '<a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a>' : '';
												echo '</div>';
											break;
											
											case "title-address":
											?>
												<div class="property-title-address-wrap">
													<div class="property-title-wrap">
														<h5><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
													</div>
													<?php
													$property_area = zoacres_get_property_tax_link( $property_id, 'property-area' );
													$property_area_name = isset( $property_area['name'] ) ? $property_area['name'] : '';
													$property_area_link = isset( $property_area['link'] ) ? $property_area['link'] : '';
													$property_city = zoacres_get_property_tax_link( $property_id, 'property-city' );
													$property_city_name = isset( $property_city['name'] ) ? $property_city['name'] : '';
													$property_city_link = isset( $property_city['link'] ) ? $property_city['link'] : '';
													echo '<div class="property-area"><span class="icon-location-pin"></span> ';
													echo ( ''. $property_area_link != '' ) ? '<a href="'. esc_url( $property_area_link ) .'" title="'. esc_attr( $property_area_name ) .'">'. esc_html( $property_area_name ) .'</a>, ' : '';
													echo ( ''. $property_city_link != '' ) ? '<a href="'. esc_url( $property_city_link ) .'" title="'. esc_attr( $property_city_name ) .'">'. esc_html( $property_city_name ) .'</a>' : '';
													echo '</div>';
												?>
												</div><!-- .property-title-address-wrap -->
												<?php
											break;
											
										}

									}
									
									if( $list_stat ){
										echo '</div><!-- .property-list-wrap -->';
									}
									
								endif;
							?>						
							
						</div>
					</div>
				<?php
				}
				?>
				</div><!-- .row/.owl-carousel -->
				<?php
				
				if( isset( $meta_args['pagination'] ) && $meta_args['pagination'] == 'on' ){
					$aps = new ZoacresPostSettings;
					$aps->zoacresWpBootstrapPagination( $args, $query->max_num_pages, true );
				}
				
				wp_reset_postdata();
			}
				
		}
		
		function zoacresHalfMapProperties( $args = array() ){
			
			$map_array = array();
			
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$property_id = get_the_ID();
					$property_title = get_the_title();
					$property_link = get_the_permalink();
					$lat = $this->zoacresGetPropertyMetaValue('zoacres_property_latitude');
					$lang = $this->zoacresGetPropertyMetaValue('zoacres_property_longitude');
					$address = $this->zoacresGetPropertyMetaValue('zoacres_property_address');
					
					$img_url = get_the_post_thumbnail_url( $property_id,'zoacres-grid-small' );
					$prop_img = '<img src="'. esc_url( $img_url ) .'" class="img-fluid" />';
					//$info_wrap = '<div class="info-wrap">'. $prop_img .'<p>'. $address .'</p></div>';
					
					$no_bed_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bed_rooms');
					$no_bath_rooms = $this->zoacresGetPropertyMetaValue('zoacres_property_no_bath_rooms');
					$size = $this->zoacresGetPropertyMetaValue('zoacres_property_size');
					
					$property_category = zoacres_get_property_tax_link( $property_id, 'property-category' );
					$prop_cat_link = isset( $property_category['link'] ) ? $property_category['link'] : '';
					$prop_cat_name = isset( $property_category['name'] ) ? $property_category['name'] : '';

					ob_start();
					$this->zoacresGetPropertyPrice( 'span' );
					$property_price = ob_get_clean();
					
					$info_wrap = '<div class="info-wrap">';
						$info_wrap .= '<div class="info-img-wrap">';
							$info_wrap .= $prop_img;
							$info_wrap .= '<div class="info-img-overlay">' . $property_price . '</div>';
						$info_wrap .= '</div>';
						
					$info_wrap .= '</div>';
					$info_wrap .= '<div class="info-content-wrap">';
						$info_wrap .= '<h6><a href="'. esc_url( $property_link ) .'">'. esc_html( $property_title ) .'</a></h6>';
						$info_wrap .= '<p><span class="property-address">'. esc_html( $address ) .'<span></p>';
						$info_wrap .= '<ul class="nav property-meta">';
							$info_wrap .= '<li><span><i class="flaticon-slumber"></i>'. esc_html( $no_bed_rooms ) .'</span></li>';
							$info_wrap .= '<li><span><i class="flaticon-bathtub"></i>'. esc_html( $no_bath_rooms ) .'</span></li>';
							$info_wrap .= '<li><span><i class="flaticon-area-chart"></i>'. esc_html( $size ) .'</span></li>';
						$info_wrap .= '</ul>';
						$info_wrap .= '<p><a href="'. esc_url( $prop_cat_link ) .'" class="property-category">'. esc_html( $prop_cat_name ) .'<span></p>';
					$info_wrap .= '</div>';
					
					$marker_url = $this->zoacresPropertyThemeOpt( 'map-marker' );

					$terms = get_the_terms( $property_id, 'property-category' );
					$prop_cat_id = '';
					if ( $terms && ! is_wp_error( $terms ) ){
						if( isset( $terms[0] ) ){
							$prop_cat_id = $terms[0]->term_id;
							$img_id = get_term_meta ( $prop_cat_id, 'property-category-image-id', true );
							$img_attr = wp_get_attachment_image_src( $img_id, 'full' );
							$marker_url = isset( $img_attr[0] ) ? $img_attr[0] : $marker_url;
						}
					}
					
					array_push( $map_array, array(
							"map_latitude" => esc_attr( $lat ),
							"map_longitude" => esc_html( $lang ),
							"map_marker" => $marker_url,
							"map_info_opt" => "on",
							"map_info_title" => esc_html( $property_title ),
							"map_info_html" => '1',
							"map_info_address" => $info_wrap,
						)
					);
					
				}
				wp_reset_postdata();
				
			}

			return $map_array;
			
		}
		
		function zoacresHalfMapPropertiesMakeMap( $map_array = array(), $map_args = array() ){
			if( !empty( $map_array ) ){
				$m_map = json_encode( $map_array );
			
				$default_mstyle = '[]';
				$multi_map = $m_map;
				$map_zoom = '10';
				$scroll_wheel = 'false';
				$property_nav = '';
				
				if( isset( $map_args['zoom'] ) && $map_args['zoom'] != '' ){
					$map_zoom = $map_args['zoom'];
				}
				$height = '600px';
				if( isset( $map_args['height'] ) && $map_args['height'] != '' ){
					$height = $map_args['height'];
				}
				$myloc = false;
				if( isset( $map_args['my_location'] ) && $map_args['my_location'] != '' ){
					$myloc = $map_args['my_location'];
				}
				
				echo '<div class="container"><div class="row"><div class="col-md-12">';
					echo '<div class="property-map-items map-items-left">';
						echo '<ul class="nav">';
							if( isset( $map_args['zoom_control'] ) && $map_args['zoom_control'] ){
								echo '<li class="nav-item">';
									echo '<div class="property-map-nav-wrap">';
										echo '<ul class="nav zoacres-map-zoomparent" data-index="0">
												<li><button id="zoacres-map-zoomplus" class="btn zoacres-map-zoomin"><span><i class="icon-plus icons"></i></span></button></li>
												<li><button id="zoacres-map-zoomminus" class="btn zoacres-map-zoomout"><span><i class="icon-minus icons"></i></span></button></li>	
											</ul>';
									echo '</div><!-- .property-map-nav-wrap -->';
								echo '</li>';
							}
							if( isset( $map_args['location_search'] ) && $map_args['location_search'] ){
								echo '<li class="nav-item">';
									echo '<div class="property-location-search">';
										echo '<input type="text" id="map-location-search-form" class="form-control" value="" placeholder="'. esc_attr__('Location', 'zoacres') .'">';
									echo '</div>';
								echo '</li>';
							}
						echo '</ul>';
					echo '</div><!-- .property-map-items -->';
					
					echo '<div class="property-map-items">';
						echo '<ul class="nav">';
						if( isset( $map_args['map_style'] ) && $map_args['map_style'] ){
							echo '<li class="nav-item">';
								echo '<div class="property-map-style-wrap">
										<button class="btn dropdown-toggle map-style-toggle" type="button" id="mapStyleMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="map-style-icon"><i class="icon-map icons"></i>'. esc_html__( 'Map Style', 'zoacres' ) .'</span></button>
										<div class="dropdown-menu map-style-dropdown-menu" aria-labelledby="mapStyleMenu">
											<a class="dropdown-item" href="#" data-style="roadmap">'. esc_html__( 'Roadmap', 'zoacres' ) .'</a>
											<a class="dropdown-item" href="#" data-style="satellite">'. esc_html__( 'Satellite', 'zoacres' ) .'</a>
											<a class="dropdown-item" href="#" data-style="hybrid">'. esc_html__( 'Hybrid', 'zoacres' ) .'</a>
											<a class="dropdown-item" href="#" data-style="terrain">'. esc_html__( 'Terrain', 'zoacres' ) .'</a>
										</div>
									</div><!-- .property-map-style-wrap -->';
							echo '</li>';
						}
						if( isset( $map_args['full_screen'] ) && $map_args['full_screen'] ){
							echo '<li class="nav-item">';
								echo '<a href="#" class="btn btn-default map-full-screen"><span class="full-screen-icon"><i class="icon-size-fullscreen icons"></i> '. esc_html__( 'Full Screen', 'zoacres' ) .'</span><span class="actual-screen-icon"><i class="icon-size-actual icons"></i> '. esc_html__( 'Default Screen', 'zoacres' ) .'</span></a><!-- .property-map-nav-wrap -->';
							echo '</li>';
						}	
						if( $myloc ){
							echo '<li class="nav-item">';
								echo '<a href="#" class="btn btn-default map-my-location"><span class="map-my-location-icon"><i class="fa fa-map-marker"></i> '. esc_html__( 'My Location', 'zoacres' ) .'</span></a><!-- .map-my-location -->';
							echo '</li>';
						}	
						if( isset( $map_args['nav'] ) && $map_args['nav'] ){
							echo '<li class="nav-item">';
								echo '<div class="property-map-nav-wrap">';
									echo '<ul class="nav property-map-nav" data-index="0">
											<li><a href="#" class="btn property-map-nav-prev"><span class="nav-left-icon"><i class="icon-arrow-left icons"></i>'. esc_html__( 'Prev', 'zoacres' ) .'</span></a></li>
											<li><a href="#" class="btn property-map-nav-next">'. esc_html__( 'Next', 'zoacres' ) .'<span class="nav-right-icon"><i class="icon-arrow-right icons"></i></span></a></li>	
										</ul>';
								echo '</div><!-- .property-map-nav-wrap -->';
							echo '</li>';
						}			
						echo '</ul>';
					echo '</div><!-- .property-map-items -->';
				echo '</div></div></div><!-- .container -->';			
				
				$cluster_image = $this->zoacresPropertyThemeOpt( 'map-marker-cluster' );
				$cluster_image = isset( $cluster_image['url'] ) && $cluster_image['url'] != '' ? $cluster_image['url'] : ZOACRES_ASSETS . '/images/markers/cluster.png';
				
				$theme_color = $this->zoacresPropertyThemeOpt( 'theme-color' );
				$map_style = $this->zoacresPropertyThemeOpt( 'map-style' );
				if( $map_style == 'custom' ){
					$default_mstyle = $this->zoacresPropertyThemeOpt( 'map-custom-style' );
				}
				
				echo '<div class="zoacresgmap zoacres-property-map" style="width:100%;height:'. esc_attr( $height ) .';" data-map-style="'. esc_attr( $map_style ) .'" data-cluster="true" data-cluster-img="'. esc_url( $cluster_image ) .'" data-multi-map="true" data-maps="'. htmlspecialchars( $multi_map, ENT_QUOTES, 'UTF-8' ) .'" data-wheel="'. esc_attr( $scroll_wheel ) .'" data-zoom="'. esc_attr( $map_zoom ) .'" data-custom-style="'. htmlspecialchars( $default_mstyle, ENT_QUOTES, 'UTF-8' ) .'" data-theme="'. esc_attr( $theme_color ) .'" data-extra-args="'. htmlspecialchars( json_encode( $map_args ), ENT_QUOTES, 'UTF-8' ) .'"></div>';
			}
		}
		
		function zoacresAgentProperties( $agent_id, $tax_id = '' ){
			
			$args = '';
			if( $tax_id != '' ){
				$args = array(
					'post_type' => 'zoacres-property',
					'tax_query' => array(
						array(
							'taxonomy' => 'property-category',
							'terms'    => array( absint( $tax_id ) ),
						)
					),
					'meta_key'   => 'zoacres_property_agent_id',
					'meta_query' => array(
						array(
							'key' => 'zoacres_property_agent_id',
							'value' => array ( $agent_id ),
							'compare' => 'IN'
						)
					)
				);
			}else{
				$args = array(
					'post_type' => 'zoacres-property',
					'meta_key'   => 'zoacres_property_agent_id',
					'meta_query' => array(
						array(
							'key' => 'zoacres_property_agent_id',
							'value' => array ( $agent_id ),
							'compare' => 'IN'
						)
					)
				);
			}

			$prop_elements = $this->zoacresPropertyThemeOpt( 'archive-agent-property-items' );
			$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
			if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
			
			$this->zoacresPropertiesArchive( $args, $prop_elements, 'archive-agent', 'col-md-4' );
			
		}
		
		function zoacresAdvanceSearch( $class = "", $search_args = array(), $parent_class = "" ){
			
			$toogle_stat = isset( $search_args['toggle'] ) && $search_args['toggle'] == true ? true : false;
			
			$redr_url = '';
			if( $parent_class == 'search-form-redirect' || $parent_class == 'search-form-redirect search-form-part-redirect' ){
				$search_pages = get_pages(array(
					'meta_key' => '_wp_page_template',
					'meta_value' => 'zoacres-property-search-result.php'
				));
				if( $search_pages ){
					$redr_url = get_permalink( $search_pages[0]->ID );
				}else{
					$redr_url = '';
				} 
			}

			if( isset( $_GET['state_id'] ) ){
				$parent_class .= ' search-template-actived';
			}
		
		?>
		
			<div class="advance-search-wrap <?php echo esc_attr( $parent_class ); ?>" data-search-url="<?php echo esc_url( $redr_url ); ?>">
			
				<?php if( is_user_logged_in() ): 
					if( !isset( $search_args['no_saved'] ) || ( isset( $search_args['no_saved'] ) && $search_args['no_saved'] == false ) ){
				?>
				<div class="saved-search-wrap">
					<div class="saved-search-inner">
						<div class="saved-search-text">
							<p>
								<span class="saved-search-inner-text"><?php esc_html_e('Do you want to saved this search?', 'zoacres'); ?></span>
								<span class="saved-search-icon"><i class="icon-check icons"></i></span>
							</p>
							<p>
								<a href="#" class="btn saved-search-trigger"><?php esc_html_e('Save', 'zoacres'); ?></a>
								<a href="#" class="btn saved-search-close"><?php esc_html_e('Leave', 'zoacres'); ?></a>
							</p>
						</div>
					</div>
				</div>
				<?php 
					}
				endif; ?>
				
				<?php if( isset( $search_args['author'] ) && $search_args['author'] != '' ): ?> 
					<input type="hidden" class="map-property-agent" value="<?php echo esc_attr( $search_args['author'] ); ?>" />
				<?php endif; 
				
				$search_wrap_id = zoacres_shortcode_rand_id();
				if( isset( $search_args['key_search'] ) && $search_args['key_search'] == true ): ?> 
				<!-- Key Word -->
				<div class="bts-ajax-search">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
						<?php 
							$prop_name = isset( $_GET['prop_name'] ) ? $_GET['prop_name'] : "";
							$placeholder = isset( $search_args['placeholder'] ) && $search_args['placeholder'] != '' ? $search_args['placeholder'] : esc_html__('Enter Location, Property , Landmark', 'zoacres');
						?>
						<input type="text" class="form-control ajax-search-box <?php echo esc_attr( $class ); ?>" name="property_name" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $prop_name ); ?>">
						<span class="input-group-addon">
							<button class="btn btn-primary ajax-search-trigger" type="button">
								<span class="fa fa-search"></span>
							</button>
						</span>
						<?php if( $toogle_stat ): ?> 
						<a class="input-group-addon expand-advance-search" data-toggle="collapse" href="#advance-search-wrap-<?php echo esc_attr( $search_wrap_id ); ?>" aria-expanded="false"><i class="icon-size-fullscreen icons"></i></a>				
						<?php endif; ?>			
					</div>
					
					<div class="ajax-search-dropdown"></div>						
				</div>
				<?php endif; ?>
				
				<?php $toggle_class = $toogle_stat ? ' collapse' : ''; ?>
				<div class="advance-search-btns-warp<?php echo esc_attr( $toggle_class ); ?>" id="advance-search-wrap-<?php echo esc_attr( $search_wrap_id ); ?>">
					
					<?php if( isset( $search_args['location'] ) && $search_args['location'] == true ): ?>
					<!-- Location -->
					<div class="property-location-search">
						<input type="text" id="property-location-search-form" class="form-control" value="" placeholder="<?php esc_attr_e('Location', 'zoacres'); ?>">
					</div>
					<?php endif; ?>
					
					<!-- Radius -->
					<?php
						wp_enqueue_script( 'jquery-ui' );
						wp_enqueue_script( 'zoacres-slide', get_theme_file_uri( '/assets/js/zoacres-slide.js' ), array('jquery', 'jquery-ui'), '1.0', true );
						if( isset( $search_args['radius'] ) && $search_args['radius'] == true ):
					?>
					<div class="property-radius-search">
						<p>
							<label><?php esc_html_e('Radius:', 'zoacres'); ?></label>
							<span id="property-radius-value" data-min="10" data-max="100"></span>
						</p>
						<div id="property-radius"></div>
					</div>
					<?php endif; ?>
					
					<div class="search-filters-wrap">
					<!-- All Actions -->
					<?php if( isset( $search_args['action'] ) && $search_args['action'] == true ): ?>
					<div class="bts-select all-action-search">
						<?php $action_id = isset( $_GET['action_id'] ) ? $_GET['action_id'] : ""; ?>
						<input class="search-hidd-id search-action-id" type="hidden" value="<?php echo esc_attr( $action_id ); ?>" name="search-action-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Actions', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<?php
								$property_action = get_terms( array(
									'taxonomy' => 'property-action',
									'hide_empty' => true
								) );
							?>
							<ul class="bts-select-menu">
								<li><?php esc_html_e('All Actions', 'zoacres'); ?></li>
								<?php
									foreach( $property_action as $action ){ // ptype = property type
										echo '<li data-id="'. esc_attr( $action->term_id ) .'">'. esc_html( $action->name ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- All Types -->
					<?php if( isset( $search_args['types'] ) && $search_args['types'] == true ): ?>
					<div class="bts-select all-type-search">
						<?php $type_id = isset( $_GET['type_id'] ) ? $_GET['type_id'] : ""; ?>
						<input class="search-hidd-id search-type-id" type="hidden" value="<?php echo esc_attr( $type_id ); ?>" name="search-type-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Types', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<?php
								$property_types = get_terms( array(
									'taxonomy' => 'property-category',
									'hide_empty' => true
								) );
							?>
							<ul class="bts-select-menu">
								<li><?php esc_html_e('All Types', 'zoacres'); ?></li>
								<?php
									foreach( $property_types as $ptype ){ // ptype = property type
										echo '<li data-id="'. esc_attr( $ptype->term_id ) .'">'. esc_html( $ptype->name ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- All States -->
					<?php if( isset( $search_args['state'] ) && $search_args['state'] == true ): ?>
					<div class="bts-select all-state-search">
						<?php $state_id = isset( $_GET['state_id'] ) ? $_GET['state_id'] : ""; ?>
						<input class="search-hidd-id search-state-id" type="hidden" value="<?php echo esc_attr( $state_id ); ?>" name="search-state-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All State', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<?php
							
								$def_country = isset( $search_args['default'] ) ? $search_args['default'] : '';
								$def_meta = array();
								$def_country_id = '';							
								if( $def_country ){
									$def_meta = 'state_parent_country';
									$def_country_id = isset( $def_country['search-country-id'] ) ? array( $def_country['search-country-id'] ) : '';
								}
							
								$property_state = get_terms( array(
									'taxonomy' => 'property-state',
									'hide_empty' => true,
									'meta_key' => $def_meta,
									'meta_value' => $def_country_id
								) );
							?>
							<ul class="bts-select-menu">
								<li><?php esc_html_e('All State', 'zoacres'); ?></li>
								<?php
									foreach( $property_state as $state ){
										echo '<li data-id="'. esc_attr( $state->term_id ) .'">'. esc_html( $state->name ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- All Cities -->
					<?php if( isset( $search_args['city'] ) && $search_args['city'] == true ): ?>
					<div class="bts-select all-cities-search">
						<?php $city_id = isset( $_GET['city_id'] ) ? $_GET['city_id'] : ""; ?>
						<input class="search-hidd-id search-city-id" type="hidden" value="<?php echo esc_attr( $city_id ); ?>" name="search-city-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Cities', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<?php
							
								$def_state = isset( $search_args['default'] ) ? $search_args['default'] : '';
								$def_meta = array();
								$def_state_id = '';							
								if( $def_state ){
									$def_meta = 'city_parent_state';
									$def_state_id = isset( $def_state['search-state-id'] ) ? array( $def_state['search-state-id'] ) : '';
								}
							
								$property_cities = get_terms( array(
									'taxonomy' => 'property-city',
									'hide_empty' => true,
									'meta_key' => $def_meta,
									'meta_value' => $def_state_id
								) );
							?>
							<ul class="bts-select-menu">
								<li><?php esc_html_e('All Cities', 'zoacres'); ?></li>
								<?php
									foreach( $property_cities as $city ){
										echo '<li data-id="'. esc_attr( $city->term_id ) .'">'. esc_html( $city->name ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- All Areas -->
					<?php if( isset( $search_args['area'] ) && $search_args['area'] == true ): ?>
					<div class="bts-select all-areas-search">
						<?php $area_id = isset( $_GET['area_id'] ) ? $_GET['area_id'] : ""; ?>
						<input class="search-hidd-id search-area-id" type="hidden" value="<?php echo esc_attr( $area_id ); ?>" name="search-area-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Areas', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<?php
							
								$def_city = isset( $search_args['default'] ) ? $search_args['default'] : '';
								$def_meta = array();
								$def_city_id = '';							
								if( $def_city ){
									$def_meta = 'area_parent_city';
									$def_city_id = isset( $def_city['search-city-id'] ) ? array( $def_city['search-city-id'] ) : array();
								}
							
								$property_cities = get_terms( array(
									'taxonomy' => 'property-area',
									'hide_empty' => true,
									'meta_key' => $def_meta,
									'meta_value' => $def_city_id
								) );
							?>
							<ul class="bts-select-menu">
								<li><?php esc_html_e('All Areas', 'zoacres'); ?></li>
								<?php
									foreach( $property_cities as $city ){
										echo '<li data-id="'. esc_attr( $city->term_id ) .'">'. esc_html( $city->name ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Min Rooms -->
					<?php if( isset( $search_args['min_rooms'] ) && $search_args['min_rooms'] == true ): ?>
					<div class="bts-select all-rooms-search">
						<?php $all_rooms = isset( $_GET['rooms_id'] ) ? $_GET['rooms_id'] : ""; ?>
						<input class="search-hidd-id search-rooms-id" type="hidden" value="<?php echo esc_attr( $all_rooms ); ?>" name="search-rooms-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('Max Rooms', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<ul class="bts-select-menu">
								<li data-id="0"><?php esc_html_e('All Rooms', 'zoacres'); ?></li>
								<?php
									for( $i = 1; $i <= 20; $i++ ){
										echo '<li data-id="'. esc_attr( $i ) .'">'. esc_html( $i ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Min Rooms -->
					<?php if( isset( $search_args['max_rooms'] ) && $search_args['max_rooms'] == true ): ?>
					<div class="bts-select all-bed-search">
						<?php $bed_rooms = isset( $_GET['bed_id'] ) ? $_GET['bed_id'] : ""; ?>
						<input class="search-hidd-id search-bed-id" type="hidden" value="<?php echo esc_attr( $bed_rooms ); ?>" name="search-bed-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Bed Rooms', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<ul class="bts-select-menu">
								<li data-id="0"><?php esc_html_e('Max Bed Rooms', 'zoacres'); ?></li>
								<?php
									for( $i = 1; $i <= 10; $i++ ){
										echo '<li data-id="'. esc_attr( $i ) .'">'. esc_html( $i ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Min Baths -->
					<?php if( isset( $search_args['min_bath'] ) && $search_args['min_bath'] == true ): ?>
					<div class="bts-select all-baths-search">
						<?php $bath_rooms = isset( $_GET['bath_id'] ) ? $_GET['bath_id'] : ""; ?>
						<input class="search-hidd-id search-baths-id" type="hidden" value="<?php echo esc_attr( $bath_rooms ); ?>" name="search-baths-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Baths', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<ul class="bts-select-menu">
								<li data-id="0"><?php esc_html_e('Max Baths', 'zoacres'); ?></li>
								<?php
									for( $i = 1; $i <= 10; $i++ ){
										echo '<li data-id="'. esc_attr( $i ) .'">'. esc_html( $i ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Min Garage -->
					<?php if( isset( $search_args['min_garage'] ) && $search_args['min_garage'] == true ): ?>
					<div class="bts-select all-garage-search">
						<?php $garage_rooms = isset( $_GET['garage_id'] ) ? $_GET['garage_id'] : ""; ?>
						<input class="search-hidd-id search-garage-id" type="hidden" value="<?php echo esc_attr( $garage_rooms ); ?>" name="search-garage-id" />
						<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
							<?php esc_html_e('All Garages', 'zoacres'); ?>
						</button>
						<div class="dropdown-menu bts-select-dropdown">
							<ul class="bts-select-menu">
								<li data-id="0"><?php esc_html_e('Max Garage', 'zoacres'); ?></li>
								<?php
									for( $i = 1; $i <= 5; $i++ ){
										echo '<li data-id="'. esc_attr( $i ) .'">'. esc_html( $i ) .'</li>';
									}
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
					</div><!-- .search-filters-wrap -->
					
					<div class="range-filters-wrap">
					<!-- Min Area -->
					<?php if( isset( $search_args['min_area'] ) && $search_args['min_area'] == true ): ?>
					<div class="all-minarea-search">
						<?php $minarea = isset( $_GET['minarea_id'] ) ? $_GET['minarea_id'] : ""; ?>
						<input class="form-control search-minarea-id" type="text" value="<?php echo esc_attr( $minarea ); ?>" name="search-minarea-id" placeholder="<?php esc_attr_e('Min Area', 'zoacres'); ?>" />
					</div>
					<?php endif; ?>
					
					<!-- Max Area -->
					<?php if( isset( $search_args['max_area'] ) && $search_args['max_area'] == true ): ?>
					<div class="all-maxarea-search">
						<?php $maxarea = isset( $_GET['maxarea_id'] ) ? $_GET['maxarea_id'] : ""; ?>
						<input class="form-control search-maxarea-id" type="text" value="<?php echo esc_attr( $maxarea ); ?>" name="search-maxarea-id" placeholder="<?php esc_attr_e('Max Area', 'zoacres'); ?>" />
					</div>
					<?php endif; ?>
					
					<!-- Price -->
					<?php if( isset( $search_args['price_range'] ) && $search_args['price_range'] == true ): ?>
					<div class="property-price-search">
						<p>
							<label><?php esc_html_e('Price range:', 'zoacres'); ?></label>
							<?php 
								$range_from = $this->zoacresPropertyThemeOpt( 'price-range-from' );
								$range_to = $this->zoacresPropertyThemeOpt( 'price-range-to' );
								$price_label = $this->zoacresPropertyThemeOpt( 'currency-label' );
								$currency_position = $this->zoacresPropertyThemeOpt( 'currency-position' );
							?>
							<span class="slider-range-amount" data-currency="<?php echo esc_attr( $price_label ); ?>" data-currency-position="<?php echo esc_attr( $currency_position ); ?>" data-from="<?php echo esc_attr( $range_from ); ?>" data-to="<?php echo esc_attr( $range_to ); ?>" data-min="<?php echo esc_attr( $range_from ); ?>" data-max="<?php echo esc_attr( $range_to ); ?>"></span>
						</p>
						<div class="slider-range"></div>
					</div>
					<?php endif; ?>		
					</div><!-- .range-filters-wrap -->
					
					<!-- Default Fixed Value -->
					<?php if( isset( $search_args['default'] ) && !empty( $search_args['default'] ) && is_array( $search_args['default'] ) ): 
							foreach( $search_args['default'] as $key => $value ){
								echo '<input class="'. esc_attr( $key ) .'" type="hidden" value="'. esc_attr( $value ) .'" />';
							}
						endif;
					?>
					
					<!-- More Search Options -->
					<?php if( isset( $search_args['more_search'] ) && $search_args['more_search'] == true ): ?>
						<div class="property-more-search">
							<p>
								<a class="more-search-options" data-toggle="collapse" href="#more-search-options" role="button" aria-expanded="false" aria-controls="more-search-options">
									<?php esc_html_e( 'More Search Options', 'zoacres' ); ?>
								</a>
							</p>
							<div class="collapse" id="more-search-options">
								<div class="card card-body">
									<?php
										$more_features = isset( $_GET['features'] ) && !empty( $_GET['features'] ) ? explode( ",", $_GET['features'] ) : array();
										$property_features = $this->zoacresPropertyThemeOpt('property-features');
										$property_features_arr = zoacres_trim_array_same_values( $property_features );
										echo '<ul>';
										foreach ( $property_features_arr as $value => $label ){
											$checked_stat = !empty( $more_features ) && in_array( $value, $more_features ) ? true : false;
											echo '<li><input class="property-more-features" type="checkbox" value="' . esc_attr( $value ) . '" name="property_more_features[]" '. ( $checked_stat ? 'checked="checked"' : '' ) .' />'. esc_html( $label ) .'</li>';
										}
										echo '</ul>';
									?>
								</div>
							</div>
						</div><!-- .property-more-search -->
					<?php endif; ?>
					
					<div class="advance-search-bottom">
					
						<?php if( !isset( $search_args['no_submit'] ) || ( isset( $search_args['no_submit'] ) && $search_args['no_submit'] == false ) ): ?>
						<!-- Search Trigger Button -->
						<div class="property-search">
							<button class="btn btn-primary ajax-search-trigger" type="button">
								<?php esc_html_e('Search Property', 'zoacres'); ?>
							</button>
						</div><!-- .property-search -->
						<?php endif; ?>
						
						<?php
							$property_layouts = isset( $search_args['property_layouts'] ) && $search_args['property_layouts'] == true ? true : false;
							$no_filter = !isset( $search_args['no_filter'] ) || ( isset( $search_args['no_filter'] ) && $search_args['no_filter'] == false ) ? true : false;
							
							if( $property_layouts || $no_filter ){
							
							echo '<div class="advance-search-extra-options clearfix">';
						
								if( $no_filter ): ?>
								<!-- Sort Filter -->
								<div class="bts-select property-sort-filter">
									<input class="search-hidd-id search-sort-filter-id" type="hidden" value="" name="search-sort-filter-id" />
									<button class="btn btn-primary bts-select-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
										<?php esc_html_e('Sort Filter', 'zoacres'); ?>
									</button>
									<div class="dropdown-menu bts-select-dropdown">
										<ul class="bts-select-menu">
											<li data-id="default"><?php esc_html_e('Default Order', 'zoacres'); ?></li>	
											<li data-id="low-high"><?php esc_html_e('Price Low to High', 'zoacres'); ?></li>
											<li data-id="high-low"><?php esc_html_e('Price High to Low', 'zoacres'); ?></li>	
											<li data-id="featured"><?php esc_html_e('Featured', 'zoacres'); ?></li>	
											<li data-id="latest"><?php esc_html_e('Latest First', 'zoacres'); ?></li>	
											<li data-id="oldest"><?php esc_html_e('Oldest First', 'zoacres'); ?></li>							
										</ul>
									</div>				
								</div><!-- .property-sort-filter -->
								<?php endif; ?>
								
								<?php if( $property_layouts ): ?>
								<!-- Property Layouts -->
								<div class="pull-right property-dynamic-layouts">
									<ul class="nav property-layouts-nav">
										<li><a href="#" class="property-layouts-trigger" data-layout="list"><span class="fa fa-list-ul"></span></a></li>
										<li><a href="#" class="property-layouts-trigger" data-layout="grid"><span class="fa fa-th-large"></span></a></li>
									</ul>
								</div><!-- .property-dynamic-layouts -->
								<?php endif; 
							
							echo '</div><!-- .advance-search-extra-options -->';
							} //property_layouts or no_filter
						?>
						
					</div> <!-- .advance-search-bottom -->
					
				</div><!-- advance-search-btns-warp -->
				
			</div><!-- .advance-search-wrap -->

		<?php
		}
	}
}	
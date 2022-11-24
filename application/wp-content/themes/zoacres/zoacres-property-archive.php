<?php
/**
 * Default property archive page
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'archive-property'; // template id
$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

$zpe = new ZoacresPropertyElements();
$cols = $aps->zoacresGetThemeOpt( 'property-grid-cols' );
$excerpt_len = $aps->zoacresGetThemeOpt( 'archive-propery-excerpt-len' );
$prop_ani = $aps->zoacresGetThemeOpt( 'archive-property-animation' );
$prop_ani = $prop_ani ? true : false;
?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php $ahe->zoacresPageTitle( $template ); ?>

		<div class="zoacres-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">

						<div class="full-map-property-list-wrap property-list-identity">	
							<div class="map-property-list" data-cols="<?php echo esc_attr( $cols ); ?>" data-animation="<?php echo esc_attr( $prop_ani ); ?>">
								<?php
								
									$excerpt_len = $excerpt_len ? $excerpt_len : 15;
									$zpe::$cus_excerpt_len = apply_filters( 'zoacres_property_archive_excerpt_length', $excerpt_len );
									
									$paged = 1;
									if( get_query_var( 'page' ) ){
										$paged = get_query_var( 'page' );
									}elseif( get_query_var( 'paged' ) ){
										$paged = get_query_var( 'paged' );
									}

									$args = $args = array(
										'post_type' => 'zoacres-property',
										'paged'	=> $paged,
										'post_status' => array( 'publish' ),
										'order'   => 'DESC'
									);

									$cols = $zpe->zoacresPropertyThemeOpt( 'property-grid-cols' );
									$property_cols = 'col-lg-' . $cols;
									$property_cols .= $cols != '12' ? ' col-md-6' : ''; 
									
									$prop_elements = $zpe->zoacresPropertyThemeOpt( 'archive-property-items' );
									$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
									if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
									
									$meta_args = array( 'animation' => esc_attr( $prop_ani ), 'pagination' => 'on' );
									
									$zpe->zoacresPropertiesArchive( $args, $prop_elements, 'archive', $property_cols, $meta_args );
									
								?>
							</div> <!-- .map-property-list -->
						</div><!-- .full-map-property-list-wrap -->
						
					</div><!-- main col -->
					
					<?php if( $template_class['lsidebar_class'] != '' ) : ?>
					<div class="<?php echo esc_attr( $template_class['lsidebar_class'] ); ?>">
						<aside class="widget-area left-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
							<?php dynamic_sidebar( $template_class['left_sidebar'] ); ?>
						</aside>
					</div><!-- sidebar col -->
					<?php endif; ?>
					
					<?php if( $template_class['rsidebar_class'] != '' ) : ?>
					<div class="<?php echo esc_attr( $template_class['rsidebar_class'] ); ?>">
						<aside class="widget-area right-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
							<?php dynamic_sidebar( $template_class['right_sidebar'] ); ?>
						</aside>
					</div><!-- sidebar col -->
					<?php endif; ?>
					
				</div><!-- row -->
			
		</div><!-- .container -->
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

<?php
/**
 * The template for displaying all custom post types
 */
 
$template = 'page'; // template id

if( is_singular( 'zoacres-property' ) ){
	$template = 'single-property';
}
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;



$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

$acpt = new ZoacresCPT;

while ( have_posts() ) : the_post();

?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php $ahe->zoacresHeaderSlider('bottom'); ?>
		
		<?php $ahe->zoacresPageTitle( $template ); ?>
		
		
		<?php 
			if( is_singular( 'zoacres-property' ) ) :
			$zpe = new ZoacresPropertyElements();
			$property_id = get_the_ID();
		?>
		<div class="container-fluid fullwidth-wrap">
			
			<div class="row">
			
				<?php
				
				$prop_elements = '';
					
				$prop_elements_opt = get_post_meta( get_the_ID(), 'zoacres_property_headeritems_opt', true );
				if( $prop_elements_opt == 'custom' ){
					$prop_elements = get_post_meta( get_the_ID(), 'zoacres_property_header_items', true );
					$prop_elements = json_decode( stripslashes( $prop_elements ), true );
					$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
				}else{
					$prop_elements = $zpe->zoacresPropertyThemeOpt( 'single-property-header-items' );
					$prop_elements = isset( $prop_elements['Enabled'] ) ? $prop_elements['Enabled'] : '';
					if( is_array( $prop_elements ) && array_key_exists( "placebo", $prop_elements ) ) unset( $prop_elements['placebo'] );
				}
						
				if ( $prop_elements ): 
					foreach ( $prop_elements as $element => $value ) {
						switch( $element ) {
							
							case "top-meta":
							?>
								<div class="container">
									<div class="row">
										<div class="col-sm-12">
											<div class="property-header-elements">
												<div class="property-meta-wrap property-top-meta">
													<?php $zpe->zoacresPropertySingleMeta( $property_id, 'top' ); ?>
												</div>
											</div>
										</div>
									</div><!-- .row -->
								</div><!-- .container -->
							<?php
							break;
							
							case "bottom-meta":
							?>
								<div class="container">
									<div class="row">
										<div class="col-sm-12">
											<div class="property-header-elements">
												<div class="property-meta-wrap property-bottom-meta">
													<?php $zpe->zoacresPropertySingleMeta( $property_id, 'bottom' ); ?>
												</div>
											</div>
										</div>
									</div><!-- .row -->
								</div><!-- .container -->
							<?php
							break;
							
							case "title":
							?>
								<div class="container">
									<div class="row">
										<div class="col-sm-12">
											<div class="property-title-wrap">
												<h2><?php the_title(); ?></h1>
											</div>
										</div>
									</div><!-- .row -->
								</div><!-- .container -->
							<?php
							break;
							
							case "gallery":
							?>
								<div class="col-sm-12 single-property-full-width">	
									<?php $zpe->zoacresPropertySingleBgGallery( $property_id ); ?>
								</div><!-- .col-sm-12 -->
							<?php
							break;
							
							case "thumb":
							?>
								<?php if( has_post_thumbnail( get_the_ID() ) ): ?>
								<div class="col-sm-12 single-property-full-width">	
									<div class="property-image-wrap">
										<?php $zpe->zoacresPropertySingleBgImage( $property_id ); ?>
									</div> <!-- .property-content-wrap -->
								</div><!-- .col-sm-12 -->
								<?php endif; // if thumb exists ?>
							<?php
							break;
							
							case "pack":
							?>
								<div class="col-sm-12 single-property-full-width">	
									<!-- Property Single Pack -->
									<div class="property-single-pack-wrap">
										<div class="property-single-pack-inner">
											<?php $zpe->zoacresPropertySinglePack( $property_id, true ); ?>
										</div>
									</div><!-- .property-single-pack-wrap -->
								</div><!-- .col-sm-12 -->
							<?php
							break;
							
							case "map":
							?>
								<!-- Property Map -->
								<div class="col-md-12 property-nearby-wrap single-property-full-width">
									<div class="property-nearby-inner">
										<?php $zpe->zoacresPropertyNearbyMap( $property_id, false, true ); ?>
									</div>
								</div><!-- .property-nearby-wrap -->
							<?php
							break;
							
						}
					}
				endif;
				?>

			</div><!-- .row -->
			
		</div><!-- .container-fluid -->
		<?php endif; ?>

		<div class="zoacres-content-inner">
			<div class="container">

				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
						<div id="primary" class="content-area">
							<?php $acpt->zoacresCPTCallTemplate( get_post_type() ); ?>				
						</div><!-- #primary -->
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

<?php endwhile; // End of the loop.

get_footer();

<?php
/**
 * The template for displaying all custom post types
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'archive-property'; // template id

$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();

$full_width_class = '';

$acpt = new ZoacresCPT;
?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php 
			$tax_id = get_queried_object()->term_id;
			$ahe->zoacresPageTitle( $template, '', $tax_id ); 
		?>

		<div class="zoacres-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
						<div id="primary" class="content-area">
							<?php
								$q_object = get_queried_object();
								$taxonomy = '';
								if( isset($q_object->taxonomy) )
									$taxonomy = $q_object->taxonomy;
									
								$acpt->zoacresCPTCallTaxTemplate( $taxonomy );
							?>				
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

<?php get_footer();

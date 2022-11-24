<?php
/**
 * The template for displaying author pages
 */

get_header(); 
$ahe = new ZoacresHeaderElements;

$template = 'archive'; // template id
$aps = new ZoacresPostSettings;
$aps->zoacresSetPostTemplate( $template );

$template_class = $aps->zoacresTemplateContentClass();
$extra_class = $layout = $aps->zoacresGetCurrentLayout();
$top_standard = $aps->zoacresGetThemeOpt( $template.'-top-standard-post' );

if( !$top_standard ){ add_filter( 'excerpt_length', array( &$aps, 'zoacresSetExcerptLength' ), 999 ); }

$gutter = $cols = $infinite = $isotope = '';
if( $layout == 'grid-layout' ){
	$cols = $aps->zoacresGetThemeOpt( $template.'-grid-cols' );
	$gutter = $aps->zoacresGetThemeOpt( $template.'-grid-gutter' );
	$infinite = $aps->zoacresGetThemeOpt( $template.'-infinite-scroll' ) ? 'true' : 'false';
	$isotope = $aps->zoacresGetThemeOpt( $template.'-grid-type' );
	$extra_class .= $aps->zoacresGetThemeOpt( $template.'-grid-type' ) == 'normal' ? ' grid-normal' : '';
}
?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">

	<?php $ahe->zoacresPageTitle( $template ); ?>
	
	<?php 
		if( $aps->zoacresThemeOpt( $template.'-featured-slider' ) ){
			$ahe->zoacresFeaturedSlider( $template );
		}
	?>
	
	<div class="zoacres-content-inner">
		<div class="container">
		
			<div class="row">
		
				<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
					<div id="primary" class="content-area">
						<main id="main" class="site-main <?php echo esc_attr( $template ); ?>-template <?php echo esc_attr( $extra_class ); ?>" data-cols="<?php echo esc_attr( $cols ); ?>" data-gutter="<?php echo esc_attr( $gutter ); ?>">
							
							<?php
							
							if ( have_posts() ) :
		
								$chk = $isotope_stat = 1;
								/* Start the Loop */
								while ( have_posts() ) : the_post();
								
									if( $top_standard && $layout != 'standard-layout' ) : ?>
										
										<div class="top-standard-post clearfix">
											<?php
											$aps::$top_standard = true;
											add_filter( 'excerpt_length', array( &$aps, 'zoacresSetTopPostExcerptLength' ), 999 );
											get_template_part( 'template-parts/post/content' );
											
											$aps::$top_standard = false;
											$top_standard = false;
											add_filter( 'excerpt_length', array( &$aps, 'zoacresSetExcerptLength' ), 999 );
											?>
										</div><?php
										
									else :
									
										if( $layout == 'grid-layout' && $isotope == 'isotope' && $isotope_stat == 1 ) : $isotope_stat = 0; ?>
											<div class="isotope" data-cols="<?php echo esc_attr( $cols ); ?>" data-gutter="<?php echo esc_attr( $gutter ); ?>" data-infinite="<?php echo esc_attr( $infinite ); ?>"><?php
										endif;
		
										if( $chk == 1 && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '<div class="grid-parent clearfix">';  endif;
										
										get_template_part( 'template-parts/post/content' );
										
										if( $chk == $cols && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '</div><!-- .grid-parent -->'; $chk = 0; endif;
										
										$chk++;
									
									endif;
				
								endwhile;
								
									if( $layout == 'grid-layout' && $isotope == 'isotope' && $isotope_stat == 0 ) : $isotope_stat = 0; ?>
										</div><!-- .isotope --><?php
									endif;
		
									if( $chk != 1 && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '</div><!-- .grid-parent -->'; endif; // Unexpected if odd grid
					
							else :
				
								get_template_part( 'template-parts/post/content', 'none' );
				
							endif;
							?>
				
						</main><!-- #main -->
							<?php $aps->zoacresWpBootstrapPagination(); ?>
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
				
			</div><!-- .row -->
		
		</div><!-- .container -->
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();
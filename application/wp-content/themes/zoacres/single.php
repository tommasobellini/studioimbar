<?php
/**
 * The template for displaying all single posts
 *
 */

//Check CPT
if( class_exists( "ZoacresCPT" ) ){
	if( is_singular( array( 'zoacres-team', 'zoacres-testimonial', 'zoacres-property' ) ) ){
		get_template_part( 'single', 'cpt' );
		return;
	}elseif( is_singular( 'zoacres-agent' ) ){
		get_template_part( 'single', 'cpt-agent' );
		return;
	}
}

get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'single-post'; // template id
$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

// Post View Count
$aps->zoacresSetPostViewCount( get_the_ID() );

?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">

	<?php $ahe->zoacresHeaderSlider('bottom'); ?>

	<?php $ahe->zoacresPageTitle( $template ); ?>
	
	<?php 
		if( $aps->zoacresCheckMetaValue( 'zoacres_post_featured_slider', $template.'-featured-slider' ) ){
			$ahe->zoacresFeaturedSlider( $template );
		}
	?>
	
	<?php
		if( $aps->zoacresCheckMetaValue( 'zoacres_post_full_wrap', 'single-post-full-wrap' ) ) : 
	?>
			<div class="post-full-thumb-wrap single-post-template">
				<?php
					if ( has_post_format( 'gallery' ) ) :
						$aps->zoacresGalleryFormat();
				?>
				<?php elseif ( has_post_format( 'video' ) ) :
					$video_type = get_post_meta( get_the_ID(), 'zoacres_post_video_type', true );
					$video_id = get_post_meta( get_the_ID(), 'zoacres_post_video_id', true );
					$video_modal = $aps->zoacresCheckMetaValue( 'zoacres_post_video_modal', $template.'-video-format' );
					$video_atts = array(
						'video_type'	=> $video_type,
						'video_id'		=> $video_id,
						'video_modal'	=> $video_modal
					);
				?>
		
					<div class="post-video-wrap">
						<?php $aps->zoacresVideoFormat( $video_atts ); ?>
					</div>
				<?php elseif ( has_post_format( 'quote' ) ) : ?>
					<div class="post-quote-full-wrap text-center">
						<?php $aps->zoacresQuoteFormat(); ?>
					</div>
				<?php elseif ( has_post_format( 'link' ) ) : ?>
					<div class="post-link-full-wrap text-center">
						<?php $aps->zoacresLinkFormat(); ?>
					</div>
				<?php elseif ( has_post_format( 'audio' ) ) : ?>
					<div class="post-audio-full-wrap">
						<?php $aps->zoacresAudioFormat(); ?>
					</div>
				<?php elseif( '' !== get_the_post_thumbnail() ) : ?>
					<div class="set-bg-img" data-src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>"></div>
				<?php endif; ?>

			<?php  if( $aps->zoacresCheckMetaValue( 'zoacres_post_overlay_opt', 'single-post-overlay-opt' ) == 1 ) : ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="post-overlay-items<?php echo ( has_post_format( 'image' ) ? ' thumb-exists' : '' ); ?>"> 
								<?php
								
									$post_elements = array();
									$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_overlay_opt', true );
									if( $post_oitems_opt == '' || $post_oitems_opt == 'theme-default' ){
										$post_elements = $aps->zoacresThemeOpt( 'single-post-overlay-items' );		
										$post_elements = $post_elements['Enabled'];		
										if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );						
									}else{
										$overlay_post_items = get_post_meta( get_the_ID(), 'zoacres_post_overlay_items', true );
										$t_post_items = explode( ',', $overlay_post_items );
										foreach ( $t_post_items as $element ) 
											$post_elements[$element] = $element;
									}
									$aps->zoacresPostOverlayItems( $post_elements );
								?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; // single-post-overlay-opt 0 or 1 ?>
			
		</div><!-- .post-full-thumb-wrap -->
	<?php endif; // single-post-full-wrap 0 or 1 ?>

	
	<div class="zoacres-content-inner">
		<div class="container">

			<div class="row">
		
				<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
				
					<div id="primary" class="content-area">
					
						<?php echo zoacres_ads_out( $ahe->zoacresThemeOpt( 'article-top-ads-list' ) ); ?>
					
						<?php
						
							$post_elements = array();
							$post_oitems_opt = get_post_meta( get_the_ID(), 'zoacres_post_page_items_opt', true );
							if( $post_oitems_opt == '' || $post_oitems_opt == 'theme-default' ){
								$post_elements = $aps->zoacresThemeOpt( 'single-post-page-items' );		
								$post_elements = $post_elements['Enabled'];		
								if( array_key_exists( "placebo", $post_elements ) ) unset( $post_elements['placebo'] );						
							}else{
								$overlay_post_items = get_post_meta( get_the_ID(), 'zoacres_post_page_items', true );
								$t_post_items = explode( ',', $overlay_post_items );
								foreach ( $t_post_items as $element ) 
									$post_elements[$element] = $element;
							}
						
							// Dynamic Single Post Page Elements
							if( $post_elements ):
							
								/* Single Post Loop */
								while ( have_posts() ) : the_post();
							
								foreach ( $post_elements as $element => $value ) {
									switch( $element ) {
									
										case 'post-items':
						?>
					
						<main id="main" class="site-main <?php echo esc_attr( $template ); ?>-template">
							
							<?php get_template_part( 'template-parts/post/content', 'single' ); ?>
				
						</main><!-- #main -->
						
						<?php
							break; // post-items
							
							case 'author-info':
						?>
						
						<!-- Post Author Wrap -->
						<?php
							$author_info = nl2br( get_the_author_meta('description') );
						if( $author_info ):
						?>
						<div class="author-info-wrapper clearfix">
							<?php get_template_part('template-parts/author/biography');	?>
						</div>
						<?php 
						endif;
						?>
						
						<?php
							break; // author-info
							
							case 'post-nav':
						?>
							
						
						<!-- Post Navigation -->
						<?php
							$prev_post = get_previous_post();
							$next_post = get_next_post();
						
						if( !empty( $prev_post ) || !empty( $next_post ) ):
						?>
						<div class="post-navigation-wrapper clearfix">
							<nav class="navigation post-navigation">
								<div class="nav-links">
									
									<?php
									if (!empty( $prev_post )): ?>
									<div class="nav-previous">
										<?php
											$prev_title = $prev_post->post_title ? $prev_post->post_title : esc_html__( "Previous Post" , "zoacres" );
										?>
										<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo esc_html( $prev_title ); ?></a>
									</div>
									<?php endif; ?>
									
									<?php
									if (!empty( $next_post )): ?>
									<div class="nav-next">
										<?php
											$next_title = $next_post->post_title ? $next_post->post_title : esc_html__( "Next Post" , "zoacres" );
										?>
										<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo esc_html( $next_title ); ?></a>
									</div>
									<?php endif; ?>
									
								</div>
							</nav>
						</div>
						<?php 
						endif; // next or prev post exists if
						?>
						
						<?php
							break; // post-nav
							
							case 'related-slider':
						?>
						
						<!-- Related Post Slider -->
						<?php get_template_part('template-parts/slider/related');	?>
						
						<?php
							break; // related-slider
							
							case 'comment':
						?>
						
						<!-- Comments -->
						<div class="post-comments-wrapper clearfix">
						<?php 
							$comment_type = $aps->zoacresThemeOpt( 'comments-type' );
							if( $comment_type == 'wp' ){
								if ( comments_open() || get_comments_number() ) :
									echo '<div class="wp-comments-wrapper">';
										comments_template();
									echo '</div>';
								endif;								
							}else{
								echo '<div class="fb-comments-wrapper">';
									zoacres_fb_comments_code();
								echo '</div>';
							}  
						?>					
						</div>
						
						<?php
							break; // comment
							case 'article-inline-ads-list':
						?>
						
						<!-- Article Inline Ads -->
						<?php echo zoacres_ads_out( $ahe->zoacresThemeOpt( 'article-inline-ads-list' ) );	?>
						
						<?php
							break; // article-inline-ads-list
						?>
						
						<?php
										} // switch
									}// foreach
								endwhile;
							endif; // Single Page Elements If
						?>
						
						<?php echo zoacres_ads_out( $ahe->zoacresThemeOpt( 'article-bottom-ads-list' ) ); ?>
						
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
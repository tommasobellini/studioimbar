<?php
/**
 * Default property archive page
 */
 
get_header(); 

$ahe = new ZoacresHeaderElements;
$aps = new ZoacresPostSettings;

$template = 'archive'; // template id
$aps->zoacresSetPostTemplate( $template );
$template_class = $aps->zoacresTemplateContentClass();
$full_width_class = '';

$zpe = new ZoacresPropertyElements();
add_filter( 'excerpt_length', array( &$aps, 'zoacresSetExcerptLength' ), 999 );
?>

<div class="zoacres-content <?php echo esc_attr( 'zoacres-' . $template ); ?>">
		
		<?php $ahe->zoacresPageTitle( $template ); ?>

		<div class="zoacres-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
					<?php
					
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								$agent_id = get_the_ID();
								
								$agent_img_url = get_the_post_thumbnail_url( absint( $agent_id ), 'full' ); 
								$agent_url = get_post_permalink( absint( $agent_id ) );
								$agent_name = get_the_title();
								
							?>
								<div class="property-agent-wrap">
									<div class="property-agent-inner">
										<div class="row agent-info-wrap">
											<div class="col-md-5">
												<div class="agent-img-wrap">
													<img class="agent-img" src="<?php echo esc_url( $agent_img_url ); ?>" alt="<?php echo esc_attr( $agent_name ); ?>">
													<div class="agent-social-links-wrap">
														<?php
														$fb = get_post_meta( $agent_id, 'zoacres_agent_fb_link', true );
														$twit = get_post_meta( $agent_id, 'zoacres_agent_twitter_link', true );
														$lnk = get_post_meta( $agent_id, 'zoacres_agent_linkedin_link', true );														
														$yt = get_post_meta( $agent_id, 'zoacres_agent_yt_link', true );
														$insta = get_post_meta( $agent_id, 'zoacres_agent_instagram_link', true );
														$social_out = '';
														$social_out .= '<ul class="nav agent-social-links">';
															$social_out .= $fb != '' ? '<li><a href="'. esc_url( $fb ) .'"><span class="fa fa-facebook"></span></a></li>' : '';
															$social_out .= $twit != '' ? '<li><a href="'. esc_url( $twit ) .'"><span class="fa fa-twitter"></span></a></li>' : '';
															$social_out .= $lnk != '' ? '<li><a href="'. esc_url( $lnk ) .'"><span class="fa fa-linkedin"></span></a></li>' : '';
															
															$social_out .= $yt != '' ? '<li><a href="'. esc_url( $yt ) .'"><span class="fa fa-youtube-play"></span></a></li>' : '';
															$social_out .= $insta != '' ? '<li><a href="'. esc_url( $insta ) .'"><span class="fa fa-instagram"></span></a></li>' : '';
														$social_out .= '</ul>';
														echo wp_kses_post( $social_out );
														?>
													</div>
													<div class="agent-read-more-wrap">
													<?php
														$read_more = $aps->zoacresGetThemeOpt( 'agent-general-more-text' );
													?>
													<a class="btn btn-default agent-read-more" href="<?php echo esc_url( $agent_url ); ?>"><?php echo esc_html( $read_more ); ?></a>
												</div>
												</div>
											</div>
											<div class="col-md-7">
												<?php
													$agent_post_count = zoacres_get_agent_post_count( $agent_id );
												?>	
												<div class="agent-prop-count">
													<a href="<?php echo esc_url( $agent_url ); ?>"><?php echo esc_html( $agent_post_count ) .' '. apply_filters( 'zoacres_agent_property_count_label', esc_html__( 'Properties', 'zoacres' ) ); ?></a>
												</div>											
												<h5 class="agent-name"><a href="<?php echo esc_url( $agent_url ); ?>"><?php echo esc_html( $agent_name ); ?></a></h5>
												<?php
													$agent_position = get_post_meta( absint( $agent_id ), 'zoacres_agent_position', true );
													if( $agent_position ) echo '<span class="small-text agent-position">'. esc_html( $agent_position ) .'</span>';
												?>
												<div class="agent-content">
													<?php the_excerpt(); ?>
												</div>
											</div>
										</div>
									</div>
								</div><!-- .property-agent-wrap -->
							<?php
							endwhile;
						endif;
						
					?>
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
				
				<?php $aps->zoacresWpBootstrapPagination(); ?>
			
		</div><!-- .container -->
	</div><!-- .zoacres-content-inner -->
</div><!-- .zoacres-content -->

<?php get_footer();

<?php
/**
 * Template part for displaying related post as slider
 *
 */

$aps = new ZoacresPostSettings;

$slide_template = 'related';
$cols = '';
$max_posts = $aps->zoacresThemeOpt( 'related-max-posts' );
$filter = $aps->zoacresThemeOpt( 'related-posts-filter' );
$gal_atts = array(
	'data-loop="'. $aps->zoacresThemeOpt( $slide_template.'-slide-infinite' ) .'"',
	'data-margin="'. $aps->zoacresThemeOpt( $slide_template.'-slide-margin' ) .'"',
	'data-center="'. $aps->zoacresThemeOpt( $slide_template.'-slide-center' ) .'"',
	'data-nav="'. $aps->zoacresThemeOpt( $slide_template.'-slide-navigation' ) .'"',
	'data-dots="'. $aps->zoacresThemeOpt( $slide_template.'-slide-pagination' ) .'"',
	'data-autoplay="'. $aps->zoacresThemeOpt( $slide_template.'-slide-autoplay' ) .'"',
	'data-items="'. $aps->zoacresThemeOpt( $slide_template.'-slide-items' ) .'"',
	'data-items-tab="'. $aps->zoacresThemeOpt( $slide_template.'-slide-tab' ) .'"',
	'data-items-mob="'. $aps->zoacresThemeOpt( $slide_template.'-slide-mobile' ) .'"',
	'data-duration="'. $aps->zoacresThemeOpt( $slide_template.'-slide-duration' ) .'"',
	'data-smartspeed="'. $aps->zoacresThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',
	'data-scrollby="'. $aps->zoacresThemeOpt( $slide_template.'-slide-scrollby' ) .'"',
	'data-autoheight="'. $aps->zoacresThemeOpt( $slide_template.'-slide-autoheight' ) .'"',
);
$data_atts = implode( " ", $gal_atts );

$cols = absint( $aps->zoacresThemeOpt( $slide_template.'-slide-items' ) );
if( $cols == 1 ){
	$thumb_size = 'large';
}elseif( $cols == 2 ){
	$thumb_size = 'medium';
}elseif( $cols == 3 ){
	$thumb_size = 'zoacres-grid-large';
}else{
	$thumb_size = 'zoacres-grid-medium';
}

if( absint( $max_posts ) ):

	$post_id = get_the_ID();
	$term_in = '';
	
	$terms = wp_get_post_categories( $post_id );
	
	if( $filter == 'category' ){
		$term_in = 'category__in';
		$terms = wp_get_post_categories( $post_id );
	}else{
		$term_in = 'tag__in';
		$terms = wp_get_post_tags( $post_id );
	}

	if( $terms ) {

		$args = array(
			$term_in => $terms,
			'ignore_sticky_posts' => 1,
			'post__not_in' => array( $post_id ),
			'posts_per_page'=> absint( $max_posts )
		);

		$related_query = new WP_Query( $args );
		
		if( $related_query->have_posts() ) { ?>
			<div class="related-slider-wrapper clearfix">
				<h4><?php echo apply_filters( 'zoacres_portfolio_related_title', esc_html__( 'Related Posts', 'zoacres' ) ); ?></h4>
				<div class="owl-carousel related-slider" <?php echo ( ''. $data_atts ); ?>><?php
		
				while( $related_query->have_posts() ) : $related_query->the_post(); ?>
				
					<div class="item">
						<?php 
							if ( has_post_thumbnail( get_the_ID() ) ) :
						?>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
								<?php echo get_the_post_thumbnail( get_the_ID(), $thumb_size, array( 'class' => 'img-fluid' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="related-slider-content">
							<h6 class="related-title">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" class="related-post-title" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
							</h6>
							<div class="related-meta">
								<?php 
								//Date 
								echo ( ''. $aps->zoacresMetaDate() );								
								
								?>													
							</div>
						</div>	
					</div>
		
				<?php
				endwhile;?>
				
				</div><!-- .related-slider -->
			</div><!-- .related-slider-wrapper --><?php
	
		}
		wp_reset_postdata();
	
	}

endif; // related-slider enable if
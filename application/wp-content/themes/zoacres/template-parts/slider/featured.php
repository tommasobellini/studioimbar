<?php
/**
 * Template part for displaying related post as slider
 *
 */

$aps = new ZoacresPostSettings;

$slide_template = 'featured';
$cols = '';
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

$args = array(
	'ignore_sticky_posts' => 1,
	'posts_per_page'=> -1,
	'meta_query' => array(
		array(
			'key' => 'zoacres_post_featured_stat',
			'value' => 1
		)
	),
);

$slide_class = $cols == 1 ? ' owl-single-item' : '';

$related_query = new WP_Query( $args );
if( $related_query->have_posts() ) { ?>
	<div class="featured-slider-wrapper clearfix">
		<div class="owl-carousel featured-slider<?php echo esc_attr( $slide_class ); ?>" <?php echo ( ''. $data_atts ); ?>><?php

		while( $related_query->have_posts() ) : $related_query->the_post(); ?>
		
			<div class="item">
				<div class="featured-item">
					<?php 
						
						$post_id = get_the_ID();
						if ( has_post_thumbnail( $post_id ) ) :
							
							$thumb_size = $aps->zoacresThemeOpt( 'featured-slide-thumb-size' );
							if( $thumb_size == 'custom' ){
								$img_csize = $aps->zoacresThemeOpt( 'featured-slide-custom-thumb-csize' );
								$wdth = isset( $img_csize['width'] ) ? $img_csize['width'] : '';
								$hgt = isset( $img_csize['height'] ) ? $img_csize['height'] : '';
								$thumb_size = array( $wdth, $hgt );
								
							}
							
							if( is_array( $thumb_size ) ){
								$featured_img_url = get_the_post_thumbnail_url( $post_id, 'full' ); 
								$cropped_img = aq_resize( $featured_img_url, $thumb_size[0], $thumb_size[1], true, false );
								if( $cropped_img ){
									$image_alt = get_the_title();
									echo '<a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'"><img class="img-fluid" src="'. esc_url( $cropped_img[0] ) .'" width="'. esc_attr( $cropped_img[1] ) .'" height="'. esc_attr( $cropped_img[2] ) .'" alt="'. esc_attr( $image_alt ) .'" /></a>';
								}else{
									echo '<a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'">'. get_the_post_thumbnail( $post_id, $thumb_size, array( 'class' => 'img-fluid' ) ) .'</a>';
								}
							}else{
								echo '<a href="'. esc_url( get_the_permalink() ) .'" title="'. esc_attr( get_the_title() ) .'">'. get_the_post_thumbnail( $post_id, $thumb_size, array( 'class' => 'img-fluid' ) ) .'</a>';
							}
						endif;
						
						//Featured Slide Items
						$featured_items = $aps->zoacresThemeOpt( 'featured-slide-inner-items' );
						$featured_items = isset( $featured_items['Enabled'] ) ? $featured_items['Enabled'] : array();
						if( array_key_exists( "placebo", $featured_items ) ) unset( $featured_items['placebo'] );
						if( $featured_items ): 
							echo '<div class="featured-item-inner">';
								foreach ( $featured_items as $element => $value ) {
									switch($element) {
										case "title":
										?>
											<h3 class="featured-title">
												<a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>">
													<?php echo esc_html( get_the_title() ); ?>
												</a>
											</h3>
										<?php
										break;
										
										case "category":
											echo ( ''. $aps->zoacresMetaCategory() );
										break;
										
										case "author":
											echo ( ''. $aps->zoacresMetaAuthor() ); 
										break;
										
										case "date":
											echo ( ''. $aps->zoacresMetaDate() );
										break;
										
										case "meta":
										?>
											<div class="featured-meta">
												<?php	
													//Date 
													echo ( ''. $aps->zoacresMetaDate() );												
													//Comments Count 
													echo ( ''. $aps->zoacresMetaComment() );
												?>
											</div>
										<?php
										break;
										
										case "more":
											$more_text = $aps->zoacresThemeOpt( 'featured-slide-more-text' );
											echo ( ''. $aps->zoacresMetaMore( $more_text ) );
										break;
									}
								}
							echo '</div><!-- .featured-item-inner -->';
						endif;						
					?>
				</div><!-- .featured-item -->
			</div><!-- .item -->

		<?php
		endwhile;?>
		
		</div><!-- .related-slider -->
	</div><!-- .related-slider-wrapper --><?php

}
wp_reset_postdata();
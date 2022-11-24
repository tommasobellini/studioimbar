<?php
/**
 * The template for displaying 404 pages (not found)
 *
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found text-center">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'zoacres' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content col-lg-8 offset-lg-2">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'zoacres' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();

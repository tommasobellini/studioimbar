<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

$aps = new ZoacresPostSettings;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_sticky() && is_home() ) : ?>
		<span class="sticky-post-icon"><i class="icon-pin icons"></i></span>
	<?php endif; ?>

	<?php $aps->zoacresPostItems(); ?>

</article><!-- #post-## -->

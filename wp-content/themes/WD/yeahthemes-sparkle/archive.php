<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package yeahthemes
 */

get_header(); ?>
	
	<?php yt_before_primary(); ?>
	
	<div id="primary" <?php yt_section_classes( 'content-area', 'primary' );?>>
		
		<?php yt_primary_start(); ?>
		
		<div id="content" <?php yt_section_classes( 'site-content', 'content' );?> role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php yt_before_loop(); ?>
			
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php yt_loop_start(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>
				
				<?php yt_loop_end(); ?>

			<?php endwhile; ?>
			
			<?php yt_after_loop(); ?>

			<?php yt_direction_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>

		</div><!-- #content -->
		
		<?php yt_primary_end(); ?>
	
	</div><!-- #primary -->
	
	<?php yt_after_primary(); ?>
	
<?php get_footer(); ?>
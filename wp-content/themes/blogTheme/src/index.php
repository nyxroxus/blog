<?php get_header(); ?>

	<main role="main w-80 center" aria-label="Content">
		<!-- section -->
		<section class="w-70">
			<!-- Add tachyon classes for page title -->
			<div class="f3 custom-post-title bb tc">
				<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>
			</div>
			<div class="br3 bg-gray pa3 ph3 mt2" style="max-width:900px;">
				<?php get_template_part('loop'); ?>
			</div>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

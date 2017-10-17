<?php
/*
 * The Footer
 */
?>

<div id="footer" class="section-footer">
	<div class="footer-wrapper">

		<?php if (function_exists('get_field') && get_field('show_instagram_feed', 'option')): ?>
		<!-- Instagram feed start -->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h4 class="h4-special instagram-feed-heading"><?php echo esc_html__('Follow on Instagram:', 'mauer-essentialist') ?></h4>
				</div>
			</div>		
		</div>
		<div id="mauer-instafeed" class="text-center" data-error-intro="<?php echo esc_attr(esc_html__('An error occured while getting Instagram images. Please double-check your settings. Original error text: ', 'mauer-essentialist')); ?>"></div>
		<!-- Instagram feed end -->	
		<?php endif ?>

		<div class="footer-pane">

			<?php get_template_part('bottomwidgetarea'); ?>

			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if (is_active_sidebar('widgetized-area-l') || is_active_sidebar('widgetized-area-c') || is_active_sidebar('widgetized-area-r')) {$class_to_add = " copyright-bordered";} ?>
						<div class="copyright text-center<?php echo esc_html($class_to_add); ?>"><?php echo wp_kses_post(mauer_copyright_text()); ?></div>
					</div>
				</div>
			</div>

		</div>
		
	</div>
</div>

<?php get_template_part("content", "pswp"); ?>
<?php wp_footer(); ?>

</body>
</html>
<?php
/*
 * Widgetized area template
 */
?>

<?php if (is_active_sidebar('widgetized-area-l') || is_active_sidebar('widgetized-area-c') || is_active_sidebar('widgetized-area-r')): ?>

	<div id="bottom-widgets">
		<div class="container">
			<div class="row">

				<?php if (is_active_sidebar('widgetized-area-l')): ?>
					<div class="col-xs-12 col-sm-4 widgetized-area-column">
						<div class="widgetized-area">
							<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area-l')) : else : ?>
							<div class="pre-widget">
								<p><strong><?php esc_html_e('Widgetized area', 'mauer-essentialist'); ?></strong></p>
								<p><?php esc_html_e('To add widgets here please go to the Admin Panel, and select Appearance>Widgets.', 'mauer-essentialist'); ?></p>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif ?>

				<?php if (is_active_sidebar('widgetized-area-c')): ?>
					<div class="col-xs-12 col-sm-4 widgetized-area-column">
						<div class="widgetized-area">
							<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area-c')) : else : ?>
							<div class="pre-widget">
								<p><strong><?php esc_html_e('Widgetized area', 'mauer-essentialist'); ?></strong></p>
								<p><?php esc_html_e('To add widgets here please go to the Admin Panel, and select Appearance>Widgets.', 'mauer-essentialist'); ?></p>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif ?>

				<?php if (is_active_sidebar('widgetized-area-r')): ?>
					<div class="col-xs-12 col-sm-4 widgetized-area-column">
						<div class="widgetized-area">
							<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area-r')) : else : ?>
							<div class="pre-widget">
								<p><strong><?php esc_html_e('Widgetized area', 'mauer-essentialist'); ?></strong></p>
								<p><?php esc_html_e('To add widgets here please go to the Admin Panel, and select Appearance>Widgets.', 'mauer-essentialist'); ?></p>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif ?>

			</div>
		</div>
	</div>

<?php endif; ?>
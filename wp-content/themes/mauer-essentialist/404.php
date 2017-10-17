<?php
/*
* Page not found (404 error)
*/
get_header(); ?>

<div class="section-main-content">

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="four-o-four-wrapper">

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
							<h1 class="entry-title text-center"><?php esc_html_e( 'Page not found (Error 404)', 'mauer-essentialist' ); ?></h1>
							<div class="entry-content">
								<p class="error-p text-center"><?php printf( wp_kses_post( 'You may want to head over to the <a href="%s">front page</a>, or search for the content you expected to be here.', 'mauer-essentialist' ), esc_url(home_url('/')) ); ?></p>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-10 col-md-offset-1">
									<?php get_search_form(); ?>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</div><!-- /.section-main-content -->

<?php get_footer();?>
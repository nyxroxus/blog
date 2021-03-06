<?php
/*
 * The Header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if (function_exists('get_field')) {mauer_provide_instafeed_settings();} ?>

<div class="mauer-preloader">
	<div class="mauer-spinner"></div>
</div>

<div class="search-popup">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
	<a href="#" class="mauer-close search-popup-closer"></a>
</div>

<div class="section section-menu-stripe">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">

				<div class="menu-stripe-wrapper">

					<nav class="navbar navbar-default navbar-static-top mauer-navbar">
						<div class="navbar-header f2">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only"><?php echo esc_html__( 'Toggle navigation', 'mauer-essentialist' ); ?></span>
								<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<?php mauer_wp_nav_menu(); ?>
							<div class="search-link search-link-in-collapsed-navbar">
								<a class="search-popup-opener" href=""><i class="fa fa-search"></i></a>
							</div>
						</div>
					</nav>

					<div class="social-links">
						<?php mauer_display_social_buttons(); ?>
					</div>

					<div class="search-link search-link-in-the-corner">
						<a class="search-popup-opener f2" href=""><i class="fa fa-search"></i><span class="search-link-text"></span></a>
					</div>	

				</div>

			</div>
		</div>
	</div>
</div>



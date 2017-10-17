<?php
/*
 * functions.php
 */


if (!isset($content_width)) {$content_width = 1170;}





if (!function_exists('mauer_theme_setup')) :

	function mauer_theme_setup() {
		# Includes
		include_once(get_template_directory() . '/includes/wp-bootstrap-navwalker/wp_bootstrap_navwalker.php');
		include_once(get_template_directory() . '/includes/acf-fields.php' );
		require_once(get_template_directory() . '/includes/TGMPA/class-tgm-plugin-activation.php');
		# Theme features
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'mauer-essentialist' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		mauer_add_image_sizes();
		# Other
		load_theme_textdomain('mauer-essentialist', get_template_directory() . '/lang');
		update_option('image_default_link_type','none');
	}

endif;

add_action('after_setup_theme', 'mauer_theme_setup');





if (!function_exists('mauer_enqueue_scripts_and_styles')) :

	function mauer_enqueue_scripts_and_styles() {
		# Styles
		wp_enqueue_style('bootstrap', get_template_directory_uri() . "/includes/bootstrap/css/bootstrap.min.css");
		wp_enqueue_style('mauer-google-fonts', mauer_google_fonts_url());
		wp_enqueue_style('metropolis', get_template_directory_uri() . '/fonts/Metropolis/stylesheet.css');
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/includes/font-awesome/css/font-awesome.min.css');
		// Making mauer-theme-stylesheet depend on bootstrap so that it loads after bootstrap and overrides its styles
		wp_enqueue_style('mauer-theme-stylesheet', get_template_directory_uri() . '/style.css', 'bootstrap' );
		wp_enqueue_style('photo-swipe', get_template_directory_uri() . '/includes/photoSwipe/photoswipe.css');
		wp_enqueue_style('photo-swipe-default-skin', get_template_directory_uri() . '/includes/photoSwipe/default-skin/default-skin.css');

		# Scripts
		// Setting the last parameter of wp_enqueue_script to true forces WP to place the script in the footer
		// (however if it belongs to a group which is loaded in the header this can be overriden)
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/includes/bootstrap/js/bootstrap.min.js', array('jquery'), '',true);
		wp_enqueue_script('mauer-generalJS', get_template_directory_uri() . '/js/general.js', array('jquery'), '',true);


		$layout_style = mauer_get_layout_setting();

		if ($layout_style == "masonry") {
			wp_enqueue_script('jquery-masonry', array('jquery'), '', true);
			wp_enqueue_script('masonryInitializer', get_template_directory_uri() . '/js/masonryInitializer.js', array('masonry'), '', true);
		}

		wp_enqueue_script('remUnitPolyfill', get_template_directory_uri() . '/includes/remUnitPolyfill/js/rem.min.js', array('jquery'), '', true);
		wp_enqueue_script('photoSwipe', get_template_directory_uri() . '/includes/photoSwipe/photoswipe.min.js', array('jquery'), '',true);
		wp_enqueue_script('photoSwipeUIDefault', get_template_directory_uri() . '/includes/photoSwipe/photoswipe-ui-default.min.js', array('photoSwipe'),'',true);
		wp_enqueue_script('photoSwipeGalleryBuilder', get_template_directory_uri() . '/js/photoSwipeGalleryBuilder.js',array('photoSwipeUIDefault'),'',true);
		wp_enqueue_script('instafeed', get_template_directory_uri() . '/includes/instafeed/instafeed.min.js', array('jquery'),'',true);
		wp_enqueue_script('PlaceholdersJS', get_template_directory_uri() . '/includes/placeholdersJS/placeholders.min.js', array('jquery'),'',true);

		if (is_singular() && get_option('thread_comments')) {wp_enqueue_script('comment-reply');}

		//HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
		wp_enqueue_script('html5shiv', get_template_directory_uri() . '/includes/html5Shiv/html5shiv.min.js', array('jquery'),'',false);
		wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
		wp_enqueue_script('respond', get_template_directory_uri() . '/includes/respondJS/respond.min.js', array('jquery'),'',false);
		wp_script_add_data('respond', 'conditional', 'lt IE 9');
	}

endif;

add_action('wp_enqueue_scripts', 'mauer_enqueue_scripts_and_styles');





if (!function_exists('mauer_enqueue_admin_scripts_and_styles')) :
	function mauer_enqueue_admin_scripts_and_styles() {
		wp_enqueue_style('adminStyles', get_template_directory_uri() . '/css/admin-styles.css');
	}
endif;

add_action('admin_enqueue_scripts', 'mauer_enqueue_admin_scripts_and_styles');





if (!function_exists('mauer_add_editor_stylesheet')) :
	function mauer_add_editor_stylesheet() {
		add_editor_style('css/editor-styles.css');
	}
endif;

add_action('admin_init', 'mauer_add_editor_stylesheet');





// Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');





if (!function_exists('mauer_acf_add_options_page')) :

	function mauer_acf_add_options_page() {
		if(function_exists('acf_add_options_page')) {

			acf_add_options_page(array(
				'menu_title'	=> esc_html__('Theme Options', 'mauer-essentialist'),
				'menu_slug' 	=> 'mauer-theme-options',
				'redirect'		=> true
			));

		}
	}

endif;

add_action( 'init', 'mauer_acf_add_options_page');





if (!function_exists('mauer_add_image_sizes')) :

	function mauer_add_image_sizes() {
		// Most image sizes are 140% - for better sharpness.
		add_image_size( "mauer_thumb_1", 781, 520, TRUE ); // 2 col grid thumbs
		add_image_size( "mauer_thumb_2", 510, 382, TRUE ); // 3 col grid and galleries
		add_image_size( "mauer_thumb_3_softcropped", 680, 680, FALSE ); // masonry thumbs
		add_image_size( "mauer_thumb_4", 526, 526, TRUE );
		add_image_size( "mauer_cover_thumb", 1596, 860, TRUE );
		add_image_size( "mauer_grand_softcropped", 1920, 1920, FALSE );
	}

endif;





if (!function_exists('mauer_google_fonts_url')) :

	function mauer_google_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by the following fonts, translate this to 'off'. Do not translate
		* into your own language. */
		$font1 = esc_html_x( 'on', 'Playfair Display font: on or off', 'mauer-essentialist' );
		$font2 = esc_html_x( 'on', 'Libre Franklin font: on or off', 'mauer-essentialist' );
		$font3 = esc_html_x( 'on', 'Yesteryear font: on or off', 'mauer-essentialist' );

		if (function_exists('get_field') && get_field('logo_to_use', 'option') == 'image') { $font3 = 'off';} 
		 
		if ( 'off' !== $font1 || 'off' !== $font2 || 'off' != $font3 ) {
			$font_families = array();
			 
			if ( 'off' !== $font1 ) {$font_families[] = 'Playfair Display:400,400i,700,700i';}
			if ( 'off' !== $font2 ) {$font_families[] = 'Libre Franklin:300,300i,400,400i,700,700i';}
			if ( 'off' !== $font3 ) {$font_families[] = 'Yesteryear';}
			 
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			 
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

endif;





if (!function_exists('mauer_wp_nav_menu')) :

	function mauer_wp_nav_menu() {
		$menu_args = array(
			'depth' => 2,
			'container' => false,
			'menu_class' => 'nav navbar-nav',
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
			'walker' => new wp_bootstrap_navwalker()
		);
		if (has_nav_menu( 'primary' )) {$menu_args['theme_location'] = 'primary';}
		wp_nav_menu($menu_args);
	}

endif;





if (!function_exists('mauer_display_header_logo')) :

	function mauer_display_header_logo() {
		if (function_exists('get_field')) {
			$logo_to_use = get_field('logo_to_use', 'option');
		} else {
			$logo_to_use = 'text';
		}
		if ($logo_to_use == 'image') {
			$logo_image = get_field('logo_image', 'option');
			$logo_image = $logo_image['url'];
			echo "<img src=" . esc_url($logo_image) . " alt='" . get_bloginfo('name') . "'/>";
		} else {
			echo "<span class='text-logo'>" . get_bloginfo('name') . "</span>";
		}
	}

endif;





if (!function_exists('mauer_get_layout_setting')) :

	function mauer_get_layout_setting($setting="layout_style") {
		$r = array();
		if (isset($_GET["demo_layout"])) {$layout_style = $_GET["demo_layout"];}
		if (isset($_GET["demo_big_latest"])) {$big_latest = $_GET["demo_big_latest"];}

		$possible_layouts = array("grid_2_cols", "grid_3_cols", "list", "masonry");

		if (isset($layout_style) && in_array($layout_style, $possible_layouts)) {
			$r["layout_style"] = $layout_style;
		} 
		elseif(function_exists('get_field') && get_field('blog_page_layout', 'option')) {
			$r["layout_style"] = get_field('blog_page_layout', 'option');
		} 
		else {
			$r["layout_style"] = "grid_2_cols";
		}

		if (isset($big_latest)) {
			switch ($big_latest) {
				case 'yes':
					$r["big_latest"] = 1;
					break;
				case 'no':
					$r["big_latest"] = 0;
					break;

				default:
					$r["big_latest"] = 0;
					break;
			}
		}
		else {
			if (function_exists('get_field')) {
				$r["big_latest"] = get_field("big_latest", "option");
			} 
			else {
				$r["big_latest"] = 0;
			}
		}

		return $r[$setting];
	}

endif;





if (!function_exists('mauer_width_attribute_removal')) :

	// This does not work for the already existing images.
	// A CSS solution has been implemented. This code is left here for the old browsers.
	function mauer_width_attribute_removal( $html ) {
		 $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
		 return $html;
	}

endif;

add_filter('post_thumbnail_html', 'mauer_width_attribute_removal', 100);
add_filter('image_send_to_editor', 'mauer_width_attribute_removal', 100);





if (!function_exists('mauer_favicon_fallback')) :

	function mauer_favicon_fallback($tags) {
		// if there's no site icon set in Appearance > Customize, use a fallback favicon.
		if (!has_site_icon()) {

			if (function_exists('get_field') && get_field('favicon_fallback', 'option')) {
				$monogram = get_field('favicon_fallback', 'option');
			} else {
				$monogram = substr(get_bloginfo("name"), 0, 1);
			}

			if (preg_match("/^[a-zA-Z]/", $monogram, $matches)) {
				$the_letter = strtolower($matches[0]);
			} else {
				$the_letter = 'universal';
			}
			$fallback_favicon_url = get_template_directory_uri() . '/img/favicons/' . $the_letter . '.png';
			echo '<link rel="icon" type="image/png" href="' . esc_url($fallback_favicon_url) . '" />';
		}
	}

endif;

add_filter('wp_head', 'mauer_favicon_fallback');





if (!function_exists('mauer_prevent_wp_from_jumping_to_anchor')) :

	function mauer_prevent_wp_from_jumping_to_anchor($link) {
		$offset = strpos($link, '#more-');
		if ($offset) { $end = strpos($link, '"',$offset); }
		if ($end) { $link = substr_replace($link, '', $offset, $end - $offset); }
		return $link;
	}

endif;

add_filter('the_content_more_link', 'mauer_prevent_wp_from_jumping_to_anchor');





if (!function_exists('mauer_theme_more_link')) :

	function mauer_theme_more_link($more_link, $more_link_text = "") {
		global $post;
		ob_start(); ?>
		<div class="more-link-holder">
			<a class="more-link ghost-button-link" href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__("read more", "mauer-essentialist") ?></a>
		</div><?php
		return ob_get_clean();
	}

endif;

add_filter('the_content_more_link', 'mauer_theme_more_link', 10, 2);





if (!function_exists('mauer_excerpt_more')) :
	// issue well described here: http://bit.ly/2jfCahy
	function mauer_excerpt_more($more) {return '';}
endif;

add_filter('excerpt_more', 'mauer_excerpt_more', 21);





if (!function_exists('mauer_excerpt_more_link')) :

	function mauer_excerpt_more_link($excerpt){
		global $post;

		ob_start(); ?>
		<div class="more-link-holder">
			<a class="more-link ghost-button-link" href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__("read more", "mauer-essentialist") ?></a>
		</div><?php
		$excerpt .= ob_get_clean();
		return $excerpt;
	}

endif;

add_filter('the_excerpt', 'mauer_excerpt_more_link', 21);





if (!function_exists('custom_excerpt_length')) :
	function custom_excerpt_length($length) {
		if (function_exists('get_field') && get_field('excerpts_length', 'option')) {
			$r = get_field('excerpts_length', 'option');
		} else {
			$r = 30;
		}
		return $r;
	}

endif;

add_filter('excerpt_length', 'custom_excerpt_length', 999);





if (!function_exists('mauer_get_prev_posts_link_text')) :

	function mauer_get_prev_posts_link_text() {
		if (!is_search()) {
			$r = esc_html__('Newer posts', 'mauer-essentialist');
		} else {
			$r = esc_html__('Newer results', 'mauer-essentialist');
		}
		return $r;
	}

endif;





if (!function_exists('mauer_get_next_posts_link_text')) :

	function mauer_get_next_posts_link_text() {
		if (!is_search()) {
			$r = esc_html__('Older posts', 'mauer-essentialist');
		} else {
			$r = esc_html__('Older results', 'mauer-essentialist');
		}
		return $r;
	}

endif;





if (!function_exists('mauer_wp_link_pages_parameters')) :

	function mauer_wp_link_pages_parameters() {
		$r = array(
			'before'           => '<div class="mauer-wp-linked-pages-holder"><p>' . esc_html__( 'Pages:', 'mauer-essentialist' ) . '&nbsp;',
			'after'            => '</p></div>',
			'link_before'      => '<i>',
			'link_after'       => '</i>',
			'next_or_number'   => 'number',
			'separator'        => '&nbsp; ',
			'nextpagelink'     => esc_html__( 'Next page', 'mauer-essentialist' ),
			'previouspagelink' => esc_html__( 'Previous page', 'mauer-essentialist' ),
			'pagelink'         => '%',
			'echo'             => 1
		);
		return $r;
	}

endif;





if (!function_exists('mauer_comments')) :

	# The wp_list_comments() callback function. It handles the way the comments are displayed.
	function mauer_comments($comment, $args, $depth) {
		$GLOBALS["comment"] = $comment;
		# Pingbacks and Trackbacks
		if (get_comment_type() == "pingback" || get_comment_type() == "trackback") : ?>
			<li class="pingback" id="comment-<?php comment_ID(); ?>">
				<article <?php comment_class('clearfix pingback-holder'); ?>>
					<header>
						<h5 class="pingback-heading"><?php esc_html_e('Pingback', 'mauer-essentialist'); ?></h5>
					</header>
					<?php comment_author_link(); ?> (<?php edit_comment_link(); ?>)
				</article>
			<?php // there is no closing </li> because WP adds it automatically
		# Comments
		elseif (get_comment_type() == "comment") : ?>
			<li id="comment-<?php comment_ID(); ?>">
				<article <?php comment_class('clearfix comment-holder'); ?>>
					<div class="avatar-column">
						<header>
							<figure class="comment-avatar">
								<?php $avatar_size = 80; if ($comment->comment_parent != 0) { $avatar_size = 50; } ?>
								<?php echo get_avatar($comment, $avatar_size) ; ?>
							</figure>
							<h4 class="comment-heading"><?php comment_author_link(); ?></h4>
							<p class="comment-date"><?php comment_date(); ?> <?php echo esc_html_x('at', 'comes between comment date and comment time', 'mauer-essentialist') . " "; echo comment_time(); ?></p>
						</header>
					</div>
					<div class="comment-text">
						<?php if ($comment->comment_approved == '0'): ?>
							<p class="awaiting-moderation"><?php esc_html_e("Your comment is awaiting moderation", "mauer-essentialist"); ?>.</p>
						<?php endif ?>
						<?php comment_text(); ?>
						<?php comment_reply_link(array_merge($args,array('depth'=>$depth, 'max_depth'=>$args['max_depth']))); ?>
					</div>
				</article>
			<?php  // there is no closing </li> because WP adds it automatically
		endif;
	}

endif;





if (!function_exists('mauer_update_fields_with_placeholders')) :

	# These 2 functions filter the comment form and turn labels into placeholders.
	# Enqueuing Placeholders.js polyfill is needed for cross-browser compatibility of the placeholders.
	function mauer_update_fields_with_placeholders($fields) {
		$placeholders = array(
			'0' => esc_html_x('Name','comment form placeholder','mauer-essentialist'),
			'1' => esc_html_x('Email','comment form placeholder','mauer-essentialist'),
			'2' => esc_html_x('Website','comment form placeholder','mauer-essentialist'),
		);
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields['author'] =
			'<p class="comment-form-author">
				<input required minlength="3" maxlength="30" placeholder="'.esc_attr($placeholders[0]).'*" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
			</p>';
		$fields['email'] =
			'<p class="comment-form-email">
				<input required placeholder="'.esc_attr($placeholders[1]).'*" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
			</p>';
		$fields['url'] =
			'<p class="comment-form-url">
				<input placeholder="'.esc_attr($placeholders[2]).'" id="url" name="url" type="url" value="' . esc_attr( esc_url($commenter['comment_author_url']) ) . '" size="30" />
			</p>';
		return $fields;
	}

endif;

add_filter('comment_form_default_fields','mauer_update_fields_with_placeholders');





if (!function_exists('mauer_update_comment_field_with_placeholder')) :

	# the textarea
	function mauer_update_comment_field_with_placeholder($comment_field) {
		$comment_field =
			'<p class="comment-form-comment">
				<textarea required placeholder="'. esc_attr(esc_html_x('Comment','comment form placeholder','mauer-essentialist')) .'*" id="comment" name="comment" cols="25" rows="4" aria-required="true"></textarea>
			</p>';
		return $comment_field;
	}

endif;

add_filter('comment_form_field_comment','mauer_update_comment_field_with_placeholder');





if (!function_exists('mauer_gallery')) :

	function mauer_gallery($output, $atts) {
			global $post;

			$atts = shortcode_atts(array(
					'order' => 'ASC',
					'orderby' => 'menu_order ID',
					'id' => $post->ID,
					'itemtag' => 'dl',
					'icontag' => 'dt',
					'captiontag' => 'dd',
					'columns' => 3,
					'size' => 'thumbnail',
					'include' => '',
					'exclude' => ''
			), $atts);

			$id = intval($atts['id']);
			if ('RAND' == $atts['order']) {$atts['orderby'] = 'none';};

			if ( ! empty( $atts['include'] ) ) {
				$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( ! empty( $atts['exclude'] ) ) {
				$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
			} else {
				$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
			}

			if (empty($attachments)) return 'No images attached';
			$output = "<div class=\"mauer-pswp-gallery-wrapper\">\n";
			$output .= "<div class=\"mauer-pswp-gallery\" itemscope itemtype=\"http://schema.org/ImageGallery\">\n";
			$img_num = 0;
			foreach ($attachments as $id => $attachment) {
				$img_num++;
				$class = "";
				// even number of images in the gallery
				if (count($attachments) % 2 == 0) {
					if ($img_num % 2 != 0) {$class = "mauer-pswp-gallery-img-1-of-2";} 
					else {$class = "mauer-pswp-gallery-img-2-of-2";}
				}
				// odd number of images in the gallery
				if (count($attachments) % 2 != 0 && count($attachments) != 1) {
					// not the last three
					if (count($attachments) - $img_num >= 3) {
						if ($img_num % 2 != 0) {$class = "mauer-pswp-gallery-img-1-of-2";} 
						else {$class = "mauer-pswp-gallery-img-2-of-2";}
					}
					// the last three
					if (count($attachments) - $img_num < 3) {
						if (count($attachments) - $img_num == 2) {$class = "mauer-pswp-gallery-img-1-of-3";} 
						elseif (count($attachments) - $img_num == 1) {$class = "mauer-pswp-gallery-img-2-of-3";} 
						elseif (count($attachments) - $img_num == 0) {$class = "mauer-pswp-gallery-img-3-of-3";}
					}
				}
				// just one image in the gallery
				if (count($attachments) == 1) {
					$class = "mauer-pswp-gallery-img-1-and-only";
				}

				if (count($attachments) == 1) {$img_reg = wp_get_attachment_image_src($id, 'large');}
				else {$img_reg = wp_get_attachment_image_src($id, 'mauer_thumb_4');}
				$img_full = wp_get_attachment_image_src($id, 'mauer_grand_softcropped');

				$output .="<figure itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'>";
				$output .=	"<a href='" . esc_url($img_full[0]) . "' itemprop='contentUrl' data-size='" . $img_full[1] . "x" . $img_full[2] . "'>";
				$output .= 		"<img class='" . $class . "' src='" . esc_url($img_reg[0]) . "' itemprop='thumbnail' alt='" . esc_attr( get_post($id)->post_excerpt) . "' />";
				$output .=	"</a>";
				$output .=	"<figcaption itemprop='caption description'>" . esc_attr( get_post($id)->post_excerpt) . "</figcaption>";
				$output .="</figure>";

			}
			$output .= "</div>\n";
			$output .= "<div class='clearfix'></div>\n";
			$output .= "</div>\n";
			return $output;

	}

endif;

add_filter('post_gallery', 'mauer_gallery', 10, 2);





if (!function_exists('mauer_opengraph_image')) :

	// Jetpack OpenGraph image tag to the front page (by defukt Jetpack would show a placeholder).
	function mauer_opengraph_image($tags) {

		if (is_home()) {
			$image_url = "";
			global $wp_query;
			$current_post_index = 0;
			while ($image_url == ""  &&  $current_post_index+1 <= $wp_query->found_posts) {
				$current_post = $wp_query->posts[$current_post_index];
				if (has_post_thumbnail($current_post)) {
					$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($current_post->ID), 'mauer_thumb_3', true );
					$image_url = esc_url($thumb['0']);
				}
				$current_post_index++;
			}
			if ($image_url) {
				unset($tags['og:image']);
				$tags['og:image'] = esc_url($image_url);
			}
		}

		return $tags;
	}

endif;

add_filter('jetpack_open_graph_tags', 'mauer_opengraph_image');





if (!function_exists('mauer_post_link_attributes')) :
	function mauer_post_link_attributes() {return 'class="solid-button-link"';}
endif;

add_filter('next_posts_link_attributes', 'mauer_post_link_attributes');
add_filter('previous_posts_link_attributes', 'mauer_post_link_attributes');





if (!function_exists('mauer_get_related_posts')) :

	function mauer_get_related_posts($post_id, $taxonomy_1, $taxonomy_2 = "", $number_of_posts = 2, $ids_to_exclude = array()) {

		$tax_query = array();

		$taxonomy_1_terms = wp_get_post_terms($post_id, $taxonomy_1);
		if (!empty($taxonomy_1_terms)) {
			foreach ($taxonomy_1_terms as $a_term) {$taxonomy_1_term_ids_array[] = $a_term->term_id;}
			$tax_query[] = array(
				'taxonomy' => $taxonomy_1,
				'field'    => 'term_id',
				'terms'    => $taxonomy_1_term_ids_array
			);
		}

		if ($taxonomy_2) {
			$taxonomy_2_terms = wp_get_post_terms($post_id, $taxonomy_2);
			if (!empty($taxonomy_2_terms) && (!is_wp_error($taxonomy_2_terms))) {
				foreach ($taxonomy_2_terms as $a_term) {$taxonomy_2_term_ids_array[] = $a_term->term_id;}
				$tax_query[] = array(
					'taxonomy' => $taxonomy_2,
					'field'    => 'term_id',
					'terms'    => $taxonomy_2_term_ids_array
				);
			}
		}

		$ids_to_exclude[] = $post_id;
		$args = array(
			'post_type' => get_post_type($post_id),
			'post__not_in' => $ids_to_exclude,
			'posts_per_page' => $number_of_posts,
		);

		if (!empty($tax_query)) {
			$args['tax_query'] = $tax_query;
			if ($taxonomy_2) {
				$args['tax_query']['relation'] = 'AND';
			}
		}

		$the_query = new WP_Query($args);

		// if there are not enough posts with 'AND' relation, go with 'OR'
		if (!empty($tax_query) && $taxonomy_2 && $the_query->found_posts < $number_of_posts) {
			$args['tax_query']['relation'] = 'OR';
			$the_query = new WP_Query($args);
		}

		$posts_we_have = array();
		if ($the_query->found_posts) {
			foreach ($the_query->posts as $a_post) {$posts_we_have[] = $a_post->ID;}
		}

		// if there are not enough posts with the given term(s) after having tried the 'OR' relation, go for 'termless' posts
		if ($the_query->found_posts < $number_of_posts) {
			$nu_of_posts_we_still_need = $number_of_posts - $the_query->found_posts;
				$args = array();
				$args = array(
					'post_type' => get_post_type($post_id),
					'post__not_in' => array_merge($posts_we_have, array($post_id)),
					'posts_per_page' => $nu_of_posts_we_still_need,
				);
				$additional_query = new WP_Query($args);
		}

		if (isset($additional_query->found_posts)) {
			$r = array_merge($the_query->posts, $additional_query->posts);
		} 
		else {
			$r = $the_query->posts;
		}

		return $r;

	}

endif;





if (!function_exists('mauer_get_related_heading')) :

	function mauer_get_related_heading($post_id) {
		if (function_exists('get_field') && get_field('related_posts_mode', $post_id) == 'manual' && get_field('related_heading', $post_id)) {
			return get_field('related_heading', $post_id);
		}
	}

endif;





if (!function_exists('mauer_register_widgetized_areas')) :

	function mauer_register_widgetized_areas() {
			register_sidebar(array(
				'name'          => esc_html__('Bottom - Left', 'mauer-essentialist'),
				'id'            => 'widgetized-area-l',
				'description'   => esc_html__('Left widgetized area', 'mauer-essentialist'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4>',
				'after_title'   => '</h4>'
			));
			register_sidebar(array(
				'name'          => esc_html__('Bottom - Center', 'mauer-essentialist'),
				'id'            => 'widgetized-area-c',
				'description'   => esc_html__('Central widgetized area', 'mauer-essentialist'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4>',
				'after_title'   => '</h4>'
			));
			register_sidebar(array(
				'name'          => esc_html__('Bottom - Right', 'mauer-essentialist'),
				'id'            => 'widgetized-area-r',
				'description'   => esc_html__('Right widgetized area', 'mauer-essentialist'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4>',
				'after_title'   => '</h4>'
			));
	}

endif;

add_action('widgets_init', 'mauer_register_widgetized_areas');





if (!function_exists('mauer_display_social_buttons')) :

	function mauer_display_social_buttons() {
		if (function_exists('get_field')) {
			$repeater = get_field('social_links', 'option');
			if ($repeater) {
				foreach ($repeater as $key => $repeater_item) { 
					?><a target="_blank" href="<?php echo esc_url($repeater_item['url']); ?>" class="social-button-link"><i class="fa fa-<?php echo esc_attr($repeater_item['icon']); ?>"></i></a><?php
				}
			}
		}
	}

endif;





if (!function_exists('mauer_copyright_text')) :

	function mauer_copyright_text() {
		if (function_exists('get_field')) {
			$r = "";
			$text = get_field('copyright_text', 'option');
			// proceed only if there is some text
			if (mb_strlen(trim($text))!=0) {
				$r .= "&copy; ";
				if (get_field('copyright_include_year', 'option')) {
					if (get_field('copyright_year', 'option')) {
						if (get_field('copyright_year', 'option') == date('Y')) {$r .= date('Y') . " ";}
						elseif (get_field('copyright_year', 'option') < date('Y')) {$r .= get_field('copyright_year', 'option') . "&ndash;" .  date('Y') . " ";}
					} else {
						$r .= date('Y') . " ";
					}
				}
				$r .= $text;
				return $r;
			}
		}
		else {
			return "&copy; " . get_bloginfo('blogname') . ". Theme by <a href=\"http://mauer.co\">Mauer Themes</a>";
		}
	}

endif;





if (!function_exists('mauer_modify_main_query')) :

	// Modifying the main query for pages that have a big latest post
	function mauer_modify_main_query($query) {

		if (!is_admin()) {

			// for demo purposes
			if (isset($_GET["demo_layout"])) {
				$demo_layout_style = $_GET["demo_layout"];
				switch ($demo_layout_style) {
					case 'grid_2_cols':
						$posts_per_page_for_demo = 8;
						break;
					case 'grid_3_cols': case 'masonry':
						$posts_per_page_for_demo = 9;
						break;
					case 'list':
						$posts_per_page_for_demo = 5;
						break;
				}
				$query->set('posts_per_page', $posts_per_page_for_demo);
			}

			if ( $query->is_home() && $query->is_main_query() && mauer_get_layout_setting("big_latest") && get_query_var('paged')==0 && mauer_get_layout_setting("layout_style")!="list") {
				$posts_per_page_query_value = $query->get('posts_per_page');
				if (!empty($posts_per_page_query_value)) {
					$posts_per_page = $posts_per_page_query_value;}
				else {
					$posts_per_page = get_option('posts_per_page');
				}
		 		$query->set('posts_per_page', $posts_per_page + 1);

			}

			// Excluding the first post from the query on pages after the first one. Otherwise we get a repeated post (last one on first page, first one on second page).
			if ( $query->is_home() && $query->is_main_query() && mauer_get_layout_setting("big_latest") && get_query_var('paged') && mauer_get_layout_setting("layout_style")!="list") {
				$to_exclude = get_posts(array('posts_per_page' => 1));
				$query->set('post__not_in', array($to_exclude[0]->ID));
			}
				
		}

	}

endif;

add_action( "pre_get_posts", "mauer_modify_main_query" );





function mytheme_custom_styles() {

    // Initialize the variable
    $custom_css = '';

    // check if it's empty
    if( '' != get_theme_mod('sitetitle_typography') ) {
        $custom_css .= 'font-family: ' . get_theme_mod('sitetitle_typography') . ';';
    }
    // check if it's empty
    if( '' != get_theme_mod('sitetitle_weight') ) {
        $custom_css .= 'font-weight: ' . get_theme_mod('sitetitle_weight') . ';';
    }
    // check if it's empty
    if( '' != get_theme_mod('sitetitle_style' ) ) {
        $custom_css .= 'font-style: ' . get_theme_mod('sitetitle_style') . ';'; 
    }
    // if variable $custom_css has changed, then add the changes and execute wp_add_inline_style
    if( '' != $custom_css ) {
        $custom_css = '.site-title {' . $custom_css . '}';
        wp_add_inline_style( 'theme-specific', $custom_css );
    }

}

add_action( 'wp_enqueue_scripts', 'mytheme_custom_styles' );






if (!function_exists('mauer_add_custom_css')) :

	function mauer_add_custom_css() {

		$css_to_add = "";


		// accent color
		$default_color = "#ad8353";
		if (function_exists('get_field')) {
			$ac = get_field('accent_color', 'option');
			if (!$ac) {$ac = $default_color;}
		}
		else {
			$ac = $default_color;	
		}
		ob_start();?>

			a {color: <?php echo esc_html($ac) ?>;}

			.mauer-spinner {border-color: <?php echo esc_html($ac) ?>; border-top-color:transparent;}

			input[type="submit"], .section-main-content input[type="submit"],
			.ghost-button-link, .section-main-content .ghost-button-link {color: <?php echo esc_html($ac) ?>;}

			input[type="submit"]:hover, .section-main-content input[type="submit"]:hover,
			.ghost-button-link:hover, .section-main-content .ghost-button-link:hover {border-color: <?php echo esc_html($ac) ?>; background-color: <?php echo esc_html($ac) ?>;}

			.solid-button-link {background-color: <?php echo esc_html($ac) ?>;}

			.site-desc {color: <?php echo esc_html($ac) ?>;}

			blockquote {border-left-color: <?php echo esc_html($ac) ?>;}<?php
			
		$css_to_add .= ob_get_clean();


		// custom logo tweaks
		$default_mw = 180;
		if (function_exists('get_field') && get_field('logo_to_use', 'option') == 'image') {
			if (get_field('logo_image_width', 'option')) {
				$val = get_field('logo_image_width', 'option') / 10;
			} else {
				$val = 180 / 10;
			}
			ob_start();?>
			.image-logo-wrapper {max-width: <?php echo esc_html($val); ?>rem;}
			<?php 
		
		$css_to_add .= ob_get_clean();

		}


		wp_add_inline_style('mauer-theme-stylesheet', $css_to_add);
	}

endif;

add_action('wp_enqueue_scripts', 'mauer_add_custom_css');





if (!function_exists('mauer_body_class_filter')) :

	function mauer_body_class_filter($classes) {
		if (function_exists('get_field') && get_field('show_instagram_feed', 'option')) {
			$classes[] = "has-instagram-feed";
		}
		return $classes;
	}

endif;

add_filter('body_class', 'mauer_body_class_filter');





if (!function_exists('mauer_append_page_links_to_content')) :

	function mauer_append_page_links_to_content($content) {
		if(is_singular() && is_main_query()) {
			ob_start();
			wp_link_pages(mauer_wp_link_pages_parameters());
			$new_content = ob_get_clean();
			$content .= $new_content;	
		}	
		return $content;
	}

endif;

add_filter('the_content', 'mauer_append_page_links_to_content');





if (!function_exists('mauer_provide_instafeed_settings')) :

	function mauer_provide_instafeed_settings() {
		if (function_exists('get_field') && get_field('show_instagram_feed', 'option')) {

			$fields['accessToken'] = 'instagram_access_token';

			$settings = array();
			foreach ($fields as $field_name => $field) {
				if (get_field($field, 'option')) {
					$settings[$field_name] = trim(get_field($field, 'option'));
				}
			}

			if(!empty($settings)) {
				echo "<div id='mauer-instafeed-settings'>";
				foreach ($settings as $k => $setting) {
					echo "<i id='" . esc_attr($k) . "'>$setting</i>";
				}
				echo "</div>";
			}

		}
	}

endif;





if (!function_exists('mauer_register_recommended_plugins')) :

	function mauer_register_recommended_plugins() {
		$plugins = array(
			array(
				'name'               => esc_html__('ACF Pro (bundled with the theme)', 'mauer-essentialist'), // The plugin name.
				'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/lib/plugins/advanced-custom-fields-pro.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false,
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'mauer-essentialist'),
				'slug'      => 'contact-form-7',
				'required'  => false,
				'force_activation'   => false,
			),
			array(
				'name'      => esc_html__('Jetpack', 'mauer-essentialist'),
				'slug'      => 'jetpack',
				'required'  => false,
				'force_activation'   => false,
			),
		);

		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

endif;

add_action( 'tgmpa_register', 'mauer_register_recommended_plugins' );

?>
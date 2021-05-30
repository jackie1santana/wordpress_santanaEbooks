<?php
/**
 * Theme hooks.
 *
 * @package Trickleup
 */

// Menu description.
add_filter( 'walker_nav_menu_start_el', 'trickleup_nav_menu_description', 10, 4 );

// Sidebars classes.
add_filter( 'trickleup_widget_area_classes', 'trickleup_set_sidebar_classes', 10, 2 );

// Set footer columns.
add_filter( 'dynamic_sidebar_params', 'trickleup_get_footer_widget_layout' );

// Adapt default image post format classes to current theme.
add_filter( 'cherry_post_formats_image_css_model', 'trickleup_add_image_format_classes', 10, 2 );

// Enqueue misc js script.
add_filter( 'trickleup_theme_script_depends', 'trickleup_enqueue_misc' );

// Add to toTop and stickUp properties if required.
add_filter( 'trickleup_theme_script_variables', 'trickleup_js_vars' );

// Add has/no thumbnail classes for posts.
add_filter( 'post_class', 'trickleup_post_thumb_classes' );

// Modify a comment form.
add_filter( 'comment_form_defaults', 'trickleup_modify_comment_form' );

// Reorder comment fields
add_filter( 'comment_form_fields', 'trickleup_reorder_comment_fields' );

// Additional body classes.
add_filter( 'body_class', 'trickleup_extra_body_classes' );

// Render macros in text widgets.
add_filter( 'widget_text', 'trickleup_render_widget_macros' );

// Adds the meta viewport to the header.
add_action( 'wp_head', 'trickleup_meta_viewport', 0 );

// Customization for `Tag Cloud` widget.
add_filter( 'widget_tag_cloud_args', 'trickleup_customize_tag_cloud' );

// Changed excerpt more string.
add_filter( 'excerpt_more', 'trickleup_excerpt_more' );

// Creating wrappers for audio shortcode.
add_filter( 'wp_audio_shortcode', 'trickleup_audio_shortcode', 10, 5 );

// Set specific content classes.
add_filter( 'trickleup_content_classes', 'trickleup_set_specific_content_classes' );

// Set specific customizer settings.
add_filter( 'theme_mod_sidebar_position', 'trickleup_specific_sidebar_position' );

// Landing main menu location.
add_filter( 'trickleup_main_menu_args', 'trickleup_landing_main_menu_location' );

/**
 * Append description into nav items
 *
 * @param  string $item_output The menu item output.
 * @param  WP_Post $item Menu item object.
 * @param  int $depth Depth of the menu.
 * @param  array $args wp_nav_menu() arguments.
 *
 * @return string
 */
function trickleup_nav_menu_description( $item_output, $item, $depth, $args ) {

	if ( 'main' !== $args->theme_location || ! $item->description ) {
		return $item_output;
	}

	$descr_enabled = get_theme_mod(
		'header_menu_attributes',
		trickleup_theme()->customizer->get_default( 'header_menu_attributes' )
	);

	if ( ! $descr_enabled ) {
		return $item_output;
	}

	$current     = $args->link_after . '</a>';
	$description = '<div class="menu-item__desc">' . $item->description . '</div>';
	$item_output = str_replace( $current, $description . $current, $item_output );

	return $item_output;
}

/**
 * Set layout classes for sidebars.
 *
 * @since  1.0.0
 * @uses   trickleup_get_layout_classes.
 *
 * @param  array $classes Additional classes.
 * @param  string $area_id Sidebar ID.
 *
 * @return array
 */
function trickleup_set_sidebar_classes( $classes, $area_id ) {

	if ( 'sidebar' == $area_id ) {
		return trickleup_get_layout_classes( 'sidebar', $classes );
	}

	if ( 'after-content-full-width-area' == $area_id ) {
		$classes[] = trickleup_get_invert_class_customize_option( 'footer_bg' );
	}

	if ( 'footer-area' == $area_id ) {
		$columns = get_theme_mod( 'footer_widget_columns', trickleup_theme()->customizer->get_default( 'footer_widget_columns' ) );

		if ( '1' !== $columns ) {
			$classes[] = sprintf( 'footer-area--%s-cols', $columns );
		} else {
			$classes[] = 'footer-area--fullwidth';
		}

		$classes[] = 'row';
	}

	return $classes;
}

/**
 * Get footer widgets layout class
 *
 * @since  1.0.0
 *
 * @param  string $params Existing widget classes.
 *
 * @return string
 */
function trickleup_get_footer_widget_layout( $params ) {

	if ( is_admin() ) {
		return $params;
	}

	if ( empty( $params[0]['id'] ) || 'footer-area' !== $params[0]['id'] ) {
		return $params;
	}

	if ( empty( $params[0]['before_widget'] ) ) {
		return $params;
	}

	$columns = get_theme_mod(
		'footer_widget_columns',
		trickleup_theme()->customizer->get_default( 'footer_widget_columns' )
	);

	$columns = intval( $columns );
	$classes = 'class="col-xs-12 col-sm-%3$s col-md-%2$s col-lg-%1$s %4$s ';

	switch ( $columns ) {
		case 4:
			$lg_col = 3;
			$md_col = 6;
			$sm_col = 12;
			$extra  = '';
			break;

		case 3:
			$lg_col = 4;
			$md_col = 4;
			$sm_col = 12;
			$extra  = '';
			break;

		case 2:
			$lg_col = 6;
			$md_col = 6;
			$sm_col = 12;
			$extra  = '';
			break;

		default:
			$lg_col = 12;
			$md_col = 12;
			$sm_col = 12;
			$extra  = '';
			break;
	}

	$params[0]['before_widget'] = str_replace(
		'class="',
		sprintf( $classes, $lg_col, $md_col, $sm_col, $extra ),
		$params[0]['before_widget']
	);

	return $params;
}

/**
 * Filter image CSS model
 *
 * @param  array $css_model Default CSS model.
 * @param  array $args Post formats module arguments.
 *
 * @return array
 */
function trickleup_add_image_format_classes( $css_model, $args ) {
	$blog_featured_image = get_theme_mod( 'blog_featured_image', trickleup_theme()->customizer->get_default( 'blog_featured_image' ) );
	$blog_layout         = get_theme_mod( 'blog_layout_type', trickleup_theme()->customizer->get_default( 'blog_layout_type' ) );
	$suffix              = ( 'default' !== $blog_layout ) ? 'fullwidth' : $blog_featured_image;

	$css_model['link'] .= ' post-thumbnail--' . $suffix;

	return $css_model;
}

/**
 * Enqueue misc js script.
 *
 * @param  array $depends Default dependencies.
 * @return array
 */
function trickleup_enqueue_misc( $depends ) {
	global $is_IE;

	if ( $is_IE ) {
		$depends[] = 'object-fit-images';
	}

	return $depends;
}

/**
 * Add to toTop and stickUp properties if required.
 *
 * @param  array $vars Default variables.
 *
 * @return array
 */
function trickleup_js_vars( $vars ) {
	$header_menu_sticky = get_theme_mod( 'header_menu_sticky', trickleup_theme()->customizer->get_default( 'header_menu_sticky' ) );

	if ( $header_menu_sticky && ! wp_is_mobile() ) {
		$vars['stickUp'] = true;
	}

	$totop_visibility = get_theme_mod( 'totop_visibility', trickleup_theme()->customizer->get_default( 'totop_visibility' ) );

	if ( $totop_visibility ) {
		$vars['toTop'] = true;
	}

	return $vars;
}

/**
 * Add has/no thumbnail classes for posts
 *
 * @param  array $classes Existing classes.
 *
 * @return array
 */
function trickleup_post_thumb_classes( $classes ) {
	$thumb = 'no-thumb';

	if ( has_post_thumbnail() ) {
		$thumb = 'has-thumb';
	}

	$classes[] = $thumb;

	return $classes;
}

/**
 * Add placeholder attributes for comment form fields.
 *
 * @param  array $args Arguments for comment form.
 *
 * @return array
 */
function trickleup_modify_comment_form( $args ) {
	$args = wp_parse_args( $args );

	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html_req  = ( $req ? " required='required'" : '' );
	$html5     = 'html5' === $args['format'];
	$commenter = wp_get_current_commenter();

	$args['label_submit'] = esc_html__( 'Submit Comment', 'trickleup' );

	$args['fields']['author'] = '<p class="comment-form-author"><i class="linearicon linearicon-man"></i><input id="author" class="comment-form__field" name="author" type="text" placeholder="' . esc_html__( 'Your name', 'trickleup' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>';

	$args['fields']['email'] = '<p class="comment-form-email"><i class="linearicon linearicon-envelope"></i><input id="email" class="comment-form__field" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_html__( 'Your e-mail', 'trickleup' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>';

	$args['fields']['url'] = '<p class="comment-form-url"><i class="linearicon linearicon-earth"></i><input id="url" class="comment-form__field" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_html__( 'Your website', 'trickleup' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	$args['comment_field'] = '<p class="comment-form-comment"><i class="linearicon linearicon-feather"></i><textarea id="comment" class="comment-form__field" name="comment" placeholder="' . esc_html__( 'Your comments *', 'trickleup' ) . '" cols="45" rows="8" aria-required="true" required="required"></textarea></p>';

	$args['title_reply_before'] = '<h5 id="reply-title" class="comment-reply-title">';

	$args['title_reply_after'] = '</h5>';

	$args['title_reply'] = esc_html__( 'Leave a reply', 'trickleup' );

	return $args;
}

/**
 * Reorder comment fields
 *
 * @param  array $fields Comment fields.
 *
 * @return array
 */
function trickleup_reorder_comment_fields( $fields ) {

	if ( is_singular( 'product' ) ) {
		return $fields;
	}

	$new_fields_order = array();
	$new_order        = array( 'author', 'email', 'url', 'comment' );

	foreach ( $new_order as $key ) {
		$new_fields_order[ $key ] = $fields[ $key ];
		unset( $fields[ $key ] );
	}

	return $new_fields_order;
}

/**
 * Add extra body classes
 *
 * @param  array $classes Existing classes.
 *
 * @return array
 */
function trickleup_extra_body_classes( $classes ) {
	global $is_IE;

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of ie to browsers IE.
	if ( $is_IE ) {
		$classes[] = 'ie';
	}

	// Adds a options-based classes.
	$header_layout  = get_theme_mod( 'header_container_type', trickleup_theme()->customizer->get_default( 'header_container_type' ) );
	$content_layout = get_theme_mod( 'content_container_type', trickleup_theme()->customizer->get_default( 'content_container_type' ) );
	$footer_layout  = get_theme_mod( 'footer_container_type', trickleup_theme()->customizer->get_default( 'footer_container_type' ) );
	$blog_layout    = get_theme_mod( 'blog_layout_type', trickleup_theme()->customizer->get_default( 'blog_layout_type' ) );
	$sb_position    = get_theme_mod( 'sidebar_position', trickleup_theme()->customizer->get_default( 'sidebar_position' ) );
	$sidebar        = get_theme_mod( 'sidebar_width', trickleup_theme()->customizer->get_default( 'sidebar_width' ) );
	$single_type    = get_theme_mod( 'single_post_type', trickleup_theme()->customizer->get_default( 'single_post_type' ) );
	$header_type    = get_theme_mod( 'header_layout_type', trickleup_theme()->customizer->get_default( 'header_layout_type' ) );
	$footer_type    = get_theme_mod( 'footer_layout_type', trickleup_theme()->customizer->get_default( 'footer_layout_type' ) );

	if ( is_singular( 'post' ) ) {
		$classes[] = 'single-post-' . sanitize_html_class( $single_type );;
	}

	if ( function_exists( 'tm_pb_is_pagebuilder_used' ) ) {
		if ( tm_pb_is_pagebuilder_used( get_the_ID() ) && ! is_search() ) {
			$classes[] = 'use-tm-pb-builder';
		}
	}

	return array_merge( $classes, array(
		'header-layout-' . $header_layout,
		'content-layout-' . $content_layout,
		'footer-layout-' . $footer_layout,
		'blog-' . $blog_layout,
		'position-' . $sb_position,
		'sidebar-' . str_replace( '/', '-', $sidebar ),
		'header-' . $header_type,
		'footer-' . $footer_type,
	) );
}

/**
 * Replace macroses in text widget.
 *
 * @param  string $text Default text.
 *
 * @return string
 */
function trickleup_render_widget_macros( $text ) {
	$uploads = wp_upload_dir();

	$data = array(
		'/%%uploads_url%%/' => $uploads['baseurl'],
		'/%%home_url%%/'    => esc_url( home_url( '/' ) ),
		'/%%theme_url%%/'   => get_stylesheet_directory_uri(),
	);

	return preg_replace( array_keys( $data ), array_values( $data ), $text );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  1.0.1
 */
function trickleup_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />' . "\n";
}

/**
 * Customization for `Tag Cloud` widget.
 *
 * @since  1.0.1
 *
 * @param  array $args Widget arguments.
 *
 * @return array
 */
function trickleup_customize_tag_cloud( $args ) {
	$args['smallest'] = 12;
	$args['largest']  = 12;
	$args['unit']     = 'px';

	return $args;
}

/**
 * Replaces `[...]` (appended to automatically generated excerpts) with `...`.
 *
 * @since  1.0.1
 *
 * @param  string $more The string shown within the more link.
 *
 * @return string
 */
function trickleup_excerpt_more( $more ) {

	if ( is_admin() ) {
		return $more;
	}

	return ' &hellip;';
}

/**
 * Creating wrappers for audio shortcode.
 */
function trickleup_audio_shortcode( $html, $atts, $audio, $post_id, $library ) {

	$html = '<div class="mejs-container-wrapper">' . $html . '</div>';

	return $html;
}

/**
 * Set specific content classes for blog listing
 */
function trickleup_set_specific_content_classes( $layout_classes ) {
	$sidebar_position = get_theme_mod( 'sidebar_position' );

	if ( ( 'fullwidth' === $sidebar_position && is_single() && ! is_singular( array( 'product', 'mp_menu_item' ) ) ) ) {
		$layout_classes = array( 'col-xs-12', 'col-md-12', 'col-xl-8', 'col-xl-push-2' );
	}

	return $layout_classes;
}

/**
 * Disable sidebar to 404 page.
 */
function trickleup_specific_sidebar_position( $value ) {

	if ( is_404() ) {
		return 'fullwidth';
	}

	return $value;
}

/**
 * Landing main menu location.
 */
function trickleup_landing_main_menu_location( $args ) {

	if ( 'page-templates/landing.php' === get_page_template_slug() ) {
		$args['theme_location'] = 'main_landing';
	}
	return $args;
}
<?php
/**
 * The template for displaying footer widget area.
 *
 * @package Trickleup
 */
// Check footer-area visibility.
if ( ! get_theme_mod( 'footer_widget_area_visibility', trickleup_theme()->customizer->get_default( 'footer_widget_area_visibility' ) ) || ! is_active_sidebar( 'footer-area' ) ) {
	return;
} ?>

<div class="footer-area-wrap <?php echo trickleup_get_invert_class_customize_option( 'footer_widgets_bg' ); ?>">
	<div class="container">
		<?php do_action( 'trickleup_render_widget_area', 'footer-area' ); ?>
	</div>
</div>

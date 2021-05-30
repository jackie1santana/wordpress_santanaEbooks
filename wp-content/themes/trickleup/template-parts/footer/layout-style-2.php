<?php
/**
 * The template for displaying the style-2 footer layout.
 *
 * @package Trickleup
 */

?>
<div class="footer-container <?php echo trickleup_get_invert_class_customize_option( 'footer_bg' ); ?>">
	<div class="site-info container">
		<?php
			trickleup_footer_logo();
			trickleup_footer_menu();
			trickleup_contact_block( 'footer' );
			trickleup_social_list( 'footer' );
			trickleup_footer_copyright();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->

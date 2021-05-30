<?php
/**
 * Template part for style-4 header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trickleup
 */

$search       = get_theme_mod( 'header_search', trickleup_theme()->customizer->get_default( 'header_search' ) );
?>
<div class="header-container_wrap container">
	<div class="header-container__flex">
		<div class="site-branding">
			<?php trickleup_header_logo() ?>
			<?php trickleup_site_description(); ?>
		</div>

		<?php trickleup_main_menu(); ?>
		
		<?php if ( $search ) : ?>
		<div class="header-icons divider">
			<?php trickleup_header_search( '<div class="header-search"><span class="search-form__toggle"></span>%s<span class="search-form__close"></span></div>' ); ?>
		</div>
		<?php endif; ?>

		<?php trickleup_header_btn(); ?>
	</div>
</div>

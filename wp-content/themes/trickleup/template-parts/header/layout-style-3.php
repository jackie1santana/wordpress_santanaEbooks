<?php
/**
 * Template part for style-3 header layout.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trickleup
 */
?>
<div class="header-container_wrap container">
	<?php trickleup_vertical_main_menu(); ?>
	<div class="header-container__flex">
		<div class="site-branding">
			<?php trickleup_header_logo() ?>
			<?php trickleup_site_description(); ?>
		</div>

		<div class="header-icons">
			<?php trickleup_header_search( '<div class="header-search"><span class="search-form__toggle"></span>%s<span class="search-form__close"></span></div>' ); ?>
			<?php trickleup_vertical_menu_toggle( 'main-menu' ); ?>
			<?php trickleup_header_btn(); ?>
		</div>

	</div>
</div>

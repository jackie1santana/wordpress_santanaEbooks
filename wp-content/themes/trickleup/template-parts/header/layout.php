<?php
/**
 * Template part for default header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trickleup
 */
?>
<div class="header-container_wrap container">
	<div class="header-container__flex">
		<div class="site-branding">
			<?php trickleup_header_logo() ?>
			<?php trickleup_site_description(); ?>
		</div>

		<?php trickleup_main_menu(); ?>
		<?php trickleup_header_btn(); ?>

	</div>
</div>

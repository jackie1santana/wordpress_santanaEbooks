<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Trickleup
 */
?>
<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title screen-reader-text"><?php esc_html_e( '404', 'trickleup' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<div class="invert">

			<h2><?php esc_html_e( 'Page Not Found.', 'trickleup' ); ?></h2>
			<p><?php esc_html_e( 'Map where your photos were taken and discover local points of interest. There&#39;s also a flip-out.', 'trickleup' ); ?></p>

		</div>
		<p><a class="btn btn-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go home', 'trickleup' ); ?></a></p>

	</div><!-- .page-content -->
</section><!-- .error-404 -->

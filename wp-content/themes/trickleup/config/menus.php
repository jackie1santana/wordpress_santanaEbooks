<?php
/**
 * Menus configuration.
 *
 * @package Trickleup
 */

add_action( 'after_setup_theme', 'trickleup_register_menus', 5 );
/**
 * Register menus.
 */
function trickleup_register_menus() {

	register_nav_menus( array(
		'top'          => esc_html__( 'Top', 'trickleup' ),
		'main'         => esc_html__( 'Main', 'trickleup' ),
		'main_landing' => esc_html__( 'Landing Main', 'trickleup' ),
		'footer'       => esc_html__( 'Footer', 'trickleup' ),
		'social'       => esc_html__( 'Social', 'trickleup' ),
	) );
}

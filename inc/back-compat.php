<?php
/**
 * Transportadora back compat functionality
 *
 * Prevents Transportadora from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Transportadora 1.0
 */

/**
 * Prevent switching to Transportadora on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Transportadora 1.0
 */
function transportadora_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'transportadora_upgrade_notice' );
}
add_action( 'after_switch_theme', 'transportadora_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Transportadora on WordPress versions prior to 4.7.
 *
 * @since Transportadora 1.0
 *
 * @global string $wp_version WordPress version.
 */
function transportadora_upgrade_notice() {
	$message = sprintf( __( 'Transportadora requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'transportadora' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Transportadora 1.0
 *
 * @global string $wp_version WordPress version.
 */
function transportadora_customize() {
	wp_die(
		sprintf( __( 'Transportadora requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'transportadora' ), $GLOBALS['wp_version'] ),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'transportadora_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Transportadora 1.0
 *
 * @global string $wp_version WordPress version.
 */
function transportadora_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Transportadora requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'transportadora' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'transportadora_preview' );

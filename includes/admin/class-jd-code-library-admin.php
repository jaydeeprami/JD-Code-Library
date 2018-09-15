<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    JD_Code_Library
 * @subpackage JD_Code_Library/admin
 */
class JD_Code_Library_Admin {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Enqueue Script and Style for Admin.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10, 1 );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_style( JD_CODE_LIBRARY_SLUG, JD_CODE_LIBRARY_PLUGIN_URL . 'assets/css/jd-code-library-admin' . $suffix . '.css', array( 'jquery-ui-style' ), JD_CODE_LIBRARY_VERSION, 'all' );
		wp_enqueue_style( JD_CODE_LIBRARY_SLUG );

		wp_enqueue_style( 'datetimepicker-style', JD_CODE_LIBRARY_PLUGIN_URL . 'assets/css/jquery.datetimepicker.min.css' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @access   public
	 *
	 * @param string $hook Page hook.
	 */
	public function enqueue_scripts( $hook ) {

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( 'post.php' === $hook || 'post-new.php' === $hook ) {

			// Enqueuing give fee recovery admin JS script.
			wp_register_script( JD_CODE_LIBRARY_SLUG, JD_CODE_LIBRARY_PLUGIN_URL . 'assets/js/jd-code-library-admin' . $suffix . '.js', array(
				'jquery',
			), JD_CODE_LIBRARY_VERSION, false );

			wp_enqueue_script( JD_CODE_LIBRARY_SLUG );

			wp_enqueue_script( 'datetimepicker-script', JD_CODE_LIBRARY_PLUGIN_URL . 'assets/js/jquery.datetimepicker.full.min.js' );
		}
	}
}

new JD_Code_Library_Admin();

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

		// Add Dashboard widget.
		add_action( 'wp_dashboard_setup', array( $this, 'jd_dashboard_setup' ) );

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

	/**
	 * Setup WordPress Dashboard widget.
	 */
	public function jd_dashboard_setup() {

		// Remove default WordPress Dashboard widget.
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

		wp_add_dashboard_widget( 'jd_dashboard_widget', // Widget slug.
			__( 'JD Dashboard Widget' ), // Title.
			array( $this, 'jd_dashboard_widget_function' ) // Display function.
		);
	}

	/**
	 * Callback function of JD Dashboard Widget.
	 */
	public function jd_dashboard_widget_function() {
		esc_html_e( 'This is a Sample Dashboard widget' );
	}
}

new JD_Code_Library_Admin();

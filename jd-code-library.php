<?php
/**
 * The plugin main file.
 *
 * @link              https://profiles.wordpress.org/jaydeep-rami/
 * @since             1.0.0
 * @package           JD_Code_Library
 *
 * @wordpress-plugin
 * Plugin Name:       JD Code Library
 * Plugin URI:
 * Description:       A Code Library which use different WordPress API with Example.
 * Version:           1.0.0
 * Author:            Jaydeep Rami
 * Author URI:        https://profiles.wordpress.org/jaydeep-rami/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jd-code-library
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'JD_Code_Library' ) ) :

	/**
	 * Main JD_Code_Library Class
	 *
	 * @since 1.0.0
	 */
	final class JD_Code_Library {

		/** Singleton *************************************************************/

		/**
		 * JD_Code_Library Instance
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @var    jd_code_library() The one true JD_Code_Library
		 */
		protected static $_instance;

		/**
		 * Main JD_Code_Library Instance
		 *
		 * Ensures that only one instance of JD_Code_Library exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since     1.0.0
		 * @access    public
		 *
		 * @static
		 * @see       jd_code_library()
		 *
		 * @return    JD_Code_Library
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * JD_Code_Library Constructor.
		 */
		public function __construct() {
			$this->setup_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'jd_code_library_loaded' );
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.0.0
		 */
		private function init_hooks() {
			add_action( 'plugins_loaded', array( $this, 'init' ), 0 );

			// Set up localization on init Hook.
			add_action( 'init', array( $this, 'load_textdomain' ), 0 );

		}


		/**
		 * Init JD_Code_Library when WordPress Initializes.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			/**
			 * Fires before the JD_Code_Library is initialized.
			 *
			 * @since 1.0.0
			 */
			do_action( 'before_jd_code_library_init' );

			// Set up localization.
			$this->load_textdomain();

			/**
			 * Fire the action after JD_Code_Library loads.
			 *
			 * @param object JD_Code_Library.
			 *
			 * @since 1.0.0
			 */
			do_action( 'jd_code_library_init', $this );

		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'JD_CODE_LIBRARY_VERSION' ) ) {
				define( 'JD_CODE_LIBRARY_VERSION', '1.0.0' );
			}

			// Plugin Slug.
			if ( ! defined( 'JD_CODE_LIBRARY_SLUG' ) ) {
				define( 'JD_CODE_LIBRARY_SLUG', 'jd-code-library' );
			}

			// Plugin Root File.
			if ( ! defined( 'JD_CODE_LIBRARY_PLUGIN_FILE' ) ) {
				define( 'JD_CODE_LIBRARY_PLUGIN_FILE', __FILE__ );
			}

			// Plugin Folder Path.
			if ( ! defined( 'JD_CODE_LIBRARY_PLUGIN_DIR' ) ) {
				define( 'JD_CODE_LIBRARY_PLUGIN_DIR', plugin_dir_path( JD_CODE_LIBRARY_PLUGIN_FILE ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'JD_CODE_LIBRARY_PLUGIN_URL' ) ) {
				define( 'JD_CODE_LIBRARY_PLUGIN_URL', plugin_dir_url( JD_CODE_LIBRARY_PLUGIN_FILE ) );
			}

			if ( ! defined( 'JD_CODE_LIBRARY_PLUGIN_BASENAME' ) ) {
				define( 'JD_CODE_LIBRARY_PLUGIN_BASENAME', plugin_basename( JD_CODE_LIBRARY_PLUGIN_FILE ) );
			}

		}

		/**
		 * Include required files
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function includes() {
			require_once JD_CODE_LIBRARY_PLUGIN_DIR . '/includes/jd-code-library-helper.php';

			if ( is_admin() ) {
				require_once JD_CODE_LIBRARY_PLUGIN_DIR . '/includes/admin/class-jd-code-library-admin.php';
			}
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return bool
		 */
		public function load_textdomain() {

			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), 'jd-code-library' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'jd-code-library', $locale );

			// Setup paths to current locale file.
			$mofile_local = trailingslashit( plugin_dir_path( JD_CODE_LIBRARY_PLUGIN_FILE ) . 'languages' ) . $mofile;

			if ( file_exists( $mofile_local ) ) {
				// Look in the /wp-content/plugins/jd-code-library/languages/ folder.
				load_textdomain( 'jd-code-library', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'jd-code-library', false, trailingslashit( plugin_dir_path( JD_CODE_LIBRARY_PLUGIN_FILE ) . 'languages' ) );
			}

			return false;
		}

	}

endif; // End if class_exists check.


/**
 * Start JD_Code_Library
 *
 * The main function responsible for returning the one true JD_Code_Library instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $jd_code_library = jd_code_library(); ?>
 *
 * @since 1.0.0
 * @return object|JD_Code_Library
 */
function jd_code_library() {
	return JD_Code_Library::instance();
}

jd_code_library();

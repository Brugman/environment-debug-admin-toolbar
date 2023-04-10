<?php
/**
 * Environment Debug Admin Toolbar
 *
 * Display your environment and debug info in the toolbar.
 *
 * @package           EnvDebugToolbar
 * @author            Medium Rare
 * @copyright         2023 Medium Rare
 * @license           GPL-3.0
 * @link              https://mediumrare.dev/
 *
 * @wordpress-plugin
 * Plugin Name:       Environment Debug Admin Toolbar
 * Description:       Display your environment and debug info in the toolbar.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Medium Rare
 * Author URI:        https://mediumrare.dev/
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       environment-debug-toolbar
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'EDT_FILE', __FILE__ );
define( 'EDT_BASENAME', plugin_basename( EDT_FILE ) );

define( 'EDT_VERSION', '1.0.0' );

/**
 * EDT
 */
class EDT {

	// > Unsorted Helpers.

	// > Misc Helpers.

	// > Toolbar Helpers.

	/**
	 * Get_env
	 *
	 * @return mixed Name of the environment, or false.
	 */
	private function get_env() {
		if ( function_exists( 'getenv' ) ) {
			if ( getenv( 'WP_ENVIRONMENT_TYPE' ) !== false ) {
				return getenv( 'WP_ENVIRONMENT_TYPE' );
			}
			if ( getenv( 'WP_ENV' ) !== false ) {
				return getenv( 'WP_ENVIRONMENT_TYPE' );
			}
		}

		if ( defined( 'WP_ENVIRONMENT_TYPE' ) ) {
			return WP_ENVIRONMENT_TYPE;
		}
		if ( defined( 'WP_ENV' ) ) {
			return WP_ENV;
		}

		return false;
	}

	/**
	 * Env_type
	 *
	 * @param  string $env Name of the environment.
	 * @return integer     Environment type number,
	 */
	private function env_type( $env ) {
		if ( ! $env ) {
			return 0;
		}

		switch ( strtolower( $env ) ) {
			case 'local':
			case 'dev':
			case 'develop':
			case 'development':
				return 1;
			case 'stage':
			case 'staging':
			case 'test':
			case 'testing':
			case 'accept':
			case 'acceptance':
			case 'integration':
				return 2;
			case 'prod':
			case 'production':
			case 'live':
				return 3;
			default:
				return 9;
		}
	}

	/**
	 * Html_label_value
	 *
	 * @param  string $label Text to display as label.
	 * @param  string $value Text to display as value.
	 * @return string        HTML to display label and value.
	 */
	private function html_label_value( $label, $value ) {
		$html  = '';
		$html .= '<span class="ei-label">' . $label . '</span>';
		$html .= '<span class="ei-value">' . $value . '</span>';

		return $html;
	}

	// > Hooks.

	/**
	 * Register_backend_styles
	 *
	 * @return void
	 */
	public function register_backend_styles() {
		// Register.
		wp_register_style(
			'edt-backend-css', // Name.
			plugin_dir_url( EDT_FILE ) . 'assets/edt.min.css', // URL.
			array(), // Deps.
			EDT_VERSION, // Version.
			'all' // Media.
		);
		// Enqueue.
		wp_enqueue_style( 'edt-backend-css' );
	}

	/**
	 * Register_translations
	 *
	 * @return void
	 */
	public function register_translations() {
		load_plugin_textdomain( 'environment-debug-toolbar', false, dirname( EDT_BASENAME ) . '/languages' );
	}

	// > Register Hooks.

	/**
	 * Register_toolbar
	 *
	 * @param  object $wp_admin_bar Details about toolbar nodes.
	 * @return void
	 */
	public function register_toolbar( $wp_admin_bar ) {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$env  = $this->get_env();
		$type = $this->env_type( $env );

		$node_title = match ( $type ) {
			0 => __( 'No Environment Found', 'environment-debug-toolbar' ),
			1 => __( 'Development', 'environment-debug-toolbar' ),
			2 => __( 'Staging', 'environment-debug-toolbar' ),
			3 => __( 'Production', 'environment-debug-toolbar' ),
			9 => __( 'Unknown Environment', 'environment-debug-toolbar' ),
			default => '',
		};

		$wp_admin_bar->add_group(
			array(
				'id' => 'edt-group',
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-node',
				'title'  => $node_title,
				'parent' => 'edt-group',
				'meta'   => array(
					'class' => 'env-type-' . $type,
				),
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-wp-debug',
				'title'  => $this->html_label_value( 'WP_DEBUG', ( WP_DEBUG ? 'true' : 'false' ) ),
				'parent' => 'edt-node',
			)
		);

		if ( ! WP_DEBUG ) {
			return;
		}

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-wp-debug-log',
				'title'  => $this->html_label_value( 'WP_DEBUG_LOG', ( WP_DEBUG_LOG ? 'true' : 'false' ) ),
				'parent' => 'edt-node',
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-wp-debug-display',
				'title'  => $this->html_label_value( 'WP_DEBUG_DISPLAY', ( WP_DEBUG_DISPLAY ? 'true' : 'false' ) ),
				'parent' => 'edt-node',
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-script-display',
				'title'  => $this->html_label_value( 'SCRIPT_DEBUG', ( SCRIPT_DEBUG ? 'true' : 'false' ) ),
				'parent' => 'edt-node',
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-savequeries',
				'title'  => $this->html_label_value( 'SAVEQUERIES', ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ? 'true' : 'false' ) ),
				'parent' => 'edt-node',
			)
		);
	}

	/**
	 * Register_hooks
	 *
	 * @return void
	 */
	public function register_hooks() {
		// Register backend styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_backend_styles' ) );
		// Register tranlations.
		add_action( 'init', array( $this, 'register_translations' ) );
		// Register toolbar.
		add_action( 'admin_bar_menu', array( $this, 'register_toolbar' ), 300, 1 );
	}
}

$edt = new EDT();
$edt->register_hooks();


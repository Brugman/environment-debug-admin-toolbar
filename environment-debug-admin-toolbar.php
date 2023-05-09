<?php
/**
 * Environment & Debug Bar
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
 * Plugin Name:       Environment & Debug Bar
 * Description:       Display your environment and debug info in the toolbar.
 * Version:           1.1.1
 * Requires at least: 5.5
 * Requires PHP:      7.4
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

define( 'EDT_VERSION', '1.1.1' );

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
	 * @return integer     Environment type number.
	 */
	private function env_type( $env ) {
		if ( ! $env ) {
			return 0;
		}

		$env = strtolower( $env );

		$env_development = apply_filters(
			'edt_env_development',
			array(
				'development',
				'develop',
				'dev',
				'local',
			)
		);

		if ( in_array( $env, $env_development ) ) {
			return 1;
		}

		$env_staging = apply_filters(
			'edt_env_staging',
			array(
				'staging',
				'stage',
				'testing',
				'test',
				'acceptance',
				'accept',
				'integration',
			)
		);

		if ( in_array( $env, $env_staging ) ) {
			return 2;
		}

		$env_production = apply_filters(
			'edt_env_production',
			array(
				'production',
				'prod',
				'live',
			)
		);

		if ( in_array( $env, $env_production ) ) {
			return 6;
		}

		return 9;
	}

	/**
	 * Env_type_label
	 *
	 * @param  string $type_id Environment type number.
	 * @return string          Name of the environment type.
	 */
	private function env_type_label( $type_id ) {
		switch ( $type_id ) {
			case 0:
				return __( 'No Environment Found', 'environment-debug-toolbar' );
			case 1:
				return __( 'Development', 'environment-debug-toolbar' );
			case 2:
				return __( 'Staging', 'environment-debug-toolbar' );
			case 6:
				return __( 'Production', 'environment-debug-toolbar' );
			case 9:
				return __( 'Unknown Environment', 'environment-debug-toolbar' );
			default:
				return '';
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
		if ( ! is_admin() || ! current_user_can( apply_filters( 'edt_capability_check', 'manage_options' ) ) ) {
			return;
		}

		$env       = $this->get_env();
		$type_id   = $this->env_type( $env );
		$type_name = $this->env_type_label( $type_id );

		$wp_admin_bar->add_group(
			array(
				'id' => 'edt-group',
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-node',
				'title'  => $type_name,
				'parent' => 'edt-group',
				'meta'   => array(
					'title' => __( 'Your env is set to:', 'environment-debug-toolbar' ) . ' ' . $this->get_env(),
					'class' => 'env-type-' . $type_id,
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

		if ( WP_DEBUG ) {
			$wp_admin_bar->add_node(
				array(
					'id'     => 'edt-wp-debug-log',
					'title'  => $this->html_label_value( 'WP_DEBUG_LOG', ( WP_DEBUG_LOG ? 'true' : 'false' ) ),
					'parent' => 'edt-node',
					'meta'   => array(
						'title' => WP_DEBUG_LOG,
					),
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

		$wp_admin_bar->add_node(
			array(
				'id'     => 'edt-php',
				'title'  => $this->html_label_value( 'PHP', phpversion() ),
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


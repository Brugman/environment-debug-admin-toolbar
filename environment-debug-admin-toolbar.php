<?php

/**
 * Plugin Name:       Environment & Debug Admin Toolbar
 * Description:       Display your environment and debug info in the toolbar.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Medium Rare
 * Author URI:        https://mediumrare.dev/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       environment-debug-toolbar
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'EDT_FILE', __FILE__ );
define( 'EDT_BASENAME', plugin_basename( EDT_FILE ) );

define( 'EDT_VERSION', '1.0.0' );

if ( !class_exists( 'EDT' ) )
{
    class EDT
    {
        public function __construct()
        {
        }

        //> Unsorted Helpers.

        //> Misc Helpers.

        private function d( $var )
        {
            echo "<pre style=\"max-height: 800px; z-index: 9999; position: relative; overflow-y: scroll; white-space: pre-wrap; word-wrap: break-word; padding: 10px 15px; border: 1px solid #fff; background-color: #161616; text-align: left; line-height: 1.5; font-family: Courier; font-size: 16px; color: #fff; \">";
            print_r( $var );
            echo "</pre>";
        }

        private function dd( $var )
        {
            $this->d( $var );
            exit;
        }

        //> Toolbar Helpers.

        private function get_env()
        {
            if ( function_exists( 'getenv' ) )
            {
                if ( getenv('WP_ENVIRONMENT_TYPE') !== false )
                    return getenv('WP_ENVIRONMENT_TYPE');
                if ( getenv('WP_ENV') !== false )
                    return getenv('WP_ENVIRONMENT_TYPE');
            }

            if ( defined('WP_ENVIRONMENT_TYPE') )
                return WP_ENVIRONMENT_TYPE;
            if ( defined('WP_ENV') )
                return WP_ENV;

            return false;
        }

        private function env_type( $env )
        {
            if ( !$env )
                return 0;

            switch ( strtolower( $env ) )
            {
                case 'local':
                case 'dev':
                case 'develop':
                case 'development':
                    return 1;
                    break;
                case 'stage':
                case 'staging':
                case 'test':
                case 'testing':
                case 'accept':
                case 'acceptance':
                case 'integration':
                    return 2;
                    break;
                case 'prod':
                case 'production':
                case 'live':
                    return 3;
                    break;
                default:
                    return 9;
                    break;
            }
        }

        private function html_label_value( $label, $value )
        {
            $html = '';
            $html .= '<span class="ei-label">'.$label.'</span>';
            $html .= '<span class="ei-value">'.$value.'</span>';

            return $html;
        }

        //> Hooks.

        public function register_backend_styles()
        {
            // register
            wp_register_style(
                'edt-backend-css', // name
                plugin_dir_url( __FILE__ ).'assets/edt.min.css', // url
                [], // deps
                EDT_VERSION, // ver
                'all' // media
            );
            // enqueue
            wp_enqueue_style( 'edt-backend-css' );
        }

        public function register_translations()
        {
            load_plugin_textdomain( 'environment-debug-toolbar', false, dirname( EDT_BASENAME ).'/languages' );
        }

        //> Register Hooks.

        public function register_toolbar( $wp_admin_bar )
        {
            $env  = $this->get_env();
            $type = $this->env_type( $env );

            $node_title = match ( $type )
            {
                0 => __( 'No Environment Found', 'environment-debug-toolbar' ),
                1 => __( 'Development', 'environment-debug-toolbar' ),
                2 => __( 'Staging', 'environment-debug-toolbar' ),
                3 => __( 'Production', 'environment-debug-toolbar' ),
                9 => __( 'Unknown Environment', 'environment-debug-toolbar' ),
                default => '',
            };

            $wp_admin_bar->add_group([
                'id' => 'edt-group',
            ]);

            $wp_admin_bar->add_node([
                'id'     => 'edt-node',
                'title'  => $node_title,
                'parent' => 'edt-group',
                'meta'   => [
                    'class' => 'env-type-'.$type,
                ],
            ]);

            $wp_admin_bar->add_node([
                'id'     => 'edt-wp-debug',
                'title'  => $this->html_label_value( 'WP_DEBUG', ( WP_DEBUG ? 'true' : 'false' ) ),
                'parent' => 'edt-node',
            ]);

            if ( !WP_DEBUG )
                return;

            $wp_admin_bar->add_node([
                'id'     => 'edt-wp-debug-log',
                'title'  => $this->html_label_value( 'WP_DEBUG_LOG', ( WP_DEBUG_LOG ? 'true' : 'false' ) ),
                'parent' => 'edt-node',
            ]);

            $wp_admin_bar->add_node([
                'id'     => 'edt-wp-debug-display',
                'title'  => $this->html_label_value( 'WP_DEBUG_DISPLAY', ( WP_DEBUG_DISPLAY ? 'true' : 'false' ) ),
                'parent' => 'edt-node',
            ]);

            $wp_admin_bar->add_node([
                'id'     => 'edt-script-display',
                'title'  => $this->html_label_value( 'SCRIPT_DEBUG', ( SCRIPT_DEBUG ? 'true' : 'false' ) ),
                'parent' => 'edt-node',
            ]);

            $wp_admin_bar->add_node([
                'id'     => 'edt-savequeries',
                'title'  => $this->html_label_value( 'SAVEQUERIES', ( defined('SAVEQUERIES') && SAVEQUERIES ? 'true' : 'false' ) ),
                'parent' => 'edt-node',
            ]);
        }

        public function register_hooks()
        {
            // register backend styles
            add_action( 'admin_enqueue_scripts', [ $this, 'register_backend_styles' ] );
            // register tranlations
            add_action( 'init', [ $this, 'register_translations' ] );
            // register toolbar
            add_action( 'admin_bar_menu', [ $this, 'register_toolbar' ], 300, 1 );
        }
    }

    $edt = new EDT();
    $edt->register_hooks();
}


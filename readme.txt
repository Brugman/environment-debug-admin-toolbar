=== Environment Debug Admin Toolbar ===
Contributors: mediumraredev, brugman
Tags: environment, env, debug, staging, production
Requires at least: 5.5
Tested up to: 6.2
Stable tag: 1.1.0
License: GPLv3

Display your environment and debug info in the toolbar.

== Description ==

This plugin will tell you what environment type you are on, and what the `WP_DEBUG` settings are.

If you have only one version of your site this plugin may not be for you.

Make sure every version of your site has its ENV defined in the `wp-config.php`. We support both the new official `WP_ENVIRONMENT_TYPE` constant, and the community classic `WP_ENV`.

`define( 'WP_ENVIRONMENT_TYPE', 'production' );`

== Frequently Asked Questions ==

= What are environment types? =

Instead of displaying the environment you've set, we show types. A type is a group of environments that roughly have the same purpose.

Like `local`, `dev`, 'develop' and `development`.

= Can you support another environment? =

If you've found a common environment that we do not yet recognize as one of the three types, please let us know and we'll gladly add it.

If you have a rare, custom, or localized environment name, we won't be adding those. However, you can add support for them yourself, with these snippets:

`add_filter( 'edt_env_local', function ( $environments ) {
    $environments[] = 'my_dev_env';
    return $environments;
});`

`add_filter( 'edt_env_staging', function ( $environments ) {
    $environments[] = 'strange_staging';
    return $environments;
});`

`add_filter( 'edt_env_production', function ( $environments ) {
    $environments[] = 'precious_production';
    return $environments;
});`

Please make sure they are completely lowercase.

= Can you support more types? =

Yes, if you can convince us. Please create a GitHub issue, so we can discuss your use-case.

= What users see the toolbar? =

By default, only Administrators see the bar. You can change who sees the bar with the following snippet. This example enables the bar for **Editors** as well:

`add_filter( 'edt_capability_check', function ( $capability ) {
    return 'edit_posts';
});`

= Can I set my own colors? =

`add_action( 'admin_head', function () {
    echo '<style>
    /* Development */
    #wp-admin-bar-edt-group .env-type-1 { background-color: rgba(255,255,255,.1); }
    /* Staging */
    #wp-admin-bar-edt-group .env-type-2 { background-color: #59B122; }
    /* Production */
    #wp-admin-bar-edt-group .env-type-6 { background-color: #2271B1; }
    /* Unknown Environment */
    #wp-admin-bar-edt-group .env-type-9 { background-color: #B12229; }
    /* No Environment Found */
    #wp-admin-bar-edt-group .env-type-0 { background-color: #B12229; }
    </style>';
});`

= Can I disable all styles? =

Sure. You can disable our CSS with this snippet:

`add_action( 'admin_enqueue_scripts', function () {
    wp_dequeue_style( 'edt-backend-css' );
});`

== Changelog ==

= 1.1.0 =
* Updated bar colors.
* Added PHP version.
* Added actual environment as title to the env type.
* Added actual log file as title to WP_DEBUG_LOG.
* Added filters to set environments to types.
* Added a filter for who sees the bar.
* Made plugin compatible with WP 5.5.
* Made plugin compatible with PHP 7.4.

= 1.0.0 =
* Initial release.

== Contribute ==

If you want to contribute, development takes place on [GitHub](https://github.com/Brugman/environment-debug-admin-toolbar).


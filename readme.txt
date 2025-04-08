=== Environment & Debug Bar ===
Contributors: mediumraredev, brugman
Tags: environment, env, debug, staging, production
Requires at least: 5.5
Tested up to: 6.8
Stable tag: 1.3.3
License: GPLv3

Display your environment and debug info in the toolbar.

== Description ==

This plugin will tell you what environment type you are on, and what the debug settings are.

If you have only one version of your site this plugin may not be useful to you.

Make sure every version of your site has its *ENV* defined in wp-config.php. We support both the new official WP_ENVIRONMENT_TYPE constant, and the community classic WP_ENV.

`define( 'WP_ENVIRONMENT_TYPE', 'production' );`

== Medium Rare ==

We hope you like this Medium Rare plugin. We take a lot of pride in our work, and try to make it the absolute best we can.

This plugin is fully free, and will never have a pro version. A small gift, from us, to you.

If you're interested in our other plugins, and future plugins, we invite you to visit our website at [mediumrare.dev](https://mediumrare.dev/). Our newsletter is the best way to never miss a Medium Rare plugin launch.

== Frequently Asked Questions ==

= What users see the toolbar? =

By default, only **Administrators** see the bar. You can change who sees the bar with the following snippet. This example enables the bar for **Editors** as well:

`add_filter( 'edt_capability_check', function ( $capability ) {
    return 'edit_pages';
});`

= What are environment types? =

Instead of displaying the exact environment you've set, we show types. A type is a group of environments that roughly have the same purpose. Like local, dev, develop and development.

= Can you support another environment? =

If you've found a common environment that we do not yet recognize as part of a type, please let us know and we'll gladly add it.

If you have a rare, custom, or localized environment name, we won't be adding those. However, you can add support for them yourself, with these snippets:

`add_filter( 'edt_env_development', function ( $environments ) {
    $environments[] = 'daring_development';
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

Please make sure the environment names are lowercased.

= Can you support more types? =

Perhaps, if you can convince us. Please create a GitHub issue, so we can discuss your use-case.

= Can I show the toolbar on the frontend as well? =

You can, with the snippet below.

Keep in mind that if you have a site where the end users are logged in, and see the toolbar on the frontend, you probably don't want to bother them by showing the environment info.

`add_filter( 'edt_show_on_frontend', '__return_true' );`

= Can I set my own colors? =

Yeah. Like with all CSS, you can override it:

`#wp-admin-bar-edt-group .env-type-1 { background-color: #f09; }`

= Can I disable all styles? =

Sure. You can disable our CSS with this snippet:

`add_action( 'admin_enqueue_scripts', function () {
    wp_dequeue_style( 'edt-backend-css' );
});`

== Changelog ==

= 1.3.3 =
* Checked compatibility with WP 6.6.

= 1.3.2 =
* Fixed wrong variable use for getenv('WP_ENV') users.

= 1.3.1 =
* Checked compatibility with WP 6.4.

= 1.3.0 =
* Added WP_DEVELOPMENT_MODE.
* Updated styling.

= 1.2.1 =
* Checked compatibility with WP 6.3.
* Fixed showing an incomplete title.

= 1.2.0 =
* Added bar to the frontend behind a filter.

= 1.1.1 =
* Fixed the name of a filter.

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


=== Environment Debug Admin Toolbar ===
Contributors: mediumraredev, brugman
Tags: environment, env, debug, staging, production
Requires at least: 6.2
Tested up to: 6.2
Stable tag: 1.0.0
License: GPLv3

Display your environment and debug info in the toolbar.

== Description ==

This plugin will tell you what environment you are on, and what your `WP_DEBUG` settings are.

If you only have one version of your site, no development or test environment, this plugin may not be for you.

To use this plugin, you **must** make sure every instance of your site has its ENV defined in the `wp-config.php`. We support both the new and official `WP_ENVIRONMENT_TYPE`, and the community classic `WP_ENV`. Pick your favorite.

`define( 'WP_ENVIRONMENT_TYPE', 'local' );`

Your environment options are:
* local | dev | develop | development
* staging | stage | testing | test | accept | acceptance | integration
* production | prod | live

We want to support all possible environments, so we will add more, and soon you'll be able to add any custom environment with some code samples.

If you want to see a 4th category, please [get in touch](https://github.com/Brugman/environment-debug-admin-toolbar/issues).

== Changelog ==

= 1.0.0 =
* Initial release.

== Contribute ==

If you want to contribute, development takes place on [GitHub](https://github.com/Brugman/environment-debug-admin-toolbar).


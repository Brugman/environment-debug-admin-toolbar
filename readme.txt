=== Environment Debug Admin Toolbar ===
Contributors: mediumraredev, brugman
Tags: environment, env, debug, staging, production
Requires at least: 5.5
Tested up to: 6.2
Stable tag: 1.1.0
License: GPLv3

Display your environment and debug info in the toolbar.

== Description ==

This plugin will tell you what environment you are on, and what the `WP_DEBUG` settings are.

If you have only one version of your site, no development or test environment, this plugin may not be for you.

To use this plugin, you **must** make sure every copy of your site has its ENV defined in the `wp-config.php`. We support both the new official `WP_ENVIRONMENT_TYPE` constant, and the community classic `WP_ENV`. Pick your favorite.

`define( 'WP_ENVIRONMENT_TYPE', 'local' );`

Your environment options are:
- `local` | `dev` | `develop` | `development`
- `staging` | `stage` | `testing` | `test` | `accept` | `acceptance` | `integration`
- `production` | `prod` | `live`

We want to support all possible environments, so the list may grow. Soon you'll also be able to add *any* custom environment with a code snippet.

If you want to see a another category, please [get in touch](https://github.com/Brugman/environment-debug-admin-toolbar/issues).

== Changelog ==

= 1.0.0 =
* Initial release.

== Contribute ==

If you want to contribute, development takes place on [GitHub](https://github.com/Brugman/environment-debug-admin-toolbar).


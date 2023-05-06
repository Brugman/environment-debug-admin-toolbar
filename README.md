# Environment & Debug Admin Toolbar

> A WordPress plugin that displays the environment and debug info in the toolbar.

If you only have one version of your site, no development or test environment, this plugin may not be for you.

To use this plugin, you **must** make sure every copy of your site has its ENV defined in the `wp-config.php`. We support both the new and official `WP_ENVIRONMENT_TYPE` constant, and the community classic `WP_ENV`. Pick your favorite.

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```

Your environment options are:
* local | dev | develop | development
* staging | stage | testing | test | accept | acceptance | integration
* production | prod | live

We want to support all possible environments, so the list may grow. Soon you'll also be able to add *any* custom environment with a code snippet.

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

### Development requirements

This plugin was developed with:

- PNPM

### Development installation

1. `pnpm i`

### Build CSS

Command | Minification | Sourcemaps
:--- |:--- |:---
`pnpm gulp` | :heavy_minus_sign: | :heavy_check_mark:
`pnpm gulp --env=prod` | :heavy_check_mark: | :heavy_minus_sign:

## Author

[Tim Brugman](https://github.com/Brugman)
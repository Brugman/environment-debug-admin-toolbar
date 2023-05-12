# Environment & Debug Bar

> A WordPress plugin that displays the environment and debug info in the toolbar.

If you have only one version of your site this plugin may not be useful to you.

Make sure every version of your site has its *ENV* defined in wp-config.php. We support both the new official WP_ENVIRONMENT_TYPE constant, and the community classic WP_ENV.

```php
define( 'WP_ENVIRONMENT_TYPE', 'production' );
```

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
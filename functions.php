<?php
use Timber\Timber;

include_once get_stylesheet_directory() . '/vendor/autoload.php';

add_theme_support('custom-logo');

Timber::$locations = [
    get_stylesheet_directory() . '/templates/',
];

if (is_admin()) {
	Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/DoedeJaarsmaCommunicatie/werf8',
		__FILE__,
		'werf8',
		12
	);
}

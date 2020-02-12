<?php

namespace App\Providers;

use App\Helpers\WP;
use function do_action;
use function add_action;

class AssetServiceProvider implements ServiceProvider
{
	public function __construct ()
	{
		$this->boot();
	}

	/**
	 *
	 */
	public function boot (): void {
		add_action('wp_enqueue_scripts', [__CLASS__, 'styles']);
		add_action('wp_enqueue_scripts', [__CLASS__, 'scripts']);
		$this->register();
	}

	/**
	 *
	 */
	public function register (): void {}

	public static function styles(): void
	{
		do_action('werf8_pre_enqueue_styles');
		WP::addStyle('style', WP::get_stylesheet_directory_uri(). '/dist/styles/main.css');
		WP::enqueueStyles();
		do_action('werf8_post_enqueue_styles');
	}

	public static function scripts(): void
	{
		do_action('werf8_pre_enqueue_scripts');
		WP::addScript('main', WP::get_stylesheet_directory_uri() . '/dist/sccripts/main.js');
		WP::enqueueScripts();
		do_action('werf8_post_enqueue_scripts');
	}
}

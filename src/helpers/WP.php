<?php
namespace App\Helpers;

class WP
{
	protected static $dequeue_cache = [];

	protected static $dequeue_cache_scripts = [];

	protected static $enqueue_cache = [];

	protected static $enqueue_cache_scripts = [];

	protected static $stylesheet_dir_cache = false;

	/**
	 * @return string
	 */
	public static function get_stylesheet_directory_uri() {
		if (static::$stylesheet_dir_cache) {
			return static::$stylesheet_dir_cache;
		}

		return static::$stylesheet_dir_cache = \get_stylesheet_directory_uri();
	}

	/**
	 * Adds scripts to the cache and registers them.
	 *
	 * @param string $handle
	 * @param bool   $src
	 * @param array  $deps
	 * @param bool   $ver
	 * @param bool   $in_footer
	 *
	 * @return void
	 */
	public static function addScript($handle, $src = false, $deps = [], $ver = false, $in_footer = true) {
		if (isset(static::$enqueue_cache_scripts[$handle])) {
			return;
		}

		\wp_register_script(
			$handle,
			$src,
			$deps,
			$ver,
			$in_footer
		);
		static::$enqueue_cache_scripts[$handle] = $handle;
	}

	/**
	 * Adds handles to the cache and registers them in wordpress
	 *
	 * @param string $handle
	 * @param bool   $src
	 * @param array  $deps
	 * @param bool   $ver
	 * @param string $media
	 *
	 * @return void
	 */
	public static function addStyle($handle, $src = false, $deps = [], $ver = false, $media = 'all') {
		if (isset(static::$enqueue_cache[$handle])) {
			return;
		}

		\wp_register_style($handle,$src, $deps, $ver, $media);
		static::$enqueue_cache[$handle] = $handle;
	}

	public static function enqueueScripts() {
		foreach(static::$enqueue_cache_scripts as $script) {
			wp_enqueue_script($script);
		}
	}

	/**
	 * Enqueues all the cached style handles.
	 *
	 * @return void
	 */
	public static function enqueueStyles() {
		foreach(static::$enqueue_cache as $item) {
			wp_enqueue_style($item);
		}
	}

	/**
	 * Removes scripts from wp enqueue array
	 *
	 * @param $handle
	 */
	public static function removeScript($handle) {
		if (!isset(static::$dequeue_cache_scripts[$handle])) {
			\wp_deregister_script($handle);
			static::$dequeue_cache_scripts[$handle] = $handle;
		}
	}

	/**
	 * Removes styles from wp enqueue array
	 *
	 * @param $handle
	 */
	public static function removeStyle($handle) {
		if(isset(static::$dequeue_cache[$handle])) {
			return;
		}

		\wp_deregister_style($handle);
		static::$dequeue_cache[$handle] = $handle;
	}
}

<?php


namespace App\Providers;


use App\Controllers\Shortcodes\HouseTable;

class ShortcodeServiceProvider implements ServiceProvider
{
	public function __construct () {
		$this->boot();

		$this->register();
	}

	/**
	 * @var callable[]
	 */
	protected $shortcodes = [];

	public function boot ()
	{
		$this->shortcodes = [
			'house-table' => [HouseTable::class, 'action']
		];

		$this->register();
	}

	public function register()
	{
		foreach (\apply_filters('werf8/shortcodes/register', $this->shortcodes) as $shortKey => $shortcode) {
			\add_shortcode($shortKey, $shortcode);
		}
	}
}

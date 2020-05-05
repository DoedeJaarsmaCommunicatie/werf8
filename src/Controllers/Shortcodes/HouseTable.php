<?php

namespace App\Controllers\Shortcodes;

class HouseTable implements Shortcode
{

	public function action($attributes = [])
	{
		$attributes = shortcode_args(
			[
				'not' => [],
				'in' => [],
				'limit' => -1
			],
			$attributes,
			'house-table'
		);


		var_dump($attributes);
	}
}

<?php

namespace App\Controllers\Shortcodes;

use App\Lot;
use Timber\Timber;
use Timber\PostQuery;
use App\Helpers\Template;

class HouseTable implements Shortcode
{
	public static function action($attributes = [])
	{
		$attributes = \shortcode_atts(
			[
				'not' => '',
				'in' => '',
				'limit' => -1
			],
			$attributes,
			'house-table'
		);

		$context = [];
		$args = [
			'post_type' => 'lot',
			'posts_per_page' => $attributes['limit'],
			'post__not_in' => explode(',', $attributes['not']),
			'orderby' => 'title',
			'order' => 'ASC'
		];


		if ($attributes['in'] !== '') {
			$args['post__in'] = explode(',', $attributes['in']);
		}

		$context['posts'] = Timber::get_posts($args, Lot::class);

		return Timber::compile(Template::partialHtmlTwigFile('shortcodes/house-table'), $context);
	}
}

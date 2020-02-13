<?php

namespace App\Providers;

use PostTypes\PostType;
use PostTypes\Taxonomy;
use Carbon_Fields\Field;
use Carbon_Fields\Container;

class PostTypeServiceProvider implements ServiceProvider
{
	public function __construct () {
		$this->boot();
		$this->register();
	}

	public function boot(): void
	{
		$lots = new PostType([
			'name'     => 'lot',
			'singular' => __( 'Lot', 'werf8' ),
			'plural'   => __( 'Lots', 'werf8' ),
			'slug'     => 'kavel',
		]);

		$lots->taxonomy('type');
		$lots->taxonomy('floor');

(		new Taxonomy([
			'name' => 'type',
			'singular' => 'Type',
			'plural' => 'Types',
			'slug' => 'types'
		]))->register();

		(new Taxonomy([
			'name' => 'floor',
			'singular' => 'Floor',
			'plural' => 'Floors',
			'slug' => 'verdieping'
		]))->register();

		$lots->register();
	}

	public function register(): void
	{
		if (!\Carbon_Fields\Carbon_Fields::is_booted()) {
			\Carbon_Fields\Carbon_Fields::boot();
		}

		Container::make('post_meta', __('Lot info', 'werf8'))
			->where('post_type', '=', 'lot')
			->add_fields([
				Field::make('text', 'price', __('Price', 'werf8'))
					->set_attribute('placeholder' , 'xxx.xxx,-'),
				Field::make('text', 'surface_area', __('Surface Area', 'werf8'))
					->set_attribute('placeholder', 'xx'),
				Field::make('select', 'status', __('Status', 'werf8'))
					->set_options([
						'soon' => 'Binnenkort in de verkoop',
						'active' => 'In de verkoop',
						'sold' => 'Verkocht'
					]),
				Field::make('rich_text', 'extra', __('Extra info', 'werf8')),
				Field::make('image', 'floor_plan', __('Floor plan', 'werf8'))
			]);
	}

}

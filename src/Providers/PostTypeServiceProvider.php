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
			'singular' => __( 'Bouwnummer', 'werf8' ),
			'plural'   => __( 'Bouwnummers', 'werf8' ),
			'slug'     => 'bouwnummer',
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
			'singular' => 'Verdieping',
			'plural' => 'Verdiepingen',
			'slug' => 'verdieping'
		]))->register();

		$lots->register();
	}

	public function register(): void
	{
		if (!\Carbon_Fields\Carbon_Fields::is_booted()) {
			\Carbon_Fields\Carbon_Fields::boot();
		}

		Container::make('post_meta', __('Woning info', 'werf8'))
			->where('post_type', '=', 'lot')
			->add_fields($this->specific_data());

		Container::make('post_meta', __('Afbeeldingen'))
			->where('post_type', '=', 'lot')
			->add_fields($this->image_fields());

		Container::make('term_meta', __('Afbeeldingen'))
			->where('term_taxonomy', '=', 'type')
			->add_fields($this->image_fields());

		Container::make('term_meta', __('Type informatie', 'werf8'))
			->where('term_taxonomy', '=', 'type')
			->add_fields($this->specific_data());
	}

	protected function specific_data(): array
	{
		return [
			Field::make('text', 'house_form', __('Woningform', 'werf8')),

			Field::make('text', 'price', __('Prijs', 'werf8'))
			     ->set_attribute('placeholder' , 'xxx.xxx,-'),
			Field::make('text', 'price_extra', __('Extra over prijs', 'werf8')),

			Field::make('text', 'surface_area', __('Oppervlakte', 'werf8'))
			     ->set_attribute('placeholder', 'xx'),
			Field::make('text', 'outside_area', __('Buitenruimte', 'werf8'))
			     ->set_attribute('placeholder', 'xx'),

			Field::make('select', 'status', __('Status', 'werf8'))
			     ->set_options([
				     'soon' => 'Binnenkort in de verkoop',
				     'active' => 'In de verkoop',
				     'sold' => 'Verkocht'
			     ]),

			Field::make('rich_text', 'extra', __('Extra info', 'werf8')),

		];
	}

	protected function image_fields(): array
	{
		return [
			Field::make('image', 'floor_plan', __('Plattegrond', 'werf8')),
			Field::make('image', 'ambiance_pic', __('Sfeerfoto')),
			Field::make('image', 'exterior_marked', __('Exterieur uitgelicht')),
			Field::make('image', 'ground_plan', __('Vloerplattegrond'))
		];
	}

}

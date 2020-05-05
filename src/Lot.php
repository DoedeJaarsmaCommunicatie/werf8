<?php

namespace App;

class Lot extends Post
{
	static $type_cache = [];

	public function get_house_form()
	{
		if (!isset(static::$type_cache[$this->id])) {
			static::$type_cache[$this->id] = $this->terms('type')[0]->term_id?? -1;
		}

		return $this->get_field_from_term_or_self('house_form', static::$type_cache[$this->id]);
	}

	public function get_price()
	{
		if (!isset(static::$type_cache[$this->id])) {
			static::$type_cache[$this->id] = $this->terms('type')[0]->term_id?? -1;
		}

		$price = $this->get_field_from_term_or_self('price', static::$type_cache[$this->id]);

		if ($price === '') {
			return 'Binnenkort bekend';
		}

		return $price;
	}

	public function get_status()
	{
		if (!isset(static::$type_cache[$this->id])) {
			static::$type_cache[$this->id] = $this->terms('type')[0]->term_id?? -1;
		}

		return $this->get_field_from_term_or_self('status',static::$type_cache[$this->id]);
	}

	public function get_area()
	{
		if (!isset(static::$type_cache[$this->id])) {
			static::$type_cache[$this->id] = $this->terms('type')[0]->term_id?? -1;
		}

		$area = $this->get_field_from_term_or_self('surface_area',static::$type_cache[$this->id]);

		$area = (float) $area;
		return (int) $area;
	}

	/**
	 * @param string $field
	 * @param int    $term
	 *
	 * @return mixed
	 */
	private function get_field_from_term_or_self($field, $term) {
		$res = $this->get_field($field);
		if ($res === '') {
			return \carbon_get_term_meta($term, $field);
		}

		return $res;
	}
}

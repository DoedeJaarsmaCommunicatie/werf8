<?php

namespace App;

class Lot extends Post
{
	static $type_cache = [];

	public function get_house_form()
	{
		if (!isset(static::$term_cache[$this->id])) {
			static::$type_cache[$this->id] = $this->terms('type')[0]->term_id?? -1;
		}

		return $this->get_field_from_term_or_self('house_form', static::$type_cache[$this->id]);
	}

	/**
	 * @param string $field
	 * @param int    $term
	 *
	 * @return mixed
	 */
	private function get_field_from_term_or_self($field, $term) {
		if ($res = $this->get_field($field)) {
			return carbon_get_term_meta($term, $field);
		}

		return $res;
	}
}

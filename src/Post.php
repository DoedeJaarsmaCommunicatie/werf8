<?php
namespace App;

class Post extends \Timber\Post
{
	/**
	 * Returns a carbon-field value
	 *
	 * @param string $field_name
	 *
	 * @return array|mixed|\Timber\mix|\WP_Post
	 */
	public function get_field($field_name)
	{
		$value = carbon_get_post_meta($this->id, $field_name);
		$value = $this->convert($value);
		return $value;
	}
}

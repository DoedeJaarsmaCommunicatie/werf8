<?php

defined('ABSPATH') || exit;

use Timber\{Image, Timber};
use App\Post;

/**
 * @param string $name
 * @param Post   $post
 * @param int    $term_id
 *
 * @return Image
 */
function get_image($name, $post, $term_id) {
	$post_image = $post->get_field($name);
	if (!$post_image) {
		return new Image(carbon_get_term_meta($term_id, $name));
	}

	return new Image($post_image);
}

/**
 * @param string $name
 * @param Post   $post
 * @param int    $term_id
 *
 * @return array|mixed|\Timber\mix|WP_Post
 */
function get_field($name, $post, $term_id) {
	$post_field = $post->get_field($name);
	if (!$post_field) {
		return carbon_get_term_meta($term_id, $name);
	}

	return $post_field;
}

$context = Timber::get_context();
$post = new \App\Lot();

$context ['post'] = $post;

$templates = [
	'views/single/' . $post->post_type . '/' . $post->id . '.html.twig',
	'views/single/' . $post->post_type . '/' . $post->slug . '.html.twig',
	'views/single/' . $post->id . '.html.twig',
	'views/single/' . $post->slug . '.html.twig',
	'views/single/' . $post->post_type . '.html.twig',
	'views/single.html.twig',
	'views/page.html.twig'
];

$context['floors'] = $post->terms('floor');
$context['types'] = $post->terms('type');
$context['price'] = [
	'price' => get_field('price', $post, $context['types'][0]->term_id),
	'info' => get_field('price_extra', $post, $context['types'][0]->term_id),
];

$context['areas'] = [
	'surface' => get_field('surface_area', $post, $context['types'][0]->term_id),
	'outside' => get_field('outside_area', $post, $context['types'][0]->term_id),
];

$context['status'] = get_field('status', $post, $context['types'][0]->term_id);
$context['extra_content'] = get_field('extra', $post, $context['types'][0]->term_id);

$context['images'] = [
	'floor_plan' => get_image('floor_plan', $post, $context['types'][0]->term_id),
	'ambiance' => get_image('ambiance_pic', $post, $context['types'][0]->term_id),
	'exterior' => get_image('exterior_marked', $post, $context['types'][0]->term_id),
	'ground_plan' => get_image('ground_plan', $post, $context['types'][0]->term_id)
];

if (post_password_required($context['post']->id)) {
	array_unshift($templates, 'views/single/password.html.twig');
}

Timber::render($templates, $context);

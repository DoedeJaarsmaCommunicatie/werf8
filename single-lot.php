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
	$term_image = carbon_get_term_meta($term_id, $name);
	if (!$term_image) {
		return new Image($post->get_field($name));
	}

	return new Image($term_image);
}

$context = Timber::get_context();
$post = new Post();

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
	'price' => $post->get_field('price'),
	'info' => $post->get_field('price_extra'),
];

$context['areas'] = [
	'surface' => $post->get_field('surface_area'),
	'outside' => $post->get_field('outside_area'),
];

$context['status'] = $post->get_field('status');
$context['extra_content'] = $post->get_field('extra');

$context['images'] = [
	'floor_plan' => get_image('floor_plan', $post, $context['types'][0]->term_id),
	'ambiance' => get_image('ambiance', $post, $context['types'][0]->term_id),
	'exterior' => get_image('exterior', $post, $context['types'][0]->term_id)
];

Timber::render($templates, $context);

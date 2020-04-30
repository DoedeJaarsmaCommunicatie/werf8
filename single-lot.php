<?php

defined('ABSPATH') || exit;

use Timber\{Image, Timber};
use App\Post;

$context = Timber::get_context();
$post = new Post();

$context ['post'] = $post;

$templates = [
	'views/single/' . $context[ 'post' ]->post_type . '/' . $context[ 'post' ]->id . '.twig',
	'views/single/' . $context[ 'post' ]->post_type . '/' . $context[ 'post' ]->slug . '.twig',
	'views/single/' . $context[ 'post' ]->id . '.twig',
	'views/single/' . $context[ 'post' ]->slug . '.twig',
	'views/single/' . $context[ 'post' ]->post_type . '.twig',
	'views/single.twig',
	'views/index.twig'
];

$context['floors'] = $context['post']->terms('floor');
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
	'floor_plan' => new Image($post->get_field('floor_plan')),
	'ambiance' => new Image($post->get_field('ambiance_pic')),
	'exterior' => new Image($post->get_field('exterior_marked'))
];

Timber::render($templates, $context);

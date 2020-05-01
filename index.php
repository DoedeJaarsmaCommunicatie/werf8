<?php

use Timber\Post;
use Timber\Timber;

$context = Timber::get_context();

$context['post'] = new Post();

if (post_password_required($context['post']->id)) {
	array_unshift($templates, 'views/single/password.html.twig');
}

return Timber::render(
    [
        'views/page.html.twig',
    ],
    $context
);

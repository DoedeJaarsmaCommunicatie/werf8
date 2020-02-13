<?php

use Timber\Post;
use Timber\Timber;

$context = Timber::get_context();

$context['post'] = new Post();

return Timber::render(
    [
        'views/page.html.twig',
    ],
    $context
);

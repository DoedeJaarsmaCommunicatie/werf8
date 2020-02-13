<?php
namespace App;

use App\Providers\MenuServiceProvider;
use App\Providers\AssetServiceProvider;
use App\Providers\PostTypeServiceProvider;

return [
	'providers'     => [
	    MenuServiceProvider::class,
		AssetServiceProvider::class,
		PostTypeServiceProvider::class
    ]
];

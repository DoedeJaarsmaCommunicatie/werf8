<?php
namespace App;

use App\Providers\MenuServiceProvider;
use App\Providers\AssetServiceProvider;
use App\Providers\PostTypeServiceProvider;
use App\Providers\ShortcodeServiceProvider;

return [
	'providers'     => [
	    MenuServiceProvider::class,
		AssetServiceProvider::class,
		PostTypeServiceProvider::class,
		ShortcodeServiceProvider::class
    ]
];

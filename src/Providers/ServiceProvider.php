<?php

namespace App\Providers;

interface ServiceProvider {
	public function boot();

	public function register();
}

<?php

namespace faker\faker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen('eloquent.created: *', function (string $event, array $payload) {
            $model = $payload[0];
            $model->delete();
        });
    }

    public function register()
    {
        //
    }
}

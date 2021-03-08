<?php

namespace Slymetrix\LaravelMandrill;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton('mandrill.client', function ($app) {
            return new Client([
                'base_uri' => 'https://mandrillapp.com/api/1.0/',
                'allow_redirects' => true,
            ]);
        });

        $this->app->bind(Mandrill::class, function ($app) {
            // return new Mandrill($app->make('mandrill.client'), $app->make('config')->get('settings.mandrill_api_key'));
        });

        $this->app->alias(Mandrill::class, 'mandrill');
    }
}

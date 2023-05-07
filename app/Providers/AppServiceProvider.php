<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!App::environment(['production'])) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Custom Validator
         */
        Validator::extend('checkspecialcharacter', function ($attribute, $value, $parameters, $validator) {
            $check = true;
            // $sp='"%*;<>?^`{|}~\\\'#=&';
            $sp = config('constant.special_character');

            if (preg_match("/[" . $sp . "]/", $value)) {
                $check = false;
            }

            return $check;
        });

        Validator::extend('alphabert', function ($attribute, $value, $parameters, $validator) {
            if (!ctype_alpha($value)) {
                return false;
            }

            return true;
        });
    }
}

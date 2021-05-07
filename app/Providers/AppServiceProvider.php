<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('poly_exists', function ($attribute, $value, $parameters, $validator) {
            if (! $type = array_get($validator->getData(), $parameters[0], false)) {
                return false;
            }
    
            if (Relation::getMorphedModel($type)) {
                $type = Relation::getMorphedModel($type);
            }
    
            if (! class_exists($type)) {
                return false;
            }
    
            return ! empty(resolve($type)->find($value));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

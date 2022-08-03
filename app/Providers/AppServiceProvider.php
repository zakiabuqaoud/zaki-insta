<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share("name", config('app.name'));
        Validator::extend(
            'content',
            function ($attribute, $value, $parameter, $validator) {
                foreach ($parameter as $word) {
                    if (strpos($value, $word) !== false) {
                        $validator->errors()->add($attribute, " not content on " . implode(',', $parameter));
                        return false;
                    }
                }
                return true;
            },
            "some words are not allowed "
        );
    }
}

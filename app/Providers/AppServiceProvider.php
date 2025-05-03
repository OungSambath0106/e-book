<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\BusinessSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // global variable
        view()->composer('*', function ($view) {
            $business_setting = new BusinessSetting;
            $languages = $business_setting->where('type', 'language')->first()->value;

            $langs = array_reduce(json_decode($languages, true), function ($result, $language) {
                if ($language['status'] == 1) {
                    $result[$language['name']] = $language['code'];
                }
                return $result;

            }, []);

            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', $langs);

        });
        // view()->composer('*',function($view) {
        //     $view->with('user', Auth::user());
        //     $view->with('social', Social::all());
        //     // if you need to access in controller and views:
        //     Config::set('something', $something);
        // });
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        if (!request()->hasCookie('dark-version')) {
            config(['app.dark-version' => config('app.theme')]);
        } else {
            if (request()->cookie('dark-version') == 1) {
                config(['app.dark-version' => 1]);
            } else {
                config(['app.dark-version' => 0]);
            }
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        Passport::tokensCan([
            'customer' => 'Customer access scope',
        ]);

        Passport::enableImplicitGrant();
    }
}

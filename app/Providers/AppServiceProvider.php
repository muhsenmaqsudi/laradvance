<?php

namespace App\Providers;

use App\Billing\BankPaymentGateway;
use App\Billing\CreditPaymentGateway;
use App\Billing\PaymentGatewayContract;
use App\Channel;
use App\Http\View\Composers\ChannelsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // every time PaymentGateway class gets called the first instance that was invoked will be called
        // but every time $this->app->bind() gets called a fresh instance will initialize
        $this->app->singleton(PaymentGatewayContract::class, function ($app) {
            if (request()->has('credit')) {
                return new CreditPaymentGateway('usd');
            }
            return new BankPaymentGateway('usd');
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//         option 1 - Every single view
//        View::share('channels', Channel::orderBy('name')->get());

        // option 2 - Granular views with wildcards
//        View::composer(['post.*', 'channel.index'], function ($view) {
//            $view->with('channels', Channel::orderBy('name')->get());
//        });

        // option 3 - dedicated class
        View::composer('partials.channels.*', ChannelsComposer::class);

    }
}

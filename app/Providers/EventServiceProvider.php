<?php

namespace App\Providers;

use App\Events\ApiEmailVerifyEvent;
use App\Events\ApiUserEventRegistrationEvent;
use App\Events\ApiUserLoginEvent;
use App\Events\ApiUserLogoutEvent;
use App\Events\ApiUserOtpEvent;
use App\Events\ApiUserRegistrationEvent;
use App\Events\OrderConfirmEvent;
use App\Listeners\ApiEmailVerifyListener;
use App\Listeners\ApiUserEventRegistrationListener;
use App\Listeners\ApiUserLoginListener;
use App\Listeners\ApiUserLogoutListener;
use App\Listeners\ApiUserOtpListener;
use App\Listeners\ApiUserRegistrationEventListener;
use App\Listeners\OrderConfirmListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ApiUserLoginEvent::class => [
            ApiUserLoginListener::class,
        ],
        ApiUserLogoutEvent::class => [
            ApiUserLogoutListener::class,
        ],
        ApiUserOtpEvent::class => [
            ApiUserOtpListener::class,
        ],
        ApiUserEventRegistrationEvent::class => [
            ApiUserEventRegistrationListener::class
        ],
        ApiEmailVerifyEvent::class => [
            ApiEmailVerifyListener::class
        ],
        ApiUserRegistrationEvent::class => [
            ApiUserRegistrationEventListener::class
        ],
        OrderConfirmEvent::class => [
            OrderConfirmListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

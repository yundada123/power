<?php

namespace App\Providers;

use App\Events\PhoneEvent;
use App\Events\PowerEvent;
use App\Events\SendHttpMessageEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\PowerListeners;
use App\Listeners\PhoneListeners;
use App\Listeners\SendHttpMessageListeners;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        PowerEvent::class=>[
            PowerListeners::class,//电费充值
        ],
        PhoneEvent::class=>[
            PhoneListeners::class,//话费充值
        ],
        SendHttpMessageEvent::class=>[
            SendHttpMessageListeners::class,//发送回调消息
        ],
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

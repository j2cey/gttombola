<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Events\WorkflowStepCompleted;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendNextWorkflowStepEmail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Illuminate\Auth\Events\Failed as LoginFailedEvent;
use App\Listeners\LoginFailed as LoginFailedListner;
use Illuminate\Auth\Events\Login as LoginSuccessfulEvent;
use App\Listeners\LoginSuccessful as LoginSuccessfulListner;
use Illuminate\Auth\Events\Logout as LogoutSuccessfulEvent;
use App\Listeners\LogoutSuccessful as LogoutSuccessfulListner;

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
        LoginFailedEvent::class => [
            LoginFailedListner::class,
        ],
        LoginSuccessfulEvent::class => [
            LoginSuccessfulListner::class,
        ],
        LogoutSuccessfulEvent::class => [
            LogoutSuccessfulListner::class
        ],
        WorkflowStepCompleted::class => [
            SendNextWorkflowStepEmail::class
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

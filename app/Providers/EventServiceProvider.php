<?php

namespace App\Providers;

use App\Listeners\Auth\LogAuthenticated;
use App\Listeners\Auth\LogAuthenticationAttempt;
use App\Listeners\Auth\LogCurrentDeviceLogout;
use App\Listeners\Auth\LogFailedLogin;
use App\Listeners\Auth\LogLockout;
use App\Listeners\Auth\LogOtherDeviceLogout;
use App\Listeners\Auth\LogPasswordReset;
use App\Listeners\Auth\LogRegisteredUser;
use App\Listeners\Auth\LogSuccessfulLogin;
use App\Listeners\Auth\LogSuccessfulLogout;
use App\Listeners\Auth\LogValidated;
use App\Listeners\Auth\LogVerified;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Validated;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            LogRegisteredUser::class,
        ],

        Attempting::class => [
            LogAuthenticationAttempt::class,
        ],

        Authenticated::class => [
            LogAuthenticated::class,
        ],

        Login::class => [
            LogSuccessfulLogin::class,
        ],

        Failed::class => [
            LogFailedLogin::class,
        ],

        Validated::class => [
            LogValidated::class,
        ],

        Verified::class => [
            LogVerified::class,
        ],

        Logout::class => [
            LogSuccessfulLogout::class,
        ],

        CurrentDeviceLogout::class => [
            LogCurrentDeviceLogout::class,
        ],

        OtherDeviceLogout::class => [
            LogOtherDeviceLogout::class,
        ],

        Lockout::class => [
            LogLockout::class,
        ],

        PasswordReset::class => [
            LogPasswordReset::class,
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

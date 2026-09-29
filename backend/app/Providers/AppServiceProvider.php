<?php
namespace App\Providers;

use App\Domain\Auth\SmsChannel;
use App\Domain\Auth\LogSmsChannel;
use App\Domain\Notification\{PushDispatcher, NullPushDispatcher};
use App\Domain\Provider\MembershipContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(SmsChannel::class, LogSmsChannel::class);
        $this->app->bind(PushDispatcher::class, NullPushDispatcher::class);
        $this->app->singleton(MembershipContext::class);
    }
    public function boot(): void {}
}

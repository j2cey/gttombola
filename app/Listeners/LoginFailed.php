<?php

namespace App\Listeners;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginFailed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Failed $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $user = $event->user;

        $data = [
            'user_type' => $user ? (new \ReflectionClass($user))->getName() : null,
            'auditable_id' => $user ? $user->id : null,
            'auditable_type' => "Login Failed",
            'event'      => "Login Failed",
            'url'        => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id'          => $user ? $user->id : null,
        ];

        //create audit trail data
        $details = Audit::create($data);
    }
}

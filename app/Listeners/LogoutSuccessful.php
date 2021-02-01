<?php

namespace App\Listeners;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogoutSuccessful
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
     * @param Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        /*$user->last_logout_at = date('Y-m-d H:i:s');
        $user->last_logout_ip = $this->request->ip();
        $user->save();*/

        $data = [
            'user_type' => (new \ReflectionClass($user))->getName(),//class_basename($user),
            'auditable_id' => $user ? $user->id : null,
            'auditable_type' => "Logged Out",
            'event'      => "Logged Out",
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

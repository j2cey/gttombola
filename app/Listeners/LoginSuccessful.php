<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginSuccessful
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
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        /*$user->last_login_at = date('Y-m-d H:i:s');
        $user->last_login_ip = $this->request->ip();
        $user->save();*/

        $user_type = $user ? (new \ReflectionClass($user))->getName() : null;

        if ($user_type == User::class) {

            $data = [
                'user_type' => $user_type,//(new \ReflectionClass(auth()->user()))->getName(),
                'auditable_id' => $user ? $user->id : null,//auth()->user()->id,
                'auditable_type' => "Logged In" . ($user ? "-" . $user->login_type : ""),
                'event' => "Logged In",
                'url' => request()->fullUrl(),
                'ip_address' => request()->getClientIp(),
                'user_agent' => request()->userAgent(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user ? $user->id : null,//auth()->user()->id,
            ];

            //create audit trail data
            $details = Audit::create($data);
        }
    }
}

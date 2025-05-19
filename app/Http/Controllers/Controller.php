<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getProcessedUser()
    {
        $user = Auth::user();

        if (!$user) {
            return (object) [
                'username' => 'Guest',
                'avatar' => asset('img/avatar_default.jpg')
            ];
        }

        $user->avatar = $user->avatar
            ? asset($user->avatar)
            : asset('img/avatar_default.jpg');

        return $user;
    }
}

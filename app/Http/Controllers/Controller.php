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
            'avatar_path' => asset('img/avatar_default.jpg')
        ];
    }

    $user->avatar_path = ($user->avatar === 'avatar_default.jpg' || $user->avatar === null)
        ? asset('img/avatar_default.jpg')
        : asset('storage/avatars/' . $user->avatar);

    return $user;
}

}

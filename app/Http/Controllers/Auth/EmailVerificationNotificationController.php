<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            $this->response()->error(
                ['email' => __('auth.already_verified')]
            );
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->response()->success(
            ['status' => 'verification-link-sent']
        );
    }
}

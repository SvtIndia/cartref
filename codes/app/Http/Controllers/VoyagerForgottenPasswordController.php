<?php

namespace  App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use TCG\Voyager\Http\Controllers\Controller as VoyagerControllerImport;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class VoyagerForgottenPasswordController extends VoyagerControllerImport
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.request');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
//        dd($response, Password::RESET_LINK_SENT);

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

//    public function sendResetLink(array $credentials, Closure $callback = null)
//    {
//        // First we will check to see if we found a user at the given credentials and
//        // if we did not we will redirect back to this current URI with a piece of
//        // "flash" data in the session to indicate to the developers the errors.
//        $user = $this->getUser($credentials);
//
//        if (is_null($user)) {
//            return static::INVALID_USER;
//        }
//
//        if ($this->tokens->recentlyCreatedToken($user)) {
//            return static::RESET_THROTTLED;
//        }
//
//        $token = $this->tokens->create($user);
//
//        if ($callback) {
//            $callback($user, $token);
//        } else {
//            // Once we have the reset token, we are ready to send the message out to this
//            // user with a link to reset their password. We will then redirect back to
//            // the current URI having nothing set in the session to indicate errors.
//            $user->sendPasswordResetNotification($token);
//        }
//
//        return static::RESET_LINK_SENT;
//    }
}
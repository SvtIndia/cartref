<?php

namespace  App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use TCG\Voyager\Http\Controllers\Controller as VoyagerControllerImport;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class VoyagerResetPasswordController extends VoyagerControllerImport
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/seller';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}
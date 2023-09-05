<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Craftsys\Msg91\Facade\Msg91;
use App\Notifications\WelcomeEmail;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Config;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    use VerifiesEmails, RedirectsUsers;


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {

            event(new Verified($request->user()));
            
            // send welcome sms & email
            try {

                if(Config::get('icrm.sms.msg91.feature') == 1)
                {
                    
                    if(!empty(auth()->user()->mobile))
                    {
                        if(!empty(Config::get('icrm.sms.msg91.welcome_flow_id')))
                        {
                            $mobile = '91'.auth()->user()->mobile;
                            $response = Msg91::sms()->to($mobile)->flow(Config::get('icrm.sms.msg91.welcome_flow_id'))->send();
                        }
                        
                    }
                }
                

                Notification::route('mail', auth()->user()->email)->notify(new WelcomeEmail(auth()->user()));

                // echo 'done';
            } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
                // issue with the request e.g. token not provided
                // echo 'issue with the request e.g. token not provided';
            } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
                // error thrown by msg91 apis or by http client
                // echo 'error thrown by msg91 apis or by http client';
            } catch (\Exception $e) {
                // something else went wrong
                // plese report if this happens :)
                // echo 'something else went wrong';
            }

        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('verification.notice', [
                            'pageTitle' => __('Account Verification')
                        ]);
    }

    
}

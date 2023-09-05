<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Validation\Rules;
use App\Notifications\WelcomeEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {        
        Session::put('register', true);
        Session::put('login', false);
        if(Config::get('icrm.auth.fields.companyinfo') == true)
        {
            // if company info is required
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'mobile' => ['required', 'numeric', 'digits:10'],
                'company_name' => ['required'],
                'gst_number' => ['required', 'regex:"^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            
            Session::put('register', false);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'company_name' => $request->company_name,
                'gst_number' => $request->gst_number,
                'password' => Hash::make($request->password),
                'status' => '1',
            ]);

            
        }else{
            // if company info is not required
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'mobile' => ['required', 'numeric', 'digits:10'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            
            Session::put('register', false);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'status' => '1',
            ]);
        }


        event(new Registered($user));

        Session::put('register', false);
        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function redirect($client)
    {
        return Socialite::driver($client)->redirect();
    }

    public function googlecallback()
    {
        $client = Socialite::driver('google')->user();
        
        $user = User::where('email', $client->email)->first();

        if (!empty($user)) {
            $user->update([
                'client_token' => $client->token,
                'client_refresh_token' => $client->refreshToken,
                'client_name' => 'Google',
            ]);
        } else {
            $user = User::create([
                'name' => $client->name,
                'email' => $client->email,
                'client_id' => $client->id,
                'client_token' => $client->token,
                'client_refresh_token' => $client->refreshToken,
                'client_name' => 'Google',
            ]);


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
                

                $user->markEmailAsVerified();
        
                Auth::login($user);

                Notification::route('mail', $user->email)->notify(new WelcomeEmail(auth()->user()));


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


        $user->markEmailAsVerified();
        
        Auth::login($user);



        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function facebookcallback()
    {
        $client = Socialite::driver('facebook')->user();

        $user = User::where('email', $client->email)->first();
     
        if (!empty($user)) {
            $user->update([
                'client_token' => $client->token,
                'client_refresh_token' => $client->refreshToken,
                'client_name' => 'Facebook',
            ]);
        } else {
            $user = User::create([
                'name' => $client->name,
                'email' => $client->email,
                'client_id' => $client->id,
                'client_token' => $client->token,
                'client_refresh_token' => $client->refreshToken,
                'client_name' => 'Facebook',
            ]);


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
                
                $user->markEmailAsVerified();
        
                Auth::login($user);

                Notification::route('mail', $user->email)->notify(new WelcomeEmail(auth()->user()));

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


        
        $user->markEmailAsVerified();
        


        Auth::login($user);

        

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}

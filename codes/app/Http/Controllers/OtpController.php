<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationOtp;
use Carbon\Carbon;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OtpController extends Controller
{
    public function otp_login()
    {
        return view('auth.otp-login');
    }

    public function otp_login_store(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|exists:users,mobile'
        ]);

        $number = $request->mobile_no;
        $randomNumber = random_int(100000, 999999);

        $response = Http::get('http://a2pservices.in/api/mt/SendSMS', [
            'user' => env('MESSAGE_API_USERNAME'),
            'password' => env('MESSAGE_API_PASSWORD'),
            'senderid' => 'CRTRFS',
            'channel' => 'Trans',
            'DCS' => 0,
            'flashsms' => 0,
            'number' => '91' . $number,
            'text' => $randomNumber . ' is your OTP to login to Cartrefs. Do NOT share with anyone. CARTREFS never calls to ask for OTP. The OTP expires in 10 mins. - Team CARTREFS',
            'route' => 3,
            'PEId' => 1001289954077984929,
        ]);
        // $jsonData = $response->json();

        $user = User::where('mobile', $number)->firstOrFail();
        $otp = VerificationOtp::create([
            'user_id' => $user->id,
            'otp' => $randomNumber,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        return view('auth.otp-verification')->with(['otp_id' => $otp->id]);
    }

    public function otp_verification(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'otp_id' => 'required'
        ]);

        $otp_id = $request->otp_id;

        // turn $request->otp;
        $verificationCode = VerificationOtp::where([ 'id' => $otp_id, 'otp' => $request->otp])->first();

        if (!isset($verificationCode)) {
            return view('auth.otp-verification',compact('otp_id'))->with(['error' => 'Your OTP is not correct']);
        }
        elseif ($verificationCode) {
            // Check if the OTP has expired (10 minutes or more)
            $now = Carbon::now();
            $minutesDifference = $now->diffInSeconds($verificationCode->expire_at, 0);

            if ($minutesDifference <= 0) {
                return redirect()->route('otp.login')->with(['error' => 'Your OTP has been expired']);
            }

            else
            {
                Session::put('login', true);
                Session::put('register', false);

                $user = User::find($verificationCode->user_id);
                Auth::login($user);

                return redirect('/');
            }
        }
    }

}

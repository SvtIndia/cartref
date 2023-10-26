<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OtpController extends Controller
{
    public function otp_login()
    {
        return view('auth.otp-login');
    }

    // public function otp_verification()
    // {
    //     return view('auth.otp-verification');
    // }

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

        $user = User::where('mobile', $number)->first();
        $otp = VerificationOtp::create([
            'user_id' => $user->id,
            'otp' => $randomNumber,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        return view('auth.otp-verification');
    }

    public function otp_verification_store(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        
        $verificationCode = VerificationOtp::where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }
        elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
        }

        $user = User::whereId($request->user_id)->first();

        dd($verificationCode);

        $otp = $request->otp;

        dd($otp);
    }
}

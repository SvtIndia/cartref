<?php

namespace App\Http\Controllers;

use App\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MyAccountController extends Controller
{
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myaccount()
    {
        return view('myaccount.accountdetails');
    }

    public function updateprofile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'gender' => 'required'
        ]);

        $profile = User::where('email', $request->email)->first();
        
        if(!empty($profile))
        {
            $profile->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'gender' => $request->gender
            ]);
        }

        Session::flash('success', 'Your personal information has been updated!');

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changepassword()
    {
        return view('myaccount.changepassword');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageaddresses()
    {
        return view('myaccount.manageaddresses');
    }


    public function postmanageaddresses(Request $request)
    {
        $validated = $request->validate([
            'street_address_1' => 'required',
            'street_address_2' => 'required',
            'landmark' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'country' => 'required'
        ]);

        $address = New Address;
        $address->street_address_1 = $request->street_address_1;
        $address->street_address_2 = $request->street_address_2;
        $address->landmark = $request->landmark;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->pincode = $request->pincode;
        $address->country = $request->country;
        $address->user_id = auth()->user()->id;
        $address->save();

        Session::flash('success', 'Your delivery address has been updated!');

        return redirect()->route('myaccount-manage-addresses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestreturn()
    {
        return view('myaccount.requestreturn');
    }
}

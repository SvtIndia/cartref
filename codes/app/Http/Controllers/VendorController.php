<?php

namespace App\Http\Controllers;

use App\Notifications\WelcomeNewVendor;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function becomeseller()
    {
        return view('becomeseller');
    }


    public function vendorsignup(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required|digits:10',
            'email_address' => 'required',
            'registered_company_name' => 'required',
            'gst_number' => 'nullable',
            'marketplaces' => 'nullable'
        ]);

        $vendor = new Vendor;
        $vendor->brand_name = $request->brand_name;
        $vendor->contact_name = $request->contact_name;
        $vendor->contact_number = $request->contact_number;
        $vendor->email_address = $request->email_address;
        $vendor->registered_company_name = $request->registered_company_name;
        $vendor->gst_number = $request->gst_number;
        $vendor->marketplaces = $request->marketplaces;
        $vendor->save();

        Session::flash('success', 'Thank you for showing your interest in '.env('APP_NAME').'! We have received your request. Our team will get back to you soon.');

        // send email to vendor & admin
        Notification::route('mail', $request->email_address)->notify(new WelcomeNewVendor($vendor));


        return redirect()->route('becomeseller');
    }

}

<?php

namespace App\Http\Livewire\Myaccount;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Myaccount extends Component
{
    public $name;
    public $gender;
    public $email;
    public $mobile;

    public $company_name;
    public $gst_number;

    public $street_address_1;
    public $street_address_2;
    public $pincode;
    public $city;
    public $state;
    public $country;


    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'gender' => 'required',
        'mobile' => 'required|integer|digits:10',
    ];
    


    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->gender = auth()->user()->gender;
        $this->email = auth()->user()->email;
        $this->mobile = auth()->user()->mobile;
        $this->company_name = auth()->user()->company_name;
        $this->gst_number = auth()->user()->gst_number;


        $this->street_address_1 = auth()->user()->street_address_1;
        $this->street_address_2 = auth()->user()->street_address_2;
        $this->pincode = auth()->user()->pincode;
        $this->city = auth()->user()->city;
        $this->state = auth()->user()->state;
        $this->country = auth()->user()->country;
    }

    public function render()
    {
        return view('livewire.myaccount.myaccount');
    }

    public function updateAccount()
    {
        $this->validate();
        
        if(empty($this->name))
        {
            Session::flash('danger', 'Please mention your name');
            return redirect()->route('myaccount');
        }

        if(empty($this->gender))
        {
            Session::flash('danger', 'Please mention your gender');
            return redirect()->route('myaccount');
        }

        if(empty($this->email))
        {
            Session::flash('danger', 'Please mention your email');
            return redirect()->route('myaccount');
        }

        if(empty($this->mobile))
        {
            Session::flash('danger', 'Please mention your registered mobile number');
            return redirect()->route('myaccount');
        }

        User::where('id', auth()->user()->id)->update([
            'name' => $this->name,
            'gender' => $this->gender,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'company_name' => $this->company_name,
            'gst_number' => $this->gst_number,
        ]);

        Session::flash('success', 'Account details successfully updated!');
        return redirect()->route('myaccount');
    }


    public function updateAddress()
    {
        if(empty($this->street_address_1))
        {
            Session::flash('danger', 'Please mention street address 1');
            return redirect()->route('myaccount');
        }

        if(empty($this->street_address_2))
        {
            Session::flash('danger', 'Please mention street address 2');
            return redirect()->route('myaccount');
        }

        if(empty($this->pincode))
        {
            Session::flash('danger', 'Please mention pincode');
            return redirect()->route('myaccount');
        }

        if(empty($this->city))
        {
            Session::flash('danger', 'Please mention city');
            return redirect()->route('myaccount');
        }

        if(empty($this->state))
        {
            Session::flash('danger', 'Please mention state');
            return redirect()->route('myaccount');
        }

        if(empty($this->country))
        {
            Session::flash('danger', 'Please mention country');
            return redirect()->route('myaccount');
        }

        User::where('id', auth()->user()->id)->update([
            'street_address_1' => $this->street_address_1,
            'street_address_2' => $this->street_address_2,
            'pincode' => $this->pincode,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        Session::flash('success', 'Delivery address successfully updated!');
        return redirect()->route('myaccount');
    }
}

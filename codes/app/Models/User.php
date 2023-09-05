<?php

namespace App\Models;

use App\Address;
use App\Showcase;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// extends \TCG\Voyager\Models\User

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'avatar',
        'name',
        'email',
        'mobile',
        'password',
        'client_id',
        'client_token',
        'client_refresh_token',
        'client_name',
        'gender',
        'company_name',
        'gst_number',
        'brands',
        'signature',
        'cancelled_check'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function scopeVendors()
    {
        if(auth()->user()->hasRole('Vendor'))
        {
            return $this->where('status', '1')->where('id', auth()->user()->id);
        }else{
            return $this->where('status', '1')
            ->whereHas('roles', function($q){
                $q->whereIn('name', ['Admin', 'Vendor']);
            })
            ->orWhereHas('role', function($q){
                $q->whereIn('name', ['Admin', 'Vendor']);
            });
        }
    }

    public function dbshowcases()
    {
        return $this->belongsTo(Showcase::class, 'id', 'deliveryboy_id');
    }

    public function scopeDeliveryboy()
    {

        return $this->where('status', '1')
            ->whereHas('role', function($q){
                $q->whereIn('name', ['Delivery Boy']);
            })
            ->whereDoesntHave('dbshowcases', function($q){
                $q->where('status', 1);
            })
            ->where('city', auth()->user()->city);
    }


}

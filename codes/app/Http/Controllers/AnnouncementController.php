<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function fetchAnnouncements(){
        $user_id = auth()->user()->id;
        $announcements = Announcement::where('is_active', true)
            ->where(function($query) use($user_id){
                $query->orWhere('user_id', $user_id)
                    ->orWhere('for_all_vendors', true);
            })
            ->latest()->get()->append('color');

        return response()->json($announcements);
    }
}

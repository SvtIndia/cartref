<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function fetchAnnouncements(){
        $user_id = auth()->user()->id;
        $onlyPriority = request()->priority;

        $announcements = Announcement::with('users')
            ->where('is_active', true)
            ->where(function($que) use($user_id){
                $que->whereHas('users', function($query) use($user_id){
                    $query->where('id', $user_id);
                })
                ->orWhere('for_all_vendors', true);
            })
            ->when(isset($onlyPriority), function($query) use($onlyPriority){
                $query->where('priority', $onlyPriority);
            })
            ->latest()->get()->append('color');

        return response()->json($announcements);
    }
}

<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ViewExporter implements FromView
{
    public function view(): View
    {
        return view('exports.users', [
            'users' => User::take(10)->get()
        ]);
    }
}

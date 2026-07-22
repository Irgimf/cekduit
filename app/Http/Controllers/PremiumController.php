<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PremiumController extends Controller
{
    public function upgrade(): View
    {
        if (config('is_mobile')) {
            return view('mobile.premium-upgrade');
        }
        return view('premium.upgrade');
    }
}
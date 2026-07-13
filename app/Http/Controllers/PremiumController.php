<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PremiumController extends Controller
{
    public function upgrade(): View
    {
        return view('premium.upgrade');
    }
}
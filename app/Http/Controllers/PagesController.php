<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Show public landing page (homepage).
     */
    public function home(): View
    {
        return view('pages.home');
    }
}

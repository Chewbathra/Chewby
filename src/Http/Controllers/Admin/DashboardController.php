<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('chewby::dashboard');
    }
}

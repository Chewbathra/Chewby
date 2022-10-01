<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('chewby::dashboard');
    }
}

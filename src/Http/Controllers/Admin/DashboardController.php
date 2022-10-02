<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::dashboard');
    }
}

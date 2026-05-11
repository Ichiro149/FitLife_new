<?php

/**
 * Šis skata komponents sagatavo "App Layout" atkārtoti lietojamu daļu.
 */

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{

    public function render(): View
    {
        return view('layouts.app');
    }
}

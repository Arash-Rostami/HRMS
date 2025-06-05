<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;

/**
 * Class AppLayout
 * @package App\View\Components
 */
class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}

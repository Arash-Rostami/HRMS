<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Class GuestLayout
 * @package App\View\Components
 */
class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function render()
    {
        return view('layouts.guest');
    }
}

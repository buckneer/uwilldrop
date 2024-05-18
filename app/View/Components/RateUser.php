<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RateUser extends Component
{
    public mixed $ride;


    public function __construct($ride)
    {
        $this->ride = $ride;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rate-user');
    }
}

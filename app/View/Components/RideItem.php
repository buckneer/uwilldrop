<?php

namespace App\View\Components;

use App\Models\Ride;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RideItem extends Component
{

    public mixed $ride;
    /**
     * Create a new component instance.
     */
    public function __construct($ride)
    {
        $this->ride = $ride;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ride-item');
    }
}

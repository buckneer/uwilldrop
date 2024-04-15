<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JourneyItem extends Component
{
    public mixed $journey;


    /**
     * Create a new component instance.
     */
    public function __construct($journey)
    {
        $this->journey = $journey;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.journey-item');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Map extends Component
{
    public $journey;

    public function __construct($journey)
    {
        $this->journey = $journey;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $from = json_decode($this->journey->from_coordinates);
        $to = json_decode($this->journey->to_coordinates);
        $coordinates = json_decode($this->journey['route_data']);

        // Ensure the variables are correctly passed to the view
        return view('components.map', compact('from', 'to', 'coordinates'));
    }
}

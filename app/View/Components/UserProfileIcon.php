<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfileIcon extends Component
{

    public mixed $rating;
    /**
     * Create a new component instance.
     */
    public function __construct($rating)
    {
        $this->rating = round($rating, 0);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-profile-icon');
    }
}

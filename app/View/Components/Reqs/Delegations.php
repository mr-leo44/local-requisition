<?php

namespace App\View\Components\Reqs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Delegations extends Component
{
    public $delegations;
    /**
     * Create a new component instance.
     */
    public function __construct($delegations)
    {
        $this->delegations = $delegations;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reqs.delegations');
    }
}

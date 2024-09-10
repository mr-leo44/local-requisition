<?php

namespace App\View\Components\Reqs;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Ongoing extends Component
{
    public $ongoings;

    /**
     * Create a new component instance.
     */
    public function __construct($ongoings)
    {
        $this->ongoings = $ongoings;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reqs.ongoing');
    }
}

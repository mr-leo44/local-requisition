<?php

namespace App\View\Components\Demandes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Validate extends Component
{
    public $validate;
    /**
     * Create a new component instance.
     */
    public function __construct($validate)
    {
        $this->validate = $validate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reqs.validate');
    }
}

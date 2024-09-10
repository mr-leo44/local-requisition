<?php

namespace App\View\Components\Demandes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Historics extends Component
{

    public $historics;
    /**
     * Create a new component instance.
     */
    public function __construct($historics)
    {
        $this->historics = $historics;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reqs.historics');
    }
}

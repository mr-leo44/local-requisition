<?php

namespace App\View\Components\Demandes;

use Closure;
use App\Models\User;
use App\Models\Compte;
use App\Models\Demande;
use App\Models\Traitement;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class Collaborators extends Component
{
    public $collaborators;
    /**
     * Create a new component instance.
     */
    public function __construct($collaborators)
    {
        $this->collaborators = $collaborators;
    }

    /**
     * Get the view / contents that represent the component.
     */
    
    public function render(): View|Closure|string
    {
        return view('components.reqs.collaborators');
    }
}

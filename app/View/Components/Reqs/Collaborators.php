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
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Session::get('authUser'); //signifie que c'est l'utilisateur qui est connecté
        // if (Compte::where('manager', $user->id)->exists()) {
        //     $collaborators = User::whereHas('compte', function (Builder $query) use ($user) {
        //         $query->where('manager', $user->id)->where('user_id', '!=', $user->id);
        //     })->get();
        //     if ($collaborators->count() > 0) {
        //         foreach ($collaborators as $key => $collaborator) {
        //             $reqs_collabs = Demande::where('user_id', $collaborator->id)->get();
        //             $collabs_reqs_list = [];
        //             foreach ($reqs_collabs as $req) {
        //                 $last_flow = Traitement::where('demande_id', $req->id)->orderBy('id', 'DESC')->first();
        //                 if ($last_flow->status === 'rejeté') {
        //                     $req['status'] = 'Rejected';
        //                 } elseif ($last_flow->status === 'validé') {
        //                     $details = $req->demande_details()->get();
        //                     $count = 0;
        //                     foreach ($details as $key => $detail) {
        //                         if ($detail->qte_demandee === $detail->qte_livree) {
        //                             $count += 1;
        //                         }
        //                     }
        //                     if ($count === $details->count()) {
        //                         $req['status'] = 'Delivered';
        //                     } else {
        //                         $req['status'] = 'In progress';
        //                     }
        //                 } else {
        //                     $req['status'] = 'In progress';
        //                 }
        //                 $collabs_reqs_list[] = $req;
        //             }
        //             $list = collect($collabs_reqs_list);
        //         }
        //         // $collaborators_reqs = Demande::whereIn('id', $list->pluck('id'))->get();
        //     }
        // }
        // dd($list);
        return view('components.reqs.collaborators');
    }
}

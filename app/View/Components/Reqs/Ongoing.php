<?php

namespace App\View\Components\Reqs;

use Closure;
use App\Models\User;
use App\Models\Demande;
use App\Models\Livraison;
use App\Models\Traitement;
use App\Models\Approbateur;
use App\Models\DemandeDetail;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class Ongoing extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $connected_user = Session::get('authUser'); //signifie que c'est l'utilisateur qui est connecté
        if ($connected_user->compte->role->value === 'user') {
            $collaborators = User::whereHas('compte', function (Builder $query) use ($connected_user) {
                $query->where('manager', $connected_user->id);
            });
            $isManager = $collaborators->exists();
            if ($isManager) {
                if($collaborators->count() > 1 && $collaborators->first()->id !== $connected_user->id) {
                    Session::put('manager', true);
                }
            }
            $isValidator = Approbateur::where('email', $connected_user->email)->exists();
            if ($isValidator) {
                Session::put('approver', true);
            }
            $reqs = Demande::whereHas('traitement', function ($query) use ($connected_user) {
                $query->where('demandeur_id', $connected_user->id)->where('status', 'en cours');
            })
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            foreach ($reqs as $demande) {
                $dernier_traitement = Traitement::where('demande_id', $demande->id)->get()->last();
                if ($dernier_traitement->approbateur_id === $connected_user->id) {
                    $demande['status'] = $dernier_traitement->status;
                    if($demande->approbateur_id === $connected_user->id) {
                        $demande['validator'] = true;
                    } else {
                        $demande['validator'] = false;
                    }
                }
                $demande['level'] = $dernier_traitement->level;
            }
        }
        if ($connected_user->compte->role->value === 'livraison') {
            $demandes = Demande::all();
            $all_validated_keys = [];
            foreach ($demandes as $key => $req) {
                $last = Traitement::where('demande_id', $req->id)->orderBy('id', 'DESC')->first();
                if ($last->status === 'validé') {
                    $all_validated_keys[$key] = $req->id;
                }
            }
            $validated_reqs = Demande::whereIn('id', $all_validated_keys)->get();
            $on_going = [];
            foreach ($validated_reqs as $key => $validated) {
                $req_details = DemandeDetail::where('demande_id', $validated->id)->get();
                $to_deliver = 0;
                foreach ($req_details as $req_detail) {
                    if($req_detail->qte_livree < $req_detail->qte_demandee) {
                        $to_deliver_detail = $req_detail->qte_demandee - $req_detail->qte_livree;
                        $to_deliver += $to_deliver_detail;
                    }
                    // $req_count = $req_detail->qte_demandee;
                    // $count = 0;
                    // if (Livraison::where('demande_detail_id', $req_detail->id)->exists()) {
                    //     $deliveries = Livraison::where('demande_detail_id', $req_detail->id)->get();
                    //     foreach ($deliveries as $key => $delivery) {
                    //         $count += $delivery->quantite;
                    //     }
                    //     if ($req_count === $count) {
                    //         $delivered += 1;
                    //     }
                    // }
                }
                // if ($delivered < $req_details->count()) {
                $validated['to_deliver'] = $to_deliver;
                    $on_going[] = $validated;
                // }
            }
            $demandes_array = collect($on_going);
            // dd($demandes_array);
            $reqs = Demande::whereIn('id', $demandes_array->pluck('id'))->orderBy('id', 'desc')->paginate(12);
        }
        foreach ($reqs as $demande) {
            $details = $demande->demande_details;
            $to_deliver = 0;
            foreach ($details as $detail) {
                $sub = $detail->qte_demandee - $detail->qte_livree;
                $to_deliver += $sub;
                $demande['to_deliver'] = $to_deliver;
            }
        }
        // dd($reqs);
        return view('components.reqs.ongoing', compact('reqs'));
    }
}

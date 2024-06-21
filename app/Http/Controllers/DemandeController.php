<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Demande;
use App\Mail\DemandeMail;
use App\Models\Traitement;
use Illuminate\Http\Request;
use App\Models\DemandeDetail;
use App\Models\Mail as MailModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $service_id = Auth::user()->id; //signifie que c'est l'utilisateur qui est connecté
        $demandes = Demande::with(['user', 'demande_details', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->demandes);
        $order = Demande::count() === 0 ? 1 : Demande::get()->first()->id + 1;
        $ref = "REQ-{$order}-" . Carbon::now()->year;
        $demande = Demande::create([
            'numero' => $ref,
            'service_id' => 1,
            'user_id' => Auth::user()->id
        ]);
        if ($demande) {
            foreach ($request->demandes as $item) {
                DemandeDetail::create([
                    'designation' => $item["designation"],
                    'qte_demandee' => $item["qte_demandee"],
                    'qte_livree' => 0,
                    'demande_id' => $demande->id
                ]);
            }

            $traitement = Traitement::create([
                'demande_id' => $demande->id,
                'approbateur_id'=> 0,
            ]);

            if ($traitement){
                MailModel::create([
                    'demande_id' => $demande->id,
                    'approbateur_id' => $traitement->approbateur_id,
                ]);
                $service_manager = (int)($demande->user->compte->manager);
                $manager = User::find($service_manager);
                $demande['manager'] = $manager->name;

                Mail::to($demande->user->email, $demande->user->name)->send(new DemandeMail($demande));
                Mail::to($manager->email, $manager->name)->send(new DemandeMail($demande, true));
            }

            return redirect()->route('demandes.index')->with('success', 'Demande enregistrée avec succès');
        }

        return redirect()->route('demandes.index')->with('success', 'Demande enregistrée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
        //
        // return view('demandes.index', compact('demandes'));
        // $demande = Demande::with('demande_details')->findOrFail($id);
        // dd($demande->demande_details);
        return view('demandes.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demande $demande)
    {
        //

        return view('demandes.index', compact('demandes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        //
        $demande->delete();
        return redirect()->route('demandes.index')->with('success', 'Suppression éffectuée avec succès');
    }
}
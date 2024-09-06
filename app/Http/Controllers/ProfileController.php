<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Compte;
use App\Models\Demande;
use App\Models\Direction;
use App\Models\Traitement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function profile()
    {
        $user = Session::get('authUser');
        $user = User::with('compte.direction')->find($user->id);
        // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUsers");
        // if ($response->successful()) {
        //     $users = $response->json()['users'];
        // }
        $users = User::all();
        $directions = Direction::all();
        $services = Compte::select('service')->distinct()->get();

        $manager = User::find($user->compte->manager);
        if ($manager) {
            $manager_name = $manager->name;
            $user['manager'] = $manager_name;
        }
        $collaborateurs = User::whereHas('compte', function (Builder $query) use ($user) {
            $query->where('manager', $user->id)->where('user_id', '!=', $user->id);
        })->get();

        Carbon::setlocale('fr');

        $months = [];
        if ($user->compte->role->value === 'user') {
            for ($month = 0; $month <= 11; $month++) {
                $months[$month]['name'] = Carbon::create()->month($month + 1)->translatedFormat('F');
                $months[$month]['count'] = Demande::where('user_id', $user->id)->whereMonth('created_at', $month + 1)->whereYear('created_at', Carbon::now()->year)->count();
            }
            // dd($months);
        }

        if($collaborateurs->count() > 0) {
            $user['isManager'] = true;
            foreach ($collaborateurs as $key => $collaborateur) {
                $reqs_count = Demande::where('user_id', $collaborateur->id)->count();
                $collaborateur['reqs_count'] = $reqs_count;
                $collab_last_reqs = Demande::where('user_id', $collaborateur->id)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
                $recent_reqs = Demande::where('user_id', $collaborateur->id)->whereMonth('created_at', Carbon::now()->month)->count();
                $collaborateur['recent_reqs'] = $recent_reqs;
                $collaborateur['collab_last_reqs'] = $collab_last_reqs;
            }
        }
        $last_month_req = Demande::where('user_id', $user->id)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $this_month_req = Demande::where('user_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->count();
        $user_reqs = Demande::where('user_id', $user->id)->get();
        $count = 0;
        foreach ($user_reqs as $key => $req) {
            $last_traitement = Traitement::where('demande_id', $req->id)->orderBy('id', 'DESC')->first();
            if ($last_traitement->status === 'validé') {
                $count = $count + 1;
            }
        }

        $user['validated_reqs'] = $count;
        $user['this_month_req'] = $this_month_req;
        $user['last_month_req'] = $last_month_req;
        return view('profile.index', compact('user', 'months', 'collaborateurs', 'users', 'directions', 'services'));
    }

    public function profileUpdate(Request $request, User $user)
    {
        $request->validate([
            'direction' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'manager' => 'required|string|max:255',
        ]);

        $compte = $user->compte;


        $direction = Direction::where('name', $request->direction)->first();
        if ($direction) {
            $compte->direction_id = $direction->id;
        }


        $manager = User::where('name', $request->manager)->first();
        if ($manager) {
            $compte->manager = $manager->id;
        // } else {
        //     $user_array = explode(' ', $request->manager);
        //     $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUserByName&name={$user_array[0]}");
        //     if ($response->successful()) {
        //         $userResponse = $response->json();
        //         $managerData = $userResponse['users'][0];
        //         $compte->manager = $managerData['id'];
        //     }
        }

        $compte->service = $request->service;
        $compte->save();

        return redirect()->route('profile.index')->with('success', 'Vos informations ont été mises à jour avec succès');
    }
}

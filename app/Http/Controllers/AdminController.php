<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Compte;
use App\Models\Direction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('compte')->where('id', '!=', Session::get('authUser')->id)->latest()->paginate(10);
        // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUsers");
        // if ($response->successful()) {
        //     $usersList = $response->json()['users'];
        // }
        $usersList = User::all();

        $directions = Direction::all();
        $services = Compte::select('service')->distinct()->get();
        return view('users.index', compact('users', 'usersList', 'directions', 'services'));
    }

    public function activateAccount(Request $request, User $user)
    {
        $user_account = Compte::where('user_id', $user->id);
        if ($user->compte->is_activated === 0) {
            $user_account->update([
                'is_activated' => 1
            ]);
            return back()->with('success', 'Compte activé avec succès');
        } else {
            $user_account->update([
                'is_activated' => 0
            ]);
            return back()->with('success', 'Compte désactivé avec succès');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:50|unique:' . User::class,
            'email' => ['required', 'email'],
            'direction' => ['required', 'string'],
            'manager' => ['required', 'string'],
            'service' => ['required', 'string'],
        ]);

        // $user_array = explode(' ', $request->name);
        // $manager_array = explode(' ', $request->manager);
        // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUserByName&name=$user_array[0]");
        // if ($response->successful()) {
        //     $userResponse = $response->json();
        //     $userData = $userResponse['users'][0];
        // }
            $userData = User::where('email', $request->email)->first();
            // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUserByName&name=$manager_array[0]");
            // if ($response->successful()) {
                //     $dataResponse = $response->json();
                //     $managerData = $dataResponse['users'][0];
                //     $manager = $managerData['id'];
                // }
                $manager = User::where('name', $request->manager)->first();

        if (Direction::where('name', $request->direction)->exists()) {
            $direction = Direction::where('name', '=', $request->direction)->first();
        } else {
            if (Session::get('admin') === null) {
                return back()->with('error', 'Cette direction n\'existe pas!');
            } else {
                $direction = Direction::create([
                    'name' => $request->direction
                ]);
            }
        }
        $userInserted = user::create([
            // 'id' => $userData['id'],
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);
        if ($userInserted) {
            // $user = User::find($userData['id']);
            Compte::create([
                "manager" => $manager == null ? $manager : $userInserted->id,
                "user_id" => $userInserted->id,
                "service" => $request->service,
                "direction_id" => $direction->id,
                "role" => $request->role
            ]);
        }
        return redirect()->route('users.index')->with('success', 'user créée avec succès');
    }

    public function changeRole(Request $request, User $user)
    {
        $user = User::find($request->id);
        $profile = Compte::where('user_id', $user->id)->first();
        $profile->update([
            'role' => $request->role,
        ]);
        return back()->with('success', 'Rôle attribué avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User)
    {
        //
    }
}

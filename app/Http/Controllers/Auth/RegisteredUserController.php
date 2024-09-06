<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Compte;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUsers");
        // if ($response->successful()) {
        //     $users = $response->json()['users'];
        // }
        $users = User::all();

        $directions = Direction::all();
        $services = Compte::select('service')->distinct()->get();
        if (Session::has('user')) {
            return view('auth.register', compact('users', 'directions', 'services'));
        } else {
            return redirect()->route('login')->with('error', 'Veuillez d\'abord vous connecter');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'direction' => ['required', 'string'],
            'manager' => ['required', 'string'],
            'service' => ['required', 'string'],
        ]);

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

        if (User::where('name', $request->manager)->exists()) {
            $exist_manager = User::where('name', $request->manager)->first();
            $manager = $exist_manager->id;
        } else {
            // $user_array = explode(' ', $request->manager);
            // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUserByName&name=$user_array[0]");
            // if ($response->successful()) {
            //     $userResponse = $response->json();
            //     $managerData = $userResponse['users'][0];
            //     $manager = $managerData['id'];
            // }
                $manager = 1;
        }
        if (Session::has('admin')) {
            $adminData = Session::get('user');
            $userInsert = User::create([
                // 'id' => $adminData['id'],
                'name' => $request->name,
                'email' => $adminData['email'],
                'password' => Hash::make($adminData['password']),
            ]);
            if ($userInsert) {
                // $user = User::find($adminData['id']);
                Compte::create([
                    "manager" => $manager,
                    "user_id" => $userInsert->id,
                    "service" => $request->service,
                    "direction_id" => $direction->id,
                    "role" => RoleEnum::ADMIN
                ]);
                Session::put('user', $adminData);
            }
        } else {
            $user = session('user');
            // $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUserByUsername&username=$username");
            if ($user) {
                // $userResponse = $response->json();
                $userInsert = User::create([
                    // 'id' => $userData['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                ]);
                if ($userInsert) {
                    // $user = User::find($userData['id']);
                    Compte::create([
                        "manager" => $manager,
                        "user_id" => $userInsert->id,
                        "service" => $request->service,
                        "direction_id" => $direction->id,
                        "role" => RoleEnum::USER
                    ]);
                    Session::put('user', $user['username']);
                }
            }
        }
        if ($userInsert) {
            Session::put('authUser', $userInsert);
            if ($userInsert->compte->role->value === 'livraison') {
                return redirect()->route('dashboard');
            } elseif ($userInsert->compte->role->value === 'admin') {
                return redirect()->route('approbateurs.index');
            } elseif ($userInsert->compte->role->value === 'user') {
                return redirect()->route('demandes.index');
            }
        } else {
            return back();
        }
    }
}

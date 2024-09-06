<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AuthenticatedSessionController extends Controller
{

    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $data = [
            "email" => $request->email,
            "password" => $request->password
        ];
        // $user = User::where('email', $data['username'])->first();
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json'
        // ])->post('http://10.143.41.70:8000/promo2/odcapi/?method=login', $data);

        if ($data) {
            $request->session()->regenerate();
            if (User::all()->count() == 0) {
                Session::put('user', $data);
                Session::put('admin', RoleEnum::ADMIN);
                return redirect()->route('register');
            } else {
                $user = User::where('email', $data['email'])->first();
                if ($user) {
                    // dd($user->compte->is_activated);
                    if ($user->compte->is_activated === 0) {
                        return back()->with('error', 'Votre compte a été désactivé. veuillez contacter l\'admin pour activation');
                    } else {
                        Session::put('authUser', $user);
                        Session::put('user', $data);
                        if ($user->compte->role->value === 'livraison') {
                            return redirect()->route('dashboard');
                        } elseif ($user->compte->role->value === 'admin') {
                            return redirect()->route('approbateurs.index');
                        } elseif ($user->compte->role->value === 'user') {
                            return redirect()->route('demandes.index');
                        } else {
                            Session::put('admin', null);
                            Session::put('user', $data);
                            return redirect()->route('register');
                        }
                    }
                } else {
                    Session::put('admin', null);
                    Session::put('user', $data);
                    return redirect()->route('register');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Informations incorrects');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $request->session()->put('authUser', null);
        return redirect('login');
    }
}

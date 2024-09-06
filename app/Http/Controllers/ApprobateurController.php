<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Approbateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApprobateurController extends Controller
{
    public function index()
    {
        $users = User::all();
        $approbateurs = Approbateur::query()
            ->orderBy('level', 'asc')
            ->get();
        return view('approbateurs.index', compact('approbateurs', 'users'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $levels = $request->input('level');
        $noms = $request->input('name');
        $fonctions = $request->input('fonction');
        $emails = $request->input('email');

        for ($i = 0; $i < count($noms); $i++) {
            $nom = $noms[$i];
            $email = $emails[$i];
            // Vérifier si l'approbateur existe dans l'API
            if (!$this->checkApproverInAPI($nom, $email)) {
                return redirect()->back()->with('error', "L'utilisateur $nom avec l'email $email n'a pas été trouvé dans l'API.");
            }
            $approbateurExistant = Approbateur::withTrashed()->where('name', $nom)->where('email', $email)->first();

            if ($approbateurExistant) {
                if ($approbateurExistant->trashed()) {
                    Approbateur::create([
                        'level' => $levels[$i],
                        'name' => $nom,
                        'fonction' => $fonctions[$i],
                        'email' => $email,
                    ]);
                    return redirect()->back()->with('message', "L'approbateur a été ajouté.");
                }
                return redirect()->back()->with('error', "L'approbateur le nom ou l'email existe déjà.");
            }
            Approbateur::create([
                'level' => $levels[$i],
                'name' => $nom,
                'fonction' => $fonctions[$i],
                'email' => $email,
            ]);
        }

        return redirect()->back()->with('message', "L'approbateur a été ajouté avec succès.");
    }

    private function checkApproverInAPI($name, $email)
    {
        $users = User::all();
        // $response = Http::get('http://10.143.41.70:8000/promo2/odcapi/?method=getUsers');
        if ($users) {
            // $data = $response->json();
            // if ($data['success']) {
                // $users = $data['users'];
                foreach ($users as $user) {
                    if ($user->name === $name && $user->email === $email) {
                        return true;
                    }
                }
            // }
        }
        return false;
    }
    public function edit($id)
    {
        $approbateurs = Approbateur::findOrFail($id);
        return view('approbateurs.index', compact('approbateurs'));
    }
    public function update(Request $request)
    {
        $approbateurs = $request->input('approbateurs');
        $updated = [];
        foreach ($approbateurs as $data) {
            $approbateur = Approbateur::findOrFail($data['id']);
            if ($this->checkApproverInAPI($data['name'], $data['email'])) {
                $approbateur->name = $data['name'];
                $approbateur->fonction = $data['fonction'];
                $approbateur->save();
                $updated[] = $approbateur;
            } else {
                return response()->json(['error'=>'le nom de l\'approbateur n\'est pas reconnue']);
            }
        }
        if (count($updated) > 0) {
            return response()->json(['message'=>"modification éffectu"]);
        } else {
            return response()->json(['error'=>'Une erreur est survenue lors de la modification des approbateurs']);
        }
    }
    public function destroy($id)
    {
        $approbateur = Approbateur::findOrFail($id);
        $approbateur->delete();
                return  redirect()->back()->with('message', 'Approbateur supprimé avec succès');
    }
    public function updateLevels(Request $request)
    {
        $approbateurIds = $request->input('approbateurIds');
        $datas = [];
        foreach ($approbateurIds as $key => $id) {
            $approbateur = Approbateur::where('id', $id)->first();
            $datas[$key]['email'] = $approbateur['email'];
            $datas[$key]['name'] = $approbateur['name'];
            $datas[$key]['fonction'] = $approbateur['fonction'];
            $datas[$key]['level'] = $key + 1;
        }
        Approbateur::truncate();
        foreach ($datas as $data) {
            DB::table('approbateurs')->Insert($data);

        }
        $stock = Approbateur::all();
        return response()->json([
            'message' => 'Niveaux des approbateurs mis à jour avec succès.',
            'data' => $stock,
        ]);
    }
}

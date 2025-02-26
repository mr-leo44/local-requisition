<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Compte;
use App\Mail\DemandeMail;
use App\Mail\UserMail;
use App\Models\Approbateur;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class EnsureUsersCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'req:ensure-users-created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vous avez été designé dans le flow de validation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $managers = Compte::select('manager')->distinct()->get();
        $approvers = Approbateur::where('deleted_at', null)->get();
        $response = Http::get("http://10.143.41.70:8000/promo2/odcapi/?method=getUsers");
        if ($response->successful()) {
            $users = $response->json()['users'];
        }

        foreach ($managers as $key => $managerData) {
            $manager_id = $managerData->manager;
            foreach ($users as $key => $user) {
                if ($user['id'] === $manager_id) {
                    $manager_name = $user['first_name'] . ' ' . $user['last_name'];
                    $userManager = User::where('name', $manager_name)->first();
                    if ($userManager === null) {
                        Mail::to($user['email'], $manager_name)->send(new UserMail($user, true));
                    }
                }
            }
        }

        foreach ($approvers as $key => $approver) {
            foreach ($users as $key => $user) {
                if ($user['email'] === $approver->email) {
                    $validator_name = $user['first_name'] . ' ' . $user['last_name'];
                    $userValidator = User::where('name', $validator_name)->first();

                    if ($userValidator === null) {
                        Mail::to($user['email'], $validator_name)->send(new UserMail($user));
                    }
                }
            }
        }
    }
}

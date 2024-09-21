<?php

namespace App\Console\Commands;

use App\Models\Demande;
use App\Models\DemandeDetail;
use App\Models\Livraison;
use App\Models\Mail;
use App\Models\Traitement;
use Illuminate\Console\Command;

class DropDeletedRequisitions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'req:drop-deleted-requisitions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reqs = Traitement::select(['id', 'demande_id'])->distinct()->get();
        foreach ($reqs as $key => $req) {
            $dropped_req = Demande::where('id', $req->demande_id)->exists();
            if ($dropped_req === false) {
                Mail::where('traitement_id', $req->id)->delete();
                $details = DemandeDetail::where('demande_id', $req->demande_id)->get();
                foreach ($details as $detail) {
                    Livraison::where('demande_detail_id', $detail->id)->delete();
                    $detail->delete();
                }
                Traitement::where('demande_id', $req->demande_id)->delete();
            }
        }
    }
}

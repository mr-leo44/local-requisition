<?php

namespace App\Console\Commands;

use App\Models\Delegation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateDelegationStatus extends Command
{
    protected $signature = 'delegations:update-status';
    protected $description = 'Met à jour le statut des délégations si la date de fin est passée.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $delegations = Delegation::where('date_fin', '<', $now)->get();
    
        foreach ($delegations as $delegation) {
            $delegation->update(['status' => 0]);
        }
    
        $this->info('Les statuts des délégations ont été mis à jour.');
    }
}
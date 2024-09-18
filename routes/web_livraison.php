<?php

use App\Http\Controllers\DemandeController;
use Illuminate\Support\Facades\Route;

Route::post('/demandes/deliver', [DemandeController::class, 'updateLivraison'])->name('demandes.updateLivraison')->middleware('role:livraison');


require __DIR__.'/auth.php';

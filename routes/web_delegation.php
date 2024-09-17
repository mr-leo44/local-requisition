<?php
use App\Http\Controllers\DelegationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function(){  
    route::delete('/delegations/{id}', [DelegationController::class, 'destroy'])->name('delegations.destroy');
    
    Route::resource('delegations', DelegationController::class);
});
require __DIR__.'/auth.php';
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delegation extends Model
{
    use HasFactory,SoftDeletes;
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];
    protected $fillable = [
        'user_id',
        'manager',
        'date_debut',
        'date_fin',
        'motif'
];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function manager(){
        return $this->belongsTo(Compte::class);
    }
}
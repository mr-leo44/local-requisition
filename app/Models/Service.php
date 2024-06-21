<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'direction_id',
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
}
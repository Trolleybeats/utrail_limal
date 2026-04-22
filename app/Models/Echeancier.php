<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeancier extends Model
{
    /** @use HasFactory<\Database\Factories\EcheancierFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'nombre_versements',
        'dates',
        'est_actif',
    ];

    protected $casts = [
        'dates' => 'array',
        'est_actif' => 'boolean',
    ];

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }
}

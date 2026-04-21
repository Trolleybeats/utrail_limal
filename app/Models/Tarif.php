<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    /** @use HasFactory<\Database\Factories\TarifFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'categorie',
        'course_numero',
        'prix',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];
}

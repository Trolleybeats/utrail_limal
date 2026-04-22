<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{
    /** @use HasFactory<\Database\Factories\VersementFactory> */
    use HasFactory;

    protected $fillable = [
        'membre_id',
        'numero_versement',
        'montant',
        'date_echeance',
        'stripe_payment_intent_id',
        'statut',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
}

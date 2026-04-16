<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    /** @use HasFactory<\Database\Factories\MembreFactory> */
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'date_naissance',
        'participation_un',
        'distance_un',
        'logement_un',
        'participation_deux',
        'distance_deux',
        'logement_deux',
        'tshirt_taille',
        'rgpd',
        'inscription',
    ];

    protected $casts = [
        'participation_un' => 'boolean',
        'participation_deux' => 'boolean',
        'logement_un' => 'boolean',
        'logement_deux' => 'boolean',
        'rgpd' => 'boolean',
        'inscription' => 'boolean',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}

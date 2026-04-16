<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'rgpd',
        'pre_inscription',
        'token',
    ];

    protected $casts = [
        'rgpd' => 'boolean',
        'pre_inscription' => 'boolean',
    ];

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }
}

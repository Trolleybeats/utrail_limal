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
        'mail_envoye_le',
    ];

    protected $casts = [
        'rgpd' => 'boolean',
        'pre_inscription' => 'boolean',
        'mail_envoye_le' => 'datetime',
    ];

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    /** @use HasFactory<\Database\Factories\ProjetFactory> */
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'photo_id',
        'ordre',
    ];

    public function photoPrincipale()
    {
        return $this->belongsTo(PhotoProjet::class, 'photo_id');
    }

    public function photos()
    {
        return $this->hasMany(PhotoProjet::class);
    }
}

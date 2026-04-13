<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PhotoProjet extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'chemin',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->chemin);
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}

<?php

namespace App\Exports;

use App\Models\Membre;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembresExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Membre::with('participant')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'Email',
            'Téléphone',
            'Date de naissance',
            'Course 1',
            'Distance 1',
            'Logement 1',
            'Course 2',
            'Distance 2',
            'Logement 2',
            'Taille tshirt',
        ];
    }

    public function map($membre): array
    {
        return [
            $membre->participant_id,
            $membre->participant?->nom,
            $membre->participant?->prenom,
            $membre->participant?->email,
            $membre->participant?->telephone,
            $membre->date_naissance ? \Carbon\Carbon::parse($membre->date_naissance)->format('d/m/Y') : '',
            $membre->participation_un ? 'Oui' : 'Non',
            $membre->distance_un,
            $membre->logement_un ? 'Oui' : 'Non',
            $membre->participation_deux ? 'Oui' : 'Non',
            $membre->distance_deux,
            $membre->logement_deux ? 'Oui' : 'Non',
            strtoupper($membre->tshirt_taille),
        ];
    }
}

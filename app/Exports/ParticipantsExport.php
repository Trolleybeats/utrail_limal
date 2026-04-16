<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Participant::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'Email',
            'Téléphone',
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->id,
            $participant->nom,
            $participant->prenom,
            $participant->email,
            $participant->telephone,
        ];
    }
}
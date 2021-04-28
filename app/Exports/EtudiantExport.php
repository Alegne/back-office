<?php

namespace App\Exports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class EtudiantExport extends DataTablesCollectionExport implements WithMapping,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Etudiant::
           with(
                'niveau',
                'parcours'
            )
            ->where('status', 'actif')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Numero',
            'Nom',
            'Prenom',
            'Email',
            'CIN',
            'Date de Naissance',
            'Lieu de Naissance',
            'Adresse',
            'Parcours',
            'Niveau',
            'Status',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row['numero'],
            $row['nom'],
            $row['prenom'],
            $row['email'],
            $row['cin'],
            $row['date_naissance'],
            $row['lieu_naissance'],
            $row['adresse'],
            $row['parcours'],
            $row['niveau'],
            $row['status'],
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Etudiant;
use App\Models\Parcours;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class EtudiantExport
    extends DataTablesCollectionExport
    implements WithMapping,FromCollection
{

    public function __construct(Collection $collection)
    {
        parent::__construct($collection);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $etudiants = Etudiant::with(
                'niveau:tag',
                'parcours:tag'
            )
            ->where('status', 'actif')
        ;
        return $etudiants->get();
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
            'Annee Univeristaire',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $parcours = Parcours::find($row->parcours_id);
        return [
            $row->numero,
            $row->nom,
            $row->prenom,
            $row->email,
            $row->cin,
            $row->date_naissance,
            $row->lieu_naissance,
            $row->adresse,
            $parcours->tag,
            $row->niveau[0]->tag,
            $row->status,
            $row->annee[0]->libelle,
        ];
        /*return [
            $row['numero'],
            $row['nom'],
            $row['prenom'],
            $row['email'],
            $row['cin'],
            $row['date_naissance'],
            $row['lieu_naissance'],
            $row['adresse'],
            $row['parcours_id'],
            $row['niveau'],
            $row['status'],
        ];*/
    }
}

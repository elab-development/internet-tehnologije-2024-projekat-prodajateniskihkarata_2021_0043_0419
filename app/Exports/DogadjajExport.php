<?php

namespace App\Exports;

use App\Models\Dogadjaj;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DogadjajExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dogadjaj::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Naziv',
            'Lokacija',
            'Opis',
            'Status',
            'Datum Registracije',
            'Kreirano',
            'Ažurirano'
        ];
    }
}
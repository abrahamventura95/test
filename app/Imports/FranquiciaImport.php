<?php

namespace App\Imports;

use App\Franquicia;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class FranquiciaImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        Franquicia::create(['nombre' => $row['0']]);
    }
    public function rules(): array
    {
        return [
            '0' => 'unique:franquicias,nombre'
        ];

    }

    public function customValidationMessages()
    {
        return [
            '0.unique' => 'Nombre ya esta en uso.',
        ];
    }
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}

<?php

namespace App\Imports;

use App\Cliente;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class ClienteImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        $exist = Cliente::where('rif','=',$row['0'])->get();
        if(!count($exist)) 
		    Cliente::create([
		       				'rif' 			=> $row['0'], 
		       				'rs'  			=> $row['1'], 
		       				'domicilio' 	=> $row['2']]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|unique:clientes,rif',
            '1' => 'required|string',
            '2' => 'required|string'
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


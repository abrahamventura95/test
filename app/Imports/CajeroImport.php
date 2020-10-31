<?php

namespace App\Imports;

use App\Caja;
use App\Cajero;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class CajeroImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        $cajaId = Caja::Where('numero','=',$row['1'])->get();
        if(!$cajaId) return null;
        $exist = Cajero::Where('codigo','=',$row['0'])->where('caja_id','=',$cajaId[0]->id)->get();
        if(!count($exist))
	        Cajero::create([
	        				'codigo' 	  => $row['0'], 
	        				'caja_id'  	=> $cajaId[0]->id, 
	        				'nombres' 	=> $row['2']]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|integer',
            '1' => 'required|integer|exists:cajas,numero',
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


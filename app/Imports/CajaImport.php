<?php

namespace App\Imports;

use App\Caja;
use App\Franquicia;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class CajaImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;  
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1)	return null;
       	if(strtoupper($row['2']) === 'ON'){
       		$row['2'] = true;
       	}else{
       		$row['2'] = false;
       	}
        $franquiciaId = Franquicia::Where('nombre','=',$row['1'])->get();
        $exist = Caja::where('numero','=',$row['0'])->where('franquicia_id', '=', $franquiciaId[0]->id)->get();
        if(!count($exist)) 
        	Caja::create(['numero' => $row['0'], 'franquicia_id' => $franquiciaId[0]->id, 'estado' => $row['2']]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|integer|min:1',
            '1' => 'required|string|exists:franquicias,nombre',
            '2' => 'required'
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

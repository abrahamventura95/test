<?php

namespace App\Imports;

use App\Formato;
use App\Producto;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Carbon\Carbon;

class ProductoImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        $row['4'] = strtolower($row['4']);
        if($row['4'] == 'limpieza' || $row['4'] == 'comestible' || $row['4'] == 'decoracion'){
            $row['5'] = substr($row['5'], 1, -1);
            $date = Carbon::createFromFormat('d/m/Y', $row['5'])->format('Y-m-d');
            $formatoId = Formato::Where('nombre','=',$row['3'])->get();
    	    Producto::create([
    	        				'nombre' 	 		=> $row['0'], 
    	        				'descripcion'  		=> $row['1'], 
    	        				'monto_unitario'  	=> $row['2'],
    	        				'formato_id' 		=> $formatoId[0]->id,
    	        				'categoria'  		=> $row['4'],
    	        				'vida_util'  		=> $date]);
        }
    }
    public function rules(): array
    {
        return [
            '0' => 'required|string|unique:productos,nombre',
            '1' => 'required|string',
            '2' => 'required|integer',
            '3' => 'required|string|exists:formatos,nombre',
            '4' => 'required',
            '5' => 'required'
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

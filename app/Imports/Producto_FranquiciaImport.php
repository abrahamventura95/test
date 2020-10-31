<?php

namespace App\Imports;

use App\Producto;
use App\Franquicia;
use App\Producto_Franquicia as PF;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class Producto_FranquiciaImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        $productoId = Producto::Where('nombre','=',$row['0'])->get();
        $franquiciaId = Franquicia::Where('nombre','=',$row['1'])->get();
        $exist = PF::Where('franquicia_id','=',$franquiciaId[0]->id)
        		   ->where('producto_id','=',$productoId[0]->id)
        		   ->get();
        if(!count($exist))
	        PF::create([
        				'franquicia_id' 	=> $franquiciaId[0]->id, 
        				'producto_id'  		=> $productoId[0]->id]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|string|exists:productos,nombre',
            '1' => 'required|string|exists:franquicias,nombre'
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
<?php

namespace App\Imports;

use App\Factura;
use App\Producto;
use App\Producto_Factura as PF;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class ProductoFraImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex === 1) return null;
        $productoId = Producto::Where('nombre','=',$row['0'])->get();
        $facturaId = Factura::find($row['1']);
        $exist = PF::Where('producto_id','=',$productoId[0]->id)
                   ->Where('factura_id','=', $facturaId->id)
                   ->get();
        if(!count($exist))           
	       PF::create([
      				'producto_id' 	=> $productoId[0]->id, 
       				'factura_id'  	=> $facturaId->id,
       				'cantidad'  	=> $row['2']]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|exists:productos,nombre',
            '1' => 'required|integer|exists:facturas,id',
            '2' => 'required|integer|min:1'
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

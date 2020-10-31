<?php

namespace App\Imports;

use App\Caja;
use App\Cajero;
use App\Cliente;
use App\Franquicia;
use App\Factura;
use Carbon\Carbon;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class FacturaImport implements OnEachRow, WithValidation ,SkipsOnFailure
{
    use Importable;
    public function onRow(Row $row)
    {
      $rowIndex = $row->getIndex();
      $row      = $row->toArray();
      if($rowIndex === 1) return null;
      $row['4'] = strtolower($row['4']);
      if($row['4'] == 'debito' || $row['4'] == 'credito' || $row['4'] == 'efectivo'){
        $clienteId = Cliente::Where('rif','=',$row['0'])->get();
        $caja = Caja::Where('numero','=',$row['2'])->get();
        $cajeroId = Cajero::Where('codigo','=',$row['1'])
                          ->Where('caja_id','=',$caja[0]->id)
                          ->get();
        $franquiciaId = Franquicia::Where('nombre','=',$row['3'])->get();
        $row['7'] = substr($row['7'], 1, -1);
        $date = Carbon::createFromFormat('d/m/Y', $row['7'])->format('Y-m-d');
  	    Factura::create([
        				'franquicia_id' 	=> $franquiciaId[0]->id, 
         				'cliente_id'  		=> $clienteId[0]->id,
         				'cajero_id'  		  => $cajeroId[0]->id,
         				'metodo'  			  => $row['4'],
         				'subtotal'  		  => $row['5'],
         				'iva'  		    		=> $row['6'],
                'created_at'      => $date]);
      }
    }
    public function rules(): array
    {
        return [
            '0' => 'required|exists:clientes,rif',
            '1' => 'required|integer|exists:cajeros,codigo',
            '2' => 'required|integer|exists:cajas,numero',
            '3' => 'required|string|exists:franquicias,nombre',
            '4' => 'required',
            '5' => 'required|min:1',
            '6' => 'required|integer|min:0',
            '7' => 'required'
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
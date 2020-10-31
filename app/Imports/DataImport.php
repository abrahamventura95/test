<?php

namespace App\Imports;

use App\Imports\FranquiciaImport;
use App\Imports\CajaImport;
use App\Imports\CajeroImport;
use App\Imports\ClienteImport;
use App\Imports\FormatoImport;
use App\Imports\ProductoImport;
use App\Imports\Producto_FranquiciaImport;
use App\Imports\FacturaImport;
use App\Imports\ProductoFraImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataImport implements WithMultipleSheets 
{


     public function sheets(): array
    {
    	return [
    		'FRANQUICIA'=>new FranquiciaImport(),
        	'CAJA'=>new CajaImport(),       
            'CAJERO' => new CajeroImport(),
            'CLIENTE' => new ClienteImport(),
            'FORMATO' => new FormatoImport(),
            'PRODUCTO' => new ProductoImport(),
        	'PRODUCTOFRANQUICIA' => new Producto_FranquiciaImport(),
        	'FACTURA' => new FacturaImport(),
        	'PRODUCTOFACTURA' => new ProductoFraImport(),
        ];
    }
}

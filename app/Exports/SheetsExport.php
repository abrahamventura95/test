<?php

namespace App\Exports;

use App\Exports\FormatExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetsExport implements WithMultipleSheets
{
    use Exportable;
    
    /**
     * @return array
     */
    public function sheets(): array 
    {
        $sheets = [];
        $sheets[0] = new FormatExport('franquicia',1);
        $sheets[1] = new FormatExport('caja',3);
        $sheets[2] = new FormatExport('cajero',3);
        $sheets[3] = new FormatExport('cliente',3);
        $sheets[4] = new FormatExport('formato',1);
        $sheets[5] = new FormatExport('producto',6);
        $sheets[6] = new FormatExport('productoFranquicia',2);
        $sheets[7] = new FormatExport('factura',8);
        $sheets[8] = new FormatExport('productoFactura',3);
        return $sheets;
    }
}

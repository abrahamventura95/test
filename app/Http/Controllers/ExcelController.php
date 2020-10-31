<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Producto_Factura as PF;
use App\Cliente;
use App\Cajero;
use App\Franquicia;
use App\Exports\SheetsExport;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
	public function export() 
    {
        return Excel::download(new SheetsExport, 'format.xlsx');
    }

    public function import() 
    {
        Excel::import(new DataImport,request()->file('file'));

        return back();
    }

    public function getFactura($num, Request $request)
    {
        $factura = Factura::find($num);
        if(isset($factura)){
            $cliente = Cliente::Select('clientes.rif as RIF',
                                       'clientes.rs as Razon_Social',
                                       'clientes.domicilio')
                              ->find($factura->cliente_id);
            $cajero = Cajero::Join('cajas','cajas.id','=','cajeros.caja_id')
                            ->Select('cajas.numero as NumCaja', 'cajeros.codigo', 'cajeros.nombres')
                            ->find($factura->cajero_id);
            $franquicia = Franquicia::Select('nombre')->find($factura->franquicia_id);
            $productos = PF::join('productos','productos.id','=','productos_factura.producto_id')
                           ->join('formatos','formatos.id','=','productos.formato_id')
                           ->Select('productos.nombre',
                                    'productos.descripcion',
                                    'formatos.nombre as formato',
                                    'productos.categoria',
                                    'productos.monto_unitario',
                                    'productos_factura.cantidad',
                                    'productos.vida_util')
                           ->Where('productos_factura.factura_id','=',$num)
                           ->get();
            $imprimible = array('NumControl' => $factura->id, 
                                'Fecha' => $factura->created_at, 
                                'Datos Cliente' => $cliente,
                                'Cajero' => $cajero,
                                'Productos' => $productos,
                                'Franquicia'=> $franquicia,
                                'Método de cancelación' => $factura->metodo,
                                'SubTotal' => $factura->subtotal,
                                'IVA' => $factura->iva);
            return $imprimible;               
        }else{
            return $arrayName = array('err' => 404, 'msg' => 'factura no encontrada');
        }
    }
}

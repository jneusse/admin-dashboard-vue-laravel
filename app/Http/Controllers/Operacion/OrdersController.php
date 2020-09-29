<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function getListaPedidos(Request $request)
    {

        $cNombre = $request->cNombre;
        $cDocumento = $request->cDocumento;
        $cPedido = $request->cPedido;
        $nIdEstado = $request->nIdEstado;

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cDocumento = ($cDocumento == NULL) ? ($cDocumento = '') : $cDocumento;
        $cPedido = ($cPedido == NULL) ? ($cPedido = '') : $cPedido;
        $nIdEstado = ($nIdEstado == NULL) ? ($nIdEstado = 0) : $nIdEstado;

        $rpta = DB::select('call sp_Pedido_getListaPedidos( ?, ?, ?, ?)', [
            $cNombre,
            $cDocumento,
            $cPedido,
            $nIdEstado
        ]);

        return $rpta;
    }
}

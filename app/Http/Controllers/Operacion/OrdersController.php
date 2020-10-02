<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

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
    public function setRegistrarPedido(Request $request)
    {
        $nIdCliente = $request->nIdCliente;
        $cComentario = $request->cComentario;
        $fTotalPedido = $request->fTotalPedido;
        $listPedido = $request->listPedido;
        $nIdAuthUser = Auth::id();

        $cComentario = ($cComentario == NULL) ? ($cComentario = '') : $cComentario;
        // return $request;
        try {
            DB::beginTransaction();
            $rpta = DB::select('call sp_Pedido_setRegistrarPedido( ?, ?, ?, ?)', [
                $nIdCliente,
                $cComentario,
                $fTotalPedido,
                $nIdAuthUser
            ]);
            // return $rpta;
            $nIdPedido = $rpta[0]->nIdPedido;


            $listPedidoSize = sizeof($listPedido);
            if($listPedidoSize > 0){
                foreach ($listPedido as $key => $value) {
                    DB::select('call sp_Pedido_setRegistrarDetallePedido( ?, ?, ?, ?)', [
                        $nIdPedido,
                        $value['nIdProducto'],
                        $value['nStock'],
                        $value['fSubtotal']
                    ]);
                }

            }
            DB::commit();


        } catch (Exception $e) {
            //throw $th;
            DB::rollback();
            return ('error');
        }


        return $rpta;
    }
}


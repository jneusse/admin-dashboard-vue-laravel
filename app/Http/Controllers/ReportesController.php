<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class ReportesController extends Controller
{
  public function getListaPedidos(Request $request)
  {

      $cNombre = $request->cNombre;
      $cDocumento = $request->cDocumento;
      $cPedido = $request->cPedido;
      $cEstado = $request->cEstado;
      $dFechaInicio = $request->dFechaInicio;
      $dFechaFin = $request->dFechaFin;

      $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
      $cDocumento = ($cDocumento == NULL) ? ($cDocumento = '') : $cDocumento;
      $cPedido = ($cPedido == NULL) ? ($cPedido = '') : $cPedido;
      $cEstado = ($cEstado == NULL) ? ($cEstado = '') : $cEstado;
      $dFechaInicio = ($dFechaInicio == NULL) ? ($dFechaInicio = '') : $dFechaInicio;
      $dFechaFin = ($dFechaFin == NULL) ? ($dFechaFin = '') : $dFechaFin;

      $rpta = DB::select('call sp_Reporte_getListaPedidos( ?, ?, ?, ?, ?, ?)', [
          $cNombre,
          $cDocumento,
          $cPedido,
          $cEstado,
          $dFechaInicio,
          $dFechaFin
      ]);

      return $rpta;
  }
  public function export(Request $request)
  {
      $listPedidos = json_decode($request->listPedidos);
      return (new OrdersExport)->getPedidos($listPedidos)->download('data.xlsx');
  }
}

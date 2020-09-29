<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function getListaProductos(Request $request)
    {

        $nIdProducto = $request->nIdProducto;
        $cNombre = $request->cNombre;
        $cDescripcion = $request->cDescripcion;
        $nIdCategoria = $request->nIdCategoria;

        $nIdProducto = ($nIdProducto == NULL) ? ($nIdProducto = 0) : $nIdProducto;
        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = '') : $cDescripcion;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 0) : $nIdCategoria;

        $rpta = DB::select('call sp_Producto_getListaProductos( ?, ?, ?, ?)', [
            $nIdProducto,
            $cNombre,
            $cDescripcion,
            $nIdCategoria
        ]);

        return $rpta;
    }
    public function setRegistrarProducto(Request $request)
    {

        $cNombre = $request->cNombre;
        $cDescripcion = $request->cDescripcion;
        $nStock = $request->nStock;
        $fPrecio = $request->fPrecio;
        $nIdCategoria = $request->nIdCategoria;
        $nIdAuthUser = Auth::id();

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = '') : $cDescripcion;
        $nStock = ($nStock == NULL) ? ($nStock = 1) : $nStock;
        $fPrecio = ($fPrecio == NULL) ? ($fPrecio = 1) : $fPrecio;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 1) : $nIdCategoria;

        $rpta = DB::select('call sp_Producto_setRegistrarProducto( ?, ?, ?, ?, ?, ?)', [
            $cNombre,
            $cDescripcion,
            $nStock,
            $fPrecio,
            $nIdCategoria,
            $nIdAuthUser
        ]);

        return $rpta;
    }
    public function setEditarProducto(Request $request)
    {
        $nIdProducto = $request->nIdProducto;
        $cNombre = $request->cNombre;
        $cDescripcion = $request->cDescripcion;
        $nStock = $request->nStock;
        $fPrecio = $request->fPrecio;
        $nIdCategoria = $request->nIdCategoria;
        $nIdAuthUser = Auth::id();

        $nIdProducto = ($nIdProducto == NULL) ? ($nIdProducto = 0) : $nIdProducto;
        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cDescripcion = ($cDescripcion == NULL) ? ($cDescripcion = '') : $cDescripcion;
        $nStock = ($nStock == NULL) ? ($nStock = 1) : $nStock;
        $fPrecio = ($fPrecio == NULL) ? ($fPrecio = 1) : $fPrecio;
        $nIdCategoria = ($nIdCategoria == NULL) ? ($nIdCategoria = 1) : $nIdCategoria;

        $rpta = DB::select('call sp_Producto_setEditarProducto( ?, ?, ?, ?, ?, ?, ?)', [
            $nIdProducto,
            $cNombre,
            $cDescripcion,
            $nStock,
            $fPrecio,
            $nIdCategoria,
            $nIdAuthUser
        ]);

        return $rpta;
    }
}

<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function getListaUsuarios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cNombre = $request->cNombre;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cEstado = $request->cEstado;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0) : $nIdUsuario;
        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cUsuario = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
        $cCorreo = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
        $cEstado = ($cEstado == NULL) ? ($cEstado = '') : $cEstado;

        $rpta = '[]';
        // return $rpta;
        $rpta = DB::select('call sp_Usuario_getListaUsuarios( ?, ?, ?, ?, ?)', [
            $nIdUsuario,
            $cNombre,
            $cUsuario,
            $cCorreo,
            $cEstado,
        ]);

        // return $cEstado;
        return $rpta;
    }
    public function setRegistrarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cPrimerNombre = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellido = $request->cApellido;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cContrasena = Hash::make($request->cContrasena);
        $oFotografia = $request->oFotografia;

        $rpta = DB::select('call sp_Usuario_setRegistrarUsuario( ?, ?, ?, ?, ?, ?, ?)', [
            $cPrimerNombre,
            $cSegundoNombre,
            $cApellido,
            $cUsuario,
            $cCorreo,
            $cContrasena,
            $oFotografia,
        ]);

        return $rpta[0]->nIdUsuario;
    }
    public function setEditarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cPrimerNombre = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellido = $request->cApellido;
        $cUsuario = $request->cUsuario;
        $cCorreo = $request->cCorreo;
        $cContrasena = Hash::make($request->cContrasena);
        if($cContrasena != NULL){
            $cContrasena = Hash::make($cContrasena);
        }
        $oFotografia = $request->oFotografia;

        $rpta = DB::select('call sp_Usuario_setEditarUsuario(?, ?, ?, ?, ?, ?, ?, ?)', [
            $nIdUsuario,
            $cPrimerNombre,
            $cSegundoNombre,
            $cApellido,
            $cUsuario,
            $cCorreo,
            $cContrasena,
            $oFotografia,
        ]);

        return $rpta;
    }
    public function setCambiarEstadoUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $cEstado = $request->cEstado;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0) : $nIdUsuario;
        $cEstado = ($cEstado == NULL) ? ($cEstado = 0) : $cEstado;


        $rpta = DB::select('call sp_Usuario_setCambiarEstadoUsuario(?, ?)', [
            $nIdUsuario,
            $cEstado
        ]);

        return $rpta;
    }
    public function setEditarRolByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario = $request->nIdUsuario;
        $nIdRol = $request->nIdRol;

        $nIdUsuario = ($nIdUsuario == NULL) ? ($nIdUsuario = 0) : $nIdUsuario;
        $nIdRol = ($nIdRol == NULL) ? ($nIdRol = 0) : $nIdRol;


        $rpta = DB::select('call sp_Usuario_setEditarRolByUsuario(?, ?)', [
            $nIdUsuario,
            $nIdRol
        ]);

        return $rpta;
    }
}

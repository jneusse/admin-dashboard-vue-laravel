<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PermissionsController extends Controller
{
    public function getListarPermisos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;
        $nIdPermiso = $request->nIdPermiso;

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;
        $nIdPermiso = ($nIdPermiso == NULL) ? ($nIdPermiso = 0) : $nIdPermiso;

        $rpta = DB::select('call sp_Rol_getListaPermisos( ?, ?, ?)', [
            $nIdPermiso,
            $cNombre,
            $cSlug
        ]);

        // return $cEstado;
        return $rpta;
    }
    public function setRegistrarPermiso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;

        DB::select('call sp_Rol_setRegistrarPermiso( ?, ?)', [
            $cNombre,
            $cSlug
        ]);
    }
    public function setEditarPermiso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdPermiso = $request->nIdPermiso;
        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;

        $nIdPermiso = ($nIdPermiso == NULL) ? ($nIdPermiso = 0) : $nIdPermiso;
        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;

        DB::select('call sp_Rol_setEditarPermiso( ?, ?, ?)', [
            $nIdPermiso,
            $cNombre,
            $cSlug
        ]);
    }
}

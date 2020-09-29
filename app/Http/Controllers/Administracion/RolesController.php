<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getListaRoles(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;
        $nIdRol = $request->nIdRol;

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;
        $nIdRol = ($nIdRol == NULL) ? ($nIdRol = 0) : $nIdRol;

        $rpta = DB::select('call sp_Rol_getListaRoles( ?, ?, ?)', [
            $nIdRol,
            $cNombre,
            $cSlug
        ]);

        // return $cEstado;
        return $rpta;
    }
    public function getListarPermisosByRol(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdRol = $request->nIdRol;
        $nIdRol = ($nIdRol == NULL) ? ($nIdRol = 0) : $nIdRol;

        $rpta = DB::select('call sp_Rol_getListarPermisosByRol(?)',[
            $nIdRol
        ]);

        return $rpta;

    }
    public function setRegistrarRolPermiso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;

        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;

        try {
            DB::beginTransaction();

            $rpta = DB::select('call sp_Rol_setRegistrarRol( ?, ?)',[
                $cNombre,
                $cSlug
            ]);

            $nIdRol = $rpta[0]->nIdRol;

            $listPermisos = $request->listPermisosFilter;
            $listPermisosSize = sizeof($listPermisos);
            if($listPermisosSize > 0){
                foreach ($listPermisos as $key => $value) {
                    if($value['checked'] == true ){
                        DB::select('call sp_Rol_setRegistrarRolPermiso( ?, ?)',[
                            $nIdRol,
                            $value['id']
                        ]);
                    }
                }
            }
            DB::commit();

        } catch (Exception $e) {
            //throw $th;
            DB::rollback();
            return ('error');

        }

    }
    public function setEditarRol(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdRol = $request->nIdRol;
        $cNombre = $request->cNombre;
        $cSlug = $request->cSlug;

        $nIdRol = ($nIdRol == NULL) ? ($nIdRol = 0) : $nIdRol;
        $cNombre = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
        $cSlug = ($cSlug == NULL) ? ($cSlug = '') : $cSlug;

        try {
            DB::beginTransaction();

            $rpta = DB::select('call sp_Rol_setEditarRol(?, ?, ?)',[
                $nIdRol,
                $cNombre,
                $cSlug
            ]);

            $listPermisos = $request->listPermisosFilter;
            $listPermisosSize = sizeof($listPermisos);
            if($listPermisosSize > 0){
                foreach ($listPermisos as $key => $value) {
                    if($value['checked'] == true ){
                        DB::select('call sp_Rol_setRegistrarRolPermiso( ?, ?)',[
                            $nIdRol,
                            $value['id']
                        ]);
                    }
                }
            }
            DB::commit();

        } catch (Exception $e) {
            //throw $th;
            DB::rollback();
            return ('error');

        }


    }
}

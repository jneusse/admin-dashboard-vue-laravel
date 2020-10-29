<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\NuevoMensaje;

class ChatsController extends Controller
{
    public function getListarContactos(Request $request)
    {
        $nIdAuthUser = Auth::id();

        $rpta = DB::select('call sp_Chat_getListarContactos(?)', [$nIdAuthUser]);

        return $rpta;
    }
    public function getListarConversaciones(Request $request)
    {
        $nIdContacto = $request->nIdContacto;
        $nIdAuthUser = Auth::id();

        $rpta = DB::select('call sp_Chat_getListarConversaciones(?, ?)', [ $nIdContacto, $nIdAuthUser ]);

        return $rpta;
    }
    public function setRegistrarMensaje(Request $request)
    {

        $from = Auth::id();
        $to = $request->nIdContacto;
        $text = $request->cMensaje;

        $rpta = DB::select('call sp_Chat_setRegistrarMensaje(?, ?, ?)', [ $from, $to, $text ]);

        broadcast(new NuevoMensaje($rpta[0]));
        return $rpta;
    }
}

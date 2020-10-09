<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$rpta1[0]->nNumeroPedido}}</title>
    <style>
        @page{
            margin: 1.3rem;
            margin-top: 1.9rem;
            padding: 1rem;
        }
        body{
            margin: 0;
        }
        *{
            font-family: verdana, arial, sans-serif;
        }
        .cabecera{
            background-color: #FEFEFE;
            color: #000000;
            padding: 2rem;
            padding-top: .2rem;
            padding-bottom: 0;
        }
        .cabecera .logo{
            margin: 5px;
        }
        .cabecera table{
            padding: 1px;
            margin-bottom: .2rem;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
    </style>
</head>
<body>
    <div class="cabecera">
        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" align="center">
                        <tr>
                            <td>
                                <img src="{{$logo}}" alt="{{$logo}}" class="logo" width="210" height="90">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Curso Laravel VueJS
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%" cellspacing="0" align="center">
                        <tr>
                            <td>Pedido</td>
                            <td>{{$rpta1[0]->nNumeroPedido}}</td>
                        </tr>
                        <tr>
                            <td>Fecha Pedido</td>
                            <td>{{$rpta1[0]->dFechaPedido}}</td>
                        </tr>
                        <tr>
                            <td>Estado Pedido</td>
                            <td>{{$rpta1[0]->cEstadoPedido}}</td>
                        </tr>
                        <tr>
                            <td>Vendedor</td>
                            <td>{{$rpta1[0]->cVendedor}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <tr>
                <td colspan="2">
                    <h3><strong>Informacion del Cliente</strong></h3>
                </td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>{{$rpta1[0]->cCliente}}</td>
            </tr>
            <tr>
                <td>Documento</td>
                <td>{{$rpta1[0]->cDocumento}}</td>
            </tr>
            <tr>
                <td>Correo Electrónico</td>
                <td>{{$rpta1[0]->cCorreo}}</td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td>{{$rpta1[0]->cTelefono}}</td>
            </tr>
        </table>

        @if (count($rpta2) > 0)
            <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
                <thead style="background-color: lightgray">
                    <tr align="center" align="middle">
                        <th colspan="5">Detalle de pedido</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rpta2 as $key => $value)
                        <tr>
                            <td align="center"><span>{{$key + 1}}</span></td>
                            <td align="center"><span>{{$value->cProducto}}</span></td>
                            <td align="center"><span>{{$value->nCantidad}}</span></td>
                            <td align="center"><span>{{number_format($value->fPrecio, 2)}}</span></td>
                            <td align="center"><span>{{number_format($value->fSubtotal, 2)}}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endif


        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <tr>
                <td align="right"><h3><strong>Total del pedido</strong></h3></td>
                <td align="center"><h3>{{$rpta1[0]->nTotal}}</h3></td>
            </tr>
        </table>
        <table width="100%" cellspacing="0" cellspacing="1" border="0" align="center">
            <tr>
                <td align="righr"><h3><strong>Comentarios</strong></h3></td>
                <td align="center">
                    <h3>
                        {{$rpta1[0]->cComentario}}
                    </h3>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

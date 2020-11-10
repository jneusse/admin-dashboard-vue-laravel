<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Documento</title>
  </head>
  <body>
    <table>
        <thead>
          <tr>
              <th>Pedido</th>
              <th>Documento</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Vendedor</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->pedido }}</td>
                <td>{{ $pedido->documento }}</td>
                <td>{{ $pedido->cliente }}</td>
                <td>{{ number_format($pedido->total, 2) }}</td>
                <td>{{ $pedido->vendedor }}</td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </body>
</html>

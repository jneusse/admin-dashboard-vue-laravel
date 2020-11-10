<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class OrdersExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    private $listPedidos = [];

    public function getPedidos($listPedidos)
    {
        $this->listPedidos = $listPedidos;

        return $this;
    }
    public function view(): View
    {
        return view('reportes.pedido.excel.pedidos', [
            'pedidos' => $this->listPedidos
        ]);
    }
    public function columnFormats(): array
    {
        return [
          'A' => NumberFormat::FORMAT_GENERAL,
          'B' => NumberFormat::FORMAT_GENERAL,
          'C' => NumberFormat::FORMAT_GENERAL,
          'D' => NumberFormat::FORMAT_NUMBER_00,
          'E' => NumberFormat::FORMAT_GENERAL,
        ];
    }
}

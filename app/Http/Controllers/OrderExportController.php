<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
class OrderExportController extends Controller
{
public function export(Request $request)
{
    $orders = $this->getOrders($request);
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    $sheet = $spreadsheet->getActiveSheet();
    
    // Установка заголовков таблицы
    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Имя');
    $sheet->setCellValue('C1', 'Телефон');
    $sheet->setCellValue('D1', 'Электронная почта');
    $sheet->setCellValue('E1', 'Дата');
    $sheet->setCellValue('F1', 'Время');
    $sheet->setCellValue('G1', 'Тип оплаты');
    $sheet->setCellValue('H1', 'Товар');
    $sheet->setCellValue('I1', 'Количество');
    $sheet->setCellValue('J1', 'Адрес');
    $sheet->setCellValue('K1', 'Статус');
    
    // Стилизация заголовков
    $sheet->getStyle('A1:K1')->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_WHITE);
    $sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID);
    $sheet->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('FF003366');
    
    // Заполнение таблицы данными
    $i = 2;
    foreach ($orders as $order) {
        // Базовые данные заказа
        $sheet->setCellValue('A' . $i, $i - 1);
        $sheet->setCellValue('B' . $i, $order->name);
        $sheet->setCellValue('C' . $i, $order->phone ?? '');
        $sheet->setCellValue('D' . $i, $order->email ?? '');
        $sheet->setCellValue('E' . $i, $order->date ?? '');
        $sheet->setCellValue('F' . $i, $order->time ?? '');
        $sheet->setCellValue('G' . $i, $order->type_oplata ?? '');
        $sheet->setCellValue('J' . $i, $order->dostavka ?? '');
        $sheet->setCellValue('K' . $i, $order->status->name ?? '');
        
        // Запись товаров
        $products = $order->basket?->productsinbasket;
        if ($products) {
            $lastRow = $i;
            foreach ($products as $product) {
                $sheet->setCellValue('H' . $lastRow, $product->product->name);
                $sheet->setCellValue('I' . $lastRow, $product->count);
                $lastRow++;
            }
            $i = $lastRow;
        } else {
            $i++;
        }
    }
    
    $lastRow = $i - 1;
    
    // Добавление границ ко всем ячейкам с заголовками и данными
    $sheet->getStyle("A1:K{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    
    // Выравнивание всех ячеек по левому краю
    $sheet->getStyle("A1:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    // Установка ширины столбцов
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->getColumnDimension('C')->setWidth(23);
    $sheet->getColumnDimension('D')->setWidth(30);
    $sheet->getColumnDimension('E')->setWidth(18);
    $sheet->getColumnDimension('F')->setWidth(20);
    $sheet->getColumnDimension('G')->setWidth(18);
    $sheet->getColumnDimension('H')->setWidth(30);
    $sheet->getColumnDimension('I')->setWidth(15);
    $sheet->getColumnDimension('J')->setWidth(25);
    $sheet->getColumnDimension('K')->setWidth(15);
    
    $writer = new Xlsx($spreadsheet);
    $filename = 'orders_' . date('Y-m-d_H-i-s') . '.xlsx';
    $temp_file = tempnam(sys_get_temp_dir(), 'orders_export_') . '.xlsx';
    $writer->save($temp_file);
    return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
}
    private function getOrders(Request $request)
    {
        $ordersQuery = Order::select(
            'id',
            'basket_id',
            'name',
            'phone',
            'email',
            'date',
            'time',
            'dostavka',
            'type_oplata',
            'status_id',
            
        );
        //выгрузка бд по статусу выбранному 
        if (!empty($statusFilter)) {
            $ordersQuery->where('status', $statusFilter);
        }
        $orders = $ordersQuery->get();
        return $orders;
    }
}
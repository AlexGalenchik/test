<?php	
//include_once('../config.php');
//include_once('../functions.php');
//session_start();

//if ($_GET['do']==1) {


$arr = array(
    array(
        'data' => '2017-10-02',
        'name' => 'Иван',
        'age' => 30,
        'username' => 'Ivan',
        'balance' => 1000
    ),
    array(
        'data' => '2018-05-05',
        'name' => 'Олег',
        'age' => 25,
        'username' => 'Oleg',
        'balance' => 12000
    ),
    array(
        'data' => '2016-04-05',
        'name' => 'Вася',
        'age' => 19,
        'username' => 'vasa',
        'balance' => 9000
    )
);


$titles = array(
   array(
       'name' => 'Дата',
       'cell' => 'A'
    ),
    array(
        'name' => 'Имя',
        'cell' => 'B'
    ),
    array(
        'name' => 'Возраст',
        'cell' => 'C'
    ),
    array(
        'name' => 'Логин',
        'cell' => 'D'
    ),
    array(
        'name' => 'Баланс',
        'cell' => 'E'
    ),
);
// подлючение Classes PHPExcel
require_once ('./Classes/PHPExcel.php');
// создаем класс
$phpexcel = new PHPExcel();


// выводим шапку
for($i=0; $i<count($titles); $i++){
    $string=$titles[$i]['name'];
    $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");
    $cellLetter = $titles[$i]['cell'] . 2;
    $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
}
$i=3;
$totalBalance = 0;

//заполняем содержимое файла
foreach ($arr as $row) {
  $data = new DateTime($row['date']);
  $data = $data->format('d.m.Y');
  $phpexcel->getActiveSheet()->setCellValueExplicit("A$i", $data, PHPExcel_Cell_DataType::TYPE_STRING);
  $string = $row['name'];
  $string = mb_convert_encoding($string, "UTF-8", "Windows-1251");
  $phpexcel->getActiveSheet()->setCellValueExplicit("B$i", $string, PHPExcel_Cell_DataType::TYPE_STRING);
  $phpexcel->getActiveSheet()->setCellValueExplicit("C$i", $row['age']);
    $string = $row['username'];
    $string = mb_convert_encoding($string, "UTF-8", "Windows-1251");
    $phpexcel->getActiveSheet()->setCellValueExplicit("D$i", $string, PHPExcel_Cell_DataType::TYPE_STRING);
    $phpexcel->getActiveSheet()->setCellValueExplicit("E$i", $row['balance']);
    $totalBalance += $row['balance'];
    $i++;
};

//алтернативное заполнение массива
    //Вставить данные(примеры)
    //Нумерация строк начинается с 1, координаты A1 - 0,1
//    $active_sheet->setCellValueByColumnAndRow(0, 1, 'Сегодня '.date('d-m-Y'));
//    $active_sheet->setCellValue('A3', 'id');
//    $active_sheet->setCellValue('B3', 'name');
//    $active_sheet->setCellValue('C3', 'info');
//
//    //Вставка данных из выборки
//    $start = 4;
//    $i = 0;
//    foreach($l as $row_l){
//        $next = $start + $i;
//
//        $active_sheet->setCellValueByColumnAndRow(0, $next, $row_l['id']);
//        $active_sheet->setCellValueByColumnAndRow(1, $next, $row_l['name']);
//        $active_sheet->setCellValueByColumnAndRow(2, $next, $row_l['info']);
//
//        $i++;
//    };


$cellNum = $i+1;
//вывод суммы баланса и его форматирование
$phpexcel->getActiveSheet()->setCellValue("E$cellNum", $totalBalance);
$phpexcel->getActiveSheet()->getStyle("E2:E$cellNum")->getNumberFormat()->setFormatCode('#, ##0.00');

// размеры ячеек
$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

// называем активную страницу
$page = $phpexcel->SetActiveSheetIndex();
//ориентация и размер страницы
$page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);
// название страницы
$page->setTitle('main');
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
// называем имя файла
$filename="rent.xlsx";

//    echo "<pre>";
//     var_dump($totalBalance);
//    echo "</pre>";


//пишем хеадеры для скачивания файла
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

//отправка файла
$objWriter->save('php://output');

//пишем код ниже если хотим сохранять файл в 1 место и перезаписывать его
// если файл существует - удалем и сохранем новый
//if(file_exists($filename)){
//    unlink($filename);
//}

// сохранение файла
//$objWriter->save($filename);

//};


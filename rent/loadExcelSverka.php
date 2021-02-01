<?php
include_once '/core/config.php';
include_once '/core/function.php';
include_once '../config.php';
session_start();

// текущая дата
$today_time = date('d-m-Y');
//Создание выгрузки по истекшим договорам
$filename = 'no_rent_' . $today_time . '.xlsx';

header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

$conn = connect(); // Подключение к БД
//////////////////////////////////////ОТСУТСВУЮЩИЕ ДОГОВОРА////////////////////////////////////////////////////////////////////////////////////
//$rent = make_array('rent', 'number', $conn, '');
//Функция, которая формирует массив из уникальных значений номеров объектов
function make_array($table, $column, $conn, $column3)
{
    $db_conn = connect(); // Подключение к БД
	$sql = "SELECT DISTINCT $column FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE $column3 like 'МТС Арендует РПС'";
		}
		$sql .= " ORDER BY Id";
	 
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row[$column];
			
	}
	return $a; 
}

//Функция формирует массив из уникальных значений БС с адресами
function make_array2($table, $column1, $column2, $conn, $column3)
{
    $db_conn = connect(); // Подключение к БД
    $sql = "SELECT DISTINCT $column1, $column2 FROM $table";
    if ($column3 !== '') {
        $sql .= " WHERE  $column3 like 'МТС Арендует РПС' ";
    }
    $sql .= " ORDER BY $column1";
    $query = mysqli_query($db_conn, $sql);
    $a = [];
    // Заношу данные выгрузки из базы в массив DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $row = mysqli_fetch_assoc($query);
        $a[$row[$column1]] = $row[$column2];
    }
    return $a;
}

///////////////////////////////////////////////////////////////////
//Формирование массива номеров объектов из стороннего файла емкости
//Создаем массив уникальных номеров БС и таблицы емкости сети
$emkost = make_array('emkost_seti', 'bts_number', $conn, '');

//echo "БД Емкость сети<pre>";
//print_r($emkost);
//echo "</pre>";

//Создаем массив уникальных номеров БС и адресов из емкости сети
$emkost2 = make_array2('emkost_seti', 'bts_number', 'adress', $conn, '');

//echo "Адреса из Емкости сети<pre>";
//print_r($emkost2);
//echo "</pre>";

//Создаем массив Подвижных БС из емкости сети
$emkost_PBS = [
    7001,
    7002,
    7004,
    8001,
    8002,
    8003,
    2000,
    2001,
    2002,
    2003,
    2004,
    2005,
    2006,
    2007,
];

//echo "БД ПБС<pre>";
//print_r($emkost_PBS);
//echo "</pre>";

//Формирование массива номеров объектов из БД RENT
$rent = make_array('rent', 'number', $conn, 'type_arenda');

//echo "База Договоров - МТС Арендует РПС<pre>";
//print_r($rent);
//echo "</pre>";

//Формирование массива номеров объектов БД ЗЕМЛИ
$land = make_array('land_docs_minsk', 'bts', $conn, '');

//echo "БД Земли полностью<pre>";
//print_r($land);
//echo "</pre>";

//Массив $nedostatok содержит элементы массива из файла емкости, которые не вошли в БД rent и в БД Land и в массив Подвижный БС (ПБС не учитываем при сверке)
$nedostatok = array_diff($emkost, $rent, $land, $emkost_PBS);

//Запрос совмещенный для сбора данных из таблиц delta_sverka и delta_info
$sql =
    " SELECT
		delta_sverka.Id, 
		delta_sverka.bts_num,
		delta_sverka.adress,
		delta_info.info,
		delta_info.events,	
		delta_info.srok,			
		delta_info.ispolnitel
		FROM delta_sverka
		LEFT JOIN delta_info
		ON delta_sverka.bts_num = delta_info.bts_num
		WHERE delta_sverka.bts_num IN (" .
    implode(',', $nedostatok) .
    ')';

$query = mysqli_query($conn, $sql);

$data2 = [];
// Заношу данные выгрузки из базы в массив DATA
for ($i = 0; $i < mysqli_num_rows($query); $i++) {
    $row = mysqli_fetch_assoc($query);
    $data2[] = $row;
}

//echo "<pre>";
//var_dump($data2);
//echo "</pre>";

////////////////////////////////////////////////////////////////////////ВЫВОД в EXCEL  нет ДОГОВРОВ /////////////////////////////////////////////////////////////////
// подлючение Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_no_rent.xlsx');

// массив столбцов Для листа 2
$abc2 = ['A', 'B', 'C', 'D', 'E','F','G'];

//заполняем содержимое файла для листа 2
$k = 0;
for ($i = 0; $i < count($data2); $i++) {
    $arrValue = [];

    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($data2[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;

    for ($s = 0; $s < count($abc2); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc2[$s] . $k;

        // задаем формат числа для выгрузки в эксель
        $string = mb_convert_encoding($string, 'UTF-8', 'Windows-1251');
        $phpexcel
            ->getActiveSheet()
            ->setCellValueExplicit(
                "$cellLetter",
                $string,
                PHPExcel_Cell_DataType::TYPE_STRING
            );
    }
}

// называем активную страницу
$page = $phpexcel->SetActiveSheetIndex();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);
// название страницы
$page->setTitle('NO_DOGOVORS');

// форматируем вывод данных

// вычисляем последнию ячейку в таблице
$lastCell = count($data2) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];


// Ширина столбца  
$page->getColumnDimension("D")->setWidth(100);
$page->getColumnDimension("E")->setWidth(100);


// форматы страницы 

$page->getStyle("A1:G$lastCell")->applyFromArray($border);

$page->getStyle("A1:G$lastCell")->getAlignment()->setWrapText(true); 


//автоширина
//for ($s = 0; $s < count($abc2); $s++) {
//    $page->getColumnDimension("$abc2[$s]")->setAutoSize(true);
//}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../history_reports/$filename");

exit();

//////////////////////////////////////////////////////////////КОНЕЦ ВЫВОДА в EXCEL////////////////////////////////////////////////////////////////////
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
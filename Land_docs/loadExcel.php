<?php
include_once('../config.php');
include_once('../functions.php');
session_start();
$filename="list.xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

function connect(){
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
    // кодировка
    mysqli_set_charset($conn, "cp1251");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
$conn = connect();
//выбор данных из таблицы в виде массива

    function selectAll($conn)    {

        // получение данных из БД
         $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //Фильтр по Области
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //Фильтр по Району
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //Фильтр по Району
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //Фильтр по номеру БС
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //Фильтр по номеру БС
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //Фильтр по номеру БС
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //Фильтр по номеру БС
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //Фильтр по номеру БС
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //Фильтр по номеру БС
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //Фильтр по номеру БС
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { 
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (raion LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR nas_punkt LIKE '%" . $_SESSION['adsearch'] . "%'
			OR bts LIKE '%" . $_SESSION['adsearch'] . "%'
			OR adress LIKE '%" . $_SESSION['adsearch'] . "%'
			OR type_opori LIKE '%" . $_SESSION['adsearch'] . "%'
			OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%'
			OR notes LIKE '%" . $_SESSION['adsearch'] . "%')";
    }

        $sql.=" ORDER BY dogovor_finish";

        $result = mysqli_query($conn, $sql);
        $a = array();
        if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$a[] = $row;
			}
			
		}
        return $a;
    }

    $dataAll = selectAll($conn);
	
//echo "<pre>";
//var_dump($dataAll);
//echo "</pre>";	
	
	    //////////////////////// вывод excel
// подлючение Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// создаем класс
    $phpexcel = new PHPExcel();
//$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_temlates.xlsx'); //«агружаем "шаблонный" xls
// массив столбцов
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L','M','N','O','P','Q','R','S', 'T','U','V','W','X','Y','Z','AA'];
	  
//заполн¤ем содержимое файла
    $k=0;
    for($i=0; $i < count($dataAll); $i++) {
		$arrValue =[];
		
//заполн¤ем массив значени¤ми и убираем не нужные дл¤ вывода пол¤
        foreach ($dataAll[$i] as $key => $value) {
			array_push($arrValue,$value);
		}
		
		$k=$i+2;
		
		

        for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
			
			
						
				   
			// задаем формат числа дл¤ выгрузки в эксель
			
			
              if (
			    
			  ($abc[$s] == "A" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "J" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "L" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "M" && isset($arrValue[$s]) && $arrValue[$s] != 0) 
              

			  )	  {
				  $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                   }

            else {
                $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");

                $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            }
			
			
			

			
        }

}

//    echo "<pre>";
//	print_r($arrValue);
//	echo "</pre>";

   


    // называем активную страницу
    $page = $phpexcel->SetActiveSheetIndex();
//// јвто ширина колонки по содержимому
//$page->getColumnDimensionByColumn("H")->setAutoSize(true);
//// Ўирина столбца A
//$page->getColumnDimension("A")->setWidth(700);

// «аписываем данные в ¤чейку
//$date = date('d.m.Y');
//$page->setCellValue('A1', $date);
// ”станавливает формат данных в ¤чейке (дата вида дд-мм-гггг)
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);




//ориентаци¤ и размер страницы
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
    $page->getRowDimension('1')->setRowHeight(30);
// название страницы
    $page->setTitle('Land');

//    // форматируем вывод данных


// вычисл¤ем последнию ¤чейку в таблице
$lastCell = count($dataAll)+1;
    // рисуем границы таблицы
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
$page->getStyle("A1:AA$lastCell")->applyFromArray($border);


//автоширина
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}
//дл¤ двух колонок делаем вручную
//$page->getColumnDimension("AL")->setAutoSize(false);
//$page->getColumnDimension("AM")->setAutoSize(false);
//$page->getColumnDimension("I")->setWidth(80);
//$page->getColumnDimension("AK")->setWidth(80);

//переносы
//$page->getStyle("AK")->getAlignment()->setWrapText(true);
//$page->getStyle("AL")->getAlignment()->setWrapText(true);
//$page->getStyle("AR")->getAlignment()->setWrapText(true);

    $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//    $objWriter->save('php://output');
$objWriter->save('php://output');

    // если файл существует - удалем и сохранем новый
//if(file_exists($filename)){
//    unlink($filename);
//}

// сохранение файла
//$objWriter->save($filename);


    exit();

 ?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
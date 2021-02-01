<?php
include_once('../config.php');
include_once('../functions.php');
session_start();
$filename="list.xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

 /* 

$reg_user = $_SESSION['reg_user'];

var_dump($reg_user);
echo "<br/>";
var_dump($_SESSION['reg_user']);

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "----------------------------------------------------------------------------------<br/>";

echo "USER_REG = ";
print_r($_SESSION['reg_user']);
echo "<br/>";
echo "Region = ";
print_r($_SESSION['reg']);
echo "<br/>";
echo "Division = ";
print_r($_SESSION['division']);
echo "<br/>";

*/

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

   /* function selectAll($conn)    {
		
			$sql = "SELECT * FROM  rent WHERE Id is not NULL ";

        // получение данных из БД
        If ($_SESSION['reg_user'] == 'Админ') {  

			If(!empty($_SESSION['division'])) {
				
			$sql.= " AND division like '". $_SESSION['division'] ."' ";
			
			}
			If (!empty($_SESSION['reg'])) {
			
			$sql.= " AND region like '". $_SESSION['reg'] ."' ";
			
			}
		         
			
        } else {
			
			$sql.= " AND division like '". $_SESSION['reg_user'] ."'  ";
		}
			
			
			$sql.= " AND dogovor_number LIKE '". $_SESSION['dog'] . "' "; 
            
				
		
//var_dump($sql);
//echo "<br/>";
//echo "<br/>";

        $result = mysqli_query($conn, $sql);
        $a = array();
        if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$a[] = $row;
			}
			
		}
        return $a;
}

*/

 function selectAll($conn)    {
	 
			
        // получение данных из БД
		
        If ($_SESSION['reg_user'] != 'ОАДО' || $_SESSION['reg_user'] != 'Гродненская' || $_SESSION['reg_user'] != 'Гомельская' || 
		$_SESSION['reg_user'] != 'Могилевская' || $_SESSION['reg_user'] != 'Витебская' || $_SESSION['reg_user'] != 'Брестская' || $_SESSION['reg_user'] != 'УРС') 
		{ //Если зашел не Администратор, то он должен видеть только свое подразделение
		
			$sql = " SELECT * FROM rent WHERE Id is not NULL ";	
			
			If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
            $sql.= " AND region like '".$_SESSION['reg']."' ";}
				
			If (!empty($_SESSION['division'])) { //Фильтр по подразделению
			$sql.= " AND division like '" . $_SESSION['division'] . "'   ";}
           
			
		
		} else {
			
			$sql = " SELECT * FROM rent WHERE division like '".$_SESSION['reg_user']."' "; //Если это не администратор, то он видит всегда свою область	
           
        }

        If (!empty($_SESSION['Areas'])) { //Фильтр по району
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Договора
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
		If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
            $sql.= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ///////////////////////////////////////////////////////////////////////////////////////////////////////////
			$sql.= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
			$sql.= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
			$sql.= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
			$sql.= ") ";
		
    }

        If (!empty($_SESSION['type_currency'])) { //Фильтр по типу площадки
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //Фильтр по дате начала действия Договора
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //Фильтр по дате окончания действия Договора
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
            $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        }

        If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
			$sql.= " AND dogovor_number LIKE '". $_SESSION['dog'] . "' "; 
	
        If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
            $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
		}

        $sql.=" ORDER BY number";
		
		//var_dump($sql);
		//echo "<br/>";
		//var_dump($reg_user == 'Админ');
		//echo "<br/>";

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
$phpexcel = $objReader->load('./templates/list_temlates.xlsx'); //Загружаем "шаблонный" xls
// массив столбцов
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L','M','N','O','P','Q','R','S', 'T','U','V','W','X','Y','Z',
      'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU'];
	  
$numeric_columns = ['P','Q','R','S','T','U','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AP'];// Колонки с числовыми значениями


 // создаем массив ключей и заполняем его (из 1 строчки выбираем все ключи)
  // $keyArr=[];
   
  // foreach ($dataAll[0] as $key => $value) {
 //      array_push($keyArr, $key);   
 //  }
   
	//	echo "<pre>";
	//	print_r($keyArr);
	//	echo "</pre>";

// выводим шапку
//    for($i=0; $i < count($abc); $i++){
//        $string = $keyArr[$i];
//        $cellLetter = $abc[$i] . 1;
//        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
//    }

    //заполняем содержимое файла
    $k=0;
    for($i=0; $i < count($dataAll); $i++) {
		$arrValue =[];
		
//        заполняем массив значениями и убираем не нужные для вывода поля
        foreach ($dataAll[$i] as $key => $value) {
			If ($key == "dogovor_AKO" || $key == "prichiny_AKO" || $key == "summa" || $key == "type_currency" || $key == "nds2") {
				continue;
			} 
				else {
					array_push($arrValue,$value);
				}
		}
		
		//echo "<pre>";
		//print_r($dataAll[$i]);
		//echo "</pre>";

        $k=$i+2;
		
		

        for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
			
			
					//	 echo "<pre>";
					// print_r( $abc[$s] . "_" . $s . "==" . $arrValue[$s] . "==" .  $cellLetter);
						//print_r( $abc[$s] == "AP" AND isset($arrValue[$s]) );
					//	 echo "</pre>";
				   
				
				   
			// задаем формат числа для выгрузки в эксель
			
			
              if (
			    
			  ($abc[$s] == "P" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "Q" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "R" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "S" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR
              ($abc[$s] == "T" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "U" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "X" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "Y" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "Z" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR
              ($abc[$s] == "AA" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AB" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AC" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AD" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR
              ($abc[$s] == "AE" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AF" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AG" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AH" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR
              ($abc[$s] == "AI" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AJ" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AP" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AV" && isset($arrValue[$s]) && $arrValue[$s] != 0) OR 
			  ($abc[$s] == "AX" && isset($arrValue[$s]) && $arrValue[$s] != 0)

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
//// Авто ширина колонки по содержимому
//$page->getColumnDimensionByColumn("H")->setAutoSize(true);
//// Ширина столбца A
//$page->getColumnDimension("A")->setWidth(700);

// Записываем данные в ячейку
//$date = date('d.m.Y');
//$page->setCellValue('A1', $date);
// Устанавливает формат данных в ячейке (дата вида дд-мм-гггг)
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);




//ориентация и размер страницы
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
    $page->getRowDimension('1')->setRowHeight(30);
// название страницы
    $page->setTitle('main');

//    // форматируем вывод данных


// вычисляем последнию ячейку в таблице
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
$page->getStyle("A1:AU$lastCell")->applyFromArray($border);


//автоширина
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}
//для двух колонок делаем вручную
//$page->getColumnDimension("AL")->setAutoSize(false);
//$page->getColumnDimension("AM")->setAutoSize(false);
//$page->getColumnDimension("AL")->setWidth(30);
//$page->getColumnDimension("AM")->setWidth(30);
//переносы
$page->getStyle("AN")->getAlignment()->setWrapText(true);
$page->getStyle("AM")->getAlignment()->setWrapText(true);

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
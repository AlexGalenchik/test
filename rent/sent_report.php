<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

// текущая дата
$today_time = date("d-m-Y");
$filename="BELARUS_".$today_time.".xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

$conn = connect(); // Подключение к БД

///////////////////////////////////////////////////////////// БЛОК ФУНКЦИЙ
//1. Функция для выборки договоров из БД RENT
Function finish_dog ($object, $table, $finish_date, $month) {
	$db_conn = connect(); // Подключение к БД
	$sql = " SELECT Id, type, $object, region, area, settlement, adress, dogovor_number, dogovor_date, start_date_dogovor, finish_date_dogovor, division
	FROM $table
	WHERE $finish_date BETWEEN (CURRENT_DATE()) AND  (CURRENT_DATE() - INTERVAL - ".$month." MONTH) ORDER BY $finish_date ";
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a;

}

//1. Определяем объекты, у которых заканчиваются договора в ближайшие 3 месяца
$month = 3; // Выбранное количество месяцев
$data = finish_dog ('number','rent','finish_date_dogovor', $month);

//2. Функция для выборки договоров, которые не вошли в Базы данных (результаты сверки)
//взял код из файла sverka.php
 //Функция, которая формирует массив из уникальных значений номеров объектов
 Function make_array ($table,$column,$conn,$column3) {
	$db_conn = connect(); // Подключение к БД 
	$sql = "SELECT DISTINCT $column FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like 'МТС арендует'";
		}
		$sql .= " ORDER BY $column";
	 
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
 Function make_array2 ($table,$column1,$column2, $conn, $column3) {
	$db_conn = connect(); // Подключение к БД  
	$sql = "SELECT DISTINCT $column1, $column2 FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like 'МТС арендует'";
		}
		$sql .= " ORDER BY $column1";
	 
	 
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i < mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[$row[$column1]] = $row[$column2];
 
			
	}
	return $a; 
	 
}

///////////////////////////////////////////////////////////////////
//Формирование массива номеров объектов из стороннего файла емкости

//Создаем массив уникальных номеров БС и таблицы емкости сети
$emkost = make_array ('emkost_seti','bts_number',$conn,'');

//Создаем массив уникальных номеров БС и адресов из емкости сети
$emkost2 = make_array2 ('emkost_seti','bts_number','adress',$conn,'');

//Создаем массив Подвижных БС из емкости сети
$emkost_PBS = [7001,7002,7004,8001,8002,8003,2000,2001,2002,2003,2004,2005,2006,2007];

//Формирование массива номеров объектов из БД RENT

$rent = make_array ('rent','number',$conn, 'type_arenda');

//Формирование массива номеров объектов БД ЗЕМЛИ

$land = make_array ('land_docs_minsk','bts',$conn,'');

//Массив $nedostatok содержит элементы массива из файла емкости, которые не вошли в БД rent и в БД Land и в массив Подвижный БС (ПБС не учитываем при сверке)

$nedostatok = array_diff($emkost,$rent,$land,$emkost_PBS);

//echo "<pre>";
//var_dump($nedostatok);
//echo "</pre>";

//Запрос совмещенный для сбора данных из таблиц delta_sverka и delta_info
$sql = " SELECT
		delta_sverka.Id, 
		delta_sverka.bts_num,
		delta_sverka.adress,
		delta_info.info,
		delta_info.ispolnitel
		FROM delta_sverka
		LEFT JOIN delta_info
		ON delta_sverka.bts_num = delta_info.bts_num
		WHERE delta_sverka.bts_num IN (".implode(",",$nedostatok).")";
		 	
	$query =  mysqli_query($conn, $sql);
	
	$data2 = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$data2[] = $row;
			
	}
	
////////////////////////////////////////////////////////////////////////ВЫВОД в EXCEL /////////////////////////////////////////////////////////////////


 //////////////////////// вывод excel
// подлючение Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// создаем класс
    $phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx'); //Загружаем "шаблонный" xls (подготовлено 2 листа)

// ЛИСТ 1.Создание выгрузки по истекшим договорам
// массив столбцов Для листа 1
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L'];

   //заполняем содержимое файла для листа 1
    $k=0;
for($i=0; $i < count($data); $i++) {
		$arrValue =[];
		
//        заполняем массив значениями и убираем не нужные для вывода поля
        foreach ($data[$i] as $key => $value) {
				array_push($arrValue,$value);
		}
		$k=$i+2;
		
		for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
			
	// задаем формат числа для выгрузки в эксель
	    $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");
        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            
		}

}

	// называем активную страницу (лист 1)
	$page = $phpexcel->SetActiveSheetIndex();

//ориентация и размер страницы
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
    $page->getRowDimension('1')->setRowHeight(30);
// название страницы
    //$page->setTitle('FINISH_DOGOVORS');

// форматируем вывод данных


// вычисляем последнию ячейку в таблице
$lastCell = count($data)+1;
    // рисуем границы таблицы
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
$page->getStyle("A1:L$lastCell")->applyFromArray($border);


//автоширина
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ЛИСТ 2.Создание выгрузки по недостающим договорам и причины
// массив столбцов Для листа 2
$abc2=['A','B','C','D','E'];
	  
   //заполняем содержимое файла для листа 2
    $k=0;
for($i=0; $i < count($data2); $i++) {
		$arrValue =[];
		
//        заполняем массив значениями и убираем не нужные для вывода поля
        foreach ($data2[$i] as $key => $value) {
				array_push($arrValue,$value);
		}
		$k=$i+2;
		
		for($s=0; $s < count($abc2); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc2[$s] . $k;
			
	// задаем формат числа для выгрузки в эксель
	    $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");
        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            
		}

}

// называем активную страницу (Новую Лист 2)
    $page = $phpexcel->SetActiveSheetIndex();

//ориентация и размер страницы
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
    $page->getRowDimension('1')->setRowHeight(30);
// название страницы
    //$page->setTitle('NO_DOGOVORS');

// форматируем вывод данных


// вычисляем последнию ячейку в таблице
$lastCell = count($data2)+1;
    // рисуем границы таблицы
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
    $page->getStyle("A1:E$lastCell")->applyFromArray($border);


//автоширина
for($s=0; $s < count($abc2); $s++) {
    $page->getColumnDimension("$abc2[$s]")->setAutoSize(true);
}



// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

//////////////////////////////////////////////////////////////КОНЕЦ ВЫВОДА в EXCEL////////////////////////////////////////////////////////////////////

//2. Определяем объекты, у которых заканчиваются договора в ближайшие 3-6 месяцев и отправляем по почте сообщение в рассылку

// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($data);

// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
 

// прописать путь к файлу и написать его имя
                //$picture = 'Docoment_2020.xlsx';
				  $picture = "../reports/".$filename."";
				// функция отправки сообщения с файлом

            function send_mail($to, $tema, $html, $path, $filename) {
                $fp = fopen($path,"r");
                if (!$fp){
                    print "Файл $path не может быть прочитан";
                    exit();
                }
                $file = fread($fp, filesize($path));
//                var_dump(filesize($path));
                fclose($fp);



                $boundary = "--".md5(uniqid(time())); // генерируем разделитель
                $headers = "MIME-Version: 1.0\n";
                $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
                $multipart = "--$boundary\n";
//                $kod = 'windows-1251'; // или $kod = 'koi8-r';
                $kod = 'cp1251'; // или $kod = 'koi8-r';
                $multipart .= "Content-Type: text/html; charset=$kod\n";
                $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";
                $multipart .= "$html\n\n";
                $message_part = "--$boundary\n";
                $message_part .= "Content-Type: application/octet-stream\n";
                $message_part .= "Content-Transfer-Encoding: base64\n";
                $message_part .= "Content-Disposition: attachment; filename = \"".$filename."\"\n\n";
                $message_part .= chunk_split(base64_encode($file))."\n";
                $multipart .= $message_part."--$boundary--\n";
                if(!mail($to, $tema, $multipart, $headers)){
                    echo "К сожалению, письмо не отправлено";
                    exit();
                }
            }


//            $name = 'Pavel';
			
            $email = 'rent@mts.by';
            $message_mail = "Добрый день!" . "<br><br>" . "Я работ Rent который помогает Вам не забывать перезаключать договора.<br> 
             В ближайшие <b>".$month."</b> месяца завершится срок действия  у <b>".$count1."</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>".$count2."</b> объектах отсутсвуют заключенные Договора, советую Вам их побыстрее заключить. 
             <br> Хорошей работы и бодрости духа в предстоящей работе!<br><br>С уважением, Ваш друг робот Rent
             <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//                $to = "uscharov@mail.ru"; // емайл получателя данных из формы
                $to = "usharov@mts.by, galenchik@mts.by"; // емайл получателя данных из формы
				$tema = "Истекащие договора аренды";
                $tema = iconv('cp1251','utf-8',$tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
                $message = $message_mail ; //полученное из формы name=message

                // Отправляем почтовое сообщение
                  if(send_mail($to, $tema, $message, $picture, $filename)) {
					  echo "<h1>Сообщение отправленно</h1>";
				  };

                  

      ?>
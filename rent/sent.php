<?php
include_once '/core/config.php';
include_once '/core/function.php';
include_once '../config.php';
session_start();

$brest_adr = 'ostrovsky@mts.by, levchenko@mts.by, imatveychuk@mts.by, ogorelov@mts.by, pryahin@mts.by, usharov@mts.by, galenchik@mts.by';
$vitebsk_adr = 'shefiev@mts.by, kuksenok@mts.by, starikov@mts.by, ezdanovskaya@mts.by, usharov@mts.by, galenchik@mts.by';
$gomel_adr = 'vlasov@mts.by, lexx@mts.by, isivolobov@mts.by, rudnickaya@mts.by, usharov@mts.by, galenchik@mts.by';
$grodno_adr = 'usharov@mts.by, galenchik@mts.by, dsherel@mts.by, skudruk@mts.by, ste@mts.by, smalinovskiy@mts.by';
$mogilev_adr = 'makaseev@mts.by, evreinov@mts.by, vshvec@mts.by, smakaseeva@mts.by, abondareva@mts.by, usharov@mts.by, galenchik@mts.by';
$minsk_adr = 'slizhevskij@mts.by, lobkov@mts.by, filipov@mts.by, kdk@mts.by, VAP@mts.by, apilipenko@mts.by, saharchuk@mts.by, yar@mts.by, yak@mts.by, nikol@mts.by, ekrolevec@mts.by, usharov@mts.by, galenchik@mts.by';
$urs_adr = 'mvs@mts.by, dsokolov@mts.by, asofronyuk@mts.by, poleshuk@mts.by, drojin@mts.by, vezhov@mts.by, itaran@mts.by, usharov@mts.by, galenchik@mts.by';
$nachalstvo = 'alex.tyazhkih@mts.by, uet@mts.by, prokopchuk@mts.by, usharov@mts.by, galenchik@mts.by';

$conn = connect(); // Подключение к БД

// функция отправки сообщения с файлом
function send_mail($to, $tema, $html, $path, $filename){
    $fp = fopen($path, 'r');
    if (!$fp) {
        print "Файл $path не может быть прочитан";
        exit();
    }
    $file = fread($fp, filesize($path));
    //                var_dump(filesize($path));
    fclose($fp);

    $boundary = '--' . md5(uniqid(time())); // генерируем разделитель
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
    $multipart = "--$boundary\n";
    //                $kod = 'windows-1251'; // или $kod = 'koi8-r';
    $kod = 'CP1251'; // или $kod = 'koi8-r';
    $multipart .= "Content-Type: text/html; charset=$kod\n";
    $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";
    $multipart .= "$html\n\n";
    $message_part = "--$boundary\n";
    $message_part .= "Content-Type: application/octet-stream\n";
    $message_part .= "Content-Transfer-Encoding: base64\n";
	
    $message_part .=
        "Content-Disposition: attachment; filename = \"" . $filename . "\"\n\n";
    $message_part .= chunk_split(base64_encode($file)) . "\n";
    $multipart .= $message_part . "--$boundary--\n";
    if (!mail($to, $tema, $multipart, $headers)) {
        echo 'К сожалению, письмо не отправлено';
        exit();
    }
}

/////////////////////////////////////////////////////////////    Функция для выборки договоров из БД RENT
function finish_dog($object, $table, $finish_date, $month, $division)
{
    $db_conn = connect(); // Подключение к БД
    $sql =
        " SELECT Id, type, $object, region, area, settlement, adress, dogovor_number, dogovor_date, start_date_dogovor, finish_date_dogovor, division
	FROM $table
	WHERE `division` like '$division' AND $finish_date BETWEEN (CURRENT_DATE()) AND  (CURRENT_DATE() - INTERVAL - " .
        $month .
        " MONTH) ORDER BY $finish_date ";

    $query = mysqli_query($db_conn, $sql);

    $a = [];
    // Заношу данные выгрузки из базы в массив DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $row = mysqli_fetch_assoc($query);
        $a[] = $row;
    }
    return $a;
}

// текущая дата
$today_time = date('d-m-Y');
// Выбранное количество месяцев
$month = 3;

$link = "<a href='http://10.128.217.135/rent/sverka.php'> ссылке </a>";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// подлючение Classes PHPExcel
require_once './Classes/PHPExcel.php';
// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx'); //Загружаем "шаблонный" xls (подготовлено 2 листа)



///////////////////////////////////////////////////ГОМЕЛЬ///////////////////////////////////////////////////////////////////////
$division = 'Гомельская';
$dataGomel = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';

//Создание выгрузки по истекшим договорам
$filename = 'Gomel_' . $today_time . '.xlsx';
// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;
for ($i = 0; $i < count($dataGomel); $i++) {
    $arrValue = [];
    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataGomel[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataGomel) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');

// сохранение файла
$objWriter->save("../reports/$filename");
 

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataGomel);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя

$picture = '../reports/' . $filename . '';
// от кого
$email = 'rent@mts.by';
$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";
			 
	
//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($gomel_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

///////////////////////////////////////////////////БРЕСТ///////////////////////////////////////////////////////////////////////
// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = 'Брестская';
$dataBrest = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename = 'Brest_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;
for ($i = 0; $i < count($dataBrest); $i++) {
    $arrValue = [];
    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataBrest[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataBrest) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataBrest);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';

$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";
			
//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла

$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($brest_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

///////////////////////////////////////////////////Витебск///////////////////////////////////////////////////////////////////////
// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');
$division = 'Витебская';
$dataVetib = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename = 'Vitebsk_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;
for ($i = 0; $i < count($dataVetib); $i++) {
    $arrValue = [];
    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataVetib[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataVetib) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataVetib);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';

$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($vitebsk_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

///////////////////////////////////////////////////Могилев///////////////////////////////////////////////////////////////////////

// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = 'Могилевская';
$dataMogil = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename =  'Mogilev_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;

// echo '<pre>';
// var_dump($arrValue);
// echo '</pre>';

for ($i = 0; $i < count($dataMogil); $i++) {
    $arrValue = [];

    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataMogil[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataMogil) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataMogil);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';
$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($mogilev_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

///////////////////////////////////////////////////Гродно///////////////////////////////////////////////////////////////////////
// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = 'Гродненская';
$dataGrod = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename = 'Grodno_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;


for ($i = 0; $i < count($dataGrod); $i++) {
    $arrValue = [];

    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataGrod[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataGrod) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataGrod);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';
$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($grodno_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

///////////////////////////////////////////////////Минск///////////////////////////////////////////////////////////////////////

// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = 'ОАДО';
$dataMin = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename = 'Minsk_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;

// echo '<pre>';
// var_dump($arrValue);
// echo '</pre>';

for ($i = 0; $i < count($dataMin); $i++) {
    $arrValue = [];

    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataMin[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataMin) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataMin);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';

$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             Также сообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, просмотр доступен по $link . 
            <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($minsk_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

/////////////////////////////////////////////////// УРС ///////////////////////////////////////////////////////////////////////

// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = 'УРС';
$dataURS = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//Создание выгрузки по истекшим договорам
$filename = 'URS_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// массив столбцов Для листа 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//заполняем содержимое файла для листа 1
$k = 0;

for ($i = 0; $i < count($dataURS); $i++) {
    $arrValue = [];

    //        заполняем массив значениями и убираем не нужные для вывода поля
    foreach ($dataURS[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
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
// называем активную страницу (лист 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//ориентация и размер страницы
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// высота строки
$page->getRowDimension('1')->setRowHeight(30);

// вычисляем последнию ячейку в таблице
$lastCell = count($dataURS) + 1;
// рисуем границы таблицы
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//автоширина
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// СОХРАНЕНИЕ ФАЙЛА в браузер (скачивание автоматическое)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($dataURS);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';

$message_mail =
    'Добрый день!' .
    '<br><br>' . " В ближайшие <b> $month</b> месяца завершится срок действия  у <b>$count1</b>  Договоров. Список этих Договоров я Вам пересылаю и их можно
             увидить во вложение моего письма. <br>
             <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";
			

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Истекащие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($urs_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>Сообщение отправленно</h1>';
}

//////////////////////////////////////ОТСУТСВУЮЩИЕ ДОГОВОРА////////////////////////////////////////////////////////////////////////////////////

//Функция, которая формирует массив из уникальных значений номеров объектов
function make_array($table, $column, $conn, $column3)
{
    $db_conn = connect(); // Подключение к БД
    $sql = "SELECT DISTINCT $column FROM $table";
    if ($column3 !== '') {
        $sql .= " WHERE  $column3 like 'МТС Арендует РПС'";
    }
    $sql .= " ORDER BY $column";
    $query = mysqli_query($db_conn, $sql);
    $a = [];
    // Заношу данные выгрузки из базы в массив DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
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
        $sql .= " WHERE  $column3 like 'МТС Арендует РПС'";
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

//Создаем массив уникальных номеров БС и адресов из емкости сети
$emkost2 = make_array2('emkost_seti', 'bts_number', 'adress', $conn, '');

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

//Формирование массива номеров объектов из БД RENT
$rent = make_array('rent', 'number', $conn, 'type_arenda');

//Формирование массива номеров объектов БД ЗЕМЛИ
$land = make_array('land_docs_minsk', 'bts', $conn, '');

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

$count2 = $_SESSION['nedostatok'];

//var_dump(count($data2));

////////////////////////////////////////////////////////////////////////ВЫВОД в EXCEL  нет ДОГОВРОВ /////////////////////////////////////////////////////////////////

// создаем класс
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_no_rent.xlsx');

//Создание выгрузки по истекшим договорам
$filename = 'no_rent_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

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
//$page->setTitle('NO_DOGOVORS');

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
//$objWriter->save('php://output');

// сохранение файла
$objWriter->save("../reports/$filename");

//////////////////////////////////////////////////////////////КОНЕЦ ВЫВОДА в EXCEL////////////////////////////////////////////////////////////////////

/////////   e-mail  /////////////////////
// необходимо подсчитать кол-во договоров завершаемых в ближайшие 3 месяца для вывода в сообщение
$count1 = count($data2);
// необходимо подситать кол-во БС без договоров
$count2 = $_SESSION['nedostatok'];
// прописать путь к файлу и написать его имя
$picture = '../reports/' . $filename . '';

// от кого
$email = 'rent@mts.by';

$message_mail =
    'Добрый день!' .
    '<br><br>' .
    "        Cообщаю, что на <b>$count2</b> объектах отсутсвуют заключенные Договора, возможно они находяться в Вашей отвествености, советую Вам их побыстрее заключить. 
             <br>Список этих Договоров я Вам пересылаю и их можно увидить во вложение моего письма или по $link . 
			
             <br><br><br>P.S.: сообщение сформированно автоматически и не требует ответа.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // емайл получателя данных из формы
$tema = 'Отсутсвующие договора аренды';
$tema = iconv('cp1251', 'utf-8', $tema); // тема полученного емайла
//                $message = "Ваше имя: " . $name . "<br>";//присвоить переменной значение, полученное из формы name=name
//                $message = "E-mail: " . $email . "<br>"; //полученное из формы name=email
$message = $message_mail; //полученное из формы name=message

// Отправляем почтовое сообщение
if (send_mail($nachalstvo, $tema, $message, $picture, $filename)) {
	echo '<h1>Сообщение отправленно</h1>';
}

echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
echo "<center><b>ДАННЫЕ ОТПРАВЛЕНЫ!</b></center>";
?>
<script>document.location.href="sverka.php"</script>

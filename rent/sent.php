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

$conn = connect(); // ����������� � ��

// ������� �������� ��������� � ������
function send_mail($to, $tema, $html, $path, $filename){
    $fp = fopen($path, 'r');
    if (!$fp) {
        print "���� $path �� ����� ���� ��������";
        exit();
    }
    $file = fread($fp, filesize($path));
    //                var_dump(filesize($path));
    fclose($fp);

    $boundary = '--' . md5(uniqid(time())); // ���������� �����������
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
    $multipart = "--$boundary\n";
    //                $kod = 'windows-1251'; // ��� $kod = 'koi8-r';
    $kod = 'CP1251'; // ��� $kod = 'koi8-r';
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
        echo '� ���������, ������ �� ����������';
        exit();
    }
}

/////////////////////////////////////////////////////////////    ������� ��� ������� ��������� �� �� RENT
function finish_dog($object, $table, $finish_date, $month, $division)
{
    $db_conn = connect(); // ����������� � ��
    $sql =
        " SELECT Id, type, $object, region, area, settlement, adress, dogovor_number, dogovor_date, start_date_dogovor, finish_date_dogovor, division
	FROM $table
	WHERE `division` like '$division' AND $finish_date BETWEEN (CURRENT_DATE()) AND  (CURRENT_DATE() - INTERVAL - " .
        $month .
        " MONTH) ORDER BY $finish_date ";

    $query = mysqli_query($db_conn, $sql);

    $a = [];
    // ������ ������ �������� �� ���� � ������ DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $row = mysqli_fetch_assoc($query);
        $a[] = $row;
    }
    return $a;
}

// ������� ����
$today_time = date('d-m-Y');
// ��������� ���������� �������
$month = 3;

$link = "<a href='http://10.128.217.135/rent/sverka.php'> ������ </a>";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ���������� Classes PHPExcel
require_once './Classes/PHPExcel.php';
// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx'); //��������� "���������" xls (������������ 2 �����)



///////////////////////////////////////////////////������///////////////////////////////////////////////////////////////////////
$division = '����������';
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

//�������� �������� �� �������� ���������
$filename = 'Gomel_' . $today_time . '.xlsx';
// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;
for ($i = 0; $i < count($dataGomel); $i++) {
    $arrValue = [];
    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataGomel[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataGomel) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');

// ���������� �����
$objWriter->save("../reports/$filename");
 

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataGomel);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���

$picture = '../reports/' . $filename . '';
// �� ����
$email = 'rent@mts.by';
$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";
			 
	
//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($gomel_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

///////////////////////////////////////////////////�����///////////////////////////////////////////////////////////////////////
// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = '���������';
$dataBrest = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename = 'Brest_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;
for ($i = 0; $i < count($dataBrest); $i++) {
    $arrValue = [];
    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataBrest[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataBrest) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataBrest);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';

$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";
			
//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������

$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($brest_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

///////////////////////////////////////////////////�������///////////////////////////////////////////////////////////////////////
// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');
$division = '���������';
$dataVetib = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename = 'Vitebsk_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;
for ($i = 0; $i < count($dataVetib); $i++) {
    $arrValue = [];
    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataVetib[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataVetib) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataVetib);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';

$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($vitebsk_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

///////////////////////////////////////////////////�������///////////////////////////////////////////////////////////////////////

// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = '�����������';
$dataMogil = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename =  'Mogilev_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;

// echo '<pre>';
// var_dump($arrValue);
// echo '</pre>';

for ($i = 0; $i < count($dataMogil); $i++) {
    $arrValue = [];

    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataMogil[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataMogil) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataMogil);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';
$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($mogilev_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

///////////////////////////////////////////////////������///////////////////////////////////////////////////////////////////////
// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = '�����������';
$dataGrod = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename = 'Grodno_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;


for ($i = 0; $i < count($dataGrod); $i++) {
    $arrValue = [];

    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataGrod[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataGrod) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataGrod);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';
$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($grodno_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

///////////////////////////////////////////////////�����///////////////////////////////////////////////////////////////////////

// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = '����';
$dataMin = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename = 'Minsk_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;

// echo '<pre>';
// var_dump($arrValue);
// echo '</pre>';

for ($i = 0; $i < count($dataMin); $i++) {
    $arrValue = [];

    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataMin[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataMin) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataMin);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';

$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� �������� �� $link . 
            <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($minsk_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

/////////////////////////////////////////////////// ��� ///////////////////////////////////////////////////////////////////////

// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx');

$division = '���';
$dataURS = finish_dog(
    'number',
    'rent',
    'finish_date_dogovor',
    $month,
    $division
);

//�������� �������� �� �������� ���������
$filename = 'URS_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 1
$abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
//��������� ���������� ����� ��� ����� 1
$k = 0;

for ($i = 0; $i < count($dataURS); $i++) {
    $arrValue = [];

    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($dataURS[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;
    for ($s = 0; $s < count($abc); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc[$s] . $k;
        // ������ ������ ����� ��� �������� � ������
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
// �������� �������� �������� (���� 1)
$phpexcel->setActiveSheetIndex();
$page = $phpexcel->getActiveSheet();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);

// ��������� ��������� ������ � �������
$lastCell = count($dataURS) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$page->getStyle("A1:L$lastCell")->applyFromArray($border);

//����������
for ($s = 0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($dataURS);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';

$message_mail =
    '������ ����!' .
    '<br><br>' . " � ��������� <b> $month</b> ������ ���������� ���� ��������  � <b>$count1</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";
			

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '��������� �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($urs_adr, $tema, $message, $picture, $filename)) {
    echo '<h1>��������� �����������</h1>';
}

//////////////////////////////////////������������ ��������////////////////////////////////////////////////////////////////////////////////////

//�������, ������� ��������� ������ �� ���������� �������� ������� ��������
function make_array($table, $column, $conn, $column3)
{
    $db_conn = connect(); // ����������� � ��
    $sql = "SELECT DISTINCT $column FROM $table";
    if ($column3 !== '') {
        $sql .= " WHERE  $column3 like '��� �������� ���'";
    }
    $sql .= " ORDER BY $column";
    $query = mysqli_query($db_conn, $sql);
    $a = [];
    // ������ ������ �������� �� ���� � ������ DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $row = mysqli_fetch_assoc($query);
        $a[] = $row[$column];
    }
    return $a;
}

//������� ��������� ������ �� ���������� �������� �� � ��������
function make_array2($table, $column1, $column2, $conn, $column3)
{
    $db_conn = connect(); // ����������� � ��
    $sql = "SELECT DISTINCT $column1, $column2 FROM $table";
    if ($column3 !== '') {
        $sql .= " WHERE  $column3 like '��� �������� ���'";
    }
    $sql .= " ORDER BY $column1";
    $query = mysqli_query($db_conn, $sql);
    $a = [];
    // ������ ������ �������� �� ���� � ������ DATA
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $row = mysqli_fetch_assoc($query);
        $a[$row[$column1]] = $row[$column2];
    }
    return $a;
}

///////////////////////////////////////////////////////////////////
//������������ ������� ������� �������� �� ���������� ����� �������
//������� ������ ���������� ������� �� � ������� ������� ����
$emkost = make_array('emkost_seti', 'bts_number', $conn, '');

//������� ������ ���������� ������� �� � ������� �� ������� ����
$emkost2 = make_array2('emkost_seti', 'bts_number', 'adress', $conn, '');

//������� ������ ��������� �� �� ������� ����
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

//������������ ������� ������� �������� �� �� RENT
$rent = make_array('rent', 'number', $conn, 'type_arenda');

//������������ ������� ������� �������� �� �����
$land = make_array('land_docs_minsk', 'bts', $conn, '');

//������ $nedostatok �������� �������� ������� �� ����� �������, ������� �� ����� � �� rent � � �� Land � � ������ ��������� �� (��� �� ��������� ��� ������)
$nedostatok = array_diff($emkost, $rent, $land, $emkost_PBS);

//������ ����������� ��� ����� ������ �� ������ delta_sverka � delta_info
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
// ������ ������ �������� �� ���� � ������ DATA
for ($i = 0; $i < mysqli_num_rows($query); $i++) {
    $row = mysqli_fetch_assoc($query);
    $data2[] = $row;
}

$count2 = $_SESSION['nedostatok'];

//var_dump(count($data2));

////////////////////////////////////////////////////////////////////////����� � EXCEL  ��� �������� /////////////////////////////////////////////////////////////////

// ������� �����
$phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_no_rent.xlsx');

//�������� �������� �� �������� ���������
$filename = 'no_rent_' . $today_time . '.xlsx';
//$filename = iconv('cp1251', 'utf-8', $filename);

// ������ �������� ��� ����� 2
$abc2 = ['A', 'B', 'C', 'D', 'E','F','G'];

//��������� ���������� ����� ��� ����� 2
$k = 0;
for ($i = 0; $i < count($data2); $i++) {
    $arrValue = [];

    //        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
    foreach ($data2[$i] as $key => $value) {
        array_push($arrValue, $value);
    }
    $k = $i + 2;

    for ($s = 0; $s < count($abc2); $s++) {
        $string = $arrValue[$s];
        $cellLetter = $abc2[$s] . $k;

        // ������ ������ ����� ��� �������� � ������
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

// �������� �������� ��������
$page = $phpexcel->SetActiveSheetIndex();

//���������� � ������ ��������
$page
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
$page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
//$page->setTitle('NO_DOGOVORS');

// ����������� ����� ������

// ��������� ��������� ������ � �������
$lastCell = count($data2) + 1;
// ������ ������� �������
$border = [
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];


// ������ �������  
$page->getColumnDimension("D")->setWidth(100);
$page->getColumnDimension("E")->setWidth(100);


// ������� �������� 

$page->getStyle("A1:G$lastCell")->applyFromArray($border);

$page->getStyle("A1:G$lastCell")->getAlignment()->setWrapText(true); 


//����������
//for ($s = 0; $s < count($abc2); $s++) {
//    $page->getColumnDimension("$abc2[$s]")->setAutoSize(true);
//}

// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

//////////////////////////////////////////////////////////////����� ������ � EXCEL////////////////////////////////////////////////////////////////////

/////////   e-mail  /////////////////////
// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($data2);
// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
// ��������� ���� � ����� � �������� ��� ���
$picture = '../reports/' . $filename . '';

// �� ����
$email = 'rent@mts.by';

$message_mail =
    '������ ����!' .
    '<br><br>' .
    "        C������, ��� �� <b>$count2</b> �������� ���������� ����������� ��������, �������� ��� ���������� � ����� �������������, ������� ��� �� ��������� ���������. 
             <br>������ ���� ��������� � ��� ��������� � �� ����� ������� �� �������� ����� ������ ��� �� $link . 
			
             <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//$to = 'usharov@mts.by, galenchik@mts.by'; // ����� ���������� ������ �� �����
$tema = '������������ �������� ������';
$tema = iconv('cp1251', 'utf-8', $tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
$message = $message_mail; //���������� �� ����� name=message

// ���������� �������� ���������
if (send_mail($nachalstvo, $tema, $message, $picture, $filename)) {
	echo '<h1>��������� �����������</h1>';
}

echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
echo "<center><b>������ ����������!</b></center>";
?>
<script>document.location.href="sverka.php"</script>

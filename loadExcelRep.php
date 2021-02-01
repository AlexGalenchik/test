<?php
include_once('config.php');
include_once('functions.php');
session_start();

//echo "<pre>";
//print_r ($_SESSION);
//echo "</pre>";

$start_date = $_SESSION['start_date']; //������� ���������� ���� ������ �������� ���
$finish_date = $_SESSION['finish_date']; //������� ���������� ���� ��������� �������� ���

$filename = "list_rep.xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");



// ����������� � �� ��������
function connect(){ 
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
    // ���������
    mysqli_set_charset($conn, "cp1251");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$conn = connect();
//����� ������ �� ������� � ���� �������

    function selectAll($conn,$start,$finish)    {

        // ��������� ������ �� ��
        //������������ ������� � �� � �������� ��� ����� � �����
$sql = " SELECT";
$sql.= " repeaters.repeater_number";
$sql.= " ,formulars.type as formular_type";
$sql.= " ,repeater_types.repeater_type";
$sql.= " ,repeater_types.diapazon";
$sql.= " ,repeaters.inventory_number"; // ��������� ��� ������� �������� �.�.
$sql.= " ,repeaters.date_rep_insert_expl"; // ��������� ��� ������� �������� �.�.
$sql.= " ,regions.region";
$sql.= " ,areas.area";
$sql.= " ,CONCAT (settlements.type,' ',settlements.settlement) as settlement_type";
$sql.= " ,CONCAT (repeaters.street_type,' ',repeaters.street_name)";
$sql.= " ,CONCAT (repeaters.house_type,' ',repeaters.house_number)";
$sql.= " ,repeaters.place_owner";
$sql.= " ,formulars.create_date";
$sql.= " ,formulars.to_lotus_date";
$sql.= " ,formulars.signed_date";
$sql.= "  FROM repeaters";
$sql.= "  LEFT JOIN repeater_types";
$sql.= "  ON repeater_types.Id = repeaters.repeater_type_id";
$sql.= "  LEFT JOIN settlements";
$sql.= "  ON settlements.Id = repeaters.settlement_id";
$sql.= "  LEFT JOIN areas";
$sql.= "  ON areas.Id = settlements.area_id";
$sql.= "  LEFT JOIN regions";
$sql.= "  ON regions.Id = areas.region_id";
$sql.= "  LEFT JOIN power_types";
$sql.= "  ON power_types.Id = repeaters.power_type_id";
$sql.= "  LEFT JOIN formulars";
$sql.= "  ON formulars.repeater_id = repeaters.Id";
$sql.= "  WHERE formulars.create_date BETWEEN '".$start."' AND '".$finish."'";
$sql.= "  ORDER BY formulars.create_date";

        $result = mysqli_query($conn, $sql);
        $a = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $a[] = $row;
            }
        }
        return $a;
		
    }

    $dataAll = selectAll($conn,$start_date,$finish_date);
	
//////////////////////// ����� excel
// ���������� Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
	//require_once ('./Classes/PHPExcel/Writer/Excel2007.php'); //��������� �������� - ��� ������ ���������
// ������� �����
    $phpexcel = new PHPExcel();
//$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objReader = PHPExcel_IOFactory::createReader('Excel2007');

    $phpexcel = $objReader->load('./templates/list_temlates.xlsx'); //��������� "���������" xls


    // ������ ��������
    $abc=['A','B','C','D','E', 'F','G','H','I','J','K','L','M','N','O'];

    // ������ ������
    $keyArr=[];
    foreach ($dataAll[0] as $key => $value) {
		//$keyArr[] = $key;
        array_push($keyArr, $key);
    }

    // ������� �����
    //for($i=0; $i < count($abc); $i++){
    //    $string = $keyArr[$i];
    //    $cellLetter = $abc[$i] . 1;
    //    $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
    //}

    //��������� ���������� �����
    $k=0;
    for($i=0; $i < count($dataAll); $i++) {
       $arrValue =[];
//        ��������� ������ ����������
        foreach ($dataAll[$i] as $key => $value) {
            array_push($arrValue, $value);
        }
        $k=$i+2;

        for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
            // ������ ������ ����� ��� �������� � ������
                if ($abc[$s] == "A") {
					$phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                   }
            else {
                $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");

                $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }

}
  // echo "<pre>";
  // print_r($dataAll[$i]);
  // echo "</pre>";


   

    // �������� �������� ��������
    $page = $phpexcel->SetActiveSheetIndex();
//// ���� ������ ������� �� �����������
$page->getColumnDimensionByColumn("H")->setAutoSize(true);
//// ������ ������� A
//$page->getColumnDimension("A")->setWidth(700);


//���������� � ������ ��������
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
    $page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
    $page->setTitle('main');

// ��������� ��������� ������ � �������
$lastCell = count($dataAll)+1;
    // ������ ������� �������
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

// ������ ����� � ������ �������
$page->getStyle("A1:A".$lastCell."")->getFont()->setBold(true);

//�����
$page->getStyle("A1:O$lastCell")->applyFromArray($border);


//����������
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}
//��� ���� ������� ������ �������
//$page->getColumnDimension("AL")->setAutoSize(false);
//$page->getColumnDimension("AM")->setAutoSize(false);
//$page->getColumnDimension("AL")->setWidth(30);
//$page->getColumnDimension("AM")->setWidth(30);

//��������
$page->getStyle("AL")->getAlignment()->setWrapText(true);
$page->getStyle("AM")->getAlignment()->setWrapText(true);

    $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//    $objWriter->save('php://output');
$objWriter->save('php://output');

// ���� ���� ���������� - ������ � �������� �����
//if(file_exists($filename)){
//    unlink($filename);
//}

// ���������� �����
//$objWriter->save($filename);
   exit();

?>
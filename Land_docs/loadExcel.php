<?php
include_once('../config.php');
include_once('../functions.php');
session_start();
$filename="list.xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

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

    function selectAll($conn)    {

        // ��������� ������ �� ��
         $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //������ �� �������
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //������ �� ������
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //������ �� ������
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //������ �� ������ ��
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //������ �� ������ ��
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //������ �� ������ ��
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //������ �� ������ ��
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //������ �� ������ ��
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //������ �� ������ ��
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //������ �� ������ ��
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { 
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
	
	    //////////////////////// ����� excel
// ���������� Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// ������� �����
    $phpexcel = new PHPExcel();
//$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_temlates.xlsx'); //��������� "���������" xls
// ������ ��������
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L','M','N','O','P','Q','R','S', 'T','U','V','W','X','Y','Z','AA'];
	  
//�������� ���������� �����
    $k=0;
    for($i=0; $i < count($dataAll); $i++) {
		$arrValue =[];
		
//�������� ������ ��������� � ������� �� ������ �� ������ ���
        foreach ($dataAll[$i] as $key => $value) {
			array_push($arrValue,$value);
		}
		
		$k=$i+2;
		
		

        for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
			
			
						
				   
			// ������ ������ ����� �� �������� � ������
			
			
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

   


    // �������� �������� ��������
    $page = $phpexcel->SetActiveSheetIndex();
//// ���� ������ ������� �� �����������
//$page->getColumnDimensionByColumn("H")->setAutoSize(true);
//// ������ ������� A
//$page->getColumnDimension("A")->setWidth(700);

// ���������� ������ � ������
//$date = date('d.m.Y');
//$page->setCellValue('A1', $date);
// ������������� ������ ������ � ������ (���� ���� ��-��-����)
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
//$page->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);




//��������� � ������ ��������
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
    $page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
    $page->setTitle('Land');

//    // ����������� ����� ������


// �������� ��������� ������ � �������
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
$page->getStyle("A1:AA$lastCell")->applyFromArray($border);


//����������
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}
//�� ���� ������� ������ �������
//$page->getColumnDimension("AL")->setAutoSize(false);
//$page->getColumnDimension("AM")->setAutoSize(false);
//$page->getColumnDimension("I")->setWidth(80);
//$page->getColumnDimension("AK")->setWidth(80);

//��������
//$page->getStyle("AK")->getAlignment()->setWrapText(true);
//$page->getStyle("AL")->getAlignment()->setWrapText(true);
//$page->getStyle("AR")->getAlignment()->setWrapText(true);

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
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
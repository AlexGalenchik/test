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

   /* function selectAll($conn)    {
		
			$sql = "SELECT * FROM  rent WHERE Id is not NULL ";

        // ��������� ������ �� ��
        If ($_SESSION['reg_user'] == '�����') {  

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
	 
			
        // ��������� ������ �� ��
		
        If ($_SESSION['reg_user'] != '����' || $_SESSION['reg_user'] != '�����������' || $_SESSION['reg_user'] != '����������' || 
		$_SESSION['reg_user'] != '�����������' || $_SESSION['reg_user'] != '���������' || $_SESSION['reg_user'] != '���������' || $_SESSION['reg_user'] != '���') 
		{ //���� ����� �� �������������, �� �� ������ ������ ������ ���� �������������
		
			$sql = " SELECT * FROM rent WHERE Id is not NULL ";	
			
			If (!empty($_SESSION['reg'])) { //������ �� ������� - ���� ������������� ������ ���� �� ��������
            $sql.= " AND region like '".$_SESSION['reg']."' ";}
				
			If (!empty($_SESSION['division'])) { //������ �� �������������
			$sql.= " AND division like '" . $_SESSION['division'] . "'   ";}
           
			
		
		} else {
			
			$sql = " SELECT * FROM rent WHERE division like '".$_SESSION['reg_user']."' "; //���� ��� �� �������������, �� �� ����� ������ ���� �������	
           
        }

        If (!empty($_SESSION['Areas'])) { //������ �� ������
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //������ �� ���� ��������
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
		If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
            $sql.= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //������ �� ���� �������� ///////////////////////////////////////////////////////////////////////////////////////////////////////////
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

        If (!empty($_SESSION['type_currency'])) { //������ �� ���� ��������
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //������ �� ���� ������ �������� ��������
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //������ �� ���� ��������� �������� ��������
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
            $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        }

        If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
			$sql.= " AND dogovor_number LIKE '". $_SESSION['dog'] . "' "; 
	
        If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
		//var_dump($reg_user == '�����');
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
	
	    //////////////////////// ����� excel
// ���������� Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// ������� �����
    $phpexcel = new PHPExcel();
//$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_temlates.xlsx'); //��������� "���������" xls
// ������ ��������
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L','M','N','O','P','Q','R','S', 'T','U','V','W','X','Y','Z',
      'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU'];
	  
$numeric_columns = ['P','Q','R','S','T','U','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AP'];// ������� � ��������� ����������


 // ������� ������ ������ � ��������� ��� (�� 1 ������� �������� ��� �����)
  // $keyArr=[];
   
  // foreach ($dataAll[0] as $key => $value) {
 //      array_push($keyArr, $key);   
 //  }
   
	//	echo "<pre>";
	//	print_r($keyArr);
	//	echo "</pre>";

// ������� �����
//    for($i=0; $i < count($abc); $i++){
//        $string = $keyArr[$i];
//        $cellLetter = $abc[$i] . 1;
//        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
//    }

    //��������� ���������� �����
    $k=0;
    for($i=0; $i < count($dataAll); $i++) {
		$arrValue =[];
		
//        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
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
				   
				
				   
			// ������ ������ ����� ��� �������� � ������
			
			
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




//���������� � ������ ��������
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
    $page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
    $page->setTitle('main');

//    // ����������� ����� ������


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
$page->getStyle("A1:AU$lastCell")->applyFromArray($border);


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
$page->getStyle("AN")->getAlignment()->setWrapText(true);
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
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
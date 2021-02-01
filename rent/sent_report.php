<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

// ������� ����
$today_time = date("d-m-Y");
$filename="BELARUS_".$today_time.".xlsx";
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=$filename");

$conn = connect(); // ����������� � ��

///////////////////////////////////////////////////////////// ���� �������
//1. ������� ��� ������� ��������� �� �� RENT
Function finish_dog ($object, $table, $finish_date, $month) {
	$db_conn = connect(); // ����������� � ��
	$sql = " SELECT Id, type, $object, region, area, settlement, adress, dogovor_number, dogovor_date, start_date_dogovor, finish_date_dogovor, division
	FROM $table
	WHERE $finish_date BETWEEN (CURRENT_DATE()) AND  (CURRENT_DATE() - INTERVAL - ".$month." MONTH) ORDER BY $finish_date ";
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a;

}

//1. ���������� �������, � ������� ������������� �������� � ��������� 3 ������
$month = 3; // ��������� ���������� �������
$data = finish_dog ('number','rent','finish_date_dogovor', $month);

//2. ������� ��� ������� ���������, ������� �� ����� � ���� ������ (���������� ������)
//���� ��� �� ����� sverka.php
 //�������, ������� ��������� ������ �� ���������� �������� ������� ��������
 Function make_array ($table,$column,$conn,$column3) {
	$db_conn = connect(); // ����������� � �� 
	$sql = "SELECT DISTINCT $column FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like '��� ��������'";
		}
		$sql .= " ORDER BY $column";
	 
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row[$column];
			
	}
	return $a; 
	 
}

//������� ��������� ������ �� ���������� �������� �� � ��������
 Function make_array2 ($table,$column1,$column2, $conn, $column3) {
	$db_conn = connect(); // ����������� � ��  
	$sql = "SELECT DISTINCT $column1, $column2 FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like '��� ��������'";
		}
		$sql .= " ORDER BY $column1";
	 
	 
	$query =  mysqli_query($db_conn, $sql);
	
	$a = [];
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i < mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[$row[$column1]] = $row[$column2];
 
			
	}
	return $a; 
	 
}

///////////////////////////////////////////////////////////////////
//������������ ������� ������� �������� �� ���������� ����� �������

//������� ������ ���������� ������� �� � ������� ������� ����
$emkost = make_array ('emkost_seti','bts_number',$conn,'');

//������� ������ ���������� ������� �� � ������� �� ������� ����
$emkost2 = make_array2 ('emkost_seti','bts_number','adress',$conn,'');

//������� ������ ��������� �� �� ������� ����
$emkost_PBS = [7001,7002,7004,8001,8002,8003,2000,2001,2002,2003,2004,2005,2006,2007];

//������������ ������� ������� �������� �� �� RENT

$rent = make_array ('rent','number',$conn, 'type_arenda');

//������������ ������� ������� �������� �� �����

$land = make_array ('land_docs_minsk','bts',$conn,'');

//������ $nedostatok �������� �������� ������� �� ����� �������, ������� �� ����� � �� rent � � �� Land � � ������ ��������� �� (��� �� ��������� ��� ������)

$nedostatok = array_diff($emkost,$rent,$land,$emkost_PBS);

//echo "<pre>";
//var_dump($nedostatok);
//echo "</pre>";

//������ ����������� ��� ����� ������ �� ������ delta_sverka � delta_info
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
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$data2[] = $row;
			
	}
	
////////////////////////////////////////////////////////////////////////����� � EXCEL /////////////////////////////////////////////////////////////////


 //////////////////////// ����� excel
// ���������� Classes PHPExcel
    require_once ('./Classes/PHPExcel.php');
// ������� �����
    $phpexcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$phpexcel = $objReader->load('./templates/list_report_rus.xlsx'); //��������� "���������" xls (������������ 2 �����)

// ���� 1.�������� �������� �� �������� ���������
// ������ �������� ��� ����� 1
$abc=['A','B','C','D','E', 'F','G','H','I','J','K','L'];

   //��������� ���������� ����� ��� ����� 1
    $k=0;
for($i=0; $i < count($data); $i++) {
		$arrValue =[];
		
//        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
        foreach ($data[$i] as $key => $value) {
				array_push($arrValue,$value);
		}
		$k=$i+2;
		
		for($s=0; $s < count($abc); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc[$s] . $k;
			
	// ������ ������ ����� ��� �������� � ������
	    $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");
        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            
		}

}

	// �������� �������� �������� (���� 1)
	$page = $phpexcel->SetActiveSheetIndex();

//���������� � ������ ��������
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
    $page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
    //$page->setTitle('FINISH_DOGOVORS');

// ����������� ����� ������


// ��������� ��������� ������ � �������
$lastCell = count($data)+1;
    // ������ ������� �������
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
$page->getStyle("A1:L$lastCell")->applyFromArray($border);


//����������
for($s=0; $s < count($abc); $s++) {
    $page->getColumnDimension("$abc[$s]")->setAutoSize(true);
}

// ���� 2.�������� �������� �� ����������� ��������� � �������
// ������ �������� ��� ����� 2
$abc2=['A','B','C','D','E'];
	  
   //��������� ���������� ����� ��� ����� 2
    $k=0;
for($i=0; $i < count($data2); $i++) {
		$arrValue =[];
		
//        ��������� ������ ���������� � ������� �� ������ ��� ������ ����
        foreach ($data2[$i] as $key => $value) {
				array_push($arrValue,$value);
		}
		$k=$i+2;
		
		for($s=0; $s < count($abc2); $s++) {
			$string = $arrValue[$s];
            $cellLetter = $abc2[$s] . $k;
			
	// ������ ������ ����� ��� �������� � ������
	    $string=mb_convert_encoding($string, "UTF-8", "Windows-1251");
        $phpexcel->getActiveSheet()->setCellValueExplicit("$cellLetter", $string, PHPExcel_Cell_DataType::TYPE_STRING);
            
		}

}

// �������� �������� �������� (����� ���� 2)
    $page = $phpexcel->SetActiveSheetIndex();

//���������� � ������ ��������
    $page->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $page->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// ������ ������
    $page->getRowDimension('1')->setRowHeight(30);
// �������� ��������
    //$page->setTitle('NO_DOGOVORS');

// ����������� ����� ������


// ��������� ��������� ������ � �������
$lastCell = count($data2)+1;
    // ������ ������� �������
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
    $page->getStyle("A1:E$lastCell")->applyFromArray($border);


//����������
for($s=0; $s < count($abc2); $s++) {
    $page->getColumnDimension("$abc2[$s]")->setAutoSize(true);
}



// ���������� ����� � ������� (���������� ��������������)
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
$objWriter->save('php://output');

// ���������� �����
$objWriter->save("../reports/$filename");

//////////////////////////////////////////////////////////////����� ������ � EXCEL////////////////////////////////////////////////////////////////////

//2. ���������� �������, � ������� ������������� �������� � ��������� 3-6 ������� � ���������� �� ����� ��������� � ��������

// ���������� ���������� ���-�� ��������� ����������� � ��������� 3 ������ ��� ������ � ���������
$count1 = count($data);

// ���������� ��������� ���-�� �� ��� ���������
$count2 = $_SESSION['nedostatok'];
 

// ��������� ���� � ����� � �������� ��� ���
                //$picture = 'Docoment_2020.xlsx';
				  $picture = "../reports/".$filename."";
				// ������� �������� ��������� � ������

            function send_mail($to, $tema, $html, $path, $filename) {
                $fp = fopen($path,"r");
                if (!$fp){
                    print "���� $path �� ����� ���� ��������";
                    exit();
                }
                $file = fread($fp, filesize($path));
//                var_dump(filesize($path));
                fclose($fp);



                $boundary = "--".md5(uniqid(time())); // ���������� �����������
                $headers = "MIME-Version: 1.0\n";
                $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
                $multipart = "--$boundary\n";
//                $kod = 'windows-1251'; // ��� $kod = 'koi8-r';
                $kod = 'cp1251'; // ��� $kod = 'koi8-r';
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
                    echo "� ���������, ������ �� ����������";
                    exit();
                }
            }


//            $name = 'Pavel';
			
            $email = 'rent@mts.by';
            $message_mail = "������ ����!" . "<br><br>" . "� ����� Rent ������� �������� ��� �� �������� ������������� ��������.<br> 
             � ��������� <b>".$month."</b> ������ ���������� ���� ��������  � <b>".$count1."</b>  ���������. ������ ���� ��������� � ��� ��������� � �� �����
             ������� �� �������� ����� ������. <br>
             ����� �������, ��� �� <b>".$count2."</b> �������� ���������� ����������� ��������, ������� ��� �� ��������� ���������. 
             <br> ������� ������ � �������� ���� � ����������� ������!<br><br>� ���������, ��� ���� ����� Rent
             <br><br><br>P.S.: ��������� ������������� ������������� � �� ������� ������.";

//                $to = "uscharov@mail.ru"; // ����� ���������� ������ �� �����
                $to = "usharov@mts.by, galenchik@mts.by"; // ����� ���������� ������ �� �����
				$tema = "��������� �������� ������";
                $tema = iconv('cp1251','utf-8',$tema); // ���� ����������� ������
//                $message = "���� ���: " . $name . "<br>";//��������� ���������� ��������, ���������� �� ����� name=name
//                $message = "E-mail: " . $email . "<br>"; //���������� �� ����� name=email
                $message = $message_mail ; //���������� �� ����� name=message

                // ���������� �������� ���������
                  if(send_mail($to, $tema, $message, $picture, $filename)) {
					  echo "<h1>��������� �����������</h1>";
				  };

                  

      ?>
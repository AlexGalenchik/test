<?php
include_once('./core/config.php');
include_once('./core/function.php');
include_once('../config.php');
include_once('../functions.php');
session_start();

//$Id = $_GET['Id'];

//  ����������� � ��
  $conn = connect();
//����� ������ �� ������� � ���� �������
  $dataAll = selectAll($conn); //core/functions.php
  
  //��� ������ Id ������������ ����� ��� Id ��� ���������� � RENT
	if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
	}

  // ������� ������ � ������� - � ������ ��������� � �����������  ���� �������   ������
$arr_key=[];
$arr_value=[];

// �������� ������� � ����������
foreach ($dataAll[0] as $key => $value) {
     array_push($arr_key, $key);
     array_push($arr_value, $value);
}
$combine=array_combine($arr_key,$arr_value);
//echo "<pre>";
//print_r($combine);
//echo "</pre>";
/*  �� ����� ������� � ������� rent, ��� ��� ��� ������ ������ MySQLActionRENT

    $sql = "INSERT INTO rent (";
                for ($i=1; $i < count($arr_key); $i++) {
                    $sql .= $arr_key[$i];
                    if($i<count($arr_key)-1) {
                        $sql .= ", ";
                    };
                };
            $sql .= ")  VALUES (";
                for ($i=1; $i < count($arr_value); $i++) {
                        $sql .= '"';
                        $sql .= $arr_value[$i];
                        $sql .= '"';
                        if($i < count($arr_value)-1) {
                            $sql .= ", ";
                        };
                    };
            $sql .=");";

// echo $sql;
 echo "<br>";
 echo "<br>";
 echo "<br>";

    $query = mysql_query($sql) or die(mysql_error());
	
*/	
    if ($combine) {

        echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
        echo "<center><b>������������ ���������!</b></center>";

    }



//$last_id = mysql_insert_id();  // ������ ������� MySQLActionRENT ��� ���� ���������� Id ������, ���� ����� $id �� ������� MySQLActionRENT, ��� ������ ����� Id ��� ���� Insert

///����� ������ ��� ������� ����
							$names = array ( 
								'type_arenda' => '��� ������'
								,'type' => '��� �������'				
								,'number' => '����� �������'
								,'region' => '�������'			
								,'area' => '�����'				
								,'settlement' => '���. �����'			
								,'adress' => '�����'			
								,'arendodatel' => '������������'		
								,'arendator' => '���������'
								,'dogovor_number' => '����� ��������'		
								,'dogovor_type' => '��� ��������'		
								,'dogovor_date' => '���� ��������'		
								,'start_date_dogovor' => '���� ������ ��������'	
								,'finish_date_dogovor' => '���� ��������� ��������'
								,'prolongaciya' => '����������� ��������'								
								,'admin_office' => '���������������� ����'	
								,'sell_office' => '���� ������'		
								,'tech_office' => '����������� ����'	
								,'sklady' => '�����'
								,'payment' => '�������'			
								,'currency' => '������'			
								,'type_opory' => '��� �����'
								,'rent_place_TSH' => '�������� �����' 
								,'rent_area' => '������� ������'				
								,'room_area' => '������� ���������'  			
								,'roof_area' => '������� ������' 		
								,'asphalt_pad_area' => '������� ��������' 
								,'length_cable' => '����� ������'				
								,'length_canaliz' => '����� ��������� ���-��'
								,'rent_pay_BYN' => '������� �� ������ (BYN)'
								,'rent_pay_BAV' => '������� �� ������ (���)'
								,'rent_pay_BV' => '������� �� ������ (��)'
								,'rent_pay_EUR' => '������� �� ������ (EUR)'
								,'rent_pay_USD' => '������� �� ������ (USD)'
								,'nds_pay' => '������� ���'
								,'naznachenie' => '����������' 			
								,'ispolnitel' => '�����������' 
								,'notes' => '����������' 
								,'contragent_data' => '���������� ����'
								,'post_adres' => '�������� �����'								
								,'insurance_finish' => '���� ��������� �����������'
								,'number_of_dogovors' => '���������� ���������'	
								,'dogovor_AKO' => '������� ���' 
								,'PUD' => '���' 							
								,'prichiny_AKO' => '������� ���'			
								,'own_form' => '����� �������������'  				
								,'method_form_AP' => '����� ������������ ��'   		
								,'summa' => '����� �������'
								,'type_currency' => '��� ������'
								,'nds2' => '������ ���' 
								,'type_rent_propety' => '��� ����������� ���������'
								,'division' => '�������������'
								,'svidetelctvo_regist' => '������������� � �����������'  
										
							);

$id = MySQLActionRENT($combine,'rent','','insert','history_rent',$names,'������������'); //id �� ���� ��������� � ������� �������, ��� ��� ��� ��� insert � ������ ������� ����� ������ ����� Id

$sql_isp_id = "UPDATE rent SET ispolnitel_id = $user_id WHERE Id = $id"; //�������� Id ����������� �������� � ������� Ispolnitel_id ��� ������������
$query = mysql_query($sql_isp_id) or die(mysql_error());


// ,������� � ������ ������� (����� �� ����� � ������ ����)
$new_url = 'edit.php?Id='.$id;
mysqli_close($conn);
?>

<script>
    var param = '<?php echo $new_url;?>';
   document.location.href=param
</script>



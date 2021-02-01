<?php
include_once('../config.php');
include_once('../functions.php');
session_start();

function clean($value = "") {
	$value = trim($value); //������� ������� � ������ � � ����� ������
	$value = stripslashes($value); //������� ������������� ��������
	$value = strip_tags($value);// ������� ���� HTML � PHP �� ������
	$value = htmlspecialchars($value,ENT_QUOTES,'cp1251'); //����������� ����������� ������� � HTML-��������
	return $value;
}

// ������� ���������� �� ����� � ������� rent ��� ������ ��������� ��� ����� � POST
function no_zero ($post,$field) {
		$post = str_replace(",",".",$post);
		
	If (empty($post) || $post == 0 || $post == '') {
			
				$field = NULL;
			} else {
				$field = str_replace(",",".",$post);
			}
			return $field;
}
// ������� ���������� �� ����� � ������� rent ��� ������ ��������� ��� ����� � POST
function no_zero_data ($post,$field) {
				
	If (empty($post) || $post == '0000-00-00' || $post == '') {
				$field = NULL;
			} else {
				$field = $post;
			}
			return $field;
}

function quotes_change ($text) {  //������� �������� ������� �� ������� � ������
	$text = str_replace(' "',' �',$text);
	$right_text = str_replace('"','�',$text);
	
	return $right_text;
}

$id = $_GET['Id'];

//�������� ���������� �� ���� �����

if ((isset($_POST['bts']) && !empty($_POST['bts']) ) ) {
			$bts = $_POST['bts'];
			$bts = clean($bts);
}
			// ��������� NE (������ ����)
			$type_opori = $_POST['type_opori']; ////
			$oblast = $_POST['oblast'];   ////
			$raion = $_POST['raion'];   ////
	 		$nas_punkt = $_POST['nas_punkt']; ////
			$adress = quotes_change ($_POST['adress']); ///////////////////New
			
			$type_opori = clean($type_opori); ////
			$oblast = clean($oblast);   ////
			$raion = clean($raion);     ////
			$nas_punkt = clean($nas_punkt); /////
			$adress = clean($adress); ///////////////////New
						
			// ��������� ���������� ������� (��)
			$svidetelstvo_land = $_POST['svidetelstvo_land']; ////
			$svidetelstvo_land_date = no_zero_data($_POST['svidetelstvo_land_date'],$svidetelstvo_land_date); ///////////////////New
			$kadastroviy_number = $_POST['kadastroviy_number']; ////
			$land_area = no_zero ($_POST['land_area'],$land_area); ////
			$type_rent = $_POST['type_rent']; ////
			//$resheniye_videlenie = $_POST['resheniye_videlenie']; //���� ����� �� ������ 24.12.2020
			//$resheniye_videlenie_date = no_zero_data ($_POST['resheniye_videlenie_date'],$resheniye_videlenie_date); ///////////////////New
			
			$svidetelstvo_land = clean($svidetelstvo_land); ////
			$kadastroviy_number = clean($kadastroviy_number); ////
			$type_rent = clean($type_rent); ////
			//$resheniye_videlenie = clean($resheniye_videlenie); // //���� ����� �� ������ 24.12.2020
			//$resheniye_videlenie_date = clean($resheniye_videlenie_date); //���� ����� �� ������ 24.12.2020
			
			//�������� ����� BYN, USD
			$rent_BYN = no_zero ($_POST['rent_BYN'],$rent_BYN);
			$rent_USD = no_zero ($_POST['rent_USD'],$rent_USD);
									
			//$rent_USD = clean ($rent_USD);
			//$rent_BYN = clean($rent_BYN);
			
			// ��������� ��������
			$dogovor_number = $_POST['dogovor_number'];
			$dogovor_date = no_zero_data ($_POST['dogovor_date'],$dogovor_date);
			$dogovor_start = no_zero_data ($_POST['dogovor_start'],$dogovor_start); ///////////////////New
			$dogovor_finish = no_zero_data ($_POST['dogovor_finish'],$dogovor_finish); ///////////////////New
			
			$dogovor_number = clean($dogovor_number);
					
            //��������� �� ��������
			$inventarniy_building = $_POST['inventarniy_building'];
			$svidetelstvo_building = $_POST['svidetelstvo_building'];
			$svidetelstvo_building_date = no_zero_data ($_POST['svidetelstvo_building_date'],$svidetelstvo_building_date); ///////////////////New
			
			$inventarniy_building = clean($inventarniy_building);
			$svidetelstvo_building = clean($svidetelstvo_building);
						
			//���������� �� �������������
			//$razreshenie_number = $_POST['razreshenie_number'];  ///////////////////New
			//$razreshenie_number_date = no_zero_data ($_POST['razreshenie_number_date'],$razreshenie_number_date); ///////////////////New
			
			//$razreshenie_number = clean($razreshenie_number); ///////////////////New
						
			//����������
			$notes = quotes_change ($_POST['notes']);  ///////////////////New
			$notes = clean($notes); ///////////////////New
			
			//$ispolnitel = $_POST['ispolnitel'];
			
			
			
			///////////////////////////////////////���������� � �������///////////////////////////////////////
			
			 //������� ������� ���������� ���� ������


			$data = array ( //������ ������ �����, ������� ���� ����������
								 'Id' => $id
								,'bts' => $bts
								,'oblast' => $oblast
								,'raion' => $raion
								,'nas_punkt' => $nas_punkt
								,'adress' => $adress
								,'svidetelstvo_land' => $svidetelstvo_land
								,'svidetelstvo_land_date' => $svidetelstvo_land_date
								,'kadastroviy_number' => $kadastroviy_number
								,'land_area' => $land_area
								,'type_rent' => $type_rent
								,'rent_BYN' => $rent_BYN
								,'rent_USD' => $rent_USD
								,'inventarniy_building' => $inventarniy_building
								,'svidetelstvo_building' => $svidetelstvo_building
								,'svidetelstvo_building_date' => $svidetelstvo_building_date
								,'dogovor_number' => $dogovor_number
								,'dogovor_date' => $dogovor_date
								,'dogovor_start' => $dogovor_start
								,'dogovor_finish' => $dogovor_finish
								//,'resheniye_videlenie' => $resheniye_videlenie  			// ���� ����� �� �����
								//,'resheniye_videlenie_date' => $resheniye_videlenie_date  // ���� ����� �� �����
								//,'razreshenie_number' => $razreshenie_number  			// ���� ����� �� �����
								//,'razreshenie_number_date' => $razreshenie_number_date  	// ���� ����� �� �����
								,'type_opori' => $type_opori
								,'notes' => $notes
								
										
							);
							///����� ������ ��� ������� ����
							$names = array ( 
								 'bts' => '����� �������'
								,'oblast' => '�������'
								,'raion' => '�����'
								,'nas_punkt' => '���. �����'
								,'adress' => '�����'
								,'svidetelstvo_land' => '����-�� � ���. ���. ��'
								,'svidetelstvo_land_date' => '���� ����-�� � ���. ���. ��'
								,'kadastroviy_number' => '����������� ����� ��'
								,'land_area' => '������� ��'
								,'type_rent' => '��� ��������'
								,'rent_BYN' => '������� �� (BYN)'
								,'rent_USD' => '������� �� (USD)'
								,'inventarniy_building' => '������. ����� ���. ���-�'
								,'svidetelstvo_building' => 'C���-�� � ��� ���. ���. ���-�'
								,'svidetelstvo_building_date' => '���� C���-�� � ��� ���. ���. ���-�'
								,'dogovor_number' => '����� �������� ������'
								,'dogovor_date' => '���� �������� ������'
								,'dogovor_start' => '���� ������ �������� ��������'
								,'dogovor_finish' => '���� ��������� �������� ��������'
								,'resheniye_videlenie' => '������� � ��������� ��'
								,'resheniye_videlenie_date' => '���� ������� � ��������� ��'
								,'razreshenie_number' => '����� ������� � ����-��, ���'
								,'razreshenie_number_date' => '���� ������� � ����-��, ���'
								,'type_opori' => '��� �����'
								,'notes' => '����������'
															
										
							);
							
	If ($_POST['NewButton'] == '���������') {						
											
							$id = MySQLActionRENT($data,'land_docs_minsk',$id,'update','history_land',$names,'��������� ������');

/////////////////////////////////����� ���������� � �������//////////////////////////////////////////


//�������� �� ���������� �������
	If ($id) {
				echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";	
				echo "<center><b>���������!</b></center>";
				// ������� �� ���������� �������� edit.php, � ������� ����������� ��������������
				echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
				
	} else {
				echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";			
				echo '<p>��������� ������: ' . mysql_error(). '</p>';
	}	
}
?>

		 





 
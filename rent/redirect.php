<?php
//RENT_EDITOR
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

$id = $_GET['Id'];

Function quotes_change ($text) {  //������� �������� ������� �� ������� � ������
	$text = str_replace(' "',' �',$text);
	$right_text = str_replace('"','�',$text);
	
	return $right_text;
}

//�������� ����������

if ( (isset($_POST['numBS_MTS']) && !empty($_POST['numBS_MTS']) ) ) {
	
			$numBS_MTS = $_POST['numBS_MTS']; 		//����� �������
			$numBS_MTS = clean($numBS_MTS);
}
			$region = $_POST['region']; 				//�������
			$area = $_POST['area'];						//�����
	 		$type_arenda = $_POST['type_arenda'];   	//��� ������
			$type = $_POST['type'];                 	//��� NE
			$adress = quotes_change($_POST['adress']);  //�����
			$settlement = $_POST['settlement'];     	//���������� �����

			$region = clean($region); //������� ����� ���������� ������� Clean (� ������ ����)
			$area = clean($area);
			$type_arenda = clean($type_arenda);
			$type = clean($type);
			$adress = clean($adress);
			$settlement = clean($settlement);
            //////////////////////////////////////////////////////////////
			//������� ��������� (��������)
			$room = no_zero($_POST['room'],$room); 
			
			//������� ������ (��������)
			$roof_walls = no_zero ($_POST['roof_walls'],$roof_walls);
			
			//������� ���������� �������� (��������)
			$asfalt_square = no_zero ($_POST['asfalt_square'],$asfalt_square);
			
			//����� ������ (��������)
			$cabel = no_zero ($_POST['cabel'],$cabel);
			
			//����� ����������� (��������)
			$canalization = no_zero($_POST['canalization'],$canalization);
			
			$room = clean($room); //������� ����� ���������� ������� Clean (� ������ ����)
			$roof_walls = clean($roof_walls);
			$asfalt_square = clean($asfalt_square);
			$cabel = clean($cabel);
			$canalization = clean($canalization);
			////////////////////////////////////////////////////////////
			If (!empty($_POST['arendodatel'])) {
			$arendodatel = quotes_change ($_POST['arendodatel']);//����������� ������� � ������� �� ������
			}
			$arendator = quotes_change ($_POST['arendator']);	//����������� ������� � ������� �� ������
			$num_dogovor = $_POST['num_dogovor'];		//����� �������� (��������)
			$type_dogovor = $_POST['type_dogovor'];		//��� �������� (��������)
			$data_dogovor = no_zero_data ($_POST['data_dogovor'],$data_dogovor);		//���� �������� (����)
			$start_dogovor = no_zero_data ($_POST['start_dogovor'],$start_dogovor);	//���� ������ �������� (����)
			$finish_dogovor = no_zero_data ($_POST['finish_dogovor'],$finish_dogovor); //���� ��������� �������� (����)
			$finish_strah = no_zero_data ($_POST['finish_strah'],$finish_strah); //���� ��������� ��������� (����)
			$prolongaciya = $_POST['prolongaciya']; //����������� (��������� ���������) ��������
									
			$arendodatel = clean($arendodatel); //������� ����� ���������� ������� Clean (� ������ ����)
			$arendator = clean($arendator);
			$num_dogovor = clean($num_dogovor);
			$type_dogovor = clean($type_dogovor);
			$data_dogovor = clean($data_dogovor);
			$start_dogovor = clean($start_dogovor);
			$finish_dogovor = clean($finish_dogovor);
			$finish_strah = clean($finish_strah);
			$prolongaciya = clean ($prolongaciya); //�����������
			/////////////////////////////////////////////////////////////////
			$ako_exist = $_POST['ako_exist'];        //������� ��� (��/���)
			$ako_exist = clean($ako_exist);
			
			//$ako_reason = $_POST['ako_reason']; ���� �� ������������ ��� ���������� � ����� � ������ � ��������
			//$ako_reason = clean($ako_reason);  ���� �� ������������ ��� ���������� � ����� � ������ � ��������
			
			////////////////////////////////////////////////////////////////
			$pud = $_POST['pud'];                 		  // ������� ��� (��/���)
			$form_own = $_POST['form_own'];		  		  //����� ������������� (���./�� ���.)
			$method_AP = $_POST['method_AP'];     		  //����� ������������ �������� ����� (�������/����. ������/������ + ����. ������)
			
			
			$main_person = $_POST['main_person']; 		  //������������� ���� (��������)
			$notes = quotes_change ($_POST['notes']); 	  //���������� (���������)
			$contact = quotes_change ($_POST['contact']); //���������� ���������� (���������)
			$post_adres = $_POST['post_adres']; //�������� ����� (���������)
			
			$pud = clean($pud);					//������� ����� ���������� ������� Clean (� ������ ����)
			//$form_own = clean($form_own);
			//$method_AP = clean($method_AP);
			$main_person = clean($main_person);
			$notes = clean($notes);
			$contact = clean($contact);
			$post_adres = clean ($post_adres);
			/////////////////////////����� � ������///////////////////////////////////
			$proverka_contragenta = $_POST['proverka_contragenta']; 				//�������� ����������� (������ ���� naznachenie)
			$data_proverki = $_POST['data_proverki'];
			
			//������� ����������������� ����� (�����)
			$admin_office = no_zero ($_POST['admin_office'],$admin_office);
 			
			//������� ����� ������ (�����)
			$sell_office = no_zero($_POST['sell_office'],$sell_office);				
			
			//������� ������������ ����� (�����)
			$tech_office = no_zero ($_POST['tech_office'],$tech_office);				
			
			//������� ������� (�����)
			$sklady = no_zero($_POST['sklady'],$sklady);

			//������� ������� (�����)
			$arhiv = no_zero($_POST['arhiv'],$arhiv);			
			
			///////////////////////////////////////////////////////////////////////////////
			//$payment = $_POST['payment'] ;   //// ���� �� ������������ � � ����� �������� ��� ��� ���
			//$currency = $_POST['currency'];  //// ���� �� ������������ � � ����� �������� ��� ��� ���
			//$type_rent_propety = $_POST['type_rent_propety']; //��� ����������� ��������� (��������� �� �������)

			$proverka_contragenta = clean($proverka_contragenta); 
			$data_proverki = clean($data_proverki); 
			$admin_office = clean($admin_office);
			$sell_office = clean($sell_office);
			$tech_office = clean($tech_office);
			$sklady = clean($sklady);
			$arhiv = clean($arhiv);
			//$payment = clean($payment);   ���� �� ������������ � � ����� �������� ��� ��� ���
			//$currency = clean($currency); ���� �� ������������ � � ����� �������� ��� ��� ���
			//$type_rent_propety = clean($type_rent_propety); //��� ����������� ��������� (��������� �� �������)

			$type_opory = $_POST['type_opory'];                       //��� ����� ���������, ���������� � ������
			$rent_place_TSH = $_POST['rent_place_TSH'];               //������ ����� � ��������. ����� (���������)
			$rent_area = $_POST['rent_area'];						  //�������, ��������� � ������ (���������)
			$division = $_POST['division'];							  //�������������	
			$svidetelctvo_regist = $_POST['svidetelctvo_regist'];	  //������������� � ����������� (���������)

			$type_opory = clean($type_opory);
			$rent_place_TSH = clean($rent_place_TSH);
			$rent_area = clean($rent_area);
			$svidetelctvo_regist = clean($svidetelctvo_regist);

			// �������� �� ������� ��� ������ � ����� � ���
			$summa = no_zero ($_POST['summa'],$summa);
			$type_currency = $_POST['type_currency'] ;
			$nds2 = no_zero ($_POST['nds2'],$nds2);
			$nds = $nds2 ;
			
			$summa = clean($summa);  //������� ����� ���������� ������� Clean (� ������ ����)
			$type_currency = clean($type_currency);
			$nds2 = clean($nds2);
			$nds = clean($nds);
			
			//������ �������� � ���������� � ����������� �� ���������� ���� ������	

			if($type_currency=="BYN") {
				$byn = $summa;
				$bav = NULL;  //NULL �������� - �������� �.�. 03.12.2020 �����
				$bv  = NULL;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="���") {
				$byn = NULL;
				$bav = $summa;
				$bv  = NULL;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="��") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = $summa;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="EUR") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = NULL;
				$eur = $summa;
				$usd = NULL;
			}
			if($type_currency=="USD") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = NULL;
				$eur = NULL;
				$usd = $summa;
			}

			$byn = clean($byn);
			$bav = clean($bav);
			$bv = clean($bv);
			$eur = clean($eur);
			$usd = clean($usd);
			
			///////////////////////////////////////���������� � �������///////////////////////////////////////
			
			


/*
If ($_POST['type_currency'] !== '') 		{
				if($_POST['type_currency']=="BYN") {
				$byn_history = $_POST['summa'];
				$bav_history = '';
				$bv_history = '';
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="���") {
				$byn_history = '';
				$bav_history = $_POST['summa'];
				$bv_history = '';
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="��") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  $_POST['summa'];
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="EUR") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  '';
				$eur_history = $_POST['summa'];
				$usd_history = '';
				}
				if($_POST['type_currency']=="USD") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  '';
				$eur_history = '';
				$usd_history =  $_POST['summa'];
				}
			} else {
				if($type_currency=="BYN") {
				$byn_history = $byn;
				}
				if($type_currency=="���") {
				$bav_history = $bav;
				}
				if($type_currency=="��") {
				$bv_history = $bv;
				}
				if($type_currency=="EUR") {
				$eur_history = $eur;
				}
				if($type_currency=="USD") {
				$usd_history = $usd;
				}
			}
*/
			
			$data = array ( //������ ������ �����, ������� ���� ����������
								'Id' => $id
								,'type_arenda' => $type_arenda
								,'type' => $type				
								,'number' => $numBS_MTS
								,'region' => $region			
								,'area' => $area				
								,'settlement' => $settlement			
								,'adress' => $adress			
								,'arendodatel' => $arendodatel		
								,'arendator' => $arendator
								,'dogovor_number' => $num_dogovor		
								,'dogovor_type' => $type_dogovor		
								,'dogovor_date' => $data_dogovor		
								,'start_date_dogovor' => $start_dogovor
								,'finish_date_dogovor' => $finish_dogovor
								,'prolongaciya' => $prolongaciya     // ����������� (��������� �������� (��/���))								
								,'admin_office' => $admin_office	
								,'sell_office' => $sell_office		
								,'tech_office' => $tech_office	
								,'sklady' => $sklady
								,'arhiv' => $arhiv
//								,'payment' => $payment	// ���� ��� ���� �� ������������� � � ������� �� ������������			
//								,'currency' => $currency  // ���� ��� ���� �� ������������� � � ������� �� ������������			
								,'type_opory' => $type_opory
								,'rent_place_TSH' => $rent_place_TSH 
								,'rent_area' => $rent_area				
								,'room_area' => $room			
								,'roof_area' => $roof_walls 		
								,'asphalt_pad_area' => $asfalt_square 
								,'length_cable' => $cabel				
								,'length_canaliz' => $canalization
								,'rent_pay_BYN' => $byn
								,'rent_pay_BAV' => $bav
								,'rent_pay_BV' => $bv
								,'rent_pay_EUR' => $eur
								,'rent_pay_USD' => $usd
								,'nds_pay' => $nds
								,'proverka_contragenta' => $proverka_contragenta //����� ���� ������ ��������������� ���� naznachenie
								,'data_proverki' => $data_proverki //����� ���� 									
								,'ispolnitel' => $main_person 
								,'notes' => $notes
								,'contragent_data' => $contact
								,'post_adres' => $post_adres            // �������� �������� ����� �� ������� �������
								,'insurance_finish' => $finish_strah
//								,'number_of_dogovors' => 1  	              	 ���� �� ������������ ��� ���������� � ����� � ������ � ��������
								,'dogovor_AKO' => $ako_exist 
								,'PUD' => $pud 							
//								,'prichiny_AKO' => $ako_reason       		     ���� �� ������������ ��� ���������� � ����� � ������ � ��������	
								,'own_form' => $form_own  				
								,'method_form_AP' => $method_AP   		
								,'summa' => $summa
								,'type_currency' => $type_currency
								,'nds2' => $nds2
								,'division' => $division
								,'svidetelctvo_regist' => $svidetelctvo_regist  
										
							);
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
								,'arhiv' => '�����'
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
								,'proverka_contragenta' => '�������� �����������'
								,'data_proverki' => '���� ��������'								
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
								,'division' => '�������������'
								,'svidetelctvo_regist' => '������������� � �����������'  
										
							);
							
If ($_POST['NewButton'] == '���������') {
								
	$id = MySQLActionRENT($data,'rent',$id,'update','history_rent',$names,'��������� ������'); //������ ��������������� � ������� rent � ���������� � �������
	
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



/*
If ($_POST['NewButton'] == '���������') {	//���� ���� ������ ������ ��������� � ����� ��������������

		//������ �� ���������� ������ �� ������� POST � �������
		
		$sql = "UPDATE `rent` SET 
			`region` = '".$region."',
			`area` = '".$area."',
			`number` = '".$numBS_MTS."',
			`type_arenda` = '".$type_arenda."',
			`type` = '".$type."',
			`adress` = '".$adress."',
			`settlement` = '".$settlement."',
 
 			`room_area` = '".$room."',
			`roof_area` = '".$roof_walls."',
			`asphalt_pad_area` = '".$asfalt_square."',
			`length_cable` = '".$cabel."',
			`length_canaliz` = '".$canalization."',
			`arendodatel` = '".$arendodatel."',
			`arendator` = '".$arendator."',
 			
			`dogovor_number` = '".$num_dogovor."',
			`dogovor_type` = '".$type_dogovor."',
			`dogovor_date` = '".$data_dogovor."',
			`start_date_dogovor` = '".$start_dogovor."',
			`finish_date_dogovor` = '".$finish_dogovor."',
			`insurance_finish` = '".$finish_strah."',
			 
			`dogovor_AKO` = '".$ako_exist."',
			
 			`PUD` = '".$pud."',
			`own_form` = '".$form_own."',
			`method_form_AP` = '".$method_AP."',
			`ispolnitel` = '".$main_person."',
			`notes` = '".$notes."',
			`contragent_data` = '".$contact."',
			`naznachenie` = '".$naznachenie."',
 			
			`admin_office` = '".$admin_office."',
			`sell_office` = '".$sell_office."',
			`tech_office` = '".$tech_office."',
			`sklady` = '".$sklady."',
			`payment` = '".$payment."',
			`currency` = '".$currency."',
			`type_rent_propety` = '".$type_rent_propety."',
  
			`type_opory` = '".$type_opory."',
			`rent_place_TSH` = '".$rent_place_TSH."',
			`rent_area` = '".$rent_area."',
			 
			`rent_pay_BYN` = '".$byn."',
 			`rent_pay_BAV` = '".$bav."',
			`rent_pay_BV` = '".$bv."',
			`rent_pay_EUR` = '".$eur."',
			`rent_pay_USD` = '".$usd."',
			`nds_pay` = '".$nds."',
			
			`summa` = '".$summa."',
			`type_currency` = '".$type_currency."',
			`nds2` = '".$nds2."',
			`division` = '".$division."',
			`svidetelctvo_regist` = '".$svidetelctvo_regist."'
 	 
			 WHERE `Id` = ".$_GET['Id'];
		     $query = mysql_query($sql) or die(mysql_error());

		if ($sql) {
					echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";	
					echo "<center><b>���������!</b></center>";
					}	

					// ������� �� ���������� �������� edit.php, � ������� ����������� ��������������
						echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";

} else {
		echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";			
		echo '<p>��������� ������: ' . mysql_error(). '</p>';
}
*/
		
		
		 


?>


 
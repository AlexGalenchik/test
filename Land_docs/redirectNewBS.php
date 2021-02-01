<?php
include_once('../config.php');
include_once('../functions.php');
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

function quotes_change ($text) {  //������� �������� ������� �� ������� � ������
	$text = str_replace(' "',' �',$text);
	$right_text = str_replace('"','�',$text);
	
	return $right_text;
}

//�������� ����������
$bts = $_POST['bts'];
$type_opori = $_POST['type_opori'];
$oblast = $_POST['oblast']; 
$raion = $_POST['raion'];
$nas_punkt = $_POST['nas_punkt'];
$adress = quotes_change ($_POST['adress']);
$ispolnitel = $_SESSION['user_surname']." ".substr($_SESSION['user_name'],0,1).".".substr($_SESSION['middle_name'],0,1).".";;

//��� ������ Id ������������ ����� ��� Id ��� ���������� � RENT
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$bts = clean($bts);
$type_opori = clean($type_opori);
$oblast = clean($oblast);
$raion = clean($raion);
$nas_punkt = clean($nas_punkt);
$adress = clean($adress);


///////////////////////////////////////���������� � �������///////////////////////////////////////

			$data_new = array ( //������ ������ �����, ������� ���� ����������
								 'bts' => $bts
								,'type_opori' => $type_opori
								,'oblast' => $oblast
								,'raion' => $raion
								,'nas_punkt' => $nas_punkt
								,'adress' => $adress
								,'ispolnitel' => $ispolnitel
								,'ispolnitel_id' =>	$user_id							//
							);
			$names_new = array ( //������ ������ �����, ������� ���� ����������
								 'bts' => '����� �������'
								,'type_opori' => '��� �����'
								,'oblast' => '�������'
								,'raion' => '�����'
								,'nas_punkt' => '���. �����'
								,'adress' => '�����'
								,'ispolnitel' => '�����������'
								,'ispolnitel_id' => '����������� Id'
							);				
/////////////////////////////////����� ���������� � �������//////////////////////////////////////////

$id = MySQLActionRENT($data_new,'land_docs_minsk','','insert','history_land',$names_new,'���������� �������');
mysqli_close($conn);

$new_url = 'edit_dogovor.php?Id='.$id;

?>

<script>
    var param = '<?php echo $new_url;?>';
    document.location.href=param
</script>



<?php
//�������� ������ �� ������ � �� �����
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//  ����������� � ��
    $conn = connect();

//������ ����� �� Id ��������
$id = $_GET['Id'];

// ����� ������� ������ ������ �� ������� � ��������� Id
$data = select_data_land ($conn);

//����� ������ �� ������� �� ������� �������� ���������� � ���� �������
$selectLand = select_land_documents ($conn);

// �������� ������ � �������� ��� ������� ��������� ������
$array = []; //������ �� �����������. �� ������, ��� ��� ������ � ������� Land_documents
for ($k = 0; $k < count($selectLand) ; $k++) {
    if (empty($selectLand[$k]['notes']) ) {
        array_push($array, $selectLand[$k]['description']);
        echo "<br>";
    }
}

//������������ ���� ��� ���������� ������������ �����
if($_SESSION['reg_user'] == '�����' || $_SESSION['reg_user'] == '����'){
    $file__path = "�������";
    $uploaddir = './files/'.$file__path.'/';
}
else{
    $file__path = $_SESSION['reg_user'];
    $uploaddir = './files/'.$file__path.'/';
}

//������ ����� �� Id ��������
$bts_num = $_GET['Id'];

// ������� ����� ��������� ���������
$data__time = date("Y m d  G:i:s ");

// ������� ��� ����� ��������
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];

//������� ������ "���������" � ����� ����� ��������� ���� �� �������
$str = $_POST['uploadDoc'];

$file_name = $_FILES['uploadfile']['name'];


// ����� �������� ���� �������������� � ��������� ����������� �� �������� � �����

If (($str == '���������') AND !empty($file_name)) { // ��������� ������� ������ "���������" � ������� �� ����
    If (is_dir($uploaddir."id_".$bts_num."/") == FALSE) {
        mkdir($uploaddir."id_".$bts_num."/");
        $uploadfile = $uploaddir."id_".$bts_num."/".basename($file_name);
        var_dump( $uploadfile );
        echo "<br>";

        // �������� ���� �� �������� ��� ���������� �������� ������:
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
            echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
            echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
            echo "<center><b>���������!</b></center>";
        }
    }
    else {
        $uploadfile = $uploaddir."id_".$bts_num."/".basename($file_name);
        // �������� ���� �� �������� ��� ���������� �������� ������:
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
            echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
            echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
            echo "<center><b>���������!</b></center>";
        }
    }
    // ������ �����
    $size__file =round($_FILES['uploadfile']['size']/1024/1024, 2) . " MegaByte";

// ������� ������� � �������. ���� ���� ��� ���� - ��������������, ����� ���������
    if(in_array($file_name, $array) ){

        var_dump("���� ���������� !!!!!" );
        $sql = "UPDATE land_documents SET 
		  ispolnitel = '".$ispolnitel."'
		, data = '".$data__time."'
		, size = '".$size__file."'
		, region = '".$data[0]['oblast']."'
		, type = '".$data[0]['type']."'
		, number = '".$data[0]['bts']."' 
		WHERE description = '".$file_name;

    }
    else{
        $sql = "INSERT INTO land_documents (region, type, number, id_directori, description, path, ispolnitel, data, size) 
            VALUES ('".$data[0]['oblast']."', '".$data[0]['type']."', '".$data[0]['bts']."', '".$bts_num."', 
            '".$file_name."', '".$uploaddir."id_".$bts_num."/".$file_name."',
            '".$ispolnitel."', '".$data__time."', '".$size__file."')";
    }

// �������������� ������ � ��
    if(mysqli_query($conn, $sql)){
        echo '����� ����� ��������� � ����';
    }
    else{
        echo "Error " .$sql. "<br>" . mysqli_error($conn);
    }

    $array = [];

}

else {
   echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
}

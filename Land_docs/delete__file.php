<?php
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

// ������ ��� ������ �����
If (isset($_GET['Id'])) {
    //  ����������� � ��
    $conn = connect();

};

$id_folders = $_GET['Id'];
$id_notes = $_GET['Id_note'];

var_dump($_GET['Id'] );  echo "<br>";
var_dump($id_notes );  echo "<br>";

// ������� ����� ��������� ���������
$data__time = date("Y m d  G:i:s ");

// ������� ��� ����� ��������
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];
var_dump($ispolnitel );  echo "<br>";

// ����� ������� � ������� ����������� ������ ����������� ���������� �� ��������� Id �������
$select_land_documents = select_land_documents($conn);

for ($k = 0; $k <count($select_land_documents) ; $k++) {

    if($select_land_documents[$k]['Id'] == $id_notes) {
        $doc_delete =  $ispolnitel .'<br> '. $data__time;
        $sql = "UPDATE land_documents SET notes = '".$doc_delete."' WHERE Id =".$id_notes;
        // �������� �����
        unlink($select_land_documents[$k]['path']);
    }
}


// �������������� ������ � ��
if(mysqli_query($conn, $sql)){
    echo "Documents deleted";
}
else{
    echo "Error " .$sql. "<br>" . mysqli_error($conn);
}

echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
?>
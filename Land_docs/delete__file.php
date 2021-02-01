<?php
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

// запрос для выбора папки
If (isset($_GET['Id'])) {
    //  подключения к БД
    $conn = connect();

};

$id_folders = $_GET['Id'];
$id_notes = $_GET['Id_note'];

var_dump($_GET['Id'] );  echo "<br>";
var_dump($id_notes );  echo "<br>";

// выводим время занесения документа
$data__time = date("Y m d  G:i:s ");

// выводим кто занес документ
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];
var_dump($ispolnitel );  echo "<br>";

// вызов функцию в которой формируется массив загруженных документов по заданному Id объекта
$select_land_documents = select_land_documents($conn);

for ($k = 0; $k <count($select_land_documents) ; $k++) {

    if($select_land_documents[$k]['Id'] == $id_notes) {
        $doc_delete =  $ispolnitel .'<br> '. $data__time;
        $sql = "UPDATE land_documents SET notes = '".$doc_delete."' WHERE Id =".$id_notes;
        // удаление файла
        unlink($select_land_documents[$k]['path']);
    }
}


// непсредственно запрос в БД
if(mysqli_query($conn, $sql)){
    echo "Documents deleted";
}
else{
    echo "Error " .$sql. "<br>" . mysqli_error($conn);
}

echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
?>
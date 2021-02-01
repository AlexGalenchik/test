<?php
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

// запрос для выбора папки
If (isset($_GET['Id'])) {
    //  подключения к БД
    $conn = connect();

};
//префикс для вывода папки
$prefix= "type_" .$data[0]["type"] . "_number_" . $data[0]["number"] ."_id_" ;

//
$id_folders = $_GET['Id'];
$id_notes = $_GET['Id_note'];

var_dump($id_folders );  echo "<br>";
var_dump($id_notes );  echo "<br>";

// выводим время занесения документа
$data__time = date("Y m d  G:i:s ");

// выводим кто занес документ
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];

// функция выгрузки из rent_documents
function select_rent_documents($conn)    {
    // получение данных из БД
    $sql = "SELECT * FROM  rent_documents  WHERE id_directori like '".$_GET['Id']."' ORDER BY Id DESC ";
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

// вызов функцию
$select_rent_documents = select_rent_documents($conn);

for ($k = 0; $k <count($select_rent_documents) ; $k++) {

    if($select_rent_documents[$k]['Id'] == $id_notes) {
        $doc_delete =  $ispolnitel .'<br> '. $data__time;
        $sql = "UPDATE rent_documents SET notes = '".$doc_delete."' WHERE Id =".$id_notes;
        // удаление файла
        unlink($select_rent_documents[$k]['path']);
    }
}


// непсредственно запрос в БД
if(mysqli_query($conn, $sql)){
    echo "new records createduccesfully";
}
else{
    echo "Error " .$sql. "<br>" . mysqli_error($conn);
}

echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
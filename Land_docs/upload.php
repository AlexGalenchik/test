<?php
//ЗАГРУЗКА ФАЙЛОВ НА СЕРВЕР В БД ЗЕМЛИ
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//  подключения к БД
    $conn = connect();

//делаем папку по Id элемента
$id = $_GET['Id'];

// вызов функцию выбора данных по объекту с выбранным Id
$data = select_data_land ($conn);

//выбор данных из таблицы об истории загрузки документов в виде массива
$selectLand = select_land_documents ($conn);

// создадим массиы и наполним его именами созданных файлов
$array = []; //Массив не формируется. он пустой, так как файлов в таблице Land_documents
for ($k = 0; $k < count($selectLand) ; $k++) {
    if (empty($selectLand[$k]['notes']) ) {
        array_push($array, $selectLand[$k]['description']);
        echo "<br>";
    }
}

//Формирование пути для сохранения загружаемого файла
if($_SESSION['reg_user'] == 'Админ' || $_SESSION['reg_user'] == 'ОАДО'){
    $file__path = "Минская";
    $uploaddir = './files/'.$file__path.'/';
}
else{
    $file__path = $_SESSION['reg_user'];
    $uploaddir = './files/'.$file__path.'/';
}

//делаем папку по Id элемента
$bts_num = $_GET['Id'];

// выводим время занесения документа
$data__time = date("Y m d  G:i:s ");

// выводим кто занес документ
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];

//Нажатие кнопки "Загрузить" и чтобы слово загрузить было на русском
$str = $_POST['uploadDoc'];

$file_name = $_FILES['uploadfile']['name'];


// словл зарузить надо переконвертить в кирилиццу илинаписать на латиницу в файлк

If (($str == 'ЗАГРУЗИТЬ') AND !empty($file_name)) { // Проверяет нажатие кнопки "Загрузить" и выбрана ли файл
    If (is_dir($uploaddir."id_".$bts_num."/") == FALSE) {
        mkdir($uploaddir."id_".$bts_num."/");
        $uploadfile = $uploaddir."id_".$bts_num."/".basename($file_name);
        var_dump( $uploadfile );
        echo "<br>";

        // Копируем файл из каталога для временного хранения файлов:
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
            echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
            echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
            echo "<center><b>СОХРАНЕНО!</b></center>";
        }
    }
    else {
        $uploadfile = $uploaddir."id_".$bts_num."/".basename($file_name);
        // Копируем файл из каталога для временного хранения файлов:
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
            echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
            echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
            echo "<center><b>СОХРАНЕНО!</b></center>";
        }
    }
    // размер файла
    $size__file =round($_FILES['uploadfile']['size']/1024/1024, 2) . " MegaByte";

// вставка запроса в таблицу. если файл уже есть - перезаписываем, иначе вставляем
    if(in_array($file_name, $array) ){

        var_dump("файл существует !!!!!" );
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

// непсредственно запрос в БД
    if(mysqli_query($conn, $sql)){
        echo 'Новые файлы добавлены в Базу';
    }
    else{
        echo "Error " .$sql. "<br>" . mysqli_error($conn);
    }

    $array = [];

}

else {
   echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
}

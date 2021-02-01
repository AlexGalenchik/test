<?php
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

// запрос
If (isset($_GET['Id'])) {
    //  подключения к БД
    $conn = connect();

};


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
echo "<pre>";
//var_dump($select_rent_documents);
echo "</pre>";


// создадим массиы и наполним его именами созданных файлов
$array = [];
for ($k = 0; $k <count($select_rent_documents) ; $k++) {

    if ( empty($select_rent_documents[$k]['notes']) ) {
            array_push($array, $select_rent_documents[$k]['description']);
            var_dump($select_rent_documents[$k]['description']);
            echo "<br>";
    }


}
//var_dump($array);



If (isset($_GET['Id'])) {
    //  подключения к БД
    $conn = connect();
    //выбор данных из таблицы в виде массива
    $data = selectAll($conn);
};

// задаем путь папки
$prefix= "type_" .$data[0]["type"] . "_number_" . $data[0]["number"] ."_id_"  ;

//var_dump($prefix);
echo "<br>";

//указываем путь для папки сохранения документов
// Каталог, в который мы будем принимать файл:

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

//var_dump( $uploaddir );
echo "<br>";
echo "<br>";


// выводим время занесения документа
$data__time = date("Y m d  G:i:s ");

// выводим кто занес документ
$ispolnitel = $_SESSION["user_surname"] . " " . $_SESSION["user_name"] . " " . $_SESSION["middle_name"];

//Создание папки для сохранения документации по БС (Договора...)

If ( ($_POST['uploadDoc'] == 'ЗАГРУЗИТЬ') AND !empty($_FILES['uploadfile']['name']) ) { // Проверяет нажатие кнопки "Загрузить" и выбрана ли файл
	If (is_dir($uploaddir."id_".$bts_num."/") == FALSE) {
		mkdir($uploaddir."id_".$bts_num."/");
        $uploadfile = $uploaddir."id_".$bts_num."/".basename($_FILES['uploadfile']['name']);
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
		$uploadfile = $uploaddir."id_".$bts_num."/".basename($_FILES['uploadfile']['name']);
		// Копируем файл из каталога для временного хранения файлов:
			if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
				echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
				echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
				echo "<center><b>СОХРАНЕНО!</b></center>";
			}
	}
    // размер файла
    $size__file =round($_FILES['uploadfile']['size']/1024/1024, 2) . "MegaByte";
//    var_dump( $size__file );
//    echo "<br>";

// вставка запроса в таблицу. если файл уже есть - перезаписываем, иначе вставляем
    if(in_array($_FILES['uploadfile']['name'], $array) ){

        var_dump("файл существует !!!!!" );
        $sql = "UPDATE rent_documents SET ispolnitel = '".$ispolnitel."', data= '".$data__time."',
        size = '".$size__file."', region = '".$data[0]["region"]."', type = '".$data[0]["type"]."',
        number = '".$data[0]["number"]."'
        WHERE description = '".$_FILES['uploadfile']['name']."' ";

    }
    else{
        $sql = "INSERT INTO rent_documents (region, type, number, id_directori, description, path, ispolnitel, data, size) 
            VALUES ('".$data[0]["region"]."', '".$data[0]["type"]."', '".$data[0]["number"]."', '".$bts_num."', 
            '".$_FILES['uploadfile']['name']."', '".$uploaddir."id_".$bts_num."/".$_FILES['uploadfile']['name']."',
            '".$ispolnitel."', '".$data__time."', '".$size__file."')";
    }

// непсредственно запрос в БД
	if(mysqli_query($conn, $sql)){
        echo "new records createduccesfully";
    }
	else{
        echo "Error " .$sql. "<br>" . mysqli_error($conn);
    }

    $array = [];

}

else {
    echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
}


<?php
//выбор данных из таблицы land_docs_minsk в виде массива
function select_data_land ($conn){
    // получение данных из БД (выбираем все поля из rent кроме первого поля Id)!!!
    $sql = "SELECT * FROM land_docs_minsk WHERE Id = ".$_GET['Id'];
	
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

// функция выгрузки из rent_documents
  function select_land_documents($conn)    {
        // получение данных из БД
        $sql = "SELECT * FROM  land_documents  WHERE id_directori like '".$_GET['Id']."' ORDER BY Id DESC ";

        $result = mysqli_query($conn, $sql);
        $a = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
				$a[] = $row;
            }
        }
        return $a;
    }

//функция отчистки
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value,ENT_QUOTES,'cp1251');
    return $value;
}




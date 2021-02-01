<?php
//ВЫВОД ЗАГРУЖЕННЫХ ДОКУМЕНТОВ - БАЗА ЗЕМЛИ
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//  подключения к БД
    $conn = connect();

// запрос для выбора папки
If (isset($_GET['Id'])) {
    //выбор данных из таблицы в виде массива
    $data = select_data_land($conn);
};
//префикс для вывода папки
//$prefix= "type_" .$data[0]["type"] . "_number_" . $data[0]["number"] ."_id_" ;

// вызов функцию - создание массива из загруженных документов данного Id объекта
    $land_documents = select_land_documents($conn);

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
<!--     <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>ДОКУМЕНТЫ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../rent/Style.css">
    <script defer src="../rent/script.js"></script>

</head>
<body>
<div id="cap" class="container mt-1">
		<div class="row align-self-center">
			<div class="col-12">
					<div  class="container">	
						<div class="row justify-content-end align-items-center">
						    <div class="col-md-12" >
								<a href='dogovor.php?Id=<?=$_GET['Id']?>'><button type="button" class="btn btn-danger" >НАЗАД</button></a>
						  </div>
						</div>
					</div>
			</div>
		</div>
	</div>	 <!--шапка header-->

<div  class="container mt-2">
	<div class="row align-self-center">	
	
			<div class="col-12"style="padding: 2%;">

							
<?php //ВСТАВКА ВЫВОДА ДОКУМЕНТОВ

//указываем путь для папки сохранения документов
// Каталог, в который мы будем принимать файл:

    $file__path = $data[0]['oblast'];
    $uploaddir = './files/'.$file__path;

// заменяем номер БС ID БС
$bts_num = $_GET['Id'];
$dir = $uploaddir."/id_".$id."/";
$i = 0;


//Шапка таблицы вывода
    $out  = "<table id='result_table'>";
    $out .= "<tr>";
    $out .=  "<td id='rs_td'><b><center>№ п\п</center></b></td>";
    $out .=  "<td id='rs_td'><b><center style=\"margin: 25% 0 25% 0;  \">Тип NE</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Номер NE</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Название документа</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Файл зугрузил</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Дата загрузки файла</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Размер файла</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>Документ удален</center></b></td>";
	If ($_SESSION['rights'] == 'w') { //C правами на чтение колонка с сивмолом удаления (крестик) не показывается
	$out .=   "<td id='rs_td'><b><center>Удалить</center></b></td>";
	}
    $out .=   "</tr>";

    for ($k = 0; $k <count($land_documents) ; $k++) {
        $t = $k+1;
//Данные наполнения таблицы
        $out .=   "<tr><td id='rs_td' align='center' width='20px' height='20px'><b>$t</b></td>";
        $out .=   "<td id='rs_td' align='center' width='20px' height='20px'><b>{$land_documents[$k]['type']}</b></td>";
        $out .=   "<td id='rs_td' align='center' width='35px'><b>{$land_documents[$k]['number']}</b></td>";
        if( empty( $land_documents[$k]['notes']) ){ //Если есть примечание, значит документ был удален
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><a target='_blank' href='{$land_documents[$k]['path']}' width='20px'><b>{$land_documents[$k]['description']}</b></td>";
        }
        else {
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><b>{$land_documents[$k]['description']}</b></td>";
        }
        $out .=   "<td id='rs_td' align='center' width='50px'>{$land_documents[$k]['ispolnitel']}</td>";
        $out .=   "<td id='rs_td' align='left' width='140px'>{$land_documents[$k]['data']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$land_documents[$k]['size']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$land_documents[$k]['notes']}</td>";
		If ($_SESSION['rights'] == 'w') {
        $out .=   "<td id='rs_td' align='center' width='20px'><p class='check-delete' position='relative'  data='{$land_documents[$k]['Id']}'>";
			if(empty( $land_documents[$k]['notes'])){
        $out .=   "<a href=''><img src='../pics/_delete_pic.png' style=\"margin: 15% 0 0 0;\"  width='30px'></a> </p></td></tr>";
            }
		}
        else {
            $out .=   "</p></td></tr>";
         }
    }
    $out .=   "</table>";


    echo $out;


echo "</div>";



?>

		</div>	
	</div>
</div>



<script>
    window.onload = function () {

        let CheckDelete = document.querySelectorAll('.check-delete');
        CheckDelete.forEach(function (element) {
            element.onclick = checkDeleteFunction;

        } );

        function checkDeleteFunction(evt) {
            evt.preventDefault();
            console.log( this.getAttribute('data') );

            let a = confirm("Do you want delete?");
            if (a == true) {

                // вставить ссылку на файл удаление файла и обновление записи об удаление файла,
                // добвить полу в таблице - кем когда удалить и не показывать крестик об удаление
                location.href = 'delete__file.php?Id=' + <?=$bts_num?> + '&Id_note=' + this.getAttribute('data');
                console.log("11111111111111111");
            }
            else {
                console.log('2222222222222');
            }
        }
    }
</script>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>

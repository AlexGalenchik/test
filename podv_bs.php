<?php
include_once('config.php');
include_once('functions.php');

$conn = connect();
	$data=select($conn);
 
function connect() {
    // Create connection
    $conn = mysqli_connect("localhost","root","","mts_dbase");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

//выбор данных из таблицы в виде массива
function select($conn)
{
    // получение данных из БД
    $sql = " SELECT ";
	$sql.= " Id";
	$sql.= " ,pbs_number";
	$sql.= " ,vendor";
	$sql.= " ,massa";
	$sql.= " ,status";
	$sql.= " ,type_pbs";
	$sql.= " ,tech";
	$sql.= " ,place";
	$sql.= " ,event";
	$sql.= " ,start_date";
	$sql.= " ,finish_date";
	$sql.= " ,notes";
	$sql.= " FROM podv_bs";
    $sql.= " ORDER BY pbs_number";
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}
 
		//Шапка
 echo "<h4>ПЕРЕЧЕНЬ ВСЕХ ПОДВИЖНЫХ БС (текущее состояние)</h4>";	 
 
// вывод элементов интерфейса
If ($pbs == 'w') {
   echo "<a href = 'index.php?f=49' id='button_edd'>
 <img src='pics/add_pic.png' 
	 width = '24px' align=\"center\"> Добавить ПБС</a> ";
 } 
	echo "<a href = 'index.php?f=54' id='button_edd'> 
	<img src='pics/search_pic.png' width = '24px' align=\"center\"> 
	<b> Поиск мероприятия </b></a>";  
	
	
	
 
    $out  = "<table id='result_table'>";
	$out .= "<tr>";
	$out .=  "<td id='rs_td'><b><center>Info</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Номер ПБС</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Производ.</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Вес</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Статус</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Высота мачты</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Доступные Технологии</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Текущее место<br/>проведения</center></td></b>";
	$out .=   "<td id='rs_td'><b><center>Текущее<br/>Мероприятие</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Начало</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Окончание</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>История</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Примечания</center></b></td>";
	$out .=   "<td id='rs_td'><b><center>Удалить</center></b></td>";
	$out .=   "</tr>";
		
			for ($k = 0; $k <count($data) ; $k++) {
			 
			$out .=   "<tr><td id='rs_td' align='center' width='20px' height='20px'><a href='index.php?f=47&id={$data[$k]['Id']}'><img src='pics/edit_pic.png' width='20px'></td>";
			$out .=   "<td id='rs_td' align='center' width='35px'><b>{$data[$k]['pbs_number']}</b></td>";
			$out .=   "<td id='rs_td' align='center' width='60x'>{$data[$k]['vendor']}</td>";
			$out .=   "<td id='rs_td' align='center' width='45x'>{$data[$k]['massa']}</td>";
			//$out .=   "<td id='rs_td' align='center' width='100x'>{$data[$k]['status']}</td>";
			
			if ($data[$k]['status'] == 'Работает')  {
			$out.=    "<td id='rs_td' width='100px' align='center' style=\"color: red\">{$data[$k]['status']}</td>";
			}
			elseif ($data[$k]['status'] == 'Постоянное место') {
			$out.=    "<td id='rs_td' width='50px' align='center' style=\"color: blue\">{$data[$k]['status']}</td>";
			}
			elseif ($data[$k]['status'] == 'Планируется') {
			$out.=    "<td id='rs_td' width='50px' align='center' style=\"color: blue\">{$data[$k]['status']}</td>";
			}
			elseif  (($data[$k]['status'] == 'Отработано') || ($data[$k]['status'] == 'Ожидает') || ($data[$k]['status'] == 'Резерв'))	{
			$out.=    "<td id='rs_td' width='50px' align='center' style=\"color: green\">{$data[$k]['status']}</td>";
			}
			else {
			$out.=    "<td id='rs_td' width='50px' align='center'>{$data[$k]['status']}</td>";
			}
			
			
			$out .=   "<td id='rs_td' align='center' width='25px' >{$data[$k]['type_pbs']}</td>";
			$out .=   "<td id='rs_td' align='center' width='50px'>{$data[$k]['tech']}</td>";
			$out .=   "<td id='rs_td' align='left' width='230px'>{$data[$k]['place']}</td>";
			$out .=   "<td id='rs_td' align='left' width='130px'>{$data[$k]['event']}</td>";
			$out .=   "<td id='rs_td' align='center' width='60px'>{$data[$k]['start_date']}</td>";
			$out .=   "<td id='rs_td' align='center' width='60px'>{$data[$k]['finish_date']}</td>";
			$out .=   "<td id='rs_td' align='center' width='30px'> <p class='check-history' data-plan='{$data[$k]['pbs_number']}'><a href=''><img src='pics/text.png' width='28px'></a></p></td>";
			$out .=   "<td id='rs_td' align='left' width='250px'>{$data[$k]['notes']}</td>";	
			$out .=   "<td id='rs_td' align='center' width='20px'> <p class='check-delete' data='{$data[$k]['Id']}'><a href=''><img src='pics/_delete_pic.png' width='20px'></a></p></td></tr>";
				}
    $out .=   "</table>";
   
  echo $out;
  
 
  
 mysqli_close($conn);
	 
?>


<script>
    window.onload = function () {
		
        let CheckDelete = document.querySelectorAll('.check-delete');
        CheckDelete.forEach(function (element) {
			 
            element.onclick = checkDeleteFunction;
			
        } );

        function checkDeleteFunction(evt) {
			evt.preventDefault();
			console.log( this.getAttribute('data') );
			console.log( 'http://10.128.217.135/index.php?f=59&id=' + this.getAttribute('data') );
			 
            let a = confirm("Do you want delete?");
            if (a == true) {
					location.href = '/index.php?f=59&id=' + this.getAttribute('data') ;
					console.log("11111111111111111");
			 }
			else {
				console.log('2222222222222');
			}
			
        }
		
	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////	 -->
		let CheckPlan = document.querySelectorAll('.check-history');
        CheckPlan.forEach(function (element) {
			console.log(element.getAttribute('data-plan'));
   			element.onclick = searchPlan;
        } );

        function searchPlan(evt) {
			evt.preventDefault();
			console.log( this.getAttribute('data-plan') );
			console.log( 'http://10.128.217.135/index.php?f=50' );
			 
					location.href = 'http://10.128.217.135/index.php?f=50&id=' + this.getAttribute('data-plan');
					console.log("11111111111111111");
			 			
        }
		 		
    }
</script>
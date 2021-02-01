<?php
include_once('config.php');
include_once('functions.php');

$pbs_number = $_GET['id'];
 
echo "<h4>ПЕРЕЧЕНЬ МЕРОПРИЯТИЙ</h4>";	 //Шапка 

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
    $sql = " SELECT";
	$sql.= " Id";
	$sql.= " ,pbs_number";
	$sql.= " ,status";
	$sql.= " ,event";
	$sql.= " ,place";
	$sql.= " ,gsm_conf";
	$sql.= " ,dcs_conf";
	$sql.= " ,umts_conf";
	$sql.= " ,u900_conf";
	$sql.= " ,lte1800_conf";
	$sql.= " ,lte2600_conf";
	$sql.= " ,start";
	$sql.= " ,finish";
	$sql.= " ,month";
	$sql.= " ,longitudel_s";
	$sql.= " ,longitudel_d";
	$sql.= " ,antenas";
	$sql.= " ,razreshenie";
	$sql.= " ,notes";
	$sql.= " FROM podv_plan";
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
	
	// вывод элементов интерфейса
echo "<a href = 'index.php?f=46'id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\"> 
Перечень ПБС</a> ";
   	if ($pbs == 'w') {
	    echo "<a href = 'index.php?f=51&id=$pbs_number'id='button_edd'><img src='pics/add_pic.png' width = '24px' align=\"center\"> Внести мероприятие</a> ";
		
	 }
	  
 // вывод таблицы
	$out = "<table id='result_table'>";
	$out .= "<tr>";
	$out .=   "<td id='rs_td align='center' width='20px''><b><center>Info</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='35px'><b><center>Номер ПБС</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='60px'><b><center>Статус</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='70px' ><b><center>Мероприятие</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='100px'><b><center>Место<br/>проведения</center></td></b>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>GSM</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>DCS</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>UMTS</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>U900</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>LTE 1800</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>LTE 2600</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='60px'><b><center>Начало</center></b></td>";
	$out .=   "<td id='rs_td' align='left' width='60px'><b><center>Окончание</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='50px'><b><center>Месяц</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='60px'><b><center>Широта</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='60px'><b><center>Долгота</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='120px'><b><center>Антенны</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='40px'><b><center>Разрешения</center></b></td>";
	$out .=   "<td id='rs_td' align='left' width='200px'><b><center>Примечания</center></b></td>";
	$out .=   "<td id='rs_td' align='center' width='20px'><b><center>Удалить</center></b></td>";
	$out .=   "</tr>";
		
			for ($k = 0; $k <count($data) ; $k++) {
				
		 if ($pbs_number == $data[$k]['pbs_number']) {	
		 	$out .=   "<tr><td id='rs_td'><a href='index.php?f=52&id={$data[$k]['Id']}'><img src='pics/edit_pic.png' width='20px'></td>";
			$out .=   "<td id='rs_td'>{$data[$k]['pbs_number']}</td>";
			$out .=   "<td id='rs_td'><center><b>{$data[$k]['status']}</b></center></td>";
			$out .=   "<td id='rs_td'><center><b>{$data[$k]['event']}</b></center></td>";
			$out .=   "<td id='rs_td'>{$data[$k]['place']}</td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['gsm_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['dcs_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['umts_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['u900_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['lte1800_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['lte2600_conf']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['start']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['finish']}</center></td>";
			$out .=   "<td id='rs_td'><center><b>{$data[$k]['month']}</b></center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['longitudel_s']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['longitudel_d']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['antenas']}</center></td>";
			$out .=   "<td id='rs_td'><center>{$data[$k]['razreshenie']}</center></td>";
			$out .=   "<td id='rs_td'>{$data[$k]['notes']}</td>";	
			$out .=   "<td id='rs_td'> <p class='check-delete' data='{$data[$k]['Id']}'><a href=''><img src='pics/_delete_pic.png' width='20px'></a></p></td></tr>";
			 //print_r($data[$k]['Id']);
			}			
		}
    $out .=   "</table>";
     
  echo $out;
  
      
  mysqli_close($conn);
?>


 

<script>
    window.onload = function () {
        let CheckDelete = document.querySelectorAll('.check-delete');
        CheckDelete.forEach(function (element) {
			console.log(element.getAttribute('data'));
            element.onclick = checkDeleteFunction;
        } );

        function checkDeleteFunction(evt) {
			evt.preventDefault();
			console.log( this.getAttribute('data') );
			console.log( '/index.php?f=60&id=' + this.getAttribute('data') );
			 
            let a = confirm("Do you want delete?");
            if (a == true) {
					location.href = '/index.php?f=60&id=' + this.getAttribute('data') ;
					console.log("11111111111111111");
			 }
			else {
				console.log('2222222222222');
			}
			
        }
    }
</script>



 
 
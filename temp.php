<?php


//  веменный файл - можно удалить

include_once('config.php');
include_once('functions.php');
  
$pbs_number = $_GET['id'];
 
echo "<h4>ПЕРЕЧЕНЬ МЕРОПРИЯТИЙ</h4>";	 //Шапка 

 

// вывод элементов интерфейса
echo "<a href = 'index.php?f=46'id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\"> 
Перечень ПБС</a> ";
   	If ($pbs == 'w') {
	    echo "<a href = 'index.php?f=51&id=$pbs_number'id='button_edd'><img src='pics/add_pic.png' width = '24px' align=\"center\"> Внести мероприятие</a> ";
	 }
  
///////////// Вывод всех ПБС в виде таблицы /////////////////////

$sql = " SELECT";
$sql.=" Id"; // Уникальный Id каждого мероприятия
$sql.=", pbs_number";
$sql.=", propiska";
$sql.=", event";
$sql.=" , place";
$sql.=" , start";
$sql.=" , finish";
$sql.=" , month";
$sql.=" , status";
$sql.=" , notes";
$sql.=" FROM podv_plan";
$sql.=" WHERE pbs_number like ".$pbs_number." ORDER BY Id";
$query = mysql_query($sql) or die(mysql_error());

 

 
 
 

  if($query) {
	 //   mysql_num_rows  = Возвращает количество рядов результата запроса
    $rows = mysql_num_rows($query);
  If ($rows > 0) { 	// количество полученных строк
    echo "<table id='result_table'>";
	echo "<tr>";
	If ($pbs == 'w') {
	echo "<td id='rs_td'><b><center>Info</center></b></td>";
	}
	echo "<td id='rs_td'><b><center>Номер ПБС</center></b></td>";
	echo "<td id='rs_td'><b><center>Прописка (ЧТП)</center></b></td>";
	echo "<td id='rs_td'><b><center>Мероприятие</center></b></td>";
	echo "<td id='rs_td'><b><center>Место<br/>проведения</center></td></b>";
	echo "<td id='rs_td'><b><center>Начало</center></b></td>";
	echo "<td id='rs_td'><b><center>Окончание</center></b></td>";
	echo "<td id='rs_td'><b><center>Месяц</center></b></td>";
	echo "<td id='rs_td'><b><center>Статус</center></b></td>";
	echo "<td id='rs_td'><b><center>Примечания</center></b></td>";
	echo "<td id='rs_td'><b><center>Удалить</center></b></td>";
	echo "</tr>";
	
	//Набор данных в таблице
	
	
	for ($i = 0 ; $i < $rows ; ++$i)   { 

// mysql_fetch_row = Обрабатывает ряд результата запроса и возвращает массив с числовыми индексами	
		$row = mysql_fetch_row($query);	
		
		   			//print_r($row[3]);
					//var_dump(count($row));
			
			////Поиск номера id в таблице bts
			echo "<tr>";
			
			for ($j = 0; $j <= 10 ; $j++) {
				   	If ($j == 0) {
					    $id = $row[$j];
				
					    $link = "index.php?f=52&id=$id";
						If ($pbs == 'w') {
				        echo "<td id='rs_td' align='center' width='30px'><a href=".$link."><img src='pics/edit_pic.png' width='20px'></a></td>";
						}
					}
					elseif ($j == 1) {
						echo "<td id='rs_td' align='center' width='30px'>$row[$j]</td>";
				    }
					elseif ($j == 2) {
						echo "<td id='rs_td' align='center' width='50x'>$row[$j]</td>";
				    }
					elseif ($j == 3) {
						echo "<td id='rs_td' align='left' width='175px'>$row[$j]</td>";
				    }
					elseif ($j == 4) {
						echo "<td id='rs_td' align='left' width='175px'>$row[$j]</td>";
				    }
					elseif (($j == 5) || ($j == 6))  {
						echo "<td id='rs_td' align='center' width='80px'>$row[$j]</td>";
				    }
					elseif ($j == 7) {
						echo "<td id='rs_td' align='center' width='120px'>$row[$j]</td>";
				    }
					elseif ($j == 8)  {
						echo "<td id='rs_td' align='center' width='80px'>$row[$j]</td>";
				    }
				 
				
					elseif ($j == 9) {
						echo "<td id='rs_td' align='center' width='105px'>$row[$j]</td>";
				    }
					
					elseif ($j == 10) {
						echo  "<td id='rs_td' align='center' width='30px'> <p class='check-delete' data='{$id}'><a href=''><img src='pics/_delete_pic.png' width='20px'></a></p></td></tr>";
				    }
			}	 				
	          
    }
   
    echo "</table>"; 
  }
 else {
	echo "По данной ПБС мероприятий пока не спланировано";
      }
  
}


//print_r($rows);

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
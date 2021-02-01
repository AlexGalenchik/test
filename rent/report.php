<?php
include_once('../config.php');
include_once('./core/function.php');
session_start();

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}


?>
<!DOCTYPE html>
<html>
<head> 
    <!--<meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " /> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />
    <title>ОТЧЕТЫ - СЧЕТЧИКИ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="Style.css">
    <style type="text/css">
   #table_counter {
		float: left; 
		border: 1px solid red; 
		padding: 2px; 
		margin: 3px; 
		text-align: center;
		font-size:  12px;
		font-family: 'Times New Roman';
		width: 240px;
		height: 265px;
		border-collapse: collapse; 
		border-radius: 4px;
		box-shadow: 0 0 10px rgba(0,0,0,0.7);
		overflow: auto;
		}
	table, td {
		border: 1px solid grey;
		border-collapse: collapse; 
		padding: 2px;
		width: 230px;
		vertical-align: middle;
		}
	#table_head {
		float: left;
		background-color: orange;		
		border: 1px solid red; 
		
		margin: 3px; 
		text-align: center;
		font-size:  14px;
		font-family: 'Times New Roman';
		width: 240px;
		height: 25px;
		border-collapse: collapse; 
		border-radius: 4px;
		box-shadow: 0 0 10px rgba(0,0,0,0.7);
				}
	</style>
</head>
<body>
<!-- шапка header-->
<div id="cap" class="container mt-1" >
    <div class="row align-self-center" >
        <div class="col-12" >
            <div  class="container" >
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="row align-items-center ">
                            <div class="col-md-4 arend">
                                <a href="/rent/geo_finder.php"><button type="button" class="btn btn-danger" >НАЗАД</button></a>
                            </div>
                            <div class="col-md-4">
                                <!--                                        <input class="btn btn-primary" type="submit"  value="РЕДАКТОР">-->
<!--                                <a href="/rent/edit.php?Id=--><?php //echo $_GET['Id'];  ?><!--"><button type="button" class="btn btn-danger" >РЕДАКТОР</button></a>-->
                            </div>
                            <div class="col-md-4">
<!--                                <a href="/rent/new_bs.php"><button type="button" class="btn btn-danger" >NEW ПЛОЩАДКА</button></a>-->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" >
                        <div class="row align-items-center">
                            <!-- ФОРМА АВТОРИЗАЦИИ -->
             <?php
			 
			
                            // блок ввода авторизации
                            if ($_SESSION['user_id'] == 0) {
                                include('/login_form.php');
                            }
                            if ($_SESSION['user_id'] > 0) {
                                echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                         ". $_SESSION['user_surname'] ." 
                                                                         ". $_SESSION['user_name']."
                                                                         ". $_SESSION['middle_name'] ."
																		 [". $_SESSION['reg_user'] ."]
																		 [". $rights ."]																		 
                                                                    </div>
                                                               <div class=\"w-100\"></div>
                                                                    <div class='col'>
                                                                          <a href='/rent/logout.php'><button >выйти</button></a>
																		  "."Online:" . GetUsersOnline()."
                                                                    </div>			
                                                            </div>
                                                            <div id='log_info'  class=\"col-2\">   
                                                                   <img src='../pics/users/".$_SESSION['user_login'].".jpg' >
                                                            </div>                                                         
                                 </div>";
                            }
                            ?>
                        </div>
                    </div>		<!-- КОНЕЦ ФОРМЫ АВТОРИЗАЦИИ -->

                </div>
            </div>
        </div>
    </div>
</div>	 <!--шапка header-->

	<div id="cap" class="container" ><!-- шапка header-->
		   <div class="row align-self-center" ><!-- row header-->
				 
			</div>
	</div>


<?php

include_once('../functions.php');


/////////////////////ФУНКЦИЯ ссуммирования платежей
function Payment ($reg,$type) {
	IF ($reg) {
		If ($reg !== 'БЕЛАРУСЬ' ) { //Если выбран Регион из выпадающего списка
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'"; //`region` заменено на 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - округление вверх со второго знака после запятой
	
    'BYN' => round($row['SUM_rent_pay_BYN'],2,PHP_ROUND_HALF_UP) 
   ,'BAV' => round($row['SUM_rent_pay_BAV'],2,PHP_ROUND_HALF_UP)
   ,'BV' => round($row['SUM_rent_pay_BV'],2,PHP_ROUND_HALF_UP)
   ,'EUR' => round($row['SUM_rent_pay_EUR'],2,PHP_ROUND_HALF_UP)
   ,'USD' => round($row['SUM_rent_pay_USD'],2,PHP_ROUND_HALF_UP)
   ,'summa' => round($row['SUM_summa'],2,PHP_ROUND_HALF_UP)
   
   );
   
   $arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;
   
   
}
//////////////////////////////////ФУНКЦИЯ суммирования параметров помещения
function Room_Cables ($reg,$type) {
	IF ($reg) {
		If ($reg !== 'БЕЛАРУСЬ' ) { //Если выбран Регион из выпадающего списка
			$sql = "SELECT";
			$sql.= " SUM(room_area) as SUM_room_area";
			$sql.= ",SUM(roof_area) as SUM_roof_area";
			$sql.= ",SUM(asphalt_pad_area) as SUM_asphalt_pad_area";
			$sql.= ",SUM(length_cable) as SUM_length_cable";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";      //`region` заменено на 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(room_area) as SUM_room_area";
			$sql.= ",SUM(roof_area) as SUM_roof_area";
			$sql.= ",SUM(asphalt_pad_area) as SUM_asphalt_pad_area";
			$sql.= ",SUM(length_cable) as SUM_length_cable";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - округление вверх со второго знака после запятой
	
    'Площадь Пола' => round($row['SUM_room_area'],2,PHP_ROUND_HALF_UP) 
   ,'Площадь Кровли' => round($row['SUM_roof_area'],2,PHP_ROUND_HALF_UP)
   ,'Площадь Асфальта' => round($row['SUM_asphalt_pad_area'],2,PHP_ROUND_HALF_UP)
   ,'Длина Кабеля' => round($row['SUM_length_cable'],2,PHP_ROUND_HALF_UP)
    );
	
		$arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;

   
	
}
/////////////////ФУНКЦИЯ ссумирования по типу оборудования (FTTX, БС, Репитер, ВОЛС, WI-FI, Коммутатор, метро
function TypeHW ($reg,$type,$hw_type) {
	IF ($reg) {
		If ($reg !== 'БЕЛАРУСЬ' ) { //Если выбран Регион из выпадающего списка
			$sql = "SELECT";
			$sql.= " count(*) as SUM_HW";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";      //`region` заменено на 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$sql.= " AND type like '".$hw_type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " count(*) as SUM_HW";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$sql.= " AND type like '".$hw_type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - округление вверх со второго знака после запятой
	
    $hw_type => $row['SUM_HW'] 
    );
	
	$arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;

   
}

/////////////////////ФУНКЦИЯ ссуммирования платежей по исполнителю
function Payment_Ispolnitel ($reg,$type,$lico) {
	IF ($reg) {
		If ($reg !== 'БЕЛАРУСЬ' ) { //Если выбран Регион из выпадающего списка
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";		//`region` заменено на 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$sql.= " AND ispolnitel like '".$lico."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."' ";
			$sql.= " AND ispolnitel like '".$lico."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - округление вверх со второго знака после запятой
	
    $lico.' BYN' => round($row['SUM_rent_pay_BYN'],2,PHP_ROUND_HALF_UP) 
   ,$lico.' BAV' => round($row['SUM_rent_pay_BAV'],2,PHP_ROUND_HALF_UP)
   ,$lico.' BV' => round($row['SUM_rent_pay_BV'],2,PHP_ROUND_HALF_UP)
   ,$lico.' EUR' => round($row['SUM_rent_pay_EUR'],2,PHP_ROUND_HALF_UP)
   ,$lico.' USD' => round($row['SUM_rent_pay_USD'],2,PHP_ROUND_HALF_UP)
   ,$lico.' summa' => round($row['SUM_summa'],2,PHP_ROUND_HALF_UP)
     
   );
   
   $arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;
   
    	
}


////////////////////////////////////Вывод таблиц о платежах за аренду

echo " <div class='container' >"; 
echo " <div class='row align-self-center' > ";

?>

 
				 <div class="col-4 push-4">
					<br/>
						<form action="" method="post">
							<select class="reg" name="region" >
							<option value="<?php echo $_POST['region'];?>"><?php echo $_POST['region'];?></option>
								<option value=""></option>
								<option value="Брестская">Брестская</option>
								<option value="Витебская">Витебская</option>
								<option value="Гомельская">Гомельская</option>
								<option value="Гродненская">Гродненская</option>
								<option value="Могилевская">Могилевская</option>
								<option value="ОАДО">ОАДО</option>    <!-- Минская заменено на ОАДО -->
								<option value="БЕЛАРУСЬ">БЕЛАРУСЬ</option>
								
								
							</select>
							<input type="submit" name="reg_submit" type="button" value="ВЫБРАТЬ">
						</form>
					<br/>
				</div>
				
				 
			
			<div class="w-100"></div>
			
<?php


if ($_SESSION['user_id'] > 0) { ////Проверка залогинен ли пользователь. Если нет - то ничего не выведет

$region = $_POST['region'];
//////////////////////////////////Выво данных по суммам
echo "<div class='col push-2'>";
echo "<div id='table_head'>";
echo "<td colspan='2'><b>МТС АРЕНДУЕТ РПС</b></td>";
echo "</div>";

echo "<div id='table_head'>";
echo "<td colspan='2'><b>МТС СДАЕТ</b></td>";
echo "</div>";

echo "<div id='table_head'>";
echo "<td colspan='2'><b>МТС Арендует Офисы</b></td>";
echo "</div>";

echo "</div>";

echo "<div class='w-100'></div>";

//////////////////////////////БЛОК с данными

echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ ПО АРЕНДЕ</b></th>";
foreach (Payment ($region,'МТС Арендует РПС') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ ПО АРЕНДЕ</b></th>";
foreach (Payment ($region,'МТС Сдает') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ ПО АРЕНДЕ</b></th>";
foreach (Payment ($region,'МТС Арендует Офисы') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";
echo "</div>";


echo "<div class='w-100'></div>";

///////////////////////////////////////////Вывод данных о арендуемых площадях помещений и длине кабеля
echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛОЩАДИ, ДЛИНА, МЕТРАЖ</b></th>";
foreach (Room_Cables ($region,'МТС Арендует РПС') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛОЩАДИ, ДЛИНА, МЕТРАЖ</b></th>";
foreach (Room_Cables ($region,'МТС Сдает') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛОЩАДИ, ДЛИНА, МЕТРАЖ</b></th>";
foreach (Room_Cables ($region,'МТС Арендует Офисы') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";
echo "</div>";
echo "<div class='w-100'></div>";

///////////////////////////////////////////Вывод данных о количестве договоров для разного типа оборудования
$sql_types = "SELECT DISTINCT type FROM rent";
$query = mysql_query ($sql_types) or die (mysql_error());

$types = array ();

for ($i=0;$i<mysql_num_rows($query);$i++) {
	$row = mysql_fetch_assoc ($query);
	$types[] = $row;
}

echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПО ТИПУ ОБОРУДОВАНИЯ</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'МТС Арендует РПС',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПО ТИПУ ОБОРУДОВАНИЯ</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'МТС Сдает',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПО ТИПУ ОБОРУДОВАНИЯ</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'МТС Арендует Офисы',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";
echo "</div>";
echo "<div class='w-100'></div>";

//////////////////////////////Счетчики по отвественному лицу
///////////////////////////////////////////Вывод данных о количестве договоров для разного типа оборудования
$sql_ispolnitel = "SELECT DISTINCT ispolnitel FROM rent";
$query = mysql_query ($sql_ispolnitel) or die (mysql_error());

$ispolnitels = array ();

for ($i=0;$i<mysql_num_rows($query);$i++) {
	$row = mysql_fetch_assoc ($query);
	$ispolnitels[] = $row;
}
echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ АРЕНДЕ (СОТРУДНИК)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'МТС Арендует РПС',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ АРЕНДЕ (СОТРУДНИК)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'МТС Сдает',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>ПЛАТЕЖИ АРЕНДЕ (СОТРУДНИК)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'МТС Арендует Офисы',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 
echo "</div>";

}
?>



</div>		
</body>
</html>
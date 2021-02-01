<?php
session_start();
include_once('../config.php');
include_once('../functions.php');
include_once('./core/function.php');

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}

$dog_number = $_GET['dog']; //Для создания отчета по отдельному договору
$_SESSION['dog'] = $dog_number; //Перенос в сессию для создания отчета


//var_dump($_SESSION['dog']);

//  подключения к БД - В нашей базе уже есть функция подключения к БД
function connect()
{
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
    // кодировка
    mysqli_set_charset($conn, "cp1251");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$conn = connect();



//выбор данных из таблицы в виде массива
function select($conn){ //пагинация
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) != '') {
        $offset = trim($_GET['page']);
    }

   	 // получение данных из БД
        If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
            $sql = "SELECT * FROM  rent WHERE Id is not NULL";
            If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //Если это не администратор, то он видит всегда свою область
        }

        If (!empty($_SESSION['Areas'])) { //Фильтр по району
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Договора
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
			
        If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
    }

        If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //Фильтр по дате начала действия Договора
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //Фильтр по дате окончания действия Договора
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        $sql .= " AND `dogovor_number` LIKE '".$_GET['dog']."' ";//Вывод записей по номеру договора (Галенчик 23.10.2020)

        If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //Фильтр по подразделению
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != 'Админ') { //Фильтр Ответственный Регион ДОБАВЛЕНО Галенчик 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		
		If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
            $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
		}
	$sql .= " ORDER BY number LIMIT 10 OFFSET " . $offset * 10;
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

$data = select($conn);

//выбор данных для расчета валюты
function selectCurrency($conn)
{
    // получение данных из БД
        If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
            $sql = "SELECT * FROM  rent WHERE Id is not NULL";
            If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //Если это не администратор, то он видит всегда свою область
			$sql .= " AND dogovor_number LIKE '".$_GET['dog']."' ";//Вывод записей по номеру договора (Галенчик 23.10.2020)
        }

        If (!empty($_SESSION['Areas'])) { //Фильтр по району
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Договора
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
        If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
		}

        If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //Фильтр по дате начала действия Договора
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //Фильтр по дате окончания действия Договора
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        //If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
        //    $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        //}

        If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //Фильтр по подразделению
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != 'Админ') { //Фильтр Ответственный Регион ДОБАВЛЕНО Галенчик 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		
		If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
            $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
		}
		
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

$dataCurrency = selectCurrency($conn);

// переменная считающая сумму валюты в запросе
$BAV = 0;
$BAV_NDS = 0;
$BV = 0;
$BV_NDS = 0;
$BYN = 0;
$BYN_NDS = 0;
$USD = 0;
$USD_NDS = 0;
$EUR = 0;
$EUR_NDS = 0;
for ($i = 0; $i <= count($dataCurrency); $i++) {
    if ($dataCurrency[$i]['type_currency'] == 'BYN') {
        $BYN += $dataCurrency[$i]['summa'];
        $BYN_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'БАВ') {
        $BAV += $dataCurrency[$i]['summa'];
        $BAV_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'БВ') {
        $BV += $dataCurrency[$i]['summa'];
        $BV_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'USD') {
        $USD += $dataCurrency[$i]['summa'];
        $USD_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'EUR') {
        $EUR += $dataCurrency[$i]['summa'];
        $EUR_NDS += $dataCurrency[$i]['nds2'];
    }
}

$BAV = number_format($BAV, 2, ',', ' ');
$BYN = number_format($BYN, 2, ',', ' ');
$EUR = number_format($EUR, 2, ',', ' ');
$USD = number_format($USD, 2, ',', ' ');
$BV = number_format($BV, 2, ',', ' ');
$BAV_NDS = number_format($BAV_NDS, 2, ',', ' ');
$BYN_NDS = number_format($BYN_NDS, 2, ',', ' ');
$EUR_NDS = number_format($EUR_NDS, 2, ',', ' ');
$USD_NDS = number_format($USD_NDS, 2, ',', ' ');
$BV_NDS = number_format($BV_NDS, 2, ',', ' ');


// переменная считающая кол-во строк в запросе
$summarow = 0;
function paginationCount($conn)
{
    global $summarow, $BAV, $BV, $BYN, $USD, $EUR;
    // получение данных из БД
        If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
            $sql = "SELECT * FROM  rent WHERE Id is not NULL";
            If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //Если это не администратор, то он видит всегда свою область
        }

        If (!empty($_SESSION['Areas'])) { //Фильтр по району
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Договора
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
        If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
    }

        If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //Фильтр по дате начала действия Договора
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //Фильтр по дате окончания действия Договора
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        //If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
        //    $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        //}

        If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //Фильтр по подразделению
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != 'Админ') { //Фильтр Ответственный Регион ДОБАВЛЕНО Галенчик 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		If (!empty($_GET['dog'])) {
			$sql .= " AND dogovor_number LIKE '".$_GET['dog']."' ";//Вывод записей по номеру договора (Галенчик 23.10.2020)
		}
	

        If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
            $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
		}
	$result = mysqli_query($conn, $sql);
    $result = mysqli_num_rows($result);
    $summarow = $result;
    return ceil($result / 10);
}

$countPage = paginationCount($conn);


?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!--     <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>ДОГОВОР № <?php echo $dog_number; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>

</head>
<body>


<div id="cap" class="container mt-1" ><!-- шапка header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
					<div class="col-md-3 push-9" >
                        <div class="row align-items-center"><!-- row 3 -->
							
                            <!-- ФОРМА АВТОРИЗАЦИИ -->
                            <?php
                            // блок ввода авторизации
                            if ($user_id == 0) {
                                include('/login_form.php');
                            }
                            if ($user_id > 0) {
                                echo  "
                                       <div class=\"col-8\">
                                           <div class='col log_info'>
                                                 ". $_SESSION['user_surname'] ." 
                                                 ". $_SESSION['user_name']."
                                                 ". $_SESSION['middle_name']."
												 [". $_SESSION['reg_user']."]												 
												 [". $rights."]												 
                                            </div>
                                            <div class=\"w-100\"></div>
                                            <div class='col'>
                                                   <a href='logout.php'><button >Выйти</button></a>
												   "."Online:" . GetUsersOnline()."
                                             </div>			
                                       </div>
                                       <div id='log_info'  class=\"col-4\">   
                                             <img src='../pics/users/".$_SESSION['user_login'].".jpg' >
                                       </div>";
                            }
                            ?>
                        </div><!-- row 3 -->
                    </div>


                    <div class="col-md-9 pull-3">
                        <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
                               <a href="/rent/geo_finder.php"><button type="button" class="btn btn-danger" >НАЗАД</button></a> 
                                    
                            </div>

                            <div class="col-md-3  arend">
                                <a href="loadExcelDog.php?dog=<?php echo $dog_number; ?>" target="_blank"><button type="button" class="btn btn-danger" >Выгрузить в EXCEL</button></a>
                            </div>
                            <div class="col-md-3  arend">
<!--                                <button type="button" id="buttonshow" class="btn btn-danger">РАЗВЕРНУТЬ ФИЛЬТРЫ</button>-->
<!--                                <a href="report.php" target="_blank"><button type="button" class="btn btn-danger" >ОТЧЕТЫ</button></a>-->

                            </div>
                            <div class="col-md-3  arend">
<!--                                <a href="reset.php" ><button type="button" class="btn btn-danger" >СБРОСИТЬ ФИЛЬТРЫ</button></a>-->
<!--                                <img  title="развернуть фильтры" id="buttonshow" src='./images/icons8_100.png' >-->
<!--                                <a id="areset"   href="reset.php" > <img  title="сбросить фильтры" id="reset" src="./images/reset_icon.svg" > </a>-->
                            </div>
                        </div>
                    </div>
                </div>		<!-- КОНЕЦ ФОРМЫ АВТОРИЗАЦИИ -->
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->
</div>	 <!--шапка header-->

<?php If ($user_id > 0) {    

    //Вставка формы для поиска по региону и району   


    If (count($countPage)>=0) {
        echo "<div  class=\"container\" >";
        echo "<div class=\"row tablerow\">
   <table>
     <tr>  
        <th class='numberBS'>номер  <br> NE </th>
        	<th class='typePlace'>Тип <br> площадки</th>
		<th class='adress'>адрес</th>

        <th class='arendodatel'>Арендодатель</th>
		<th class='arendodatel'>Арендатор</th>
		<th class='arendodatel'>Вид<br/>Аренды</th>
        <th class='typeDogovor'>Тип <br> договора</th>
		<th class='numDogovor'>Номер<br/>договора</th>
		<th class='dataDogovor'>Дата <br> договора</th>
		<th class='dateStart'>Начало<br/>договора</th>
		<th  class='dateEnd'>Конец<br/>договора</th>
		<th class='typeArendy'>Тип <br> Аренды</th>
		<th class='summa'>Сумма</th>
		<th class='nds2'>НДС</th>
		
		<th  class='kontragent'>Контрагент</th>
 		<th  class='worker'>Исполнитель</th>";
        echo"</tr>";
        for ($i=0; $i<count($data); $i++) {

            if(!empty($data[$i]['number'])){
                $number_NE=$data[$i]['number'];
            }
            else {
                $number_NE='no_numb';
            }

            echo "<tr>";
//            echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$data[$i]['number']}</a></b></center></td>
            echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$number_NE}</a></b></center></td>
	  <td><center>".$data[$i]['type']."</center></td>
      <td>".$data[$i]['region'] . " область  <br>". $data[$i]['area'] ." район <br>". $data[$i]['settlement'] ." <br> ". $data[$i]['adress']."</td>
      <td><center>".$data[$i]['arendodatel']."</center></td>
	  <td><center>".$data[$i]['arendator']."</center></td>
	  <td><center>".$data[$i]['type_arenda']."</center></td>
      <td><center>".$data[$i]['dogovor_type']."</center></td>
	  <td><center>".$data[$i]['dogovor_number']."</center></td>
	  <td><center>".date('d.m.Y',strtotime($data[$i]['dogovor_date']))."</center></td>
	  <td><center>".date('d.m.Y',strtotime($data[$i]['start_date_dogovor']))."</center></td>
	  <td><center>".$data[$i]['finish_date_dogovor']."</center></td>
	  <td><center>".$data[$i]['type_arenda']."</center></td>
	  <td><center>".$data[$i]['summa']." <br> ".$data[$i]['type_currency']."</center></td>";
	  If (!empty($data[$i]['nds2'])) {$cur = $data[$i]['type_currency'];}
	  echo "<td><center>".$data[$i]['nds2']." <br> ".$cur."</center></td>
	  <td><center>".$data[$i]['contragent_data']."</center></td>
	  <td><center>".$data[$i]['ispolnitel']."</center></td>";
            echo "</tr>";
        }

    } else {
        echo "<div  class=\"container mt-2\" >
		<h5><span style=\"color:red;\">Договоров не найдено</span></h5>
		</div>";
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";
    ?>
    </div>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-4 paginat ">

                <?php
                // создаем массив в который заносим все существующий страницы
                $array = [];
                for ($i=0; $i < $countPage; $i++){
                    array_push($array, $i);
                }
                // первая и последняя стр массива
                $firstElement = reset($array);
                $lastElement = end($array);

                // определяем текущую страницу
                if(isset($_GET['page'])){
                    $current = $_GET['page'];
                }
                else{
                    $current=$firstElement;
                }
                // длинна массва
                //                echo count($array);
                $lang = count($array);
                // условия перелистывания
                $Previous = $current - 1;
                $Next=$current + 1;

                if($Previous<0){
                    $Previous=$current;
                }

                if($Next>=$lastElement){
                    $Next=$lastElement;
                }
                if($lang==0){
                    $Next=$current;
                    $lastElement=$current;
                }
                // вывод страниц +1
                $firstElement_d = 1+$firstElement;
                $Previous_d = 1+$Previous;
                $current_d = 1+$current;
                $Next_d = 1+$Next;
                $lastElement_d = 1+$lastElement;


                echo " <nav aria-label=\"...\">";
                echo "   <ul class=\"pagination\">";
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$firstElement\"><sup style=\"color: #0275d8;\">$firstElement_d</sup><img src=\"https://img.icons8.com/color/15/000000/double-left.png\"/></a></li>";
                if($current_d != 1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$Previous\">Previous </a></li>";};
                echo "       <li class=\"page-item active\">";
                echo "           <a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$current\">$current_d <span class=\"sr-only\"> </span></a>";
                echo "       </li>";
                if($current_d != $lastElement+1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$Next\">Next </a></li>";};
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$lastElement\"><img src=\"https://img.icons8.com/color/15/000000/double-right.png\"/><sup style=\"color: #0275d8;\">$lastElement_d</sup></a></li>";
                echo "   </ul>";
                echo "</nav>";
                ?>

            </div>

           
        </div>
    </div>
<?php }

mysqli_close($conn);
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script  src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
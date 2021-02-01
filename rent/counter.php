<?PHP
include_once('../config.php');
include_once('../functions.php');
include_once('./core/function.php');
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

//  подключения к БД
function connect(){
    // Create connection
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
function select($conn,$region)
{
    // получение данных из БД
    $sql = "SELECT * FROM  rent WHERE region like '$region'";
//    $sql = "SELECT * FROM  rent ";

    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

function select2($conn,$ispolnitel)
{
    // получение данных из БД
    $sql = "SELECT * FROM  rent WHERE ispolnitel like '$ispolnitel'";
//    $sql = "SELECT * FROM  rent ";

    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}



function get_result($data) {
// переменная считающая сумму валюты в запросе
    $BAV = 0; $BAV_NDS = 0;
    $BV = 0; $BV_NDS = 0;
    $BYN = 0; $BYN_NDS = 0;
    $USD = 0; $USD_NDS = 0;
    $EUR = 0; $EUR_NDS = 0;

    for ($i = 0; $i <= count($data); $i++) {
        if ($data[$i]['type_currency'] == 'BYN') {
            $BYN += $data[$i]['summa'];
            $BYN_NDS += $data[$i]['nds2'];
        }
        if ($data[$i]['type_currency'] == 'БАВ') {
            $BAV += $data[$i]['summa'];
            $BAV_NDS += $data[$i]['nds2'];
        }
        if ($data[$i]['type_currency'] == 'БВ') {
            $BV += $data[$i]['summa'];
            $BV_NDS += $data[$i]['nds2'];
        }
        if ($data[$i]['type_currency'] == 'USD') {
            $USD += $data[$i]['summa'];
            $USD_NDS += $data[$i]['nds2'];
        }
        if ($data[$i]['type_currency'] == 'EUR') {
            $EUR += $data[$i]['summa'];
            $EUR_NDS += $data[$i]['nds2'];
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
    $arr_AP = array($BYN, $BYN_NDS, $BAV, $BAV_NDS, $EUR, $EUR_NDS, $USD, $USD_NDS, $BV, $BV_NDS);
    return $arr_AP;
};

//$region='Минская';
//$region='';
//$data = select($conn,$region);
//$culc = get_result($data);

//var_dump($culc);

// выводим регионы, создаем массив регионов
$arr_region=[];
$res = mysql_query('SELECT DISTINCT `region` FROM `rent` ');
while($row = mysql_fetch_assoc($res)) {
    if(!empty($row['region'])){
        array_push($arr_region, $row['region']);
//        var_dump($row['region']);
    }
}

// пробегаемся по регионам и создаем массивы с результатами
$arr_currency=[];

for($i = 0; $i < count($arr_region); $i++) {
         $data = select($conn,$arr_region[$i]);
         $region = get_result($data);
         array_push($arr_currency, $region);
}
//echo "<pre>";
//var_dump( $arr_currency);
//echo "</pre>";

// выводим исполнителей, создаем массив регионов
$arr_ispolnitel=[];
$res2 = mysql_query('SELECT DISTINCT `ispolnitel` FROM `rent` ');
while($row2 = mysql_fetch_assoc($res2)) {
    if(!empty($row2['ispolnitel'])){
        array_push($arr_ispolnitel, $row2['ispolnitel']);
//        var_dump($row2['ispolnitel']);
    }
}
//var_dump($arr_ispolnitel);

// пробегаемся по Исполнитеелям и создаем массивы с результатами
$arr_currency2=[];

for($i = 0; $i < count($arr_ispolnitel); $i++) {
    $data2 = select2($conn,$arr_ispolnitel[$i]);
    $ispolnitel = get_result($data2);
    array_push($arr_currency2, $ispolnitel);
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>Аренда МТС</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
</head>

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
                            if ($user_id == 0) {
                                include('/login_form.php');
                            }
                            if ($user_id > 0) {
                                echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                         ". $_SESSION['user_surname'] ." 
                                                                         ". $_SESSION['user_name']."
                                                                         ". $_SESSION['middle_name'] ." 
																		 [". $_SESSION['reg_user'] ."]																		 
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

<div  class="container mt-2"> <!--данные по площадке-->
    <h5>Арендная плата по регионам</h5>
    <div class="row my-1 mx-1">
        <div class="col ">
            <?php
                 echo "<div class=\"row tablerow counter\">
            <table>
                <tr>
                    <th>номер  <br> п\п </th>
                    <th>регион</th>
                    <th>BYN</th>
                    <th>BYN_NDS</th>
                    <th>BAV</th>
                    <th>BAV_NDS</th>
                    <th>EUR</th>
                    <th>EUR_NDS</th>
                    <th>USD</th>
                    <th>USD_NDS</th>
                    <th>BV</th>
                    <th>BV_NDS</th>
                </tr>";
                for ($i=0; $i<count($arr_region); $i++) {
                    $k=1;
                    $k+=$i;
                echo "<tr>";
                    echo "
                    <td><center><b>$k</b></center></td>
                    <td><center>".$arr_region[$i]."</center></td>";

                    for ($j=0; $j<count($arr_currency[$i]); $j++) {
                        echo " <td>".$arr_currency[$i][$j]. " </td>";
                    }
               echo"    </tr>";
                }
           echo "</table>";
        echo "</div>";
    ?>
        </div>

        </div> <!-- Параметры помещения-->
    </div>
</div><!--данные по площадке-->

<div  class="container mt-2"> <!--данные по площадке-->
    <h5>Арендная плата по Сотрудникам </h5>
    <div class="row my-1 mx-1">
        <div class="col ">
            <?php
            echo "<div class=\"row tablerow counter\">
            <table>
                <tr>
                    <th>номер  <br> п\п </th>
                    <th>Сотрудник</th>
                    <th>BYN</th>
                    <th>BYN_NDS</th>
                    <th>BAV</th>
                    <th>BAV_NDS</th>
                    <th>EUR</th>
                    <th>EUR_NDS</th>
                    <th>USD</th>
                    <th>USD_NDS</th>
                    <th>BV</th>
                    <th>BV_NDS</th>
                </tr>";
            for ($i=0; $i<count($arr_ispolnitel); $i++) {
                $k=1;
                $k+=$i;
                echo "<tr>";
                echo "
                    <td><center><b>$k</b></center></td>
                    <td><center>".$arr_ispolnitel[$i]."</center></td>";

                for ($j=0; $j<count($arr_currency2[$i]); $j++) {
                    echo " <td>".$arr_currency2[$i][$j]. " </td>";
                }
                echo"    </tr>";
            }
            echo "</table>";
            echo "</div>";

//            echo "<pre>";
//            var_dump($arr_currency2);
//            echo "</pre>";
//            var_dump(count($arr_currency2));
            ?>
        </div>

    </div> <!-- Параметры помещения-->
</div>
</div><!--данные по площадке-->





<?php
//Выборка по каждой технологии количество БС

//function tech_BS ($region) {
//	$sql = "SELECT";
//	$sql.= " SUM(G) as SUMG";
//	$sql.= ",SUM(D) as SUMD";
//	$sql.= ",SUM(U) as SUMU";
//	$sql.= ",SUM(U9) as SUMU9";
//	$sql.= ",SUM(L18) as SUML18";
//	$sql.= ",SUM(L26) as SUML26";
//	$sql.= ",SUM(IoT) as SUMIoT";
//	$sql.= ",SUM(5G) as SUM5G";
//	$sql.= " FROM bts, areas, regions, settlements";
//	$sql.= " WHERE bts.settlement_id = settlements.Id";
//	$sql.= " AND settlements.area_id = areas.Id";
//	$sql.= " AND areas.region_id = regions.Id";
//	$sql.= " AND regions.region = '".$region."'";
//	$sql.= " AND bts.die_bs is NULL";  // счет только тех БС, которые не отпали
//	$query = mysql_query ($sql) or die (mysql_error());
//	$row = mysql_fetch_assoc ($query);
//
//	$arr = array (
//    'GSM' => $row['SUMG']
//   ,'DCS' => $row['SUMD']
//   ,'U2100' => $row['SUMU']
//   ,'U900' => $row['SUMU9']
//   ,'LTE1800' => $row['SUML18']
//   ,'LTE2600' => $row['SUML26']
//   ,'IoT' => $row['SUMIoT']
//   ,'5G' => $row['SUM5G']
//   );
//
//   return $arr;
//
//}
 






 ?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>

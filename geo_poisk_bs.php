<!--
<div style="float: left;margin:10px;">
<h3>Выберите фильтры</h3>
<form action="" method="POST">
<p>Выберите область:<br>
<select name="Region" size=1> 
<option value=""> </option> 
<option value="Брестская"> Брестская</option>
<option value="Витебская"> Витебская</option>
<option value="Гомельская"> Гомельская</option>
<option value="Гродненская"> Гродненская</option>
<option value="Витебская"> Витебская</option>
<option value="Могилёвская"> Могилёвская</option>
<option value="Минская"> Минская</option>
</select></p>

<p>Выберите район: <br> 
<select name="Areas" size=1>

-->

<?php 
/*
$sql = "SELECT Id,area,region_id FROM areas ORDER BY area";
$query1 = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query1); $i++) {
  $row = mysql_fetch_array($query1);
  $areas[] = $row[1];
} 
array_unshift($areas,'') ; //Добавляет пустой элемент в начало массива
	
for($i=0; $i<count($areas); $i++) { 
	echo "<option value=\"$areas[$i]\"> $areas[$i]</option>";
	} 
	*/
?>

<!--
</select></p>

<p>Выберите технологию: <br> 
<select name="Tech" size=1>
<option value=""> </option> 
<option value="G"> GSM</option>
<option value="D"> DCS</option>
<option value="U"> UMTS</option>
<option value="U9"> U900</option>
<option value="L18"> LTE1800</option>
<option value="L26"> LTE2600</option>
<option value="IoT"> IoT</option>
<option value="5G"> 5G</option>
</select></p>

<p>Выберите тип БС: <br> 
<select name="Type" size=1>
<option value=""> </option> 
<option value="СЕЛО"> СЕЛО</option>
<option value="<50000"> <50000</option>
<option value=">=50000"> >=50000</option>
<option value="БРЕСТ"> БРЕСТ</option>
<option value="ВИТЕБСК"> ВИТЕБСК</option>
<option value="ГРОДНО"> ГРОДНО</option>
<option value="ГОМЕЛЬ"> ГОМЕЛЬ</option>
<option value="МОГИЛЁВ"> МОГИЛЁВ</option>
<option value="МИНСК"> МИНСК</option>
</select></p>

<input type="submit" value="Выгрузить">
</form>
</div> 
-->




<!doctype html>
<html lang="en">
<head>
    <meta charset="windows-1251">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>БС МТС </title>
</head>
<body>

<style>
    .select, .selectDistributs, .selectCity {
        float: left;
        padding: 10px;
    }

    .pressMe{
        clear: left;
    }
    #content{
        overflow-Y: scroll;
    }
   
   .outFilter{
      padding: 10px;
      margin-left: 490px;
      margin-top: -85px;
   }

</style>
<h3><i>Внесите необходимые фильтры для выгрузки перечня БС</i></h3>

<form action="" method="post">
    <div class="select">
        <label for="">Технология <br>
         <select  name="Tech">
                <option value=""></option>
                <option  value="G">GSM</option>
                <option value="D">DCS</option>
                <option value="U">UMTS2100</option>
                <option value="U9">UMTS900</option>
                <option value="L18">LTE1800</option>
                <option value="L26">LTE2600</option>
                <option value="IoT">IoT</option>
                <option value="5G">5G</option>
            </select></label>
    </div>
    <div class="select">
        <label for="">Область <br>
        <select  class="reg" name="Region">
            <option value=""></option>
            <option value="Брестская">Брестская</option>
            <option value="Витебская">Витебская</option>
            <option value="Гомельская">Гомельская</option>
            <option value="Гродненская">Гродненская</option>
            <option value="Минская">Минская</option>
            <option value="Могилёвская">Могилёвская</option>
        </select></label>
    </div>
    

    <div class="selectDistributs">
        <label for="">Районы<br>

        </label>
    </div>
 

    <div class="selectCity">
        <label for="">Город<br>

        </label>
    </div>

    <script defer>

        let arrCity = {
            "Брестская" : [ "", "БРЕСТ", ">=50000" ,"<50000", "СЕЛО" ]
            ,"Витебская" :  ["", "ВИТЕБСК" , ">=50000" ,"<50000", "СЕЛО" ]
            ,"Гомельская" : [ "", "ГОМЕЛЬ" ,">=50000" ,"<50000", "СЕЛО"]
            ,"Гродненская" : [ "", "ГРОДНО"  ,">=50000" ,"<50000", "СЕЛО"]
            ,"Минская" : [ "", "МИНСК" ,">=50000" ,"<50000", "СЕЛО"]
            ,"Могилёвская" : [ "", "МОГИЛЕВ" ,">=50000" ,"<50000", "СЕЛО"]
        };

        let arr = {
            "Брестская" : [ "",	"Барановичский" , "Березовский" , "Брестский" ,	"Ганцевичский" , "Дрогичинский" , "Жабинковский" , "Ивановский" 
							  , "Ивацевичский", "Каменецкий" , "Кобринский" , "Лунинецкий" , "Ляховичский" , "Малоритский" 
							  , "Пинский" , "Пружанский" ,	"Столинский" ]
							  
            ,"Витебская" :  ["", "Бешенковичский" ,	"Браславский" ,	"Верхнедвинский" , "Витебский" , "Глубокский" , "Городокский" ,	"Докшицкий" ,
							"Дубровенский" , "Лепельский" ,	"Лиозненский" ,	"Миорский" , "Оршанский" , "Полоцкий" ,	"Поставский" , "Россонский" ,
							"Сенненский" , "Толочинский" , "Ушачский" ,	"Чашникский" , "Шарковщинский" , "Шумилинский" ]
							
            ,"Гомельская" : [ "", "Брагинский" , "Буда-Кошелевский" , "Ветковский" , "Гомельский" ,	"Добрушский" , "Ельский" , "Житковичский" ,
							"Жлобинский" , "Калинковичский" , "Кормянский" , "Лельчицкий" ,	"Лоевский" , "Мозырский" ,	"Наровлянский" ,
			                "Октябрьский" ,	"Петриковский" , "Речицкий" , "Рогачевский" , "Светлогорский" ,	"Хойникский" , "Чечерский"]
							
            ,"Гродненская" : [ "", "Берестовицкий" , "Волковысский" , "Вороновский" , "Гродненский" , "Дятловский" , "Зельвенский" , "Ивьевский" ,
							"Кореличский" ,	"Лидский" ,	"Мостовский" ,	"Новогрудский" , "Островецкий" , "Ошмянский" , "Свислочский" ,	"Слонимский" ,
							"Сморгонский" ,	"Щучинский"]
			
            ,"Минская" : [ "", "Березинский" , "Борисовский" , "Вилейский" , "Воложинский" , "Дзержинский" , "Клецкий" , "Копыльский" ,	"Крупский" ,
							"Логойский" , "Любанский" , "Минский" ,	"Молодечненский" , "Мядельский" , "Несвижский" , "Пуховичский" , "Слуцкий" ,
							"Смолевичский" , "Солигорский" , "Стародорожский" ,	"Столбцовский" , "Узденский" , "Червенский" ]
				
            ,"Могилёвская" : [ "", "Белыничский" , "Бобруйский" , "Быховский" , "Глусский" , "Горецкий" , "Дрибинский" , "Кировский" , "Климовичский" ,
							"Кличевский" , "Костюковичский" , "Краснопольский" , "Кричевский" , "Круглянский" , "Могилёвский" , "Мстиславский" ,
							"Осиповичский" , "Славгородский" , "Хотимский" , "Чаусский" , "Чериковский" ,"Шкловский" ]
        };

// создаем селект для выбора районов
        let distr = document.querySelector('.selectDistributs');
        var x = document.createElement("SELECT");
        x.setAttribute("id", "mySelect");
        x.setAttribute("name", "Areas");
        distr.appendChild(x);
        // создание   option
        let z = document.createElement("option");
        z.setAttribute("value", "");
        let t = document.createTextNode("Выбрать район");
        z.appendChild(t);
        document.getElementById("mySelect").appendChild(z);

        // создаем селект для выбора ГОРОДОВ
        let city = document.querySelector('.selectCity');
        var selectCity = document.createElement("SELECT");
        selectCity.setAttribute("id", "mySelectCity");
        selectCity.setAttribute("name", "Type");
        city.appendChild(selectCity);
        // создание   option
        let optCity = document.createElement("option");
        optCity.setAttribute("value", "");
        let tip = document.createTextNode("Выбрать тип");
        optCity.appendChild(tip);
        document.getElementById("mySelectCity").appendChild(optCity);



        // функция onchange  срабатывает по изменению областей
        document.querySelector('.reg').onchange = function () {
            // выбираем область в переменную selectRegion
            let option = document.querySelectorAll('.reg option');
            // console.log(option);
            for (let i = 0; i < option.length; i++) {
                if (option[i].selected) {
                    var selectRegion = option[i].value;
                    console.log(selectRegion);
                 }
            }

            function myFunction() {
                // выбираем районны
                for(key in arr) {
                    if (selectRegion == key) {
                        let opt = document.querySelectorAll("#mySelect option");
                        for (let i = 0; i < opt.length; i++) {
                             opt[i].remove();
                        }

                        for (let i = 0; i < arr[key].length; i++) {
                            z = document.createElement("option");
                            z.setAttribute("value", arr[key][i]);
                            t = document.createTextNode(arr[key][i]);
                            z.appendChild(t);
                            document.getElementById("mySelect").appendChild(z);
                        }
                    }
                }

                // выбираем type
                for(key in arrCity) {
                    if (selectRegion == key) {
                        let opt = document.querySelectorAll("#mySelectCity option");
                        for (let i = 0; i < opt.length; i++) {
                            opt[i].remove();
                        }

                        for (let i = 0; i < arrCity[key].length; i++) {
                            optCity = document.createElement("option");
                            optCity.setAttribute("value", arrCity[key][i]);
                            tip = document.createTextNode(arrCity[key][i]);
                            optCity.appendChild(tip);
                            document.getElementById("mySelectCity").appendChild(optCity);
                        }
                    }
                }
            }

            myFunction();
        }

    </script>



    <br>
    <div class="pressMe">
    <input type="submit" value="Выгрузить">
    </div>
</form>


</body>
</html>



<?php

If (count($_POST)>0) {
	
echo "<div class='outFilter'>";
echo "<table id='result_table'>";
echo "<tr align='center'>";
echo "<td id='rs_td' colspan=\"4\" style=\"color:red;font-weight:bold;\">Выбранные фильтры</td>";
echo "<tr align='center'>";  // заголовки
echo "<td id='rs_td'><b>&nbsp;Область</td>";
echo "<td id='rs_td'><b>&nbsp;Район</b></td>";
echo "<td id='rs_td'><b>&nbsp;Технология</b></td>";
echo "<td id='rs_td'><b>&nbsp;Тип нас. пункта</b></td>";
echo "</tr>";
echo "<tr align='center'>";  // выбранные фильтры значения

switch ($_POST[Tech]) {
    case 'G':
        $tech_perehod = 'GSM';
        break;
    case 'D':
        $tech_perehod = 'DCS';
        break;
    case 'U':
        $tech_perehod = 'UMTS';
        break;
	case 'U9':
        $tech_perehod = 'U900';
        break;
	case 'L18':
       $tech_perehod = 'LTE1800';
        break;
	case 'L26':
       $tech_perehod = 'LTE2600';
        break;
	case 'IoT':
        $tech_perehod = 'IoT';
        break;
	case '6G':
       $tech_perehod = '5G';
        break;
}

echo "<td id='rs_td' style=\"color:red;\"><b>".$_POST[Region]."</b></td>";
echo "<td id='rs_td' style=\"color:red;\"><b>".$_POST[Areas]."</b></td>";
echo "<td id='rs_td' style=\"color:red;\"><b>".$tech_perehod."</b></td>";
echo "<td id='rs_td' style=\"color:red;\"><b>".$_POST[Type]."</b></td>";
echo "</tr>";	
echo "</table>";
echo "</div>";
}




if(isset($_POST['Region']) ) {
$reg = $_POST['Region'];
} else {
	$reg ='';
} 
if(isset($_POST['Tech']) ) {
$tech = $_POST['Tech'];
} else {
	$tech ='';
} 
if(isset($_POST['Type']) ) {
$type = $_POST['Type']; 
} else {
	$type ='';
}
if(isset($_POST['Areas']) ) {
$area = $_POST['Areas']; 
} else {
	$area ='';
}

//Основной запрос на выборку
If (count($_POST)>0) {
$sql_search = " SELECT";
$sql_search.="  bts.Id";
$sql_search.=" ,bts.bts_number";
$sql_search.=" ,regions.region";
$sql_search.=" ,areas.area";
$sql_search.=" ,settlements.settlement";
$sql_search.=" ,bts.street_type";
$sql_search.=" ,bts.street_name";
$sql_search.=" ,bts.house_type";
$sql_search.=" ,bts.house_number";
$sql_search.=" ,bts.nas_punkt";
$sql_search.=" ,bts.date_gsm_on";
$sql_search.=" ,bts.date_dcs_on";
$sql_search.=" ,bts.date_umts_on";
$sql_search.=" ,bts.date_umts900_on";
$sql_search.=" ,bts.date_LTE_on";
$sql_search.=" ,bts.date_LTE2600_on";
$sql_search.=" ,bts.date_IoT_on";
$sql_search.=" ,bts.date_5g_on";
$sql_search.=" ,bts.G";
$sql_search.=" ,bts.D";
$sql_search.=" ,bts.U";
$sql_search.=" ,bts.U9";
$sql_search.=" ,bts.L18";
$sql_search.=" ,bts.L26";
$sql_search.=" ,bts.IoT";
$sql_search.=" ,bts.5G";
$sql_search.=" ,gsm_configs.gsm_config";
$sql_search.=" ,dcs_configs.dcs_config";
$sql_search.=" ,umts_configs.umts_config";
$sql_search.=" ,umts900_configs.umts900_config";
$sql_search.=" ,lte_configs.lte_config";
$sql_search.=" ,lte_2600_configs.lte_2600_config";
$sql_search.=" ,IoT_configs.IoT_config";
$sql_search.=" ,5g_configs.5g_config";
$sql_search.=" FROM bts";
$sql_search.=" LEFT JOIN gsm_configs";
$sql_search.=" ON gsm_configs.Id = bts.work_gsm_config_id";
$sql_search.=" LEFT JOIN dcs_configs";
$sql_search.=" ON dcs_configs.Id = bts.work_dcs_config_id";
$sql_search.=" LEFT JOIN umts_configs";
$sql_search.=" ON umts_configs.Id = bts.work_umts_config_id";
$sql_search.=" LEFT JOIN umts900_configs";
$sql_search.=" ON umts900_configs.Id = bts.work_umts9_config_id";
$sql_search.=" LEFT JOIN lte_configs";
$sql_search.=" ON lte_configs.Id = bts.work_lte_config_id";
$sql_search.=" LEFT JOIN lte_2600_configs";
$sql_search.=" ON lte_2600_configs.Id = bts.work_lte2600_config_id";
$sql_search.=" LEFT JOIN IoT_configs";
$sql_search.=" ON IoT_configs.Id = bts.work_IoT_config_id";
$sql_search.=" LEFT JOIN 5g_configs";
$sql_search.=" ON 5g_configs.Id = bts.work_5g_config_id";
$sql_search.=" LEFT JOIN settlements";
$sql_search.=" ON settlements.Id = bts.settlement_id";
$sql_search.=" LEFT JOIN areas";
$sql_search.=" ON areas.Id = settlements.area_id";
$sql_search.=" LEFT JOIN regions";
$sql_search.=" ON regions.Id = areas.region_id";
$sql_search.=" WHERE die_bs is NULL ";
If ($reg<>'') {
$sql_search.=" AND regions.region like '".$reg."' ";
}
If ($area<>'') {
$sql_search.=" AND areas.area like '".$area."' ";
}
If ($type<>'') {
$sql_search.=" AND bts.nas_punkt like '".$type."' ";
}
If ($tech<>'') {
$sql_search.=" AND bts.".$tech." like 1 ";
}
$query_search = mysql_query($sql_search) or die(mysql_error());

}
  // таблица результатов поиска
  $counter_gsm = 0;
  $counter_dcs = 0;
  $counter_umts = 0;
  $counter_u900 = 0;
  $counter_L1800 = 0;
  $counter_L2600 = 0;
  $counter_IoT = 0;
  $counter_5g = 0;
  
If (count($query_search)>0) {
	
  echo "<div>";
  echo "<table id='result_table'>";
  echo "<tr align='center'>";  // заголовки
  echo "<td id='rs_td' style='height:30px;'><b>Инфо</td>";
  echo "<td id='rs_td'><b>&nbsp;номер БС</b></td>";
  echo "<td id='rs_td'><b>&nbsp;область</b></td>";
  echo "<td id='rs_td'><b>&nbsp;район</b></td>";
  echo "<td id='rs_td'><b>&nbsp;нас.пункт</b></td>";
  echo "<td id='rs_td' style='width:170px';><b>&nbsp;адрес</b></td>";
  echo "<td id='rs_td'><b>&nbsp;Тип нас.пункта</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;G</b></td>";
  echo "<td id='rs_td'><b>&nbsp;GSM</b></td>";
  echo "<td id='rs_td'><b>&nbsp;GSM_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;D</b></td>";
  echo "<td id='rs_td'><b>&nbsp;DCS</b></td>";
  echo "<td id='rs_td'><b>&nbsp;DCS_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;U</b></td>";
  echo "<td id='rs_td'><b>&nbsp;UMTS</b></td>";
  echo "<td id='rs_td'><b>&nbsp;UMTS_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;U9</b></td>";
  echo "<td id='rs_td'><b>&nbsp;U900</b></td>";
  echo "<td id='rs_td'><b>&nbsp;U900_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;L18</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE1800</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE1800_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;L26</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE2600</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE2600_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;IoT</b></td>";
  echo "<td id='rs_td'><b>&nbsp;IoT</b></td>";
  echo "<td id='rs_td'><b>&nbsp;IoT_on</b></td>";
  //echo "<td id='rs_td'><b>&nbsp;5G</b></td>";
  echo "<td id='rs_td'><b>&nbsp;5G</b></td>";
  echo "<td id='rs_td'><b>&nbsp;5G_on</b></td>";
  echo "</tr>";
  for ($i=0; $i<mysql_num_rows($query_search); $i++) {
    $row_all = mysql_fetch_array($query_search);
		
		If (($row_all['G'] + $row_all['D'] + $row_all['U'] + $row_all['U9'] + $row_all['L18']+ $row_all['L26']+ $row_all['IoT']+ $row_all['5G']) > 0 ) {
	$counter = $counter+1;
    echo "<tr>";
    echo "<td id='rs_td'><center><a href='index.php?f=17&id=".$row_all['Id']."' title='подробное инфо' target=\"_blank\" ><img src='pics/info_pic.png' width='16' height='16'></a></center></td>";
    echo "<td id='rs_td'><center><b>".$row_all['bts_number']."</b></center></td>";
    echo "<td id='rs_td'><center>".$row_all['region']."</center></td>";
    echo "<td id='rs_td'><center>".$row_all['area']."</center></td>";
    echo "<td id='rs_td'><center>".$row_all['settlement']."</center></td>";
    echo "<td id='rs_td'>".FormatAddress('','',$row_all['street_type'],$row_all['street_name'],$row_all['house_type'],$row_all['house_number'],'','')."</td>";
    echo "<td id='rs_td'><center>".$row_all['nas_punkt']."</center></td>";
	
	
	//echo "<td id='rs_td'><center>".$row_all['G']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['gsm_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_gsm_on']."</center></td>";
	If ($row_all['G'] == 1)  {$counter_gsm++;}
	
	//echo "<td id='rs_td'><center>".$row_all['D']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['dcs_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_dcs_on']."</center></td>";
	If ($row_all['D'] == 1)  {$counter_dcs++;}
	
	//echo "<td id='rs_td'><center>".$row_all['U']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['umts_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_umts_on']."</center></td>";
	If ($row_all['U'] == 1)  {$counter_umts++;}
	
	//echo "<td id='rs_td'><center>".$row_all['U9']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['umts900_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_umts900_on']."</center></td>";
	If ($row_all['U9'] == 1)  {$counter_u900++;}
	
	//echo "<td id='rs_td'><center>".$row_all['L18']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['lte_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_LTE_on']."</center></td>";
	If ($row_all['L18'] == 1)  {$counter_L1800++;}
	
	//echo "<td id='rs_td'><center>".$row_all['L26']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['lte_2600_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_LTE2600_on']."</center></td>";
	If ($row_all['L26'] == 1)  {$counter_L2600++;}
	
	//echo "<td id='rs_td'><center>".$row_all['IoT']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['IoT_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_IoT_on']."</center></td>";
	If ($row_all['IoT'] == 1)  {$counter_IoT++;}
	
	//echo "<td id='rs_td'><center>".$row_all['5G']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['5g_config']."</center></td>";
	echo "<td id='rs_td'><center>".$row_all['date_5g_on']."</center></td>";
	If ($row_all['5G'] == 1)  {$counter_5g++;}
	
	
	echo "</tr>";
		}
	
  } 
    echo "<tr align='center'>";
	echo "<td id='rs_td' colspan = \"7\" style=\"color:red;font-size:14px;font-weight:bold;\">".$counter." Площадки</td>";
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">GSM<br/> ".$counter_gsm."</td>"; //gsm
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">DCS<br/> ".$counter_dcs."</td>"; //dcs
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">UMTS<br/> ".$counter_umts."</td>"; //umts
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">U900<br/> ".$counter_u900."</td>"; //u900
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">L1800<br/> ".$counter_L1800."</td>"; //L18
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">L2600<br/> ".$counter_L2600."</td>"; //L26
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">IoT<br/> ".$counter_IoT."</td>"; //IoT
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">5G<br/> ".$counter_5g."</td>"; //5G
	echo "</tr>";
echo "</table>";
  echo "</div>";
} 
/* 
///////////////////////////////////////////////////////////////ВЫГРУЗКА В EXCEL


// раскомментируйте строки ниже, если файл не будет загружаться
 header("Content-Type: application/force-download");
 header("Content-Type: application/octet-stream");
 header("Content-Type: application/download");

//стандартный заголовок, которого обычно хватает
 header('Content-Type: application/vnd.ms-excel; charset=utf-8');
 header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
 header("Content-Transfer-Encoding: binary ");

//Вывод шапки html Для восприятия Excel-ем 
 echo '
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <meta name="author" content="zabey" />
 <title>Demo</title>
 </head>
 <body>
';

// заголовок таблицы

  echo "<table id='result_table'>";
  echo "<tr align='center'>";  // заголовки
  echo "<td id='rs_td'><b>Инфо</td>";
  echo "<td id='rs_td'><b>&nbsp;номер БС</b></td>";
  echo "<td id='rs_td'><b>&nbsp;область</b></td>";
  echo "<td id='rs_td'><b>&nbsp;район</b></td>";
  echo "<td id='rs_td'><b>&nbsp;нас.пункт</b></td>";
  echo "<td id='rs_td'><b>&nbsp;адрес</b></td>";
  echo "<td id='rs_td'><b>&nbsp;Тип нас.пункта</b></td>";
  echo "<td id='rs_td'><b>&nbsp;GSM</b></td>";
  echo "<td id='rs_td'><b>&nbsp;GSM_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;DCS</b></td>";
  echo "<td id='rs_td'><b>&nbsp;DCS_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;UMTS</b></td>";
  echo "<td id='rs_td'><b>&nbsp;UMTS_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;U900</b></td>";
  echo "<td id='rs_td'><b>&nbsp;U900_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE1800</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE1800_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE2600</b></td>";
  echo "<td id='rs_td'><b>&nbsp;LTE2600_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;IoT</b></td>";
  echo "<td id='rs_td'><b>&nbsp;IoT_on</b></td>";
  echo "<td id='rs_td'><b>&nbsp;5G</b></td>";
  echo "<td id='rs_td'><b>&nbsp;5G_on</b></td>";
  echo "</tr>";

 for ($i=0; $i<mysql_num_rows($query_search); $i++) {
    $row_all = mysql_fetch_array($query_search);
	$counter = $counter+1;
    echo "<tr>";
    echo "<td id='rs_td'><center><a href='index.php?f=17&id=".$row_all['Id']."' title='подробное инфо' target=\"_blank\" ><img src='pics/info_pic.png' width='16' height='16'></a></center></td>";
    echo "<td id='rs_td'><center><b>".$row_all['bts_number']."</b></center></td>";
    echo "<td id='rs_td'><center>".$row_all['region']."</center></td>";
    echo "<td id='rs_td'><center>".$row_all['area']."</center></td>";
    echo "<td id='rs_td'><center>".$row_all['settlement']."</center></td>";
    echo "<td id='rs_td'>".FormatAddress('','',$row_all['street_type'],$row_all['street_name'],$row_all['house_type'],$row_all['house_number'],'','')."</td>";
    echo "<td id='rs_td'><center>".$row_all['nas_punkt']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['gsm_config']."</center></td>";
	
	If ($row_all['gsm_config'] <>'')  {$counter_gsm++;}
	echo "<td id='rs_td'><center>".$row_all['date_gsm_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['dcs_config']."</center></td>";
	
	If ($row_all['dcs_config'] <> '')  {$counter_dcs++;}
	echo "<td id='rs_td'><center>".$row_all['date_dcs_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['umts_config']."</center></td>";
	
	If ($row_all['umts_config'] <> '')  {$counter_umts++;}
	echo "<td id='rs_td'><center>".$row_all['date_umts_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['umts900_config']."</center></td>";
	
	If ($row_all['umts900_config'] <> '')  {$counter_u900++;}
	echo "<td id='rs_td'><center>".$row_all['date_umts900_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['lte_config']."</center></td>";
	
	If ($row_all['lte_config'] <> '')  {$counter_L1800++;}
	echo "<td id='rs_td'><center>".$row_all['date_LTE_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['lte_2600_config']."</center></td>";
	
	If ($row_all['lte_2600_config'] <> '')  {$counter_L2600++;}
	echo "<td id='rs_td'><center>".$row_all['date_LTE2600_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['IoT_config']."</center></td>";
	
	If ($row_all['IoT_config'] <> '')  {$counter_IoT++;}
	echo "<td id='rs_td'><center>".$row_all['date_IoT_on']."</center></td>";
	echo "<td id='rs_td' style=\"color:blue;font-size:12px;font-weight:bold;\"><center>".$row_all['5g_config']."</center></td>";
	
	If ($row_all['5g_config'] <> '')  {$counter_5g++;}
	echo "<td id='rs_td'><center>".$row_all['date_5g_on']."</center></td>";
	echo "</tr>";
	
  } 
    echo "<tr align='center'>";
	echo "<td id='rs_td' colspan = \"7\" style=\"color:red;font-size:14px;font-weight:bold;\">".$counter." Площадки</td>";
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">GSM<br/> ".$counter_gsm."</td>"; //gsm
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">DCS<br/> ".$counter_dcs."</td>"; //dcs
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">UMTS<br/> ".$counter_umts."</td>"; //umts
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">U900<br/> ".$counter_u900."</td>"; //u900
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">L1800<br/> ".$counter_L1800."</td>"; //L18
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">L2600<br/> ".$counter_L2600."</td>"; //L26
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">IoT<br/> ".$counter_IoT."</td>"; //IoT
	echo "<td id='rs_td' colspan = \"2\" style=\"color:red;font-size:14px;font-weight:bold;\">5G<br/> ".$counter_5g."</td>"; //5G
	echo "</tr>";
echo "</table>";
echo '</body></html>';
// не забываем закрывать таблицу, боди и сам хтмл документ 

*/
?>


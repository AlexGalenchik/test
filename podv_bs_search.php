<?php
// входные параметры 
// Задание переменной поискового запроса

// входные параметры
$searchstring = PrvFill('adsearch',$_POST['adsearch']); // Поисковый набор текста
if (isset($_GET['sort'])) {$sort = ' ORDER BY '.$_GET['sort'];}

// формируем элементы - Поле для поиска
echo "<h4>ПОИСК МЕРОПРИЯТИЙ</h4>";
echo "<h1></h1>";
$adsearchinfo = array (
 'el_type' => 'text'
,'value' => $searchstring 
,'id' => 'select_field'
,'name' => 'adsearch'
,'start_line' => true
,'end_line' => true
);

echo "<a href = 'index.php?f=46' id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\"> Перечень ПБС</a> ";
echo "<h1></h1>";
echo "Поиск по номеру ПБС / названию праздника / месту проведения / Месяцу<br/>";
echo "<br/>";

// основной запрос
$search_words=explode(' ',$searchstring);
if (strlen($search_words[0])>0)   {
  $search_where = " WHERE";
  for ($i=0; $i<count($search_words); $i++) {
    $w=$search_words[$i];
    if ($i>0) {$search_where.=" AND";}
      $search_where.=" (pbs_number = '$w' OR event LIKE '%$w%' OR place LIKE '%$w%' OR month LIKE '%$w%')";      
  }
  $sql = "SELECT";
  $sql.= " Id";
  $sql.= " ,pbs_number";
  
  $sql.= " ,event";
  $sql.= " ,place";
  $sql.= " ,start";
  $sql.= " ,finish";
  $sql.= " ,month";
  $sql.= " ,status";
  $sql.= " ,notes";
  $sql.= " FROM podv_plan";
  $sql.= $search_where; // " WHERE 
  $sql.= $sort;
  $query=mysql_query($sql) or die(mysql_error());
}

// вывод элементов интерфейса
echo "<div id='inline'>";
echo "<form action='redirect.php?f=54' method='post' id='bts_list'>";
echo "&nbsp;<img src='pics/search_pic.png' width='18' height='18'>&nbsp;";
FieldEdit($adsearchinfo);
echo "&nbsp;&nbsp;&nbsp;<button type='submit'>поиск</button>";
echo "</form>";
echo "</div>";

// вывод элементов интерфейса

echo "<div>"; 
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">ПБС</span>',$table3);

echo "  </div>";

// таблица результатов поиска
if ((strlen($search_words[0])>0) && (mysql_num_rows($query)>0))   {
  echo "<table id='result_table'>";
	echo "<tr>";
	echo "<td id='rs_td'><b><center>Номер ПБС</center></b></td>";
 
	echo "<td id='rs_td'><b><center>Мероприятие</center></b></td>";
	echo "<td id='rs_td'><b><center>Место<br/>проведения</center></td></b>";
	echo "<td id='rs_td'><b><center>Начало</center></b></td>";
	echo "<td id='rs_td'><b><center>Окончание</center></b></td>";
	echo "<td id='rs_td'><b><center>Месяц</center></b></td>";
	echo "<td id='rs_td'><b><center>Статус</center></b></td>";
	echo "<td id='rs_td'><b><center>Примечания</center></b></td>";
	echo "</tr>";
   for ($i=0; $i<mysql_num_rows($query); $i++) {
    $row = mysql_fetch_array($query);
	
	echo "<tr>";
    echo "<td id='rs_td' width='30px' align='center'>".$row['pbs_number']."</td>";
    echo "<td id='rs_td' width='180px'>".$row['event']."</td>";
    echo "<td id='rs_td' width='180px'>".$row['place']."</td>";
    echo "<td id='rs_td' width='70px' align='center'>".$row['start']."</td>";
    echo "<td id='rs_td' width='70px' align='center'>".$row['finish']."</td>";
    echo "<td id='rs_td' width='100px' align='center'>".$row['month']."</td>";

    if ($row['status'] == 'Работает')  {
			echo    "<td id='rs_td' width='100px' align='center' style=\"color: red\">".$row['status']."</td>";
			}
			elseif ($row['status'] == 'Постоянное место') {
			echo   "<td id='rs_td' width='50px' align='center' style=\"color: blue\">".$row['status']."</td>";
			}
			elseif ($data[$k]['status'] == 'Планируется') {
			echo   "<td id='rs_td' width='50px' align='center' style=\"color: blue\">".$row['status']."</td>";
			}
			elseif  (($data[$k]['status'] == 'Отработано') || ($data[$k]['status'] == 'Ожидает') || ($data[$k]['status'] == 'Резерв'))	{
			echo    "<td id='rs_td' width='50px' align='center' style=\"color: green\">".$row['status']."</td>";
			}
			else {
			echo    "<td id='rs_td' width='50px' align='center'>".$row['status']."</td>";
			}
	echo "<td id='rs_td' width='190px'>".$row['notes']."</td>";
    echo "</tr>";
  } 
  echo "</table>";
   
} else {
	
	echo "<h4>Мероприятий по этому запросу не найдено<br/>Попробуйте другой запрос</h4>";
}

?>
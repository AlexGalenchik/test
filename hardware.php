<?php 

include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];

////////////////////////////////////////////////////////////////ПОИСК по НОМЕРУ БС///////////////////////////////////

 //входные параметры
$searchstring = PrvFill('adsearch',$_POST['adsearch']);
if (isset($_GET['sort'])) {$sort = ' ORDER BY '.$_GET['sort'];}

// формируем элементы
$searchinfo = array (
 'el_type' => 'text'
,'id' => 'select_field_small'
,'name' => 'bts_number'
,'start_line' => true
,'end_line' => true
);

// вывод элементов интерфейса

// блок интерфейса выбора и поиска
echo "<div id='inline'>";
echo "<p><form action='redirect.php?f=55' method='post'>Введите номер БС:&nbsp;&nbsp;&nbsp;";
FieldEdit($searchinfo);
echo "&nbsp;&nbsp;&nbsp;<button type='submit'>выбрать</button>";
echo "</form></p>";
echo "</div>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// основной запрос
$sql="SELECT";
$sql.= " bts_number";
$sql.= ",site_type";
$sql.= ",place_owner";
$sql.= ",cooperative";
$sql.= ",settlements.type";
$sql.= ",settlement";
$sql.= ",area";
$sql.= ",region";
$sql.= ",street_type";
$sql.= ",street_name";
$sql.= ",house_type";
$sql.= ",house_number";
$sql.= ",date_gsm_on";
$sql.= ",date_gsm_off";
$sql.= ",date_dcs_on";
$sql.= ",date_dcs_off";
$sql.= ",date_umts_on";
$sql.= ",date_umts_off";
$sql.= ",date_umts900_on";
$sql.= ",date_umts900_off";
$sql.= ",date_LTE_on";
$sql.= ",date_LTE_off";
$sql.= ",date_LTE2600_on";
$sql.= ",date_LTE2600_off";
$sql.= ",date_IoT_on";
$sql.= ",date_IoT_off";
$sql.= ",G";
$sql.= ",D";
$sql.= ",U";
$sql.= ",U9";
$sql.= ",L18";
$sql.= ",L26";
$sql.= ",IoT";
$sql.= ",work_gsm.gsm_config as work_gsm_config";
$sql.= ",work_dcs.dcs_config as work_dcs_config";
$sql.= ",work_umts.umts_config as work_umts_config";
$sql.= ",work_umts9.umts900_config as work_umts9_config";
$sql.= ",work_lte.lte_config as work_lte_config";
$sql.= ",work_lte2600.lte_config as work_lte2600_config";
$sql.= ",work_IoT.lte_config as work_IoT_config";
$sql.= " FROM bts";
$sql.= " LEFT JOIN gsm_configs work_gsm";
$sql.= " ON bts.work_gsm_config_id=work_gsm.id";
$sql.= " LEFT JOIN dcs_configs work_dcs";
$sql.= " ON bts.work_dcs_config_id=work_dcs.id";
$sql.= " LEFT JOIN umts_configs work_umts";
$sql.= " ON bts.work_umts_config_id=work_umts.id";
$sql.= " LEFT JOIN umts900_configs work_umts9";
$sql.= " ON bts.work_umts9_config_id=work_umts9.id";
$sql.= " LEFT JOIN lte_configs work_lte";
$sql.= " ON bts.work_lte_config_id=work_lte.id";
$sql.= " LEFT JOIN lte_configs work_lte2600";
$sql.= " ON bts.work_lte2600_config_id=work_lte2600.id";
$sql.= " LEFT JOIN lte_configs work_IoT";
$sql.= " ON bts.work_IoT_config_id=work_IoT.id";
$sql.= " LEFT JOIN settlements";
$sql.= " ON bts.settlement_id=settlements.id";
$sql.= " LEFT JOIN areas";
$sql.= " ON settlements.area_id=areas.id";
$sql.= " LEFT JOIN regions";
$sql.= " ON areas.region_id=regions.id";
$sql.= " WHERE bts.Id=".NumOrNull($id); 
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

// Запрос по BBU из таблицы bbu
$sql="SELECT";
$sql.=" bbu2g"; 
$sql.=",bbu3g"; 
$sql.=",bbu3900";  
$sql.=",bbu3910";
$sql.=",bbu3910A3";
$sql.=",virtual_micro";
$sql.=",rhub";   
$sql.=",single_bbu";
$sql.= " FROM hw_bbu";
$sql.= " WHERE bts_id=".NumOrNull($id); 
$query2 = mysql_query($sql) or die(mysql_error());
$row1 = mysql_fetch_array($query2);

// Запрос по RRU из таблицы rru
$sql="SELECT";
$sql.=" cell_name";
$sql.=",tech";
$sql.=",locell"; 
$sql.=",ne_name";
$sql.=",sector";
$sql.=",rru";  
$sql.= " FROM hw_rru";
$sql.= " WHERE bts_id=".NumOrNull($id); 
$sql.= " ORDER BY ne_name, tech, sector";
$query3 = mysql_query($sql) or die(mysql_error());

// Запрос по Boards из таблицы hw_boards
$sql="SELECT";
$sql.=" bbu_num";
$sql.=",position";
$sql.=",board"; 
$sql.=",hw_boards_types.class as board_class";
$sql.= " FROM hw_boards";
$sql.= " LEFT JOIN hw_boards_types";
$sql.= " ON hw_boards_types.board_type = hw_boards.board";
$sql.= " WHERE bts_id=".NumOrNull($id);
$sql.= " ORDER BY bbu_num, position"; 
$query4 = mysql_query($sql) or die(mysql_error());



// формируем элементы БС (Общие параметры БС)
$info1 = array (
  $row['site_type'] => "<b><span style=color:red;\">".$row['bts_number']."</b>"
  ,'адрес' =>  FormatAddress($row['type'],$row['settlement'],$row['street_type'],$row['street_name'],$row['house_type'],$row['house_number'],$row['area'],$row['region'])  
  ,'размещение' => $row['place_owner']
  ,'тип сайта' => $row['site_type']
  ,'кооперация' => $row['cooperative']
  
);    
// BBU информация
$info2 = array (
    '2G only' => $row1['bbu2g']
   ,'3G only' => $row1['bbu3g']
   ,'2G+3G' => $row1['single_bbu']
 );  


// BBU таблица

$table1 = array (
   array ('Тип BBU','3900','3910','Blade','Micro','RHUB')
  ,array ('Состав BBU',$row1['bbu3900'],$row1['bbu3910'],$row1['bbu3910A3'],$row1['virtual_micro'],$row1['rhub'])
 
     
);
// Данные по рабочим конфигурациям всех технологий

$table2 = array (
   array ('Технология',' Наличие','   Вкл.','    Выкл.','Раб. Конфиг.')
  ,array ('GSM',$row['G'],$row['date_gsm_on'],$row['date_gsm_off'],$row['work_gsm_config'])
  ,array ('DCS',$row['D'],$row['date_dcs_on'],$row['date_dcs_off'],$row['work_dcs_config'])
  ,array ('UMTS',$row['U'],$row['date_umts_on'],$row['date_umts_off'],$row['work_umts_config'])
  ,array ('U900',$row['U9'],$row['date_umts900_on'],$row['date_umts900_off'],$row['work_umts9_config'])
  ,array ('LTE1800',$row['L18'],$row['date_LTE_on'],$row['date_LTE_off'],$row['work_lte_config'])
  ,array ('LTE2600',$row['L26'],$row['date_LTE2600_on'],$row['date_LTE2600_off'],$row['work_lte2600_config'])
  ,array ('IoT',$row['IoT'],$row['date_IoT_on'],$row['date_IoT_off'],$row['work_IoT_config'])
  
);



// RRU Таблица
$table3 = array (
   array ('BTS','Tech','Cell','Locell','Sector','RRU')
); 

for ($j=0; $j< mysql_num_rows($query3); $j++) {
  $row2 = mysql_fetch_array($query3);
    $table3[] = array(
	 $row2['ne_name'] 
    ,"<b>".$row2['tech']."</b>"
	,$row2['cell_name']
	,$row2['locell']
	,$row2['sector']
	,$row2['rru']
	);
 
}

// Общие данные по RRU
$info3 = array();
  

// Board Таблица
$table4 = array (
   array ('BBU_num','Position','Board','Class')
); 

for ($i=0; $i<= mysql_num_rows($query4); $i++) {
  $row3 = mysql_fetch_array($query4);
 
    $table4[] = array(
	 $row3['bbu_num']
	,$row3['position']
	,"<b>".$row3['board']."</b>" 
	,"<i>".$row3['board_class']."<i>"
   );
   
 
}


/*  
// блок списка кнопок действий
if ($bm == 'w' || ($fm == 'w' && $_SESSION['enable_to_edit'] == 1) ) {
  $info=array (
     'Редактировать BBU' => "index.php?f=56&id=$id"
    ,'Редактировать RRU' => "index.php?f=57&id=$id"
    ,'Редактировать Платы' => "index.php?f=58&id=$id"
   
	
);

  ActionBlock($info);
}
*/
// вывод элементов интерфейса

// вывод элементов интерфейса
If (isset($id)) {
echo "<div>";
echo "  <div id='info_left_indent'>";   
InfoBlock('bts_info_block',$info=array($info1),'<span style="color: red;">Базовая станция</span>',$table2);
InfoBlock('bts_info_block',$info=array($info2),'<span style="color: red;">BBU </span><span style="color: blue;">(<i>Обновлено 27.05.2020</i>)</span>',$table1);
InfoBlock('bts_info_block',$info=array($info3),'<span style="color: red;">Платы </span><span style="color: blue;">(<i>Обновлено 27.05.2020</i>)</span>',$table4);
echo "  </div>";
echo "  <div id='info_right_indent'>";
InfoBlock('bts_ad_info_block',$info=array($info3),'<span style="color: red;">RRU </span><span style="color: blue;">(<i>Обновлено 27.05.2020</i>)</span>',$table3); 

echo "  </div>";
echo "</div>";
}


?>

 

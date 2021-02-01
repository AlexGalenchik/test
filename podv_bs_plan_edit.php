<?php
include_once('config.php');
include_once('functions.php');
session_start();

//Связка с прошлой формой. Передача id мероприятия
$event_id = $_GET['id'];

// основной запрос
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
	$sql.= " ,notes";
	$sql.= " FROM podv_plan";  
    $sql.=" WHERE Id = '$event_id'"; 
    $query = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($query);

// получаем номер БС
$pbs_id = $row['pbs_number'];

//Запросы по конфигурациям
$sql = "SELECT gsm_config,Id FROM gsm_configs ORDER BY gsm_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $gsm_config[] = array('value' => $row2[0], 'display' => $row2[0]);
}
$sql = "SELECT dcs_config,Id FROM dcs_configs ORDER BY dcs_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $dcs_config[] = array('value' => $row2[0], 'display' => $row2[0]);
} 
$sql = "SELECT umts_config,Id FROM umts_configs ORDER BY umts_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $umts_config[] = array('value' => $row2[0], 'display' => $row2[0]);
} 
$sql = "SELECT umts900_config,Id FROM umts900_configs ORDER BY umts900_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $umts900_config[] = array('value' => $row2[0], 'display' => $row2[0]);
} 
$sql = "SELECT lte_config,Id FROM lte_configs ORDER BY lte_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_config[] = array('value' => $row2[0], 'display' => $row2[0]);
}
$sql = "SELECT lte_2600_config,Id FROM lte_2600_configs ORDER BY lte_2600_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_2600_config[] = array('value' => $row2[0], 'display' => $row2[0]);
} 

echo "<h4>РЕДАКТОР МЕРОПРИЯТИЯ ПБС ".$pbs_id."</h4>";

echo "<div>";
echo "<a href = 'index.php?f=50&id=$pbs_id' id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\"> План ПБС ".$pbs_id."</a>";

 

echo "<h1></h1>";
echo "</div>";




// формируем элементы
$info[] = $info1 = array (
 'field' => 'Уникальный Id мероприятия'
 ,'value' => PrvFill('Id',$row['Id'])
 ,'el_type' => 'text'
 ,'id' => 'text_field_podv'
 ,'name' => 'Id'
 ,'disabled' => true
 ,'required' => true
 );
 
$info[] = $info1 = array (
  'field' => 'Номер ПБС'
  ,'value' => PrvFill('pbs_number',$row['pbs_number'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv'
  ,'name' => 'pbs_number'
  ,'disabled' => true
  ,'required' => true
);
$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'Работает', 'display'=>'Работает')
  ,array ('value'=>'Планируется', 'display'=>'Планируется')
  ,array ('value'=>'Постоянно', 'display'=>'Постоянно')
  ,array ('value'=>'Отработано', 'display'=>'Отработано')
  ,array ('value'=>'В ремонте', 'display'=>'В ремонте')
  ,array ('value'=>'Резерв', 'display'=>'Резерв')
  );

$info[] = $info1 = array (
   'field' => 'Статус'
  ,'value' => PrvFill('status',$row['status'])
  ,'el_type' => 'select'
  ,'id' => 'text'
  ,'name' => 'status'
  ,'list' => $list
  ,'required' => true
);

$info[] = $info1 = array (
   'field' => 'Мероприятие'
  ,'value' => PrvFill('event',$row['event'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv'
  ,'name' => 'event'
  
);
$info[] = $info1 = array (
   'field' => 'Место размещения'
  ,'value' => PrvFill('place',$row['place'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv'
  ,'name' => 'place'
  );

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($gsm_config); $i++) {
    $list[] = array('value' => $gsm_config[$i]['value'], 'display' => $gsm_config[$i]['display']);  
}

$info[] = $info1 = array (
   'field' => 'GSM план'
  ,'value' => PrvFill('gsm_config',$row['gsm_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'gsm_conf'
  ,'list' => $list
   
  );
  
  $list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($dcs_config); $i++) {
    $list[] = array('value' => $dcs_config[$i]['value'], 'display' => $dcs_config[$i]['display']);  
}  
  
$info[] = $info1 = array (
   'field' => 'DCS план'
  ,'value' => PrvFill('dcs_config',$row['dcs_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'dcs_conf'
  ,'list' => $list
  );

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts_config); $i++) {
    $list[] = array('value' => $umts_config[$i]['value'], 'display' => $umts_config[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => 'UMTS план'
  ,'value' => PrvFill('umts_config',$row['umts_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'umts_conf'
  ,'list' => $list
  );

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts900_config); $i++) {   
    $list[] = array('value' => $umts900_config[$i]['value'], 'display' => $umts900_config[$i]['display']);  
} 

$info[] = $info1 = array (
   'field' => 'U900 план'
  ,'value' => PrvFill('umts900_config',$row['umts900_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'u900_conf'
  ,'list' => $list
  );
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_config); $i++) {
    $list[] = array('value' => $lte_config[$i]['value'], 'display' => $lte_config[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => 'LTE 1800 план'
  ,'value' => PrvFill('lte_config',$row['lte_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'lte1800_conf'
  ,'list' => $list
  );
  
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_2600_config); $i++) {
    $list[] = array('value' => $lte_2600_config[$i]['value'], 'display' => $lte_2600_config[$i]['display']);  
}   
  
$info[] = $info1 = array (
   'field' => 'LTE 2600 план'
  ,'value' => PrvFill('lte_2600_config',$row['lte_2600_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv'
  ,'name' => 'lte2600_conf'
  ,'list' => $list
  );

$info[] = $info1 = array (
   'field' => 'Дата начала'
  ,'value' => PrvFill('start',$row['start'])
  ,'el_type' => 'date'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'start'
  
);
$info[] = $info1 = array (
   'field' => 'Дата окончания'
  ,'value' => PrvFill('finish',$row['finish'])
  ,'el_type' => 'date'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'finish'
  
);

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'Январь', 'display'=>'Январь')
  ,array ('value'=>'Февраль', 'display'=>'Февраль')
  ,array ('value'=>'Март', 'display'=>'Март')
  ,array ('value'=>'Апрель', 'display'=>'Апрель')
  ,array ('value'=>'Май', 'display'=>'Май')
  ,array ('value'=>'Июнь', 'display'=>'Июнь')
  ,array ('value'=>'Июль', 'display'=>'Июль')
  ,array ('value'=>'Август', 'display'=>'Август')
  ,array ('value'=>'Сентябрь', 'display'=>'Сентябрь')
  ,array ('value'=>'Октябрь', 'display'=>'Октябрь')
  ,array ('value'=>'Ноябрь', 'display'=>'Ноябрь')
  ,array ('value'=>'Декабрь', 'display'=>'Декабрь')
  );

$info[] = $info1 = array (
   'field' => 'Месяц'
  ,'value' => PrvFill('month',$row['month'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'month'
  ,'list' => $list
  //,'required' => true
);

$info[] = $info1 = array (
 'field' => 'Широта'
,'value' => PrvFill('longitudel_s',$row['longitudel_s'])
,'el_type' => 'text'
,'id' => 'text_field_podv'
,'name' => 'longitudel_s'
);

$info[] = $info1 = array (
 'field' => 'Долгота'
,'value' => PrvFill('longitudel_d',$row['longitudel_d'])
,'el_type' => 'text'
,'id' => 'text_field_podv'
,'name' => 'longitudel_d'
);

$info[] = $info1 = array (
 'field' => 'Антенны'
,'value' => PrvFill('antenas',$row['antenas'])
,'el_type' => 'text'
,'id' => 'text_field_podv'
,'name' => 'antenas'
);

$info[] = $info1 = array (
 'field' => 'Разрешение'
,'value' => PrvFill('razreshenie',$row['razreshenie'])
,'el_type' => 'text'
,'id' => 'text_field_podv'
,'name' => 'razreshenie'
);

$info[] = $info1 = array (
 'field' => 'Примечания'
,'value' => PrvFill('notes',$row['notes'])
,'el_type' => 'textarea'
,'id' => 'text_field_podv'
,'name' => 'notes'
);

//echo "<pre>";
//print_r ($info);
//echo "</pre>";
// вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
	FieldName($info[$i]);
}

echo "</div>";
echo "<div id='left_indent'>";
echo "<form action='index.php?f=53&id=$event_id' method='post' id='podv_bs_plan_edit'>";
for ($i=0;$i<count($info);$i++) {
  FieldEdit($info[$i]);
}
if ($pbs == 'w') {
echo "<button type='submit' style=\"color: red;\" >сохранить</button>";
}
echo "</form>";
echo "</div>";
?>
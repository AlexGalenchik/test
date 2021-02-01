<?php
// входные параметры
$id=$_GET['id'];

// основной запрос
$sql = "SELECT"; 
$sql.=" repeater_number";
$sql.=",inventory_number";
$sql.=",settlement_id";
$sql.=",street_type";
$sql.=",street_name";
$sql.=",house_type";
$sql.=",house_number";
$sql.=",place_owner";
$sql.=",rep_diapazon_id";
$sql.=",gsm_config_id";
$sql.=",dcs_config_id";
$sql.=",umts_config_id";
$sql.=",umts9_config_id";
$sql.=",date_rep_insert_expl";
$sql.=",date_rep_on";
$sql.=",date_rep_off";
$sql.=",R";
$sql.=",repeater_type_id";
$sql.=",power_type_id";
$sql.=",longitudel_s";
$sql.=",longitudel_d";
$sql.=",notes";
$sql.=" FROM repeaters"; 
$sql.=" WHERE Id='$id'"; 
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query); 

$sql = "SELECT";
$sql.=" area_id";
$sql.=",area";
$sql.=",region_id";
$sql.=",region";
$sql.=",CONCAT(type,' ',settlement) as settlement";
$sql.=" FROM settlements";
$sql.=" LEFT JOIN areas";
$sql.=" ON settlements.area_id=areas.id";
$sql.=" LEFT JOIN regions";
$sql.=" ON areas.region_id=regions.id";
$sql.=" WHERE settlements.id=".StrOrNull(PrvFill('settlement_id',$row['settlement_id']));
$query = mysql_query($sql) or die(mysql_error());
$setlrow = mysql_fetch_array($query);

$sql = "SELECT gsm_config,Id FROM gsm_configs ORDER BY gsm_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $gsm_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
} 
$sql = "SELECT dcs_config,Id FROM dcs_configs ORDER BY dcs_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $dcs_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
} 
$sql = "SELECT umts_config,Id FROM umts_configs ORDER BY umts_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $umts_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
$sql = "SELECT umts900_config,Id FROM umts900_configs ORDER BY umts900_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $umts900_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}

// формируем элементы
if ($id>0) $disabled = true;
$info[] = $info1 = array (
   'field' => 'Номер репитера'
  ,'value' => PrvFill('repeater_number',$row['repeater_number'])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'repeater_number'
  ,'disabled' => $disabled
);
$info[] = $info1 = array (
  'el_type' => 'break'
);

$info[] = $info1 = array (
   'value' => PrvFill('settlement_id',$row['settlement_id'])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'settlement_id'
  ,'hidden' => true
  ,'required' => true
);
$info[] = $info1 = array (
   'value' => $setlrow['area_id']
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'area_id'
  ,'hidden' => true
);
$info[] = $info1 = array (
   'value' => $setlrow['region_id']
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'region_id'
  ,'hidden' => true
);
$info[] = $info1 = array (
   'field' => 'Населённый пункт'
  ,'value' => $setlrow['settlement']
  ,'el_type' => 'text'
  ,'id' => 'text_field_medium'
  ,'name' => 'settlement'
  ,'disabled' => true
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=4&ff=$section_index&obj=region&#039;,&#039;repeater_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Район'
  ,'value' => $setlrow['area']
  ,'el_type' => 'text'
  ,'id' => 'text_field_medium'
  ,'name' => 'area'
  ,'disabled' => true
);
$info[] = $info1 = array (
   'field' => 'Область'
  ,'value' => $setlrow['region']
  ,'el_type' => 'text'
  ,'id' => 'text_field_medium'
  ,'name' => 'region'
  ,'disabled' => true
);
$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'ул.', 'display'=>'ул.')
  ,array ('value'=>'пер.', 'display'=>'пер.')
  ,array ('value'=>'пр-т', 'display'=>'пр-т')
  ,array ('value'=>'тракт', 'display'=>'тракт')
  ,array ('value'=>'бул.', 'display'=>'бул.')
  ,array ('value'=>'пл.', 'display'=>'пл.')
  ,array ('value'=>'шоссе', 'display'=>'шоссе')
  ,array ('value'=>'р-н', 'display'=>'р-н')
  ,array ('value'=>'парк', 'display'=>'парк')
);

$list_on_off = array (
   array ('value'=>'', 'display'=>'НЕ Работает')
  ,array ('value'=>1, 'display'=>'Работает')
);

$info[] = $info1 = array (
   'field' => 'Улица'
  ,'value' => PrvFill('street_type',$row['street_type'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'street_type'
  ,'list' => $list
  ,'start_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('street_name',$row['street_name'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_medium'
  ,'name' => 'street_name'
  ,'end_line' => true
);
$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'д.', 'display'=>'д.')
  ,array ('value'=>'стр.', 'display'=>'стр.')
);
$info[] = $info1 = array (
   'field' => 'Номер здания'
  ,'value' => PrvFill('house_type',$row['house_type'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'house_type'
  ,'list' => $list
  ,'start_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('house_number',$row['house_number'])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'house_number'
  ,'end_line' => true
);
$info[] = $info1 = array (
  'el_type' => 'break'
);
$info[] = $info1 = array (
   'field' => 'Расположение'
  ,'value' => PrvFill('place_owner',$row['place_owner'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_large'
  ,'name' => 'place_owner'
);
$info[] = $info1 = array (
  'el_type' => 'break'
);

if ($id==0) $noinfo = true;
$info[] = $info1 = array (  // Добавлено для отчетов Каменеву В.В.
   'field' => '<span style="color:green;font-weight:bold;">Инвентарный номер</span>'  
  ,'value' => PrvFill('inventory_number',$row['inventory_number'])
  ,'el_type' => 'text'
  ,'id' => 'select_field_medium'
  ,'name' => 'inventory_number'
  ,'disabled' => $noinfo
);

$info[] = $info1 = array (  // Добавлено для отчетов Каменеву В.В.
   'field' => '<span style="color:green;font-weight:bold;">Дата ввода в эксплуатацию</span>'
  ,'value' => PrvFill('date_rep_insert_expl',$row['date_rep_insert_expl'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_rep_insert_expl'
 
);

$info[] = $info1 = array (
  'el_type' => 'break'
);


$sql = "SELECT rep_diapazon,Id FROM rep_diapazons ORDER BY rep_diapazon";
$query = mysql_query($sql) or die(mysql_error());
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $list[] = array('value' => $row2['Id'], 'display' => $row2['rep_diapazon']);
}  
$info[] = $info1 = array (
   'field' => '<span style="color:red;font-weight:bold;">Рабочий диапазон</span>'
  ,'value' => PrvFill('rep_diapazon_id',$row['rep_diapazon_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field'
  ,'name' => 'rep_diapazon_id'
  ,'list' => $list
  ,'required' => false
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=rep_diapazons&#039;,&#039;repeater_edit_form&#039;);"
);
/*
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($gsm_configs); $i++) {
    $list[] = array('value' => $gsm_configs[$i]['value'], 'display' => $gsm_configs[$i]['display']);  
}

$info[] = $info1 = array (
   'field' => 'Конфигурация GSM'
  ,'value' => PrvFill('gsm_config_id',$row['gsm_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'gsm_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;repeater_edit_form&#039;);"
);
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($dcs_configs); $i++) {
    $list[] = array('value' => $dcs_configs[$i]['value'], 'display' => $dcs_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Конфигурация DCS'
  ,'value' => PrvFill('dcs_config_id',$row['dcs_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'dcs_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=dcs_configs&#039;,&#039;repeater_edit_form&#039;);"
);
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts_configs); $i++) {
    $list[] = array('value' => $umts_configs[$i]['value'], 'display' => $umts_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Конфигурация UMTS'
  ,'value' => PrvFill('umts_config_id',$row['umts_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'umts_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts_configs&#039;,&#039;repeater_edit_form&#039;);"
);
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts900_configs); $i++) {
    $list[] = array('value' => $umts900_configs[$i]['value'], 'display' => $umts900_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Конфигурация UMTS 900'
  ,'value' => PrvFill('umts9_config_id',$row['umts9_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'umts9_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts900_configs&#039;,&#039;repeater_edit_form&#039;);"
);
$info[] = $info1 = array (
  'el_type' => 'break'
);
*/
$info[] = $info1 = array (
   'field' => 'Дата включения Репитера'
  ,'value' => PrvFill('date_rep_on',$row['date_rep_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_rep_on'
  ,'list' => $list
  
);
$info[] = $info1 = array (
   'field' => 'Дата выключения Репитера'
  ,'value' => PrvFill('date_rep_off',$row['date_rep_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_rep_off'
  ,'list' => $list
  
);
$info[] = $info1 = array (
   'field' => '<span style=\"color: red;\"><b>Репитер работает</b></span>'
  ,'value' => PrvFill('R',$row['R'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'R'
  ,'list' => $list_on_off
  
);
$info[] = $info1 = array (
  'el_type' => 'break'
);
$list_number = array (
	 array ('value'=>'1', 'display'=>'1')
	,array ('value'=>'2', 'display'=>'2')
	,array ('value'=>'3', 'display'=>'3')
    ,array ('value'=>'4', 'display'=>'4')
);

$info[] = $info1 = array (
   'field' => 'Количество репитеров'
  ,'value' => PrvFill('quantity_rep',$row['quantity_rep'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'quantity_rep'
  ,'list' => $list_number
  
);
$info[] = $info1 = array (
  'el_type' => 'break'
);


$sql = "SELECT repeater_type,Id FROM repeater_types ORDER BY repeater_type";
$query = mysql_query($sql) or die(mysql_error());
$list_type = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row4 = mysql_fetch_array($query);
  $list_type[] = array('value' => $row4[1], 'display' => $row4[0]);
} 

$info[] = $info1 = array (
   'field' => 'Тип репитерного оборудования'
  ,'value' => PrvFill('repeater_type_id',$row['repeater_type_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field'
  ,'name' => 'repeater_type_id'
  ,'list' => $list_type
  ,'required' => true
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=repeater_types&#039;,&#039;repeater_edit_form&#039;);"
);
/*
$sql = "SELECT diapazon,Id FROM repeater_types ORDER BY diapazon";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $list_diapazon[] = array('value' => $row2[1], 'display' => $row2[0]);
} 
echo "<pre>";
print_r($list_diapazon);
echo "</pre>";

$info[] = $info1 = array (
   'field' => 'Поддерживаемые Диапазоны'
  ,'value' => PrvFill('repeater_type_id',$row2['repeater_type_id'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'repeater_type_id'
  ,'list' => $list_diapazon
  ,'required' => true
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=repeater_types&#039;,&#039;repeater_edit_form&#039;);"
);
*/
$sql = "SELECT power_type,Id FROM power_types ORDER BY power_type";
$query = mysql_query($sql) or die(mysql_error());
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $list[] = array('value' => $row2[1], 'display' => $row2[0]);
}  
$info[] = $info1 = array (
   'field' => 'Тип питания'
  ,'value' => PrvFill('power_type_id',$row['power_type_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field'
  ,'name' => 'power_type_id'
  ,'list' => $list
  ,'required' => true
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=power_types&#039;,&#039;repeater_edit_form&#039;);"  
);
$info[] = $info1 = array (
  'el_type' => 'break'
);
$longitudel_s = explode(' ',$row['longitudel_s']);
$info[] = $info1 = array (
   'field' => 'Географическая широта'
  ,'value' => PrvFill('s_grad',$longitudel_s[0])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 's_grad'
  ,'required' => true
  ,'pattern' => '[0-9]{2,}'
  ,'start_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('s_min',$longitudel_s[1])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 's_min'
  ,'required' => true
  ,'pattern' => '[0-9]{2,}'
  ,'start_line' => true
  ,'end_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('s_sec',$longitudel_s[2])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 's_sec'
  ,'required' => true
  ,'pattern' => '[0-9\.]{2,}'
  ,'end_line' => true
);
$longitudel_d = explode(' ',$row['longitudel_d']);
$info[] = $info1 = array (
   'field' => 'Географическая долгота'
  ,'value' => PrvFill('d_grad',$longitudel_d[0])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'd_grad'
  ,'required' => true
  ,'pattern' => '[0-9]{2,}'
  ,'start_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('d_min',$longitudel_d[1])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'd_min'
  ,'required' => true
  ,'pattern' => '[0-9]{2,}'
  ,'start_line' => true
  ,'end_line' => true
);
$info[] = $info1 = array (
   'value' => PrvFill('d_sec',$longitudel_d[2])
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'd_sec'
  ,'required' => true
  ,'pattern' => '[0-9\.]{2,}'
  ,'end_line' => true
);
$info[] = $info1 = array (
  'el_type' => 'break'
);
$info[] = $info1 = array (
 'field' => 'Примечания'
,'value' => PrvFill('notes',$row['notes'])
,'el_type' => 'textarea'
,'id' => 'note_edit'
,'name' => 'notes'
);

// блок списка кнопок действий

// вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
  FieldName($info[$i]);
}
echo "</div>";
echo "<div id='right_indent'>";
echo "<form action='repeater_edit.php?id=$id' method='post' id='repeater_edit_form'>";
for ($i=0;$i<count($info);$i++) {
  FieldEdit($info[$i]);
}
echo "<p><button type='submit' style=\"color: red;\" >сохранить</button></p>";
echo "</form>";
echo "</div>";
?>
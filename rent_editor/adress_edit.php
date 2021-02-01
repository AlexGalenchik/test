<?php
include_once ('../functions.php');
include_once ('../config.php');
session_start();

// основной запрос
$sql = "SELECT";
$sql.=" Id"; 
$sql.=",bts_number";
$sql.=",settlement_id"; // Id Населенного пункта
$sql.=",street_type";  // Тип Улицы
$sql.=",street_name";  // Название улицы
$sql.=",house_type";   // Тип строения
$sql.=",house_number"; //Номер дома
$sql.=" FROM bts"; 
$sql.=" WHERE bts_number = ".$_SESSION['bts_num']; 
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
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=4&ff=$section_index&obj=region&#039;,&#039;bts_edit_form&#039;);"
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

$info[] = $info1 = array (
   'field' => 'Тип улицы'
  ,'value' => PrvFill('street_type',$row['street_type'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'street_type'
  ,'list' => $list
  ,'start_line' => true
);
$info[] = $info1 = array (
   'field' => 'Улица'
  ,'value' => PrvFill('street_name',$row['street_name'])
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
   'field' => 'Тип здания'
  ,'value' => PrvFill('house_type',$row['house_type'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'house_type'
  ,'list' => $list
  ,'start_line' => true
);
$info[] = $info1 = array (
   'field' => 'Номер здания'
  ,'value' => PrvFill('house_number',$row['house_number']) 
  ,'id' => 'select_field_small'
  ,'name' => 'house_number'
  ,'end_line' => true
);

// блок списка кнопок действий

// вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
	echo $info[$i]['field']." - ".$info[$i]['value']."<br/>";
  //FieldName($info[$i]);
}
echo "</div>";
echo "<div id='right_indent'>";
/*
//Кнопка Возврат с сохранением данных
echo "<form action='../bts_edit.php?id=".$row['Id']."' method='post' id='bts_edit_form'>";
for ($i=0;$i<count($info);$i++) {
	echo $info[$i]['value']."<br/>";
  //FieldEdit($info[$i]);
}
echo "<p><button type='submit' style=\"color: red;\" >сохранить</button></p>";
echo "</form>";

*/
echo "</div>";
?>
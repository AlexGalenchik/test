<?php

// входные параметры
$id=$_GET['id'];



// основной запрос
$sql="SELECT * FROM bts WHERE id='$id'"; 
$query=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query); 

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
$sql = "SELECT lte_800_config,Id FROM lte_800_configs ORDER BY lte_800_config"; //Добавлена таблица lte_800_configs 11.12.2019
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_800_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
} 
$sql = "SELECT lte_config,Id FROM lte_configs ORDER BY lte_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
$sql = "SELECT lte_2600_config,Id FROM lte_2600_configs ORDER BY lte_2600_config"; //Добавлена таблица lte_2600_configs 11.12.2019
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_2600_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
$sql = "SELECT 5g_config,Id FROM 5g_configs ORDER BY 5g_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $g5_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
$sql = "SELECT IoT_config,Id FROM IoT_configs ORDER BY IoT_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $IoT_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
 
  
}


// формируем элементы


$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'1', 'display'=>'1')
  ,array ('value'=>'2', 'display'=>'2')
  //,array ('value'=>'3', 'display'=>'3')
  //,array ('value'=>'4', 'display'=>'4')
  //,array ('value'=>'5', 'display'=>'5')
  //,array ('value'=>'6', 'display'=>'6')
  //,array ('value'=>'7', 'display'=>'7')
);
$list_on_off = array (
   array ('value'=>'', 'display'=>'НЕ Работает')
  ,array ('value'=>1, 'display'=>'Работает')
  
 
);

$list_die = array (
   array ('value'=>'', 'display'=>'Работает')
  ,array ('value'=>'ОТПАЛА', 'display'=>'Отпала')
  
 
);

$info[] = $info1 = array (
   'field' => 'Отпавшая БС'
  ,'value' => PrvFill('die_bs',$row['die_bs'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'die_bs'
  ,'list' => $list_die
);

$info[] = $info1 = array (
  'el_type' => 'break'
);

$info[] = $info1 = array (
   'field' => 'Количество шкафов 2G'
  ,'value' => PrvFill('cupboard_2g_count',$row['cupboard_2g_count'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'cupboard_2g_count'
  ,'list' => $list
);

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация GSM</b>'
  ,'el_type' => 'break'
);
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($gsm_configs); $i++) {
    $list[] = array('value' => $gsm_configs[$i]['value'], 'display' => $gsm_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_gsm_config_id',$row['plan_gsm_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_gsm_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Установленная конфигурация'
  ,'value' => PrvFill('install_gsm_config_id',$row['install_gsm_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'install_gsm_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_gsm_config_id',$row['work_gsm_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_gsm_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
/*Заполнение даты вкл/выкл и отметки о состоянии*/



$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_gsm_on',$row['date_gsm_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_gsm_on'
  ,'list' => $list
  
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_gsm_off',$row['date_gsm_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_gsm_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>GSM работает</b></span>'
  ,'value' => PrvFill('G',$row['G'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'G'
  ,'list' => $list_on_off
  
);



/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/
$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация DCS</b>'
  ,'el_type' => 'break'
);
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($dcs_configs); $i++) {
    $list[] = array('value' => $dcs_configs[$i]['value'], 'display' => $dcs_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_dcs_config_id',$row['plan_dcs_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_dcs_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=dcs_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Установленная конфигурация'
  ,'value' => PrvFill('install_dcs_config_id',$row['install_dcs_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'install_dcs_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=dcs_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_dcs_config_id',$row['work_dcs_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_dcs_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=dcs_configs&#039;,&#039;config_edit_form&#039;);"
);
/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_dcs_on',$row['date_dcs_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_dcs_on'
  ,'list' => $list
  //,'marker' => PrvFill('DCS',$row['D'])
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_dcs_off',$row['date_dcs_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_dcs_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>DCS работает</b></span>'
  ,'value' => PrvFill('D',$row['D'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'D'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

$info[] = $info1 = array (
  'el_type' => 'break'
);
$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'1', 'display'=>'1')
  ,array ('value'=>'2', 'display'=>'2')
  ,array ('value'=>'3', 'display'=>'3')
);
$info[] = $info1 = array (
   'field' => 'Количество шкафов 3G'
  ,'value' => PrvFill('cupboard_3g_count',$row['cupboard_3g_count'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'cupboard_3g_count'
  ,'list' => $list
);
$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация UMTS 2100</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts_configs); $i++) {
    $list[] = array('value' => $umts_configs[$i]['value'], 'display' => $umts_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_umts_config_id',$row['plan_umts_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_umts_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_umts_config_id',$row['work_umts_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_umts_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_umts_on',$row['date_umts_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_umts_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_umts_off',$row['date_umts_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_umts_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>UMTS работает</b></span>'
  ,'value' => PrvFill('U',$row['U'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'U'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

$list = array(array('value'=>'', 'display'=>''));//////////////////////////////////
for ($i=0; $i<count($umts900_configs); $i++) {   ///////////////////////////////////
    $list[] = array('value' => $umts900_configs[$i]['value'], 'display' => $umts900_configs[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация UMTS 900</b>'
  ,'el_type' => 'break'
);
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_umts9_config_id',$row['plan_umts9_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_umts9_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts900_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_umts9_config_id',$row['work_umts9_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_umts9_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=umts900_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_umts900_on',$row['date_umts900_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_umts900_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_umts900_off',$row['date_umts900_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_umts900_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>UMTS900 работает</b></span>'
  ,'value' => PrvFill('U9',$row['U9'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'U9'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

// 4G 1800
$info[] = $info1 = array (
  'el_type' => 'break'
);
$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'1', 'display'=>'1')
  ,array ('value'=>'2', 'display'=>'2')
  ,array ('value'=>'3', 'display'=>'3')
);
$info[] = $info1 = array (
   'field' => 'Количество шкафов 4G'
  ,'value' => PrvFill('cupboard_4g_count',$row['cupboard_4g_count'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_small'
  ,'name' => 'cupboard_4g_count'
  ,'list' => $list
);
//////////////////////////////////////////////////////////////////////////////
$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация LTE 800</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_800_configs); $i++) {
    $list[] = array('value' => $lte_800_configs[$i]['value'], 'display' => $lte_800_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_lte800_config_id',$row['plan_lte800_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_lte800_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_lte800_config_id',$row['work_lte800_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_lte800_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_LTE800_on',$row['date_LTE800_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE800_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_LTE800_off',$row['date_LTE800_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE800_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>LTE800 работает</b></span>'
  ,'value' => PrvFill('L8',$row['L8'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'L8'
  ,'list' => $list_on_off
  
);

echo "</div>";
////////////////////////////////////////////////////////////////
/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация LTE 1800</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_configs); $i++) {
    $list[] = array('value' => $lte_configs[$i]['value'], 'display' => $lte_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_lte_config_id',$row['plan_lte_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_lte_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_lte_config_id',$row['work_lte_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_lte_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_LTE_on',$row['date_LTE_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_LTE_off',$row['date_LTE_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>LTE1800 работает</b></span>'
  ,'value' => PrvFill('L18',$row['L18'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'L18'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

// LTE 2600

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация LTE 2600</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_2600_configs); $i++) {
    $list[] = array('value' => $lte_2600_configs[$i]['value'], 'display' => $lte_2600_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_lte2600_config_id',$row['plan_lte2600_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_lte2600_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_lte2600_config_id',$row['work_lte2600_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_lte2600_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_LTE2600_on',$row['date_LTE2600_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE2600_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_LTE2600_off',$row['date_LTE2600_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_LTE2600_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>LTE2600 работает</b></span>'
  ,'value' => PrvFill('L26',$row['L26'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => 'L26'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

// 5G

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация 5G</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($g5_configs); $i++) {
    $list[] = array('value' => $g5_configs[$i]['value'], 'display' => $g5_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_5g_config_id',$row['plan_5g_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_5g_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=5g_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_5g_config_id',$row['work_5g_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_5g_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=5g_configs&#039;,&#039;config_edit_form&#039;);"
);

/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_5g_on',$row['date_5g_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_5g_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=5g_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_5g_off',$row['date_5g_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_5g_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=5g_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>5G работает</b></span>'
  ,'value' => PrvFill('5G',$row['5G'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium'
  ,'name' => '5G'
  ,'list' => $list_on_off
  
);

echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/

//IoT  

$info[] = $info1 = array (
   'field' => '<b style= color:red;>Конфигурация IoT</b>'
  ,'el_type' => 'break'
);

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($IoT_configs); $i++) {
    $list[] = array('value' => $IoT_configs[$i]['value'], 'display' => $IoT_configs[$i]['display']);  
}  
$info[] = $info1 = array (
   'field' => 'Планируемая конфигурация'
  ,'value' => PrvFill('plan_IoT_config_id',$row['plan_IoT_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'plan_IoT_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Рабочая конфигурация'
  ,'value' => PrvFill('work_IoT_config_id',$row['work_IoT_config_id'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'work_IoT_config_id'
  ,'list' => $list
  ,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=lte_configs&#039;,&#039;config_edit_form&#039;);"
);


/*Заполнение даты вкл/выкл и отметки о состоянии*/

echo "<div id = 'datalock'>";

$info[] = $info1 = array (
   'field' => 'Дата включения'
  ,'value' => PrvFill('date_IoT_on',$row['date_IoT_on'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_IoT_on'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
$info[] = $info1 = array (
   'field' => 'Дата выключения'
  ,'value' => PrvFill('date_IoT_off',$row['date_IoT_off'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium_data'
  ,'name' => 'date_IoT_off'
  ,'list' => $list
  //,'ad_edit' => "ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=gsm_configs&#039;,&#039;config_edit_form&#039;);"
);
// Клиент IoT поле

$info[] = $info1 = array (
   'field' => '<span style="color: red;">IoT Клиент</span>'
  ,'value' => $row['iot_client']
  ,'el_type' => 'text'
  ,'id' => 'org_info'
  ,'name' => 'iot_client'
  //,'list' => $client_list
);

$info[] = $info1 = array (
   'field' => '<span style="color: red;"><b>IoT работает</b></span>'
  ,'value' => PrvFill('IoT',$row['IoT'])
  ,'el_type' => 'select'
  ,'id' => 'select_field_medium_conf'
  ,'name' => 'IoT'
  ,'list' => $list_on_off
  
);

//echo "</div>";

/* КОНЕЦ Заполнение даты вкл/выкл и отметки о состоянии*/


// вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
  FieldName($info[$i]);
}
echo "</div>";
echo "<div id='right_indent'>";
echo "<form action='config_edit.php?f=17&id=$id' method='post' id='config_edit_form'>";
for ($i=0;$i<count($info);$i++) {
  FieldEdit($info[$i]);
}
echo "<p><button type='submit' style=\"color: red;\" >сохранить</button></p>";
echo "</form>";
echo "</div>";
?>
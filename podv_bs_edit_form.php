

<?php
include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];

// основной запрос
$sql="SELECT * FROM podv_bs WHERE id='$id'"; 
$query=mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);
$bts_id = $row['pbs_number'];

/*
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
$sql = "SELECT lte_config,Id FROM lte_configs ORDER BY lte_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
$sql = "SELECT lte_2600_config,Id FROM lte_2600_configs ORDER BY lte_2600_config";
$query = mysql_query($sql) or die(mysql_error());
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row2 = mysql_fetch_array($query);
  $lte_2600_configs[] = array('value' => $row2[1], 'display' => $row2[0]);
}
*/
// входные параметры

if (isset($_GET['id'])) {
	    $id = $_GET['id'];
        $sql = "SELECT * FROM podv_bs WHERE id=" . StrOrNull($id);
        $query = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($query);
        $pbs_number = $row['pbs_number'];
		$_SESSION['pbs_number'] = $pbs_number;
		
    }
	
	echo "<h4>РЕДАКТОР ПАРАМЕТРОВ ПБС (HW)</h4>";
	
	// основной запрос
$sql = " SELECT * FROM podv_bs"; 
$sql.=" WHERE pbs_number = '$pbs_number'"; 
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query); 

////Поиск номера id в таблице bts
$sql = "SELECT Id FROM bts WHERE bts_number =".$pbs_number;
$query1 = mysql_query($sql) or die(mysql_error());
$row1 = mysql_fetch_array($query1);
$bts_id = $row1['Id'];

echo "<div style=\"margin-left:50px; margin-bottom:20px;\">";
echo "<a href = 'index.php?f=46' id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\">    Перечень ПБС </a> ";

if (isset($bts_id)) {
echo "<a href = 'index.php?f=17&id=$bts_id' id='button_edd'style=\"margin-left:100px\"><img src='pics/info_picc.png' width = '24px' align=\"center\">   Параметры ФУД</a> ";
}
//echo "<a href = 'index.php?f=50' id='button_edd'><img src='pics/info_picc.png' width = '24x' align=\"center\">    План ПБС ".$pbs_number."</a> ";
//echo "<a href = 'PBS/$pbs_number.docx' id='button_edd'><img src='pics/download_pic.jpg' width = '24px' align=\"center\"> Распоряжение ".$pbs_number."</a> ";
//echo "<h1></h1>";
echo "</div>";

// формируем элементы
$info[] = $info1 = array (
   'field' => 'Номер ПБС'
  ,'value' => PrvFill('pbs_number',$row['pbs_number'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv'
  ,'name' => 'pbs_number'
 // ,'disabled' => true
  ,'required' => true
);

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'Комдор', 'display'=>'Комдор')
  ,array ('value'=>'meiko', 'display'=>'meiko')
  ,array ('value'=>'ЛогиТранс', 'display'=>'ЛогиТранс')
  );

$info[] = $info1 = array (
   'field' => 'Производитель'
  ,'value' => PrvFill('vendor',$row['vendor'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'vendor'
  ,'list' => $list
  //,'required' => true
);   

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'3,5 тонн', 'display'=>'3,5 тонн')
  ,array ('value'=>'9 тонн', 'display'=>'9 тонн')
  ,array ('value'=>'15 тонн', 'display'=>'15 тонн')
  );

$info[] = $info1 = array (
   'field' => 'Масса ПБС'
  ,'value' => PrvFill('massa',$row['massa'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'massa'
  ,'list' => $list
  //,'required' => true
);  

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'Работает', 'display'=>'Работает')
  ,array ('value'=>'Ожидает', 'display'=>'Ожидает')
  ,array ('value'=>'Постоянное место', 'display'=>'Постоянное место')
   ,array ('value'=>'Ремонт', 'display'=>'Ремонт')
   ,array ('value'=>'Резерв', 'display'=>'Резерв')
  );

$info[] = $info1 = array (
   'field' => 'Статус'
  ,'value' => PrvFill('status',$row['status'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'status'
  ,'list' => $list
  //,'required' => true
);  

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'14м', 'display'=>'14м')
  ,array ('value'=>'18м', 'display'=>'18м')
   ,array ('value'=>'30м', 'display'=>'30м')
  );
  
$info[] = $info1 = array (
   'field' => 'Высота мачты'
  ,'value' => PrvFill('type_pbs',$row['type_pbs'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'type_pbs'
  ,'list' => $list
  //,'required' => true
);

$list = array (
   array ('value'=>'', 'display'=>'')
  ,array ('value'=>'G', 'display'=>'G')
  ,array ('value'=>'G,D', 'display'=>'G,D')
  ,array ('value'=>'G,D,U', 'display'=>'G,D,U')
  ,array ('value'=>'D,U', 'display'=>'D,U')
  ,array ('value'=>'D,U,U9', 'display'=>'D,U,U9')
  ,array ('value'=>'D,U,U9,L18', 'display'=>'D,U,U9,L18')
  ,array ('value'=>'D,U,U9,L18,L26', 'display'=>'D,U,U9,L18,L26')
  ,array ('value'=>'G,D,U,U9,L18,L26', 'display'=>'G,D,U,U9,L18,L26')
  ,array ('value'=>'U,U9,L18', 'display'=>'U,U9,L18')
  ,array ('value'=>'U,U9,L18,L26', 'display'=>'U,U9,L18,L26')
  ,array ('value'=>'U,U9', 'display'=>'U,U9')
  ,array ('value'=>'L18', 'display'=>'L18')
  ,array ('value'=>'U,L18', 'display'=>'U,L18')
  ,array ('value'=>'L18,L26', 'display'=>'L18,L26')
  ,array ('value'=>'U,L18,L26', 'display'=>'U,L18,L26')
  );

$info[] = $info1 = array (
'field' => 'Технологии'
,'value' => PrvFill('tech',$row['tech'])
,'el_type' => 'select'
,'id' => 'text_field_podv_select'
,'name' => 'tech'
,'list' => $list
  //,'required' => true
);

/*
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($gsm_configs); $i++) {
    $list[] = array('value' => $gsm_configs[$i]['value'], 'display' => $gsm_configs[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => 'GSM'
  ,'value' => PrvFill('gsm_config',$row['gsm_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'gsm_config'
  ,'list' => $list
  
  );
  
  $list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($dcs_configs); $i++) {
    $list[] = array('value' => $dcs_configs[$i]['value'], 'display' => $dcs_configs[$i]['display']);  
}  
  
$info[] = $info1 = array (
   'field' => 'DCS'
  ,'value' => PrvFill('dcs_config',$row['dcs_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'dcs_config'
  ,'list' => $list
  );

$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($umts_configs); $i++) {
    $list[] = array('value' => $umts_configs[$i]['value'], 'display' => $umts_configs[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => 'UMTS'
  ,'value' => PrvFill('umts_config',$row['umts_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'umts_config'
  ,'list' => $list
  );

$list = array(array('value'=>'', 'display'=>''));//////////////////////////////////
for ($i=0; $i<count($umts900_configs); $i++) {   ///////////////////////////////////
    $list[] = array('value' => $umts900_configs[$i]['value'], 'display' => $umts900_configs[$i]['display']);  
} 

$info[] = $info1 = array (
   'field' => 'U900'
  ,'value' => PrvFill('u900_config',$row['u900_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'u900_config'
  ,'list' => $list
  );
$list = array(array('value'=>'', 'display'=>''));
for ($i=0; $i<count($lte_configs); $i++) {
    $list[] = array('value' => $lte_configs[$i]['value'], 'display' => $lte_configs[$i]['display']);  
}  

$info[] = $info1 = array (
   'field' => 'LTE 1800'
  ,'value' => PrvFill('lte18_config',$row['lte18_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'lte18_config'
  ,'list' => $list
  );
$info[] = $info1 = array (
   'field' => 'LTE 2600 план'
  ,'value' => PrvFill('lte26_config',$row['lte26_config'])
  ,'el_type' => 'select'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'lte26_config'
  ,'list' => $list
  );
*/
$info[] = $info1 = array (
   'field' => 'Место размещения'
  ,'value' => PrvFill('place',$row['place'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'place'
  //,'required' => true
);

$info[] = $info1 = array (
   'field' => 'Мероприятие'
  ,'value' => PrvFill('event',$row['event'])
  ,'el_type' => 'text'
  ,'id' => 'text_field_podv_select'
  ,'name' => 'event'
  //,'required' => true
);
$info[] = $info1 = array (
   'field' => 'Дата начала'
  ,'value' => PrvFill('start_date',$row['start_date'])
  ,'el_type' => 'date'
  ,'id' => 'text_field_podv_date'
  ,'name' => 'start_date'
   
);
$info[] = $info1 = array (
   'field' => 'Дата окончания'
  ,'value' => PrvFill('finish_date',$row['finish_date'])
  ,'el_type' => 'date'
  ,'id' => 'text_field_podv_date'
  ,'name' => 'finish_date'
   
);

$info[] = $info1 = array (
 'field' => 'Примечания'
,'value' => PrvFill('notes',$row['notes'])
,'el_type' => 'textarea'
,'id' => 'note_edit'
,'name' => 'notes'
);

// вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
	FieldName($info[$i]);
}

echo "</div>";
echo "<div id='right_indent'>";
echo "<form action='index.php?f=48&id=$id' method='post' id='podv_bs_edit_form'>";
for ($i=0;$i<count($info);$i++) {
  FieldEdit($info[$i]);
}
if ($pbs == 'w') {
  echo "<button type='submit' name='submit' style=\"color: red;\" >сохранить</button>";
  if (isset($_POST['submit'])) {
	echo '<p>Данные успешно добавлены в таблицу.</p>';
   }
   	print_r($POST);
}
echo "</form>";
echo "</div>";
?>





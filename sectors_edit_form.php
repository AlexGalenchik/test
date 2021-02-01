<?php
// входные параметры
$id = $_GET['id'];
$cell_counter = 0;

// основной запрос ВЫБОРКИ данных по секторам
$sql = "SELECT * FROM sectors WHERE tech_type in ('gsm','dcs','2g') AND bts_id='$id'"; 
$query = mysql_query($sql) or die(mysql_error());
$exist_number_2g = mysql_num_rows($query);
//echo "2g sectors=".$exist_number_2g."<br/>";

$sql = "SELECT * FROM sectors WHERE tech_type in ('umts 2100') AND bts_id='$id'"; 
$query2 = mysql_query($sql) or die(mysql_error());
$exist_number_3g = mysql_num_rows($query2);
//echo "3g sectors=".$exist_number_3g."<br/>";

$sql = "SELECT * FROM sectors WHERE tech_type in ('umts 900') AND bts_id='$id'"; 
$query4 = mysql_query($sql) or die(mysql_error());
$exist_number_3g9 = mysql_num_rows($query4);
//echo "u900 sectors=".$exist_number_3g9."<br/>";

$sql = "SELECT * FROM sectors WHERE tech_type in ('lte 1800') AND bts_id='$id'"; 
$query5 = mysql_query($sql) or die(mysql_error());
$exist_number_4g1800 = mysql_num_rows($query5);
//echo "4g 1800 sectors=".$exist_number_4g1800."<br/>";

// Добавлено Галенчик Данные по LTE 800
$sql = "SELECT * FROM sectors WHERE tech_type in ('lte 800') AND bts_id='$id'"; 
$query8 = mysql_query($sql) or die(mysql_error());
$exist_number_4g800 = mysql_num_rows($query8);
//echo "4g 800 sectors=".$exist_number_4g800."<br/>";

// Добавлено Галенчик Данные по LTE 2600
$sql = "SELECT * FROM sectors WHERE tech_type in ('lte 2600') AND bts_id='$id'"; 
$query6 = mysql_query($sql) or die(mysql_error());
$exist_number_4g2600 = mysql_num_rows($query6);
//echo "4g 2600 sectors=".$exist_number_4g2600."<br/>";

// Добавлено Галенчик Данные по 5G
$sql = "SELECT * FROM sectors WHERE tech_type in ('5g') AND bts_id='$id'"; 
$query7 = mysql_query($sql) or die(mysql_error());
$exist_number_5g = mysql_num_rows($query7);
//echo "5g sectors=".$exist_number_5g."<br/>";

//Выборки типов антенн для каждой технологии
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('2g','gsm','dcs') GROUP BY antenna_type"; // Исправлено 2g, gsm,dcs
$query_at=mysql_query($sql) or die(mysql_error());
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('3g') GROUP BY antenna_type"; 
$query_at_3g=mysql_query($sql) or die(mysql_error());
// Добавлено Галенчик Данные по LTE 1800
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('4g') GROUP BY antenna_type"; 
$query_at_4g800=mysql_query($sql) or die(mysql_error());
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('4g') GROUP BY antenna_type"; 
$query_at_4g=mysql_query($sql) or die(mysql_error());
// Добавлено Галенчик Данные по LTE 2600
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('4g') GROUP BY antenna_type"; 
$query_at_4g2600=mysql_query($sql) or die(mysql_error());
// Добавлено Галенчик Данные по 5G
$sql="SELECT antenna_type, Id FROM antenna_types WHERE tech_type in ('5g') GROUP BY antenna_type"; 
$query_at_5g=mysql_query($sql) or die(mysql_error());

// формируем элементы
//If (PrvFill('row_number_2g',$exist_number_2g) < $exist_number_2g) { //Проверка на то, что если введено меньшее число секторов, чем есть секторов
//	$row_number_2g = $exist_number_2g;
//} else {
$row_number_2g = PrvFill('row_number_2g',$exist_number_2g);
//}

$info[] = $info1 = array (
   'value' => $row_number_2g
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_2g'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);

//If (PrvFill('row_number_3g',$exist_number_3g) < $exist_number_3g) {  //Проверка на то, что если введено меньшее число секторов, чем есть секторов
//	$row_number_3g = $exist_number_3g; 
//} else {
$row_number_3g = PrvFill('row_number_3g',$exist_number_3g);
//}

$info[] = $info1 = array (
   'value' => $row_number_3g
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_3g'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);

//If (PrvFill('row_number_3g9',$exist_number_3g9) < $exist_number_3g9) {  //Проверка на то, что если введено меньшее число секторов, чем есть секторов
//	$row_number_3g9 = $exist_number_3g9; 
//} else {
$row_number_3g9 = PrvFill('row_number_3g9',$exist_number_3g9);
//}

$info[] = $info1 = array (
   'value' => $row_number_3g9
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_3g9'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);

//If (PrvFill('row_number_4g1800',$exist_number_4g1800) < $exist_number_4g1800) {  //Проверка на то, что если введено меньшее число секторов, чем есть секторов
//	$row_number_4g1800 = $exist_number_4g1800;
//} else {
$row_number_4g1800 = PrvFill('row_number_4g1800',$exist_number_4g1800);
//}

$info[] = $info1 = array (
   'value' => $row_number_4g1800
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_4g1800'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);
// Добавлено Галенчик Данные по LTE 2600
//If (PrvFill('row_number_4g2600',$exist_number_4g2600) < $exist_number_4g2600) {
//	$row_number_4g2600 = $exist_number_4g2600;  
//} else {
$row_number_4g2600 = PrvFill('row_number_4g2600',$exist_number_4g2600);
//}

$info[] = $info1 = array (
   'value' => $row_number_4g2600
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_4g2600'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);
//////////////////////////////////////////////////////////////////LTE 800//////////////////////////////////////////////////////////////////////////////////////////////////
//If (PrvFill('row_number_4g800',$exist_number_4g800) < $exist_number_4g800) {  //Проверка на то, что если введено меньшее число секторов, чем есть секторов
//	$row_number_4g800 = $exist_number_4g800;
//} else {
$row_number_4g800 = PrvFill('row_number_4g800',$exist_number_4g800);
//}

$info[] = $info1 = array (
   'value' => $row_number_4g800
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_4g800'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Добавлено Галенчик Данные по 5G
//If (PrvFill('row_number_5g',$exist_number_5g) < $exist_number_5g) {
//	$row_number_5g = $exist_number_5g; 
//} else {
$row_number_5g = PrvFill('row_number_5g',$exist_number_5g);
//}

$info[] = $info1 = array (
   'value' => $row_number_5g
  ,'el_type' => 'text'
  ,'id' => 'select_field_small'
  ,'name' => 'row_number_5g'
  ,'start_line' => true
  ,'end_line' => true
  ,'pattern' => '[0-9]*'
);

$info[] = $info1 = array (
  'el_type' => 'break'
);

// блок списка кнопок действий

// вывод элементов интерфейса
echo "<form action='sectors_edit.php?id=$id' method='post' id='sectors_edit_form'>";

echo "введите количество строк для секторов <b>2G</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[0]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_2g > 0) { // СЕКТОРА 2G НАПОЛНЕНИЕ
  echo "<table id='result_table'>";
  
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td></tr>"; //Добавлено </tr> в конце
			
			//$cell_counter += $row_number_2g;
			
  for ($i=0; $i < $row_number_2g; $i++) {   //Перебор параметров сектора в технологии 2g
    	$row2g = mysql_fetch_assoc($query); //Массив данных о секторах 2g
		
	echo "<tr>";	
    // номер сектора
    $value=PrvFill("num_$i",$row2g['num']);
    if ($value==0) {$value=1;} ///////////////////////////////////////////////
    echo "<td id='rs_td'>";
    echo "<input type='text' value='".$row2g['Id']."' name='Id_$i' hidden>";  // id
    echo "<select size='1' id='select_field_small' name='num_$i'>";
    for ($j=1; $j<$row_number_2g+5; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
  
    // стандарт
    $value=PrvFill("tech_type_$i",$row2g['tech_type']);
	echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='gsm') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='gsm'>gsm</option>";
    if ($value=='dcs') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='dcs'>dcs</option>";
    if ($value=='2g') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='2g'>2g</option>";
	echo "</select></td>";
  
    // тип антенны
    $value=PrvFill("antenna_type_id_$i",$row2g['antenna_type_id']);
	$sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0];
	echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    mysql_data_seek($query_at,0);
    echo "<option></option>";
    for ($j=0; $j<mysql_num_rows($query_at); $j++) {
      $row2 = mysql_fetch_array($query_at); 
      if ($value == $row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_2g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row2g['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row2g['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row2g['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row2g['tm_slope']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row2g['te_slope']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row2g['cable_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
  
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row2g['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
 /*   // тип мшу
    $value=PrvFill("msu_type_$i",$row2g['msu_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA900') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA900'>TMA900</option>";
    echo "</select></td>";
*/  echo "</tr>";
 	
  }
  echo "</table>";
}
echo "<br/>";


echo "введите количество строк для секторов <b>3G UMTS 2100</b>:&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[2]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_3g>0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>"; //Добавлено </tr> в конце
			
			$cell_counter += $row_number_3g;
			  
  for ($i=$row_number_2g; $i<$row_number_2g+$row_number_3g; $i++) {
    $row3g = mysql_fetch_array($query2);
	
	echo "<tr>";
    // номер сектора
    $value=PrvFill("num_$i",$row3g['num']); 
    if ($value==0) {$value=1;}  ///////////////////////////////////////////////
	
    echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row3g['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_3g+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row3g['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='3g') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='umts 2100'>umts 2100</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row3g['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_3g,0);
    for ($j=0; $j<mysql_num_rows($query_at_3g); $j++) {
      $row2=mysql_fetch_array($query_at_3g); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_3g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row3g['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row3g['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row3g['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row3g['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row3g['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row3g['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row3g['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row3g['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
/*    $value=PrvFill("msu_type_$i",$row3g['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA2100') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA2100'>TMA2100</option>";
    echo "</select></td>";
*/	echo "</tr>";
  }
  echo "</table>";
}
echo "<br/>";

echo "введите количество строк для секторов <b>3G UMTS 900</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[4]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_3g9>0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>"; //Внесено в конце </tr>
			
			$cell_counter += $row_number_3g9;
			//echo "&nbsp;".$cell_counter;
  
  for ($i=$row_number_2g+$row_number_3g; $i<$row_number_2g+$row_number_3g+$row_number_3g9; $i++) {
    $row3g9 = mysql_fetch_array($query4);
	
	echo "<tr>";
    // номер сектора
    $value=PrvFill("num_$i",$row3g9['num']); 
    if ($value==0) {$value=1;}  /////////////////////////////////////////
	echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row3g9['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_3g9+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row3g9['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='3g') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='umts 900'>umts 900</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row3g9['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_3g,0);
    for ($j=0; $j<mysql_num_rows($query_at_3g); $j++) {
      $row2=mysql_fetch_array($query_at_3g); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_3g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row3g9['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row3g9['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row3g9['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row3g9['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row3g9['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row3g9['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row3g9['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row3g9['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
/*  $value=PrvFill("msu_type_$i",$row3g9['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA900') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA900'>TMA900</option>";
    echo "</select></td>";
*/	echo "</tr>";
  }
  echo "</table>";
}
echo "<br/>";

echo "введите количество строк для секторов <b>4G LTE 1800</b>:&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[6]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_4g1800 > 0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>";  //Добавлено </tr> в конце
			
			$cell_counter += $row_number_4g1800;
			
  
  for ($i=$row_number_2g+$row_number_3g+$row_number_3g9; $i < $row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800; $i++) {
    $row4g = mysql_fetch_array($query5);
	
	echo "<tr>";   
    // номер сектора
    $value=PrvFill("num_$i",$row4g['num']); 
    if ($value==0) {$value=1;} /////////////////////////////////////////// 
	
    echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row4g['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_4g1800+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row4g['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='4g') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='lte 1800'>lte 1800</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row4g['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_4g,0);
    for ($j=0; $j<mysql_num_rows($query_at_4g); $j++) {
      $row2=mysql_fetch_array($query_at_4g); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_4g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row4g['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row4g['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row4g['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row4g['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row4g['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row4g['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row4g['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row4g['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
/*  $value=PrvFill("msu_type_$i",$row4g['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA1800') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA1800'>TMA1800</option>";
    echo "</select></td>";
*/	echo "</tr>";
  }
  echo "</table>";
  
  
}
echo "<br/>";

// 4G 2600

echo "введите количество строк для секторов <b>4G LTE 2600</b>:&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[8]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_4g2600>0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>"; // Добавлено в конце </tr>
			
			$cell_counter += $row_number_4g2600;
			
		
  
  for ($i=$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800; $i<$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800+$row_number_4g2600; $i++) {
    $row4g2600 = mysql_fetch_array($query6);
	
	echo "<tr>";    
    // номер сектора
    $value=PrvFill("num_$i",$row4g2600['num']); 
    if ($value==0) {$value=1;}  /////////////////////////////////////////////
	
    echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row4g2600['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_4g2600+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row4g2600['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='4g2600') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='lte 2600'>lte 2600</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row4g2600['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_4g2600,0);
    for ($j=0; $j<mysql_num_rows($query_at_4g2600); $j++) {
      $row2=mysql_fetch_array($query_at_4g2600); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_4g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row4g2600['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row4g2600['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row4g2600['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row4g2600['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row4g2600['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row4g2600['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row4g2600['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row4g2600['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
 /* $value=PrvFill("msu_type_$i",$row4g2600['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA1800') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA1800'>TMA1800</option>";
    echo "</select></td>";
 */	echo "</tr>";
  }
  echo "</table>";
  
  
}

echo "<br/>";

// 4G 800

echo "введите количество строк для секторов <b>4G LTE 800</b>:&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[10]);
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_4g800>0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>"; // Добавлено в конце </tr>
			
			$cell_counter += $row_number_4g800;
			
		
  
  for ($i=$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800+$row_number_4g2600; $i<$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800+$row_number_4g2600+$row_number_4g800; $i++) {
    $row4g800 = mysql_fetch_array($query8);
	
	echo "<tr>";    
    // номер сектора
    $value=PrvFill("num_$i",$row4g800['num']); 
    if ($value==0) {$value=1;}  /////////////////////////////////////////////
	
    echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row4g800['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_4g800+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row4g800['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='4g800') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='lte 800'>lte 800</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row4g800['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_4g800,0);
    for ($j=0; $j<mysql_num_rows($query_at_4g800); $j++) {
      $row2=mysql_fetch_array($query_at_4g800); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_4g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row4g800['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row4g800['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row4g800['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row4g800['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row4g800['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row4g800['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row4g800['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row4g800['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
 /* $value=PrvFill("msu_type_$i",$row4g800['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA1800') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA1800'>TMA1800</option>";
    echo "</select></td>";
 */	echo "</tr>";
  }
  echo "</table>";
  
  
}

echo "<br/>";

///5G

echo "введите количество строк для секторов <b>5G</b>:&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
FieldEdit($info[12]); 
echo "&nbsp;&nbsp;&nbsp;<button type='button' onclick='ad_edit(&#039;redirect.php?f=8&#039;,&#039;sectors_edit_form&#039;);'>выбрать</button>";
echo "<br/>";

if ($row_number_5g>0) {
  echo "<table id='result_table'>";
  echo "<tr><td id='rs_td'>номер сектора</td>
			<td id='rs_td'>стандарт</td>
			<td id='rs_td'>тип антенны</td>
			<td id='rs_td'>кол-во</td>
			<td id='rs_td'>высота(размещ.)</td>
			<td id='rs_td'>азимут</td>
			<td id='rs_td'>tm</td>
			<td id='rs_td'>te</td>
			<td id='rs_td'>тип каб.</td>
			<td id='rs_td'>длина каб.</td>
			<td id='rs_td'>ret</td></tr>"; //Добавлено в конце </tr>
			
			$cell_counter += $row_number_5g;
			
  
  for ($i=$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800+$row_number_4g2600+$row_number_4g800; $i<$row_number_2g+$row_number_3g+$row_number_3g9+$row_number_4g1800+$row_number_4g2600+$row_number_4g800+$row_number_5g; $i++) {
    $row5g = mysql_fetch_array($query7);
	
	echo "<tr>";
    // номер сектора
    $value=PrvFill("num_$i",$row5g['num']); 
    if ($value==0) {$value=1;}  /////////////////////////////////////////////////////////////
	
    echo "<td id='rs_td'>";
    
    echo "<input type='text' value='".$row5g['Id']."' name='Id_$i' hidden>"; // id 

    echo "<select size='1' id='select_field_small' name='num_$i'>";
    
    for ($j=1; $j<$row_number_5g+1; $j++) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
      
    }
    echo "</select></td>";
    
    // стандарт
    $value=PrvFill("tech_type_$i",$row5g['tech_type']);
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tech_type_$i'>";
    if ($value=='5g') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5g'>5g</option>";
    echo "</select></td>";
  
    // тип антенны
    $value = PrvFill("antenna_type_id_$i",$row5g['antenna_type_id']);
    $sql = "SELECT antenna_type FROM antenna_types WHERE id=".NumOrNull($value); 
    $query3 = mysql_query($sql) or die(mysql_error());
    $row2 = mysql_fetch_array($query3); 
    $value = $row2[0]; 
    echo "<td id='rs_td'><select size='1' id='select_field_large' name='antenna_type_id_$i' required>";
    echo "<option></option>";
    mysql_data_seek($query_at_5g,0);
    for ($j=0; $j<mysql_num_rows($query_at_5g); $j++) {
      $row2=mysql_fetch_array($query_at_5g); 
      if ($value==$row2[0]) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='".$row2[1]."'>".$row2[0]."</option>";
    }
    echo "</select>&nbsp;<a href='#' title='редактировать список' onclick='ad_edit(&#039;redirect.php?f=5&ff=$section_index&obj=antenna_types_5g&#039;,&#039;sectors_edit_form&#039;);'><img src='pics/edit_pic.jpg' width='16' height='16'></a></td>";
  
    // кол-во антенн
    $value=PrvFill("antenna_count_$i",$row5g['antenna_count']);
    if ($value=='') {$value=1;}
    echo "<td id='rs_td'><input type='number' value='$value' name='antenna_count_$i' id='select_field_small' pattern='[0-9]*' required></td>";
  
    // высота (размещение)
    $value=PrvFill("height_$i",$row5g['height']);
    echo "<td id='rs_td'><input type='text' value='$value' name='height_$i' size='10'></td>";
  
    // азимут
    $value=PrvFill("azimuth_$i",$row5g['azimuth']);
    echo "<td id='rs_td'><input type='text' value='$value' name='azimuth_$i' size='1' pattern='[0-9]*'></td>";
  
    // TM
    $value=PrvFill("tm_slope_$i",$row5g['tm_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='tm_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // TE
    $value=PrvFill("te_slope_$i",$row5g['te_slope']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='te_slope_$i'>";
    for ($j=5; $j>-16; $j--) {
      if ($value==$j) {$selected='selected';} else {$selected='';}
      echo "<option $selected value='$j'>$j</option>";
    }
    echo "</select></td>";
  
    // тип кабеля
    $value=PrvFill("cable_type_$i",$row5g['cable_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='cable_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='1/2') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='1/2'>1/2</option>";
    if ($value=='3/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='3/8'>3/8</option>";
    if ($value=='5/4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='5/4'>5/4</option>";
    if ($value=='7/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='7/8'>7/8</option>";
    if ($value=='13/8') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='13/8'>13/8</option>";
    if ($value=='LCF-11-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-11-50J'>LCF-11-50J</option>";
    if ($value=='LCF-12-50J') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF-12-50J'>LCF-12-50J</option>";
    if ($value=='LCF12') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LCF12'>LCF12</option>";
    if ($value=='LDF4') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4'>LDF4</option>";
    if ($value=='LDF4RN50A') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF4RN50A'>LDF4RN50A</option>";
    if ($value=='LDF6') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='LDF6'>LDF6</option>";
    echo "</select></td>";
    
    // длинна кабеля
    $value=PrvFill("cable_length_$i",$row5g['cable_length']);
    echo "<td id='rs_td'><input type='text' value='$value' name='cable_length_$i' size='3' pattern='[0-9]*'></td>"; 
  
    // ret
    $value=PrvFill("ret_type_$i",$row5g['ret_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='ret_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='да') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='да'>да</option>";
    echo "</select></td>";
  
    // тип мшу
 /* $value=PrvFill("msu_type_$i",$row5g['msu_type']); 
    echo "<td id='rs_td'><select size='1' id='select_field_small' name='msu_type_$i'>";
    if ($value=='') {$selected='selected';} else {$selected='';}
    echo "<option $selected value=''></option>";
    if ($value=='TMA1800') {$selected='selected';} else {$selected='';}
    echo "<option $selected value='TMA1800'>TMA1800</option>";
    echo "</select></td>";
 */	echo "</tr>";
  }
  echo "</table>";
  
  
}

echo "<br/>";


echo "<br><p><button type='submit' style=\"color: red;\" >сохранить</button></p>";
echo "</form>";


//echo "<pre>";
//print_r ($info);
//echo "</pre>";
?>
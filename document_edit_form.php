<?php
// входные параметры
$id=$_GET['id'];

// основной запрос
$sql =" SELECT ";
$sql.=" sanpasport_num";
$sql.=",sanpasport_date";
$sql.=",protocol_num";
$sql.=",protocol_date";
$sql.=",zakluchenie_num";
$sql.=",zakluchenie_date";
$sql.= " FROM bts";
$sql.= " WHERE bts.Id=".NumOrNull($id);
$query2 = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query2);

// Данные Сан паспорта  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">Сан паспорт</span></b>'
  ,'value' => PrvFill('sanpasport_num',$row['sanpasport_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'sanpasport_num'
  
 ); 
 
  
$info[] = $info1 = array (
   'field' => 'Дата'
  ,'value' => PrvFill('sanpasport_date',$row['sanpasport_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'sanpasport_date'
  
    );
  
$info[] = $info1 = array (
'el_type' => 'break'
);
  
  // Данные Протокол  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">Протокол</span></b>'
  ,'value' => PrvFill('protocol_num',$row['protocol_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'protocol_num'
  
    );
  
   
$info[] = $info1 = array (
   'field' => 'Дата'
  ,'value' => PrvFill('protocol_date',$row['protocol_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'protocol_date'
  
    );
  
$info[] = $info1 = array (
'el_type' => 'break'
);
  
   // Данные Заключение  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">Заключение</span></b>'
  ,'value' => PrvFill('zakluchenie_num',$row['zakluchenie_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'zakluchenie_num'

    );
  
$info[] = $info1 = array (
   'field' => 'Дата'
  ,'value' => PrvFill('zakluchenie_date',$row['zakluchenie_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'zakluchenie_date'
  
    );
  
  // вывод элементов интерфейса
echo "<div id='left_indent'>";
for ($i=0;$i<count($info);$i++) {
	FieldName($info[$i]);
}

echo "</div>";
echo "<div id='right_indent'>";
echo "<form action='document_edit.php?id=$id' method='post' id='document_edit_form'>";
for ($i=0;$i<count($info);$i++) {
  FieldEdit($info[$i]);
}
echo "<p><button type='submit'>сохранить</button></p>";
echo "</form>";
echo "</div>";

?>
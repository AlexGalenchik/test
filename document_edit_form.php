<?php
// ������� ���������
$id=$_GET['id'];

// �������� ������
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

// ������ ��� ��������  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">��� �������</span></b>'
  ,'value' => PrvFill('sanpasport_num',$row['sanpasport_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'sanpasport_num'
  
 ); 
 
  
$info[] = $info1 = array (
   'field' => '����'
  ,'value' => PrvFill('sanpasport_date',$row['sanpasport_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'sanpasport_date'
  
    );
  
$info[] = $info1 = array (
'el_type' => 'break'
);
  
  // ������ ��������  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">��������</span></b>'
  ,'value' => PrvFill('protocol_num',$row['protocol_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'protocol_num'
  
    );
  
   
$info[] = $info1 = array (
   'field' => '����'
  ,'value' => PrvFill('protocol_date',$row['protocol_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'protocol_date'
  
    );
  
$info[] = $info1 = array (
'el_type' => 'break'
);
  
   // ������ ����������  
$info[] = $info1 = array (
   'field' => '<b><span style="color:red">����������</span></b>'
  ,'value' => PrvFill('zakluchenie_num',$row['zakluchenie_num'])
  ,'el_type' => 'text'
  ,'id' => 'select_field'
  ,'name' => 'zakluchenie_num'

    );
  
$info[] = $info1 = array (
   'field' => '����'
  ,'value' => PrvFill('zakluchenie_date',$row['zakluchenie_date'])
  ,'el_type' => 'date'
  ,'id' => 'select_field_medium '
  ,'name' => 'zakluchenie_date'
  
    );
  
  // ����� ��������� ����������
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
echo "<p><button type='submit'>���������</button></p>";
echo "</form>";
echo "</div>";

?>
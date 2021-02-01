<?php
// ������� ���������
$id=$_GET['id'];

// �������� ������
$sql="SELECT";
$sql.= " repeater_number";
$sql.= ",inventory_number";
$sql.= ",place_owner";
$sql.= ",settlements.type";
$sql.= ",settlement";
$sql.= ",area";
$sql.= ",region";
$sql.= ",street_type";
$sql.= ",street_name";
$sql.= ",house_type";
$sql.= ",house_number";
$sql.= ",gsm_config";
$sql.= ",dcs_config";
$sql.= ",umts_config";
$sql.= ",umts900_config";
$sql.= ",date_rep_insert_expl";
$sql.= ",date_rep_on";
$sql.= ",date_rep_off";
$sql.= ",R";
$sql.= ",quantity_rep";
$sql.= ",repeater_type";
$sql.= ",power_type";
$sql.= ",longitudel_s";
$sql.= ",longitudel_d";
$sql.= ",notes";
$sql.= ",rep_diapazons.rep_diapazon";
$sql.= ",repeater_types.diapazon";
$sql.= " FROM repeaters";
$sql.= " LEFT JOIN rep_diapazons";
$sql.= " ON rep_diapazons.Id = repeaters.rep_diapazon_id";
$sql.= " LEFT JOIN settlements";
$sql.= " ON repeaters.settlement_id=settlements.id";
$sql.= " LEFT JOIN areas";
$sql.= " ON settlements.area_id=areas.id";
$sql.= " LEFT JOIN regions";
$sql.= " ON areas.region_id=regions.id";
$sql.= " LEFT JOIN gsm_configs";
$sql.= " ON repeaters.gsm_config_id=gsm_configs.id";
$sql.= " LEFT JOIN dcs_configs";
$sql.= " ON repeaters.dcs_config_id=dcs_configs.id";
$sql.= " LEFT JOIN umts_configs";
$sql.= " ON repeaters.umts_config_id=umts_configs.id";
$sql.= " LEFT JOIN umts900_configs";
$sql.= " ON repeaters.umts9_config_id=umts900_configs.id";
$sql.= " LEFT JOIN repeater_types";
$sql.= " ON repeaters.repeater_type_id=repeater_types.Id";
$sql.= " LEFT JOIN power_types";
$sql.= " ON repeaters.power_type_id=power_types.id";
$sql.= " WHERE repeaters.Id=".NumOrNull($id); 
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

$sql = "SELECT *";
$sql.= " FROM repeater_sectors, antenna_types WHERE";
$sql.= "     repeater_sectors.antenna_type_id=antenna_types.id";
$sql.= " AND repeater_id=$id ORDER BY num,repeater_sectors.id"; 
$query2 = mysql_query($sql) or die(mysql_error());

$sql = "SELECT";
$sql.= " bts_number";
$sql.= ",link_type";
$sql.= ",divider_type";
$sql.= ",incut_place";
$sql.= ",antenna_type";
$sql.= ",height";
$sql.= ",cable_type";
$sql.= ",azimuth";
$sql.= ",repeater_sectors.notes";
$sql.= " FROM repeaters";
$sql.= " LEFT JOIN bts";
$sql.= " ON repeaters.link_bts_id=bts.id";
$sql.= " LEFT JOIN repeater_sectors";
$sql.= " ON repeater_sectors.repeater_link_id=repeaters.id";
$sql.= " LEFT JOIN antenna_types";
$sql.= " ON repeater_sectors.antenna_type_id=antenna_types.id";
$sql.= " WHERE repeaters.Id=".NumOrNull($id); 
$query3 = mysql_query($sql) or die(mysql_error());

If ($row['R'] == 1) {
	$on_off = "<span style=\"color:green;font-weight: bold;\">��������</span>";
} else {
	$on_off = "<span style=\"color:red;font-weight: bold;\">�� ��������</span>";
}

// ��������� ��������
$info1 = array (
   '�����' => $row['repeater_number']
  ,'������' => $on_off 
  ,'�����' =>  FormatAddress($row['type'],$row['settlement'],$row['street_type'],$row['street_name'],$row['house_type'],$row['house_number'],$row['area'],$row['region'])  
  ,'����������' => $row['place_owner']
);
$info2 = array (
	 '���������� ����������' => "<span style=\"color:blue;font-weight:bold;\">".$row['rep_diapazon']."</span>"
  // '������������ gsm' => $row['gsm_config']
  //,'������������ dcs' => $row['dcs_config']
  //,'������������ umts' => $row['umts_config']
  //,'������������ umts900' => $row['umts900_config']
);
$info3 = array (
   '��� ����������� ������������' => $row['repeater_type']
   ,'�������������� ����������' => "<span style=\"color:red;font-weight:bold;\">".$row['diapazon']."</span>" // ��������� �������� �������
   ,'<span style="color:green;">����������� �����</span>' => $row['inventory_number'] // ��������� ��� ������� �������� �.�.
   ,'��� �������' => $row['power_type']
);

if (!empty($row['longitudel_d'])) {
  $geo = MyGeoToDisplay($row['longitudel_s'])." ��&nbsp;&nbsp;&nbsp;".MyGeoToDisplay($row['longitudel_d'])." ��"; 
  $dec_geo = "N".MyGeoToDecDisplay($row['longitudel_s'])."&nbsp;&nbsp;&nbsp;E".MyGeoToDecDisplay($row['longitudel_d']);
}
$info4 = array (
   '����������' => $geo
  ,'���������� ����������' => $dec_geo
  ,'����������' => $row['notes']
);
$info5 = array (
   '���� ���������' => $row['date_rep_on']
  ,'���� ����������' => $row['date_rep_off']
  ,'<span style="color:green;">���� ����� � �����.</span>' => $row['date_rep_insert_expl'] // ��������� ��� ������� �������� �.�.
);
$info6 = array (
   '���������� ���������' => $row['quantity_rep']
);



$table1 = array (
   array ('�����','��� �������','������<br>(������.)','������','tm','te','��� ���.','����� ���.','����������')
); 
for ($i=0; $i<mysql_num_rows($query2); $i++) {
  $row2 = mysql_fetch_array($query2);
  $table1[] = array(
     $row2['num']
    ,$row2['antenna_type']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    ,$row2['notes']
  ); 
}

$table2 = array (
   array ('�� ��������','��� ��������','��� ��������','����� ������','��� �������','������','��� ���.','������','����������')
); 
for ($i=0; $i<mysql_num_rows($query3); $i++) {
  $row2 = mysql_fetch_array($query3);
  $table2[] = array(
     $row2['bts_number']
    ,$row2['link_type']
    ,$row2['divider_type']
    ,$row2['incut_place']
    ,$row2['antenna_type']
    ,$row2['height']
    ,$row2['cable_type']
    ,$row2['azimuth']
    ,$row2['notes']
  ); 
}

// ���� ������ ������ ��������
if ($rm == 'w' || ($fm == 'w' && $_SESSION['enable_to_edit'] == 1) ) {
  $info=array (
     '������������� ����� ������' => "index.php?f=31&id=$id"
    ,'������������� �������' => "index.php?f=32&id=$id"
    ,'������������� ��������' => "index.php?f=33&id=$id"
	,'����������' => "index.php?f=44&id=$id"
	,'������� ���������' => "index.php?f=16&cat=repeaters&id=$id"
  );
  ActionBlock($info);
}


// ����� ��������� ����������
echo "<div>";
echo "  <div id='info_left_indent'>";  
InfoBlock('bts_info_block',$info=array($info1));
InfoBlock('bts_info_block',$info=array($info2,$info3));
InfoBlock('bts_info_block',$info=array($info4));
InfoBlock('bts_info_block',$info=array($info5,$info6));
echo "  </div>";
echo "  <div id='info_right_indent'>"; 
InfoBlock('bts_ad_info_block',$info=array(),'��������� �������',$table1);
InfoBlock('bts_ad_info_block',$info=array(),'������ ��������',$table2);
echo "  </div>";
echo "</div>";
?>
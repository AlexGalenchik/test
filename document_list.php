<?php

$id=$_GET['id'];

// �������� ������ � bts
$sql ="  SELECT ";
$sql.="  site_type";
$sql.=", bts_number";
$sql.=", regions.region as region_bts";
$sql.=", areas.area as area_bts";
$sql.=", settlements.settlement as settlement_bts";
$sql.=", street_type";
$sql.=", street_name";
$sql.=", house_type";
$sql.=", house_number";
$sql.=", place_owner";
$sql.=", sanpasport_num";
$sql.=", sanpasport_date";
$sql.=", protocol_num";
$sql.=", protocol_date";
$sql.=", zakluchenie_num";
$sql.=", zakluchenie_date";
$sql.= " FROM bts";
$sql.= " LEFT JOIN settlements";
$sql.= " ON bts.settlement_id=settlements.Id";
$sql.= " LEFT JOIN areas";
$sql.= " ON settlements.area_id=areas.Id";
$sql.= " LEFT JOIN regions";
$sql.= " ON areas.region_id=regions.Id";
$sql.= " WHERE bts.Id=".NumOrNull($id);
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

If (!empty($row['bts_number'])) {
$sp = "<a href='SANPASPORTA/".$row['bts_number']."' target =\"_blank\" ><b><span style='color: blue;'>�������</span></b></a>"; //����� �� ����� � ����������� �� ������� ����� Optimus
$pr = "<a href=\"file://store3/pir/������� ��/".$row['bts_number']."/\" target=\"_blank\"><b><span style='color: blue;'>������� (IE)</b></a>"; //IE ��������� ������ ����������
} 


//$project = "<a href=\"//store3/pir/������� ��/".$row['bts_number']."\" target =\"_blank\" ><b><span style=\"color: blue;\">�������</span></b></a>"; //����� �� ����� � ��������� �� ������� ����� Optimus

//$sp_link = "<a href='file://Store3/pir/SANPASPORTA/".$row['bts_number']."/' target ='_blank'><b><span style='color: blue;'>����������</span></b></a>"; //������ � ������ ������ ����� IE

//$prot_link = "<a href='file://Store3/developers/������ ����/������/��������� ��� 2018/����������� ��������������� _��� ����� �� 12042018/".stripos($name,$row['bts_number'])."/' target ='_blank'><b><span style='color: blue;'>�������� ���</span></b></a>";


$info1 = array (
    $row['site_type'] => "<b>".$row['bts_number']."</b> -  ".FormatAddress('',$row['settlement_bts'],$row['street_type'],$row['street_name'],$row['house_type'],$row['house_number'],$row['area_bts'],$row['region_bts'])
   ,'<br/>����������' => $row['place_owner']
   
 );
 
 $table1 = array (
   array ('��������','')
  ,array ('����������',$sp)
  ,array ('������',$pr)
  //,array ('����������',$row['zakluchenie_num'],$row['zakluchenie_date'],'����� ����������')
 
);	

If ($doc == 'w') { //���� ���� ����� �� �������� ��������� � ���������

$info=array (
  '���������' => "index.php?f=39&cat=document&id=$id"
 ,'�������������' => "index.php?f=41&id=$id"
  );
}  else {
	$info=array (
  '���������' => "index.php?f=39&cat=document&id=$id"
  );
}
 AdInfoBlock($info);
 
 ////////������� ������� �����  
 $dir = "//store3/pir/������� ��/".$row['bts_number']."/";

 //echo "<a href=\"file://store3/pir/SANPASPORTA/".$row['bts_number']."/\" target=\"_blank\">���������</a>"; //IE ��������� ������ ����������
 

function recursive($dir)
            {
                $odir = opendir($dir);
 
                while (($file = readdir($odir)) !== FALSE) {
					
 
                if ($file == '.' || $file == '..') {
					continue;
                }
 
                else {
                    echo "<li>";
					echo $file;
					//echo " ".$dir.$file;
					
				}
 
                if (is_dir($dir.$file)) {
					
                    echo "<ol class='subdirectory'>";
                    recursive($dir.$file);
                    echo "</ol>";
                    }
                    echo "</li>";
                }
                closedir($odir);
            }
			
 
 
 	
/////// ������� �����




// ����� ��������� ����������
echo "<div>";
	echo "  <div id='info_left_indent'>";  
	InfoBlock('bts_info_block',$info=array($info1),'<span style="color: red;">���������<br/></span>',$table1);
	echo "  </div>";
echo "</div>";
echo "<div>";	
	echo "  <div id='info_right_indent'style=\"padding-left: 2%;\">";
	echo "<h4>�������� ����������:</h4>";
	echo "<table>";
	recursive($dir);
	echo "</table>";
	echo "</div>";
echo "</div>";






?>



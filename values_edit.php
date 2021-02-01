<?php
include_once('config.php');
include_once('functions.php');
session_start();

if ($_GET['obj']=='regions') 
  {
  $table='regions';
  $field='region';
  }
if ($_GET['obj']=='areas') 
  {
  $table='areas';
  $field='area';
  $add="region_id=".GetFromPrvForm('select',3).",";
  }  
if ($_GET['obj']=='settlements') 
  {
  $table='settlements';
  $field='settlement';
  $add="area_id=".GetFromPrvForm('select',3).", type='".$_POST['type']."',";
  }    
if ($_GET['obj']=='construction_2g_types') 
  {
  $table='construction_2g_types';
  $field='construction_type';
  } 
if ($_GET['obj']=='construction_3g_types') 
  {
  $table='construction_3g_types';
  $field='construction_type';
  } 
if ($_GET['obj']=='construction_4g_types') 
  {
  $table='construction_4g_types';
  $field='construction_type';
  }
if ($_GET['obj']=='construction_5g_types') //5G Добавлен
  {
  $table='construction_5g_types';
  $field='construction_type';
  }     
if ($_GET['obj']=='power_types') 
  {
  $table='power_types';
  $field='power_type';
  }    
if ($_GET['obj']=='gsm_configs') 
  {
  $table='gsm_configs';
  $field='gsm_config';
  }   
if ($_GET['obj']=='dcs_configs') 
  {
  $table='dcs_configs';
  $field='dcs_config';
  }  
if ($_GET['obj']=='umts_configs') 
  {
  $table='umts_configs';
  $field='umts_config';
  }
if ($_GET['obj']=='umts900_configs') 
  {
  $table='umts900_configs';
  $field='umts900_config';
  }     
if ($_GET['obj']=='lte_configs') 
  {
  $table='lte_configs';
  $field='lte_config';
  }
if ($_GET['obj']=='5g_configs')   //5G Добавлен
  {
  $table='5g_configs';
  $field='5g_config';
  }     
if ($_GET['obj']=='antenna_types') 
  {
  $table='antenna_types';
  $field='antenna_type';
  $add="tech_type='".$_POST['type']."',";
  }  
if ($_GET['obj']=='agreement_persons') 
  {
  $table='agreement_persons';
  $field='name';
  }    
if ($_GET['obj']=='build_persons') 
  {
  $table='build_persons';
  $field='name';
  }   
if ($_GET['obj']=='build_organizations') 
  {
  $table='build_organizations';
  $field='title';
  }  
if ($_GET['obj']=='project_organizations') 
  {
  $table='project_organizations';
  $field='title';
  } 
if ($_GET['obj']=='repeater_types') 
  {
  $table='repeater_types';
  $field='repeater_type';
  }
if ($_GET['obj']=='rep_diapazons') 
  {
  $table='rep_diapazons';
  $field='rep_diapazon';
  }   

$value=$_POST['record'];   
if ($_GET['id']>0)
  {
  $sql="UPDATE $table SET $add $field=".StrOrNull($value)." WHERE id=".$_GET['id'];
  }
if ($_GET['id']=='new')
  {
  $sql="INSERT INTO $table SET $add $field=".StrOrNull($value);
  }
$href=$_SESSION['sections'][count($_SESSION['sections'])-2]['link'];
  
if (isset($_GET['del']))
  {
  $sql="DELETE FROM $table WHERE id=".$_GET['id'];
  $href=$_SESSION['sections'][count($_SESSION['sections'])-1]['link'];
  } 
$query = mysql_query($sql) or die(mysql_error()) ;

?>
<script>
var param = '<?php echo $href;?>';
document.location.href=param</script> 
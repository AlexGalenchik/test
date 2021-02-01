<?php
include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];

print_r($id);



if ($id>0 && !isset($_GET['del'])) {  // UPDATE
$link=$_SESSION['sections'][count($_SESSION['sections'])-3]['link'];
$edit_type='update';
}
print_r($link);

// основной запрос
$data = array (
   'pbs_number' => $_POST['pbs_number']
  ,'vendor' => $_POST['vendor']
  ,'massa' => $_POST['massa']
  ,'status' => $_POST['status']
  ,'type_pbs' => $_POST['type_pbs']
  ,'tech' => $_POST['tech']
  //,'gsm_conf' => $_POST['gsm_conf']
  //,'dcs_conf' => $_POST['dcs_conf']
  //,'umts_conf' => $_POST['umts_conf']
  //,'u900_conf' => $_POST['u900_conf']
  //,'lte1800_conf' => $_POST['lte1800_conf']
  //,'lte2600_conf' => $_POST['lte2600_conf']
  ,'boards' => $_POST['boards']
  ,'bbu_type' => $_POST['bbu_type']
  ,'rru' => $_POST['rru']
  ,'rrl' => $_POST['rrl']
  ,'place' => $_POST['place']
  ,'event' => $_POST['event']
  ,'start_date' => $_POST['start_date']
  ,'finish_date' => $_POST['finish_date']
  ,'notes' => $_POST['notes']
   );

$id = MySQLAction($data,'podv_bs',$id,$edit_type,true); //Функция вносит изменения и записывает в историю
print_r($id);
?>


 
<script>
var param = '<?php echo $link;?>';
document.location.href=param</script>
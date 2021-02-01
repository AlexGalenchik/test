<?php
include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];
echo $id;

if ($id>0 && !isset($_GET['del'])) {  // UPDATE
$link=$_SESSION['sections'][count($_SESSION['sections'])-3]['link'];
$edit_type='update';
}

// основной запрос
$data = array (

   'Id' => $_POST['Id']
  ,'pbs_number' => $_POST['pbs_number']
  ,'place' => $_POST['place']
  ,'event' => $_POST['event']
  ,'gsm_conf' => $_POST['gsm_conf']
  ,'dcs_conf' => $_POST['dcs_conf']
  ,'umts_conf' => $_POST['umts_conf']
  ,'u900_conf' => $_POST['u900_conf']
  ,'lte1800_conf' => $_POST['lte1800_conf']
  ,'lte2600_conf' => $_POST['lte2600_conf']
  ,'start' => $_POST['start']
  ,'finish' => $_POST['finish']
  ,'month' => $_POST['month']
  ,'status' => $_POST['status']
  ,'longitudel_s' => $_POST['longitudel_s']
  ,'longitudel_d' => $_POST['longitudel_d']
  ,'antenas' => $_POST['antenas']
  ,'razreshenie' => $_POST['razreshenie']
  ,'notes' => $_POST['notes']
   );

$id = MySQLAction($data,'podv_plan',$id,$edit_type,true); //Функция вносит изменения и записывает в историю
?>
<script>
var param = '<?php echo $link;?>';
document.location.href=param</script>
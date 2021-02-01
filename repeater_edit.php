<?php
include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];
$longitudel_s=$_POST['s_grad']." ".$_POST['s_min']." ".$_POST['s_sec'];
$longitudel_d=$_POST['d_grad']." ".$_POST['d_min']." ".$_POST['d_sec'];


if ($id==0) { // INSERT
$link=$_SESSION['sections'][count($_SESSION['sections'])-2]['link'];
$edit_type='insert';
}


if ($id>0 && !isset($_GET['del'])) {  // UPDATE
$link=$_SESSION['sections'][count($_SESSION['sections'])-2]['link'];
$edit_type='update';
}

// основной запрос
$data = array (
   'repeater_number' => $_POST['repeater_number']
  ,'inventory_number' => $_POST['inventory_number'] // Добавлено для отчетов Каменеву В.В.
  ,'settlement_id' => $_POST['settlement_id']
  ,'street_type' => $_POST['street_type']
  ,'street_name' => $_POST['street_name']
  ,'house_type' => $_POST['house_type']
  ,'house_number' => $_POST['house_number']
  ,'place_owner' => $_POST['place_owner']
  ,'rep_diapazon_id' => $_POST['rep_diapazon_id'] // Добавлено. Диапазоны репитеров
  ,'gsm_config_id' => $_POST['gsm_config_id']
  ,'dcs_config_id' => $_POST['dcs_config_id']
  ,'umts_config_id' => $_POST['umts_config_id']
  ,'umts9_config_id' => $_POST['umts9_config_id']
  ,'date_rep_insert_expl' => $_POST['date_rep_insert_expl'] // Добавлено для отчетов Каменеву В.В.
  ,'date_rep_on' => $_POST['date_rep_on']
  ,'date_rep_off' => $_POST['date_rep_off']
  ,'R' => $_POST['R'] // Отметка о включении репитера (1 или 0)
  ,'quantity_rep' => $_POST['quantity_rep'] // Количество репитеров на 1 точке
  ,'repeater_type_id' => $_POST['repeater_type_id']
  ,'power_type_id' => $_POST['power_type_id']
  ,'longitudel_s' => $longitudel_s
  ,'longitudel_d' => $longitudel_d
  ,'notes' => $_POST['notes']
);

$id = MySQLAction($data,'repeaters',$id,$edit_type,true); //Функция вносит изменения и записывает в историю
?>
<script>
var param = '<?php echo $link;?>';
document.location.href=param</script> 
                                                                                                                                                                                                                                                                                                
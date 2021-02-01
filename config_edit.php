<?php
include_once('config.php');
include_once('functions.php');
session_start();

// входные параметры
$id=$_GET['id'];

if ($id>0 && !isset($_GET['del'])) {  // UPDATE
$link=$_SESSION['sections'][count($_SESSION['sections'])-2]['link'];
$edit_type='update';
}

// основной запрос
$data = array (
   'cupboard_2g_count' => $_POST['cupboard_2g_count']
  ,'plan_gsm_config_id' => $_POST['plan_gsm_config_id']
  ,'install_gsm_config_id' => $_POST['install_gsm_config_id']
  ,'work_gsm_config_id' => $_POST['work_gsm_config_id']
  ,'plan_dcs_config_id' => $_POST['plan_dcs_config_id']
  ,'install_dcs_config_id' => $_POST['install_dcs_config_id']
  ,'work_dcs_config_id' => $_POST['work_dcs_config_id']
  ,'cupboard_3g_count' => $_POST['cupboard_3g_count']
  ,'plan_umts_config_id' => $_POST['plan_umts_config_id']
  ,'work_umts_config_id' => $_POST['work_umts_config_id']
  ,'plan_umts9_config_id' => $_POST['plan_umts9_config_id']
  ,'work_umts9_config_id' => $_POST['work_umts9_config_id']
  ,'plan_lte800_config_id' => $_POST['plan_lte800_config_id'] //Добавлен LTE800
  ,'work_lte800_config_id' => $_POST['work_lte800_config_id'] //Добавлен LTE800
  ,'plan_lte_config_id' => $_POST['plan_lte_config_id']
  ,'work_lte_config_id' => $_POST['work_lte_config_id']
  ,'plan_lte2600_config_id' => $_POST['plan_lte2600_config_id']
  ,'work_lte2600_config_id' => $_POST['work_lte2600_config_id']
  ,'plan_5g_config_id' => $_POST['plan_5g_config_id']   // 5G Добавлен
  ,'work_5g_config_id' => $_POST['work_5g_config_id']	// 5G Добавлен
  ,'plan_IoT_config_id' => $_POST['plan_IoT_config_id']
  ,'work_IoT_config_id' => $_POST['work_IoT_config_id']
  ,'iot_client' => $_POST['iot_client']
  ,'cupboard_4g_count' => $_POST['cupboard_4g_count']
  ,'cupboard_5g_count' => $_POST['cupboard_5g_count']   // 5G Добавлен
  ,'date_gsm_on' => $_POST['date_gsm_on']
  ,'date_gsm_off' => $_POST['date_gsm_off']
  ,'date_dcs_on' => $_POST['date_dcs_on']
  ,'date_dcs_off' => $_POST['date_dcs_off']
  ,'date_umts_on' => $_POST['date_umts_on']
  ,'date_umts_off' => $_POST['date_umts_off']
  ,'date_umts900_on' => $_POST['date_umts900_on']
  ,'date_umts900_off' => $_POST['date_umts900_off']
  ,'date_LTE800_on' => $_POST['date_LTE800_on'] //Добавлен LTE800
  ,'date_LTE800_off' => $_POST['date_LTE800_off'] //Добавлен LTE800
  ,'date_LTE_on' => $_POST['date_LTE_on']
  ,'date_LTE_off' => $_POST['date_LTE_off']
  ,'date_LTE2600_on' => $_POST['date_LTE2600_on']
  ,'date_LTE2600_off' => $_POST['date_LTE2600_off']
  ,'date_5g_on' => $_POST['date_5g_on']				// 5G Добавлен
  ,'date_5g_off' => $_POST['date_5g_off']			// 5G Добавлен
  ,'date_IoT_on' => $_POST['date_IoT_on']
  ,'G' => $_POST['G']
  ,'D' => $_POST['D']
  ,'U' => $_POST['U']
  ,'U9' => $_POST['U9']
  ,'L8' => $_POST['L8'] //Добавлен LTE800
  ,'L18' => $_POST['L18']
  ,'L26' => $_POST['L26']
  ,'IoT' => $_POST['IoT']
  ,'5G' => $_POST['5G']								// 5G Добавлен
  ,'die_bs' => $_POST['die_bs'] //отметка отпавшей БС
  ,'sanpasport_num' => $_POST['sanpasport_num']
  ,'sanpasport_date' => $_POST['sanpasport_date']
  ,'protocol_num' => $_POST['protocol_num']
  ,'protocol_date' => $_POST['protocol_date']
  ,'zakluchenie_num' => $_POST['zakluchenie_num']
  ,'zakluchenie_date' => $_POST['zakluchenie_date']
   );

$id = MySQLAction($data,'bts',$id,$edit_type,true); //Функция вносит изменения и записывает в историю
?>
<script>
var param = '<?php echo $link;?>';
document.location.href=param</script> 
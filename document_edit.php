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
   'sanpasport_num' => $_POST['sanpasport_num']
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




  
   




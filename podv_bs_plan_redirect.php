<?php
include_once('config.php');
include_once('functions.php');

 
 $link=$_SESSION['sections'][count($_SESSION['sections'])-3]['link'];
  
 
$conn = connect(); 
function connect() {
    // Create connection
    $conn = mysqli_connect("localhost","root","","mts_dbase");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$pbs_number = $_GET['id'];


    //Вставляем данные, подставляя их в запрос
    $sql = mysqli_query($conn, "INSERT INTO `podv_plan` (`pbs_number`, `event`, `place`, `start`, `finish`, `month`, `status`, `notes`) VALUES ('{$_POST['pbs_number']}', '{$_POST['event']}', 
	'{$_POST['place']}', '{$_POST['start']}', '{$_POST['finish']}', '{$_POST['month']}', '{$_POST['status']}', '{$_POST['notes']}')");
    //Если вставка прошла успешно
    if ($sql) {
       echo '<p>Данные успешно добавлены в таблицу</p>';
    } else {
      echo '<p>Произошла ошибка: ' . mysql_error($conn) . '</p>';
    }
  
  
  ////////////////////////////////////////////
   
?>

<script>
var param = '<?php echo $link;?>';
document.location.href=param
</script>
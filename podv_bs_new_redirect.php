
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
include_once('config.php');
include_once('functions.php');

session_start();
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


// проверка формы /////////////////////////////////////////////////////////////////
	
// 1 получить данные для проверки
	$pbs_number = $_POST['pbs_number'];
	$status = $_POST['status'];
	$type_pbs = $_POST['type_pbs'];
	 
			
// 2 создадим функцию для очистки данных от HTML и PHP тегов
	function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    //$value = htmlspecialchars($value);
    return $value;
}
	
// 3  функцию для проверки длинны строки	
	function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
	
// 4 "прогнать" переменные через эти функции	
	$pbs_number = clean($pbs_number);
	$status = clean($status);
	$type_pbs = clean($type_pbs);
	 
	
	
	
//Если не пустые то идем далее
if(!empty($pbs_number) && !empty($status) && !empty($type_pbs) ) {

    if( check_length($pbs_number, 2, 20) && check_length($status, 2, 20) && check_length($type_pbs, 2, 20) ) { 
 		//Вставляем данные, подставляя их в запрос
		 $sql = mysqli_query($conn, "INSERT INTO podv_bs (pbs_number, status, type_pbs, bbu_type, boards, place, event, start_date, finish_date, notes) 
		VALUES ('{$_POST['pbs_number']}', '{$_POST['status']}', '{$_POST['type_pbs']}', '{$_POST['bbu_type']}', 
		'{$_POST['boards']}', '{$_POST['place']}', '{$_POST['event']}', '{$_POST['start_date']}', '{$_POST['finish_date']}', '{$_POST['notes']}') ");
		 
			if ($sql) {
			echo '<p>Данные успешно добавлены в таблицу.</p>'; 
			} 
			else {
			  echo '<p>Произошла ошибка: ' . mysql_error($conn) . '</p>';
			}   
    }
	
	mysqli_close($conn);
}


print_r ($_POST['pbs_number']);
print_r ($_POST['status']);
print_r ($_POST['type_pbs']);
print_r ($_POST['event']);
print_r ($_POST['boards']);
print_r ($_POST['place']);
print_r ($_POST['start_date']);
print_r ($_POST['finish_date']);
print_r ($_POST['bbu_type']);
print_r ($_POST['notes']);

 ?>
 
 
 

<script>
var param = '<?php echo $link;?>';
document.location.href=param
</script>


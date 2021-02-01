<?php
include_once('../config.php');
include_once('../functions.php');
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//получаем переменные
$type_arenda = $_POST['type_arenda'];
$number = $_POST['number'];
$type = $_POST['type'];
$region = $_POST['region'];
$area = $_POST['area'];
$division = $_POST['division'];

//Для записи Id пользователя нужен его Id для сохранения в RENT
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$type_arenda = clean($type_arenda);
$number = clean($number);
$type = clean($type);
$region = clean($region);
$area = clean($area);
$division = clean($division);

$sql =" SELECT surname, name, middle_name 
		FROM users
		WHERE users.Id = ".$user_id;
		
		$query = mysql_query($sql) or die(mysql_error());
		$row_user = mysql_fetch_array($query);
		
$User_FIO = $row_user['surname']." ".substr($row_user['name'],0,1).".".substr($row_user['middle_name'],0,1).".";		

///////////////////////////////////////СОХРАНЕНИЕ в ИСТОРИЮ///////////////////////////////////////

			$data_new = array ( //массив данных поста, которые были исправлены
								 'type_arenda' => $_POST['type_arenda'] //
								,'type' => $_POST['type']				//		
								,'number' => $_POST['number']       //
								,'region' => $_POST['region']			//		
								,'area' => $_POST['area']				//
								,'division' => $_POST['division']
								,'ispolnitel_id' =>	$user_id
								,'ispolnitel' =>	$User_FIO								//
							);
			$names_new = array ( //массив данных поста, которые были исправлены
								'type_arenda' => 'Тип аренды'
								,'type' => 'Тип объекта'				
								,'number' => 'Номер объекта'
								,'region' => 'Область'			
								,'area' => 'Район'
								,'division' => 'Подразделение'
								,'ispolnitel_id' => 'Исполнитель Id'
								,'ispolnitel' =>	'Исполнитель'
							);				
/////////////////////////////////КОНЕЦ СОХРАНЕНИЯ В ИСТОРИЮ//////////////////////////////////////////

$id = MySQLActionRENT($data_new,'rent','','insert','history_rent',$names_new,'ДОБАВЛЕНИЕ ОБЪЕКТА');
mysqli_close($conn);

$new_url = 'edit.php?Id='.$id;

?>

<script>
    var param = '<?php echo $new_url;?>';
    document.location.href=param
</script>



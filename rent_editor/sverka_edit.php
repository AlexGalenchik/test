<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

$conn = connect(); // Подключение к БД
 
$bts_num = $_GET['bts_num'];
$_SESSION['bts_num'] = $bts_num;

// Находим адрес площадки из файла емкости сети
$sql = " SELECT `adress` FROM `emkost_seti` WHERE `bts_number` LIKE '".$bts_num."' LIMIT 1 ";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
$adress = $row['adress'];

//Определяем уже внесенные ранее записи причин и исполнителя
$sql = " SELECT `info`, `events`,`srok`,`ispolnitel` FROM `delta_info` WHERE `bts_num` LIKE '".$bts_num."' ";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
$info = $row['info'];
$events = $row['events'];
$srok = $row['srok'];
$ispoln = $row['ispolnitel'];

//Формируем массив всех БС, которые есть в таблице DELTA_INFO
		$sql_all = " SELECT DISTINCT `bts_num` FROM `delta_info` ";
		$result = mysqli_query($conn,$sql_all);
		
		$all_objects = [];
		// Заношу данные выгрузки из базы в массив DATA
		For ($i = 0; $i<mysqli_num_rows($result);$i++) {
			$row_bts_all = mysqli_fetch_array($result);
			$all_objects[] = $row_bts_all['bts_num'];
			
		}
				

If (!empty($_GET['bts_num'])) {
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>Редактор <?php echo $bts_num; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href=" bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href=" Style.css">
    <script defer src="script.js"></script>
	<style>
	 textarea {
		resize: none; 
	} 
	
	</style>
</head>
<body>


<div id="cap" class="container mt-1" ><!-- шапка header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
                    <div class="col-md-3 push-9" >
					
                      
                    </div>


                    <div class="col-md-9 pull-3">
					
									
									
					
					<h4>РЕДАКТОР ОБЪЕКТА - <?php echo $bts_num; ?></h4>
				 
					    <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
                                <form action="sverka_edit.php?bts_num=<?php echo $bts_num; ?>" method="post">
                                   									
                                        <a href="sverka.php"><button type="button" class="btn btn-danger">НАЗАД</button></a>
                                    								
										<input type="submit" name="edit_data" type="button" class="btn btn-danger" value="СОХРАНИТЬ" >
									
								 
                            </div>
							
                        </div>
							
                    </div>
                </div>		
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->

<div id="addFilter"  class="container mt-2 pt-2 show_report" >
        <div class="row justify-content-end " >
            <div class="col-12 order-last">
                <div class="row">
                    <div class="box1 col-md-8">
						<label for="bts">Номер NE&nbsp;</label>
                    	<input type="text" class="reg" name="bts" value="<?php echo $bts_num; ?>" disabled>
						
					</div>
					<div class="box1 col-md-8">
                        <label for="adress">Адрес&nbsp;</label>
						<textarea rows="2" cols="40" name="adress" disabled><?php echo $adress; ?></textarea>
                    </div>
					<div class="box1 col-md-8">
                        <label for="reason">Причины&nbsp;</label>
						<!--<input style="height:200px" type="text" rows="10" name="reason" value="<?php //echo $info; ?>" > -->
						<textarea rows="8" name="reason" placeholder="Причины, по которым объект не внесен в БД"><?php echo $info; ?></textarea>
                    </div>
					<div class="box1 col-md-8">
                        <label for="events">Решение&nbsp;</label>
						<!--<input style="height:200px" type="text" rows="10" name="reason" value="<?php //echo $info; ?>" > -->
						<textarea rows="8" name="events" placeholder="Мероприятия по решению проблемы"><?php echo $events; ?></textarea>
                    </div>
					<div class="box1 col-md-8">
                        <label for="srok">Дата<br/>выполнения&nbsp;</label>
						<!--<input style="height:200px" type="text" rows="10" name="reason" value="<?php //echo $info; ?>" > -->
						<input type="date" name="srok" value="<?php echo $srok; ?>">
					</div>
					<div class="box1 col-md-8">
					    <label for="ispolnitel">Ответственный&nbsp;</label>
						<input type="text" name="ispolnitel" value="<?php echo $ispoln; ?>" >
					</div>
					
                </div>
			</div>
		</div>
       
		
        </form>
    </div>
	
<?php

////////// Внесение полученных с формы данных в таблицу DELTA_INFO

	IF ($_POST['edit_data'] == 'СОХРАНИТЬ') { //Если внесены данные в форму
	
		$reason = clean ($_POST['reason']);
		$events = clean ($_POST['events']);
		If ($_POST['srok'] == '0000-00-00' OR $_POST['srok'] == NULL OR empty($_POST['srok'])) {
			$srok = NULL;
		} else {
			$srok = $_POST['srok'];	
		}
		$ispolnitel = clean ($_POST['ispolnitel']);
		
		//Внесение в таблицу DELTA_INFO
		If (in_array($bts_num, $all_objects)) {
				$sql = " UPDATE delta_info SET `info` = '".$reason."'
				,`ispolnitel` = '".$ispolnitel."'
				,`events` = '".$events."'
				,`srok` = '".$srok."'
				WHERE `bts_num` LIKE '".$bts_num."' ";
				$result = mysqli_query($conn,$sql);
		} else {		 
				$sql = "INSERT INTO `delta_info` (`bts_num`,`info`,`events`,`srok`,`ispolnitel`) 
				VALUES ('".$bts_num."','".$reason."','".$events."','".$srok."','".$ispolnitel."')";
				$result = mysqli_query($conn,$sql);
		}
		
		If ($sql) {
					
					echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
					echo "<center><b>ДАННЫЕ внесены!</b></center>";
					?>
					<script>document.location.href="sverka.php"</script>
					<?php
		}  else 
				{
					echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";
					echo "<center><b>ЧТО-ТО ПОШЛО НЕ ТАК!</b></center>";
					?>
					<script>document.location.href="sverka.php"</script>
					<?php
				}
	}

}

 
?>
	



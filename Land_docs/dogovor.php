<?php	
include_once('../rent/core/config.php');
include_once('../rent/core/function.php');
include_once('../config.php');


session_start();

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];

} else {
$user_id = 0;
}

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}

//НОВАЯ ФОРМА 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>ОБЪЕКТ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../rent/Style.css">
    <script defer src="../rent/script.js"></script>
</head>
<body>

    <!-- шапка header-->
	<div id="cap" class="container mt-1" >
		<div class="row align-self-center" >
			<div class="col-12" >
					<div  class="container" >	
						<div class="row align-items-center justify-content-center">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3 arend offset-1">
                                        <a href="index.php?page=<?php echo $_SESSION['page']; ?>"><button type="button" class="btn btn-danger">НАЗАД</button></a>
                                    </div>
                                    <div class="col-md-3">
                                        <?php If($rights == 'Редактор') { ?>
                                        <a href="edit_dogovor.php?Id=<?=$_GET['Id']?>"><button type="button" class="btn btn-danger" >РЕДАКТОР</button></a>
										<?php } ?>
                                    </div>
                                </div>
                            </div>

						    <div class="col-md-3" >
                                <div class="row align-items-center">
                                    <!-- ФОРМА АВТОРИЗАЦИИ -->
                                    <?php
                                    // блок ввода авторизации
                                    if ($user_id == 0) {
                                        include('/login_form.php');
                                        }
                                            if ($user_id > 0) {
                                                     echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                        ". $_SESSION['user_surname'] ." 
																		". $_SESSION['user_name']."
																		". $_SESSION['middle_name']."
																		[". $_SESSION['reg_user']."]												 
																		[". $rights."]																													 
                                                                    </div>
                                                               <div class=\"w-100\"></div>
                                                                    <div class='col'>
                                                                          <a href='logout.php'><button >выйти</button></a>
																		  "."Online:" . GetUsersOnline()."
                                                                    </div>			
                                                            </div>
                                                            <div id='log_info'  class=\"col-2\">   
                                                                   <img src='../pics/users/".$_SESSION['user_login'].".jpg' >
                                                            </div>                                                         
                                 </div>";
                                                }
                                    ?>
                               </div>
						  </div>		<!-- КОНЕЦ ФОРМЫ АВТОРИЗАЦИИ -->

						</div>
					</div>
			</div>
		</div>
	</div>	 <!--шапка header-->

<?php
function selectTable($conn){
    // получение данных из БД (выбираем все поля из rent кроме первого поля Id)!!!
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id = ".$_GET['Id'];
	
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}



    If (($user_id > 0) && isset($_GET['Id'])) {
            //  подключения к БД
          $conn = connect();
        //выбор данных из таблицы в виде массива
          $data = selectTable($conn);
        // вывод область, район если они есть
            if(!empty($data[0]['oblast'])) {
                $region_out = $data[0]['oblast']." обл., ";
            }
            else {
                $region_out="";
            }
            if(!empty($data[0]['raion'])) {
                $area_out = $data[0]['raion']." р-н, ";
            }
            else {
                $area_out="";
            }
			if(!empty($data[0]['nas_punkt'])) {
                $nas_punkt = $data[0]['nas_punkt'];
            }
            else {
                $nas_punkt="";
            }
			if(!empty($data[0]['adress'])) {
                $adress = ", ".$data[0]['adress'];
            }
            else {
                $adress="";
            }
           $adress_dogovor = $region_out.$area_out.$nas_punkt.$adress;
    }
?>

<div  class=" container mt-2">
<div class="row align-self-center">	
			<div class="col-12">	
					<div  class="container">
						<div class="row justify-content-end align-items-center">
						  <div class="col-md-6 offset-1" >
						  <?php If($rights == 'Редактор') { ?>
							<form action="upload.php?Id=<?=$_GET['Id']?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="MAX_FILE_SIZE" value="15000000000">
								<input type="file" name="uploadfile"> 
								<input type="submit" name="uploadDoc" class="btn btn-danger" value="ЗАГРУЗИТЬ" >
							</form> 
						  <?php } ?>
						  </div>
						  <div class="col-md-3" >
                               <a href="open_doc.php?Id=<?=$_GET['Id']?>" target="_blank"><button type="button"   class="btn btn-danger" >ДОКУМЕНТЫ</button></a>
						 </div>
                            <div class="col-md-2">
                                <a href="history_form.php?id=<?=$_GET['Id']?>"><button type="button" class="btn btn-danger"><b>HISTORY</b></button></a>
                            </div>
						</div>
					</div>
			</div>		
		</div>	


</div>
    <form action="index.php" method="POST">

 <div  class="container mt-2"> <!--данные по площадке-->
    <h5>Данные по Земельному участку</h5>
     <div class="row my-1 mx-1">
         <div class="col-md-7 ">
			<div class="row block">
				<div class="col"><h5>Параметры NE</h5> </div>
				<div class="w-100"></div>
                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>Данные БС</h5> -->
					<div class="box">
                         <input type="text"  id="bts" style="width: 60%;" name="bts" value="<?php echo $data[0]['bts']; ?>" disabled>
                         <label for="bts">Номер NE</label>
                    </div>
					<div class="box">
                         <input type="text"  id="type_opori" style="width: 60%;" name="type_opori" value="<?php echo $data[0]['type_opori']; ?>" disabled>
                         <label for="type_opori">Тип опоры</label>
                    </div>
					<div class="box">
                         <input type="text"  id="ispolnitel" style="width: 60%;" name="ispolnitel" value="<?php echo $data[0]['ispolnitel']; ?>" disabled>
                         <label for="ispolnitel">Исполнитель</label>
                    </div>
                 </div>

                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>Адрес</h5> -->
                     <div class="box">
                         <input type="text" id="oblast" name="oblast" style="width: 75%;" value="<?php echo $data[0]['oblast']; ?>" disabled> <!-- Берется из Базы -->
                         <label for="oblast">Обл.</label>
                     </div>
                     <div class="box">
                         <input type="text" id="raion" name="raion" style="width: 75%;" value="<?php echo $data[0]['raion']; ?>" disabled> <!-- Берется из Базы -->
                         <label for="raion">Р-н</label>
                     </div>
					 <div class="box">
                         <input type="text" id="nas_punkt" name="nas_punkt" style="width: 75%;" value="<?php echo $data[0]['nas_punkt']; ?>" disabled> <!-- Берется из Базы -->
                         <label for="nas_punkt">Нас.п.</label>
                     </div>
					  <div class="box">
                         <input type="text" id="nas_punkt" name="nas_punkt" style="width: 75%;" value="<?php echo $data[0]['adress']; ?>" disabled> <!-- Берется из Базы -->
                         <label for="nas_punkt">Адрес</label>
                     </div>
					 
                 </div>

                    <div class="w-100">
						<div class="col mt-2">
							<div class="box area">
								<textarea id="adres" rows="2" name="adres" placeholder="<?php echo $adress_dogovor; ?>" disabled></textarea> <!-- Берется из Базы -->
								<label for="adres">Полный адрес</label>
							</div>
							
						</div>
					</div>
                    
             </div>
         </div>
         <div class="col-md-5 ">

             <!-- <h5>Параметры помещения</h5> -->
             <div class="row block">
                 <div class="col ">
                     <h5>Земельный участок</h5>
<!--                     через div-->
                    <div class="box">
                        <input type="text" id="svidetelstvo_land" name="svidetelstvo_land" value="<?php echo $data[0]['svidetelstvo_land']; ?>" disabled>
                        <label for="svidetelstvo_land">Свид-во гос. рег. ЗУ</label>
                    </div>
					<div class="box">
                        <input type="date" id="svidetelstvo_land_date" name="svidetelstvo_land_date" value="<?php echo $data[0]['svidetelstvo_land_date']; ?>" disabled>
                        <label for="svidetelstvo_land_date">Дата Свид-ва</label>
                    </div>
                    <div class="box">
                        <input type="text" id="kadastroviy_number" name="kadastroviy_number" value="<?php echo $data[0]['kadastroviy_number']; ?>" disabled>
                         <label for="kadastroviy_number">Кадастровый номер ЗУ</label>
                    </div>
                    <div class="box">
                        <input type="number" id="land_area" name="land_area" value="<?php echo $data[0]['land_area']; ?>" disabled>
                        <label for="land_area">Площадь участка (Га)</label>
                    </div>
                    <div class="box">
                        <input type="text" id="type_rent" name="type_rent" value="<?php echo $data[0]['type_rent']; ?>" disabled>
                        <label for="type_rent">Вещное право</label>
                    </div>
                    <!--<div class="box">
                        <input type="text" id="resheniye_videlenie" name="resheniye_videlenie" value="<?php //echo $data[0]['resheniye_videlenie']; ?>" disabled>
                        <label for="resheniye_videlenie">Решение о выд-ии ЗУ</label>
                    </div>
					<div class="box">
                        <input type="date" id="resheniye_videlenie_date" name="resheniye_videlenie_date" value="<?php //echo $data[0]['resheniye_videlenie_date']; ?>" disabled>
                        <label for="resheniye_videlenie_date">Дата реш. о выд-ии ЗУ</label>
                    </div>-->
				 </div>
             </div>


         </div> <!-- Параметры помещения-->
     </div>
 </div><!--данные по площадке-->

<div class="container mt-2">
   <h5>Данные по договору и строению</h5>
    <div class="row mx-1 my-1">
			<div class="col-md-6" style="margin-left: 10px;"><!--            Данные по договору-->
                <div class="row block">
                    <div class="col">
                        <h5>Арендная Плата</h5>
                        <div class="box">
                            <input type="number" id="rent_BYN" name="rent_BYN" value="<?php echo $data[0]['rent_BYN']; ?>" disabled>
                            <label for="rent_BYN">Годовая АП (BYN)</label>
                        </div>
						<div class="box">
                            <input type="number" id="rent_USD" name="rent_USD" value="<?php echo $data[0]['rent_USD']; ?>" disabled>
                            <label for="rent_USD">Годовая АП (USD)</label>
                        </div>
                    </div>
                </div>
                 <div class="row block">
					<div class="col">
					  <h5>Дополнительные сведения</h5>
					<!--
						<div class="box">
							<input type="text" id="resheniye_videlenie" name="resheniye_videlenie" value="<?php //echo $data[0]['resheniye_videlenie']; ?>" disabled>
							<label for="resheniye_videlenie">Решение о выд-ии ЗУ</label>
						</div>
						<div class="box">
							<input type="date" id="resheniye_videlenie_date" name="resheniye_videlenie_date" value="<?php //echo $data[0]['resheniye_videlenie_date']; ?>" disabled>
							<label for="resheniye_videlenie_date">Дата Решения о выд-ии ЗУ</label>
						</div>
						<div class="box">
							<input type="text" id="razreshenie_number" name="razreshenie_number" value="<?php //echo $data[0]['razreshenie_number']; ?>" disabled>
							<label for="razreshenie_number">Решение о разрешении,СМР</label>
						</div>
						<div class="box">
							<input type="date" id="razreshenie_number_date" name="razreshenie_number_date" value="<?php //echo $data[0]['razreshenie_number_date']; ?>" disabled>
							<label for="razreshenie_number_date">Дата Решения о разр-ии, СМР</label>
						</div>
					-->
						<div class="box">
								<textarea id="notes" rows="8" name="notes" disabled><?php echo $data[0]['notes']; ?></textarea>
								<label for="notes">Примечания</label>
						</div>

					</div>	
				</div>  
				 

			</div><!--            Данные по договору-->

		<div class="col-md-6" style="margin-left: -10px;"><!--        параметры догвора-->
			<div class="row block">
				<div class="col">
					<h5>Параметры договора</h5>

					<div class="box">
						<input type="text" id="dogovor_number" name="dogovor_number" value="<?php echo $data[0]['dogovor_number']; ?>" disabled>
						<label for="dogovor_number">Номер договора аренды</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_date" name="dogovor_date" value="<?php echo $data[0]['dogovor_date']; ?>" disabled>
						<label for="dogovor_date">Дата договора</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_start" name="dogovor_start" value="<?php echo $data[0]['dogovor_start']; ?>" disabled>
						<label for="dogovor_start">Дата начала договора</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_finish" name="dogovor_finish" value="<?php echo $data[0]['dogovor_finish']; ?>" disabled>
						<label for="dogovor_finish">Дата окончания договора</label>
					</div>
					

				</div>
			</div>	
				<div class="row block">
				<div class="col">
					<h5>Документы на Строение</h5>

					<div class="box">
						<input type="text" id="inventarniy_building" name="inventarniy_building" value="<?php echo $data[0]['inventarniy_building']; ?>" disabled>
						<label for="inventarniy_building" title="(номер регистр в гос кадастре)">Инвент. номер кап. стр-я</label>
					</div>
					<div class="box">
						<input type="text" id="svidetelstvo_building" name="svidetelstvo_building" value="<?php echo $data[0]['svidetelstvo_building']; ?>" disabled>
						<label for="svidetelstvo_building">Cвид-во о гос рег. кап. стр-я</label>
					</div>
					<div class="box">
						<input type="date" id="svidetelstvo_building_date" name="svidetelstvo_building_date" value="<?php echo $data[0]['svidetelstvo_building_date']; ?>" disabled>
						<label for="svidetelstvo_building_date">Дата Cвидетельства</label>
					</div>
				</div>
			</div>			

        </div><!--        параметры догвора-->
		
        </div>
     </div>
</div>

       
    </form>


<!--узнать время жизни сессии-->
<?php
//$maxlifetime = ini_get("session.gc_maxlifetime");
//$cookielifetime = ini_get("session.cookie_lifetime");
//
//echo $maxlifetime;
//echo $cookielifetime;
?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>
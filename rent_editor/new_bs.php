<?php
include_once('../config.php');
include_once('../functions.php');
include_once('./core/function.php');
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
    <title>НОВЫЙ ДОГОВОР</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
</head>
<body>
<form action="redirectNewBS.php" method="POST"> <!-- НАЧАЛО ФОРМЫ -->
    <!-- шапка header-->
    <div id="cap" class="container mt-1" >
        <div class="row align-self-center" >
            <div class="col-12" >
                <div  class="container" >
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="row align-items-center ">
                            <!--<div class="col-md-3 arend">
                                    <a href="geo_finder.php"><button type="button" class="btn btn-danger">ПОИСК NE</button></a>
                                </div> -->
								<div class="col-md-2">
                                    <a href=" <?php echo $_SERVER['HTTP_REFERER']; ?>"><button type="button" class="btn btn-danger"> НАЗАД </button></a>
                                </div>
                                <div class="col-md-3">
                                    <input class="btn btn-danger" name="NewButton" type="submit"  value="СОХРАНИТЬ">
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="row align-items-center">
                                <!-- ФОРМА АВТОРИЗАЦИИ -->
                                <?php
                                // блок ввода авторизации

                                if ($user_id > 0) {
                                    echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                         ". $_SESSION['user_surname'] ." 
                                                                         ". $_SESSION['user_name']."
                                                                         ". $_SESSION['middle_name'] ."
																		[". $_SESSION['reg_user'] ."]
																		[".$rights."]																		 
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

    <?php If ($user_id > 0) { ?>


    <!--данные по площадке-->
    <div  class="container mt-3 mb-3 ">
        <br>
        <h5 style="font-size: 26px">Внести начальные данные нового объекта</h5>
        <div class="row my-3 mx-1">
            <div class="col ">
                <div class="row mt-3 block">
                    <div class="col"><h5>Параметры нового объекта</h5> </div>
                    <br>
                    <br>
                    <div class="w-100"></div>
                    <div class="col-md-12 col-lg-6">
                        <!--  <h5>Данные БС</h5> -->
                        <div class="box">
                            <select  style="width: 60%;" class="type_arenda" name="type_arenda" >
                                <option value=""></option>
                                <option value="МТС Арендует">МТС Арендует</option>
                                <option value="МТС Сдает">МТС Сдает</option>
                                <option value="Офисы, админ. пом., склады">Офисы, админ.пом., склады</option>
								<option value="Техническая поддержка">Техническая поддержка</option>
                             </select>
                            <label for="type_arenda" >Тип Аренды</label>
                        </div>
                        <br>
                        <div class="box numBS">
                            <input type="text" id="number" name="number" value="no_numb" style="width: 60%;" required>
                            <label for="number">Номер NE</label>
                        </div>
                        <br>
                        <div class="box">
                            <select style="width: 60%;" class="selectDistributs" ></select>
                            <label for="type" title="тип площадки (БС, FTTx, офис, репитер, коммутатор, ВОЛС)">Тип оборудования </label>
                        </div>
                    </div>
					
					<!-- Скрипт для выбора типа оборудования в зависимости от типа Аренды -->		 
				 <script defer>
					
					let arr = {
                    "МТС Арендует" : ["",	"БС" , "Репитер" , "FTTx" ,	"БС_FTTx" , "ВОЛС" , "ВОЛС в канализации" , "Wi-Fi", "коммутатор", "unit" ]

                    ,"МТС Сдает" :  ["", "БС" ,	"ВОЛС" , "Канализация" , "Пом./строение" ]

					,"Офисы, админ. пом., склады" : [ "", "Админ. пом." , "Салон связи" , "Технич. пом." , "Склад" , "Архив" ]

                    ,"Техническая поддержка" : [ "" ]

                };

                // создаем селект для выбора районов
                var x = document.querySelector('.selectDistributs');
                console.log(x);
                x.setAttribute("id", "mySelect");
                x.setAttribute("name", "type");
                // distr.appendChild(x);
                // создание   option
                let z = document.createElement("option");
                // console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['type_arenda']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);


                // функция onchange  срабатывает по изменению областей
                document.querySelector('.type_arenda').onchange = function () {
                    // выбираем область в переменную selectType_arenda
                    let option = document.querySelectorAll('.type_arenda option');
                    // console.log(option);
                    for (let i = 0; i < option.length; i++) {
                        if (option[i].selected) {
                            var selectType_arenda = option[i].value;
                            console.log(selectType_arenda);
                        }
                    }

                    function myFunction() {
                        // выбираем районны
                        for(key in arr) {
                            if (selectType_arenda == key) {
                                let opt = document.querySelectorAll("#mySelect option");
                                for (let i = 0; i < opt.length; i++) {
                                    opt[i].remove();
                                }

                                for (let i = 0; i < arr[key].length; i++) {
                                    z = document.createElement("option");
                                    z.setAttribute("value", arr[key][i]);
                                    t = document.createTextNode(arr[key][i]);
                                    z.appendChild(t);
                                    document.getElementById("mySelect").appendChild(z);
                                }
                            }
                        }

                    }

                    myFunction();
                }

            </script>
			<!-- Конец скрипта для выбора типов оборудования -->

                    <div class="col-md-12 col-lg-6">
                        <!--  <h5>Адрес</h5> -->
                        <div class="box">
                            <label for="region">Область</label> <!-- Выпадающий список всех областей с их Id -->
							
							<?php if($_SESSION['reg_user'] == 'Админ') { ?>
							
                            <select id="region" name="region" style="width: 75%;" required>
                                <option value=""></option>
                                <option value="Брестская">Брестская</option>
                                <option value="Витебская">Витебская</option>
                                <option value="Гомельская">Гомельская</option>
                                <option value="Гродненская">Гродненская</option>
                                <option value="Минская">Минская</option>
                                <option value="Могилевская">Могилевская</option>
                            </select>
							<?php } else { ?>
								<input type="text" id="region" name="region" style="width: 75%;" value="<?=$_SESSION['reg_user'];?>" required>
                                							
							<?php } ?>
                        </div>
                        <br>
						
                        <div class="box">
                            <label for="area">Район</label> <!-- Выпадающий список всех районов с их Id -->
                            <select id="area" name="area" style="width: 75%;">
                                <option value="<?php  echo $row2['area']; ?>"><?php echo $row2['area']; ?></option>
                                <?php // ПЕРЕЧЕНЬ ВСЕХ РАЙОНОВ В ЗАВИСИМОСТИ ОТ ВЫБРАННОГО РЕГИОНА
								
								If ($_SESSION['reg_user'] !== 'Админ') {
									If ($_SESSION['reg_user'] == 'ОАДО') {
										$region_search = 'Минская';
									} else {
										$region_search = $_SESSION['reg_user'];
									}
									$sql_areas = " SELECT area FROM areas LEFT JOIN regions ON regions.Id = areas.region_id 
									WHERE regions.region LIKE '$region_search' ";
									
								} else {
									$sql_areas = " SELECT Id, area FROM areas ";
								}
								$res = mysql_query($sql_areas);
                                while($row3 = mysql_fetch_assoc($res)){
                                ?>
                                    <option value="<?php echo $row3['area']; ?>"><?php echo $row3['area']; ?></option>
                                <?php }  ?>
                            </select>
                        </div>

                        <br>
                        <div class="box">
                            <label for="division">Подразделение</label>
							
							<?php 
							
							if($_SESSION['reg_user'] == 'Админ') {
										?>
								<select style="width: 75%;"  name="division" required >
                                <option value=""></option>
                                <option value="ОАДО">ОАДО</option>
                                <option value="Брестская">Брест</option>
                                <option value="Витебская">Витебск</option>
                                <option value="Гомельская">Гомель</option>
                                <option value="Гродненская">Гродно</option>
                                <option value="Могилевская">Могилев</option>
                            </select>
							<?php }	else {	?>
								<input type="text" style="width: 75%;"  name="division" value="<?=$_SESSION['reg_user'];?>" required>
							<?php }
							
							?>
				                    
                        </div>

                     </div>
                </div>
            </div>
        </div>
    </div><!--данные по площадке-->


</form> <!-- КОНЕЦ ФОРМЫ -->



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



<?php  } ?>

</body>
</html>

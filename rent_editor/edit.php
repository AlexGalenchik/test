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

$id = $_GET['Id'];  //Перенос в Сессию значения $id договора
$_SESSION['id_dog'] = $id;

//Выборка всех записей для выбранного Id
$sql = "SELECT * FROM rent WHERE Id = ".$_GET['Id']; // Для выбранного Id БС
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

If (mysql_num_rows($query)) {

    // вывод область, район если они естю
    if(!empty($row['region'])) {
        $regon_out = $row['region'] . " обл., ";
    }
    else {
        $regon_out="";
    }
    if(!empty($row['area'])) {
        $area_out = $row['area'] . " р-н, ";
    }
    else {
        $area_out="";
    }
    $adress_dogovor =$regon_out . $area_out . $row['settlement'].", ".$row['adress'];
    }

//НОВАЯ ФОРМА 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>РЕДАКТОР <?php echo $row['type']." ".$row['number']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
</head>
<body>

<form action="redirect.php?Id=<?=$_GET['Id'];  ?>" method="POST"> <!-- НАЧАЛО ФОРМЫ -->
    <!-- шапка header-->
    <div id="cap" class="container mt-1" >
        <div class="row align-self-center" >
            <div class="col-12" >
                <div  class="container" >
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="row align-items-center ">
                                <div class="col-md-3 arend">
                                    <a href="index.php?Id=<?php echo $_GET['Id'];  ?>"><button type="button" class="btn btn-danger">НАЗАД</button></a>
                                </div>
                                <div class="col-md-3">
                                    <input class="btn btn-danger" name="NewButton" type="submit"  value="СОХРАНИТЬ">
                                </div>
                                <div class="col-md-3">
									<a href="history_form.php?id=<?php echo $_GET['Id']; ?>"><button type="button" class="btn btn-danger" ><b>HISTORY</b></button></a>
                                </div>
								<div class="col-md-3">
									<input type="button" class="btn btn-danger" value="DELETE" 
									onclick="if(confirm('Вы уверены, что хотите удалить Договор Id = <?php echo $_GET['Id']; ?>?'))location.href='delete_dogovor.php?id=<?php echo $_GET['Id']; ?>' "/>
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
//                                  echo "<pre>";
//                                	print_r($_SESSION);
//                                	echo "</pre>";
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
 <div  class="container mt-3">
     <h5>Данные по площадке</h5>
     <div class="row my-1 mx-1">
         <div class="col-md-7 ">
			<div class="row block">
				<div class="col"><h5>Параметры NE</h5> </div>
				<div class="w-100"></div>
                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>Данные БС</h5> -->

                     <div class="box">
                         <select style="width: 60%;"  class="type_arenda" name="type_arenda" >
                             <option value="<?php echo $row['type_arenda']; ?>"><?php echo $row['type_arenda']; ?></option>
                             <option value=""></option>
                             <option value="МТС Арендует">МТС Арендует</option>
                             <option value="МТС Сдает">МТС Сдает</option>
                             <option value="Офисы, админ. пом., склады">Офисы, админ. пом., склады</option>
							 <option value="Техническая поддержка">Техническая поддержка</option>
                         </select>
                         <label for="type_arenda">Вид Аренды</label>
                     </div>

                     <div class="box">
                         <input type="text" id="numBS_MTS" name="numBS_MTS" style="width: 60%;" value="<?php echo $row['number']; ?>" >
                         <label for="numBS_MTS"  title="NE - номер сетевого элемента (БС, FTTx, офис, ВОЛС)">Номер NE<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

                     <div class="box">
                         <select style="width: 60%;"  class="selectDistributs" >
                             <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                             <option value=""></option>
                             <!--<option value="БС">БС</option>
							 <option value="Репитер">Репитер</option>
							 <option value="FTTx">FTTx</option>
							 <option value="БС_FTTX">БС_FTTX</option>
                             <option value="ВОЛС">ВОЛС</option>
							 <option value="ВОЛС в канализации">ВОЛС в канализации</option>
                             <option value="Wi-Fi">WI-Fi</option>
                             <option value="Коммутатор">Коммутатор</option>
							 <option value="unit">unit</option>
							 <option value="Офис">Офис</option>
							 <option value="Подвижная БС">Подвижная БС</option>-->
                         </select>
                         <label for="type" title="тип площадки (БС, FTTx, офис, репитор, коммутатор, ВОЛС)">Об-кт РПС<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>
					 
					 <script defer>


                let arr = {
                    "МТС Арендует" : ["",	"БС" , "Репитер" , "FTTx" ,	"БС_FTTx" , "ВОЛС" , "ВОЛС в канализации" , "Wi-Fi", "коммутатор", "unit"]

                    ,"МТС Сдает" :  ["", "БС" ,	"ВОЛС" , "Канализация" , "Пом./строение" ]

					,"Офисы, админ. пом., склады" : [ "", "Админ. пом." , "Салон связи" , "Технич. пом." , "Склад" ,	"Архив"]

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

                     <div class="box">
                         <select style="width: 60%;" id="division"   name="division" >
                             <option value="<?php echo $row['division']; ?>"><?php echo $row['division']; ?></option>
                             <option value="ОАДО">ОАДО</option>
                             <option value="Брестcкая">Брестcкая</option>
                             <option value="Витебская">Витебская</option>
                             <option value="Гомельская">Гомельская</option>
                             <option value="Гродненская">Гродненская</option>
                             <option value="Могилевская">Могилевская</option>
                         </select>
                          <label for="division" title="Регион ответственности">Подразд-е<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

			  		 
                 </div>
				 
	            <div class="col-md-12 col-lg-6">
                     <!--  <h5>Адрес</h5> -->
                     <div class="box">
						 <label for="region">Область</label> <!-- Выпадающий список всех областей с их Id -->
                         <select id="region" name="region" style="width: 75%;">
								<option value="<?php  echo $row['region']; ?>"><?php echo $row['region']; ?></option>
								<option value=""></option>
							<?php // ПЕРЕЧЕНЬ ВСЕХ ОБЛАСТЕЙ
								$res = mysql_query('SELECT `id`, `region` FROM `regions`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['region'];?>"><?php echo $row3['region'];?></option>
							<?php } ?>
						 </select>
					 </div>
                     <div class="box">
						 <label for="area">Район</label> <!-- Выпадающий список районов с их Id -->
                         <select id="area" name="area" style="width: 75%;">
						 <option value="<?php  echo $row['area']; ?>"><?php echo $row['area']; ?></option>
							<?php // ПЕРЕЧЕНЬ ВСЕХ РАЙОНОВ
								$res = mysql_query('SELECT `Id`, `area` FROM `areas`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['area']; ?>"><?php echo $row3['area']; ?></option>
							<?php } ?>
						 </select>
					 </div>

                     <div class="box">
                         <input type="text" id="settlement" name="settlement" style="width: 75%;" value="<?php echo $row['settlement']; ?>"> <!-- Берется из Базы -->
                         <label for="settlement">Нас.п.</label>
                     </div>
                     <div class="box">
                         <input type="text" id="adress" name="adress"  style="width: 75%;" value="<?php echo $row['adress']; ?>" > <!-- Берется из Базы -->
                         <label for="adress">Ул./пр-т</label> <!-- Улица -->
                     </div>



                 </div>

                    <div class="w-100"></div>
                     <div class="col mt-2">
                         <div class="box area">
                             <textarea id="adres_baza" rows="2" name="adres_baza" placeholder="<?php echo $adress_dogovor; ?>" disabled></textarea>
                             <label for="adres_baza">Полный адрес &nbsp;</label>
                         </div>
                     </div>
             </div>
         </div>
         <div class="col-md-5 ">
             <!-- <h5>Параметры помещения</h5> -->
             <div class="row block">
                 <div class="col ">
                     <h5>Данные о помещении</h5>
<!--                     через div-->
                    <div class="box">
                           <input type="number" step="0.001"  id="room" name="room" value="<?php if( !empty( $row['room_area'] ) ) { echo $row['room_area'];}  ?>" >          
						 
                        <label for="room">Помещение (м2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="roof_walls" name="roof_walls" value="<?php if( !empty( $row['roof_area'] ) ) { echo $row['roof_area'];}    ?>" >
                         <label for="roof_walls">Кровля,стены,фасад (м2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="asfalt_square" name="asfalt_square" value="<?php if( !empty( $row['asphalt_pad_area'] ) ) { echo $row['asphalt_pad_area'];}      ?>" >
                        <label for="asfalt_square">Асфальтн.площадка (м2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="cabel" name="cabel" value="<?php if( !empty( $row['length_cable'] ) ) { echo $row['length_cable'];}   ?>" >
                        <label for="cabel">Волокно,кабель (м)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="canalization" name="canalization" value="<?php if( !empty( $row['length_canaliz'] ) ) { echo $row['length_canaliz'];}     ?>" >
                        <label for="canalization">Кабельная канализация<br/>(каналокилометры)</label>
                    </div>
				 </div>
             </div>
         </div> <!-- Параметры помещения-->
     </div>
 </div><!--данные по площадке-->

<div class="container mt-2"><!--            Данные по договору-->
    <h5>Данные по договору</h5>
    <div class="row mx-1 my-1">

			<div class="col-md-6" style="margin-left: 10px;">
                <div class="row block"><!--      Арендная Плата-->
                    <div class="col">
                        <h5>Арендная Плата</h5>
                        <div class="box">

                            <!--                        завсети в БД новый столбец-->
                            <!--                        добавть инпут с НДС и его авто разсчет по формлуле USD*20/100-->

                            <input type="number" step="0.0001" id="summa" name="summa" value="<?php if( !empty( $row['summa'] ) ) { echo $row['summa'];}     ?>" >
                            <label for="summa">Сумма:</label>
                        </div>
                        <div class="box">
                            <label for="type_currency">Тип валюты</label>
                            <select id="type_currency" name="type_currency">
                                <option value="<?php echo $row['type_currency']; ?>"><?php  if( !empty( $row['type_currency'] ) ) { echo $row['type_currency'];}      ?></option>
                                <!--                                <option value=""></option>-->
                                <option value="BYN">BYN</option>
                                <option value="БАВ">БАВ</option>
                                <option value="БВ">БВ</option>
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="box">
                            <input type="number" step="0.0001" id="nds2" name="nds2" value="<?php if( !empty( $row['nds2'] ) ) { echo $row['nds2'];}     ?>" >
                            <label for="nds2">НДС</label>
                        </div>

                    </div>
                </div>
				<div class="row block">
					<div class="col">
					  <h5>Реквизиты</h5>

						<div class="box">
							<input type="text" id="arendodatel" name="arendodatel" value="<?php echo $row['arendodatel']; ?>" >
							<!-- <label for="arendodatel">Арендодатель</label> -->
							<label for="arendodatel"><?php If ($_SESSION['reg_user'] !== 'УРС') {echo 'Арендодатель';} else {echo 'Контрагент';} ?></label>
						</div>
						<div class="box">
							<input type="text" id="arendator" name="arendator" value="<?php echo $row['arendator']; ?>" >
							<label for="arendator">Арендатор</label>
						</div>
						<div class="box">
							<input type="text" id="num_dogovor" name="num_dogovor" value="<?php echo $row['dogovor_number']; ?>" >
							<label for="num_dogovor">№ Договора</label>
						</div>
						<div class="box">
							<select id="type_dogovor" name="type_dogovor" value="<?php echo $row['dogovor_type']; ?>" >
								<option value="<?php echo $row['dogovor_type']; ?>"><?php  if( !empty( $row['dogovor_type'] ) ) { echo $row['dogovor_type'];} ?></option>
								<option value=""></option>
								<option value="аренда">аренда</option>
								<option value="безвоздмездно">безвоздмездно</option>
								<option value="коммунальные">коммунальные</option>
								<option value="эксплутационные">эксплутационные</option>
								<option value="субаренда">субаренда</option>
								<option value="услуга">услуга</option>
								<option value="хранение">хранение</option>
							<select> 
							<label for="type_dogovor">Тип договора</label>
						</div>
						<div class="box">
							<input type="date" id="data_dogovor" name="data_dogovor" value="<?php echo $row['dogovor_date']; ?>" >
							<label for="data_dogovor">Дата договора</label>
						</div>
						<div class="box">
							<input type="date" id="start_dogovor" name="start_dogovor" value="<?php echo $row['start_date_dogovor']; ?>" >
							<label for="start_dogovor">Действует с</label>
						</div>
						<div class="box">
							<input type="date" id="finish_dogovor" name="finish_dogovor" value="<?php echo $row['finish_date_dogovor']; ?>" >
							<label for="finish_dogovor">Действует по</label>
						</div>
						<div class="box">
							<input type="date" id="finish_strah" name="finish_strah" value="<?php echo $row['insurance_finish']; ?>" >
							<label for="finish_strah">Страхование по</label>
						</div>
						<div class="box">
							<select id="prolongaciya" name="prolongaciya" value="<?php echo $row['prolongaciya']; ?>" >
								<option value="<?php echo $row['prolongaciya']; ?>"><?php  if( !empty( $row['prolongaciya'] ) ) { echo $row['prolongaciya'];} ?></option>
								<option value=""></option>
								<option value="да">Да</option>
								<option value="нет">Нет</option>
							</select>
							<label for="prolongaciya">Пролонгация</label>							
						</div>
					</div>	
				</div>
			</div><!--            Данные по договору-->

		<div class="col-md-6" style="margin-left: -10px;"><!--        параметры догвора-->
		
			<div class="row block">
				<div class="col">
					<h5>Параметры</h5>
			<!--		<div class="box">
						<input type="text" id="ako_exist" name="ako_exist" value="<?php echo $row['dogovor_AKO']; ?>" >
						<label for="ako_exist">Наличие АКО</label>
					</div>
			-->		
					<div class="box">
						<select id="ako_exist" name="ako_exist">
							<option value=<?php echo $row['dogovor_AKO']; ?>><?php echo $row['dogovor_AKO']; ?></option>
							<option value=""></option>
							<option value="да">да</option>
							<option value="нет">нет</option>
						</select>
						<label for="ako_exist">Наличие АКО</label>
					</div>
			<!--		<div class="box">
						<input type="text" id="ako_reason" name="ako_reason" value="<?php //echo $row['prichiny_AKO']; ?>" >
						<label for="ako_reason">Причины отсутствия АКО</label>
					</div>
			-->
			<!--		<div class="box">
						<input type="text" id="pud" name="pud" value="<?php echo $row['PUD']; ?>" >
						<label for="pud">Составление ПУД</label>
					</div>
			-->
					<div class="box">
					<select id="pud" name="pud">
						<option value=<?php echo $row['PUD']; ?>><?php echo $row['PUD']; ?></option>
						<option value=""></option>
						<option value="да">да</option>
						<option value="нет">нет</option>
					</select>	
						<label for="pud">Составление ПУД</label>
					</div>
			<!--    <div class="box">
						<input type="text" id="form_own" name="form_own" value="<?php echo $row['own_form']; ?>" >
						<label for="form_own">Форма собственности</label>
					</div>
			-->
			        <div class="box">
					<select id="form_own" name="form_own">
						<option value=<?php echo $row['own_form']; ?>><?php echo $row['own_form']; ?></option>
						<option value=""></option>
						<option value="гос">гос</option>
						<option value="не_гос">не_гос</option>
					</select>	
						<label for="form_own" title="Более 50% - это гос.">Форма собственности<span style="color:red;font-size:12px;"> (?)</span></label>
					</div>
			<!--		<div class="box">
						<input type="text" id="method_AP" name="method_AP" value="<?php echo $row['method_form_AP']; ?>" >
						<label for="method_AP">Метод формирования АП</label>
					</div>
			-->		
					<div class="box">
					<select id="method_AP" name="method_AP">
						<option value=<?php echo $row['method_form_AP']; ?>><?php echo $row['method_form_AP']; ?></option>
						<option value=""></option>
						<option value="ставки">ставки</option>
						<option value="согл_сторон">согл_сторон</option>
						<option value="ставки+согл_сторон">ставки+согл_сторон</option>
					</select>	
						<label for="method_AP">Метод формирования АП</label>
					</div>
					<div class="box">
						<input type="text" id="main_person" name="main_person" rows="2"  placeholder="Формат - Фамилия И.О." value="<?php echo $row['ispolnitel']; ?>" >
						<label for="main_person">Ответственное лицо</label>
					</div>

                    <div class="box">
                        <input type="text" id="svidetelctvo_regist" name="svidetelctvo_regist" value="<?php echo $row['svidetelctvo_regist']; ?>">
                        <label for="svidetelctvo_regist">Свидет-во (Инв.номер ЕГРНИ)</label>
                    </div>


					<div class="box" >
						<textarea id="contact" rows="3" name="contact"  ><?php echo $row['contragent_data']; ?></textarea>
                            <label for="contact">Контакты</label>
					</div>
					<div class="box">
						<textarea id="post_adres" rows="2" name="post_adres"  ><?php echo $row['post_adres']; ?></textarea>
                            <label for="post_adres">Почтовый<br/>адрес</label>
					</div>
					<div class="box">
						<textarea id="notes" name="notes" rows="2"  ><?php echo $row['notes']; ?></textarea>
						<label for="notes">Примечания</label>
					</div>
                    <div class="box">
                        <textarea id="type_rent_propety" rows="2" name="type_rent_propety"><?=$row['type_rent_propety']; ?></textarea>
                        <label for="type_rent_propety">Вид<br>арендуемого<br>имущества<br></label>
                    </div>
				</div>
			</div>

        </div><!--        параметры догвора-->
    </div>
</div>

    <div class="container mt-2"><!--            Данные по договору-->
        <h5>Офисы / склады и сдаваемое в аренду имущество</h5>
        <div class="row mx-1 my-1">


            <div class="col-md-6" style="margin-left: 10px;">

                <div class="row block">
                    <div class="col">
                        <h5>Сдаваемое в аренду имущество</h5>

                        <div class="box">
                            <input type="text" id="type_opory" name="type_opory" value="<?php echo $row['type_opory']; ?>">
                            <label for="type_opory">Тип антенной опоры</label>
                        </div>
                        <div class="box">
                            <input type="text" id="rent_place_TSH" name="rent_place_TSH" value="<?php echo $row['rent_place_TSH']; ?>">
                            <label for="rent_place_TSH">Аренда места в ТШ</label>
                        </div>
                        <div class="box">
                            <input type="text" id="rent_area" name="rent_area" value="<?php echo $row['rent_area']; ?>">
                            <label for="rent_area">Площадь аренды</label>
                        </div>

                    </div>
                </div>


            </div><!--            Данные по договору-->



            <div class="col-md-6" style="margin-left: -10px;"><!--        параметры догвора-->

                <div class="row block">
                    <div class="col">
                        <h5>Офисы / Склады</h5>
                        <div class="box">
                            <label for="naznachenie">Назначение</label>
                            <input  type="text" id="naznachenie" name="naznachenie" value="<?php echo $row['naznachenie']; ?>" >
                        </div>
                        <div class="box">
                            <label for="admin_office">Админ.</label>
                            <input type="number" step="0.001" id="admin_office" name="admin_office" value="<?php echo $row['admin_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="sell_office">Продажы</label>
                            <input type="number" step="0.001" id="sell_office" name="sell_office" value="<?php echo $row['sell_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="tech_office">Тех.</label>
                            <input type="number" step="0.001" id="tech_office" name="tech_office" value="<?php echo $row['tech_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="sklady">Склад</label>
                            <input type="number" step="0.001" id="sklady" name="sklady" value="<?php echo $row['sklady']; ?>" >
                        </div>
                        <!--					<div class="box">-->
                        <!--						<label for="payment">Оплата</label>-->
                        <!--						<input type="text" id="payment" name="payment" value="--><?php //echo $row['payment']; ?><!--" >-->
                        <!--					</div>-->
                        <!--					<div class="box">	-->
                        <!--						<label for="currency">Валюта</label>-->
                        <!--						<input type="text" id="currency" name="currency" value="--><?php //echo $row['currency']; ?><!--" >-->
                        <!--					</div>-->
                    </div>
                </div>
            </div>

        </div><!--        параметры догвора-->
    </div>
    </div>





</form> <!-- КОНЕЦ ФОРМЫ -->



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



<?php  } ?>

</body>
</html>






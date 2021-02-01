<?php session_start(); 
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />   
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
        <title>  БД Отдел развития (Optimus) </title>
        <link rel="shortcut icon" type="image/x-icon" href="pics/favicon.png" />
		<link rel="stylesheet" href="styles.css">
		
			<script type="text/javascript" src="flot/jquery.js"></script>
            <script type="text/javascript" src="flot/jquery.flot.js"></script>
            <script type="text/javascript" src="flot/jquery.flot.time.js"></script>
            <script type="text/javascript" src="flot/jquery.flot.selection.js"></script>
            <script type="text/javascript" src="scripts.js"></script>
			<script type="text/javascript" src="Clock.js"></script>
						
    </head>
	
	<body>
        <?php
        include_once('config.php');
        include_once('functions.php');
        include_once('interface.php');
		
	
	        $user_id = $_SESSION['user_id'];
        if ($user_id > 0) {  // запрос на список прав пользователя
            $sql = "SELECT * FROM users_access WHERE user_id=$user_id";
            $query_access = mysql_query($sql) or die(mysql_error());
            for ($i = 0; $i < mysql_num_rows($query_access); $i++) {
                $row = mysql_fetch_array($query_access);
                if ($row['object_access'] == 'formular managment') {
                    $fm = $row['access_type'];
                }
                if ($row['object_access'] == 'bts managment') {
                    $bm = $row['access_type'];
                }
                if ($row['object_access'] == 'repeater managment') {
                    $rm = $row['access_type'];
                }
                if ($row['object_access'] == 'statistics') {
                    $st = $row['access_type'];
                }
                if ($row['object_access'] == 'budget') {
                    $bg = $row['access_type'];
                }
                if ($row['object_access'] == 'administration') {
                    $admin = $row['access_type'];
                }
                if ($row['object_access'] == 'switches') {
                    $sw = $row['access_type'];
                }
				if ($row['object_access'] == 'maps') {
                    $mp = $row['access_type'];
                }
				if ($row['object_access'] == 'documents') {
                    $doc = $row['access_type'];
                }
				if ($row['object_access'] == 'counters') {
                    $cnt = $row['access_type'];
                }
				if ($row['object_access'] == 'podv') {
                    $pbs = $row['access_type'];
			    }
				if ($row['object_access'] == 'hw') {
                    $hw = $row['access_type'];
			    }
				if ($row['object_access'] == 'doc') {
                    $doc = $row['access_type'];
			    }
				if ($row['object_access'] == 'geo') {
                    $geo = $row['access_type'];
			    }
				
				
            }
        }
	
	
	

// ШАПКА  /////////////////////////////////////////////////
		
		echo "<div id='header'>";
				echo "<div id='left_indent'><a href='main.php' id='button'><div id='text_in_button_child'>Выбор БД (New!)</div></a></div>";
				//echo "<div style=\"padding-right:5px;\"><img src='pics/MTS_Logo_rus_w.png' align='left' width='160px' hight='60px'; ></a></div>";
				
				echo "<div id='left_indent'><h3 style=\"font-size: 21px;text-decoration: none;color:white;\">&nbsp;&nbsp;Отдел Развития Радиоподсистемы (ОРРП)</h3>";
				
				
				echo "</div>";
		        
				// блок отображения аутенфикации <img src='pics/Logo_new_paint.png' align='center' height=\"67px\"><script src=\"//megatimer.ru/get/c7575228caa44d279947f462ceba0940.js\"></script>
        if ($user_id > 0) {
            echo "<div id='log_info'>
					<div style=\"float:right;padding:1px;\">
						<img style=\"border-radius:5px;border:1px solid red;margin-top: 2px;height: 70px;\" src='pics/users/".$_SESSION['user_login'].".jpg' height='70px' >
					</div>" 
					. $_SESSION['user_name']."<br>" 
					. $_SESSION['user_middle_name'] . "<br>" 
					. $_SESSION['user_surname'] . "<br>
			  <br><a href='logout.php'>выйти</a>
			  </div>";
			 
        
			// ВЫВОД КОЛИЧЕСТВА ВКЛЮЧЕННЫХ БС ПО ТЕХНОЛОГИЯМ	
			$sql_bts  = " SELECT "; //Выборка сумм включенных БС по технологиям
			$sql_bts .= " SUM(G) as GSM";
			$sql_bts .= " ,SUM(D) as DCS";
			$sql_bts .= " ,SUM(U) as UMTS";
			$sql_bts .= " ,SUM(U9) as U900";
			$sql_bts .= " ,SUM(L8) as LTE800"; //LTE800 добавлено Галенчик 27.07.2020
			$sql_bts .= " ,SUM(L18) as LTE1800";
			$sql_bts .= " ,SUM(L26) as LTE2600";
			$sql_bts .= " ,SUM(IoT) as IoT";
			$sql_bts .= " ,SUM(5G) as 5G";
			$sql_bts .= " FROM bts";
			$sql_bts .= " WHERE die_bs is NULL";
			$query = mysql_query ($sql_bts) or die (mysql_error()); //загрузка данных выборки в переменную (массив) 
			$row = mysql_fetch_assoc ($query); //формирование ассоциативного массива из данных выборки
			
			echo "<div id='count_bts' style=\"color:yellow;font-size:10px;\">";
				echo "&nbsp;&nbsp;Включено на сети:&nbsp;&nbsp;";
			foreach ($row as $key => $value) {
				if ($value == '') $value = 0;
				echo "<span style=\"color:white;\">".$key." = </span><b><span style=\"color:yellow;\">".$value."</b>&nbsp;&nbsp;";
		
			}
			//echo "</div>";  ////Конец строки вывода количества БС по Технологиям
			
			// ВЫВОД КОЛИЧЕСТВА ВКЛЮЧЕННЫХ РЕПИТЕРОВ 
			$sql_rep  = " SELECT "; //Выборка сумм включенных БС по технологиям
			$sql_rep .= " SUM(R) as REP";
			$sql_rep .= " FROM repeaters";
			$query_rep = mysql_query ($sql_rep) or die (mysql_error()); //загрузка данных выборки в переменную (массив) 
			$row_rep = mysql_fetch_assoc ($query_rep); //формирование ассоциативного массива из данных выборки
			
			//echo "<div id='count_bts' style=\"color:yellow;font-size:12px;\">Включено Репитеров:&nbsp;"; 
			foreach ($row_rep as $key => $value) {
				if ($value == '') $value = 0;
				echo "<span style=\"color:white;\">".$key." = </span><b><span style=\"color:yellow;\">".$value."</b>";
		
			}
			echo "</div>";  ////Конец строки вывода количества БС по Технологиям
		}	
					
        echo "</div>";
///////////////////////////////////////////////////////////
// ЛЕВОЕ ПОЛЕ МЕНЮ  ///////////////////////////////////////
        
			
	

        echo "<div id='sidebar'>";
		if ($user_id > 0) {
			
		echo "<div id='Clock'></div>";
		echo "<div id='days'>".date('d.m.Y')."</div>";
		
		}		
			
 
            if (isset($user_id)) {
            if (isset($fm)) {
                echo "<a href='index.php?f=1' id='button'><div id='text_in_button_child'>Менеджер формуляров</div></a>";
            }
            if (isset($bm)) {
                echo "<a href='index.php?f=2' id='button'><div id='text_in_button_child'>Менеджер базовых станции</div></a>";
            }
            if (isset($rm)) {
                echo "<a href='index.php?f=28' id='button'><div id='text_in_button_child'>Менеджер репитеров</div></a>";
            }
            if (isset($bg)) {
                echo "<a href='index.php?f=11' id='button'><div id='text_in_button_child'>Бюджет</div></a>";
            }
            if (isset($sw)) {
                echo "<a href='index.php?f=34' id='button'><div id='text_in_button_child'>Менеджер включений</div></a>";
            }
            if (isset($st)) {
                echo "<a href='index.php?f=10' id='button'><div id='text_in_button_child'>Статистика</div></a>";
            }
            if ($user_id > 0) {
                echo "<a href='index.php?f=26' id='button'><div id='text_in_button_child'>Кабинет пользователя</div></a>";
            }
            if ($user_id > 0) {
                echo "<a href='index.php?f=38' id='button'><div id='text_in_button_child'>Карта БС</div></a>";
            }
			
			if (isset($geo))  {
                echo "<a href='index.php?f=62' id='button' style=\"color: blue;\"><div id='text_in_button_child'>Вывод списка БС</div></a>";
            }
						
			if (isset($cnt))  {
                echo "<a href='index.php?f=45' id='button'><div id='text_in_button_child'>Счётчики БС</div></a>";
            }
			if ($user_id > 0) {
                echo "<a href='index.php?f=46' id='button'><div id='text_in_button_child' >Подвижные БС</div></a>";
            }
			if (isset($hw))  {
                echo "<a href='index.php?f=55' id='button'><div id='text_in_button_child' >Оборудование БС</div></a>";
            }
			if ($user_id > 0) {
                echo "<a href='index.php?f=56' id='button'><div id='text_in_button_child' >Справочник по оборудованию</div></a>";
            }
			if (isset($admin)) {
                echo "<a href='index.php?f=14' id='button'><div id='text_in_button_child'><span style=\"color:red;\">Администратор</div></a>";
            }
			if (isset($doc))  {
                echo "<a href='index.php?f=39' id='button'><div id='text_in_button_child' >Документация</div></a>";
            }
		
					 
        }
		
		
		//Итоговая таблица по количеству запущенных ФПД за год всеми проектировщиками

$sql = " SELECT";
$sql.= " users.name as name";
$sql.= ",users.surname as surname";
$sql.= ",COUNT(formulars.to_lotus_date) as lotus_count";
$sql.= ",COUNT(formulars.projector_user_id) as fpd_count";
$sql.= ",COUNT(formulars.signed_date) as signed_count";
$sql.= " FROM formulars, users";
$sql.= " WHERE users.Id = formulars.projector_user_id";
$sql.= " AND formulars.create_date >= '".date(Y)."-01-01'";
$sql.= " AND formulars.create_date <= '".date(Y)."-12-31'";
$sql.= " GROUP BY formulars.projector_user_id";
$sql.= " ORDER BY fpd_count DESC";
$query = mysql_query($sql) or die(mysql_error());
//$row = mysql_fetch_array($query);

	if ($user_id > 0) {
		echo "<div id='rating_fpd'>";
		echo "<table><tr><td colspan=4><b>Количество ФПД (".date(Y)." г)</b></tr></th>";
		echo "<tr style=\"color: red;\"><td>Проектировщик</td><td>БД</td><td>Lotus</td><td>Подп.</td></tr>";
		$i = 1;
		While ($i <= mysql_num_rows($query)) {
			$row = mysql_fetch_array($query);
			echo "<tr>";
			echo "<td style=\"text-align: left;\">".$row['surname']." ".$row['name'][0].".</td>";
			echo "<td>".$row['fpd_count']."</td>";
			echo "<td>".$row['lotus_count']."</td>";
			echo "<td>".$row['signed_count']."</td>";
			echo "</tr>";
			$i++;
			$sumfpd +=$row['fpd_count'];
			$sumlotus +=$row['lotus_count'];
			$sumpodpis +=$row['signed_count'];
			}
		echo "<tr style=\"color: red;\"><td>Итого</td><td>".$sumfpd."</td><td>".$sumlotus."</td><td>".$sumpodpis."</td></tr>";
		echo "<tr style=\"color: blue;font-weight:bold;\"><td>На согл. в БД  </td><td>".($sumfpd - $sumlotus)."</td></tr>";
		echo "<tr style=\"color: blue;font-weight:bold;\"><td>На согл. Lotus </td><td>".($sumlotus - $sumpodpis)."</td></tr>";
		echo "</table>";	
		echo "</div>";
		//Окно сообщений от админа
		//echo "<br>";
		//echo "<div>";
		//echo "<table id='rating_fpd' style=\"width:165px\";><tr>";
		//echo "</div>";
		//echo "<div id = 'massages'>";
		//echo "<td><b>Сообщения</b></td></tr>";
		//echo "<tr><td style=\"text-align: left;\">".$message."</td></tr></table>";
		//echo "</div>";
	
		
		
                
				
				
				//echo "<div id=/'chat/'>";
				//echo "<iframe src=\"https://www4.cbox.ws/box/?boxid=4341447&boxtag=0a3oJE\" width=\"170px\" height=\"360px\" allowtransparency=\"yes\" allow=\"autoplay\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"auto\"></iframe>";	
				//echo "</div>";
				
			
			

				// Yandex Погода

                //echo "<div id=\"Yandex_Pogoda\">";
                //echo "<p align=\"center\"><a href=\"https://clck.yandex.ru/redir/dtype=stred/pid=7/cid=1228/*https://yandex.by/pogoda/157\" target=\"_blank\"><img src=\"https://info.weather.yandex.net/157/3.ru.png?domain=ua\" border=\"0\" alt=\"Яндекс.Погода\"/><img width=\"1\" height=\"1\" src=\"https://clck.yandex.ru/click/dtype=stred/pid=7/cid=1227/*https://img.yandex.ru/i/pix.gif\" alt=\"\" border=\"0\"/></a></p>"; 
                //echo "</div>";	
				
				// weather widget start
                //echo "<div id=\"Yandex_Pogoda\">";				
				//echo "<a target=\"_blank\" href=\"https://nochi.com/weather/minsk-17469\"><img src=\"https://w.bookcdn.com/weather/picture/4_17469_1_20_f28383_160_ffffff_333333_08488D_1_ffffff_333333_0_6.png?scode=124&domid=589&anc_id=6194\" /></a>";
				//echo "</div>";
				// weather widget end
				
				// echo "<div id='elka' style=\"margin-top:10px;\"><img src='pics/NewYearTree1.gif' align='center' width='115px' hight='45px'></div>";
				//echo "<div id=\"currency\" style=\"color:white;font-weight: bold;text-align: center;\">";
				//echo "  <i>Обновить курсы</i> - <u>Ctrl+F5</u>";
				//echo "<div id='rating_fpd'><img src=\"http://www.obmennik.by/images/kurs/bestkurs200x1551.png\" width=\"180px\" border=\"0\" ></div>";
				//echo "</div>";	
				
				//Счётчик пользователей онлайн
			function GetUsersOnline(){  
				clearstatcache();
				$SessionDir = session_save_path();
				$Timeout = 60 * 10; 
					if ($Handler = scandir ($SessionDir)){
						$count = count ($Handler);
						$users = 0;
     
						for ($i = 0; $i < $count; $i++){
							if (time() - fileatime ($SessionDir . '/' . $Handler[$i]) < $Timeout){
							$users++;
							}
						}
                         
						return $users;
					} else {
						return 'error';
					}
			}
			echo '<div id=\'counter\'> Online: ' . GetUsersOnline() . '</div>';  
			//Окончание счётчика с выводом количества онлайн	
	}
			
	
				
	echo "</div>";
///////////////////////////////////////////////////////////

// КОНТЕНТ  ///////////////////////////////////////////////  
        echo "<div id='content'>"; //Фоновое изображение как фон контента можно вставить сюда
		

// блок ввода авторизации
        if ($user_id == 0) {
            include('login_form.php');
        }

// блок горизонтальной навигации по разделам
        if ($user_id > 0) {
            echo "<div id='navigation'><table border='0' cellpadding='0' cellspacing='0'><tr>";
            GetSection();
            for ($i = 0; $i < count($_SESSION['sections']); $i++) {
                $tx2 = "";
                if ($i > 0) {
                    $tx2 = "&nbsp;--&nbsp;";
                }
                $tx = $_SESSION['sections'][$i]['name'];
                echo "<td>$tx2</td><td><a href='" . $_SESSION['sections'][$i]['link'] . "'>$tx</a></td>";
            }
            echo "</tr><tr>";
            for ($i = 0; $i < count($_SESSION['sections']); $i++) {
                $tx2 = "";
                $tx = $_SESSION['sections'][$i]['display'];
                echo "<td>$tx2</td><td id='section_display_cell'>$tx</td>";
            }
            echo "</tr></table></div>";

            $section_index = count($_SESSION['sections']) - 1;

            // вывод форм

            if (($_GET['f'] == 1) && (isset($fm))) {
                include('formular_list_form.php');
            }
            if (($_GET['f'] == 2) && (isset($bm))) {
                include('bts_list_form.php');
            }
            if (($_GET['f'] == 17) && (isset($bm) || isset($fm) )) {
                include('bts_info_form.php');
            }
            if (($_GET['f'] == 3) && ( ($bm == 'w') || ($fm == 'w') )) {
                include('bts_edit_form.php');
            }
            if (($_GET['f'] == 4) && ( ($bm == 'w') || ($bg == 'w') || ($fm == 'w'))) {
                include('relations_edit_form.php');
            }
            if (($_GET['f'] == 5) && ( ($bm == 'w') || ($bg == 'w') || ($fm == 'w'))) {
                include('values_list_form.php');
            }
            if (($_GET['f'] == 6) && ( ($bm == 'w') || ($bg == 'w') || ($fm == 'w'))) {
                include('values_edit_form.php');
            }
            if (($_GET['f'] == 7) && ($bm == 'w' || $fm == 'w')) {
                include('config_edit_form.php');
            }
            if (($_GET['f'] == 8) && ($bm == 'w' || $fm == 'w')) {
                include('sectors_edit_form.php');
            }
            if (($_GET['f'] == 9) && ($bm == 'w' || $fm == 'w')) {
                include('transport_edit_form.php');
            }
            if (($_GET['f'] == 10) && (isset($st))) {
                include('statistics_form.php');
            }
            if (($_GET['f'] == 11) && (isset($bg))) {
                include('budget_list_form.php');
            }
            if (($_GET['f'] == 12) && (isset($bg))) {
                include('budget_info_form.php');
            }
            if (($_GET['f'] == 13) && ($bg == 'w')) {
                include('budget_edit_form.php');
            }
            if (($_GET['f'] == 14) && ($admin == 'w')) {
                include('admin_form.php');
            }
            if (($_GET['f'] == 15) && ($admin == 'w')) {
                include('import_form.php');
            }
            if (($_GET['f'] == 16) && (isset($bg) || isset($bm) || isset($fm))) {
                include('history_form.php');
            }
            if (($_GET['f'] == 18) && ($bm == 'w' || $fm == 'w')) {
                include('hardware_edit_form.php');
            }
            if (($_GET['f'] == 19) && ($fm == 'w')) {
                include('formular_edit_form.php');
            }
            if (($_GET['f'] == 20) && (isset($fm))) {
                include('formular_info_form.php');
            }
            if (($_GET['f'] == 21) && ($admin == 'w')) {
                include('users_list_form.php');
            }
            if (($_GET['f'] == 22) && ($admin == 'w')) {
                include('user_edit_form.php');
            }
            if (($_GET['f'] == 23) && (isset($fm))) {
                include('formular_sign_form.php');
            }
            if (($_GET['f'] == 24) && ($fm == 'w')) {
                include('formular_lotus_form.php');
            }
            if (($_GET['f'] == 25) && ($fm == 'w')) {
                include('adsearch_form.php');
            }
            if (($_GET['f'] == 26) && ($user_id > 0)) {
                include('account_info_form.php');
            }
            if (($_GET['f'] == 27) && ($user_id > 0)) {
                include('account_edit_form.php');
            }
            if ($_GET['f'] == 29) {
                include('tasks/' . $_GET['alias'] . '/forms.php');
            }
            if (($_GET['f'] == 28) && (isset($rm))) {
                include('repeater_list_form.php');
            }
            if (($_GET['f'] == 30) && (isset($rm) || isset($fm) )) {
                include('repeater_info_form.php');
            }
            if (($_GET['f'] == 31) && ( ($rm == 'w') || ($fm == 'w') )) {
                include('repeater_edit_form.php');
            }
            if (($_GET['f'] == 32) && ( ($rm == 'w') || ($fm == 'w') )) {
                include('repeater_sectors_edit_form.php');
            }
            if (($_GET['f'] == 33) && ( ($rm == 'w') || ($fm == 'w') )) {
                include('repeater_link_edit_form.php');
            }
			 if (($_GET['f'] == 34) && (isset($sw))) {
                include('switch_list_form.php');
            }
            if (($_GET['f'] == 35) && (isset($sw))) {
                include('switch_info_form.php');
            }
            if (($_GET['f'] == 36) && ($sw == 'w')) {
                include('switch_edit_form.php');
            }
            if ($_GET['f'] == 38) {
                include('map.php');
            }
			if ($_GET['f'] == 39) {
                include('document.php');
            }
			If ($_GET['f'] == 40) {
                include('document_list.php');
            }
			If ($_GET['f'] == 41) {
                include('document_edit_form.php');
            }
			If ($_GET['f'] == 42) {
                include('document_edit.php');
            }
			If ($_GET['f'] == 43) {
                include('razresheniya_info.php');
            }
			If ($_GET['f'] == 44) {
                include('razresheniya_repeaters_info.php');
            }
			If (($_GET['f'] == 45) && (isset($cnt))) {
                include('counter.php');
            }
			If ($_GET['f'] == 46) {
                include('podv_bs.php');
            }
			If ($_GET['f'] == 47)  {
                include('podv_bs_edit_form.php');
            }
			If ($_GET['f'] == 48) {
                include('podv_bs_edit.php');
            }
			If (($_GET['f'] == 49) && ($pbs == 'w')) {
                include('podv_bs_new.php');
            }
			If ($_GET['f'] == 50) {
                include('podv_bs_plan.php');
            }
			If (($_GET['f'] == 51) && ($pbs == 'w')) {
                include('podv_bs_plan_new.php');
            }
			If (($_GET['f'] == 52) && ($pbs == 'w')) {
                include('podv_bs_plan_edit.php');
            }
			If ($_GET['f'] == 53) {
                include('podv_bs_conf_edit.php');
            }
			If ($_GET['f'] == 54) {
                include('podv_bs_search.php');
            }
			If ($_GET['f'] == 55) {
                include('hardware.php');
            }
			If ($_GET['f'] == 56) {
                include('HW_spravka.php');
            }
			If (($_GET['f'] == 57) && (isset($doc))) {
                include('document.php');
            }
			If (($_GET['f'] == 58) ) {
                include('podv_bs_new_redirect.php');
            }
			If (($_GET['f'] == 59) ) {
                include('podv_bs_delete.php');
            }
			If (($_GET['f'] == 60) ) {
                include('podv_bs_plan_delete.php');
            }
			If (($_GET['f'] == 61) ) {
                include('podv_bs_plan_redirect.php');
            }
			If (($_GET['f'] == 62) ) {
                include('geo_poisk_bs.php');
            }
			If (($_GET['f'] == 63) ) {
                include('fpd_repeaters.php');
            }
			
			

            // Разделы по технологии MVC
            if ($_GET['f']>33) {

                require_once 'mvc/route.php';
                
                if ($_GET['f'] == 34) route::start('switchings', 'list');
                if ($_GET['f'] == 37) route::start('switchings', 'total');
            }

            if (($_GET['f'] == 34) && (isset($sw))) {
                include('switch_list_form.php');
            }
            if (($_GET['f'] == 35) && (isset($sw))) {
                include('switch_info_form.php');
            }
            if (($_GET['f'] == 36) && ($sw == 'w')) {
                include('switch_edit_form.php');
            }
        }
		
        echo "</div>";
		
        echo "</body>";
        echo "</html>";
        ?>
		
	

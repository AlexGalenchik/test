<!DOCTYPE html>
<html>
<head>
    <title>������� ���. ��</title>
    <meta charset="windows-1251" />
    <link rel="stylesheet" href="stylecounter.css">
	
	
	<style>
		#content {
			position: absolute;
			top: 35px;
			z-index: -1;
		}
		
	</style>

</head>
<body>

<?php
$link = mysql_connect('127.0.0.1', 'mts_user', 'mts_user'); //���������� � ��������
if (!$link) {
    die('Not connect to server!' . mysql_error());
}
//echo 'Connection to data base Success!<br/>';

//����������� � ���� ������

$db_selected = mysql_select_db('mts_dbase', $link);
if (!$db_selected) {
    die ('No data Base connection!' . mysql_error());
}
//echo 'Connection to data base Success!<br/>';
?>
<ul class='tree' id='tree'>
	 <li class='nameLi'>������� �������
				<ul class='nameUL'>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block-first" checked> <b>�� �� �����������</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label>  <input type="checkbox" data-set-type="block-RNC"/>  <b>�� 3G U2100 �� RNC</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label><input type="checkbox" data-set-type="block-RNC900"/>  <b>�� 3G U900 �� RNC</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label><input type="checkbox" data-set-type="block_BSC"/>  <b>�� 2G (GSM, DCS) �� BSC</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_BBU"/> <b>BBU �� �����</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_LAC2G"/> <b>BSC, LAC 2G</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_LAC3G"/> <b>RNC, LAC 3G</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_LAC4G"/> <b>TAC 4G</b> </label>
								</div>
							</li>
				</ul>
	</li>
		
		<li class='nameLi show' > �� ����������� ������
				<ul class='nameUL disabled'>
							
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBS"/> <b> ��������</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSGSM"/> <b> �� GSM</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSDCS"/> <b> �� DCS</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSU2100"/> <b> �� U2100</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSU900"/> <b> �� U900</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSL800"/> <b> �� LTE 800</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSL1800"/> <b> �� LTE 1800</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSL2600"/> <b> �� LTE 2600</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBSIoT"/> <b> �� IoT</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_PlaceBS_5G"/> <b> �� 5G</b> </label>
								</div>
							</li>
							<li>
								<div class='nameBox'>
									<label> <input type="checkbox" data-set-type="block_Place_Repiter"/> <b> ��������</b> </label>
								</div>
							</li>
				</ul>
		</li>	
</ul>


 
 
 <script>
let nameLi = document.querySelectorAll('.nameLi');
let nameUL = document.querySelectorAll('.nameUL');
for (let i=0; i < nameLi.length; i++){
	console.log('worl_!');
			nameLi[i].onclick = function () {
				console.log(this);
				console.log(nameUL[i]);
			 nameUL[i].classList.toggle('disabled');
			 nameLi[i].classList.toggle('show');
			 	}
}
  </script>
 
 
	 <script>
let box = document.querySelectorAll('input[type="checkbox"]');
for (let i=0; i < box.length; i++){
			box[i].onchange = function () {
			let d = box[i].getAttribute('data-set-type');
			let c = '#'+d;
			document.querySelector(c).classList.toggle('disabled');	
			 	}
}
  </script>



<?php
//������� �� ������ ���������� ���������� ��

function tech_BS ($region) {
	$sql = "SELECT";
	$sql.= " SUM(G) as SUMG";
	$sql.= ",SUM(D) as SUMD";
	$sql.= ",SUM(U) as SUMU";
	$sql.= ",SUM(U9) as SUMU9";
	$sql.= ",SUM(L8) as SUML8";
	$sql.= ",SUM(L18) as SUML18";
	$sql.= ",SUM(L26) as SUML26";
	$sql.= ",SUM(IoT) as SUMIoT";
	$sql.= ",SUM(5G) as SUM5G";
	$sql.= " FROM bts, areas, regions, settlements";
	$sql.= " WHERE bts.settlement_id = settlements.Id";
	$sql.= " AND settlements.area_id = areas.Id";
	$sql.= " AND areas.region_id = regions.Id";
	$sql.= " AND regions.region = '".$region."'";
	$sql.= " AND bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
	$query = mysql_query ($sql) or die (mysql_error());
	$row = mysql_fetch_assoc ($query);
	
	$arr = array (
    'GSM' => $row['SUMG']
   ,'DCS' => $row['SUMD']
   ,'U2100' => $row['SUMU']
   ,'U900' => $row['SUMU9']
   ,'LTE800' => $row['SUML8']
   ,'LTE1800' => $row['SUML18']
   ,'LTE2600' => $row['SUML26']
   ,'IoT' => $row['SUMIoT']
   ,'5G' => $row['SUM5G']
   );

   return $arr;
	
}
 

  // var_dump(tech_BS ("���������"));

echo "<div id='block-first'>";
echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (����������)</b></tr>";
foreach (tech_BS ('���������') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";


echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (����������)</b></tr>";
foreach (tech_BS ('���������') as $key => $value) {
     	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";


echo "<div id='tableNB'>";
 echo "<table>";
echo "<tr><b>���������� ���. (����������)</b></tr>";
foreach (tech_BS ('����������') as $key => $value) {
   	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";


echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (����������)</b></tr>";
foreach (tech_BS ('�����������') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";


echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (����������)</b></tr>";
foreach (tech_BS ('����������') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";


echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (����������)</b></tr>";
foreach (tech_BS ('�������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
 echo "</table></div>";



//������ �� ���� ������	

    $sql_Belar = "SELECT";
	$sql_Belar.= " SUM(G) as SUMG";
	$sql_Belar.= ",SUM(D) as SUMD";
	$sql_Belar.= ",SUM(U) as SUMU";
	$sql_Belar.= ",SUM(U9) as SUMU9";
	$sql_Belar.= ",SUM(L8) as SUML8";
	$sql_Belar.= ",SUM(L18) as SUML18";
	$sql_Belar.= ",SUM(L26) as SUML26";
	$sql_Belar.= ",SUM(IoT) as SUMIoT";
	$sql_Belar.= ",SUM(5G) as SUM5G";
	$sql_Belar.= " FROM bts";
	$sql_Belar.= " WHERE bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
	$query = mysql_query ($sql_Belar) or die (mysql_error());
	$row = mysql_fetch_assoc ($query);
	
	$arrBEL = array (
    'GSM' => $row['SUMG']
   ,'DCS' => $row['SUMD']
   ,'U2100' => $row['SUMU']
   ,'U900' => $row['SUMU9']
   ,'LTE800' => $row['SUML8']
   ,'LTE1800' => $row['SUML18']
   ,'LTE2600' => $row['SUML26']
   ,'IoT' => $row['SUMIoT']
   ,'5G' => $row['SUM5G']
   );

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (����������)</b></tr>";
foreach ($arrBEL as $key => $value) {
	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	}
 echo "</table></div>";
echo "</div>";

//////////////////////////////////////////������� �� RNC ///////////////////////////////

$sql = "SELECT";
$sql.= " rnc.rnc_number as rnc_name";
$sql.= ",bts_number";
$sql.= " FROM bts";
$sql.= " LEFT JOIN rnc"; 
$sql.= " ON rnc.Id = bts.rnc_id";
$sql.= " WHERE bts.U = 1";
$sql.= " AND bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
$query = mysql_query ($sql) or die (mysql_error());
$row = mysql_fetch_assoc ($query);


for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
  $table[] = array(
     'RNC' => $row['rnc_name']
	 ,'NB' => $row['bts_number'] 
    ); 
}
//���������� ������� � ������ �� RNC
for ($j=0; $j < count($table);$j++) {
		switch ($table[$j]['RNC']) {
			case 'RNC200_Minsk1'   : $nb200++ ; break;
			case 'RNC201_Grodno2'  : $nb201++ ; break;
			case 'RNC202_Grodno1'  : $nb202++ ; break;
			case 'RNC203_Minsk2'   : $nb203++ ; break;
			case 'RNC204_Mogilev1' : $nb204++ ; break;
			case 'RNC205_Mogilev2' : $nb205++ ; break;
			case 'RNC206_Minsk3'   : $nb206++ ; break;
			case 'RNC207_Minsk4'   : $nb207++ ; break;
			case 'RNC208_Minsk5'   : $nb208++ ; break;
			case 'RNC221_Brest1'   : $nb221++ ; break;
			case 'RNC222_Brest2'   : $nb222++ ; break;
			case 'RNC241_Vitebsk1' : $nb241++ ; break;
			case 'RNC242_Vitebsk2' : $nb242++ ; break;
			case 'RNC251_Gomel1'   : $nb251++ ; break;
			case 'RNC252_Gomel2'   : $nb252++ ; break; 
			case 'RNC261_Mogilev3' : $nb261++ ; break;
			case 'RNC281_Grodno3'  : $nb281++ ; break;
			case 'RNC299_Minsk6'   : $nb299++ ; break;
			//default: echo "�� ���� RNC".$table[$j]['RNC']." ��� NB".$table[$j]['NB']."<br/>";
		}
}


// ����� ���������� �� �������� ���������� NB �� RNC


// ���������� checkbox
//echo "<div>";
//echo "���������� �� 3G U2100 �� RNC <label> <input type=\"checkbox\" id=\"RNC_BTS\"/> <b>BTS</b> </label>";
//echo "</div>";

echo "<div id='block-RNC' class='disabled'>";
$sum_br = $nb221 + $nb222;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>��������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC221_Brest1</td><td><b>'.$nb221.'</b></td></tr>' ;
echo '<tr><td>RNC222_Brest2</td><td><b>'.$nb222.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_br.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
$sum_vt = $nb241 + $nb242;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>��������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC241_Vitebsk1</td><td><b>'.$nb241.'</b></td></tr>' ;
echo '<tr><td>RNC242_Vitebsk2</td><td><b>'.$nb242.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_vt.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
$sum_gm = $nb251 + $nb252;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>���������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC251_Gomel1</td><td><b>'.$nb251.'</b></td></tr>' ;
echo '<tr><td>RNC252_Gomel2</td><td><b>'.$nb252.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_gm.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
$sum_gr = $nb201 + $nb202 + $nb281;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>����������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC201_Grodno2</td><td><b>'.$nb201.'</b></td></tr>';
echo '<tr><td>RNC202_Grodno1</td><td><b>'.$nb202.'</b></td></tr>';
echo '<tr><td>RNC281_Grodno3</td><td><b>'.$nb281.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_gr.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
$sum_mg = $nb204 + $nb205 + $nb261;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>����������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC204_Mogilev1</td><td><b>'.$nb204.'</b></td></tr>' ;
echo '<tr><td>RNC205_Mogilev2</td><td><b>'.$nb205.'</b></td></tr>' ;
echo '<tr><td>RNC261_Mogilev3</td><td><b>'.$nb261.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_mg.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
$sum_msk = $nb200 + $nb203 + $nb206 + $nb207 + $nb208 + $nb299;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>������� ���. (RNC-NB2100)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC200_Minsk1</td><td><b>'.$nb200.'</b></td></tr>';
echo '<tr><td>RNC203_Minsk2</td><td><b>'.$nb203.'</b></td></tr>' ;
echo '<tr><td>RNC206_Minsk3</td><td><b>'.$nb206.'</b></td></tr>' ;
echo '<tr><td>RNC207_Minsk4</td><td><b>'.$nb207.'</b></td></tr>' ;
echo '<tr><td>RNC208_Minsk5</td><td><b>'.$nb208.'</b></td></tr>' ;
echo '<tr><td>RNC299_Minsk6</td><td><b>'.$nb299.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_msk.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
echo "</div>";

//////////////////////////////////////////////////������� �� U900

$sql = "SELECT";
$sql.= " rnc.rnc_number as rnc_name";
$sql.= ",bts_number";
$sql.= " FROM bts";
$sql.= " LEFT JOIN rnc"; 
$sql.= " ON rnc.Id = bts.rnc_id";
$sql.= " WHERE bts.U9 = 1";
$sql.= " AND bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
$query = mysql_query ($sql) or die (mysql_error());
$row = mysql_fetch_assoc ($query);


for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
  $tableU9[] = array(
     'RNC' => $row['rnc_name']
	 ,'NB' => $row['bts_U9'] 
    ); 
}

//���������� ������� � ������ �� RNC
for ($m=0; $m < count($tableU9);$m++) {
		switch ($tableU9[$m]['RNC']) {
			case 'RNC200_Minsk1'   : $nbu9200++ ; break;
			case 'RNC201_Grodno2'  : $nbu9201++ ; break;
			case 'RNC202_Grodno1'  : $nbu9202++ ; break;
			case 'RNC203_Minsk2'   : $nbu9203++ ; break;
			case 'RNC204_Mogilev1' : $nbu9204++ ; break;
			case 'RNC205_Mogilev2' : $nbu9205++ ; break;
			case 'RNC206_Minsk3'   : $nbu9206++ ; break;
			case 'RNC207_Minsk4'   : $nbu9207++ ; break;
			case 'RNC208_Minsk5'   : $nbu9208++ ; break;
			case 'RNC221_Brest1'   : $nbu9221++ ; break;
			case 'RNC222_Brest2'   : $nbu9222++ ; break;
			case 'RNC241_Vitebsk1' : $nbu9241++ ; break;
			case 'RNC242_Vitebsk2' : $nbu9242++ ; break;
			case 'RNC251_Gomel1'   : $nbu9251++ ; break;
			case 'RNC252_Gomel2'   : $nbu9252++ ; break; 
			case 'RNC261_Mogilev3' : $nbu9261++ ; break;
			case 'RNC281_Grodno3'  : $nbu9281++ ; break;
			case 'RNC299_Minsk6'   : $nbu9299++ ; break;
			//default: echo "�� ���� RNC".$table[$m]['RNC']." ��� NB".$table[$m]['NB']."<br/>";
		}
}
// ����� ���������� �� �������� ���������� NB U900 �� RNC


// ���������� checkbox
//echo "<div>";
//echo "���������� �� 3G U900 �� RNC <label> <input type=\"checkbox\" id=\"RNC900_BTS\"/> <b>BTS</b> </label>";
//echo "</div>";


echo "<div id='block-RNC900' class='disabled'>";
//echo "<h4>���������� ���������� ���������� �� 3G U900 �� RNC</h4>";
unset ($sum_br);
$sum_br = $nbu9221 + $nbu9222;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>��������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC221_Brest1</td><td><b>'.$nbu9221.'</b></td></tr>' ;
echo '<tr><td>RNC222_Brest2</td><td><b>'.$nbu9222.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_br.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sum_vt);
$sum_vt = $nbu9241 + $nbu9242;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>��������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC241_Vitebsk1</td><td><b>'.$nbu9241.'</b></td></tr>' ;
echo '<tr><td>RNC242_Vitebsk2</td><td><b>'.$nbu9242.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_vt.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sum_gm);
$sum_gm = $nbu9251 + $nbu9252;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>���������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC251_Gomel1</td><td><b>'.$nbu9251.'</b></td></tr>' ;
echo '<tr><td>RNC252_Gomel2</td><td><b>'.$nbu9252.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_gm.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sum_gr);
$sum_gr = $nbu9201 + $nbu9202 + $nbu9281;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>����������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC201_Grodno2</td><td><b>'.$nbu9201.'</b></td></tr>';
echo '<tr><td>RNC202_Grodno1</td><td><b>'.$nbu9202.'</b></td></tr>';
echo '<tr><td>RNC281_Grodno3</td><td><b>'.$nbu9281.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_gr.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sum_mg);
$sum_mg = $nbu9204 + $nbu9205 + $nbu9261;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>����������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC204_Mogilev1</td><td><b>'.$nbu9204.'</b></td></tr>' ;
echo '<tr><td>RNC205_Mogilev2</td><td><b>'.$nbu9205.'</b></td></tr>' ;
echo '<tr><td>RNC261_Mogilev3</td><td><b>'.$nbu9261.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_mg.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sum_msk);
$sum_msk = $nbu9200 + $nbu9203 + $nbu9206 + $nbu9207 + $nbu9208 + $nbu9299;
echo "<div id='tableRNC'>";
echo "<table>";
echo "<tr><b>������� ���. (RNC-NB900)</b></tr>";
echo '<tr><td>RNC</td><td>NodeB</td></tr>';
echo '<tr><td>RNC200_Minsk1</td><td><b>'.$nbu9200.'</b></td></tr>';
echo '<tr><td>RNC203_Minsk2</td><td><b>'.$nbu9203.'</b></td></tr>' ;
echo '<tr><td>RNC206_Minsk3</td><td><b>'.$nbu9206.'</b></td></tr>' ;
echo '<tr><td>RNC207_Minsk4</td><td><b>'.$nbu9207.'</b></td></tr>' ;
echo '<tr><td>RNC208_Minsk5</td><td><b>'.$nbu9208.'</b></td></tr>' ;
echo '<tr><td>RNC299_Minsk6</td><td><b>'.$nbu9299.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sum_msk.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
echo "</div>";

//////////////////////////////////////////������� �� BSC ///////////////////////////////

$sql = "SELECT";
$sql.= " bsc.bsc_number as bsc_name";
$sql.= ",bts_number";
$sql.= " FROM bts";
$sql.= " LEFT JOIN bsc"; 
$sql.= " ON bsc.Id = bts.bsc_id";
$sql.= " WHERE bts.G = 1";
$sql.= " AND bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
$query = mysql_query ($sql) or die (mysql_error());
$row = mysql_fetch_assoc ($query);

for ($i=0; $i<= mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
  $tableGSM[] = array(
     'BSC' => $row['bsc_name']
	 ,'BTSG' => $row['bts_number'] 
    ); 
}

//���������� ������� � ������ �� BSC GSM
for ($j=0; $j < count($tableGSM);$j++) {
		switch ($tableGSM[$j]['BSC']) {
			case 'BSC600_Mogilev2'    : $bsg600++ ; break;//
			case 'BSC601_Mogilev1'    : $bsg601++ ; break;//
			case 'BSC603_Bobruisk1'   : $bsg603++ ; break;//
			case 'BSC611_Minsk1'      : $bsg611++ ; break;//
			case 'BSC612_Minsk2'      : $bsg612++ ; break;//
			case 'BSC614_Minsk4'      : $bsg614++ ; break;//
			case 'BSC616_Borisov1'    : $bsg616++ ; break;//
			case 'BSC617_Slutsk1'     : $bsg617++ ; break;//
			case 'BSC618_Molodechno1' : $bsg618++ ; break;//
			case 'BSC621_Brest1'      : $bsg621++ ; break;//
			case 'BSC622_Brest2'      : $bsg622++ ; break;//
			case 'BSC623_Pinsk1'      : $bsg623++ ; break;//
			case 'BSC624_Baranovichi1': $bsg624++ ; break;//
			case 'BSC641_Vitebsk1'    : $bsg641++ ; break;//
			case 'BSC642_Vitebsk2'    : $bsg642++ ; break;// 
			case 'BSC643_Novopolotsk1': $bsg643++ ; break;//
			case 'BSC651_Gomel1'      : $bsg651++ ; break;//
			case 'BSC652_Gomel2'      : $bsg652++ ; break;//
			case 'BSC653_Mozyr1'      : $bsg653++ ; break;//
			case 'BSC661_Mogilev3'    : $bsg661++ ; break;//
			case 'BSC680_Grodno1'     : $bsg680++ ; break;//
			case 'BSC681_Grodno2'     : $bsg681++ ; break;//
			case 'BSC682_Grodno3'     : $bsg682++ ; break;//
			case 'BSC683_Lida1'       : $bsg683++ ; break;//
			case 'BSC699_Minsk6'      : $bsg699++ ; break;//
			//default: echo "�� ���� BSC".$table[$j]['BSC']." ��� BTS".$table[$j]['BTS']."<br/>";
		}
}

$sql = "SELECT";
$sql.= " bsc.bsc_number as bsc_name";
$sql.= ",bts_number";
$sql.= " FROM bts";
$sql.= " LEFT JOIN bsc"; 
$sql.= " ON bsc.Id = bts.bsc_id";
$sql.= " WHERE bts.D = 1";
$sql.= " AND bts.die_bs is NULL";  // ���� ������ ��� ��, ������� �� ������
$query = mysql_query ($sql) or die (mysql_error());
$row = mysql_fetch_assoc ($query);

for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
  $tableDCS[] = array(
     'BSC' => $row['bsc_name']
	 ,'BTSD' => $row['bts_number'] 
    ); 
}

//���������� ������� � ������ �� BSC DCS
for ($k=0; $k <= count($table);$k++) {
		switch ($tableDCS[$k]['BSC']) {
			case 'BSC600_Mogilev2'    : $bsd600++ ; break;//
			case 'BSC601_Mogilev1'    : $bsd601++ ; break;//
			case 'BSC603_Bobruisk1'   : $bsd603++ ; break;//
			case 'BSC611_Minsk1'      : $bsd611++ ; break;//
			case 'BSC612_Minsk2'      : $bsd612++ ; break;//
			case 'BSC614_Minsk4'      : $bsd614++ ; break;//
			case 'BSC616_Borisov1'    : $bsd616++ ; break;//
			case 'BSC617_Slutsk1'     : $bsd617++ ; break;//
			case 'BSC618_Molodechno1' : $bsd618++ ; break;//
			case 'BSC621_Brest1'      : $bsd621++ ; break;//
			case 'BSC622_Brest2'      : $bsd622++ ; break;//
			case 'BSC623_Pinsk1'      : $bsd623++ ; break;//
			case 'BSC624_Baranovichi1': $bsd624++ ; break;//
			case 'BSC641_Vitebsk1'    : $bsd641++ ; break;//
			case 'BSC642_Vitebsk2'    : $bsd642++ ; break;// 
			case 'BSC643_Novopolotsk1': $bsd643++ ; break;//
			case 'BSC651_Gomel1'      : $bsd651++ ; break;//
			case 'BSC652_Gomel2'      : $bsd652++ ; break;//
			case 'BSC653_Mozyr1'      : $bsd653++ ; break;//
			case 'BSC661_Mogilev3'    : $bsd661++ ; break;//
			case 'BSC680_Grodno1'     : $bsd680++ ; break;//
			case 'BSC681_Grodno2'     : $bsd681++ ; break;//
			case 'BSC682_Grodno3'     : $bsd682++ ; break;//
			case 'BSC683_Lida1'       : $bsd683++ ; break;//
			case 'BSC699_Minsk6'      : $bsd699++ ; break;//
			//default: echo "�� ���� BSC".$table[$k]['BSC']." ��� BTS".$table[$k]['BTS']."<br/>";
		}
}
// ����� ���������� �� �������� ���������� BTS �� BSC

// ���������� checkbox
//echo "<div>";
//echo "���������� �� 2G (GSM, DCS) �� BSC <label> <input type=\"checkbox\" id=\"BSC_BTS\"/> <b>BTS</b> </label>";
//echo "</div>";


echo "<div id='block_BSC' class='disabled'>";

//echo "<h4>���������� ���������� ���������� �� 2G (GSM, DCS) �� BSC</h4>";
$sumg = $bsg621 + $bsg622 + $bsg623 + $bsg624;
$sumd = $bsd621 + $bsd622 + $bsd623 + $bsd624;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<tr><b>��������� ���. (BSC-BS)</b></tr>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC621_Brest1</td><td><b>'.$bsg621.'</b></td><td><b>'.$bsd621.'</b></td></tr>' ;
echo '<tr><td>BSC622_Brest2</td><td><b>'.$bsg622.'</b></td><td><b>'.$bsd622.'</b></td></tr>' ;
echo '<tr><td>BSC623_Pinsk1</td><td><b>'.$bsg623.'</b></td><td><b>'.$bsd623.'</b></td></tr>' ;
echo '<tr><td>BSC624_Baranovichi1</td><td><b>'.$bsg624.'</b></td><td><b>'.$bsd624.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sumg);
unset ($sumd);
$sumg = $bsg624 + $bsg642 + $bsg643;
$sumd = $bsd624 + $bsd642 + $bsd643;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<tr><b>��������� ���. (BSC-BS)</b></tr>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC641_Vitebsk1</td><td><b>'.$bsg624.'</b></td><td><b>'.$bsd624.'</b></td></tr>' ;
echo '<tr><td>BSC642_Vitebsk2</td><td><b>'.$bsg642.'</b></td><td><b>'.$bsd642.'</b></td></tr>' ;
echo '<tr><td>BSC643_Novopolotsk1</td><td><b>'.$bsg643.'</b></td><td><b>'.$bsd643.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sumg);
unset ($sumd);
$sumg = $bsg651 + $bsg652 + $bsg653;
$sumd = $bsd651 + $bsd652 + $bsd653;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<tr><b>���������� ���. (BSC-BS)</b></tr>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC651_Gomel1</td><td><b>'.$bsg651.'</b></td><td><b>'.$bsd651.'</b></td></tr>' ;
echo '<tr><td>BSC652_Gomel2</td><td><b>'.$bsg652.'</b></td><td><b>'.$bsd652.'</b></td></tr>' ;
echo '<tr><td>BSC653_Mozyr1</td><td><b>'.$bsg653.'</b></td><td><b>'.$bsd653.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sumg);
unset ($sumd);
$sumg = $bsg680 + $bsg681 + $bsg682 + $bsg683;
$sumd = $bsd680 + $bsd681 + $bsd682 + $bsd683;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<tr><b>����������� ���. (BSC-BS)</b></tr>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC680_Grodno1</td><td><b>'.$bsg680.'</b></td><td><b>'.$bsd680.'</b></td></tr>';
echo '<tr><td>BSC681_Grodno2</td><td><b>'.$bsg681.'</b></td><td><b>'.$bsd681.'</b></td></tr>';
echo '<tr><td>BSC682_Grodno3</td><td><b>'.$bsg682.'</b></td><td><b>'.$bsd682.'</b></td></tr>' ;
echo '<tr><td>BSC683_Lida1</td><td><b>'.$bsg683.'</b></td><td><b>'.$bsd683.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sumg);
unset ($sumd);
$sumg = $bsg600 + $bsg601 + $bsg661 + $bsg603;
$sumd = $bsd600 + $bsd601 + $bsd661 + $bsd603;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<tr><b>����������� ���. (BSC-BS)</b></tr>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC600_Mogilev2</td><td><b>'.$bsg600.'</b></td><td><b>'.$bsd600.'</b></td></tr>' ;
echo '<tr><td>BSC601_Mogilev1</td><td><b>'.$bsg601.'</b></td><td><b>'.$bsd601.'</b></td></tr>' ;
echo '<tr><td>BSC661_Mogilev3</td><td><b>'.$bsg661.'</b></td><td><b>'.$bsd661.'</b></td></tr>' ;
echo '<tr><td>BSC603_Bobruisk1</td><td><b>'.$bsg603.'</b></td><td><b>'.$bsd603.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
unset ($sumg);
unset ($sumd);
$sumg = $bsg611 + $bsg612 + $bsg614 + $bsg699 + $bsg616 + $bsg617 + $bsg618;
$sumd = $bsd611 + $bsd612 + $bsd614 + $bsd699 + $bsd616 + $bsd617 + $bsd618;
echo "<div id='tableBSC'>";
echo "<table>";
echo "<b>������� ���. (BSC-BS)</b></br>";
echo '<tr><td>BSC</td><td>GSM</td><td>DCS</td></tr>';
echo '<tr><td>BSC611_Minsk1</td><td><b>'.$bsg611.'</b></td><td><b>'.$bsd611.'</b></td></tr>';
echo '<tr><td>BSC612_Minsk2</td><td><b>'.$bsg612.'</b></td><td><b>'.$bsd612.'</b></td></tr>' ;
echo '<tr><td>BSC614_Minsk4</td><td><b>'.$bsg614.'</b></td><td><b>'.$bsd614.'</b></td></tr>' ;
echo '<tr><td>BSC699_Minsk6</td><td><b>'.$bsg699.'</b></td><td><b>'.$bsd699.'</b></td></tr>' ;
echo '<tr><td>BSC616_Borisov1</td><td><b>'.$bsg616.'</b></td><td><b>'.$bsd616.'</b></td></tr>' ;
echo '<tr><td>BSC617_Slutsk1</td><td><b>'.$bsg617.'</b></td><td><b>'.$bsd617.'</b></td></tr>' ;
echo '<tr><td>BSC618_Molodechno1</td><td><b>'.$bsg618.'</b></td><td><b>'.$bsd618.'</b></td></tr>' ;
echo '<tr><td>�����</td><td><b>'.$sumg.'</b></td><td><b>'.$sumd.'</b></td></tr>' ;
echo "</table>";
echo "</div>";
echo "</div>";

///////////////////////////////////////������ ���������� BBU �� ����� � ��������

function BBU_Types ($region) {
	$sql = "SELECT";
	$sql.= " SUM(hw_bbu.bbu2g) as SUM_2g";
	$sql.= ",SUM(hw_bbu.bbu3g) as SUM_3g";
	$sql.= ",SUM(hw_bbu.single_bbu) as SUM_single";
	$sql.= ",SUM(hw_bbu.bbu3900) as SUM_3900";
	$sql.= ",SUM(hw_bbu.bbu3910) as SUM_3910";
	$sql.= ",SUM(hw_bbu.bbu3910A3) as SUM_blade";
	$sql.= ",SUM(hw_bbu.virtual_micro) as SUM_micro";
	$sql.= ",SUM(hw_bbu.rhub) as SUM_rhub";
	$sql.= " FROM hw_bbu, bts, areas, regions, settlements";
	$sql.= " WHERE bts.id = hw_bbu.bts_id";
	$sql.= " AND bts.settlement_id = settlements.Id";
	$sql.= " AND settlements.area_id = areas.Id";
	$sql.= " AND areas.region_id = regions.Id";
	$sql.= " AND regions.region = '".$region."'";
	$sql.= " AND bts.die_bs is NULL";
	$query = mysql_query ($sql) or die (mysql_error());
	$row = mysql_fetch_assoc ($query);

	//�������� ������� �� SQL � ������
	$arrBBU = array (
	 'BBU 2G' => $row['SUM_2g']
	,'BBU 3G' => $row['SUM_3g']
	,'BBU 2G+3G' => $row['SUM_single']
	,'BBU3900' => $row['SUM_3900']
	,'BBU3910' => $row['SUM_3910']
	,'BBU Blade' => $row['SUM_blade']
	,'Small Cell' => $row['SUM_micro']
  //,'RHUB' => $row['SUM_rhub']
	);
	
	return ($arrBBU);
	
}


//��� ����������
$sql = "SELECT";
$sql.= " SUM(hw_bbu.bbu2g) as SUM_2g";
$sql.= ",SUM(hw_bbu.bbu3g) as SUM_3g";
$sql.= ",SUM(hw_bbu.single_bbu) as SUM_single";
$sql.= ",SUM(hw_bbu.bbu3900) as SUM_3900";
$sql.= ",SUM(hw_bbu.bbu3910) as SUM_3910";
$sql.= ",SUM(hw_bbu.bbu3910A3) as SUM_blade";
$sql.= ",SUM(hw_bbu.virtual_micro) as SUM_micro";
$sql.= ",SUM(hw_bbu.rhub) as SUM_rhub";
$sql.= " FROM hw_bbu, bts";
$sql.= " WHERE bts.id = hw_bbu.bts_id";
$sql.= " AND bts.die_bs is NULL";
$query = mysql_query ($sql) or die (mysql_error());
$row = mysql_fetch_assoc ($query);

//�������� ������� �� SQL � ������
$arrBel = array (
 'BBU 2G' => $row['SUM_2g']
,'BBU 3G' => $row['SUM_3g']
,'BBU 2G+3G' => $row['SUM_single']
,'BBU3900' => $row['SUM_3900']
,'BBU3910' => $row['SUM_3910']
,'BBU Blade' => $row['SUM_blade']
,'Small Cell' => $row['SUM_micro']
//,'RHUB' => $row['SUM_rhub']
);

////////////////��������� �������///////////////
 echo "<div id='block_BBU' class='disabled'>";

echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>��������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('���������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

////////////////��������� �������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>��������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('���������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);


////////////////���������� �������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>���������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('����������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);


////////////////����������� �������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>����������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('�����������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);


////////////////���������� �������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>���������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('����������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

////////////////������� �������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>������� ������� (BBU)</b></tr>";
foreach (BBU_Types ('�������') as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

////////////////��� ��������///////////////
echo "<div id='tableBBU'>";
echo "<table>";
echo "<tr><b>��� �������� (BBU)</b></tr>";
foreach ($arrBel as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

echo "</div>";

///////////////////////////////////////������ ���������� BSC, LAC 2G � ���������� �� �� ��������

function RNC_LAC2g ($region) {
	$sql = "  SELECT";
    $sql.= "  bsc.bsc_number as bscnum";
    $sql.= " ,bts.lac_2g as lac2g";
    $sql.= " ,COUNT(*) as BS_count";
    $sql.= " FROM bts";
	$sql.= " LEFT JOIN bsc";
    $sql.= " ON bsc.Id = bts.bsc_id";
	$sql.= " LEFT JOIN settlements";
    $sql.= " ON settlements.Id = bts.settlement_id";
	$sql.= " LEFT JOIN areas";
    $sql.= " ON areas.Id = settlements.area_id";
	$sql.= " LEFT JOIN regions";
    $sql.= " ON regions.Id = areas.region_id";
    $sql.= " WHERE bts.die_bs is NULL";
    $sql.= " AND (bts.G like 1 OR bts.D like 1)";
    $sql.= " AND regions.region like '".$region."'";
	$sql.= " AND bts.bts_number not IN ('2004','2007','2003','2000','2005a','2007g','2005','2002','2001','7000','7001','7002','7003','7004','2006g','2006n')";
    $sql.= " GROUP BY lac2g";
    $sql.= " ORDER BY lac2g";
	$query = mysql_query ($sql) or die (mysql_error());
		
	//�������� ������� �� SQL � ������
	 
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
  $tableLAC2g[] = array(
     $row['bscnum']
    ,$row['lac2g']
    ,$row['BS_count']
    
  ); 
}

return ($tableLAC2g);
	
}
echo "<div id='block_LAC2G' class='disabled'>";

////////////////��������� �������///////////////


$arrai_2g = RNC_LAC2g ('���������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////��������� �������///////////////


$arrai_2g = RNC_LAC2g ('���������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////���������� �������///////////////


$arrai_2g = RNC_LAC2g ('����������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////����������� �������///////////////


$arrai_2g = RNC_LAC2g ('�����������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>����������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////���������� �������///////////////


$arrai_2g = RNC_LAC2g ('����������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////������� �������///////////////


$arrai_2g = RNC_LAC2g ('�������');
echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>������� ���. (LAC 2G)</b></tr>";
echo "<tr><td><b>BSC</b></td><td><b>LAC</b></td><td><b>BSs</b></td></tr>";
for ($i=0;$i<count($arrai_2g);$i++) {
	echo "<tr>";
	for ($j=0;$j<3;$j++) {
		echo "<td>".$arrai_2g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

echo "</div>";

///////////////////////////////////////������ ���������� RNC, LAC � ���������� �� �� ��������

function RNC_LAC3g ($region,$tech) {
	$sql = "  SELECT";
    $sql.= "  rnc.rnc_number as rncnum";
    $sql.= " ,bts.lac_3g as lac3g";
	$sql.= " ,COUNT(*) as NB_count";
    $sql.= " FROM bts";
	$sql.= " LEFT JOIN rnc";
    $sql.= " ON rnc.Id = bts.rnc_id";
	$sql.= " LEFT JOIN settlements";
    $sql.= " ON settlements.Id = bts.settlement_id";
	$sql.= " LEFT JOIN areas";
    $sql.= " ON areas.Id = settlements.area_id";
	$sql.= " LEFT JOIN regions";
    $sql.= " ON regions.Id = areas.region_id";
    $sql.= " WHERE bts.die_bs is NULL";
    $sql.= " AND bts.".$tech." like 1";
    $sql.= " AND regions.region like '".$region."'";
	$sql.= " AND bts.bts_number not IN ('2004','2007','2003','2000','2005a','2007g','2005','2002','2001','7000','7001','7002','7003','7004','2006g','2006n')";
    $sql.= " GROUP BY lac3g";
    $sql.= " ORDER BY bts.lac_3g, bts.rnc_id";
	$query = mysql_query ($sql) or die (mysql_error());
	
		//�������� ������� �� SQL � ������
	 
for ($i=0; $i<mysql_num_rows($query); $i++) {
  $row = mysql_fetch_array($query);
		$tableLAC3g[] = array(
			$row['rncnum']
			,$row['lac3g']
			,$row['NB_count']
    
			); 
		
}


return ($tableLAC3g);
	
}

echo "<div id='block_LAC3G' class='disabled'>";

////////////////��������� �������///////////////


$arrai_U = RNC_LAC3g ('���������','U');
$arrai_U9 = RNC_LAC3g ('���������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				}  
	echo "</tr>";
}

echo "</table></div>";



////////////////��������� �������///////////////

$arrai_U = RNC_LAC3g ('���������','U');
$arrai_U9 = RNC_LAC3g ('���������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				}  
	echo "</tr>";
}

echo "</table></div>";

////////////////���������� �������///////////////

$arrai_U = RNC_LAC3g ('����������','U');
$arrai_U9 = RNC_LAC3g ('����������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				} 
				
	echo "</tr>";
}

echo "</table></div>";

////////////////����������� �������///////////////

$arrai_U = RNC_LAC3g ('�����������','U');
$arrai_U9 = RNC_LAC3g ('�����������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>����������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				} 
				
	echo "</tr>";
}

echo "</table></div>";

////////////////���������� �������///////////////

$arrai_U = RNC_LAC3g ('����������','U');
$arrai_U9 = RNC_LAC3g ('����������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				} 
				
	echo "</tr>";
}

echo "</table></div>";

////////////////������� �������///////////////

$arrai_U = RNC_LAC3g ('�������','U');
$arrai_U9 = RNC_LAC3g ('�������','U9');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>������� ���. (LAC 3G)</b></tr>";
echo "<tr><td><b>RNC</b></td><td><b>LAC</b></td><td><b>NB</b></td><td><b>NB9</b></td></tr>";
for ($i=0;$i<count($arrai_U9);$i++) {
	echo "<tr>";
				If ($arrai_U9[$i][1] == $arrai_U[$i][1]) {
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseif (!empty ($arrai_U9[$i][1]) & empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U9[$i][0]."</td><td><b>".$arrai_U9[$i][1]."</b></td><td></td><td>".$arrai_U9[$i][2]."</td>";
				}
				elseIf (empty ($arrai_U9[$i][1]) & !empty ($arrai_U[$i][1]) ){
				echo "<td>".$arrai_U[$i][0]."</td><td><b>".$arrai_U[$i][1]."</b></td><td>".$arrai_U[$i][2]."</td><td></td>";
				} 
				
	echo "</tr>";
}

echo "</table></div>";


echo "</div>";



///////////////////////////////////////������ ���������� LAC, TAC 4g � ���������� �� �� ��������

function RNC_LAC4g ($region) {
	$sql = "  SELECT";
	$sql.= "  bts.tac_LTE as tacLTE";
    $sql.= " ,COUNT(*) as eNB_count";
    $sql.= " FROM bts";
	$sql.= " LEFT JOIN settlements";
    $sql.= " ON settlements.Id = bts.settlement_id";
	$sql.= " LEFT JOIN areas";
    $sql.= " ON areas.Id = settlements.area_id";
	$sql.= " LEFT JOIN regions";
    $sql.= " ON regions.Id = areas.region_id";
    $sql.= " WHERE bts.die_bs is NULL";
    $sql.= " AND (bts.L18 like 1 OR bts.L26 like 1 OR bts.L8 like 1)";
    $sql.= " AND regions.region like '".$region."'";
    $sql.= " GROUP BY bts.tac_LTE";
	$sql.= " ORDER BY bts.tac_LTE";
    $query = mysql_query ($sql) or die (mysql_error());
	
	//�������� ������� �� SQL � ������
	 
for ($i=0; $i< mysql_num_rows($query); $i++) {
	$row = mysql_fetch_assoc($query);
	$tableLAC4g[] = array(
	   $row['tacLTE']
      ,$row['eNB_count']
      
    ); 
}

return ($tableLAC4g);	

}

echo "<div id='block_LAC4G' class='disabled'>";

////////////////��������� �������///////////////

$arrai_4g = RNC_LAC4g ('���������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>tac LTE</b></td><td><b>eNBs</b></td></tr>";

for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////��������� �������///////////////

$arrai_4g = RNC_LAC4g ('���������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>��������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>tac LTE</b></td><td><b>eNBs</b></td></tr>";
for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////���������� �������///////////////

$arrai_4g = RNC_LAC4g ('����������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>tac LTE</b></td><td><b>eNBs</b></td></tr>";
for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////����������� �������///////////////

$arrai_4g = RNC_LAC4g ('�����������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>����������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>tac LTE</b></td><td><b>eNBs</b></td></tr>";
for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////���������� �������///////////////

$arrai_4g = RNC_LAC4g ('����������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>���������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>TAC LTE</b></td><td><b>eNBs</b></td></tr>";
for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

////////////////������� �������///////////////

$arrai_4g = RNC_LAC4g ('�������');

echo "<div id='tableLAC'>";
echo "<table>";
echo "<tr><b>������� ���. (TAC 4G)</b></tr>";
echo "<tr><td><b>TAC LTE</b></td><td><b>eNBs</b></td></tr>";
for ($i=0;$i<count($arrai_4g);$i++) {
	echo "<tr>";
	for ($j=0;$j<2;$j++) {
		echo "<td>".$arrai_4g[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table></div>";

echo "</div>";





/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� /////////////////////////

function PlaceBS ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $n = $arr[$type];
	 
	return $n;
	
		
};

///////////////////////////////////////////////////////////////�� �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR = array (
	 '�����' => PlaceBS('���������','�����')
	,'������ >50000' => PlaceBS('���������','>=50000')
	,'������ <50000' => PlaceBS('���������','<50000')
	,'����' => PlaceBS('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBS' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (��������)</b></tr>";
foreach ($arrBR as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT = array (
	 '�������' => PlaceBS('���������','�������')
	,'������ >50000' => PlaceBS('���������','>=50000')
	,'������ <50000' => PlaceBS('���������','<50000')
	,'����' => PlaceBS('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (��������)</b></tr>";
foreach ($arrVT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM = array (
	 '������' => PlaceBS('����������','������')
	,'������ >50000' => PlaceBS('����������','>=50000')
	,'������ <50000' => PlaceBS('����������','<50000')
	,'����' => PlaceBS('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (��������)</b></tr>";
foreach ($arrGM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR = array (
	 '������' => PlaceBS('�����������','������')
	,'������ >50000' => PlaceBS('�����������','>=50000')
	,'������ <50000' => PlaceBS('�����������','<50000')
	,'����' => PlaceBS('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ������� (��������)</b></tr>";
foreach ($arrGR as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG = array (
	 '�������' => PlaceBS('����������','�������')
	,'������ >50000' => PlaceBS('����������','>=50000')
	,'������ <50000' => PlaceBS('����������','<50000')
	,'����' => PlaceBS('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (��������)</b></tr>";
foreach ($arrMG as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK = array (
	 '�����' => PlaceBS('�������','�����')
	,'������ >50000' => PlaceBS('�������','>=50000')
	,'������ <50000' => PlaceBS('�������','<50000')
	,'����' => PlaceBS('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ������� (��������)</b></tr>";
foreach ($arrMSK as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic = array (
	 '��������� ������' => PlaceBS('%','�����') + PlaceBS('%','�����') + PlaceBS('%','�������') + PlaceBS('%','������') + PlaceBS('%','������') + PlaceBS('%','�������')
	,'������ >50000' => PlaceBS('%','>=50000')
	,'������ <50000' => PlaceBS('%','<50000')
	,'����' => PlaceBS('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (��������)</b></tr>";
foreach ($arrRepublic as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� /////////////////////////

function PlaceBSU2100 ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.U like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $n = $arr[$type];
	 
	return $n;
	
		
};

///////////////////////////////////////////////////////////////�� U2100 �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBRU2100 = array (
	 '�����' => PlaceBSU2100('���������','�����')
	,'������ >50000' => PlaceBSU2100('���������','>=50000')
	,'������ <50000' => PlaceBSU2100('���������','<50000')
	,'����' => PlaceBSU2100('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSU2100' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (NB U2100)</b></tr>";
foreach ($arrBRU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVTU2100 = array (
	 '�������' => PlaceBSU2100('���������','�������')
	,'������ >50000' => PlaceBSU2100('���������','>=50000')
	,'������ <50000' => PlaceBSU2100('���������','<50000')
	,'����' => PlaceBSU2100('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (NB U2100)</b></tr>";
foreach ($arrVTU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGMU2100 = array (
	 '������' => PlaceBSU2100('����������','������')
	,'������ >50000' => PlaceBSU2100('����������','>=50000')
	,'������ <50000' => PlaceBSU2100('����������','<50000')
	,'����' => PlaceBSU2100('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (NB U2100)</b></tr>";
foreach ($arrGMU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGRU2100 = array (
	 '������' => PlaceBSU2100('�����������','������')
	,'������ >50000' => PlaceBSU2100('�����������','>=50000')
	,'������ <50000' => PlaceBSU2100('�����������','<50000')
	,'����' => PlaceBSU2100('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ������� (NB U2100)</b></tr>";
foreach ($arrGRU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMGU2100 = array (
	 '�������' => PlaceBSU2100('����������','�������')
	,'������ >50000' => PlaceBSU2100('����������','>=50000')
	,'������ <50000' => PlaceBSU2100('����������','<50000')
	,'����' => PlaceBSU2100('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (NB U2100)</b></tr>";
foreach ($arrMGU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSKU2100 = array (
	 '�����' => PlaceBSU2100('�������','�����')
	,'������ >50000' => PlaceBSU2100('�������','>=50000')
	,'������ <50000' => PlaceBSU2100('�������','<50000')
	,'����' => PlaceBSU2100('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ������� (NB U2100)</b></tr>";
foreach ($arrMSKU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublicU2100 = array (
	 '��������� ������' => PlaceBSU2100('%','�����') + PlaceBSU2100('%','�����') + PlaceBSU2100('%','�������') + PlaceBSU2100('%','������') + PlaceBSU2100('%','������') + PlaceBSU2100('%','�������')
	,'������ >50000' => PlaceBSU2100('%','>=50000')
	,'������ <50000' => PlaceBSU2100('%','<50000')
	,'����' => PlaceBSU2100('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (NB U2100)</b></tr>";
foreach ($arrRepublicU2100 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";


/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� /////////////////////////


function PlaceBSU900 ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.U9 like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $n = $arr[$type];
	 
	return $n;
	
		
};


///////////////////////////////////////////////////////////////�� U900 �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBRU900 = array (
	 '�����' => PlaceBSU900('���������','�����')
	,'������ >50000' => PlaceBSU900('���������','>=50000')
	,'������ <50000' => PlaceBSU900('���������','<50000')
	,'����' => PlaceBSU900('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSU900' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (NB U900)</b></tr>";
foreach ($arrBRU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVTU900 = array (
	 '�������' => PlaceBSU900('���������','�������')
	,'������ >50000' => PlaceBSU900('���������','>=50000')
	,'������ <50000' => PlaceBSU900('���������','<50000')
	,'����' => PlaceBSU900('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (NB U900)</b></tr>";
foreach ($arrVTU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGMU900 = array (
	 '������' => PlaceBSU900('����������','������')
	,'������ >50000' => PlaceBSU900('����������','>=50000')
	,'������ <50000' => PlaceBSU900('����������','<50000')
	,'����' => PlaceBSU900('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (NB U900)</b></tr>";
foreach ($arrGMU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGRU900 = array (
	 '������' => PlaceBSU900('�����������','������')
	,'������ >50000' => PlaceBSU900('�����������','>=50000')
	,'������ <50000' => PlaceBSU900('�����������','<50000')
	,'����' => PlaceBSU900('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ������� (NB U900)</b></tr>";
foreach ($arrGRU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMGU900 = array (
	 '�������' => PlaceBSU900('����������','�������')
	,'������ >50000' => PlaceBSU900('����������','>=50000')
	,'������ <50000' => PlaceBSU900('����������','<50000')
	,'����' => PlaceBSU900('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (NB U900)</b></tr>";
foreach ($arrMGU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSKU900 = array (
	 '�����' => PlaceBSU900('�������','�����')
	,'������ >50000' => PlaceBSU900('�������','>=50000')
	,'������ <50000' => PlaceBSU900('�������','<50000')
	,'����' => PlaceBSU900('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ������� (NB U900)</b></tr>";
foreach ($arrMSKU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublicU900 = array (
	 '��������� ������' => PlaceBSU900('%','�����') + PlaceBSU900('%','�����') + PlaceBSU900('%','�������') + PlaceBSU900('%','������') + PlaceBSU900('%','������') + PlaceBSU900('%','�������')
	,'������ >50000' => PlaceBSU900('%','>=50000')
	,'������ <50000' => PlaceBSU900('%','<50000')
	,'����' => PlaceBSU900('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (NB U900)</b></tr>";
foreach ($arrRepublicU900 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";


/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� GSM /////////////////////////

function PlaceBSGSM ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.G like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� GSM �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_GSM = array (
	 '�����' => PlaceBSGSM('���������','�����')
	,'������ >50000' => PlaceBSGSM('���������','>=50000')
	,'������ <50000' => PlaceBSGSM('���������','<50000')
	,'����' => PlaceBSGSM('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSGSM' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (�� GSM)</b></tr>";
foreach ($arrBR_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_GSM = array (
	 '�������' => PlaceBSGSM('���������','�������')
	,'������ >50000' => PlaceBSGSM('���������','>=50000')
	,'������ <50000' => PlaceBSGSM('���������','<50000')
	,'����' => PlaceBSGSM('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (�� GSM)</b></tr>";
foreach ($arrVT_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_GSM = array (
	 '������' => PlaceBSGSM('����������','������')
	,'������ >50000' => PlaceBSGSM('����������','>=50000')
	,'������ <50000' => PlaceBSGSM('����������','<50000')
	,'����' => PlaceBSGSM('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (�� GSM)</b></tr>";
foreach ($arrGM_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_GSM = array (
	 '������' => PlaceBSGSM('�����������','������')
	,'������ >50000' => PlaceBSGSM('�����������','>=50000')
	,'������ <50000' => PlaceBSGSM('�����������','<50000')
	,'����' => PlaceBSGSM('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ������� (�� GSM)</b></tr>";
foreach ($arrGR_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_GSM = array (
	 '�������' => PlaceBSGSM('����������','�������')
	,'������ >50000' => PlaceBSGSM('����������','>=50000')
	,'������ <50000' => PlaceBSGSM('����������','<50000')
	,'����' => PlaceBSGSM('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (�� GSM)</b></tr>";
foreach ($arrMG_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_GSM = array (
	 '�����' => PlaceBSGSM('�������','�����')
	,'������ >50000' => PlaceBSGSM('�������','>=50000')
	,'������ <50000' => PlaceBSGSM('�������','<50000')
	,'����' => PlaceBSGSM('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ������� (�� GSM)</b></tr>";
foreach ($arrMSK_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_GSM = array (
	 '��������� ������' => PlaceBSGSM('%','�����') + PlaceBSGSM('%','�����') + PlaceBSGSM('%','�������') + PlaceBSGSM('%','������') + PlaceBSGSM('%','������') + PlaceBSGSM('%','�������')
	,'������ >50000' => PlaceBSGSM('%','>=50000')
	,'������ <50000' => PlaceBSGSM('%','<50000')
	,'����' => PlaceBSGSM('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� GSM)</b></tr>";
foreach ($arrRepublic_GSM as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� DCS /////////////////////////

function PlaceBSDCS ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.D like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� GSM �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_DCS = array (
	 '�����' => PlaceBSDCS('���������','�����')
	,'������ >50000' => PlaceBSDCS('���������','>=50000')
	,'������ <50000' => PlaceBSDCS('���������','<50000')
	,'����' => PlaceBSDCS('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSDCS' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (�� DCS)</b></tr>";
foreach ($arrBR_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_DCS = array (
	 '�������' => PlaceBSDCS('���������','�������')
	,'������ >50000' => PlaceBSDCS('���������','>=50000')
	,'������ <50000' => PlaceBSDCS('���������','<50000')
	,'����' => PlaceBSDCS('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ������� (�� DCS)</b></tr>";
foreach ($arrVT_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_DCS = array (
	 '������' => PlaceBSDCS('����������','������')
	,'������ >50000' => PlaceBSDCS('����������','>=50000')
	,'������ <50000' => PlaceBSDCS('����������','<50000')
	,'����' => PlaceBSDCS('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (�� DCS)</b></tr>";
foreach ($arrGM_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_DCS = array (
	 '������' => PlaceBSDCS('�����������','������')
	,'������ >50000' => PlaceBSDCS('�����������','>=50000')
	,'������ <50000' => PlaceBSDCS('�����������','<50000')
	,'����' => PlaceBSDCS('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ������� (�� DCS)</b></tr>";
foreach ($arrGR_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_DCS = array (
	 '�������' => PlaceBSDCS('����������','�������')
	,'������ >50000' => PlaceBSDCS('����������','>=50000')
	,'������ <50000' => PlaceBSDCS('����������','<50000')
	,'����' => PlaceBSDCS('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ������� (�� DCS)</b></tr>";
foreach ($arrMG_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_DCS = array (
	 '�����' => PlaceBSDCS('�������','�����')
	,'������ >50000' => PlaceBSDCS('�������','>=50000')
	,'������ <50000' => PlaceBSDCS('�������','<50000')
	,'����' => PlaceBSDCS('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ������� (�� DCS)</b></tr>";
foreach ($arrMSK_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_DCS = array (
	 '��������� ������' => PlaceBSDCS('%','�����') + PlaceBSDCS('%','�����') + PlaceBSDCS('%','�������') + PlaceBSDCS('%','������') + PlaceBSDCS('%','������') + PlaceBSDCS('%','�������')
	,'������ >50000' => PlaceBSDCS('%','>=50000')
	,'������ <50000' => PlaceBSDCS('%','<50000')
	,'����' => PlaceBSDCS('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� DCS)</b></tr>";
foreach ($arrRepublic_DCS as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� LTE800 /////////////////////////

function PlaceBSL800 ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.L8 like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� LTE1800 �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_LTE800 = array (
	 '�����' => PlaceBSL800('���������','�����')
	,'������ >50000' => PlaceBSL800('���������','>=50000')
	,'������ <50000' => PlaceBSL800('���������','<50000')
	,'����' => PlaceBSL800('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSL800' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE 800)</b></tr>";
foreach ($arrBR_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_LTE800 = array (
	 '�������' => PlaceBSL800('���������','�������')
	,'������ >50000' => PlaceBSL800('���������','>=50000')
	,'������ <50000' => PlaceBSL800('���������','<50000')
	,'����' => PlaceBSL800('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE 800)</b></tr>";
foreach ($arrVT_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_LTE800 = array (
	 '������' => PlaceBSL800('����������','������')
	,'������ >50000' => PlaceBSL800('����������','>=50000')
	,'������ <50000' => PlaceBSL800('����������','<50000')
	,'����' => PlaceBSL800('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE 800)</b></tr>";
foreach ($arrGM_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_LTE800 = array (
	 '������' => PlaceBSL800('�����������','������')
	,'������ >50000' => PlaceBSL800('�����������','>=50000')
	,'������ <50000' => PlaceBSL800('�����������','<50000')
	,'����' => PlaceBSL800('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (�� LTE 800)</b></tr>";
foreach ($arrGR_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_LTE800 = array (
	 '�������' => PlaceBSL800('����������','�������')
	,'������ >50000' => PlaceBSL800('����������','>=50000')
	,'������ <50000' => PlaceBSL800('����������','<50000')
	,'����' => PlaceBSL800('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE 800)</b></tr>";
foreach ($arrMG_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_LTE800 = array (
	 '�����' => PlaceBSL800('�������','�����')
	,'������ >50000' => PlaceBSL800('�������','>=50000')
	,'������ <50000' => PlaceBSL800('�������','<50000')
	,'����' => PlaceBSL800('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (�� LTE 800)</b></tr>";
foreach ($arrMSK_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_LTE800 = array (
	 '��������� ������' => PlaceBSL800('%','�����') + PlaceBSL800('%','�����') + PlaceBSL800('%','�������') + PlaceBSL800('%','������') + PlaceBSL800('%','������') + PlaceBSL800('%','�������')
	,'������ >50000' => PlaceBSL800('%','>=50000')
	,'������ <50000' => PlaceBSL800('%','<50000')
	,'����' => PlaceBSL800('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� LTE 800)</b></tr>";
foreach ($arrRepublic_LTE800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� LTE1800 /////////////////////////

function PlaceBSL1800 ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.L18 like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� LTE1800 �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_LTE1800 = array (
	 '�����' => PlaceBSL1800('���������','�����')
	,'������ >50000' => PlaceBSL1800('���������','>=50000')
	,'������ <50000' => PlaceBSL1800('���������','<50000')
	,'����' => PlaceBSL1800('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSL1800' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE1800)</b></tr>";
foreach ($arrBR_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_LTE1800 = array (
	 '�������' => PlaceBSL1800('���������','�������')
	,'������ >50000' => PlaceBSL1800('���������','>=50000')
	,'������ <50000' => PlaceBSL1800('���������','<50000')
	,'����' => PlaceBSL1800('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE1800)</b></tr>";
foreach ($arrVT_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_LTE1800 = array (
	 '������' => PlaceBSL1800('����������','������')
	,'������ >50000' => PlaceBSL1800('����������','>=50000')
	,'������ <50000' => PlaceBSL1800('����������','<50000')
	,'����' => PlaceBSL1800('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE1800)</b></tr>";
foreach ($arrGM_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_LTE1800 = array (
	 '������' => PlaceBSL1800('�����������','������')
	,'������ >50000' => PlaceBSL1800('�����������','>=50000')
	,'������ <50000' => PlaceBSL1800('�����������','<50000')
	,'����' => PlaceBSL1800('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (�� LTE1800)</b></tr>";
foreach ($arrGR_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_LTE1800 = array (
	 '�������' => PlaceBSL1800('����������','�������')
	,'������ >50000' => PlaceBSL1800('����������','>=50000')
	,'������ <50000' => PlaceBSL1800('����������','<50000')
	,'����' => PlaceBSL1800('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE1800)</b></tr>";
foreach ($arrMG_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_LTE1800 = array (
	 '�����' => PlaceBSL1800('�������','�����')
	,'������ >50000' => PlaceBSL1800('�������','>=50000')
	,'������ <50000' => PlaceBSL1800('�������','<50000')
	,'����' => PlaceBSL1800('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (�� LTE1800)</b></tr>";
foreach ($arrMSK_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_LTE1800 = array (
	 '��������� ������' => PlaceBSL1800('%','�����') + PlaceBSL1800('%','�����') + PlaceBSL1800('%','�������') + PlaceBSL1800('%','������') + PlaceBSL1800('%','������') + PlaceBSL1800('%','�������')
	,'������ >50000' => PlaceBSL1800('%','>=50000')
	,'������ <50000' => PlaceBSL1800('%','<50000')
	,'����' => PlaceBSL1800('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� LTE1800)</b></tr>";
foreach ($arrRepublic_LTE1800 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� LTE2600 /////////////////////////

function PlaceBSL2600 ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.L26 like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� LTE1800 �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_LTE2600 = array (
	 '�����' => PlaceBSL2600('���������','�����')
	,'������ >50000' => PlaceBSL2600('���������','>=50000')
	,'������ <50000' => PlaceBSL2600('���������','<50000')
	,'����' => PlaceBSL2600('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSL2600' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE2600)</b></tr>";
foreach ($arrBR_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_LTE2600 = array (
	 '�������' => PlaceBSL2600('���������','�������')
	,'������ >50000' => PlaceBSL2600('���������','>=50000')
	,'������ <50000' => PlaceBSL2600('���������','<50000')
	,'����' => PlaceBSL2600('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� LTE2600)</b></tr>";
foreach ($arrVT_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_LTE2600 = array (
	 '������' => PlaceBSL2600('����������','������')
	,'������ >50000' => PlaceBSL2600('����������','>=50000')
	,'������ <50000' => PlaceBSL2600('����������','<50000')
	,'����' => PlaceBSL2600('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE2600)</b></tr>";
foreach ($arrGM_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_LTE2600 = array (
	 '������' => PlaceBSL2600('�����������','������')
	,'������ >50000' => PlaceBSL2600('�����������','>=50000')
	,'������ <50000' => PlaceBSL2600('�����������','<50000')
	,'����' => PlaceBSL2600('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (�� LTE2600)</b></tr>";
foreach ($arrGR_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_LTE2600 = array (
	 '�������' => PlaceBSL2600('����������','�������')
	,'������ >50000' => PlaceBSL2600('����������','>=50000')
	,'������ <50000' => PlaceBSL2600('����������','<50000')
	,'����' => PlaceBSL2600('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� LTE2600)</b></tr>";
foreach ($arrMG_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_LTE2600 = array (
	 '�����' => PlaceBSL2600('�������','�����')
	,'������ >50000' => PlaceBSL2600('�������','>=50000')
	,'������ <50000' => PlaceBSL2600('�������','<50000')
	,'����' => PlaceBSL2600('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (�� LTE2600)</b></tr>";
foreach ($arrMSK_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_LTE2600 = array (
	 '��������� ������' => PlaceBSL2600('%','�����') + PlaceBSL2600('%','�����') + PlaceBSL2600('%','�������') + PlaceBSL2600('%','������') + PlaceBSL2600('%','������') + PlaceBSL2600('%','�������')
	,'������ >50000' => PlaceBSL2600('%','>=50000')
	,'������ <50000' => PlaceBSL2600('%','<50000')
	,'����' => PlaceBSL2600('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� LTE2600)</b></tr>";
foreach ($arrRepublic_LTE2600 as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� IoT /////////////////////////

function PlaceBSIoT ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.IoT like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $m = $arr[$type];
	 
	return $m;
	
		
};

///////////////////////////////////////////////////////////////�� IoT �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_IoT = array (
	 '�����' => PlaceBSIoT('���������','�����')
	,'������ >50000' => PlaceBSIoT('���������','>=50000')
	,'������ <50000' => PlaceBSIoT('���������','<50000')
	,'����' => PlaceBSIoT('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBSIoT' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� IoT)</b></tr>";
foreach ($arrBR_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_IoT = array (
	 '�������' => PlaceBSIoT('���������','�������')
	,'������ >50000' => PlaceBSIoT('���������','>=50000')
	,'������ <50000' => PlaceBSIoT('���������','<50000')
	,'����' => PlaceBSIoT('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� IoT)</b></tr>";
foreach ($arrVT_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_IoT = array (
	 '������' => PlaceBSIoT('����������','������')
	,'������ >50000' => PlaceBSIoT('����������','>=50000')
	,'������ <50000' => PlaceBSIoT('����������','<50000')
	,'����' => PlaceBSIoT('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� IoT)</b></tr>";
foreach ($arrGM_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_IoT = array (
	 '������' => PlaceBSIoT('�����������','������')
	,'������ >50000' => PlaceBSIoT('�����������','>=50000')
	,'������ <50000' => PlaceBSIoT('�����������','<50000')
	,'����' => PlaceBSIoT('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (�� IoT)</b></tr>";
foreach ($arrGR_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_IoT = array (
	 '�������' => PlaceBSIoT('����������','�������')
	,'������ >50000' => PlaceBSIoT('����������','>=50000')
	,'������ <50000' => PlaceBSIoT('����������','<50000')
	,'����' => PlaceBSIoT('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� IoT)</b></tr>";
foreach ($arrMG_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_IoT = array (
	 '�����' => PlaceBSIoT('�������','�����')
	,'������ >50000' => PlaceBSIoT('�������','>=50000')
	,'������ <50000' => PlaceBSIoT('�������','<50000')
	,'����' => PlaceBSIoT('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (�� IoT)</b></tr>";
foreach ($arrMSK_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_IoT = array (
	 '��������� ������' => PlaceBSIoT('%','�����') + PlaceBSIoT('%','�����') + PlaceBSIoT('%','�������') + PlaceBSIoT('%','������') + PlaceBSIoT('%','������') + PlaceBSIoT('%','�������')
	,'������ >50000' => PlaceBSIoT('%','>=50000')
	,'������ <50000' => PlaceBSIoT('%','<50000')
	,'����' => PlaceBSIoT('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� IoT)</b></tr>";
foreach ($arrRepublic_IoT as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";

/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� �� 5G /////////////////////////

function PlaceBS_5G ($region, $type) {
	
	$sql = "   SELECT";
    $sql.= " count(bts.nas_punkt) as number";
    $sql.= " FROM bts";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON bts.settlement_id = settlements.id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON settlements.area_id = areas.id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON areas.region_id = regions.id";
    $sql.= " WHERE regions.region like '".$region."'";
    $sql.= " AND bts.nas_punkt like '".$type."'";
	$sql.= " AND bts.5G like 1";
    $sql.= " AND bts.die_bs is NULL";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $type => $row['number'] 
    );
	
    $fiveG = $arr[$type];
	 
	return $fiveG;
	
		
};

///////////////////////////////////////////////////////////////�� 5G �� ����������� ������ ���������� /////////////////////////////////////////////////



//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrBR_5g = array (
	 '�����' => PlaceBS_5G('���������','�����')
	,'������ >50000' => PlaceBS_5G('���������','>=50000')
	,'������ <50000' => PlaceBS_5G('���������','<50000')
	,'����' => PlaceBS_5G('���������','����')
	);

//����� ������� �� �������� �������

echo "<div id='block_PlaceBS_5G' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� 5G)</b></tr>";
foreach ($arrBR_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������� �������)

$arrVT_5g = array (
	 '�������' => PlaceBS_5G('���������','�������')
	,'������ >50000' => PlaceBS_5G('���������','>=50000')
	,'������ <50000' => PlaceBS_5G('���������','<50000')
	,'����' => PlaceBS_5G('���������','����')
	);

//����� ������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (�� 5G)</b></tr>";
foreach ($arrVT_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrGM_5g = array (
	 '������' => PlaceBS_5G('����������','������')
	,'������ >50000' => PlaceBS_5G('����������','>=50000')
	,'������ <50000' => PlaceBS_5G('����������','<50000')
	,'����' => PlaceBS_5G('����������','����')
	);

//����� ������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� 5G)</b></tr>";
foreach ($arrGM_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (����������� �������)

$arrGR_5g = array (
	 '������' => PlaceBS_5G('�����������','������')
	,'������ >50000' => PlaceBS_5G('�����������','>=50000')
	,'������ <50000' => PlaceBS_5G('�����������','<50000')
	,'����' => PlaceBS_5G('�����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (�� 5G)</b></tr>";
foreach ($arrGR_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (���������� �������)

$arrMG_5g = array (
	 '�������' => PlaceBS_5G('����������','�������')
	,'������ >50000' => PlaceBS_5G('����������','>=50000')
	,'������ <50000' => PlaceBS_5G('����������','<50000')
	,'����' => PlaceBS_5G('����������','����')
	);

//����� ������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (�� 5G)</b></tr>";
foreach ($arrMG_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";  
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (������� �������)

$arrMSK_5g = array (
	 '�����' => PlaceBS_5G('�������','�����')
	,'������ >50000' => PlaceBS_5G('�������','>=50000')
	,'������ <50000' => PlaceBS_5G('�������','<50000')
	,'����' => PlaceBS_5G('�������','����')
	);

//����� ������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (�� 5G)</b></tr>";
foreach ($arrMSK_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
}
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>"; 
echo "</table></div>";
unset ($sum);

//������� �� ����� ���������� �� �� ����������� ������ (��������)

$arrRepublic_5g = array (
	 '��������� ������' => PlaceBS_5G('%','�����') + PlaceBS_5G('%','�����') + PlaceBS_5G('%','�������') + PlaceBS_5G('%','������') + PlaceBS_5G('%','������') + PlaceBS_5G('%','�������')
	,'������ >50000' => PlaceBS_5G('%','>=50000')
	,'������ <50000' => PlaceBS_5G('%','<50000')
	,'����' => PlaceBS_5G('%','����')
	);

//����� ������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (�� 5G)</b></tr>";
foreach ($arrRepublic_5g as $key => $value) {
    echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";
	$sum += $value;
} 
echo "<tr><td>�����</td><td><b>".$sum."</b></td></tr>";
echo "</table></div>";
unset ($sum);

echo "</div>";


/////////////////////////////////////////////////////////////////////////////����� �� ����������  ������� ��������/////////////////////////

function Place_Repiter ($region) {
	
	$sql = "   SELECT";
    $sql.= " COUNT(regions.region) as number";
    $sql.= " FROM repeaters";
    $sql.= " LEFT JOIN settlements";
    $sql.= " ON settlements.Id = repeaters.settlement_id";
    $sql.= " LEFT JOIN areas";
    $sql.= " ON areas.Id = settlements.area_id";
    $sql.= " LEFT JOIN regions";
    $sql.= " ON regions.Id = areas.region_id";
    $sql.= " WHERE regions.region like '".$region."'";
	$sql.= " AND repeaters.R = 1";
    $query = mysql_query ($sql) or die (mysql_error());
    $row = mysql_fetch_assoc ($query);
	
	$arr = array (
       $number => $row['number'] 
    );
	
    $Rep_count = $arr[$number];
	 
	return $Rep_count;
		
};

//����� ������� ���������� ��������� �� �������� �������

echo "<div id='block_Place_Repiter' class='disabled'>";

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('���������')."</b></td></tr>";
$sum_rep += Place_Repiter('���������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ��������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('���������')."</b></td></tr>";
$sum_rep += Place_Repiter('���������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('����������')."</b></td></tr>";
$sum_rep += Place_Repiter('����������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ����������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>����������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('�����������')."</b></td></tr>";
$sum_rep += Place_Repiter('�����������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ���������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>���������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('����������')."</b></td></tr>";
$sum_rep += Place_Repiter('����������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ������� �������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>������� ���. (��������)</b></tr>";
echo "<tr><td><b>".Place_Repiter('�������')."</b></td></tr>";
$sum_rep += Place_Repiter('�������');
echo "</table></div>";

//����� ������� ���������� ��������� �� ���� ������

echo "<div id='tableNB'>";
echo "<table>";
echo "<tr><b>��� �������� (��������)</b></tr>";
echo "<tr><td><b>".$sum_rep."</b></td></tr>";
echo "</table></div>";




echo "</div>";
 
mysql_close($link);
?>



</body>
</html>
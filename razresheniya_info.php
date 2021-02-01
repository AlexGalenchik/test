<?php 
	// входные параметры
   $id=$_GET['id'];  
	
	
	// основной запрос из 4ех таблиц для всех технологий
   $sql = "SELECT * FROM razresheniya_2g WHERE bts_id='$id' order by sector"; 
   $query = mysql_query($sql) or die(mysql_error());
   $row1 = mysql_num_rows($query);
   
   $sql = "SELECT * FROM razresheniya_3g WHERE bts_id='$id' order by sector"; 
   $query2 = mysql_query($sql) or die(mysql_error());
   $row2 = mysql_num_rows($query2);
   
   $sql = "SELECT * FROM razresheniya_U900 WHERE bts_id='$id' order by sector"; 
   $query3 = mysql_query($sql) or die(mysql_error());
   $row3 = mysql_num_rows($query3);
   
   $sql = "SELECT * FROM razresheniya_IoT WHERE bts_id='$id' order by sector"; 
   $query4 = mysql_query($sql) or die(mysql_error());
   $row4 = mysql_num_rows($query4);
	
		
	$table1 = array ( //Сбор данных по Разрешениям 2G
   array ('БС','Сектор','Cell_ID','N','E','Высота','азимут','мощность','антенна','канал','Категория','Разрешение','Дата получения','Дата окончания')
);
    
  for ($i=0; $i<mysql_num_rows($query); $i++)	  {
	 // echo "<br>2G-".$i;
	  $row1 = mysql_fetch_array($query);
  $table1[] = array(
       $row1['BS']
    ,$row1['sector'] 
    ,$row1['CellID']
	,$row1['ng']."&#176;".$row1['nm']."&#8217;".$row1['ns']."&#8221;"
    ,$row1['eg']."&#176;".$row1['em']."&#8217;".$row1['es']."&#8221;"
    ,$row1['hight']
    ,$row1['azimuth']
	//,$row1['angle']
	//,$row1['ku']
	,$row1['power']
	//,$row1['lost']
	//,$row1['eiim']
	,$row1['ant']
	,$row1['canal']
	//,$row1['can_after']
	,$row1['category']
	,$row1['permissionUseNumber']
	,$row1['permissionUseDateGiven']
	,$row1['permissionUseDateTrueTo']
	); 
}



$table2 = array ( //Сбор данных по Разрешениям 3G
   array ('БС','Сектор','Cell_ID','N','E','Высота','азимут','мощность','антенна','канал','Категория','Разрешение','Дата получения','Дата окончания')
);

for ($i=0; $i<mysql_num_rows($query2); $i++) {
	//echo "<br>3G-".$i;
  $row2 = mysql_fetch_array($query2);
  $table2[] = array(
     $row2['BS']
    ,$row2['sector']
    ,$row2['CellID']
	,$row2['ng']."&#176;".$row2['nm']."&#8217;".$row2['ns']."&#8221;"
    ,$row2['eg']."&#176;".$row2['em']."&#8217;".$row2['es']."&#8221;"
    ,$row2['hight']
    ,$row2['azimuth']
	//,$row2['angle']
	//,$row2['ku']
	,$row2['power']
	//,$row2['lost']
	//,$row2['eiim']
	,$row2['ant']
	,$row2['canal']
	//,$row2['can_after']
	,$row2['category']
	,$row2['permissionUseNumber']
	,$row2['permissionUseDateGiven']
	,$row2['permissionUseDateTrueTo']
  ); 
}


$table3 = array ( //Сбор данных по Разрешениям U900
   array ('БС','Сектор','Cell_ID','N','E','Высота','азимут','мощность','антенна','канал','Категория','Разрешение','Дата получения','Дата окончания')
); 
for ($i=0; $i<mysql_num_rows($query3); $i++) {
	//echo "<br>U900-".$i;
  $row3 = mysql_fetch_array($query3);
  $table3[] = array(
     $row3['BS']
    ,$row3['sector']
    ,$row3['CellID']
	,$row3['ng']."&#176;".$row3['nm']."&#8217;".$row3['ns']."&#8221;"
    ,$row3['eg']."&#176;".$row3['em']."&#8217;".$row3['es']."&#8221;"
    ,$row3['hight']
    ,$row3['azimuth']
	//,$row3['angle']
	//,$row3['ku']
	,$row3['power']
	//,$row3['lost']
	//,$row3['eiim']
	,$row3['ant']
	,$row3['canal']
	//,$row3['can_after']
	,$row3['category']
	,$row3['permissionUseNumber']
	,$row3['permissionUseDateGiven']
	,$row3['permissionUseDateTrueTo']
  ); 
}

$table4 = array ( //Сбор данных по Разрешениям IoT
   array ('БС','Сектор','Cell_ID','N','E','Высота','азимут','мощность','антенна','канал','Категория','Разрешение','Дата получения','Дата окончания')
); 
for ($i=0; $i<mysql_num_rows($query4); $i++) {
	//echo "<br>IoT-".$i;
  $row4 = mysql_fetch_array($query4);
  $table4[] = array(
     $row4['BS']
    ,$row4['sector']
    ,$row4['CellID']
	,$row4['ng']."&#176;".$row4['nm']."&#8217;".$row4['ns']."&#8221;"
    ,$row4['eg']."&#176;".$row4['em']."&#8217;".$row4['es']."&#8221;"
    ,$row4['hight']
    ,$row4['azimuth']
	//,$row4['angle']
	//,$row4['ku']
	,$row4['power']
	//,$row4['lost']
	//,$row4['eiim']
	,$row4['ant']
	,$row4['canal']
	//,$row4['can_after']
	,$row4['category']
	,$row4['permissionUseNumber']
	,$row4['permissionUseDateGiven']
	,$row4['permissionUseDateTrueTo']
  ); 
}


// вывод элементов интерфейса
echo "<div>";
echo "<div id=\"razresheniya\"><b><span style=\"color: blue;\">Разрешения на 1 Ноября 2020г.</span></b></div>";
echo "<p>";
InfoBlock('',$info=array(),"<span style=\"color: red;\">Разрешения 2G</span>",$table1);
echo "<p>";
InfoBlock('',$info=array(),"<span style=\"color: red;\">Разрешения 3G U2100</span>",$table2);
echo "<p>";
InfoBlock('',$info=array(),"<span style=\"color: red;\">Разрешения U900</span>",$table3);
echo "<p>";
InfoBlock('',$info=array(),"<span style=\"color: red;\">Разрешения IoT</span>",$table4);
echo "<p>";
echo "  </div>";

?>
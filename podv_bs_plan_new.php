<?php 

//$pbs_number = $_SESSION['pbs_number'];


$pbs_number = $_GET['id'];

echo "<h4>ПЛАНИРУЕМОЕ МЕСТО УСТАНОВКИ ПБС ". $pbs_number."</h4>";

echo "<div>";
echo "<a href = 'index.php?f=50&id=$pbs_number' id='button_edd'><img src='pics/back_pic.png' width = '24px' align=\"center\">План ПБС ".$pbs_number."</a><br/>";
echo "<h1></h1>";
echo "</div>";

?>

 <form action="index.php?f=61" method="post">
  <table>
  
  <tr>
      <td>Номер ПБС <C</td>
      <td><input type="text" name="pbs_number"  style="margin-bottom:5px" value="<?php echo "$pbs_number" ?>" ></td>
    </tr>
	<tr>
	
	   <td>Статус:</td>
    	<td>	<select name="status"  style="margin-bottom:5px; width:166px; height: 24px">
				<option value="Планируется" selected>Планируется</option>
				<option value="Работает">Работает</option>
				<option value="Ожидание">Ожидание</option>
				<option value="Постоянно">Постоянное место</option>
				<option value="Ремонт">Ремонт</option>
		    </select>
	  </td>    
	  
	  
    </tr>
    <tr>
      <td>Мероприятие:</td>
      <td><input type="text" name="event"  style="margin-bottom:5px"></td>
    </tr>
	<tr>
      <td>Место проведения:</td>
      <td><input type="text" name="place"  style="margin-bottom:5px"></td>
    </tr>
	<tr>
      <td>Дата начала:</td>
      <td><input type="date" id="dataTodai" name="start" min="2018-01-01" max="2025-12-30"  style="margin-bottom:5px; width:161px"></td>
	  <script>document.getElementById('dataTodai').valueAsDate = new Date();</script>
    </tr>
	<tr>
      <td>Дата окончания:</td>
      <td><input type="date" id="dataToday" name="finish" min="2019-10-01" max="2025-12-31"  style="margin-bottom:5px; width:161px"></td>
	  <script>document.getElementById('dataToday').valueAsDate = new Date();</script>
    </tr>
	<tr>
      <td>Месяц:</td>
    
    	<td>	<select name="month"   style="margin-bottom:5px; width:166px; height: 24px">
				<option value="январь">январь</option>
				<option value="февраль">февраль</option>
				<option value="март">март</option>
				<option value="апрель">апрель</option>
				<option value="май">май</option>
				<option value="июнь" selected>июнь</option>
				<option value="июль">июль</option>
				<option value="август">август</option>
				<option value="сентябрь">сентябрь</option>
				<option value="октябрь">октябрь</option>
				<option value="ноябрь">ноябрь</option>
				<option value="декабрь">декабрь</option>		
		    </select>
	  </td>    
	 	  
	  
    </tr>
	<tr>
      <td>Примечания:</td>
      <td><input type="textarea" name="notes" style="margin-bottom:5px"></td>
    </tr>
	<tr>
      <td><input type="submit" value="Внести" style="margin-bottom:5px"></td>
    </tr>
  </table>
</form>



 
  
 
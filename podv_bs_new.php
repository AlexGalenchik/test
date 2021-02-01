<?php 

include_once('config.php');
include_once('functions.php');
//session_start();
//$link=$_SESSION['sections'][count($_SESSION['sections'])-3]['link'];


echo "<h4>ДОБАВЛЕНИЕ НОВОЙ ПБС </h4>";

echo "<div>";
echo "<a href = 'index.php?f=46' id='button_edd'>
<img src='pics/back_pic.png' width = '24px' align=\"center\"> &emsp;&emsp; Back</a><br/>";
echo "<h1></h1>";
echo "</div>";

?>



<form action="index.php?f=58" method="post"  id='podv_bs_new'>
  <table>
    <tr><td>Номер ПБС:</td>
        <td><input type="text" id="text_field_medium" name="pbs_number"  style="margin-bottom:5px" required></td>
	</tr>
	
    <tr>
        <td>Статус:</td>
    	<td>	<select name="status" id="text_field_medium" style="margin-bottom:5px; height:22px">
				<option value="Планируется" selected>Планируется</option>
				<option value="Работает">Работает</option>
				<option value="Ожидание">Ожидание</option>
				<option value="Постоянно">Постоянное место</option>
				<option value="Ремонт">Ремонт</option>
				<option value="Ремонт">Резерв</option>
		    </select>
	  </td>    
	</tr>
	
	<tr>
      <td>Тип ПБС:</td>
		<td> <select name="type_pbs" id="text_field_medium"  style="margin-bottom:5px; height:22px">
				<option value="ПБС_14м" selected>14м</option>
				<option value="ПБС_18м">18м</option>
				<option value="ПБС_30м">30м</option>
								
		    </select>
		</td>
    </tr>
	
	  <tr>
		  <td>Место размещения:</td>
		  <td><input type="text" name="place" id="text_field_medium"  style="margin-bottom:5px"></td>
      </tr>
	<tr>
      <td>Мероприятие:</td>
      <td><input type="text" name="event" id="text_field_medium"  style="margin-bottom:5px"></td>
    </tr>
	
	<tr>
      <td>Дата начала:</td>
      <td><input type="date" id="dataToday" name="start_date" min="2018-01-01" max="2025-12-30" style="width:190px; margin-bottom:5px"></td>
	  <script>document.getElementById('dataToday').valueAsDate = new Date();</script>
    </tr>
	<tr>
      <td>Дата окончания:</td>
      <td><input type="date" name="finish_date" id="davaToday" min="2019-10-01" max="2025-12-31"  style="width:190px; margin-bottom:5px"></td>
	  <script>document.getElementById('davaToday').valueAsDate = new Date();</script>
    </tr>
	
	
	<tr>
      <td>Примечание:</td>
      <td><input type="area" name="notes" id="text_field_medium"  style="margin-bottom:5px"></td>
    </tr>
    <tr>
      <td><input type="submit" id='button_edd' value="Внести"  style="margin-bottom:5px; padding-bottom:40px"></td>
    </tr>
	
  </table>
</form>
 

 
 
 

  
 

 


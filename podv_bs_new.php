<?php 

include_once('config.php');
include_once('functions.php');
//session_start();
//$link=$_SESSION['sections'][count($_SESSION['sections'])-3]['link'];


echo "<h4>���������� ����� ��� </h4>";

echo "<div>";
echo "<a href = 'index.php?f=46' id='button_edd'>
<img src='pics/back_pic.png' width = '24px' align=\"center\"> &emsp;&emsp; Back</a><br/>";
echo "<h1></h1>";
echo "</div>";

?>



<form action="index.php?f=58" method="post"  id='podv_bs_new'>
  <table>
    <tr><td>����� ���:</td>
        <td><input type="text" id="text_field_medium" name="pbs_number"  style="margin-bottom:5px" required></td>
	</tr>
	
    <tr>
        <td>������:</td>
    	<td>	<select name="status" id="text_field_medium" style="margin-bottom:5px; height:22px">
				<option value="�����������" selected>�����������</option>
				<option value="��������">��������</option>
				<option value="��������">��������</option>
				<option value="���������">���������� �����</option>
				<option value="������">������</option>
				<option value="������">������</option>
		    </select>
	  </td>    
	</tr>
	
	<tr>
      <td>��� ���:</td>
		<td> <select name="type_pbs" id="text_field_medium"  style="margin-bottom:5px; height:22px">
				<option value="���_14�" selected>14�</option>
				<option value="���_18�">18�</option>
				<option value="���_30�">30�</option>
								
		    </select>
		</td>
    </tr>
	
	  <tr>
		  <td>����� ����������:</td>
		  <td><input type="text" name="place" id="text_field_medium"  style="margin-bottom:5px"></td>
      </tr>
	<tr>
      <td>�����������:</td>
      <td><input type="text" name="event" id="text_field_medium"  style="margin-bottom:5px"></td>
    </tr>
	
	<tr>
      <td>���� ������:</td>
      <td><input type="date" id="dataToday" name="start_date" min="2018-01-01" max="2025-12-30" style="width:190px; margin-bottom:5px"></td>
	  <script>document.getElementById('dataToday').valueAsDate = new Date();</script>
    </tr>
	<tr>
      <td>���� ���������:</td>
      <td><input type="date" name="finish_date" id="davaToday" min="2019-10-01" max="2025-12-31"  style="width:190px; margin-bottom:5px"></td>
	  <script>document.getElementById('davaToday').valueAsDate = new Date();</script>
    </tr>
	
	
	<tr>
      <td>����������:</td>
      <td><input type="area" name="notes" id="text_field_medium"  style="margin-bottom:5px"></td>
    </tr>
    <tr>
      <td><input type="submit" id='button_edd' value="������"  style="margin-bottom:5px; padding-bottom:40px"></td>
    </tr>
	
  </table>
</form>
 

 
 
 

  
 

 


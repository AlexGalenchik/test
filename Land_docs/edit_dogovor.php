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
	$rights = '��������';
} else {
	$rights = '������';
}

$id = $_GET['Id'];  //������� � ������ �������� $id �������� (���� ����� ��� ����� ���� ��������� �� ����������� �������� �������������
$_SESSION['id_dog'] = $id;

//������� ���� ������� ��� ���������� Id
$sql = "SELECT * FROM land_docs_minsk WHERE Id = ".$_GET['Id']; // ��� ���������� Id ��
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

If (mysql_num_rows($query)) {

    // ����� �������, ����� ���� ��� ����
    if(!empty($row['oblast'])) {
        $regon_out = $row['oblast']. " ���., ";
    }
    else {
        $regon_out="";
    }
    if(!empty($row['raion'])) {
        $area_out = $row['raion']. " �-�, ";
    }
    else {
        $area_out="";
    }
	if(!empty($row['nas_punkt'])) {
        $nas_punkt = $row['nas_punkt'];
    }
    else {
        $nas_punkt="";
    }
	If(!empty($row['adress'])) {
        $adress = ", ".$row['adress'];
    }
    else {
        $adress="";
    }
  $adress_dogovor = $region_out.$area_out.$nas_punkt.$adress;         
}

//����� ����� 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>�������� <?php echo $row['bts']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../rent/Style.css">
    <script defer src="../rent/script.js"></script>
</head>
<body>

<form action="redirect.php?Id=<?=$_GET['Id'];  ?>" method="POST"> <!-- ������ ����� -->
    <!-- ����� header-->
    <div id="cap" class="container mt-1" >
        <div class="row align-self-center" >
            <div class="col-12" >
                <div  class="container" >
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="row align-items-center ">
                                <div class="col-md-3 arend">
                                    <a href="dogovor.php?Id=<?php echo $_GET['Id'];  ?>"><button type="button" class="btn btn-danger">�����</button></a>
                                </div>
                                <div class="col-md-3">
                                    <input class="btn btn-danger" name="NewButton" type="submit"  value="���������">
                                </div>
								<div class="col-md-3">
									<input type="button" class="btn btn-danger" value="DELETE" 
									onclick="if(confirm('�� �������, ��� ������ ������� ������� Id = <?php echo $_GET['Id']; ?>?'))location.href='delete_dogovor.php?id=<?php echo $_GET['Id']; ?>' "/>
								</div>
							</div>
                        </div>

                        <div class="col-md-3" >
                            <div class="row align-items-center">
                                <!-- ����� ����������� -->
                                <?php
                                // ���� ����� �����������

                                if ($user_id > 0) {
                                    echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                        ". $_SESSION['user_surname'] ." 
																		". $_SESSION['user_name'] ."
																		". $_SESSION['middle_name'] ."
																		[".$_SESSION['reg_user']."]												 
																		[". $rights."]																		 
                                                                    </div>
                                                               <div class=\"w-100\"></div>
                                                                    <div class='col'>
                                                                         <a href='logout.php'><button >�����</button></a>
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
                        </div>		<!-- ����� ����� ����������� -->

                    </div>
                </div>
            </div>
        </div>
    </div>	 <!--����� header-->
	
<?php If ($user_id > 0) { ?>	


<!--������ �� ��������-->
 <div  class="container mt-3">
     <h5>������ �� ���������� �������</h5>
     <div class="row my-1 mx-1">
        <div class="col-md-7 ">
			<div class="row block">
				<div class="col"><h5>��������� NE</h5> </div>
				<div class="w-100"></div>
                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>������ ��</h5> -->
					 <div class="box">
                         <input type="text" id="bts" name="bts" style="width: 60%;" value="<?php echo $row['bts']; ?>" >
                         <label for="bts">����� NE</label>
                     </div>
					 <div class="box">
                         <input type="text" id="type_opori" name="type_opori" style="width: 60%;" value="<?php echo $row['type_opori']; ?>" >
                         <label for="type_opori">��� �����</label>
                     </div>
					 <div class="box">
						 <?php $sql = " SELECT surname, name, middle_name 
										FROM users, land_docs_minsk
										WHERE users.Id = land_docs_minsk.ispolnitel_id
										AND land_docs_minsk.Id = ".$id;
							   $query = mysql_query($sql) or die(mysql_error());
							   $row_user = mysql_fetch_array($query);

						?>						 
                         <input type="text" id="ispolnitel" name="ispolnitel" style="width: 60%;" value="<?php echo $row_user['surname']." ".substr($row_user['name'],0,1).".".substr($row_user['middle_name'],0,1)."."; ?>">
                         <label for="ispolnitel">�����������</label>
                     </div>			 
                 </div>
				 

                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>�����</h5> -->
                     <div class="box">
						 <label for="oblast">�������</label> <!-- ���������� ������ ���� �������� � �� Id -->
						 		<select id="oblast" name="oblast" style="width: 75%;">
									<option value="<?php  echo $row['oblast']; ?>"><?php echo $row['oblast']; ?></option>
									<option value=""></option>
									<option value="����">����</option>
									<option value="���������">���������</option>
									<option value="���������">���������</option>
									<option value="�����������">�����������</option>
									<option value="����������">����������</option>
									<option value="�����������">�����������</option>
								</select>
						
					 </div>
                     <div class="box">
						 <label for="raion">�����</label> <!-- ���������� ������ ������� � �� Id -->
                         <select id="raion" name="raion" style="width: 75%;">
						 <option value="<?php  echo $row['raion']; ?>"><?php echo $row['raion']; ?></option>
						 <option value=""></option>
							<?php // �������� ���� �������
								$res = mysql_query('SELECT `Id`, `area` FROM `areas`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['area']; ?>"><?php echo $row3['area']; ?></option>
							<?php } ?>
						 </select>
					 </div>

                     <div class="box">
                         <input type="text" id="nas_punkt" name="nas_punkt" style="width: 75%;" value="<?php echo $row['nas_punkt']; ?>"> <!-- ������� �� ���� -->
                         <label for="nas_punkt">���.�.</label>
                     </div>
					  <div class="box">
                         <input type="text" id="adress" name="adress" style="width: 75%;" value="<?php echo $row['adress']; ?>"> <!-- ������� �� ���� -->
                         <label for="adress">�����</label>
                     </div>
                 </div>
                    <div class="w-100">
						<div class="col mt-2">
							<div class="box area">
								<textarea id="full_adres" rows="2" name="full_adres" placeholder="<?php echo $adress_dogovor; ?>" disabled></textarea>
								<label for="full_adres">������ �����</label>
							</div>
							
						</div>
					</div>
			</div>
		</div>
         <div class="col-md-5 ">
             <!-- <h5>��������� ���������</h5> -->  
            <div class="row block">
                 <div class="col ">
                     <h5>��������� �������</h5>
<!--                     ����� div-->
                    <div class="box">
                        <input type="text" id="svidetelstvo_land" name="svidetelstvo_land" value="<?php if( !empty( $row['svidetelstvo_land'] ) ) { echo $row['svidetelstvo_land'];}  ?>">
                        <label for="svidetelstvo_land">����-�� ���. ���. ��</label>
                    </div>
					<div class="box">
                        <input type="date" id="svidetelstvo_land_date" name="svidetelstvo_land_date" value="<?php if( !empty( $row['svidetelstvo_land_date'] ) ) { echo $row['svidetelstvo_land_date'];}  ?>">
                        <label for="svidetelstvo_land_date">���� ����-��</label>
                    </div>
                    <div class="box">
                        <input type="text" id="kadastroviy_number" name="kadastroviy_number" value="<?php if( !empty( $row['kadastroviy_number'] ) ) { echo $row['kadastroviy_number'];}  ?>">
                         <label for="kadastroviy_number">����������� ����� ��</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.0001" id="land_area" name="land_area" value="<?php if( !empty( $row['land_area'] ) ) { echo $row['land_area'];}  ?>">
                        <label for="land_area">������� ������� (��)</label>
                    </div>
                    <div class="box">
					<select id="type_rent" name="type_rent">
						<option value="<?php if( !empty( $row['type_rent'] ) ) { echo $row['type_rent'];}  ?>"><?php if( !empty( $row['type_rent'] ) ) { echo $row['type_rent'];}  ?></option>
						<option value=""></option>
						<?php // �������� ���� ��������
								$res = mysql_query('SELECT DISTINCT `type_rent` FROM `land_docs_minsk`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['type_rent']; ?>"><?php echo $row3['type_rent']; ?></option>
							<?php } ?>

					</select>					
                        <!--<input type="text" id="type_rent" name="type_rent" value="<?php if( !empty( $row['type_rent'] ) ) { echo $row['type_rent'];}  ?>"> -->
                        <label for="type_rent">������ �����</label>
                    </div>
                <!-- <div class="box">
                        <input type="text" id="resheniye_videlenie" name="resheniye_videlenie" value="<?php //if( !empty( $row['resheniye_videlenie'] ) ) { echo $row['resheniye_videlenie'];}  ?>">
                        <label for="resheniye_videlenie">������� � �������. ��</label>
                    </div>
					 <div class="box">
                        <input type="date" id="resheniye_videlenie_date" name="resheniye_videlenie_date" value="<?php //if( !empty( $row['resheniye_videlenie_date'] ) ) { echo $row['resheniye_videlenie_date'];}  ?>">
                        <label for="resheniye_videlenie_date">���� ���. � ���-�� ��</label>
                    </div>
				-->	
				 </div>
             </div>
         </div> <!-- ��������� ���������-->
     </div>
 </div><!--������ �� ��������-->

<div class="container mt-2"><!--            ������ �� ��������-->
    <h5>������ �� �������� � ��������</h5>
    <div class="row mx-1 my-1">

			<div class="col-md-6" style="margin-left: 10px;">
                <div class="row block"><!--      �������� �����-->
                    <div class="col">
                        <h5>�������� �����</h5>
                         <div class="box">
                            <input type="number" step="0.01" id="rent_BYN" name="rent_BYN" value="<?php if( !empty( $row['rent_BYN'] ) ) { echo $row['rent_BYN'];}  ?>">
                            <label for="rent_BYN">������� �� (BYN)</label>
                        </div>
						<div class="box">
                            <input type="number" step="0.001" id="rent_USD" name="rent_USD" value="<?php if( !empty( $row['rent_USD'] ) ) { echo $row['rent_USD'];}  ?>">
                            <label for="rent_USD">������� �� (USD)</label>
                        </div>

                    </div>
                </div>
				<div class="row block">
					<div class="col">
					   <h5>�������������� ��������</h5>

				<!--	<div class="box">
							<input type="text" id="resheniye_videlenie" name="resheniye_videlenie" value="<?php //if( !empty( $row['resheniye_videlenie'] ) ) { echo $row['resheniye_videlenie'];}  ?>">
							<label for="resheniye_videlenie">����� ������� � ���-�� ��</label>
						</div>
						<div class="box">
							<input type="date" id="resheniye_videlenie_date" name="resheniye_videlenie_date" value="<?php //if( !empty( $row['resheniye_videlenie_date'] ) ) { echo $row['resheniye_videlenie_date'];}  ?>">
							<label for="resheniye_videlenie_date">���� ������� � ���-�� ��</label>
						</div>
						<div class="box">
							<input type="text" id="razreshenie_number" name="razreshenie_number" value="<?php //if( !empty( $row['razreshenie_number'] ) ) { echo $row['razreshenie_number'];}  ?>">
							<label for="razreshenie_number">����� ������� � ����-��, ���</label>
						</div>
						<div class="box">
							<input type="date" id="razreshenie_number_date" name="razreshenie_number_date" value="<?php //if( !empty( $row['razreshenie_number_date'] ) ) { echo $row['razreshenie_number_date'];}  ?>">
							<label for="razreshenie_number_date">���� ������� � ����-��, ���</label>
						</div>
				-->
						<div class="box area">
								<textarea id="notes" rows="8" name="notes" ><?php echo $row['notes']; ?></textarea>
								<label for="notes">����������</label>
						</div>
					</div>	
				</div>
			</div><!--            ������ �� ��������-->

		<div class="col-md-6" style="margin-left: -10px;"><!--        ��������� �������-->
		
			<div class="row block">
				<div class="col">
					<h5>��������� ��������</h5>

					<div class="box">
						<input type="text" id="dogovor_number" name="dogovor_number" value="<?php if( !empty( $row['dogovor_number'] ) ) { echo $row['dogovor_number'];}  ?>">
						<label for="dogovor_number">����� �������� ������</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_date" name="dogovor_date" value="<?php if( !empty( $row['dogovor_date'] ) ) { echo $row['dogovor_date'];}  ?>">
						<label for="dogovor_date">���� ��������</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_start" name="dogovor_start" value="<?php if( !empty( $row['dogovor_start'] ) ) { echo $row['dogovor_start'];}  ?>">
						<label for="dogovor_start">���� ������ ��������</label>
					</div>
					<div class="box">
						<input type="date" id="dogovor_finish" name="dogovor_finish" value="<?php if( !empty( $row['dogovor_finish'] ) ) { echo $row['dogovor_finish'];}  ?>">
						<label for="dogovor_finish">���� ��������� ��������</label>
					</div>
				</div>
			</div>
			<div class="row block">
				<div class="col">
					<h5>��������� �� ��������</h5>

					<div class="box">
						<input type="text" id="inventarniy_building" name="inventarniy_building" value="<?php if( !empty( $row['inventarniy_building'] ) ) { echo $row['inventarniy_building'];}  ?>">
						<label for="inventarniy_building" title="(����� ������� � ��� ��������)">������. ����� ���. ���-�</label>
					</div>
					<div class="box">
						<input type="text" id="svidetelstvo_building" name="svidetelstvo_building" value="<?php if( !empty( $row['svidetelstvo_building'] ) ) { echo $row['svidetelstvo_building'];}  ?>">
						<label for="svidetelstvo_building">C���-�� � ��� ���. ���. ���-�</label>
					</div>
					<div class="box">
						<input type="date" id="svidetelstvo_building_date" name="svidetelstvo_building_date" value="<?php if( !empty( $row['svidetelstvo_building_date'] ) ) { echo $row['svidetelstvo_building_date'];}  ?>">
						<label for="svidetelstvo_building_date">���� C������������</label>
					</div>
				</div>
			</div>	
        </div><!--        ��������� �������-->
    </div>
</div>

    
    </div>


</form> <!-- ����� ����� -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



<?php  } ?>

</body>
</html>






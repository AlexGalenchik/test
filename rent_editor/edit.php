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
	$rights = '��������';
} else {
	$rights = '������';
}

$id = $_GET['Id'];  //������� � ������ �������� $id ��������
$_SESSION['id_dog'] = $id;

//������� ���� ������� ��� ���������� Id
$sql = "SELECT * FROM rent WHERE Id = ".$_GET['Id']; // ��� ���������� Id ��
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

If (mysql_num_rows($query)) {

    // ����� �������, ����� ���� ��� ����
    if(!empty($row['region'])) {
        $regon_out = $row['region'] . " ���., ";
    }
    else {
        $regon_out="";
    }
    if(!empty($row['area'])) {
        $area_out = $row['area'] . " �-�, ";
    }
    else {
        $area_out="";
    }
    $adress_dogovor =$regon_out . $area_out . $row['settlement'].", ".$row['adress'];
    }

//����� ����� 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>�������� <?php echo $row['type']." ".$row['number']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
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
                                    <a href="index.php?Id=<?php echo $_GET['Id'];  ?>"><button type="button" class="btn btn-danger">�����</button></a>
                                </div>
                                <div class="col-md-3">
                                    <input class="btn btn-danger" name="NewButton" type="submit"  value="���������">
                                </div>
                                <div class="col-md-3">
									<a href="history_form.php?id=<?php echo $_GET['Id']; ?>"><button type="button" class="btn btn-danger" ><b>HISTORY</b></button></a>
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
																		  ". $_SESSION['user_name']."
																		  ". $_SESSION['middle_name']."
												                         [". $_SESSION['reg_user']."]												 
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
     <h5>������ �� ��������</h5>
     <div class="row my-1 mx-1">
         <div class="col-md-7 ">
			<div class="row block">
				<div class="col"><h5>��������� NE</h5> </div>
				<div class="w-100"></div>
                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>������ ��</h5> -->

                     <div class="box">
                         <select style="width: 60%;"  class="type_arenda" name="type_arenda" >
                             <option value="<?php echo $row['type_arenda']; ?>"><?php echo $row['type_arenda']; ?></option>
                             <option value=""></option>
                             <option value="��� ��������">��� ��������</option>
                             <option value="��� �����">��� �����</option>
                             <option value="�����, �����. ���., ������">�����, �����. ���., ������</option>
							 <option value="����������� ���������">����������� ���������</option>
                         </select>
                         <label for="type_arenda">��� ������</label>
                     </div>

                     <div class="box">
                         <input type="text" id="numBS_MTS" name="numBS_MTS" style="width: 60%;" value="<?php echo $row['number']; ?>" >
                         <label for="numBS_MTS"  title="NE - ����� �������� �������� (��, FTTx, ����, ����)">����� NE<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

                     <div class="box">
                         <select style="width: 60%;"  class="selectDistributs" >
                             <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                             <option value=""></option>
                             <!--<option value="��">��</option>
							 <option value="�������">�������</option>
							 <option value="FTTx">FTTx</option>
							 <option value="��_FTTX">��_FTTX</option>
                             <option value="����">����</option>
							 <option value="���� � �����������">���� � �����������</option>
                             <option value="Wi-Fi">WI-Fi</option>
                             <option value="����������">����������</option>
							 <option value="unit">unit</option>
							 <option value="����">����</option>
							 <option value="��������� ��">��������� ��</option>-->
                         </select>
                         <label for="type" title="��� �������� (��, FTTx, ����, �������, ����������, ����)">��-�� ���<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>
					 
					 <script defer>


                let arr = {
                    "��� ��������" : ["",	"��" , "�������" , "FTTx" ,	"��_FTTx" , "����" , "���� � �����������" , "Wi-Fi", "����������", "unit"]

                    ,"��� �����" :  ["", "��" ,	"����" , "�����������" , "���./��������" ]

					,"�����, �����. ���., ������" : [ "", "�����. ���." , "����� �����" , "������. ���." , "�����" ,	"�����"]

                    ,"����������� ���������" : [ "" ]

                };

                // ������� ������ ��� ������ �������
                var x = document.querySelector('.selectDistributs');
                console.log(x);
                x.setAttribute("id", "mySelect");
                x.setAttribute("name", "type");
                // distr.appendChild(x);
                // ��������   option
                let z = document.createElement("option");
                // console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['type_arenda']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);


                // ������� onchange  ����������� �� ��������� ��������
                document.querySelector('.type_arenda').onchange = function () {
                    // �������� ������� � ���������� selectType_arenda
                    let option = document.querySelectorAll('.type_arenda option');
                    // console.log(option);
                    for (let i = 0; i < option.length; i++) {
                        if (option[i].selected) {
                            var selectType_arenda = option[i].value;
                            console.log(selectType_arenda);
                        }
                    }

                    function myFunction() {
                        // �������� �������
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
                             <option value="����">����</option>
                             <option value="�����c���">�����c���</option>
                             <option value="���������">���������</option>
                             <option value="����������">����������</option>
                             <option value="�����������">�����������</option>
                             <option value="�����������">�����������</option>
                         </select>
                          <label for="division" title="������ ���������������">�������-�<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

			  		 
                 </div>
				 
	            <div class="col-md-12 col-lg-6">
                     <!--  <h5>�����</h5> -->
                     <div class="box">
						 <label for="region">�������</label> <!-- ���������� ������ ���� �������� � �� Id -->
                         <select id="region" name="region" style="width: 75%;">
								<option value="<?php  echo $row['region']; ?>"><?php echo $row['region']; ?></option>
								<option value=""></option>
							<?php // �������� ���� ��������
								$res = mysql_query('SELECT `id`, `region` FROM `regions`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['region'];?>"><?php echo $row3['region'];?></option>
							<?php } ?>
						 </select>
					 </div>
                     <div class="box">
						 <label for="area">�����</label> <!-- ���������� ������ ������� � �� Id -->
                         <select id="area" name="area" style="width: 75%;">
						 <option value="<?php  echo $row['area']; ?>"><?php echo $row['area']; ?></option>
							<?php // �������� ���� �������
								$res = mysql_query('SELECT `Id`, `area` FROM `areas`');
								while($row3 = mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row3['area']; ?>"><?php echo $row3['area']; ?></option>
							<?php } ?>
						 </select>
					 </div>

                     <div class="box">
                         <input type="text" id="settlement" name="settlement" style="width: 75%;" value="<?php echo $row['settlement']; ?>"> <!-- ������� �� ���� -->
                         <label for="settlement">���.�.</label>
                     </div>
                     <div class="box">
                         <input type="text" id="adress" name="adress"  style="width: 75%;" value="<?php echo $row['adress']; ?>" > <!-- ������� �� ���� -->
                         <label for="adress">��./��-�</label> <!-- ����� -->
                     </div>



                 </div>

                    <div class="w-100"></div>
                     <div class="col mt-2">
                         <div class="box area">
                             <textarea id="adres_baza" rows="2" name="adres_baza" placeholder="<?php echo $adress_dogovor; ?>" disabled></textarea>
                             <label for="adres_baza">������ ����� &nbsp;</label>
                         </div>
                     </div>
             </div>
         </div>
         <div class="col-md-5 ">
             <!-- <h5>��������� ���������</h5> -->
             <div class="row block">
                 <div class="col ">
                     <h5>������ � ���������</h5>
<!--                     ����� div-->
                    <div class="box">
                           <input type="number" step="0.001"  id="room" name="room" value="<?php if( !empty( $row['room_area'] ) ) { echo $row['room_area'];}  ?>" >          
						 
                        <label for="room">��������� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="roof_walls" name="roof_walls" value="<?php if( !empty( $row['roof_area'] ) ) { echo $row['roof_area'];}    ?>" >
                         <label for="roof_walls">������,�����,����� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="asfalt_square" name="asfalt_square" value="<?php if( !empty( $row['asphalt_pad_area'] ) ) { echo $row['asphalt_pad_area'];}      ?>" >
                        <label for="asfalt_square">��������.�������� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="cabel" name="cabel" value="<?php if( !empty( $row['length_cable'] ) ) { echo $row['length_cable'];}   ?>" >
                        <label for="cabel">�������,������ (�)</label>
                    </div>
                    <div class="box">
                        <input type="number" step="0.001" id="canalization" name="canalization" value="<?php if( !empty( $row['length_canaliz'] ) ) { echo $row['length_canaliz'];}     ?>" >
                        <label for="canalization">��������� �����������<br/>(���������������)</label>
                    </div>
				 </div>
             </div>
         </div> <!-- ��������� ���������-->
     </div>
 </div><!--������ �� ��������-->

<div class="container mt-2"><!--            ������ �� ��������-->
    <h5>������ �� ��������</h5>
    <div class="row mx-1 my-1">

			<div class="col-md-6" style="margin-left: 10px;">
                <div class="row block"><!--      �������� �����-->
                    <div class="col">
                        <h5>�������� �����</h5>
                        <div class="box">

                            <!--                        ������� � �� ����� �������-->
                            <!--                        ������� ����� � ��� � ��� ���� ������� �� �������� USD*20/100-->

                            <input type="number" step="0.0001" id="summa" name="summa" value="<?php if( !empty( $row['summa'] ) ) { echo $row['summa'];}     ?>" >
                            <label for="summa">�����:</label>
                        </div>
                        <div class="box">
                            <label for="type_currency">��� ������</label>
                            <select id="type_currency" name="type_currency">
                                <option value="<?php echo $row['type_currency']; ?>"><?php  if( !empty( $row['type_currency'] ) ) { echo $row['type_currency'];}      ?></option>
                                <!--                                <option value=""></option>-->
                                <option value="BYN">BYN</option>
                                <option value="���">���</option>
                                <option value="��">��</option>
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="box">
                            <input type="number" step="0.0001" id="nds2" name="nds2" value="<?php if( !empty( $row['nds2'] ) ) { echo $row['nds2'];}     ?>" >
                            <label for="nds2">���</label>
                        </div>

                    </div>
                </div>
				<div class="row block">
					<div class="col">
					  <h5>���������</h5>

						<div class="box">
							<input type="text" id="arendodatel" name="arendodatel" value="<?php echo $row['arendodatel']; ?>" >
							<!-- <label for="arendodatel">������������</label> -->
							<label for="arendodatel"><?php If ($_SESSION['reg_user'] !== '���') {echo '������������';} else {echo '����������';} ?></label>
						</div>
						<div class="box">
							<input type="text" id="arendator" name="arendator" value="<?php echo $row['arendator']; ?>" >
							<label for="arendator">���������</label>
						</div>
						<div class="box">
							<input type="text" id="num_dogovor" name="num_dogovor" value="<?php echo $row['dogovor_number']; ?>" >
							<label for="num_dogovor">� ��������</label>
						</div>
						<div class="box">
							<select id="type_dogovor" name="type_dogovor" value="<?php echo $row['dogovor_type']; ?>" >
								<option value="<?php echo $row['dogovor_type']; ?>"><?php  if( !empty( $row['dogovor_type'] ) ) { echo $row['dogovor_type'];} ?></option>
								<option value=""></option>
								<option value="������">������</option>
								<option value="�������������">�������������</option>
								<option value="������������">������������</option>
								<option value="���������������">���������������</option>
								<option value="���������">���������</option>
								<option value="������">������</option>
								<option value="��������">��������</option>
							<select> 
							<label for="type_dogovor">��� ��������</label>
						</div>
						<div class="box">
							<input type="date" id="data_dogovor" name="data_dogovor" value="<?php echo $row['dogovor_date']; ?>" >
							<label for="data_dogovor">���� ��������</label>
						</div>
						<div class="box">
							<input type="date" id="start_dogovor" name="start_dogovor" value="<?php echo $row['start_date_dogovor']; ?>" >
							<label for="start_dogovor">��������� �</label>
						</div>
						<div class="box">
							<input type="date" id="finish_dogovor" name="finish_dogovor" value="<?php echo $row['finish_date_dogovor']; ?>" >
							<label for="finish_dogovor">��������� ��</label>
						</div>
						<div class="box">
							<input type="date" id="finish_strah" name="finish_strah" value="<?php echo $row['insurance_finish']; ?>" >
							<label for="finish_strah">����������� ��</label>
						</div>
						<div class="box">
							<select id="prolongaciya" name="prolongaciya" value="<?php echo $row['prolongaciya']; ?>" >
								<option value="<?php echo $row['prolongaciya']; ?>"><?php  if( !empty( $row['prolongaciya'] ) ) { echo $row['prolongaciya'];} ?></option>
								<option value=""></option>
								<option value="��">��</option>
								<option value="���">���</option>
							</select>
							<label for="prolongaciya">�����������</label>							
						</div>
					</div>	
				</div>
			</div><!--            ������ �� ��������-->

		<div class="col-md-6" style="margin-left: -10px;"><!--        ��������� �������-->
		
			<div class="row block">
				<div class="col">
					<h5>���������</h5>
			<!--		<div class="box">
						<input type="text" id="ako_exist" name="ako_exist" value="<?php echo $row['dogovor_AKO']; ?>" >
						<label for="ako_exist">������� ���</label>
					</div>
			-->		
					<div class="box">
						<select id="ako_exist" name="ako_exist">
							<option value=<?php echo $row['dogovor_AKO']; ?>><?php echo $row['dogovor_AKO']; ?></option>
							<option value=""></option>
							<option value="��">��</option>
							<option value="���">���</option>
						</select>
						<label for="ako_exist">������� ���</label>
					</div>
			<!--		<div class="box">
						<input type="text" id="ako_reason" name="ako_reason" value="<?php //echo $row['prichiny_AKO']; ?>" >
						<label for="ako_reason">������� ���������� ���</label>
					</div>
			-->
			<!--		<div class="box">
						<input type="text" id="pud" name="pud" value="<?php echo $row['PUD']; ?>" >
						<label for="pud">����������� ���</label>
					</div>
			-->
					<div class="box">
					<select id="pud" name="pud">
						<option value=<?php echo $row['PUD']; ?>><?php echo $row['PUD']; ?></option>
						<option value=""></option>
						<option value="��">��</option>
						<option value="���">���</option>
					</select>	
						<label for="pud">����������� ���</label>
					</div>
			<!--    <div class="box">
						<input type="text" id="form_own" name="form_own" value="<?php echo $row['own_form']; ?>" >
						<label for="form_own">����� �������������</label>
					</div>
			-->
			        <div class="box">
					<select id="form_own" name="form_own">
						<option value=<?php echo $row['own_form']; ?>><?php echo $row['own_form']; ?></option>
						<option value=""></option>
						<option value="���">���</option>
						<option value="��_���">��_���</option>
					</select>	
						<label for="form_own" title="����� 50% - ��� ���.">����� �������������<span style="color:red;font-size:12px;"> (?)</span></label>
					</div>
			<!--		<div class="box">
						<input type="text" id="method_AP" name="method_AP" value="<?php echo $row['method_form_AP']; ?>" >
						<label for="method_AP">����� ������������ ��</label>
					</div>
			-->		
					<div class="box">
					<select id="method_AP" name="method_AP">
						<option value=<?php echo $row['method_form_AP']; ?>><?php echo $row['method_form_AP']; ?></option>
						<option value=""></option>
						<option value="������">������</option>
						<option value="����_������">����_������</option>
						<option value="������+����_������">������+����_������</option>
					</select>	
						<label for="method_AP">����� ������������ ��</label>
					</div>
					<div class="box">
						<input type="text" id="main_person" name="main_person" rows="2"  placeholder="������ - ������� �.�." value="<?php echo $row['ispolnitel']; ?>" >
						<label for="main_person">������������� ����</label>
					</div>

                    <div class="box">
                        <input type="text" id="svidetelctvo_regist" name="svidetelctvo_regist" value="<?php echo $row['svidetelctvo_regist']; ?>">
                        <label for="svidetelctvo_regist">������-�� (���.����� �����)</label>
                    </div>


					<div class="box" >
						<textarea id="contact" rows="3" name="contact"  ><?php echo $row['contragent_data']; ?></textarea>
                            <label for="contact">��������</label>
					</div>
					<div class="box">
						<textarea id="post_adres" rows="2" name="post_adres"  ><?php echo $row['post_adres']; ?></textarea>
                            <label for="post_adres">��������<br/>�����</label>
					</div>
					<div class="box">
						<textarea id="notes" name="notes" rows="2"  ><?php echo $row['notes']; ?></textarea>
						<label for="notes">����������</label>
					</div>
                    <div class="box">
                        <textarea id="type_rent_propety" rows="2" name="type_rent_propety"><?=$row['type_rent_propety']; ?></textarea>
                        <label for="type_rent_propety">���<br>�����������<br>���������<br></label>
                    </div>
				</div>
			</div>

        </div><!--        ��������� �������-->
    </div>
</div>

    <div class="container mt-2"><!--            ������ �� ��������-->
        <h5>����� / ������ � ��������� � ������ ���������</h5>
        <div class="row mx-1 my-1">


            <div class="col-md-6" style="margin-left: 10px;">

                <div class="row block">
                    <div class="col">
                        <h5>��������� � ������ ���������</h5>

                        <div class="box">
                            <input type="text" id="type_opory" name="type_opory" value="<?php echo $row['type_opory']; ?>">
                            <label for="type_opory">��� �������� �����</label>
                        </div>
                        <div class="box">
                            <input type="text" id="rent_place_TSH" name="rent_place_TSH" value="<?php echo $row['rent_place_TSH']; ?>">
                            <label for="rent_place_TSH">������ ����� � ��</label>
                        </div>
                        <div class="box">
                            <input type="text" id="rent_area" name="rent_area" value="<?php echo $row['rent_area']; ?>">
                            <label for="rent_area">������� ������</label>
                        </div>

                    </div>
                </div>


            </div><!--            ������ �� ��������-->



            <div class="col-md-6" style="margin-left: -10px;"><!--        ��������� �������-->

                <div class="row block">
                    <div class="col">
                        <h5>����� / ������</h5>
                        <div class="box">
                            <label for="naznachenie">����������</label>
                            <input  type="text" id="naznachenie" name="naznachenie" value="<?php echo $row['naznachenie']; ?>" >
                        </div>
                        <div class="box">
                            <label for="admin_office">�����.</label>
                            <input type="number" step="0.001" id="admin_office" name="admin_office" value="<?php echo $row['admin_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="sell_office">�������</label>
                            <input type="number" step="0.001" id="sell_office" name="sell_office" value="<?php echo $row['sell_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="tech_office">���.</label>
                            <input type="number" step="0.001" id="tech_office" name="tech_office" value="<?php echo $row['tech_office']; ?>" >
                        </div>
                        <div class="box">
                            <label for="sklady">�����</label>
                            <input type="number" step="0.001" id="sklady" name="sklady" value="<?php echo $row['sklady']; ?>" >
                        </div>
                        <!--					<div class="box">-->
                        <!--						<label for="payment">������</label>-->
                        <!--						<input type="text" id="payment" name="payment" value="--><?php //echo $row['payment']; ?><!--" >-->
                        <!--					</div>-->
                        <!--					<div class="box">	-->
                        <!--						<label for="currency">������</label>-->
                        <!--						<input type="text" id="currency" name="currency" value="--><?php //echo $row['currency']; ?><!--" >-->
                        <!--					</div>-->
                    </div>
                </div>
            </div>

        </div><!--        ��������� �������-->
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






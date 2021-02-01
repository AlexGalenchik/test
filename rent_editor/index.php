<?php	
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//print_r($_SESSION['page']);
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

//����� ����� 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>�������</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
</head>
<body>

    <!-- ����� header-->
	<div id="cap" class="container mt-1" >
		<div class="row align-self-center" >
			<div class="col-12" >
					<div  class="container" >	
						<div class="row align-items-center justify-content-center">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3 arend offset-1">
                                        <a href="geo_finder.php?page=<?php echo($_SESSION['page']); ?>"><button type="button" class="btn btn-danger">�����</button></a>
                                    </div>
                                    <div class="col-md-3">
                                        <?php If($rights == '��������') { ?>
                                        <a href="edit.php?Id=<?=$_GET['Id']?>"><button type="button" class="btn btn-danger" >��������</button></a>
										<?php } ?>
                                    </div>

                                    <div class="col-md-2">
                                        <?php If($rights == '��������') { ?>
                                        <a href="clone_ID.php?Id=<?=$_GET['Id']?>" ><button type="button" class="btn btn-danger"><b>CLONE</b></button></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

						    <div class="col-md-3" >
                                <div class="row align-items-center">
                                    <!-- ����� ����������� -->
                                    <?php
                                    // ���� ����� �����������
                                    if ($user_id == 0) {
                                        include('/login_form.php');
                                        }
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
                                                                          <a href='logout.php'><button >�����</button></a>
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
						  </div>		<!-- ����� ����� ����������� -->

						</div>
					</div>
			</div>
		</div>
	</div>	 <!--����� header-->

<?php


    If (($user_id > 0) && isset($_GET['Id'])) {
            //  ����������� � ��
          $conn = connect();
        //����� ������ �� ������� � ���� �������
          $data = selectAll($conn);
        // ����� �������, ����� ���� ��� ����
            if(!empty($data[0]['region'])) {
                $region_out = $data[0]['region'] . " ���., ";
            }
            else {
                $region_out="";
            }
            if(!empty($data[0]['area'])) {
                $area_out = $data[0]['area'] . " �-�, ";
            }
            else {
                $area_out="";
            }
           $adress_dogovor = $region_out . $area_out . $data[0]['settlement']. " , ". $data[0]['adress'];
    }
	
	//echo $data[0]['arendodatel']."<br/>";
	//echo $data[0]['own_form']."<br/>";
	//echo $data[0]['method_form_AP']."<br/>";
?>

<div  class=" container mt-2">
<div class="row align-self-center">	
			<div class="col-12">	
					<div  class="container">
						<div class="row justify-content-end align-items-center">
						  <div class="col-md-6 offset-1" >
						  <?php If($rights == '��������') { ?>
							<form action="upload.php?Id=<?=$_GET['Id']?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="MAX_FILE_SIZE" value="15000000">
								<input type="file" name="uploadfile"> 
								<input type="submit" name="uploadDoc" class="btn btn-danger" value="���������" >
							</form> 
						  <?php } ?>
						  </div>
						  <div class="col-md-3" >
                               <a href="open_doc.php?Id=<?=$_GET['Id']?>" target="_blank"><button type="button"   class="btn btn-danger" >���������</button></a>
						 </div>
                            <div class="col-md-2">
                                <a href="history_form.php?id=<?=$_GET['Id']?>"><button type="button" class="btn btn-danger"><b>HISTORY</b></button></a>
                            </div>
						</div>
					</div>
			</div>		
		</div>	


</div>
    <form action="index.php" method="POST">

 <div  class="container mt-2"> <!--������ �� ��������-->
     <h5>������ �� ��������</h5>
     <div class="row my-1 mx-1">
         <div class="col-md-7 ">
			<div class="row block">
				<div class="col"><h5>��������� NE</h5> </div>
				<div class="w-100"></div>
                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>������ ��</h5> -->
					 <div class="box">
                         <input type="text" id="type_arenda" name="type_arenda" style="width: 60%;" value="<?php echo $data[0]['type_arenda']; ?>" disabled>
                         <label for="type_arenda">��� ������</label>
                     </div>

                     <div class="box">
                         <input type="text"  id="numBS_MTS" style="width: 60%;" name="numBS_MTS" value="<?php echo $data[0]['number']; ?>" disabled>
                         <label for="numBS_MTS"  title="NE - ����� �������� �������� (��, FTTx, ����, ����)">����� NE<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

                     <div class="box">
                         <input type="text" id="house" name="house" style="width: 60%;" value="<?php echo $data[0]['type']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="house" title="��� �������� (��, FTTx, ����, �������, ����������, ����)">��-�� ���<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>


                     <div class="box">
                         <input type="text" id="division"  name="division" style="width: 60%;" value="<?php echo $data[0]['division']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="division" title="������ ���������������">�������-�<span style="color:red;font-size:12px;"> (?)</span></label>
                     </div>

                 </div>

                 <div class="col-md-12 col-lg-6">
                     <!--  <h5>�����</h5> -->
                     <div class="box">
                         <input type="text" id="oblast" name="oblast" style="width: 75%;" value="<?php echo $data[0]['region']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="oblast">���.</label>
                     </div>
                     <div class="box">
                         <input type="text" id="region" name="region" style="width: 75%;" value="<?php echo $data[0]['area']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="region">�-�</label>
                     </div>
					 <div class="box">
                         <input type="text" id="NasPunkt" name="NasPunkt" style="width: 75%;" value="<?php echo $data[0]['settlement']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="NasPunkt">���.�.</label>
                     </div>
					 <div class="box">
                         <input type="text" id="street" name="street"  style="width: 75%;" value="<?php echo $data[0]['adress']; ?>" disabled> <!-- ������� �� ���� -->
                         <label for="street">��.</label> <!-- ����� -->
                     </div>
                 </div>

                    <div class="w-100">
                     <div class="col mt-2">
                         <div class="box area">
                             <textarea id="adres_baza" rows="2" name="adres_baza" placeholder="<?php echo $adress_dogovor; ?>" disabled></textarea> <!-- ������� �� ���� -->
                             <label for="adres_baza">������ ����� &nbsp;</label>
                         </div>
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
                        <input type="text" id="room" name="room" value="<?php echo $data[0]['room_area']; ?>" disabled>
                        <label for="room">��������� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="text" id="roof_walls" name="roof_walls" value="<?php echo $data[0]['roof_area']; ?>" disabled>
                         <label for="roof_walls">������,�����,����� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="text" id="asfalt_square" name="asfalt_square" value="<?php echo $data[0]['asphalt_pad_area']; ?>" disabled>
                        <label for="asfalt_square">��������.�������� (�2)</label>
                    </div>
                    <div class="box">
                        <input type="text" id="cabel" name="cabel" value="<?php echo $data[0]['length_cable']; ?>" disabled>
                        <label for="cabel">�������,������ (�)</label>
                    </div>
                    <div class="box">
                        <input type="text" id="canalization" name="canalization" value="<?php echo $data[0]['length_canaliz']; ?>" disabled>
                        <label for="canalization">��������� �����������<br/>(���������������)</label>
                    </div>
				 </div>
             </div>


         </div> <!-- ��������� ���������-->
     </div>
 </div><!--������ �� ��������-->

<div class="container mt-2">
    <h5>������ �� ��������</h5>
    <div class="row mx-1 my-1">
			<div class="col-md-6" style="margin-left: 10px;"><!--            ������ �� ��������-->
                <div class="row block">
                    <div class="col">
                        <h5>�������� �����</h5>
                        <div class="box">
                            <input type="text" id="summa" name="summa" value="<?php echo $data[0]['summa']; ?>" disabled>
                            <label for="summa">�����:</label>
                        </div>
                        <div class="box">
                            <label for="type_currency">��� ������</label>
                            <select id="type_currency" name="type_currency" disabled>
                                <option value="<?php echo $data[0]['type_currency']; ?>"><?php echo $data[0]['type_currency']; ?></option>
                                <option value="BYN">BYN</option>
                                <option value="���">���</option>
                                <option value="��">��</option>
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="box">
                            <input type="text" id="nds2" name="nds2" value="<?php echo $data[0]['nds2']; ?>" disabled>
                            <label for="nds2">���</label>
                        </div>

                    </div>
                </div>
                <div class="row block">
					<div class="col">
					  <h5>���������</h5>

						<div class="box">
							<input type="text" id="arendodatel" name="arendodatel" value="<?php echo $data[0]['arendodatel']; ?>" disabled>
							<label for="arendodatel"><?php If ($_SESSION['reg_user'] !== '���') {echo '������������';} else {echo '����������';} ?></label>
						</div>
						<div class="box">
							<input type="text" id="arendator" name="arendator" value="<?php echo $data[0]['arendator']; ?>" disabled>
							<label for="arendator">���������</label>
						</div>
						<div class="box">
							<input type="text" id="num_dogovor" name="num_dogovor" value="<?php echo $data[0]['dogovor_number']; ?>" disabled>
							<label for="num_dogovor">� ��������</label>
						</div>
						<div class="box">
							<input type="text" id="type_dogovor" name="type_dogovor" value="<?php echo $data[0]['dogovor_type']; ?>" disabled>
							<label for="type_dogovor">��� ��������</label>
						</div>
						<div class="box">
							<input type="date" id="data_dogovor" name="data_dogovor" value="<?php echo $data[0]['dogovor_date']; ?>" disabled>
							<label for="data_dogovor">���� ��������</label>
						</div>
						<div class="box">
							<input type="date" id="start_dogovor" name="start_dogovor" value="<?php echo $data[0]['start_date_dogovor']; ?>" disabled>
							<label for="start_dogovor">��������� �</label>
						</div>
						<div class="box">
							<input type="date" id="finish_dogovor" name="finish_dogovor" value="<?php echo $data[0]['finish_date_dogovor']; ?>" disabled>
							<label for="finish_dogovor">��������� ��</label>
						</div>
						<div class="box">
							<input type="date" id="finish_strah" name="finish_strah" value="<?php echo $data[0]['insurance_finish']; ?>" disabled>
							<label for="finish_strah">����������� ��</label>
						</div>
						<div class="box">
							<input type="text" id="prolongaciya" name="prolongaciya" value="<?php echo $data[0]['prolongaciya']; ?>" disabled>
							<label for="prolongaciya">�����������</label>
						</div>
					</div>	
				</div>

			</div><!--            ������ �� ��������-->

		<div class="col-md-6" style="margin-left: -10px;"><!--        ��������� �������-->
			<div class="row block">
				<div class="col">
					<h5>���������</h5>

					<div class="box">
						<input type="text" id="ako_exist" name="ako_exist" value="<?php echo $data[0]['dogovor_AKO']; ?>" disabled>
						<label for="ako_exist">������� ���</label>
					</div>
			<!--		<div class="box">
						<input type="text" id="ako_reason" name="ako_reason" value="<?php //echo $data[0]['prichiny_AKO']; ?>" disabled>
						<label for="ako_reason">������� �����-� ���</label>
					</div>
			-->		
					<div class="box">
						<input type="text" id="pud" name="pud" value="<?php echo $data[0]['PUD']; ?>" disabled>
						<label for="pud">����������� ���</label>
					</div>
					<div class="box">
						<input type="text" id="form_own" name="form_own" value="<?php echo $data[0]['own_form']; ?>" disabled>
						<label for="form_own" title="����� 50% - ��� ���.">����� �������������<span style="color:red;font-size:12px;"> (?)</span></label>
					</div>
					<div class="box">
						<input type="text" id="method_AP" name="method_AP" value="<?php echo $data[0]['method_form_AP']; ?>" disabled>
						<label for="method_AP">����� ����-� ��</label>
					</div>
					<div class="box">
						<input type="text" id="main_person" name="main_person" value="<?php echo $data[0]['ispolnitel']; ?>" disabled>
						<label for="main_person">������������� ����</label>
					</div>

                    <div class="box">
                        <input type="text" id="svidetelctvo_regist" name="svidetelctvo_regist" value="<?php echo $data[0]['svidetelctvo_regist']; ?>" disabled>
                        <label for="svidetelctvo_regist">������-�� (���.����� �����)</label>
                    </div>

					<div class="box">
						<textarea id="contact" rows="3" name="contact" placeholder="<?php echo $data[0]['contragent_data']; ?>" disabled></textarea>
						<label for="contact">��������</label>
					</div>
					<div class="box">
						<textarea id="post_adres" rows="2" name="post_adres" placeholder="<?php echo $data[0]['post_adres']; ?>" disabled></textarea>
						<label for="post_adres">��������<br/>�����</label>
					</div>
					<div class="box">
						<textarea id="notes" rows="2" name="notes" placeholder="<?php echo $data[0]['notes']; ?>" disabled></textarea>
						<label for="notes">����������</label>
					</div>
                    <div class="box">
                        <textarea id="type_rent_propety" rows="3" name="type_rent_propety" placeholder="<?php echo $data[0]['type_rent_propety']; ?>" disabled></textarea>
                        <label for="type_rent_propety">���<br>�����������<br>���������<br></label>
                    </div>

				</div>
			</div>				

        </div><!--        ��������� �������-->
        </div>
     </div>
</div>

        <div class="container mt-2">
            <h5> ����� / ������ � ��������� � ������ ��������� </h5>
            <div class="row mx-1 my-1">

                <div class="col-md-6" style="margin-left: 10px;"><!--            ��������� ���������-->
                    <div class="row block">
                        <div class="col">
                            <h5>��������� � ������ ���������</h5>

                            <div class="box">
                                <input type="text" id="type_opory" name="type_opory" value="<?php echo $data[0]['type_opory']; ?>" disabled>
                                <label for="type_opory">��� �������� �����</label>
                            </div>
                            <div class="box">
                                <input type="text" id="rent_place_TSH" name="rent_place_TSH" value="<?php echo $data[0]['rent_place_TSH']; ?>" disabled>
                                <label for="rent_place_TSH">������ ����� � ��</label>
                            </div>
                            <div class="box">
                                <input type="text" id="rent_area" name="rent_area" value="<?php echo $data[0]['rent_area']; ?>" disabled>
                                <label for="rent_area">������� ������</label>
                            </div>

                        </div>
                    </div>

                </div><!--            ������ �� ��������-->

                <div class="col-md-6" style="margin-left: -10px;"><!--        ����� � ������-->

                    <div class="row block"><!--        ����� � ������-->
                        <div class="col">
                            <h5>����� / ������</h5>
                            <div class="box">
                                <label for="naznachenie">����������</label>
                                <input type="text" id="naznachenie" name="naznachenie" value="<?php echo $data[0]['naznachenie']; ?>" disabled>
                            </div>
                            <div class="box">
                                <label for="admin_office">�����.</label>
                                <input type="text" id="admin_office" name="admin_office" value="<?php echo $data[0]['admin_office']; ?>" disabled>
                            </div>
                            <div class="box">
                                <label for="sell_office">�������</label>
                                <input type="text" id="sell_office" name="sell_office" value="<?php echo $data[0]['sell_office']; ?>" disabled>
                            </div>
                            <div class="box">
                                <label for="tech_office">���.</label>
                                <input type="text" id="tech_office" name="tech_office" value="<?php echo $data[0]['tech_office']; ?>" disabled>
                            </div>
                            <div class="box">
                                <label for="sklady">�����</label>
                                <input type="text" id="sklady" name="sklady" value="<?php echo $data[0]['sklady']; ?>" disabled>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>




    </form>


<!--������ ����� ����� ������-->
<?php
//$maxlifetime = ini_get("session.gc_maxlifetime");
//$cookielifetime = ini_get("session.cookie_lifetime");
//
//echo $maxlifetime;
//echo $cookielifetime;
?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>






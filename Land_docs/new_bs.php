<?php
include_once('../config.php');
include_once('../functions.php');
include_once('../rent/core/function.php');
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
    <title>����� �������</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../rent/Style.css">
    <script defer src="../rent/script.js"></script>
</head>
<body>
<form action="redirectNewBS.php" method="POST"> <!-- ������ ����� -->
    <!-- ����� header-->
    <div id="cap" class="container mt-1" >
        <div class="row align-self-center" >
            <div class="col-12" >
                <div  class="container" >
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="row align-items-center ">
                                <div class="col-md-3 arend">
                                    <a href="index.php"><button type="button" class="btn btn-danger">����� ��������</button></a>
                                </div>
                                <div class="col-md-3">
                                    <input class="btn btn-danger" name="NewButton" type="submit"  value="���������">
                                </div>
                                <div class="col-md-6">
                                    <a href=" <?php echo $_SERVER['HTTP_REFERER']; ?>"><button type="button" class="btn btn-danger">�����</button></a>
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

    <?php If ($user_id > 0) { ?>


    <!--������ �� ��������-->
    <div  class="container mt-3 mb-3 ">
        <br>
        <h5 style="font-size: 26px">������ ��������� ������ ������ �������</h5>
        <div class="row my-3 mx-1">
            <div class="col ">
                <div class="row mt-3 block">
                    <div class="col"><h5>��������� ��</h5> </div>
                    <br>
                    <br>
                    <div class="w-100"></div>
                    <div class="col-md-12 col-lg-6">
                        <!--  <h5>������ ��</h5> -->
                        <div class="box numBS">
                            <input type="text" id="bts" name="bts" style="width: 60%;" value="no_numb">
                            <label for="bts">����� NE</label>
                        </div>
                        <br>
                        <div class="box">
                             <input type="text" id="type_opori" name="type_opori" style="width: 60%;" >
                             <label for="type_opori">��� �����</label>
                        </div>
					</div>

                    <div class="col-md-12 col-lg-6">
                        <!--  <h5>�����</h5> -->
                        <div class="box">
                            <label for="oblast">�������</label> <!-- ���������� ������ ���� �������� � �� Id -->
							<?php if($_SESSION['reg_user'] == '�����') { ?>
								<select id="oblast" name="oblast" style="width: 75%;">
									<option value=""></option>
									<option value=""></option>
									<option value="���������">���������</option>
									<option value="���������">���������</option>
									<option value="����������">����������</option>
									<option value="�����������">�����������</option>
									<option value="�������">�������</option>
									<option value="�����������">�����������</option>
								</select>
							<?php } else { ?>
								<input type="text" id="oblast" name="oblast" style="width: 75%;" value="<?=$_SESSION['reg_user'];?>" required>
                            <?php } ?>
							</div>
                        <br>
                        <div class="box">
                            <label for="oblast">�����</label> <!-- ���������� ������ ������� � �� Id -->
                            <select id="oblast" name="raion" style="width: 75%;">
                                <option value="<?php  echo $row2['area']; ?>"><?php echo $row2['area']; ?></option>
                                <?php // �������� ���� ������� � ����������� �� ���������� �������
								
								If ($_SESSION['reg_user'] !== '�����') {
									If ($_SESSION['reg_user'] == '����') {
										$region_search = '�������';
									} else {
										$region_search = $_SESSION['reg_user'];
									}
									$sql_areas = " SELECT area FROM areas LEFT JOIN regions ON regions.Id = areas.region_id 
									WHERE regions.region LIKE '$region_search' ";
									
								} else {
									$sql_areas = " SELECT Id, area FROM areas ";
								}
								$res = mysql_query($sql_areas);
                                while($row3 = mysql_fetch_assoc($res)){
                                ?>
                                    <option value="<?php echo $row3['area']; ?>"><?php echo $row3['area']; ?></option>
                                <?php }  ?>
                            </select>
                        </div>

                        <br>
                        <div class="box">
                             <input type="text" id="nas_punkt" name="nas_punkt" style="width: 75%;" >
                             <label for="nas_punkt">���. �����</label>
                        </div>
						<br>
						 <div class="box">
                             <input type="text" id="adress" name="adress" style="width: 75%;" >
                             <label for="adress">�����</label>
                        </div>

                     </div>
                </div>
            </div>
        </div>
    </div><!--������ �� ��������-->


</form> <!-- ����� ����� -->



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



<?php  } ?>

</body>
</html>

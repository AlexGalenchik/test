<?php
//����� ����������� ���������� - ���� ���������
include_once('./core/config.php');
include_once('./core/function.php');
session_start();


// ������ ��� ������ �����
If (isset($_GET['Id'])) {
    //  ����������� � ��
    $conn = connect();
    //����� ������ �� ������� � ���� �������
    $data = selectAll($conn);
};

// ������� �������� �� rent_documents
  function select_rent_documents($conn)    {
        // ��������� ������ �� ��
        $sql = "SELECT * FROM  rent_documents  WHERE id_directori like '".$_GET['Id']."' ORDER BY Id DESC ";

        $result = mysqli_query($conn, $sql);
        $a = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $a[] = $row;
            }
        }
        return $a;
    }

    // ����� �������
    $select_rent_documents = select_rent_documents($conn);


// �� ���� ����� ��� ���
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
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
<!--     <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>���������</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>

</head>
<body>
<div id="cap" class="container mt-1">
		<div class="row align-self-center">
			<div class="col-12">
					<div  class="container">	
						<div class="row justify-content-end align-items-center">
						    <div class="col-md-12" >
								<a href='/rent/index.php?Id=<?=$_GET['Id']?>'><button type="button" class="btn btn-danger" >�����</button></a>
						  </div>
						</div>
					</div>
			</div>
		</div>
	</div>	 <!--����� header-->

<div  class="container mt-2">
	<div class="row align-self-center">	
	
			<div class="col-12"style="padding: 2%;">

							
<?php //������� ������ ����������

//��������� ���� ��� ����� ���������� ����������
// �������, � ������� �� ����� ��������� ����:

if($_SESSION['reg_user'] == '�����' || $_SESSION['reg_user'] == '����'){
    $file__path = "�����";
    $uploaddir = './files/'.$file__path;
}

else{
    $file__path = $_SESSION['reg_user'];
    $uploaddir = './files/'.$file__path;
}

// �������� ����� �� ID ��
$bts_num = $_GET['Id'];
$dir = $uploaddir."/id_".$bts_num;
$i = 0; 


// �������� ����������� �������� � ������� is_dir
//if (is_dir($dir)) {
//    // ��������� ������
//    $openDir = opendir($dir);
//    while (($file = readdir($openDir)) !== false) {
//		if ($file != '.' && $file != '..') {
//			$i++;
//            echo $i.". <a href='$dir/$file'>$file</a></br>" . "<br>";
//        }
//    }
// ��������� ������
//    closedir($openDir);
//} else {
//	echo "���������� �� ������ �� ".$_SESSION['bts_num']." �� �������!";
//}


    $out  = "<table id='result_table'>";
    $out .= "<tr>";
    $out .=  "<td id='rs_td'><b><center>� �\�</center></b></td>";
    $out .=  "<td id='rs_td'><b><center style=\"margin: 25% 0 25% 0;  \">��� NE</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>����� NE</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>�������� ���������</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>���� ��������</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>���� �������� �����</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>������ �����</center></b></td>";
    $out .=   "<td id='rs_td'><b><center>�������� ������</center></b></td>";
	If ($_SESSION['rights'] == 'w') {
    $out .=   "<td id='rs_td'><b><center>�������</center></b></td>";
	}
    $out .=   "</tr>";

    for ($k = 0; $k <count($select_rent_documents) ; $k++) {
        $t = $k+1;

        $out .=   "<tr><td id='rs_td' align='center' width='20px' height='20px'><b>$t</b></td>";
        $out .=   "<td id='rs_td' align='center' width='20px' height='20px'><b>{$select_rent_documents[$k]['type']}</b></td>";
        $out .=   "<td id='rs_td' align='center' width='35px'><b>{$select_rent_documents[$k]['number']}</b></td>";
        if( empty( $select_rent_documents[$k]['notes']) ){
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><a href='{$select_rent_documents[$k]['path']}' width='20px'><b>{$select_rent_documents[$k]['description']}</b></td>";
        }
        else {
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><b>{$select_rent_documents[$k]['description']}</b></td>";
        }
        $out .=   "<td id='rs_td' align='center' width='50px'>{$select_rent_documents[$k]['ispolnitel']}</td>";
        $out .=   "<td id='rs_td' align='left' width='140px'>{$select_rent_documents[$k]['data']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$select_rent_documents[$k]['size']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$select_rent_documents[$k]['notes']}</td>";
		If ($_SESSION['rights'] == 'w') {
        $out .=   "<td id='rs_td' align='center' width='20px'><p class='check-delete' position='relative'  data='{$select_rent_documents[$k]['Id']}'>";
			if( empty( $select_rent_documents[$k]['notes']) ){
        $out .=   "<a href=''><img src='../pics/_delete_pic.png' style=\"margin: 15% 0 0 0;\"  width='30px'></a> </p></td></tr>";
            }
		}
        else {
            $out .=   "</p></td></tr>";
         }
    }
    $out .=   "</table>";


    echo $out;


echo "</div>";

?>

		</div>	
	</div>
</div>



<script>
    window.onload = function () {

        let CheckDelete = document.querySelectorAll('.check-delete');
        CheckDelete.forEach(function (element) {
            element.onclick = checkDeleteFunction;

        } );

        function checkDeleteFunction(evt) {
            evt.preventDefault();
            console.log( this.getAttribute('data') );

            let a = confirm("Do you want delete?");
            if (a == true) {

                // �������� ������ �� ���� �������� ����� � ���������� ������ �� �������� �����,
                // ������� ���� � ������� - ��� ����� ������� � �� ���������� ������� �� ��������
                location.href = 'delete__file.php?Id=' + <?=$bts_num?> + '&Id_note=' + this.getAttribute('data');
                console.log("11111111111111111");
            }
            else {
                console.log('2222222222222');
            }
        }
    }
</script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>

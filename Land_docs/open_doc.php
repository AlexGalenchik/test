<?php
//����� ����������� ���������� - ���� �����
include_once('./core/config.php');
include_once('./core/function.php');
session_start();

//  ����������� � ��
    $conn = connect();

// ������ ��� ������ �����
If (isset($_GET['Id'])) {
    //����� ������ �� ������� � ���� �������
    $data = select_data_land($conn);
};
//������� ��� ������ �����
//$prefix= "type_" .$data[0]["type"] . "_number_" . $data[0]["number"] ."_id_" ;

// ����� ������� - �������� ������� �� ����������� ���������� ������� Id �������
    $land_documents = select_land_documents($conn);

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
    <link rel="stylesheet" href="../rent/Style.css">
    <script defer src="../rent/script.js"></script>

</head>
<body>
<div id="cap" class="container mt-1">
		<div class="row align-self-center">
			<div class="col-12">
					<div  class="container">	
						<div class="row justify-content-end align-items-center">
						    <div class="col-md-12" >
								<a href='dogovor.php?Id=<?=$_GET['Id']?>'><button type="button" class="btn btn-danger" >�����</button></a>
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

    $file__path = $data[0]['oblast'];
    $uploaddir = './files/'.$file__path;

// �������� ����� �� ID ��
$bts_num = $_GET['Id'];
$dir = $uploaddir."/id_".$id."/";
$i = 0;


//����� ������� ������
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
	If ($_SESSION['rights'] == 'w') { //C ������� �� ������ ������� � �������� �������� (�������) �� ������������
	$out .=   "<td id='rs_td'><b><center>�������</center></b></td>";
	}
    $out .=   "</tr>";

    for ($k = 0; $k <count($land_documents) ; $k++) {
        $t = $k+1;
//������ ���������� �������
        $out .=   "<tr><td id='rs_td' align='center' width='20px' height='20px'><b>$t</b></td>";
        $out .=   "<td id='rs_td' align='center' width='20px' height='20px'><b>{$land_documents[$k]['type']}</b></td>";
        $out .=   "<td id='rs_td' align='center' width='35px'><b>{$land_documents[$k]['number']}</b></td>";
        if( empty( $land_documents[$k]['notes']) ){ //���� ���� ����������, ������ �������� ��� ������
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><a target='_blank' href='{$land_documents[$k]['path']}' width='20px'><b>{$land_documents[$k]['description']}</b></td>";
        }
        else {
            $out .=   "<td id='rs_td' align='center' width='200px' height='20px'><b>{$land_documents[$k]['description']}</b></td>";
        }
        $out .=   "<td id='rs_td' align='center' width='50px'>{$land_documents[$k]['ispolnitel']}</td>";
        $out .=   "<td id='rs_td' align='left' width='140px'>{$land_documents[$k]['data']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$land_documents[$k]['size']}</td>";
        $out .=   "<td id='rs_td' align='left' width='40px'>{$land_documents[$k]['notes']}</td>";
		If ($_SESSION['rights'] == 'w') {
        $out .=   "<td id='rs_td' align='center' width='20px'><p class='check-delete' position='relative'  data='{$land_documents[$k]['Id']}'>";
			if(empty( $land_documents[$k]['notes'])){
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
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>

<?php
include_once('../config.php');

if (isset($_POST['log']) && isset($_POST['pas']))
{
    $login = mysql_real_escape_string($_POST['log']);
    $password =$_POST['pas'];

    // ������ ������ � ��
    // � ���� ����� � ����� ������� � �������

    $query = "SELECT id, name, middle_name, surname, login, department, reg_user, rights   
            FROM users
            WHERE login='{$login}' AND password='{$password}'
            LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());

    // ���� ����� ������������ �������
    if (mysql_num_rows($sql) == 1) {
        // �� �� ������ �� ���� ����� � ������ (�������� �� ����� ������� ID ������������)

        $row = mysql_fetch_assoc($sql);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_surname'] = $row['surname'];
		$_SESSION['middle_name'] = $row['middle_name'];
        $_SESSION['user_login'] = $row['login'];
		$_SESSION['department'] = $row['department'];
		$_SESSION['reg_user'] = $row['reg_user']; //�������� ������ - �������� 15.05.2020
		$_SESSION['rights'] = $row['rights']; //��������� ����� ������������ (������/������) - �������� 26.06.2020
        
        // �� ��������, ��� ��� ������ � ����������� �������, � ��� � ������ ������� ������ �������������� session_start();
    }
    
}
?>
<script>document.location.href="/rent/geo_finder.php"</script>
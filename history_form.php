<?php
// ������� ���������
$cat = $_GET['cat']; //��� ������� (���������) [�� ��� ������� ��� ������ �������]
$id = $_GET['id']; //Id ������� (� �������������� ������� �� id ��� ������� id ��� ������ ������� id

// �������� ������
if ($cat == 'budget') {  // ������ �������
  $objects = array (
     'budget' => '������'
    ,'budget_addresses' => '����� �������'
  );
}

if ($cat == 'bts') {  // ������ ��
  $objects = array (
     'bts' => '��'
    ,'sectors' => '�������'
    ,'rrl' => '���'
    ,'hardware' => '���.������.'
  );
}

if ($cat == 'repeaters') {  // ������ �������
  $objects = array (
     'repeaters' => '�������'
    ,'repeater_sectors' => '������� ��������'
  );
}

//�� ����� ������ objects ������ ��� ������ ���� ������� [�� ��� ������� ��� ������ �������]
//������������ ������ $objects � ����� ������ $fields � �������� ������ ������ ����� �� ���������� 
//([budget,budget_addresses][bts,sectors,rrl,hardware],[repeaters,repeater_sectors])
foreach ($objects as $key => $value) {
  $fields[] = '"'.$key.'"';
}
//������ �� ������� ������ �� ������� ������� (history)
$sql = "SELECT ";
$sql.= " act_date";
$sql.= ",act_time";
$sql.= ",surname";
$sql.= ",name";
$sql.= ",middle_name";
$sql.= ",action";
$sql.= ",changes"; //�������� ��������� 
$sql.= ",table_name";
$sql.= " FROM history"; 
$sql.= " LEFT JOIN users"; //������ � �������� �������������
$sql.= " ON history.user_id=users.id";
$sql.= " WHERE table_name IN (".implode(',',$fields).") AND object_id=$id ORDER BY history.id DESC"; //��������� ������ � ���� �� �������� ","
//��� ���� table_name  � ������� ������� ������ $fields (����� �� ��������) � ���� object_id ����� id ������� (��� ������� ��� ������ �������)
//���������� �� �������� ������� � ������� �������, �.�. ���������� ������ ����� ������ ������

$query=mysql_query($sql) or die(mysql_error());

// ����� ��������� ����������
echo "<div id='main_content'>";
echo "<table id='additional_table'>";   // ������� �������
echo "<tr>";// ����� ������� �������
echo "<td id='ad_td' style='text-align:center;'>����</td>"; //act_date
echo "<td id='ad_td' style='text-align:center;'>�����</td>"; //act_time
echo "<td id='ad_td' style='text-align:center;'>�������.</td>"; //surname name middle_name
echo "<td id='ad_td' style='text-align:center;'>������</td>"; //table_name
echo "<td id='ad_td' style='text-align:center;'>��������</td>"; //action
echo "<td id='ad_td' style='text-align:center;'>���������</td>";  //changes
echo "</tr>";

for ($i=0; $i<mysql_num_rows($query); $i++) { //����� ������ �� ������� history
  $row = mysql_fetch_array($query);
  echo "<tr>";
  echo "<td id='ad_td'>".$row['act_date']."</td>"; // ���� ���������
  echo "<td id='ad_td'>".$row['act_time']."</td>"; // ����� ���������
  $user = $row['surname']." ".(!empty($row['name'])? substr($row['name'],0,1).'.' : '').(!empty($row['middle_name'])? substr($row['middle_name'],0,1).'.' : '');
  //����������� ������������ �� ������� "������� �.�." ���� ��� � �������� ���� � ����
  echo "<td id='ad_td'>$user</td>"; //����� "������� �.�."
  $object = $objects[$row['table_name']]; //��� ������� (��,������,�������)
  echo "<td id='ad_td'>$object</td>"; //����� �������
  if ($row['action'] == 'insert') $action = "��������� ������"; // ������� ���� �� �������
  if ($row['action'] == 'update') $action = "�������� ������";// ������� ���� �� �������
  if ($row['action'] == 'delete') $action = "������� ������";  // ������� ���� �� �������
  echo "<td id='ad_td'>$action</td>"; //����� �������� ��� ��������
  echo "<td id='ad_td'>";
  $changes = explode(';',$row['changes']); //��������� ������ �� ���������� � ������� ����������� � ������ ������ ";" � ���������� � ������ $changes
  for ($j=0; $j<count($changes); $j++) {
	 echo $changes[$j]; //����� ���������� (����� ������) �� ������� ��������� $changes, ����������� ";"
	     
    if ($j+1 < count($changes) ) echo"<br>"; //������� �� ����� ������ ��� ������ ����� ����������
  }
  echo "</td>";
  echo "</tr>";
}

echo "</table>"; //��������� �������
echo "</div>";
?> 
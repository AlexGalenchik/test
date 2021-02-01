<?php
// входные параметры
$cat = $_GET['cat']; //тип объекта (категория) [БС ИЛИ репитер ИЛИ запись бюджета]
$id = $_GET['id']; //Id объекта (в соответсвующей таблице БС id ИЛИ репитер id ИЛИ запись бюджета id

// основной запрос
if ($cat == 'budget') {  // запись бюджета
  $objects = array (
     'budget' => 'бюджет'
    ,'budget_addresses' => 'адрес бюджета'
  );
}

if ($cat == 'bts') {  // запись БС
  $objects = array (
     'bts' => 'бс'
    ,'sectors' => 'сектора'
    ,'rrl' => 'ррл'
    ,'hardware' => 'доп.оборуд.'
  );
}

if ($cat == 'repeaters') {  // запись репитер
  $objects = array (
     'repeaters' => 'репитер'
    ,'repeater_sectors' => 'сектора репитера'
  );
}

//Мы имеем массив objects только для одного типа объекта [БС ИЛИ репитер ИЛИ запись бюджета]
//Переписываем массив $objects в новый массив $fields и получаем массив ключей полей на английском 
//([budget,budget_addresses][bts,sectors,rrl,hardware],[repeaters,repeater_sectors])
foreach ($objects as $key => $value) {
  $fields[] = '"'.$key.'"';
}
//Запрос на выборку данных из таблицы истории (history)
$sql = "SELECT ";
$sql.= " act_date";
$sql.= ",act_time";
$sql.= ",surname";
$sql.= ",name";
$sql.= ",middle_name";
$sql.= ",action";
$sql.= ",changes"; //нарушена кодировка 
$sql.= ",table_name";
$sql.= " FROM history"; 
$sql.= " LEFT JOIN users"; //связка с таблицей пользователей
$sql.= " ON history.user_id=users.id";
$sql.= " WHERE table_name IN (".implode(',',$fields).") AND object_id=$id ORDER BY history.id DESC"; //склеивает строки в одну по символам ","
//где поле table_name  в составе массива ключей $fields (любое из значений) и поле object_id равно id объекта (БСб Репитер или запись бюджета)
//сортировка по убыванию записей в таблице истории, т.е. показывать сверху самые свежие записи

$query=mysql_query($sql) or die(mysql_error());

// вывод элементов интерфейса
echo "<div id='main_content'>";
echo "<table id='additional_table'>";   // таблица истории
echo "<tr>";// шапка таблицы истории
echo "<td id='ad_td' style='text-align:center;'>дата</td>"; //act_date
echo "<td id='ad_td' style='text-align:center;'>время</td>"; //act_time
echo "<td id='ad_td' style='text-align:center;'>пользов.</td>"; //surname name middle_name
echo "<td id='ad_td' style='text-align:center;'>объект</td>"; //table_name
echo "<td id='ad_td' style='text-align:center;'>действие</td>"; //action
echo "<td id='ad_td' style='text-align:center;'>изменения</td>";  //changes
echo "</tr>";

for ($i=0; $i<mysql_num_rows($query); $i++) { //вывод данных из таблицы history
  $row = mysql_fetch_array($query);
  echo "<tr>";
  echo "<td id='ad_td'>".$row['act_date']."</td>"; // Дата изменения
  echo "<td id='ad_td'>".$row['act_time']."</td>"; // Время изменения
  $user = $row['surname']." ".(!empty($row['name'])? substr($row['name'],0,1).'.' : '').(!empty($row['middle_name'])? substr($row['middle_name'],0,1).'.' : '');
  //Составление пользователя по шаблону "Фамилия И.О." если имя и отчество есть в базе
  echo "<td id='ad_td'>$user</td>"; //вывод "Фамилия И.О."
  $object = $objects[$row['table_name']]; //тип объекта (БС,Бюджет,Репитер)
  echo "<td id='ad_td'>$object</td>"; //Вывод объекта
  if ($row['action'] == 'insert') $action = "добавлена запись"; // перевод поля на русский
  if ($row['action'] == 'update') $action = "изменена запись";// перевод поля на русский
  if ($row['action'] == 'delete') $action = "удалена запись";  // перевод поля на русский
  echo "<td id='ad_td'>$action</td>"; //Вывод действия над объектом
  echo "<td id='ad_td'>";
  $changes = explode(';',$row['changes']); //разбивает строку на подмассивы с помощью разделителя в данном случае ";" и записывает в массив $changes
  for ($j=0; $j<count($changes); $j++) {
	 echo $changes[$j]; //Вывод подмассива (одной записи) из массива изменений $changes, разделенные ";"
	     
    if ($j+1 < count($changes) ) echo"<br>"; //Переход на новую строку при выводе всего подмассива
  }
  echo "</td>";
  echo "</tr>";
}

echo "</table>"; //Окончание таблицы
echo "</div>";
?> 
<?php 

include_once('config.php');
include_once('functions.php');
session_start();

// Запрос по типам RRU  с их количеством
$sql = " SELECT";
$sql.= " rru_type";
$sql.= ",power";
$sql.= ",ports";
$sql.= ",diapazon";
$sql.= ",primechanie";
$sql.= " FROM hw_rru_types";
$sql.= " GROUP BY rru_type"; 
$sql.= " ORDER BY rru_type"; 
$query = mysql_query($sql) or die(mysql_error());

// Запрос по типам Антенн
$sql="SELECT";
$sql.=" prototip";
$sql.=",ant_name";
$sql.=",diapazon";
$sql.=",ports";
$sql.= " FROM hw_antenna_types";
$sql.= " ORDER BY prototip"; 
$query2 = mysql_query($sql) or die(mysql_error());

// Запрос по Количеству всех плат Boards
$sql = " SELECT";
$sql.= " hw_boards_types.board_type";
$sql.= ",hw_boards_types.class";
$sql.= ",hw_boards_types.tech";
$sql.= ",hw_boards_types.cells";
$sql.= ",hw_boards_types.ce_load";
$sql.= ",hw_boards_types.power";
$sql.= ",COUNT(hw_boards.board) as count_board";
$sql.= " FROM hw_boards_types, hw_boards";
$sql.= " WHERE hw_boards_types.board_type = hw_boards.board";
$sql.= " GROUP BY hw_boards_types.board_type";
$sql.= " ORDER BY hw_boards_types.class";
$query3 = mysql_query($sql) or die(mysql_error());



// Общие данные по RRU
$info = array();

// Общие данные по antennas
$info1 = array();

// Общие данные по boards
$info2 = array();
// Общие данные по boards
$info3 = array();

/////////////////////////////////////////////////////// Справочник по RRU

$tableRRU = array (
		array ('Type RRU','Power (W)','Ports','Diapazon (MHz)','Info')
		);
for ($i=0; $i<= mysql_num_rows($query); $i++) {
  $row1 = mysql_fetch_array($query);
    $tableRRU[] = array(
	 $row1['rru_type']
	,$row1['power']
	,$row1['ports']
	,$row1['diapazon']
	,$row1['primechanie']
	);
}	

/////////////////////////////////////////////////////// Справочник по Антеннам

$tableAnt = array (
		array ('Prototip','Antenna','Diapazon (MHz)','Ports')
		);
for ($i=0; $i<= mysql_num_rows($query2); $i++) {
  $row2 = mysql_fetch_array($query2);
  
    $tableAnt[] = array(
	"<b>".$row2['prototip']."</b>"
	,"<div style=\"text-align:left;\">&nbsp;".$row2['ant_name']."</div>"
	,$row2['diapazon']
	,$row2['ports']
	 
	);
	 
}	

/////////////////////////////////////////////////////// Справочник по количеству Плат БС

$tableBoardsNum = array (
		array ('Type','Class','Tech','Cells','CE','Power (W)','Count')
		);
		
for ($i=0; $i<= mysql_num_rows($query3); $i++) {
  $row3 = mysql_fetch_array($query3);
  
    $tableBoardsNum[] = array(
	 "<b>".$row3['board_type']."</b>"
	,$row3['class']
	,$row3['tech']
	,$row3['cells']
	,$row3['ce_load']
	,$row3['power']
	,"<b>".$row3['count_board']."</b>"
	
	);
	
	
	 
}
	

// вывод элементов интерфейса

echo "<div>";
echo "  <div id='info_left_indent'>";   
InfoBlock('bts_info_block',$info=array($info),'<span style="color: red;">RRU</span>',$tableRRU); 
InfoBlock('bts_info_block',$info=array($info2),'<span style="color: red;">Boards_Number</span>',$tableBoardsNum); 

echo "  </div>";
echo "  <div id='info_right_indent'>";
InfoBlock('bts_ad_info_block',$info=array($info1),'<span style="color: red;">Prototip - Antenna</span>',$tableAnt);
echo "  </div>";
echo "</div>";

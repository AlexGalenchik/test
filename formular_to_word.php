<?php
include_once('config.php');
include_once('functions.php');
session_start();

$id = $_GET['id'];

if (!isset($_GET['done']) ) {
  echo "<div style='display: table; height: 80%; width: 100%;  text-align: center;'>";
  echo "  <div style='display: table-cell; vertical-align: middle; border-radius: 15px;'>";
  echo "    <div>√енерируетс€ формул€р...ждите</div>";
  echo "  <p><img src='https://i.gifer.com/2of.gif' ></p>";
  echo "  </div>";
  echo "</div>";
  $link='formular_to_word.php?id='.$_GET['id'].'&done';
}

if (isset($_GET['done']) ) {
  set_time_limit(60*10);
  exec ('bats\fud_create.bat '.$_GET['id']); 
 
  $data = array (
     'fud_lotus_link' => "/files/lotus_fud/$id.doc"
	 
  ); 
  
  
  MySQLAction($data,'formulars',$id,'update',false);
  $link = "index.php?f=24&id=$id";
 
}

?> 
<script type="text/javascript" src="flot/jquery.js"></script>

<script>
$(document).ready(function (){
  setTimeout(function () {
    var param = '<?php echo $link;?>';
    document.location.href=param;
  } , 1000)
});
</script> 
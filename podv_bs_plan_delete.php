<?php
include_once('config.php');
include_once('functions.php');
session_start();
 
$link=$_SESSION['sections'][count($_SESSION['sections'])-2]['link'];
 

function connect() {
    // Create connection
    $conn = mysqli_connect("localhost","root","","mts_dbase");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$conn = connect(); 

$id=$_GET[id];
   
	   $sql = mysqli_query($conn, "DELETE FROM podv_plan WHERE id=".$id);
			if ($sql) {
				echo '<p style="color: gray; font-size: 30px">Data delete.</p>'; 
				 
				//print_r($link);
				echo "<a href='http://10.128.217.135/index.php?f=50'><b style=\"color: blue; font-size: 30px\">Back</b></a>";
			 
			
		} else {
				'<p>Ошибка.</p>'; 
		}
 
 	mysqli_close($conn);
?>

<script>
var param = '<?php echo $link;?>';
document.location.href=param</script>
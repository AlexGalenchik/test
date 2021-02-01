<?php
session_start();

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];

} else {
$user_id = 0;
}

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}

function PrintDirectoryTree($dir, $parent = 0)
{
    if ($parent == 0)
        echo "<ul>\r\n";
    echo "<li type='circle'>$dir</li>\r\n";
    echo "<ul type='disc'>\r\n";
    
    $files = scandir($dir);
    foreach ($files as $v)
    {
        if ($v == "." || $v == "..")
            continue;
        $s = $dir."\\".$v;
        if (is_dir($s))
            PrintDirectoryTree($s, 1);
        else
            echo "<li>$v&nbsp;<a href='?del=".urlencode($dir."\\".$v)."' alt='Удалить'>x</a></li>\r\n";
    }
    echo "</ul>\r\n";
    if ($parent == 0)
        echo "</ul>\r\n";
}
if (isset($_GET['del']))
{
    $file = urldecode($_GET['del']);
    if (isset($_GET['confirmed']))
        unlink($file);
    else
    {
        echo "<center>Уверены что хотите удалить файл $file?<br>";
        echo "<a href='?del=".$_GET['del']."&confirmed=true'>Да</a>";
        echo "&nbsp;&nbsp;&nbsp;<a href='".$_SERVER['PHP_SELF']."'>Нет</a></center>";
    }
}
 
PrintDirectoryTree('./files/');
?>
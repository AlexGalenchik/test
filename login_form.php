<?php    
echo "<div id='login'><form action='auth.php' method='post'>";
echo "<p>Логин:<br>";
echo "<input type='text' size='25' name='log'>";
echo "</p>";
echo "<p>Пароль:<br>";
echo "<input type='password' size='25' name='pas'>";
echo "</p>";
echo "<p>";
echo "  <input type='submit' value='войти' id='log_submit'>";
echo "</p>"; 
echo "</form>";
echo "</div>";
?>
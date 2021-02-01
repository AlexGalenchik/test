<?php

    echo "<form action='auth.php' method='post' >";
        echo "<div class=\"col-8\">";
                echo "<div class='col log_info'>";
                                echo 'Логин:'."&nbsp;&nbsp;&nbsp;";
                                echo "<input type='text' name='log'>";
                                echo 'Пароль: ';
                                echo "<input type='password' name='pas'>";
                echo "</div>";
                echo "<div class=\"w-100\"></div>";
                echo "<div class='col'>";
                               echo "<input type='submit' value='".'войти'."'>";
                echo "</div>";
            echo "</div>";
    echo "<div id='log_info'  class=\"col-2\">";
    echo "</div>";
    echo "</form>";
?>
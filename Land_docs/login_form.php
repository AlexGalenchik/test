<?php

    echo "<form action='auth.php' method='post' >";
        echo "<div class=\"col-8\">";
                echo "<div class='col log_info'>";
                                echo '�����:'."&nbsp;&nbsp;&nbsp;";
                                echo "<input type='text' name='log'>";
                                echo '������: ';
                                echo "<input type='password' name='pas'>";
                echo "</div>";
                echo "<div class=\"w-100\"></div>";
                echo "<div class='col'>";
                               echo "<input type='submit' value='".'�����'."'>";
                echo "</div>";
            echo "</div>";
    echo "<div id='log_info'  class=\"col-2\">";
    echo "</div>";
    echo "</form>";
?>
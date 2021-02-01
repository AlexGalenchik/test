<?php

//  подключения к БД
function connect(){
    // Create connection
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
    // кодировка
    mysqli_set_charset($conn, "cp1251");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}



<?php 
$link = mysqli_connect("localhost", "mysql", "mysql");

if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    // print("Соединение установлено успешно");
}

//mysqli_set_charset($link, "utf8");
mysqli_select_db($link,"stripe");


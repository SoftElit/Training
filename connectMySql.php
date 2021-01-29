<?php
$host = 'localhost'; //адрес сервера БД (этот адрес хоста применяем, когда подключаемся с того же хоста)
//$host = 'newgrade.vpool'; //адрес сервера БД (этот адрес хоста применяем, когда подключаемся удалённо)
$user = 'root'; //имя пользователя 
$password = 'root'; //пароль пользователя
$dbname = 'test_samson'; //имя БД

//Создаём подключение к серверу БД
$connect = mysqli_connect($host, $user, $password, $dbname);

//Проверяем подключение к серверу БД
/*
if(mysqli_connect_errno()) {
	echo mysqli_connect_error();
};
*/

//Закрываем подключение к серверу БД
//mysqli_close($connect);

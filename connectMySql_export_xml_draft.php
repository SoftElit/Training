<?php
/*
Реализовать функцию exportXml($a, $b). $a – путь к xml файлу вида (структура файла приведена ниже), $b – код рубрики. 
Результат ее выполнения: выбрать из БД товары (и их характеристики, необходимые для формирования файла) выходящие в рубрику $b 
или в любую из всех вложенных в нее рубрик, сохранить результат в файл $a.
*/

//Подключаем скрипт подключения к серверу БД
require_once "connectMySql.php";

//Проверяем подключение к серверу БД и отправляем SQL запрос

if(mysqli_connect_errno()) {
	echo mysqli_connect_error();
} else {

	$result = mysqli_query(
	$connect,
	"SELECT * FROM `test_samson`.`a_product`
	;");


	$dom = new DOMDocument('1.0', 'windows-1251');
	$dom->formatOutput = True;

	$root = $dom->createElement('Товары');
	$dom->appendChild($root);

	while($row = $result->fetch_assoc())
	{
		$node = $dom->createElement('Товар');
		foreach($row as $key => $val)
		{
			$child = $dom->createElement($key);
			$child ->appendChild($dom->createCDATASection($val));
			$node  ->appendChild($child);
		}
		$root->appendChild($node);
	}

	$dom->save( 'target.xml' );

};


//Закрываем подключение к серверу БД
mysqli_close($connect);

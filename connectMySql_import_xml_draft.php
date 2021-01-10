<?php
/*
Реализовать функцию importXml($a). $a – путь к xml файлу (структура файла приведена ниже). 
Результат ее выполнения: прочитать файл $a и импортировать его в созданную БД.
*/

//Подключаем скрипт подключения к серверу БД
require_once "connectMySql.php";

//Проверяем подключение к серверу БД и отправляем SQL запрос

if(mysqli_connect_errno()) {
	echo mysqli_connect_error();
} else {

	/* Выбираем загружаемый файл (Путь к XML-файлу)
	simplexml_load_file — Интерпретирует XML-файл в объект. */
	$sxml = simplexml_load_file('samson1.xml');

	//Получаем из созданного объекта XML-файла код товара и прочие параметры, сохраняя их в переменных
	foreach($sxml->Товар as $product) {
		$art = stripslashes($product['Код']);
		$name = stripslashes($product['Название']);

		foreach($product as $description) {
			
			switch((string) $description['Тип']) { // Получение атрибутов элемента по индексу
			case 'Базовая':
				$priceBase = stripslashes($description);
			case 'Москва':
				$priceMoscow = stripslashes($description);
			}		
			
			switch((string) $description->Плотность) { // Получение атрибутов элемента по индексу
			case true:
				$density = stripslashes($description->Плотность);
			}
		
			switch((string) $description->Белизна['ЕдИзм']) { // Получение атрибутов элемента по индексу
			case '%':
				$white = stripslashes($description->Белизна);
			}

			switch((string) $description->Формат) { // Получение атрибутов элемента по индексу
			case true:
/*
				foreach($description->Формат as $format) {
					$printerFormat[] = $description->Формат;
				}
*/
				$printerFormat = stripslashes($description->Формат);
			}
/*
			foreach($description->Формат as $format) {
			switch($format) { // Получение атрибутов элемента по индексу
			case true:
				$printerFormat[] = $format;
			}
			}
*/
			switch((string) $description->Тип) { // Получение атрибутов элемента по индексу
			case true:
				$printerType = stripslashes($description->Тип);
			}

			switch((string) $description->Раздел) { // Получение атрибутов элемента по индексу
			case true:
				$section = stripslashes($description->Раздел);
			}
		};	

		$result = mysqli_query(
		$connect,
		"INSERT INTO `test_samson`.`a_product` (`код`, `название`) 
		VALUES ('$art', '$name')
		;");

		$result = mysqli_query(
		$connect,		
		"INSERT INTO `test_samson`.`a_ price` (`товар`, `тип цены`, `цена`) 
		VALUES ('$name', 'Базовая', '$priceBase'),
		('$name', 'Москва', '$priceMoscow')
		;");

		$result = mysqli_query(
		$connect,		
		"INSERT INTO `test_samson`.`a_property` (`товар`, `свойство`, `значение свойста`) 
		VALUES ('$name', 'Плотность', '$density'),
		('$name', 'Белизна ЕдИзм=%', '$white'),
		('$name', 'Формат', '$printerFormat'),
		('$name', 'Тип', '$printerType')
		;");

		$result = mysqli_query(
		$connect, 
		"INSERT INTO `test_samson`.`a_category` (`код`, `название`, `parent_id`) 
		VALUES ('$art', '$section', '0')
		;");

	}
};


//Закрываем подключение к серверу БД
mysqli_close($connect);

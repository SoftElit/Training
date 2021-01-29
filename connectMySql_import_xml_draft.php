<?php
/*
Реализовать функцию importXml($a). $a – путь к xml файлу (структура файла приведена ниже). 
Результат ее выполнения: прочитать файл $a и импортировать его в созданную БД.
*/

function importXml($a)
{

	//Подключаем скрипт подключения к серверу БД
	require_once "connectMySql.php";

	//Проверяем подключение к серверу БД и отправляем SQL запрос

	if(mysqli_connect_errno()) {
		echo mysqli_connect_error();
	} else {

		/* Выбираем загружаемый файл (Путь к XML-файлу)
		simplexml_load_file — Интерпретирует XML-файл в объект. */
		$sxml = simplexml_load_file($a);																					//<ТОВАРЫ>

		//Получаем из созданного объекта XML-файла код товара и прочие параметры, сохраняя их в переменных
		foreach($sxml as $product) {																						//<ТОВАР>
			$art = stripslashes($product['Код']);
			$name = stripslashes($product['Название']);

			foreach($product as $description) {																				//<ЦЕНА, СВОЙСТВА, РАЗДЕЛЫ>
				
				switch((string) $description['Тип']) { // Получение атрибутов элемента по индексу
				case 'Базовая':
					$priceBase = stripslashes($description);
				case 'Москва':
					$priceMoscow = stripslashes($description);
				}

				switch((string) $description->children()->getName()) { // Получение атрибутов элемента по индексу
				case 'Плотность':
					$density = stripslashes($description->children());
					
					$result = mysqli_query(
					$connect,		
					"INSERT INTO `test_samson`.`a_property` (`товар`, `свойство`, `значение свойства`) 
					VALUES ('$name', 'Плотность', '$density')
					;");
				}
		
				switch((string) $description->Белизна['ЕдИзм']) { // Получение атрибутов элемента по индексу
				case '%':
					$white = stripslashes($description->children());
					
					$result = mysqli_query(
					$connect,		
					"INSERT INTO `test_samson`.`a_property` (`товар`, `свойство`, `значение свойства`) 
					VALUES ('$name', 'Белизна ЕдИзм=%', '$white')
					;");
				}

				switch((string) $description->Тип) { // Получение атрибутов элемента по индексу
				case true:
					$printerType = stripslashes($description->Тип);
					
					$result = mysqli_query(
					$connect,		
					"INSERT INTO `test_samson`.`a_property` (`товар`, `свойство`, `значение свойства`) 
					VALUES 
					('$name', 'Тип', '$printerType')
					;");
				}
				
				switch((string) $description->Раздел) { // Получение атрибутов элемента по индексу
					case true:
					foreach($description as $sections) {
						$section = $sections;
						
						//ВАЖНО!!! Нужно либо указывать в `parent_id` уже загруженный в БД `id` реально существующей категории, либо вообще НЕ загружать `parent_id` (то есть убрать этот параметр из маски INSERT INTO...)
						$result = mysqli_query(
						$connect, 
						"INSERT INTO `test_samson`.`a_category` (`код`, `название`) 
						VALUES ('$art', '$section')
						;");
					}
				}
				
				switch((string) $description->Формат) { // Получение атрибутов элемента по индексу
					case true:
					foreach($description->Формат as $printerFormats) {
						$printerFormat = $printerFormats;
						
						$result = mysqli_query(
						$connect,		
						"INSERT INTO `test_samson`.`a_property` (`товар`, `свойство`, `значение свойства`) 
						VALUES 
						('$name', 'Формат', '$printerFormat')
						;");

					}
				}

				
			};	

			$result = mysqli_query(
			$connect,
			"INSERT INTO `test_samson`.`a_product` (`код`, `название`) 
			VALUES ('$art', '$name')
			;");

			$result = mysqli_query(
			$connect,		
			"INSERT INTO `test_samson`.`a_price` (`товар`, `тип цены`, `цена`) 
			VALUES ('$name', 'Базовая', '$priceBase'),
			('$name', 'Москва', '$priceMoscow')
			;");

		}
	};


	//Закрываем подключение к серверу БД
	mysqli_close($connect);
};

//Вызов функции
$a = 'samson1.xml';
importXml($a);
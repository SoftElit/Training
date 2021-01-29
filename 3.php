<?php
/*
Программа проверки и сохранения данных с помощью сериализации (родительский класс) и последующей загрузки сохраненных данных с помощью ансериализации (класс-наследник). 
*/

namespace Test3;
use Exception;							//Возможность ссылаться на внешнее абсолютное имя по псевдониму или импортированию - исправление ошибки, связанной с пространствами имен (Exception), подробнее https://stackoverflow.com/questions/10000539/php-exception-not-found
class newBase
{
	static private $count = 0;												//вспомогательная переменная (индекс/ключ массива $arSetName[])
    static private $arSetName = [];											//в этом массиве сохраняем данные (например, имена объектов), полученные от пользователя
    /**
     * @param string $name
     */
    //function __construct(int $name = 0)
    function __construct(string $name) 										//исправление типа параметра и убрал значение по-умолчанию
	{
        if (empty($name)) {													//если $name пуста
            while (array_search(self::$count, self::$arSetName) != false) { //пока есть ключ статичного свойства $count в массиве $arSetName (то есть, есть такой элемент в массиве)
                ++self::$count;												//инкрементируем ключ массива для перехода к следующей итерации цикла
            }
            $name = self::$count;											//сохраняем статичное свойство $count (индекс/ключ массива $arSetName[]) в переменной $name (для последующего сохранения в массиве имен $arSetName[])
        }
        $this->name = $name;												//присваиваем свойству $name текущего объекта значение полученное от пользователя в $name (например, наименование объекта)
		self::$arSetName[] = $this->name;									//и сохраняем это значение в массиве данных $arSetName[]
    }

    //private $name;
    protected $name;														// сменено на protected для использования в наследуемых классах

    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }
    protected $value;														//строка 44 и 255 - для хранения декодированных и несериализированных данных (используется как вспомогательная переменная для сохранения обрабатываемых данных)
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {																		
        $this->value = $value;												//записываем данные (string) в переменную $value, строка 38
    }
    /**
     * @return string
     */
    public function getSize()												//метод определения размера данных
    {
        $size = strlen(serialize($this->value));							//преобразуем данные ($this->value) в строковое бинарное представление для удобного хранения без нарушения типа и структуры и высчитываем длину строки
        //return strlen($size) + $size;
        return $size;														//исправление ошибки подсчета размера данных
    }
    public function __sleep()												//возвращает список сериализуемых полей (двойное подчеркивание означает, что функция вызывается неявно (при вызове объекта класса вызовется тоже))
    {
        //return ['value'];
        return ['value', 'name'];											//исправление, 'value' и 'name' - подразумеваются переменные того же класса, которому принадлежит данный метод 
    }
	
    /**
     * @return string
     */
    public function getSave(): string										//возвращает преобразованные (сериализованные) данные в форме строки
    {
        //$value = serialize($value);										//неверная ссылка
        $value = serialize($this->value);									//исправление неверной ссылки, сериализация для хранения или передачи значений PHP между скриптами без потери их типа и структуры
        // return $this->name . ':' . sizeof($value) . ':' . $value;		//исправление ниже, причины:
																			//sizeof($value) - потребует реализацию Countable, поэтому проще полностью переделать save и load
																			//также этот метод уповает на то, что в имени не будет :, иначе делиметр ломается. из-за этого уже приходится использовать сложный метод десериализации
        
		return json_encode(["name" => $this->name, "value" => $value]);		/* Пояснения к функции json_encode: 
																			json_encode (mixed $value , int $flags = 0 , int $depth = 512 ): string|false
																			Возвращает строку, содержащую JSON-представление для указанного value или false в случае возникновения ошибки.
																			value - значение, которое будет закодировано. Может быть любого типа, кроме resource.
																			flags - Битовая маска, составляемая из значений JSON_FORCE_OBJECT, JSON_HEX_QUOT, ... Смысл этих констант объясняется на странице JSON-констант. 
																			Функция работает только с кодировкой UTF-8.
																			depth - Устанавливает максимальную глубину. Должен быть больше нуля.
																			Пример: Ассоциативный массив всегда отображается как объект: {"foo":"bar","baz":"long"}
																			Другими словами - если не заданы дополнительные параметры, то разделитель будет в форме ':', 
																			если на входе ассоциативный массив 'key => value', то на выходе массив из объектов key:value ??? 
																			То есть на выходе получим в нашем случае - ["name":"$this->name", "value":"$value"] */
    }
    /**
     * @return newBase
     */
    static public function load(string $value): newBase						//загрузка ранее сохранённых данных - раскодировка (обратное преобразование json-сериализованной строки) и её сохранение
    {
        //$arValue = explode(':', $value);									//переделка под json, разбиваем строку $value на массив с элеменатами (разделитель ':')
        $arValue = json_decode($value, true);								/* Пояснения к функции json_decode:
																			Принимает закодированную в JSON строку и преобразует её в переменную PHP.
																			Возвращает данные json, преобразованные в соответствующие типы PHP. Значения true, false и null возвращаются как true, false и null соответственно. 
																			null также возвращается, если json не может быть преобразован или закодированные данные содержат вложенных уровней больше, чем указанный 
																			предел вложенности.
																			json - Строка (string) json для декодирования.
																			Эта функция работает только со строками в кодировке UTF-8.
																			associative - Если true, объекты JSON будут возвращены как ассоциативные массивы (array); если false, объекты JSON будут возвращены как 
																			объекты (object). Если null, объекты JSON будут возвращены как ассоциативные массивы (array) или объекты (object) в зависимости от того, 
																			установлена ли JSON_OBJECT_AS_ARRAY в flags.
																			depth - Максимальная глубина вложенности структуры, для которой будет производиться декодирование.
																			flags - Битовая маска из констант JSON_BIGINT_AS_STRING, JSON_INVALID_UTF8_IGNORE, JSON_INVALID_UTF8_SUBSTITUTE, JSON_OBJECT_AS_ARRAY, 
																			JSON_THROW_ON_ERROR. Поведение этих констант описаны на странице JSON-констант.
																			Другими словами - в нашем случае на выходе получим ассоциативный массив ["name" => $this->name, "value" => $value] */
        
		//return (new newBase($arValue[0]))									
        //    ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
        //        + strlen($arValue[1]) + 1), $arValue[1]));
        $deserialize = new newBase($arValue["name"]);						//создаем объект базового класса, передавая в конструктор в качестве параметра сохраненное в массиве имя объекта (сохраненные данные)
																			//чтобы после передать их другому объекту, для которого и производится загрузка
        $deserialize->setValue(unserialize($arValue["value"]));
        return $deserialize;
    }
}
class newView extends newBase
{
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     */
    public function setValue($value)										//определяет тип и размер указанного объекта 
    {
        parent::setValue($value);											//для сохранения свойства объекта - в данном случае ансериализованной строки
        $this->setType();													//определяем тип переменной, то есть переданного параметра - объект или 'test'
        $this->setSize();													//длина декодированной (ансериализованной) строки с/без учетом пространства имен 
    }
    public function setProperty($value)										//добавление пользовательских данных (переменная $property)
    {
        $this->property = $value;
        //return $this;														//архитектурная ошибка, так делают только при соблюдении паттерна BUILDER и лучше не злоупотреблять без необходимости
    }
	
    private function setType()												//определяет тип объекта 
    {
        //исправлено имя функции
        $this->type = gettypeInternal($this->value);						//исправлено имя функции
    }

    private function setSize()												//длина сериализованной строки с/без учетом пространства имен (Определяет длину строки родительского преобразованного значения $value)
    {
        if (is_subclass_of($this->value, "Test3\newView")) {				// Проверяет, содержит ли объект $this->value в своём дереве предков класс 'Test3\newView' либо прямо реализует его. 																			
            $this->size = parent::getSize() + 1 + strlen($this->property);	//добавляется длина строки свойства property текущего объекта.

        //} elseif ($this->type == 'test') {								//бессмысленно, т.к верхняя проверка делает то же самое - условие строки 142 равнозначно условию строки 145, потому что 245 строка в function gettypeInternal
        //    $this->size = parent::getSize();
        } else {
            //$this->size = strlen($this->value);
            $this->size = parent::getSize();								//тут ошибка - длина строки на объекте (уже ансериализованные данные), возможно лучше полностю поменять на getsize
        }
    }

    /**
     * @return string[]														//неправильный @return в комментах. был string, стал string[]
     */
    public function __sleep()												//добавляет свойство property в массив и возвращает список сериализуемых полей (двойное подчеркивание означает, что функция вызывается неявно (при вызове объекта класса вызовется тоже))
    {
        //return ['property'];
		$arr = parent::__sleep();											//исправление - вызываем метод класса-родителя
        array_push( $arr, 'property' );										//добавляем свойство в конец массива
        return $arr;
    }
    /**
     * @return string
     */
    public function getName(): string										//расширили родительский метод, добавив выброс исключения, если нет имени передаваемых пользователем данных (имя пустое). Возвращает имя объекта
    {
        if (empty($this->name)) {
            throw new Exception('The object doesn\'t have name');
        }
        return '"' . $this->name  . '": ';
    }
    /**
     * @return string
     */
    public function getType(): string										//возвращает тип объекта
    {
		return ' type ' . $this->type  . ';'; 																							
    }
	
    /**
     * @return string
     */
    public function getSize(): string										//возвращает размер объекта (данных)
    {																		//строка 49
        return ' size ' . $this->size . ';';
    }

    public function getInfo()												//вывод информации в браузер о результате обработки данных
    {
        try {
            echo $this->getName()											//получение имени рассматриваемого объекта либо уведомления, что имени нет
                . $this->getType()											//получение типа рассматриваемого объекта
                . $this->getSize()											//получение размера данных
                . "\r\n";
        } catch (Exception $exc) {
            echo 'Error: ' . $exc->getMessage() . "\n";						//ОБРАБОТКА ИСКЛЮЧЕНИЯ - ВЫВОД ОШИБКИ, ЧТО ИМЯ ПУСТОЕ
        }
    }
    /**
     * @return string
     */
    public function getSave(): string										//метод сохранения данных, строка 64	
																			/* добавляем в сериализованный архив (родительского метода) 3-й параметр (предварительно сериализовав его) и обрабатываем json_encode 
																			(для представления в формате "key":"value") */
    {
        //if ($this->type == 'test') {
        //    $this->value = $this->value->getSave();
        //}																	//непонятно, зачем цикличное сохранение при отсутствии цикличной загрузки
        //return parent::getSave() . serialize($this->property);			//должно разделяться ':' раз такой метод используется в десериализации
																			//лучше один дополнительный раз декодить, но save будет надежным
        $arr = json_decode(parent::getSave(), true);						//декодирование сохраняемых данных
        $arr["property"] = serialize($this->property);						//сериализация данных
        return json_encode($arr);											//возвращение json-представления данных
    }
    /**
     * @return newView
     */
    static public function load(string $value): newBase 					//функция загрузки данных (загружаем сохранённые данные в виде объекта newBase), 87 строка
    {
        //$arValue = explode(':', $value);
        //return (new newBase($arValue[0]))
        //    ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
        //        + strlen($arValue[1]) + 1), $arValue[1]))
        //    ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
        //        + strlen($arValue[1]) + 1 + $arValue[1])))
        //    ;
        $arValue = json_decode($value, true);								//исправление на json
        $deserialize = new newView($arValue["name"]);
        $deserialize -> setValue(unserialize($arValue["value"]));
        $deserialize -> setProperty(unserialize($arValue["property"]));		//десериализация всех сохранённых данных по каждому элементу массива

        return $deserialize;
    }
}

function gettypeInternal($value): string									//возвращает тип переданного параметра - объект или "test"
{																			//метод нужен для определения типа объекта в другом методе, подробнее - строка 137 и 178
    if (is_object($value)) {												//проверка, является ли переменная объектом
        $type = get_class($value);											//если да, то $type = имя класса данного объекта
																			/* get_class — Возвращает имя класса, к которому принадлежит объект,  
																			если параметр object является экземпляром класса, существующего в пространстве имён, то будет возвращено полное имя с указанием пространства имён.) */
        do {																//цикл с проверкой (содержит ли данный объект в своём дереве предков класс 'Test3\newView')
			//if (strpos($type, "Test3\newBase") !== false) {				//НЕ РАБОТАЕТ ПРОВЕРКА НАЛИЧИЯ ПРОСТРАНСТВА ИМЕН В ДЕРЕВЕ ПРЕДКОВ
			if (strpos($type, 'Test3\newBase') !== false) {					//исправление - поменял двойные кавычки на одинарные
                return 'test';
            }
        } while ($type = get_parent_class($type));							//get_parent_class - возвращает имя родительского класса для объекта или класса
    }
    return gettype($value);													//встроенная php-функция gettype — Возвращает тип переменной
}


$obj = new newBase('12345');												//создаём новый объект типа newBase, строка 8
$obj->setValue('text');														//сохраняем пользовательские данные (строчку 'text') в value, строка 42 (используем метод для сохранения свойства объекта в свойстве $value родительского класса newBase)

$obj2 = new \Test3\newView('O9876');										//задается имя объекта O9876, создаём новый объект типа newView (с указанием пространства имен Test3 - строка 245, строка 142)

$obj2->setValue($obj);														//строка 122 определяем тип и размер указанного объекта
$obj2->setProperty('field');												//строка 128 в класс-наследник (переменная $property) добавить свойство property(строку 'field'), чтобы потом добавить длину строки свойства property к длине строки свойства $value текущего объекта
$obj2->getInfo();															//строка 189 вызываем метод дочернего класса, отвечающий за вывод информации в браузер о результате обработки данных

$save = $obj2->getSave();													//строка 203 вызываем метод дочернего класса, отвечающий за сохранение данных, расширяющий метод родительского класса

$obj3 = newView::load($save);												//[%]строка 87, 219 вызываем метод дочернего класса, отвечающий за загрузку и декодирование (ансериализацию) ранее сохранённых данных

var_dump($obj2->getSave() == $obj3->getSave());								//проверка, одинаковы ли данные объектов $obj2 и $obj3 **сравнение сохраняемых данных из $obj2 с полученными после обработки и загруженными в $obj3

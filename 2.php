<?php
/*
Создать файл 2.php и в нем реализовать:


функцию convertString($a, $b). Результат ее выполнение: если в строке $a содержится 2 и более подстроки $b, то во втором месте заменить подстроку $b на инвертированную подстроку.
*/
function mb_strrev($string)
{
    $string = strrev(mb_convert_encoding($string, 'UTF-16LE', 'UTF-8'));
    return mb_convert_encoding($string, 'UTF-8', 'UTF-16BE');
	/* UTF-16LE меняем на UTF-16BE при инвертировании строки, чтобы имзенить маркер последовательности байтов в 2х-байтной кодировке символов:
	https://medium.com/@kozlova14/%D0%BE%D0%B1%D1%89%D0%B5%D0%B5-%D0%BF%D1%80%D0%B5%D0%B4%D1%81%D1%82%D0%B0%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5-%D0%BE-unicode-utf-8-utf-16-le-be-bom-65be4e13b57e 
	*/
}

//echo mb_strrev('☆❤world');

function convertString($a, $b)
{
	if(mb_substr_count($a, $b) >= 2) {
		$a = 
			strstr($a, $b, true) . 
			$b . 
			strstr(mb_substr(strstr($a, $b), mb_strlen($b)), $b, true) . 
			mb_strrev($b) . 
			mb_substr(strstr(mb_substr(strstr($a, $b), mb_strlen($b)), $b), mb_strlen($b));
		
		return $a;
	}
	
}

$a = 'Начало строки, иголка в стоге, середина строки, иголка в стоге, иголка в стоге, конец строки.';
$b = 'иголка в стоге';
//$a = 'Top of the line, a needle in a haystack, the middle of the string, a needle in a haystack, a needle in a haystack, the end of the line.';
//$b = 'a needle in a haystack';
//$a = '1, 123, середина строки, 123, 123, конец строки.';
//$b = '123';
echo convertString($a, $b);
echo '<br><br>';


/* функию mySortForKey($a, $b). $a – двумерный массив вида [['a'=>2,'b'=>1],['a'=>1,'b'=>3]], $b – ключ вложенного массива. 
Результат ее выполнения: двумерном массива $a отсортированный по возрастанию значений для ключа $b. 
В случае отсутствия ключа $b в одном из вложенных массивов, выбросить ошибку класса Exception с индексом неправильного массива. */
function mySortForKey($a, $b)
{
	foreach($a as $key => $inputArray) {
		if(!array_key_exists($b, $inputArray)) {
			throw new Exception(" Отсутствует ключ \"$b\" в массиве \"$key\"");
		}
	};
	
		usort($a, function($x1, $x2) use ($b) {
			return $x1[$b] <=> $x2[$b];
		});
		
		return $a;
};

$a = [['a' => 2,'b' => 1],['a' => 1,'b' => 3]];

try {
print_r(mySortForKey($a, 'a'));
} catch (Exception $e) {
    echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
};

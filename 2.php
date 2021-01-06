<?php
/*
Создать файл 2.php и в нем реализовать:
- функцию convertString($a, $b). Результат ее выполнение: если в строке $a содержится 2 и более подстроки $b, то во втором месте заменить подстроку $b на инвертированную подстроку.
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
		
		/*
		$a0 = strstr($a, $b, true); //'начало строки, '
		
		$strstr1 = strstr($a, $b); //'иголка в стоге, середина строки, иголка в стоге, конец строки'
		
		//$a1 = strstr(mb_substr($strstr1, mb_strlen($b)), $b, true); //', середина строки, '
		$a1 = strstr(mb_substr(strstr($a, $b), mb_strlen($b)), $b, true); //', середина строки, '
		
		$a2 = mb_strrev($b); //инвертирование строки 'иголка в стоге' (обратная последовательность символов)
		
		//$a3 = strstr(mb_substr($strstr1, mb_strlen($b)), $b); //'иголка в стоге, конец строки'
		$a3 = strstr(mb_substr(strstr($a, $b), mb_strlen($b)), $b); //'иголка в стоге, конец строки'
		
		//$a4 = mb_substr($a3, mb_strlen($b)); //', конец строки'
		$a4 = mb_substr(strstr(mb_substr(strstr($a, $b), mb_strlen($b)), $b), mb_strlen($b)); //', конец строки'
		
		//strstr(substr(strstr($a, $b), strlen($b)), );
		
		$a = $a0 . $b . $a1 . $a2 . $a4; //собираем/сохраняем полученные подстроки обратно в строку
		*/
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

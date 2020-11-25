<?php

// Автор: Звеков Алексей
// Алгоритм был создан на https://www.tutorialspoint.com/execute_php_online.php поэтому
// и запускать его надо по этой ссылке, в других PHP online редакторах не проверялся

// Алгоритм хорош тем что не выделяет лишней памяти, не использует всяких промежуточных
// буферов и нет конкатенаций (они RAM-прожорливые), в общем написан в старом стиле (Д. Кнут плюсует+)

// Дальше комменты будут на ангийском
// Посмотрите также мою С++ версию, она работает с ASCII, а PHP-версия с UNICODE
// Я код "зазиповал" (сделал компактным по выполнению и визуально) как мог, зато не выделяет
// память, и есть условия для оптимизации чтобы не делать лишнюю работу и не жечь
// миллисекунды CPU-времени

//------------------------------------------------------------------------------------------------------------------------------------------------
function revertCharacters($s) { // NOTE: UNICODE only
    $offset = 2; // because of UNICODE
    
	$size = strlen($s);

	if ($size<=$offset) { // ignore empty string or string with one chracter 
		return $s;
	}

	$pos1 = 0; $pos2 = 0;
	while($pos2 != $size) {

		$isFoundOrEnd = false;
		do {
			$pos2+=$offset;
			if ($pos2 != $size){
			    if ( $s[$pos2]==' ' || $s[$pos2]=='.' ||  $s[$pos2]==',' || $s[$pos2]=='!' || $s[$pos2]=='?' ) {
    				$pos2-=$offset;
    				
    				if ($s[$pos1]==$s[$pos2] ) {
    					$pos2+=$offset;
    					$pos1 = $pos2;
    					$pos1+=$offset;
    				} else {
    					$isFoundOrEnd = true;
    				}
			    }
			}else{
			    $pos2-=$offset;
    			$isFoundOrEnd = true;
			}
		}while (!$isFoundOrEnd);

		// Reversing chunk
		{
			$p1 = $pos1; $p2 = $pos2;

			while($p1<$p2){
				// swap characters within chunk
				$tmp    = $s[$p1];
				$s[$p1] = $s[$p2];
				$s[$p2] = $tmp;

				$p1+=$offset;
				$p2-=$offset;
			} 
		}

		// shift frame
		{
			$pos2+=$offset;
			$pos1 = $pos2;
			$pos1+=$offset;
		} 
	};
	return $s;
}

//------------------------------------------------------------------------------------------------------------------------------------------------
function main(){

	$texts = array(
    			// TEST #1 original test text
    			mb_convert_encoding("Привет! Давно не виделись.", 'UTF-16LE', 'UTF-8'), 
                // TEST #2 Check for many repating punctuation characters (?!., )
				mb_convert_encoding("Привет!...Давно не виделись, КОЗЁЛ!!!!! Что!!! Я???   Да!Ты, Лысый!!!Я тебя завалю! ",'UTF-16LE', 'UTF-8'),
                // TEST #3
				mb_convert_encoding("улыбок тебе дед макар! :)))",'UTF-16LE', 'UTF-8')  
				);	 
                
    echo "\n";
                
    foreach ($texts as $txt) {
        echo "-----------------------------------------------------------------------\n\n";
    	echo mb_convert_encoding($txt, "UTF-8", "UTF-16LE");

        echo "\n";
        $res = revertCharacters($txt);

	echo mb_convert_encoding($res, "UTF-8", "UTF-16LE");
        echo "\n";
        echo "\n";
    }
}

main();
?>

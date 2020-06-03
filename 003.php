<?php

/** drow `line` ;) */
function hr() {    echo "\n".str_repeat("_",55) . "\n";  }  # element estetyczny
/**
browse() is my version of displaying everything (almots)
@param mixed $a =wartość do wyświetlenia
@param int $method = 0|1|2 print_r, var_export, var_dump: default 1
@return not return
Example: browse($var); browse([$var1,$var2],0);
*/
function browse($a,$method=1) {
   hr();
   if ($method==2) {
      var_dump($a);
      return;
   }
   $m = ($method==1) ? "var_export" : "print_r";
   if (is_array($a) and count($a) and $method!=2) {
      while (true) {
         $e = current($a);
         if ($method==0)
            echo str_replace("\n"," ", key($a)."=>[".$m($e,true)."]");
         else
            echo str_replace("\n"," ", $m($e,true));
         if (next($a)!==FALSE) echo ", ";
         else {reset($a); break; }
      }
      echo "\n" . str_repeat("-",55);
   }
   else
      echo preg_replace("/[\n\r\f]+/"," ", $m($a,true)) . "\n" . str_repeat("-",55);
   echo "\n";
}
////////////////////////////////////////////////////////////////////////////////////
############################################################################
# 003 : stałe i magiczne stałe, napisy, wyrażenia regularne, obsługa tablic, data i czas
# https://www.php.net/manual/en/book.strings.php
# https://www.php.net/manual/en/book.pcre.php
# https://www.php.net/manual/en/book.datetime.php

#stałe
define("Const1",1);
define("Const2",[2,3]);
browse([Const1,Const2]); // moja funkcja wyświetlająca
echo __LINE__ . "\n" .
__FILE__ . "\n" . // 19 licząc od 0
__DIR__ . "\n";
function whyIsTheNameOfThisFunctionSoLong() {
   echo __FUNCTION__ . "\n\n";
}
whyIsTheNameOfThisFunctionSoLong();


# Napisy otrzymały znaczne wsparcie w PHP. Jest ogromna paleta funkcji, które można wykorzystać.
# Otrzymujemy również pełne wsparcie wyrażeń regularnych

browse(str_replace("a","o","rabarbar")); # podmiana
browse(strip_tags("<b>bold <i>and</i> bolder</b>")); # usuwa znaczniki HTML
echo strlen("How many?") . "\n";
echo strpos("Text of the day.","of") . "\n"; # pozycja znalezionego podciągu
echo substr("Text of the day",5,2) , "\n"; # podciąg "of"

parse_str("var0=5&var1=value",$out);  # tekst reprezentujący wartości -> zmienne
browse($out,0);

echo $var = join([1,"-",2,"-3"," z ar-ma-ty"]); # skleja elementy tablicy w napis
$var2 = explode (" ", $var); # rozbija napis na elementy tablicy na podstawie separatora
browse($var2);


# wyrażenia regularne
$var3 = "My phone is 89-987-654-321.";
preg_match("/(.*?)([\d-]+)/",$var3, $out); # szuka dopasowania, $out zawiera wyniki
browse($out,0);

browse(preg_replace("/(..)-(...)/","$2-$1","12-345")); # szuka wzorzec i zamienia

# Tablice również otrzymały smakowity zestaw wsparcia, wystarczy zerknąć na listę:
# https://www.php.net/manual/en/book.array.php

$ar1 = [1,2,3,4,5,6,7,8,9,10];
$ar2 = [1,2,3,4,5,60,70,80,90,100];
$ar3 = ["k1"=>"v1", "k2"=>"v2", "k3"=>1000];
echo count($ar1) , "\n"; # ile elementów
if (in_array(10,$ar1)) echo "true\n"; # test na obecność wartości
if (array_key_exists("k2",$ar3)) echo "true\n"; # test na obecność klucza
browse(array_intersect($ar1,$ar2)); # część wspólna
browse(array_keys($ar3)); # klucze bez wartości
browse(array_values($ar3)); # wartości bez kluczy
$ar4 = array_merge($ar1,$ar2); # złącz
usort($ar4,function($e1,$e2){ # sortuj
   return ($e1<=$e2); // malejący
});
browse($ar4);

krsort($ar3); # sort tablicy (wartości) poprzez posortowanie kluczy malejąco
browse($ar3);

# czas w PHP

$date = new DateTime(); // now!
echo $date->format('Y-m-d H:i:s'), "\n";
$int = new DateInterval("P1MT5H30M"); // [P]eriod 1 [M]onth, [T]ime: 5 [H]ours, 30 [M]inutes
echo $date->add($int)->format("Y-m-d H:i:s\n"); // przesuń do przodu
$date2 = new DateTime('2020-01-01 12:00:00');
echo date_diff($date2,$date)->format("%a"), "\n"; // %a - diff days
echo $E = date("Y-m-d H:i:s",0) , "\n"; // epoka (początek naliczania czasu)
$time = strtotime($D = '2020-01-01 18:00:30'); // ile sekund od epoki
echo $D, " is ", $time . " sec after $E\n"; //
$date = new DateTime('2000-01-20');
echo $date->format("Y-m-d");
$date->sub(new DateInterval('P1M10D')); // zabiera z daty 1 miesiąc i 10 dni, przesuń w tył
echo " - 1 month 10 days => " , $date->format('Y-m-d') . "\n";
$date->modify('+1 day +3 months'); # można i tak
echo $date->format("Y-m-d") , "\n";

?>





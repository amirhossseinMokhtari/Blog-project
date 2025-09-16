<?php
//$word='ایران';
//$codeSearch=urlencode($word);
//$baseUrl = 'https://www.tasnimnews.com/fa/search?query='.$codeSearch;
//\Illuminate\Support\Facades\Log::info($baseUrl);

require __DIR__ . '/vendor/autoload.php';

use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

function numFaTEn($string): string
{
    return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
}

//public function persianStringToDate($dateString)

$dateString = "۱۱ شهريور ۱۴۰۴ - ۱۴:۴۸";
$monthsArrayString = array("فروردین","اردیبهشت","خرداد","تیر","مرداد","شهريور","مهر","آبان","آذر","دی","بهمن","اسفند");
//$monthsArrayString = array('فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
$dataArrayString = explode(' ', $dateString);

$solarYear = numFaTEn($dataArrayString[2]);
$solaMonth = array_search($dataArrayString[1], $monthsArrayString) + 1;
$solaDay = numFaTEn($dataArrayString[0]);
$clock = numFaTEn($dataArrayString[4] . ':00');

//        $gregorian_date=$j_year.'-'.$j_month.'-'.$j_day;
$gregorianDate = CalendarUtils::toGregorian($solarYear, $solaMonth, $solaDay);
$dateTime=$gregorianDate[0].'-'.$gregorianDate[1].'-'.$gregorianDate[2]. ' ' . $clock;
$x = 5;



//echo $timestamp;





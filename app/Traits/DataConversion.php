<?php

namespace App\Traits;

use Morilog\Jalali\CalendarUtils;

trait DataConversion
{

    private function numberFaToEn($string): string
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
    }

    public function persianStringToDate($dateString)
    {
//        $dateString='۲۶ مرداد ۱۴۰۴ - ۱۰:۳۰';
        $monthsArrayString = array('فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
        $dataArrayString = explode(' ', $dateString);
        $solarYear = $this->numberFaToEn($dataArrayString[2]);
        $solaMonth = array_search($dataArrayString[1], $monthsArrayString) + 1;
        $solaDay = $this->numberFaToEn($dataArrayString[0]);
        $clock = $this->numberFaToEn($dataArrayString[4] . ':00');
        $gregorianDate = CalendarUtils::toGregorian($solarYear, $solaMonth, $solaDay);
        $dateTime = $gregorianDate[0] . '-' . $gregorianDate[1] . '-' . $gregorianDate[2] . ' ' . $clock;
        return $dateTime;
    }

}


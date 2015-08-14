<?php

class Custom_Date
{
    static $errorMessage = 'O formato da data deve ser YYYY-MM-dd';

    private static function validateDate($date, $format = 'Y-m-d'){
        try{
            $d = DateTime::createFromFormat($format, $date);
            if (!$d){
                throw new Exception(self::$errorMessage);
            }
        }catch (Exception $ex){
            echo $ex->getMessage();
            exit();
        }
    }

    private static function dateTimeFactory($date, $validate = true){
        if ($validate){
            self::validateDate($date);
        }

        $dateTime = new DateTime($date);
        return $dateTime;
    }

    public static function diffInDays($date1, $date2){
        $dateTime1 = self::dateTimeFactory($date1);
        $dateTime2 = self::dateTimeFactory($date2);

        $diff = $dateTime1->diff($dateTime2);
        return $diff->days;
    }

    public static function subtract($date, $days, $format = 'Y-m-d'){
        $dateTime = self::dateTimeFactory($date);
        $resultDate = $dateTime->sub(new DateInterval('P'.$days.'D'));

        return $resultDate->format($format);
    }

    public static function sum($date, $days, $format = 'Y-m-d'){
        $dateTime = self::dateTimeFactory($date);
        $resultDate = $dateTime->add(new DateInterval('P'.$days.'D'));

        return $resultDate->format($format);
    }

    private static function makeDateByTimestamp($timestamp, $format = 'Y-m-d'){
        return date($format, $timestamp);
    }

    public static function isFeriado($date){
        $dia = 86400; // dois dias

        $feriados = array();
        $year = date('Y');

        $pascoaTime = easter_date($year);

        $feriados['confraternizacao'] = $year.'-01-01';
        $feriados['sextaSanta'] = self::makeDateByTimestamp($pascoaTime-(2*$dia));
        $feriados['carnaval'] = self::makeDateByTimestamp($pascoaTime-(47*$dia));
        $feriados['corpusChristi'] = self::makeDateByTimestamp($pascoaTime+(60*dia));
        $feriados['pascoaTime'] = self::makeDateByTimestamp($pascoaTime);
        $feriados['tiradentes'] = $year.'-04-21';
        $feriados['trabalho'] = $year.'-05-01';
        $feriados['independencia'] = $year.'-09-07';
        $feriados['nossaSenhora'] = $year.'-10-12';
        $feriados['finados'] = $year.'-11-02';
        $feriados['republica'] = $year.'-11-15';
        $feriados['natal'] = $year.'-12-25';

        foreach ($feriados as $feriado){
            if ($date == $feriado){
                return true;
            }
        }

        return false;
    }

    private function convertDateToTimestamp($date, $format = '%Y-%m-%d'){
        $dateTime = self::dateTimeFactory($date);
        return $dateTime->getTimestamp();
    }

    public static function isWeekend($date){
        $str = explode('-', $date);
        $dateTimestamp = self::convertDateToTimestamp($date);

        $dateWeek = date('w', $dateTimestamp);

        if ($dateWeek == 0 || $dateWeek == 6){
            return true;
        }
        return false;
    }

    public static function isUsefulDay($date){
        if (self::isWeekend($date) || self::isFeriado($date)){
            return false;
        }
        return true;
    }

    public static function countUsefulDays($dateStart, $dateEnd){
        $intervalDays = self::diffInDays($dateStart, $dateEnd);
        $auxDate = $dateStart;

        $dateStart = self::dateTimeFactory($dateStart);
        $dateEnd = self::dateTimeFactory($dateEnd);

        $countUseful = 0;

        for ($i = 0; $i <= $intervalDays; $i++){
            if (self::isUsefulDay($auxDate)){
                $countUseful++;
            }
            $auxDate = self::sum($auxDate, 1);
        }

        return $countUseful;
    }

    public static function showFormatBr($date){
        $str = explode('-',$date);
        $year = $str[0];
        $month = $str[1];
        $day = $str[2];

        return $formatDate = $day.'/'.$month.'/'.$year;
    }

    public static function makeFirstDayMonth($date){
        $str = explode('-',$date);
        $year = $str[0];
        $month = $str[1];
        $day = 01;

        return $formatDate = $year.'-'.$month.'-'.$day;
    }

    public static function makeFirstDayDateByMonthYear($month, $year){
        $day = 01;

        return $formatDate = $year.'-'.$month.'-'.$day;
    }

    public static function makeLastDayDateByMonthYear($month, $year){
        $day = 31;
        return $formatDate = $year.'-'.$month.'-'.$day;
    }

    public static function makeLastDayMonth($date){
        $str = explode('-',$date);
        $year = $str[0];
        $month = $str[1];
        $day = 31;

        return $formatDate = $year.'-'.$month.'-'.$day;
    }

    public static function showMonthString($month){
        switch($month){
            case '01':
                return 'Janeiro';
            case '02':
                return 'Fevereiro';
            case '03':
                return 'Março';
            case '04':
                return 'Abril';
            case '05':
                return 'Maio';
            case '06':
                return 'Junho';
            case '07':
                return 'Julho';
            case '08':
                return 'Agosto';
            case '09':
                return 'Setembro';
            case '10':
                return 'Outubro';
            case '11':
                return 'Novembro';
            case '12':
                return 'Dezembro';
        }
    }

    public static function formatDefault($date){
        $str = explode('/', $date);

        $year = $str[2];
        $month = $str[1];
        $day = $str[0];

        return $formatDate =$year.'-'.$month.'-'.$day;
    }
}
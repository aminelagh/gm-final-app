<?php
/*
Helper pour le gerer les dates
*/


use Carbon\Carbon;

// retourn date simple
if (!function_exists('getDateSimple')) {
    function getDateSimple($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($value)));
        return $date->day . "/" . $date->month . "/" . $date->year . " -> " . $date->dayOfWeek;
    }
}

// permet de donner une date a partir d un timestamps from db
if (!function_exists('getDateHelper')) {
    function getDateHelper($value)
    {
        //$date = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($value)));
        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($value)));

        switch ($date->dayOfWeek) {
            case '1':
                $J = 'Lundi';
                break;
            case '2':
                $J = 'Mardi';
                break;
            case '3':
                $J = 'Mercredi';
                break;
            case '4':
                $J = 'Jeudi';
                break;
            case '5':
                $J = 'Vendredi';
                break;
            case '6':
                $J = 'Samedi';
                break;
            case '0':
                $J = 'Dimanche';
                break;
            default:
                $J = 'Le';
        }

        switch ($date->month) {
            case '01':
                $M = 'janvier';
                break;
            case '02':
                $M = 'février';
                break;
            case '03':
                $M = 'mars';
                break;
            case '04':
                $M = 'avril';
                break;
            case '05':
                $M = 'mai';
                break;
            case '06':
                $M = 'juin';
                break;
            case '07':
                $M = 'juillet';
                break;
            case '08':
                $M = 'août';
                break;
            case '09':
                $M = 'septembre';
                break;
            case '10':
                $M = 'octobre';
                break;
            case '11':
                $M = 'novembre';
                break;
            case '12':
                $M = 'décembre';
                break;
            default:
                $M = '/ ' . $date->month . ' /';
        }
        return $J . " " . $date->day . " " . $M . " " . $date->year;
    }
}

// permet de donner une l'heur a partir d un timestamps from db
if (!function_exists('getTimeHelper')) {
    function getTimeHelper($value)
    {
        $date = Carbon::createFromFormat('H:m:s', date('H:m:s', strtotime($value)));
        return $date->hour . ":" . $date->minute;//.":".$date->second;
    }
}

if (!function_exists('getLongDateHelper')) {
    function getLongDateHelper($value)
    {
        //$date = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($value)));
        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($value)));

        switch ($date->dayOfWeek) {
            case '1':
                $J = 'Lundi';
                break;
            case '2':
                $J = 'Mardi';
                break;
            case '3':
                $J = 'Mercredi';
                break;
            case '4':
                $J = 'Jeudi';
                break;
            case '5':
                $J = 'Vendredi';
                break;
            case '6':
                $J = 'Samedi';
                break;
            case '0':
                $J = 'Dimanche';
                break;
            default:
                $J = 'Le';
        }

        switch ($date->month) {
            case '01':
                $M = 'janvier';
                break;
            case '02':
                $M = 'février';
                break;
            case '03':
                $M = 'mars';
                break;
            case '04':
                $M = 'avril';
                break;
            case '05':
                $M = 'mai';
                break;
            case '06':
                $M = 'juin';
                break;
            case '07':
                $M = 'juillet';
                break;
            case '08':
                $M = 'août';
                break;
            case '09':
                $M = 'septembre';
                break;
            case '10':
                $M = 'octobre';
                break;
            case '11':
                $M = 'novembre';
                break;
            case '12':
                $M = 'décembre';
                break;
            default:
                $M = '/ ' . $date->month . ' /';
        }
        return $J . " " . $date->day . " " . $M . " " . $date->year;
    }
}

if (!function_exists('getShortDateHelper')) {
    function getShortDateHelper($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($value)));

        //return $date->toDateTimeString();
        if ($date->day < 10)
            $day = "0" . $date->day;
        else $day = $date->day;

        if ($date->month < 10)
            $month = "0" . $date->month;
        else $month = $date->month;

        return $day . "/" . $month . "/" . $date->year;

    }
}

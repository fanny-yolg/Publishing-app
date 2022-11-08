<?php

function dayOfProgrammer($year) {
    if($year < 1700 && $year > 2700)
        return false;

    $leapYear = false;
    if($year == 1918) {
        return "26.09.1918";
    } else if($year < 1918) {
        if($year % 4 === 0) $leapYear = true;
    } else {
        if($year % 400 === 0) 
            $leapYear = true;
        else if($year % 4 === 0 && $year % 100 != 0) $leapYear = true;
    }

    if($leapYear)
        return "12.09." . $year;
    else return "13.09." . $year;
}

echo(dayOfProgrammer(1916)).PHP_EOL;
echo(dayOfProgrammer(1800)).PHP_EOL;
echo(dayOfProgrammer(1918)).PHP_EOL;
echo(dayOfProgrammer(2016)).PHP_EOL;
echo(dayOfProgrammer(2012)).PHP_EOL;
echo(dayOfProgrammer(2017)).PHP_EOL;
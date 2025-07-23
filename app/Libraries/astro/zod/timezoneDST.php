<?php



$date = new DateTime('1978-09-07 14:30', new DateTimeZone('Europe/Madrid'));
var_dump((bool) $date->format('I')); // returns false


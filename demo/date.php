<?php
ini_set('display_errors',1);

use Carbon\Carbon;
use Jtar\Utils\Utils\Date;


require '../vendor/autoload.php';
require '../src/Utils/Date.php';

$date = new Date();

$at1 = '2023-01-12 23:30:00';


var_dump($date->getDayHours($at1,false));

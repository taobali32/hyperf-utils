<?php
ini_set('display_errors',1);

use Carbon\Carbon;
use Jtar\Utils\Utils\Date;


require '../vendor/autoload.php';
require '../src/Utils/Date.php';

use Jxlwqq\IdValidator\IdValidator;

$idValidator = new IdValidator();

var_dump($idValidator->fakeId());
<?php
require_once "../vendor/autoload.php";

use ShubhamGupta16\LaraliteCore\LaraliteCore;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');

LaraliteCore::serve();
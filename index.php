<?php

use App\App;

require 'vendor/autoload.php';

$app = new App();
$app->identificarController();
$app->executarController();
<?php
require_once __DIR__ . '/../vendor/autoload.php';
use azolee\DS18B20;

$respone =  DS18B20::loadSensors();

var_dump($respone);

<?php
require_once __DIR__ . '/../vendor/autoload.php';
use azolee\DS18B20;
use azolee\DataFormat\CelsiusDataProcessor;

$dataProcessor = new CelsiusDataProcessor();
$dataProcessor->setPrecision(3);

$respone =  DS18B20::loadSensors($dataProcessor);

var_dump($respone);

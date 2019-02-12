<?php
require_once __DIR__ . '/vendor/autoload.php';
use azolee\DS18B20;

$data =  DS18B20::loadSensors();

header('Content-type: application/json');
echo json_encode( $data );

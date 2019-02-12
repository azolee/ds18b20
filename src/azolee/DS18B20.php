<?php
namespace azolee;

use azolee\Contracts\SenzorDataProcessor;

class DS18B20
{
    protected const SENSORS_LIST_FILE_NAME = "/sys/bus/w1/devices/w1_bus_master1/w1_master_slaves";
    protected static $dataProcessor;
    protected static $microTimeGetAsFloat = true;

    public static function loadSensors(SenzorDataProcessor $senzorDataProcessor = null)
    {
        if($senzorDataProcessor) {
            self::setProcessor($senzorDataProcessor);
        }
        $sensors = self::loadSensorList();

        $response = [];

        foreach($sensors as $sensor){
            $response[$sensor] = self::sensor($sensor);
        }

        if(self::$dataProcessor){
            return self::$dataProcessor->getData($response);
        }
        return $response;

    }

    public static function loadSensorList()
    {
        $result = [];

        if(file_exists(self::SENSORS_LIST_FILE_NAME)){
            $result = file(self::SENSORS_LIST_FILE_NAME);
        }

        array_walk($result, function(&$item){

            $item = trim($item);

        });

        return $result;
    }

    public static function sensor($sensor): array
    {
        $sensorFile = "/sys/bus/w1/devices/".$sensor."/w1_slave";

        $sensorHandle = fopen($sensorFile, "r");
        $sensorReading = fread($sensorHandle, filesize($sensorFile));
	    $time = microtime(self::$microTimeGetAsFloat);
	    fclose($sensorHandle);

        preg_match("/t=(.+)/", preg_split("/\n/", $sensorReading)[1], $matches);

        return [$matches[1], $time];
    }

    public static function setProcessor(SenzorDataProcessor $senzorData)
    {
        self::$dataProcessor = $senzorData;
    }

    public static function setMicrotimeFormatToFloat(bool $format)
    {
        self::$microTimeGetAsFloat = $format;
    }
}

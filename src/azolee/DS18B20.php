<?php
namespace azolee;

use azolee\Contracts\SenzorDataProcessor;

class DS18B20
{
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
        $folders = glob('/sys/bus/w1/devices/w1_bus_master*', GLOB_ONLYDIR);

        $result = [];

        foreach($folders as $bus){
            $local = [];

            if(file_exists($bus.'/w1_master_slaves')){
                $local = file($bus.'/w1_master_slaves');
            }

            array_walk($local, function(&$item){
                $item = trim($item);
            });

            $result = array_merge($result, $local);
        }

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

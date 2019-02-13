# A Simple DS18B20 Sensor Handling PHP Package

This package can be used to read the popular DS18B20 Sensor data from multiple sensors on a Raspberry PI.

Tested on Raspibian OS.

Note: Previously the Raspibian needs to be configured to handle the sensor. 


## Example usage (See _tests_ folder)

###Read the raw data:
```php
use azolee\DS18B20;

$respone =  DS18B20::loadSensors();

var_dump($respone);
```

###Read the raw data and process it:


```php
use azolee\DS18B20;
use azolee\DataFormat\{CelsiusDataProcessor, FahrenheitDataProcessor};


//in Celsius
$celsiusDataProcessor = new CelsiusDataProcessor();
$celsiusDataProcessor->setPrecision(3);

$respone =  DS18B20::loadSensors($celsiusDataProcessor);

var_dump($respone);


// in Fahrenheit
$fahrenheitDataProcessor = new FahrenheitDataProcessor();
$fahrenheitDataProcessor->setPrecision(0);

DS18B20::setProcessor($fahrenheitDataProcessor);

$respone =  DS18B20::loadSensors();

var_dump($respone);

```


License: **MIT**

Author: **ANDRAS Zoltan Gyarfas**

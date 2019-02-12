<?php
/**
 * Creator: Zoli
 * Date: 12/02/2019
 * Time: 21:58
 */
namespace azolee\DataFormat;

use DateTime;
use azolee\Contracts\SenzorDataProcessor;

class CelsiusDataProcessor implements SenzorDataProcessor
{
    protected $_precision = 2;

    public function getData($data){

        $response = [];

        foreach ($data as $key => $value){

            $celsius = round($value[0] / 1000, $this->_precision);

            $t = $value[1];
            $micro = sprintf("%06d",($t - floor($t)) * 1000000);
            $date = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

            $response[$key] = ['celsius'=>$celsius,'date'=>$date->format('Y-m-d H:i:s.v')];
        }

        return $response;

    }

    public function setPrecision($precision)
    {
        $this->_precision = intval($precision);
    }

}
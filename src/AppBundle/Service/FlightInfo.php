<?php
/**
 * Created by PhpStorm.
 * User: dupouy
 * Date: 18/06/18
 * Time: 11:50

 */

namespace AppBundle\Service;

    class FlightInfo
    {
        /**
         * @var string
         */
        private $unit;

        /**
         * constructor
         *
         * @param string $unit config in config.yml
         */
        public function __construct($unit)
        {
            $this->unit = $unit;
        }
        /**
         * Distance calculation between latitude/longitude based on Harnive's formula
         * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
         *
         * @param float $latitudeFrom Departure
         * @param float $longitudeFrom Departure
         * @param float $latitudeTo Arrival
         * @param float $longitudeTo Arrival
         *
         * @return float
         */
        public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo,
                                    $longitudeTo)
        {
            $d = 0;
            $earth_radius = 6371;
            $dLat = deg2rad($latitudeTo - $latitudeFrom);
            $dLon = deg2rad($longitudeTo - $longitudeFrom);

            $a = sin($dLat / 2) * sin($dLat / 2)
                + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo))
                * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * asin(sqrt($a));

            switch ($this->unit) {
                case 'km':
                    $d = $c * $earth_radius;
                    break;
                case 'mi':
                    $d = $c * $earth_radius / 1.609344;
                    break;
                case 'nmi':
                    $d = $c * $earth_radius / 1.852;
                    break;
            }

            return $d;
        }

        /**
         * @return string
         */
        public function getUnit()
        {
            return $this->unit;
        }

        /**
         * @param string $unit
         */
        public function setUnit($unit)
        {
            $this->unit = $unit;
        }

}
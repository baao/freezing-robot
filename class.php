<?php
class Weather {

    var $url;

    var $json;

    var $ch;

    var $result;

    var $run;

    var $hourly;

    var $daily;

    public function __construct($api_key, $coordinates, $date, $options = array()) {


        $checkdate = new DateTime($date);

        $this->url  = 'https://api.forecast.io/forecast/';
        $this->url .= $api_key.'/';
        $this->url .= $coordinates;

        if ($date) {

            $this->url .= ','.$checkdate->getTimestamp();

        }

        if ($options) {

            $this->url .= '?';
            foreach ($options as $a => $v) {
                $b = $a.'='.$v.'&';
                $this->url .= $b;

            }

            $this->url = rtrim($this->url, "&");

        }

        $this->ch = curl_init($this->url);


        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $this->result = curl_exec($this->ch);
        curl_close($this->ch);



        $this->json = (json_decode($this->result));


    }

    public function getPureResult() {


        return $this->result;


    }


    public function getResult ()
    {


        return $this->json;

    }


    public function getCurrentWeather() {


        $a = $this->json->currently;

        return $a;

    }

    public function getHourlyForecast () {

        $this->hourly = $this->json->hourly->data;

        return $this->hourly;


    }

    public function getDailyForecast() {

        $this->daily = $this->json->daily;

        return $this->daily->data[0];
    }

    public function getHourlyForecastForHour($hour) {

        return $this->json->hourly->data[$hour];

    }

}

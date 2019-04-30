<?php

    class OpenWeather {

        private  $apiKey;

        public function __construct(string $apiKey)
        {
            $this->apiKey = $apiKey;
        }

      public function  getToday(string $city): ?array{


          $data = $this->callAPI("weatger?q={$city}");

          $data = json_decode($data, true);

              return [
                  'temp' => $data['main']['temp'],
                  'description' => $data['weather'][0]['description'],
                  'date' => new DateTime()

              ];
      }


        public function getForecast(string $city): ?array
        {

            $url = $this->callAPI("forecast?q={$city}");
            $data = $url;
            foreach($data['list'] as $day){
                $result[] = [
                    'temp' => $day['main']['temp'],
                    'description' => $day['weather'][0]['description'],
                    'date' => new DateTime(('@'. $day['dt']))

                ];
            }

            return $result;
        }

        private  function  callAPI(string $endpoint): ?array
        {

            $curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}&appid={$this->apiKey}");
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CAINFO => __DIR__ .DIRECTORY_SEPARATOR. 'cert.cer',
                CURLOPT_TIMEOUT => 1
            ]);

            $data = curl_exec($curl);
            if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200){
                var_dump(curl_error($curl));
                return null;
            }
            $result = [];
            return json_decode($data, true);

        }

    }




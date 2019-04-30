<?php


    require_once  'apiClass/OpenWeather.php';
    $weather = new OpenWeather('55a46059ad1d12814583eafcd8111142');
    $forecast = $weather->getForecast('Metz');
    $today = $weather->getToday('Metz');
?>

<div class ="container">
    <ul>
        <li>En ce moment <?= $today['description'] ?> <?= $today['temp'] ?>°C</li>
        <?php
        foreach ($forecast as $day):?>
            <li> <?= $day['date']->format('d/m/y') ?> <?= $day['description'] ?> <?= $day['temp'] ?>°C </li>
        <?php endforeach  ?>

    </ul>
</div>




//
//	$curl = curl_init('http://api.openweathermap.org/data/2.5/weather?q=Metz,fr&APPID=55a46059ad1d12814583eafcd8111142&unit=metric&lang=fr');
//	curl_setopt_array($curl,[
//	    CURLOPT_CAINFO => __DIR__ .DIRECTORY_SEPARATOR. 'cert.cer',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_TIMEOUT => 1
//    ]);
//
//   $data = curl_exec($curl);
//    if ($data === false){
//        var_dump(curl_error($curl));
//    } else {
//        if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
//            $data = json_decode($data, true);
//
//            echo 'Il fera' .$data['main']['temp']. '°C';
//
//        }
//
//    }
//        curl_close($curl);

<?php

// работающий файл в rent скопировал - раотать в нем

//https://samples.openweathermap.org/data/2.5/weather?q=London,uk&appid=439d4b804bc8187953eb36d2a8c26a02

//https://samples.openweathermap.org/data/2.5/weather?id=2172797&appid=439d4b804bc8187953eb36d2a8c26a02

//API_keys
//dd557c0a5510b230fcae8b0b8a8b1fbc

// мой запрос и ID для данного примера в строке
// https://api.openweathermap.org/data/2.5/weather?id=625144&appid=dd557c0a5510b230fcae8b0b8a8b1fbc&units=metric&lang=en

// $c = file_get_contents(
//     'https://api.openweathermap.org/data/2.5/weather?id=625144&appid=dd557c0a5510b230fcae8b0b8a8b1fbc&units=metric&lang=en'
// );

//$c = file_get_contents('https://www.google.by');
// echo $c;

echo "<pre>";

 print_r(stream_get_wrappers());

function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

 echo curl_get_contents('https://www.google.by/');

// $data = [
//     'id' => 625144,
//     'APPID' => 'dd557c0a5510b230fcae8b0b8a8b1fbc',
//     'units' => 'metric',
//     'lang' => 'en',
// ];

// $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);
// $curl = curl_init('https://api.openweathermap.org/data/2.5/weather');
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
// // Принимаем в виде массива. (false - в виде объекта)
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
//     'Content-Length: ' . strlen($data_string),
// ]);
// $result = curl_exec($curl);
// curl_close($curl);
// echo '<pre>';
// print_r($result);

// print_r($data);

// $url = 'https://api.openweathermap.org/data/2.5/weather';

// $options = [
//     'id' => 625144,
//     'APPID' => 'dd557c0a5510b230fcae8b0b8a8b1fbc',
//     'units' => 'metric',
//     'lang' => 'en',
// ];

// //инициация запроса
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($options));

// $response = curl_exec($ch);

// $data = json_decode($response, true);

// curl_close($ch);

// // распаковка запроса в JSON формат - предобразовал для себя...
// $newArray = [];

// foreach ($data as $key => $value) {
//     if (!is_array($value)) {
//         echo $key . ':' . $value . '<br>';
//         $newArray[$key] = $value;
//     } elseif (is_array($value)) {
//         foreach ($value as $key => $value) {
//             if (!is_array($value)) {
//                 echo $key . ':' . $value . '<br>';
//                 $newArray[$key] = $value;
//             } else {
//                 foreach ($value as $key => $value) {
//                     echo $key . ':' . $value . '<br>';
//                     $newArray[$key] = $value;
//                 }
//             }
//         }
//     }
// }

// echo '<br>';
// echo '<pre>';
// print_r($newArray);

// echo '<br>';
// echo '<pre>';
// print_r($data);

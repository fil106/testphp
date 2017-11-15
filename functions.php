<?php

//генерируем post-запрос
function sendPost($api, $arr, $action) {
    if($api == "yandex") {

        $myCurl = curl_init('https://geocode-maps.yandex.ru/1.x/');

        foreach ($arr as $key => $val) {
            curl_setopt_array($myCurl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array('format'=>'json', 'geocode'=>'Выборг, ' . $val))
            ));

            $result[] = json_decode(curl_exec($myCurl), true);
        }

        //ловим ошибки
        if ($result === false) {
            var_dump('Curl error: ' . curl_error($myCurl));
        }

        curl_close($myCurl);

        return $result;

    } elseif ($api == "zabbix") {
        if ($action == "host") {

            $data = array(
                "jsonrpc" => "2.0",
                "method" => "host.get",
                "params" => array(
                    "output" => array(
                        "hostid",
                        "host",
                        "name")),
                "id" => 2,
                "auth" => 'd444eb51d616652f37295eb975482147');

            // генерируем cURL
            $myCurl = curl_init('https://isp.vbg.ru/zabbix/api_jsonrpc.php');
            curl_setopt_array($myCurl, array(
                CURLOPT_POST => TRUE,                       //говором что это пост-запрос
                CURLOPT_RETURNTRANSFER => TRUE,             //возвращаем ответ, а не выводим в браузер
                CURLOPT_HTTPHEADER => array(                //загаловки
                    'Content-Type: application/json-rpc'
                ),
                CURLOPT_POSTFIELDS => json_encode($data),   //переменные, в данном случае json массив
                CURLOPT_SSL_VERIFYPEER => 0,                //если поставить его в 0, то удалённый сервер не будет проверять наш сертификат. В противном случае необходимо этот самый сертификат послать.
                CURLOPT_SSL_VERIFYHOST => 0                 //будет ли производиться проверка имени удалённого сервера, указанного в сертификате. Если установить значение «2», то будет произведена ещё и проверка соответствия имени хоста. (если честно, я так и не понял что делает этот флаг)
            ));

            //отправка запроса
            $result[] = json_decode(curl_exec($myCurl), true);

            //ловим ошибки
            if ($result === false) {
                var_dump('Curl error: ' . curl_error($myCurl));
            }

            curl_close($myCurl);

            return $result;

        }
    }
}


function getHost($arr) {
    $res[] = array();
    foreach ($arr as $key => $val) {
        if ($key == "name") {
            $res[] = $val;
        }
    }
    return $res;
}

//получаем координаты точки
function getPosition($arr) {
    $result[] = array();
    for ($i=0;$i<count($arr);$i++) {
        $result[] = $arr[$i][response][GeoObjectCollection][featureMember][0][GeoObject][Point][pos];
    }
    return $result;
}
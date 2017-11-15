<?php

    //запрос на получение hostов с zabbixа
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
    $ch = curl_init('https://isp.vbg.ru/zabbix/api_jsonrpc.php');
    curl_setopt_array($ch, array(
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
    $resultPOST = curl_exec($ch);

    //ловим ошибки
    if($resultPOST === false)
    {
        var_dump('Curl error: ' . curl_error($ch));
    }

    print_r($resultPOST);
?>
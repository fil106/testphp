<?php

//класс zabbix
class Zabbix {

    private $login;
    private $pass;

    function __construct($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;
    }

    function getAuth() {
        $result = array();

        $data = array(
            "jsonrpc" => "2.0",
            "method" => "user.login",
            "params" => array(
                "user" => $this->login,
                "password" => $this->pass),
            "id" => 1,
            "auth" => null
        );

        $myCurl = curl_init('https://isp.vbg.ru/zabbix/api_jsonrpc.php');

        curl_setopt_array($myCurl, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array('content-type: application/json-rpc'),
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE
        ));

        $result = json_decode(curl_exec($myCurl), true);

        if ($result === false) {
            var_dump('Curl error: ' . curl_error($myCurl));
        }

        curl_close($myCurl);

        return $result[result];

    }

    function getHosts() {
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
        $arr[] = json_decode(curl_exec($myCurl), true);

        //ловим ошибки
        if ($arr === false) {
            var_dump('Curl error: ' . curl_error($myCurl));
        }

        curl_close($myCurl);

        foreach ($arr as $key => $value) {

        }

        return $result;
    }

}
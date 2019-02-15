<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apiactcul {

    private $urlApi = "http://api-ac.local/api/";
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXBpLWFjLmxvY2FsL2FwaS9sb2dpbiIsImlhdCI6MTU0ODYxMzk4NSwiZXhwIjoxNTQ4NzAwMzg1LCJuYmYiOjE1NDg2MTM5ODUsImp0aSI6IkNQb1dmeUtoeTRySktVZGUiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.pmq_2Go5hjLnlfCMDOCepqALR3BFDocZ_gbZuMX4FgY";
    private $headers = array();
    public function __construct() {
        $this->headers = array(
            'Content-type: application/json',
            'Authorization: Bearer ' . $this->token,
        );
    }

    public function addTeacher($data) {
        $curlHandle = curl_init($this->urlApi . "teacher");
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data));
        $execResult = curl_exec($curlHandle);
        return $execResult;
    }
}

?>
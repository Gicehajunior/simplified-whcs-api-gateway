<?php

class WhcsGateway {
    private $domain_url;
    private $domain_port;
    private $cpanel_username;
    private $cpanel_password;

    public function __construct($domain_url, $domain_port = 2083, $cpanel_username, $cpanel_password)
    {
        $this->domain_url = $domain_url;
        $this->domain_port = $domain_port;
        $this->cpanel_username = $cpanel_username;
        $this->cpanel_password = $cpanel_password ? md5($cpanel_password) : null;
    }

    public function api_call($param_array_object = []) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->domain_url . ':' . $this->domain_port);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            http_build_query($param_array_object)
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function getClients($search_q = null, $responsetype = null, $limitstart = null, $limitnum = null, $sorting = null, $status = null, $orderby = null) {
        $param_array_object = array(
            'action' => 'GetClients',
            'username' => $this->cpanel_username,
            'password' => $this->cpanel_password,
            'search' => $search_q,
            'responsetype' => $responsetype,
            'limitstart' => $limitstart,
            'limitnum' => $limitnum,
            'sorting' => $sorting,
            'status' => $status,
            'orderby' => $orderby
        );

        $response = $this->api_call($param_array_object);

        return $response;
    }
}


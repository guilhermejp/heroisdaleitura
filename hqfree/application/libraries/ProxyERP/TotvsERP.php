<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class TotvsERP implements IProxyERP
{
    private $api = "";

    function __construct($dataApi) 
    {
        $this->api = $dataApi;  
    }

    //TODO: Implement interface
}
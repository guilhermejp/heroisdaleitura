<?php
defined('BASEPATH') OR exit('No direct script access allowed');

interface IProxyERP
{
    public function GetAllClientByRepresentative($codeERP);
    public function GetAllAddressByClient($codeERP);
    public function GetAllConditionsByClient($codeERP);
    public function GetAllContaCorrenteByClient($codeERP);
    public function GetAllShippingCompanyByClient($codeERP);
    public function GetAllFinalityByClient($codeERP);
    public function GetAllPriceByProduct($codeERP);
    public function GetStatusPurchaseOrder($codeERP);        
    public function SendRequest($representativeID,$clientCode,$finality,$conditions,$address,$district,$city,$zipcode,$clientCPFCNPJ,$clientStateRegister,$typeDelivery,$shippingcompany,$totalDelivery,$jsonItens,$accountID,$natoper, $purchaseorder, $valorresgate);
    public function SavePurchaseOrderBI($purchaseorder);
    public function SavePurchaseOrderItemBI($purchaseorderitemload);
    public function SaveNewClientBI($account); 
}


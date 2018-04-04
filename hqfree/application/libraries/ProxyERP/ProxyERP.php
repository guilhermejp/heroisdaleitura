<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once(LIBRARIES_PATH . "/ProxyERP/IProxyERP.php");
include_once(LIBRARIES_PATH . "/ProxyERP/ProxyResource.php");
include_once(LIBRARIES_PATH . "/ProxyERP/LogixERP.php");
//include_once(LIBRARIES_PATH . "/ProxyERP/TotvsERP.php");

class ProxyERP implements IProxyERP
{
    const LOGIX  = "LOGIX";
    const TOTVS  = "TOTVS";

    //--> Property by configurantion
    private $erp    = NULL;
    //private $api    = NULL;
   

    function __construct() 
    {
        
    }

    public function InitializeContext($erpName, $dataApi)
    {
        switch($erpName)
        {
            case self::LOGIX :
                $this->erp = new LogixErp($dataApi);
                //$this->api = $dataApi;
                break;
            case self::TOTVS :
                $this->erp = new LogixErp($dataApi);
                $this->api = $dataApi;
                break;
            default:
                throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);                
                break;
        }
    }
    
    public function GetAllClientByRepresentative($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllClientByRepresentative($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetAllAddressByClient($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllAddressByClient($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetAllConditionsByClient($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllConditionsByClient($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetAllFinalityByClient($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllFinalityByClient($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }
    
    public function GetAllContaCorrenteByClient($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllContaCorrenteByClient($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetAllShippingCompanyByClient($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllShippingCompanyByClient($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetAllPriceByProduct($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetAllPriceByProduct($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function GetStatusPurchaseOrder($codeERP)
    {
        $result = NULL; 
        
        if(isset($this->erp) && $codeERP != NULL)
        {
            $result = $this->erp->GetStatusPurchaseOrder($codeERP);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function SendRequest($representativeID,$clientCode,$finality,$conditions,$address,$district,$city,$zipcode,$clientCPFCNPJ,$clientStateRegister,$typeDelivery,$shippingcompany,$totalDelivery,$jsonItens,$accountID, $natoper, $purchaseorder,$valorresgate)
    {
        $result = NULL; 
        
        if(isset($this->erp))
        {
            $result = $this->erp->SendRequest($representativeID,$clientCode,$finality,$conditions,$address,$district,$city,$zipcode,$clientCPFCNPJ,$clientStateRegister,$typeDelivery,$shippingcompany,$totalDelivery,$jsonItens,$accountID,$natoper, $purchaseorder, $valorresgate);
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function SavePurchaseOrderBI($purchaseOrder)
    {
        $result = NULL; 
        
        if(isset($this->erp))
        {
            if(isset($purchaseOrder)) 
            { 
                $result = $this->erp->SavePurchaseOrderBI($purchaseOrder);
            }
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }

    public function SavePurchaseOrderItemBI($purchaseorderitemload)
    {
        $result = NULL; 
        
        if(isset($this->erp))
        {
            if(isset($purchaseorderitemload)) 
            { 
                $result = $this->erp->SavePurchaseOrderItemBI($purchaseorderitemload);
            }
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }
    
    public function SaveNewClientBI($account) 
    {
        $result = NULL; 
        
        if(isset($this->erp))
        {
            if(isset($account)) 
            { 
                $result = $this->erp->SaveNewClientBI($account);
            }
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
        
        return $result;
    }
}


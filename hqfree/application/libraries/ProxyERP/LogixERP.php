<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class LogixERP implements IProxyERP
{
    const POST   = "POST";
    private $api = NULL;
    
    
    function __construct($dataApi) 
    {
        if($dataApi != NULL)
        {
            $this->api = $dataApi[0];  
        }
        else throw new Exception(ProxyResource::ERROR_ERP_NOT_INFORMED);
    }

    public function GetToken()
    {   
        $result = NULL;    

        if($this->api != NULL)
        {          
            $data  = array("login" => $this->api->username, "senha" => $this->api->password);                   
            $obj = $this->CommunicationAPI('renewToken', self::POST, $data);   

            if($obj != NULL && $obj->codigoErro == 0)
            {
                $result = TRIM($obj->token);
            }else{
                show_error("Problema na validação do Token!");
            }       
        }
        return $result;
    }

    public function GetAllClientByRepresentative($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "codrepres" => $codeERP); 

        $obj = $this->CommunicationAPI('clientes', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->clientes; 
        }else{
            show_error("Problema ao selecionar informações do cliente!");
        } 
        
        return  $result;
    }

    public function GetAllAddressByClient($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "id" => $codeERP); 

        $obj = $this->CommunicationAPI('clientes/endereco', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->enderecos; 
        }else{
            show_error("Problema ao consultar o endereço do cliente no ERP!");
        } 
        
        return  $result;
    }

    public function GetAllConditionsByClient($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "id" => $codeERP); 

        $obj = $this->CommunicationAPI('condicoes', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->condicoes; 
        }else{
            show_error("Problema ao consultar as condições de pagamento do Cliente!");
        } 
        
        return  $result;
    }

    public function GetAllShippingCompanyByClient($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "codCliente" => $codeERP); 

        $obj = $this->CommunicationAPI('transportadora', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->clientes; 
        }else{
            show_error("Problema ao consultar as Transportadoras do Cliente!");
        } 
        
        return  $result;
    }

    public function GetAllFinalityByClient($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "id" => $codeERP); 

        $obj = $this->CommunicationAPI('finalidades', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->finalidades; 
        }else{
            show_error("Problema ao consultar Finalidades do Cliente!");
        } 
        
        return  $result;
    }
    
    public function GetAllContaCorrenteByClient($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "id" => $codeERP); 

        $obj = $this->CommunicationAPI('contacorrente', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->contacorrente; 
        }else{
            show_error("Cliente não possui informações de Conta Corrente!");
        } 
        
        return  $result;
    }
    
    public function GetAllTaxesByOrder($order_number)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "pedido" => $codeERP); 

        $obj = $this->CommunicationAPI('impostos', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->impostos; 
        }else{
            show_error("Erro ao receber os impostos!");
        } 
        
        return  $result;
    }

    public function GetAllPriceByProduct($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "item" => $codeERP); 

        $obj = $this->CommunicationAPI('preco', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->quantidade; 
        }else{
            show_error("Erro ao consultar produto!");
        }  
        
        return  $result;
    }

    public function GetStatusPurchaseOrder($codeERP)
    {
        $result = NULL;  

        $token = $this->GetToken();
        $data  = array("token" => $token, "pedidos" => "[{'numPedido':$codeERP, 'status':''}]"); 

        $obj = $this->CommunicationAPI('getStatusPedido', self::POST, $this->FormatArraySendApi($data));  

        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj->pedidos[0]; 
        }else{
            show_error("Erro ao consultar status do pedido!");
        }  
        
        return  $result;
    }

    public function SendRequest($representativeID,$clientCode,$finality,$conditions,$address,$district,$city,$zipcode,$clientCPFCNPJ,$clientStateRegister,$typeDelivery,$shippingcompany,$totalDelivery,$jsonItens,$accountID, $natoper, $purchaseorder, $valorresgate)
    {
        $result = NULL;  
        $token = $this->GetToken();        
        $data = array(
                "token"             => $token,	    		                   
                "codRepres"         => $representativeID,
                "usuario"           => $accountID,
                "codCliente"        => $clientCode,
                "finalidade"        => $finality,
                "condicaoPagamento" => $conditions,
                "enderecoEntrega"   => $address,
                "bairro"            => $district,
                "codCidade"         => $city,
                "codCep"            => $zipcode,   
                "numCGC"            => $clientCPFCNPJ,
                "numInsEst"         => $clientStateRegister, 
                "tipoEntrega"       => $typeDelivery,
                "codTransportadora" => $shippingcompany,
                "natoper"           => $natoper,
                "totalFrete"        => $totalDelivery,
                "itens"             => $jsonItens,
                "ordemcompra"       => $purchaseorder,
                "valorbenef"        => $valorresgate,
            
        );

        $obj = $this->CommunicationAPI('finalizaPedido', self::POST, $this->FormatArraySendApi($data));  
        /*
        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj; 
        } 
        */
        //return  $result;
        return $obj;
    }

    public function SavePurchaseOrderBI($purchaseorder)
    {
        $result = NULL;  
        $token = $this->GetToken();        
        $data = array(
            "token"                         => $token,	    	
            "parameters"                    => json_encode($purchaseorder, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)	    	
            // "accountid"                     => $purchaseOrder->accountid,
            // "clientid"                      => $purchaseOrder->clientid,
            // "clienterp"                     => $purchaseOrder->clienterp,
            // "requestcode"                   => $purchaseOrder->requestcode,
            // "finality"                      => $purchaseOrder->finality,
            // "conditions"                    => $purchaseOrder->conditions,
            // "address"                       => $purchaseOrder->address,
            // "addressnumber"                 => $purchaseOrder->addressnumber,
            // "complement"                    => $purchaseOrder->complement,
            // "district"                      => $purchaseOrder->district,
            // "zipcode"                       => $purchaseOrder->zipcode,
            // "countryname"                   => $purchaseOrder->countryname,
            // "stateabbreviation"             => $purchaseOrder->stateabbreviation,
            // "city"                          => $purchaseOrder->city,
            // "deliverytype"                  => $purchaseOrder->deliverytype,
            // "subtotal"                      => $purchaseOrder->subtotal,
            // "freight"                       => $purchaseOrder->freight,
            // "total"                         => $purchaseOrder->total,
            // "dateadded"                     => $purchaseOrder->dateadded,
            // "status"                        => $purchaseOrder->status,
            // "dateupdate"                    => $purchaseOrder->dateupdate,
            // "userupdate"                    => $purchaseOrder->userupdate,
            // "clientname"                    => $purchaseOrder->clientname,
            // "shippingcompanyerp"            => $purchaseOrder->shippingcompanyerp,
            // "deliverydays"                  => $purchaseOrder->deliverydays,
            // "stage"                         => $purchaseOrder->stage,
            // "clientcpfcnpf"                 => $purchaseOrder->clientcpfcnpf,
            // "finalityname"                  => $purchaseOrder->finalityname,
            // "conditionname"                 => $purchaseOrder->conditionname,
            // "transactioncode"               => $purchaseOrder->transactioncode,
            // "representativeid"              => $purchaseOrder->representativeid,
            // "natoper"                       => $purchaseOrder->natoper,
            // "preorder"                      => $purchaseOrder->preorder,
            // "representativeld"              => $purchaseOrder->representativeld,
            // "valorresgate"                  => $purchaseOrder->valorresgate,
            // "percentagediscountcondition"   => $purchaseOrder->percentagediscountcondition,
            // "valuediscountcondition"        => $purchaseOrder->valuediscountcondition,
            // "valueipi"                      => $purchaseOrder->valueipi,
            // "valueicmsst"                   => $purchaseOrder->valueicmsst,
            // "clientpurchaseorder"           => $purchaseOrder->clientpurchaseorder,
            // "clientmail"                    => $purchaseOrder->clientmail,
            // "pendingapprove"                => $purchaseOrder->pendingapprove	                   
        );
        
        $obj = $this->CommunicationAPI('setPedidoBI', self::POST, $this->FormatArraySendApi($data));  
        
        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj; 
        } 
        
        //return  $result;
        return $obj;
    }

    public function SavePurchaseOrderItemBI($purchaseorderitemload)
    {
        $result = NULL;  
        $token = $this->GetToken();
        $data = array(
            "token"                         => $token,	    	
            "parameters"                    => json_encode($purchaseorderitemload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)	    	
        );
        $obj = $this->CommunicationAPI('setPedidoItemBI', self::POST, $this->FormatArraySendApi($data));  
        
        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj; 
        } 
        
        //return  $result;
        return $obj;
    }

    public function SaveNewClientBI($account)
    {
        $result = NULL;  
        $token = $this->GetToken();        
        $data = array(
            "token" => $token,	    	
            "parameters" => json_encode($account, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)	    	                
        );
    
        $obj = $this->CommunicationAPI('setClientePortal', self::POST, $this->FormatArraySendApi($data));  
        
        if($obj != NULL && $obj->codigoErro == 0)
        {            
            $result = $obj; 
        } 
        
        //return  $result;
        return $obj;
    }

    private function FormatArraySendApi($data)
    {
        $result = NULL;

        if(is_array($data))
        {
            $result = http_build_query($data);
        }

        return $result;
    }


    private function CommunicationAPI($endpoint, $method, $data)
    {
        $result = NULL;
        $pathURL = $this->api->urli . $endpoint;                
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pathURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);

        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if((int)$response_code == 200)
        {
            $result = json_decode($output);
        }
        else show_error("Informação não encontrada no ERP para este registro!");
        //else throw new Exception($output);
        
        return $result;
    }
}

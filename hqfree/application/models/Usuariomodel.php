<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuarioModel extends ModelBase 
{    

    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$USUARIO['model']);
    }

    public function GetUsuarioByEmail($email=null)
    {
        $rows = NULL;                    			

        $this->db->select("p.*");                

        if(Tools::IsValid($email)){
            $this->db->where(array('p.email' => $email));
        }        
        
        $result = $this->db->get($this->GetDefaultTable(). ' AS p');
        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetUsuarioByFacebookID($idfacebook)
    {
        $rows = NULL;                    			

        $this->db->select("p.*");                
        $this->db->where(array('p.id_facebook' => $idfacebook));        
        $result = $this->db->get($this->GetDefaultTable(). ' AS p');        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
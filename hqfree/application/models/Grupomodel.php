<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GrupoModel extends ModelBase 
{    

    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$GRUPO['model']);
    }

    public function GetByNome($nome)
    {
        $rows = NULL;                    			
        
        $sql =  "SELECT * FROM grupo where nome_grupo like '%".$nome."%'";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
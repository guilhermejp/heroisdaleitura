<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EditoraModel extends ModelBase 
{    

    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$EDITORA['model']);
    }



    public function GetByNome($nome)
    {
        $rows = NULL;                    			
        
        $sql =  "SELECT * FROM editora where nome = '".$nome."'";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
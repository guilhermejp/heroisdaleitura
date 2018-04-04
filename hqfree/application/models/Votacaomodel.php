<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VotacaoModel extends ModelBase 
{    
    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$VOTACAO['model']);
    }

    public function GetVote($idusuario, $idrevista)
    {
        
        $sql = "SELECT * FROM votacao WHERE id_usuario = ".$idusuario." AND id_revista = ".$idrevista;                

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result()[0];     
            return $rows;
        }else{
            return NULL;
        }
    }
}
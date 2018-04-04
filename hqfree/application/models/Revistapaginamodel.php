<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RevistapaginaModel extends ModelBase 
{    
    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$REVISTAPAGINA['model']);
    }

    public function GetTotalCapitulos($idrevista, $capitulo=null)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.id_revista, r.capitulo, count(*) as total_paginas ".                      
               "FROM revistapagina as r ".                
               "WHERE r.id_revista = ". $idrevista;

        if($capitulo != null && $capitulo != 0) {
            $sql = $sql." AND r.capitulo = ".$capitulo;
        }
               
        $sql = $sql." GROUP BY 1, 2 ";               


        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetCapitulosByRevista($idrevista)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.*".                      
               "FROM revistapagina as r ".                
               "WHERE r.ordem = 0 and r.id_revista = ". $idrevista." ORDER BY r.capitulo";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }


    public function GetCapitulos($idrevista, $capitulo)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.*".                      
               "FROM revistapagina as r ".                
               "WHERE r.capitulo = ".$capitulo." and r.id_revista = ". $idrevista." ORDER BY r.ordem";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LeituraModel extends ModelBase 
{    
    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$LEITURA['model']);
    }

    public function GetLeituraPorRevista($idusuario, $idrevista, $capitulo)
    {
        
        $sql = "SELECT * FROM leitura WHERE id_usuario = ".$idusuario." AND id_revista = ".$idrevista." AND capitulo = ".$capitulo;                

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result()[0];     
            return $rows;
        }else{
            return NULL;
        }
    }

    public function GetHistLeitura($idusuario)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.titulo, l.capitulo, r.id as id_revista, l.ordem, l.data ".
               "FROM leitura l ". 
               "INNER JOIN revista r ON (l.id_revista = r.id AND r.ativo = 1) ". 
               "INNER JOIN revistapagina pag  ON (r.id = pag.id_revista AND pag.capitulo = l.capitulo AND pag.ordem = l.ordem) ". 
               "WHERE l.id_usuario = ". $idusuario;             

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
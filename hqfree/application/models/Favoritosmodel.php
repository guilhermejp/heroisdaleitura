<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FavoritosModel extends ModelBase 
{    
    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$FAVORITOS['model']);
    }

    public function GetRegistroFavorito($idusuario, $idrevista)
    {
        
        $sql = "SELECT * FROM favoritos WHERE id_usuario = ".$idusuario." AND id_revista = ".$idrevista;

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result()[0];     
            return $rows;
        }else{
            return NULL;
        }
    }

    public function GetFavoritos($idusuario)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.titulo, r.status, r.id, ".                      
               "CASE WHEN pag.capitulo IS NULL THEN sum(0) ELSE count(IFNULL(pag.capitulo, 0)) END as total_capitulos ".
               "FROM revista as r ". 
               "INNER JOIN favoritos e  ON (e.id_revista = r.id AND e.id_usuario = ".$idusuario.") ". 
               "INNER JOIN revistapagina pag  ON (r.id = pag.id_revista AND pag.ordem = 0) ". 
               "WHERE r.ativo = 1 GROUP BY 1, 2, 3 ";             

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
}
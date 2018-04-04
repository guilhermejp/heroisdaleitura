<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RevistaModel extends ModelBase 
{    

    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$REVISTA['model']);
    }

    public function GetRevistaById($idrevista=null, $ordem=null, $capitulo=null)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.*, alb.capitulo as numero, alb.ordem, alb.arquivo, ".
               "IFNULL(e.nome, 'N/A') as nome_editora, IFNULL(g.nome_grupo, 'N/A') nome_grupo, IFNULL(g.url_grupo, '#') as url_grupo ".
               "FROM revista as r ".
               "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista) ".
               "LEFT JOIN editora e  ON (e.id = r.id_editora) ". 
               "LEFT JOIN grupo   g  ON (g.id = r.id_grupo) ". 
               "WHERE r.ativo = 1 AND r.id = ".$idrevista;
        
        if($ordem != null){
            $sql = $sql." AND alb.ordem = ".$ordem;
        }

        if($capitulo != null){
            $sql = $sql." AND alb.capitulo = ".$capitulo;
        }
        
        $sql = $sql." ORDER BY alb.ordem ASC, alb.capitulo ";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetRevistaVisalGeral($idrevista)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.*, ".
               "IFNULL(e.nome, 'N/A') as nome_editora, IFNULL(g.nome_grupo, 'N/A') nome_grupo, IFNULL(g.url_grupo, '#') as url_grupo ".
               "FROM revista as r ".
               "LEFT JOIN editora e  ON (e.id = r.id_editora) ". 
               "LEFT JOIN grupo   g  ON (g.id = r.id_grupo) ". 
               "WHERE r.ativo = 1 AND r.id = ".$idrevista;               
        

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRevitaOrderByViews()
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.id, r.titulo, r.views, r.ativo, ". 
                      "alb.arquivo AS capa, ". 
                      "sum(IFNULL(vote.voto,0)) AS soma_votos, ". 
                      "count(vote2.voto) AS total_votos ". 
                "FROM revista as r ". 
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (select min(capitulo) from revistapagina where id_revista = r.id) )  ". 
                "LEFT JOIN votacao vote  ON  (r.id = vote.id_revista) ". 
                "LEFT JOIN votacao vote2  ON (r.id = vote2.id_revista) ". 
                "WHERE r.ativo = 1 AND r.views IS NOT NULL AND r.views > 0 ". 
                "GROUP BY 1, 2, 3, 4, 5 ORDER BY r.views DESC, r.titulo LIMIT 10 ";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRevitaOrderByVote()
    {
        $rows = NULL;                    			
    
        $sql = "SELECT r.id, r.titulo, r.views, r.ativo, ". 
                      "alb.arquivo AS capa, ". 
                      "sum(IFNULL(vote.voto,0)) AS soma_votos, ". 
                      "count(vote2.voto) AS total_votos ". 
                "FROM revista as r ". 
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (select min(capitulo) from revistapagina where id_revista = r.id) )  ". 
                "LEFT JOIN votacao vote  ON  (r.id = vote.id_revista) ". 
                "LEFT JOIN votacao vote2  ON (r.id = vote2.id_revista) ". 
                "WHERE r.ativo = 1 AND r.views IS NOT NULL AND r.views > 0 ". 
                "GROUP BY 1, 2, 3, 4, 5 HAVING COUNT(vote2.voto) > 0 ORDER BY 6 DESC, 7 DESC LIMIT 10 ";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRevitaOrderByDate()
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.id, r.titulo, alb.arquivo AS capa ".
                "FROM revista as r ". 
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (select min(capitulo) from revistapagina where id_revista = r.id) )  ". 
                "WHERE r.ativo = 1 ". 
                "GROUP BY 1, 2, 3 ORDER BY r.data DESC LIMIT 10";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRevista($idusuario=0)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.id, r.titulo, 1 as numero, ". 
                      "r.data, r.views, r.ativo, r.id_editora, ". 
                      "CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg'  END AS capa, ". 
                      "sum(IFNULL(vote.voto,0)) AS soma_votos, ". 
                      "count(vote2.voto) AS total_votos, count(alb.capitulo) AS numero_final, ".
                      "CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END AS eh_favorito ".
                " FROM revista as r ". 
                "LEFT JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (select min(capitulo) from revistapagina where id_revista = r.id)) ". 
                "LEFT JOIN votacao vote  ON  (r.id = vote.id_revista) ". 
                "LEFT JOIN votacao vote2  ON (r.id = vote2.id_revista) ".              
                "LEFT JOIN favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = ".$idusuario.") ";            

        $sql = $sql." WHERE r.ativo = 1 ". 
                "GROUP BY 1, 2, 3, 4, 5, 6, 7, 8 ORDER BY r.titulo";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetRevistas()
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.titulo, IFNULL(e.nome, 'N/A') as nome_editora, r.status, IFNULL(g.nome_grupo, 'N/A') as nome_grupo, r.id, r.ativo, ".                      
               "CASE WHEN pag.capitulo IS NULL THEN sum(0) ELSE count(IFNULL(pag.capitulo, 0)) END as total_capitulos ".
               "FROM revista as r ". 
               "LEFT JOIN editora e  ON (e.id = r.id_editora) ". 
               "LEFT JOIN grupo   g  ON (g.id = r.id_grupo) ". 
               "LEFT JOIN revistapagina pag  ON (r.id = pag.id_revista AND pag.ordem = 0) ". 
               "WHERE r.ativo = 1 GROUP BY 1, 2, 3, 4, 5, 6";               

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetRevistaByFilro($titulo=null, $editora=null, $ordem=null, $idusuario=0)
    {
        $rows = NULL;                    			
        
        $sql = "SELECT r.id, r.titulo, 1 AS numero, ". 
                      "r.data, r.views, r.ativo, r.id_editora, ". 
                      "alb.arquivo AS capa, ". 
                      "sum(IFNULL(vote.voto,0)) AS soma_votos, ". 
                      "count(vote2.voto) AS total_votos, MAX(alb.capitulo) AS numero_final, ". 
                      "CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END AS eh_favorito ".
                "FROM revista as r ". 
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (SELECT MAX(capitulo) FROM revistapagina pg WHERE pg.id_revista = r.id)) ". 
                "LEFT JOIN votacao vote  ON  (r.id = vote.id_revista) ". 
                "LEFT JOIN votacao vote2  ON (r.id = vote2.id_revista) ".                 
                "LEFT JOIN favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = ".$idusuario.") ".  
                "WHERE r.ativo = 1 ";

        if($titulo != null){
            $sql = $sql." AND r.titulo LIKE '%".$titulo."%' ";
        }

        if($editora != null && $editora != 0) {
            $sql = $sql." AND r.id_editora = ".$editora;
        }
        
        $sql = $sql." GROUP BY 1, 2, 3, 4, 5, 6, 7, 8";

        if($ordem != null) {
            $sql = $sql." ORDER BY ".$ordem;
        }else{
            $sql = $sql." ORDER BY r.titulo";
        }

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

}
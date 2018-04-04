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
        
        $sql = "SELECT r.*,
                       IFNULL(e.nome, 'N/A') as nome_editora, IFNULL(g.nome_grupo, 'N/A') nome_grupo, IFNULL(g.url_grupo, '#') as url_grupo
                  FROM revista as r
                  LEFT JOIN editora e  ON (e.id = r.id_editora) 
                  LEFT JOIN grupo   g  ON (g.id = r.id_grupo) 
                 WHERE r.ativo = 1 AND r.id = $idrevista";
        

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
        
        $sql = "select r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora,
                       capitulos.cap_min numero,capitulos.cap_max numero_final,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos, 
                       IFNULL(sum(v.voto),0) total_votos,
                       sum(r.views) views
                  from revista r
                  join (select id_revista, min(capitulo) cap_min, max(capitulo) cap_max
                          from revistapagina rp
                         group by id_revista) capitulos ON capitulos.id_revista = r.id
                  left join favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = 0)
                  left join votacao v ON (r.id = v.id_revista)  
                  join revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = capitulos.cap_max)  
                 where r.ativo = 1
                 group by r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min,capitulos.cap_max,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END,
                       IFNULL(v.voto,0), CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END 
              order by r.views desc
              limit 10";

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
    
        $sql = "select r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora,
                       capitulos.cap_min numero,capitulos.cap_max numero_final,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos, 
                       IFNULL(sum(v.voto),0) total_votos,
                       sum(r.views) views
                  from revista r
                  join (select id_revista, min(capitulo) cap_min, max(capitulo) cap_max
                          from revistapagina rp
                         group by id_revista) capitulos ON capitulos.id_revista = r.id
                  left join favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = 0)
                  left join votacao v ON (r.id = v.id_revista)  
                  join revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = capitulos.cap_max)  
                 where r.ativo = 1 AND r.views IS NOT NULL AND r.views > 0 
                 group by r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min,capitulos.cap_max,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END,
                       IFNULL(v.voto,0), CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END 
                having COUNT(v.voto) > 0
                 order by soma_votos desc, total_votos desc
                 limit 10";

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
        
        $sql = "select r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min numero,capitulos.cap_max numero_final,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos, 
                       IFNULL(sum(v.voto),0) total_votos
                  from revista r
                  join (select id_revista, min(capitulo) cap_min, max(capitulo) cap_max
                          from revistapagina rp
                         group by id_revista) capitulos ON capitulos.id_revista = r.id
                  left join favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = $idusuario)
                  left join votacao v ON (r.id = v.id_revista)  
                  join revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = capitulos.cap_max)  
                 where r.ativo = 1
                 group by r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min,capitulos.cap_max,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END,
                       IFNULL(v.voto,0), CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END 
              order by r.titulo";

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function getMain($idusuario=0)
    {
        $rows = NULL;                         
        
        $sql = "select r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min numero,capitulos.cap_max numero_final,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos, 
                       IFNULL(sum(v.voto),0) total_votos
                  from revista r
                  join (select id_revista, min(capitulo) cap_min, max(capitulo) cap_max, max(data),@row_num := @row_num + 1 as row_number
                          from revistapagina rp
                         group by id_revista
                         order by 4 desc, 1
                         limit 15) capitulos ON capitulos.id_revista = r.id
                  left join favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = $idusuario)
                  left join votacao v ON (r.id = v.id_revista)  
                  join revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = capitulos.cap_max)  
                 where r.ativo = 1
                 group by r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min,capitulos.cap_max,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END,
                       IFNULL(v.voto,0), CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END 
              order by capitulos.row_number";

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
        $where = null;
        $order = null;

        if($titulo != null){
            $where .= " AND r.titulo LIKE '%".$titulo."%' ";
        }

        if($editora != null && $editora != 0) {
            $where .= " AND r.id_editora = ".$editora;
        }

        if($ordem != null) {
            $order = " ORDER BY $ordem";
        }else{
            $order = " ORDER BY r.titulo";
        }

        $sql = "select r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min numero,capitulos.cap_max numero_final,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos, 
                       IFNULL(sum(v.voto),0) total_votos
                  from revista r
                  join (select id_revista, min(capitulo) cap_min, max(capitulo) cap_max
                          from revistapagina rp
                         group by id_revista) capitulos ON capitulos.id_revista = r.id
                  left join favoritos fav  ON (r.id = fav.id_revista AND fav.id_usuario = $idusuario)
                  left join votacao v ON (r.id = v.id_revista)  
                  join revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = capitulos.cap_max)  
                 where r.ativo = 1 $where
                 group by r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
                       capitulos.cap_min,capitulos.cap_max,
                       CASE WHEN fav.id_revista IS NOT NULL THEN 1 ELSE 0 END,
                       IFNULL(v.voto,0), CASE WHEN alb.arquivo IS NOT NULL THEN alb.arquivo ELSE 'sem_imagem.jpg' END 
              $order";

        

        $result = $this->db->query($sql);     

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

}
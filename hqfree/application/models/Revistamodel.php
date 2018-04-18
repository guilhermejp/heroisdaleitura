<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RevistaModel extends ModelBase {

    function __construct() {
        parent::__construct(DBGroup::MASTER_STORE, Model::$REVISTA['model']);
    }

    public function GetRevistaById($idrevista = null, $ordem = null, $capitulo = null) {
        $rows = NULL;

        $sql = "SELECT r.*, alb.capitulo as numero, alb.ordem, alb.arquivo, " .
                "IFNULL(e.nome, 'N/A') as nome_editora, IFNULL(g.nome_grupo, 'N/A') nome_grupo, IFNULL(g.url_grupo, '#') as url_grupo " .
                "FROM revista as r " .
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista) " .
                "LEFT JOIN editora e  ON (e.id = r.id_editora) " .
                "LEFT JOIN grupo   g  ON (g.id = r.id_grupo) " .
                "WHERE r.ativo = 1 AND r.id = " . $idrevista;

        if ($ordem != null) {
            $sql = $sql . " AND alb.ordem = " . $ordem;
        }

        if ($capitulo != null) {
            $sql = $sql . " AND alb.capitulo = " . $capitulo;
        }

        $sql = $sql . " ORDER BY alb.ordem ASC, alb.capitulo ";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetRevistaVisalGeral($idrevista) {
        $rows = NULL;

        $sql = "SELECT r.*,
                       IFNULL(e.nome, 'N/A') as nome_editora, IFNULL(g.nome_grupo, 'N/A') nome_grupo, IFNULL(g.url_grupo, '#') as url_grupo
                  FROM revista as r
                  LEFT JOIN editora e  ON (e.id = r.id_editora) 
                  LEFT JOIN grupo   g  ON (g.id = r.id_grupo) 
                 WHERE r.ativo = 1 AND r.id = $idrevista";


        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetAllRevitaOrderByViews() {
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

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetAllRevitaOrderByVote() {
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

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetAllRevitaOrderByDate() {
        $rows = NULL;

        $sql = "SELECT r.id, r.titulo, alb.arquivo AS capa " .
                "FROM revista as r " .
                "INNER JOIN revistapagina alb  ON (r.id = alb.id_revista AND alb.ordem = 0 AND alb.capitulo = (select min(capitulo) from revistapagina where id_revista = r.id) )  " .
                "WHERE r.ativo = 1 " .
                "GROUP BY 1, 2, 3 ORDER BY r.data DESC LIMIT 10";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetAllRevista($idusuario = 0) {
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

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function getMain($idusuario = 0) {
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

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function getMain2($idusuario = 0) {
        $rows = NULL;
        $retorno = array();

        // Seleciona todos os capítulos ordenando decrescente pela data
        
        $sql = "SELECT rp.id_revista, r.titulo, r.data as data_rev, r.views, r.ativo, r.id_editora, rp.capitulo, rp.descricao, rp.data, rp.arquivo,
                       CASE WHEN f.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       IFNULL(v.voto,0) soma_votos,
                       IFNULL(sum(v.voto),0) total_votos
                       
                    FROM `revistapagina` as rp
                    
                    INNER JOIN revista as r
                        ON r.id = rp.id_revista
                    
                    LEFT JOIN favoritos f
                        ON (r.id = f.id_revista AND f.id_usuario = $idusuario)
                            
                    LEFT JOIN votacao v ON (r.id = v.id_revista)
    
                    WHERE r.ativo = 1
                    GROUP BY rp.id_revista, rp.capitulo 
                    ORDER BY rp.data DESC";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        // obter primeiro e último registro atualizado - máximo de 15
        $id_revista = 0;
        $cont = -1;

        foreach ($rows as $value) {

            if ($value->id_revista != $id_revista) {
                $cont++;
                if ($cont > 14) {
                    break;
                }

                $id_revista = $value->id_revista;

                $retorno[$cont]['id'] = $id_revista;
                $retorno[$cont]['titulo'] = $value->titulo;
                $retorno[$cont]['data'] = $value->data_rev;
                $retorno[$cont]['views'] = $value->views;
                $retorno[$cont]['ativo'] = $value->ativo;
                $retorno[$cont]['id_editora'] = $value->id_editora;
                
                $retorno[$cont]['numero_final'] = $value->capitulo;
                $retorno[$cont]['descricao_final'] = $value->descricao;
                
                $retorno[$cont]['soma_votos'] = $value->soma_votos;
                $retorno[$cont]['total_votos'] = $value->total_votos;
                $retorno[$cont]['eh_favorito'] = $value->eh_favorito;
            }

            $retorno[$cont]['numero'] = $value->capitulo;
            $retorno[$cont]['descricao'] = $value->descricao;
            $retorno[$cont]['capa'] = $value->arquivo;

        }

        // arrayy retorno
        // id, titulo, data, view, ativo, id_editora, numero, numero_final, descricao, descricao_final, eh_favorito, capa, soma_votos, total_votos
        return json_decode(json_encode($retorno), FALSE);
    }

    public function GetRevistas() {
        $rows = NULL;

        $sql = "SELECT r.titulo, IFNULL(e.nome, 'N/A') as nome_editora, r.status, IFNULL(g.nome_grupo, 'N/A') as nome_grupo, r.id, r.ativo, " .
                "CASE WHEN pag.capitulo IS NULL THEN sum(0) ELSE count(IFNULL(pag.capitulo, 0)) END as total_capitulos " .
                "FROM revista as r " .
                "LEFT JOIN editora e  ON (e.id = r.id_editora) " .
                "LEFT JOIN grupo   g  ON (g.id = r.id_grupo) " .
                "LEFT JOIN revistapagina pag  ON (r.id = pag.id_revista AND pag.ordem = 0) " .
                "WHERE r.ativo = 1 GROUP BY 1, 2, 3, 4, 5, 6";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }

    public function GetRevistaByFilro($titulo = null, $editora = null, $ordem = null, $idusuario = 0) {
        $rows = NULL;
        $where = null;
        $order = null;

        if ($titulo != null) {
            $where .= " AND r.titulo LIKE '%" . $titulo . "%' ";
        }

        if ($editora != null && $editora != 0) {
            $where .= " AND r.id_editora = " . $editora;
        }

        if ($ordem != null) {
            $order = " ORDER BY $ordem";
        } else {
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

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows;
    }
    
    // Guilherme Silva: versão otimizada para obter nome dos capítulos e ordenar corretamente
    public function GetRevistaByFilro2($titulo = null, $editora = null, $ordem = null, $idusuario = 0) {
        $rows = NULL;
        $where = null;
        $order = null;

        if ($titulo != null) {
            $where .= " AND r.titulo LIKE '%" . $titulo . "%' ";
        }

        if ($editora != null && $editora != 0) {
            $where .= " AND r.id_editora = " . $editora;
        }

        if ($ordem != null) {
            $order = " ORDER BY $ordem";
        } else {
            $order = " ORDER BY r.titulo";
        }

        $sql = "SELECT r.id, r.titulo, r.data, r.views, r.ativo, r.id_editora, 
rpm.capitulo as numero, rpx.capitulo as numero_final, rpm.descricao as descricao, rpx.descricao as descricao_final,

                       CASE WHEN f.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       CASE WHEN rpx.arquivo IS NOT NULL THEN rpx.arquivo ELSE 'sem_imagem.jpg' END AS capa,
                       IFNULL(v.voto,0) soma_votos,
                       IFNULL(sum(v.voto),0) total_votos
                       
                    FROM revista as r
                    
                    LEFT JOIN (SELECT min(capitulo) as capitulo, descricao, id_revista from revistapagina GROUP BY id_revista) as rpm
                        ON r.id = rpm.id_revista
						
		    LEFT JOIN (SELECT max(capitulo) as capitulo, descricao, data, arquivo, id_revista from revistapagina GROUP BY id_revista) as rpx
                        ON r.id = rpx.id_revista
                    
                    LEFT JOIN favoritos f
                        ON (r.id = f.id_revista AND f.id_usuario = $idusuario)
                            
                    LEFT JOIN votacao v ON (r.id = v.id_revista)
    
                    WHERE r.ativo = 1 $where
                    GROUP BY r.id
                    $order";

        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        return $rows; 
        
        
    }
    
    public function GetRevistaByFilro3($titulo = null, $editora = null, $ordem = null, $idusuario = 0) {
        $rows = NULL;
        $where = null;
        $order = null;

        if ($titulo != null) {
            $where .= " AND r.titulo LIKE '%" . $titulo . "%' ";
        }

        if ($editora != null && $editora != 0) {
            $where .= " AND r.id_editora = " . $editora;
        }

        if ($ordem != null) {
            $order = " ORDER BY $ordem";
        } else {
            $order = " ORDER BY r.titulo";
        }

        $sql = "SELECT rp.id_revista, r.titulo, r.data as data_rev, r.views, r.ativo, r.id_editora, rp.capitulo, rp.descricao, rp.data, rp.arquivo,
                       CASE WHEN f.id_revista IS NOT NULL THEN 1 ELSE 0 END as eh_favorito,
                       IFNULL(v.voto,0) soma_votos,
                       IFNULL(sum(v.voto),0) total_votos
                       
                    FROM `revistapagina` as rp
                    
                    INNER JOIN revista as r
                        ON r.id = rp.id_revista
                    
                    LEFT JOIN favoritos f
                        ON (r.id = f.id_revista AND f.id_usuario = $idusuario)
                            
                    LEFT JOIN votacao v ON (r.id = v.id_revista)
    
                    WHERE r.ativo = 1 $where
                    GROUP BY rp.id_revista, rp.capitulo 
                    ORDER BY rp.id_revista, rp.capitulo";
        $result = $this->db->query($sql);

        if (Tools::IsValidObject($result)) {
            $rows = $result->result();
        }

        // obter primeiro e último registro atualizado - máximo de 15
        $id_revista = 0;
        $cont = -1;

        foreach ($rows as $value) {

            if ($value->id_revista != $id_revista) {
                $cont++;
                $id_revista = $value->id_revista;

                $retorno[$cont]['id'] = $id_revista;
                $retorno[$cont]['titulo'] = $value->titulo;
                $retorno[$cont]['data'] = $value->data_rev;
                $retorno[$cont]['views'] = $value->views;
                $retorno[$cont]['ativo'] = $value->ativo;
                $retorno[$cont]['id_editora'] = $value->id_editora;
                
                $retorno[$cont]['numero'] = $value->capitulo;
                $retorno[$cont]['descricao'] = $value->descricao;    
                
                $retorno[$cont]['soma_votos'] = $value->soma_votos;
                $retorno[$cont]['total_votos'] = $value->total_votos;
                $retorno[$cont]['eh_favorito'] = $value->eh_favorito;
            }

            $retorno[$cont]['numero_final'] = $value->capitulo;
            $retorno[$cont]['descricao_final'] = $value->descricao;
            $retorno[$cont]['capa'] = $value->arquivo;

        }

        // arrayy retorno
        // id, titulo, data, view, ativo, id_editora, numero, numero_final, descricao, descricao_final, eh_favorito, capa, soma_votos, total_votos
        return json_decode(json_encode($retorno), FALSE);
        
    }

}

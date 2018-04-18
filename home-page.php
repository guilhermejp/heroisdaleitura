<div class="container">
  <div class="row">

    <div class="col-md-8 col-xs-12">
      <div class="titulos">
        <h3>Lista de HQ's</h3>
      </div>
      
      <div class="listagem-hqs">
      <?php 
        if(!is_null($revistas) && !empty($revistas) && sizeof($revistas) > 0):
        foreach ($revistas as $obj): 
      ?>
          <div class="col-md-4 col-sm-6 col-xs-12">    <!-- inicio da hq !-->
            <div class="hq_info">
              <h4 title="<?php echo $obj->titulo; ?>"><?php 
                if( mb_strlen($obj->titulo) > 56 ) {
                  echo substr($obj->titulo, 0, 53) . "...";
                }
                else {
                  echo $obj->titulo;
                }
              ?></h4>
              <span>Capítulo #<?php echo $obj->numero;?> ~ Capitulo #<?php echo $obj->numero_final;?></span>
            </div>
            <div class="hq_foto">
              <a href="<?php echo $baseURL.'/visao/geral/'.$obj->id; ?>">
                <img src="<?php echo $baseURL; ?>/img/hq/<?php echo $obj->capa;?>" class="img-responsive">
              </a>
            </div>
            <div class="hq_data_views">
              <span class="data"><?php echo strftime("%d/%m/%Y %H:%M",strtotime($obj->data));?></span>
              <span class="views"><?php echo $obj->views;?></span>
            </div>
            <div class="hq_stars">
              <div>
                <span class="nota_media">Nota média:
                  <b><?php echo $obj->total_votos > 0 ? $obj->soma_votos / $obj->total_votos : 0;?></b>
                </span>
                <span class="votos_gerais"><?php echo $obj->total_votos;?> Votos</span>
              </div>
            </div>
            <?php 
                $userSession = $_SESSION['user_session'];
                if(!is_null($userSession) && !empty($userSession)):               
            ?>
              <div class="hq_favoritos_btn">
                <a href="#" onclick="javascript: fJSAddFavoritos(this, <?php echo $obj->id;?>);"><i class="<?php echo $obj->eh_favorito ? "fa fa-heart" : "fa fa-heart-o"; ?>" aria-hidden="true"></i> favoritos</a>
              </div>
            <?php endif; ?>    
          </div>
        <?php 
            endforeach; 
          endif;
        ?>
      </div> 


    </div>

    <div class="col-md-4 col-xs-12">
      <div class="col-side-right">
        <div class="titulos">
          <h3>As 10 Mais acessadas</h3>
        </div>
        
        <?php 
        if(Tools::IsValid($maisvistas) && sizeof($maisvistas) > 0):
        foreach ($maisvistas as $obj): ?>
          <div class="col-md-12 col-side">        <!-- LATERAL HQ !-->
            <div class="mini_thumb">
              <a href="<?php echo SITE_URL.'/visao/geral/'.$obj->id; ?>">
                <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $obj->capa;?>"  class="img-thumbnail">
              </a>              
            </div>
            <div class="side_infos">
              <h5><?php echo $obj->titulo; ?></h5>
              <div class="hq_stars">
                <span class="nota_media">Nota média:
                  <b><?php echo $obj->total_votos > 0 ? $obj->soma_votos / $obj->total_votos : 0;?></b>
                </span>
              </div>
              <div class="hq_stars">
                  <span class="votos_gerais" style="float:left !important;"><?php echo $obj->total_votos;?> Votos</span>
              </div>
              <span class="views"><?php echo $obj->views; ?></span>
            </div>
          </div>                                 <!-- FINAL LATERAL HQ !-->
        <?php 
        endforeach; 
        endif;
        ?>
      </div>

      <div class="col-side-right">
        <div class="titulos">
          <h3>As 10 Mais votadas</h3>
        </div>
        <?php 
        if(Tools::IsValid($maisvotados) && sizeof($maisvotados) > 0):
        foreach ($maisvotados as $obj): ?>
          <div class="col-md-12 col-side">        <!-- LATERAL HQ !-->
            <div class="mini_thumb">
              <a href="<?php echo SITE_URL.'/visao/geral/'.$obj->id; ?>">
                <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $obj->capa;?>" class="img-thumbnail" >
              </a>  
            </div>
            <div class="side_infos">
              <h5><?php echo $obj->titulo; ?></h5>
              <div class="hq_stars">
                <span class="nota_media">Nota média:
                  <b><?php echo $obj->total_votos > 0 ? $obj->soma_votos / $obj->total_votos : 0;?></b>
                </span>
              </div>
              <div class="hq_stars">
                  <span class="votos_gerais" style="float:left !important;"><?php echo $obj->total_votos;?> Votos</span>
              </div>
              <span class="views"><?php echo $obj->views; ?></span>
            </div>
          </div>                                 <!-- FINAL LATERAL HQ !-->
        <?php endforeach; 
        endif;?>
      </div>
    </div>
  </div>
</div>
</div>
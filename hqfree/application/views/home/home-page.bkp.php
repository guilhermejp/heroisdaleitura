<div class="container">
  <div class="row">

    <div class="col-md-8 col-xs-12">
      <div class="titulos">
        <h3>Lista de HQ's</h3>
      </div>
      
      <div class="spacer_hq"></div>      
      <div class="data-container"></div>
      <div id="pagination-demo2"></div>      
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
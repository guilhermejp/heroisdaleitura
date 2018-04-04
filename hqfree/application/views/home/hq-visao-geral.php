<div class="container-interno-hq">
    <div class="container-fluid">
        <div class="row content">
            <div class="col-12 sidenav">
                <div class="hq_foto">
                    <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $revista->arquivo;?>" class="img-responsive">
                </div>
            </div>

            <div class="col-12">
                <hr>
                <h1><?php echo $revista->titulo;?></h1>
                <h3><b>Editora:   </b><?php echo $revista->nome_editora;?></h5>
                <h3><b>Grupo:     </b><a href="<?php echo $revista->url_grupo;?>" target="_blank"><?php echo $revista->nome_grupo;?></a></h5>
                <h4>                    
                    <span class="label label-warning">Status: <?php echo Tools::Equals($revista->status, "A") ? "Andamento" : "Concluído"; ?></span>
                    <span class="label label-primary">Visualizações: <?php echo $revista->views;?></span>
                </h4>
                <br>     
                <?php 
                    $userSession = $this->session->userdata(SESSION_ACCOUNT);
                    if(Tools::IsValid($userSession)):               
                ?>
                    <div style="margin-top:10px; margin-bottom:5px;">                 
                        <label for="tipousuario" class="field select"> Votar: </label>
                        <select required id="voto" name="voto" class="empty" onchange="javascript: fJSVotarHQ(<?php echo $revista->id;?>, this.value);">
                            <option value="">Notas...</option>
                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo $voto_revista == $i ? "selected" : "";?> ><?php echo $i; ?></option>
                            <?php  endfor; ?>
                        </select>    
                    </div>
                <?php endif; ?>
               
                <p><i class="fa fa-quote-left fa-1x fa-pull-left"></i> <?php echo $revista->sinopse;?> <i class="fa fa-quote-right fa-1x fa-pull-right"></i></p>                
                <br>
                <br>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid text-center">    
    <h2>Capítulos</h2>

    <?php if(Tools::IsValid($userSession) && $userSession->tipo == "A"): ?>                        
        <a href="<?php echo SITE_URL.'/revista/capitulo/'.$revista->id; ?>" class="btn btn-info">
        <span class="glyphicon glyphicon-plus-sign"></span> Add
        </a>    
    <?php endif;?>
    
    <br>
    <div class="row">
<?php
    if(Tools::IsValid($capitulos) && sizeof($capitulos) > 0):
        foreach ($capitulos as $cap): 
?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 text-center">
            <?php if($cap->especial): ?>
                <p class="chapter-title"><?php echo $cap->descricao; ?></p>
            <?php else: ?> 
                <p class="chapter-title">Capítulo #<?php echo (float) $cap->capitulo; ?><?php if(trim($cap->descricao) != ""){ echo " - ".$cap->descricao; } ?></p>
            <?php endif; ?> 
            <a href="<?php echo SITE_URL.'/leitura/classica/'.$cap->id_revista.'/0/'.(float) $cap->capitulo; ?>">
                <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $cap->arquivo;?>" class="img-responsive center-block" style="width:150px; heigth:80px !important;">
            </a>
        </div>    
<?php 
        endforeach; 
    endif;
?>
    </div>
    </div><br>
</div>
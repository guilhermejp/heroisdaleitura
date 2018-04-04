<div class="container-interno-hq">
    <div class="titulos">    
        <a href="<?php echo SITE_URL.'/visao/geral/'.$revista[0]->id; ?>">    
            <h3><?php echo $revista[0]->titulo;?></h3>
        </a>
        <h4><span><b>Capitulo #</b><?php echo (float) $revista[0]->numero ;?></span></h4>
    </div>

    <div class="paginador"> <!-- PAGINADOR !-->
        <nav aria-label="Page navigation example"> 
        <ul class="pagination justify-content-center">
            <?php foreach ($revista as $obj): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo SITE_URL.'/leitura/classica/'.$revista[0]->id.'/'.$obj->ordem.'/'.(float)$obj->numero; ?>">
                        <?php echo $obj->ordem == 0 ? "Capa" : $obj->ordem;?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
        </nav>
    </div> <!-- Fim do paginador !-->


    <div class="modo-exibição">
        <span class="btn-exibicao"><a href="<?php echo SITE_URL.'/leitura/completa/'.$revista[0]->id.'/'.(float)$obj->numero; ?>">Mudar para modo de leitura completa</a></span>       
    </div>

    <div class="hq_ampliada">
        <a href="<?php echo SITE_URL.'/leitura/classica/'.$revista[$revista_ordem]->id.'/'.$prox_pag.'/'.(float)$obj->numero; ?>">
            <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $revista[$revista_ordem]->arquivo;?>" class="img-responsive">
        </a>
    </div>

    <div class="paginador"> <!-- PAGINADOR !-->
        <nav aria-label="Page navigation example"> 
        <ul class="pagination justify-content-center">
            <?php foreach ($revista as $obj): ?>
                <li class="page-item"><a class="page-link" href="<?php echo SITE_URL.'/leitura/classica/'.$revista[0]->id.'/'.$obj->ordem.'/'.(float)$obj->numero; ?>"><?php echo $obj->ordem == 0 ? "Capa" : $obj->ordem;?></a></li>
            <?php endforeach;?>
        </ul>
        </nav>
    </div> <!-- Fim do paginador !-->
</div>	






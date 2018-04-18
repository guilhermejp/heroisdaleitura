<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="titulos titulo_interno">
                <h3>Destaques</h3>
            </div>
            <div class="filtro_editora">
                <form method="post" action="<?php echo SITE_URL . '/filtrar'; ?>">
                    Filtros: 
                    <select id="filtro_editora" name="filtro_editora" class="input-sm">
                        <option value="0">Todas Editoras</option>
                        <?php foreach ($editoras as $obj): ?>
                            <option value="<?php echo $obj->id; ?>" <?php echo $filtro_editora == $obj->id ? "selected" : ""; ?> ><?php echo $obj->nome; ?></option>
                        <?php endforeach; ?>	          
                    </select>

                    <select id="filtro_ordem" name="filtro_ordem" class="input-sm">
                        <option value="2 ASC,  3" <?php echo $filtro_ordem == "2 ASC,  3" ? "selected" : ""; ?>>A - z</option>
                        <option value="2 DESC, 3" <?php echo $filtro_ordem == "2 DESC, 3" ? "selected" : ""; ?>>Z - a</option>                
                        <option value="6 DESC"    <?php echo $filtro_ordem == "6 DESC" ? "selected" : ""; ?>>Mais Visualizações</option>
                        <option value="11 DESC"   <?php echo $filtro_ordem == "11 DESC" ? "selected" : ""; ?>>Mais Votado</option>
                        <option value="10 DESC"   <?php echo $filtro_ordem == "10 DESC" ? "selected" : ""; ?>>Por Média</option>
                    </select>

                    <button type="submit" class="btn btn-default btn-sm" title="Filtrar...">
                        <span class="glyphicon glyphicon-filter"></span>
                    </button>
                </form>
            </div>
            <div class="spacer_hq"></div>
            <div class="listagem-hqs">							
                <?php if (Tools::IsValid($revistas) && sizeof($revistas) > 0): ?>
                    <?php foreach ($revistas as $obj): ?>
                        <div class="col-md-3 col-sm-6 col-xs-12"> <!-- inicio da hq !-->
                            <div class="hq_info">
                                <h4 title="<?php echo $obj->titulo; ?>"><?php
                                    if (mb_strlen($obj->titulo) > 56) {
                                        echo mb_substr($obj->titulo, 0, 53) . "...";
                                    } else {
                                        echo $obj->titulo;
                                    }
                                    ?></h4>
                                <span>Capítulo #<?php echo $obj->numero; ?> ~ Capitulo #<?php echo $obj->numero_final; ?></span>
                                    <?php if ($obj->descricao != "" || $obj->descricao_final != "") { ?>
                                    <small><?php echo $obj->descricao; ?> ~ <?php echo $obj->descricao_final; ?></small>
                                <?php } ?>
                            </div>
                            <div class="hq_foto">
                                <a href="<?php echo SITE_URL . '/visao/geral/' . $obj->id; ?>">
                                    <img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $obj->capa; ?>" class="img-responsive">
                                </a>
                            </div>
                            <div class="hq_data_views">
                                <span class="data"><?php echo Tools::GetMyDate($obj->data, '1x'); ?></span>
                                <span class="views"><?php echo $obj->views; ?></span>
                            </div>
                            <div class="hq_stars">
                                <div>
                                    <span class="nota_media">Nota média: <b><?php echo $obj->total_votos > 0 ? $obj->soma_votos / $obj->total_votos : 0; ?></b></span>
                                    <span class="votos_gerais"><?php echo $obj->total_votos; ?> Votos</span>
                                </div>
                            </div>							
        <?php
        $userSession = $this->session->userdata(SESSION_ACCOUNT);
        if (Tools::IsValid($userSession)):
            ?>
                                <div class="hq_favoritos_btn">
                                    <a href="#" onclick="javascript: fJSAddFavoritos(this, <?php echo $obj->id; ?>);"><i class="<?php echo $obj->eh_favorito ? "fa fa-heart" : "fa fa-heart-o"; ?>" aria-hidden="true"></i> favoritos</a>
                                </div>
        <?php endif; ?>  
                        </div> <!-- FINAL DA HQ !-->
                        <?php endforeach; ?>
                    <div class="paginador"> <!-- PAGINADOR !-->
                        <nav aria-label="Page navigation example"> 
                            <ul class="pagination justify-content-center hidden">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Próximo</a>
                                </li>
                            </ul>
                        </nav>
                    </div> <!-- Fim do paginador !-->
<?php else: ?>
                    <div class="container">										
                        <h2 class="subtitle is-6"><b>0</b> resultado(s) de pesquisa para <b>'<?php echo $filtro; ?>'</b></h2>
                    </div>
<?php endif; ?>
            </div>
        </div>
    </div>
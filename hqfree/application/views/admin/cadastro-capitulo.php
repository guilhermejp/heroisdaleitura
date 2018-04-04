<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
    height: 340px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.gallery-body {    
    height: 274px;
}

div.desc {
    padding: 15px;
    text-align: center;
}
</style>

<br>
<br>
<br>
<div class="container-fluid">

  <div class="center-block mt30" style="max-width: 1000px !important;">
    <div class="admin-form theme-danger" id="register1">
      <div class="panel panel-danger heading-border">
        <div class="panel-heading">
          <span class="panel-title">
            <i class="fa fa-pencil-square"></i>Cadastros Capítulo (<?php echo $revista->titulo;?>)
          </span>
        </div>

        <!-- end .form-header section -->

        <form method="post" id="formcadastro">
          <input type="hidden" name="hdnUrl" id="hdnUrl" value="<?php echo '/revista/capitulo/'.$idrevistaprocesso; ?>">          
          <input type="hidden" name="hdnUrlInserir" id="hdnUrlInserir" value="/capitulo/cadastro/geral">          
          <input type="hidden" name="hdnUrlAlterar" id="hdnUrlAlterar" value="/capitulo/alterar">          
          <input type="hidden" name="hdnTitle" id="hdnTitle" value="Capitulos HQ"> 
          <input type="hidden" name="hdnIdRevistaProcesso" id="hdnIdRevistaProcesso" value="<?php echo $idrevistaprocesso;?>">      

          <?php if(Tools::IsValid($capitulo->paginas)): ?>
            <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $capitulo->capitulo?>">          
          <?php endif; ?> 
           
          <div class="panel-body p25">
            <div class="section-divider mt10 mb40">
              <span>Dados Capítulo</span>
            </div>
            <div class="section row">
              <div class="col-md-8">
                <label for="numero_capitulo" class="field prepend-icon">
                  <input type="text" name="nome_capitulo" id="nome_capitulo" value="<?php echo $capitulo->nome_capitulo;?>" class="gui-input" placeholder="Nome Capítulo..." maxlength="100"> 
                  <label for="numero_capitulo" class="field-icon">
                    <i class="imoon imoon-numbered-list"></i>
                  </label>
                </label>
              </div>
              <div class="col-md-4">
                  <label class="block mt15 switch switch-primary" style="margin-top:8px;">                    
                    <input type="checkbox" name="especial" id="especial" value="S" <?php echo $capitulo->especial ? "checked" : "";?>>
                    <label for="especial" data-on="SIM" data-off="NÃO"></label>                    
                    <span>Capítulo Especial ?</span>
                  </label>
                </div>
            </div>

            <div class="section row">
              <div class="col-md-3">
                <label for="numero_capitulo" class="field prepend-icon">
                  <input type="number" name="numero_capitulo" id="numero_capitulo" value="<?php echo $capitulo->capitulo;?>" step="0.1" class="gui-input" placeholder="Número Capítulo..." required>
                  <label for="numero_capitulo" class="field-icon">
                    <i class="imoon imoon-numbered-list"></i>
                  </label>
                </label>
              </div>
 
              <div class="col-md-9 btnBox hidden">     
                <div class="section" style="margin-top:5px;">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalUpload">
                      <i class="fa fa-files-o"></i> Arquivos
                    </button>
                  </div>
                  <small class="text-danger"> (*** Clique e arraste as imagens para ordena-las) </small>
                </div>         
              </div>
            </div>
      

            <div class="section" id="listFileUpload">
            <?php if(Tools::IsValid($capitulo->paginas)):            
                $targetPath = SITE_PATH.'/img/hq/';   
                $targetURL  = SITE_URL.'/img/hq/';        

                if (is_dir($targetPath) && strlen($targetPath)>0):
                    $files = scandir($targetPath);
                ?>
                  <div class="col-md-12" id="sortable">
                    <?php
                      $i=1;
                      foreach ($capitulo->paginas as $pag):
                        if (file_exists($targetPath.'/'.$pag->arquivo)):
                          $nome_arquivo = explode('/', $pag->arquivo);
                ?>
                      <div class="gallery" id="pagina_<?php echo $i;?>">
                        <div class="gallery-body">
                          <a target="_blank" href="<?php echo $targetURL.'/'.$nome_arquivo[2]; ?>">
                            <img src="<?php echo $targetURL.'/'.$pag->arquivo; ?>" width="300" height="200">
                            <input type="hidden" name="hdnPaginas[]" id="hdnPaginas_<?php echo $i;?>" value="<?php echo $nome_arquivo[2];?>">
                          </a>
                        </div>
                        <div class="desc">
                          <button type="button" class="btn btn-danger" data-toggle="modal" onclick="javascript: $(pagina_<?php echo $i;?>).remove();">
                            Remover
                          </button>
                        </div>
                      </div>
                          
                <?php 
                        $i++;
                      endif; ?>

                      <?php endforeach;?>
                  </div>                
                <?php endif;?>
            <?php endif; ?> 
            </div>
          </div>

          <div class="panel-footer text-right">
            <a class="button btn-info" id="reseteditora" href="<?php echo SITE_URL.'/revista/capitulo/'.$idrevistaprocesso; ?>">Limpar</a>
            <button type="submit" class="button btn-primary" id="submitpagina">Gravar</button>
            <a class="button btn-danger pull-left" href="javascript: history.back();">Voltar</a>
          </div>

        </form>

        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Listagem</span>
          </div>

          <table class="table table-striped table-hover datatable" id="revistadatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Capítulos</th>
                <th>Paginas</th>
                <th class="text-right">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(Tools::IsValid($capitulos)): ?>
                <?php foreach ($capitulos as $obj): ?>
                  <tr>
                    <td><?php echo "Capítulo #".(float) $obj->capitulo;?></td>
                    <td><?php echo $obj->total_paginas;?></td>
                    <td class="text-right">
                      <div class="btn-group text-right">
                        <button type="button" class="btn btn-info br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Ação
                          <span class="caret ml5"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">                     
                          <li><a href="<?php echo SITE_URL.'/capitulo/alteracao/'.$obj->id_revista.'/'.(float)$obj->capitulo; ?>">Alterar</a></li>   
                          <li class="divider"></li>                          
                          <li><a href="#" onclick="javascript: fJSExclirRegistro('/capitulo/excluir/<?php echo $obj->id_revista; ?>/<?php echo (float) $obj->capitulo; ?>', '/revista/capitulo/<?php echo $obj->id_revista;?>', 'Excluir Capítulo');">Excluir</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>

    <div id="modalUpload" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 900px;">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Arquivos</h4> <!-- <h6>(10 por vez)</h6> -->
            </div>
            <div class="modal-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="section">
                  <div id="dZUpload" class="dropzone">
                    <div class="dz-default dz-message"></div>
                  </div>
                </div>
              </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_upload">Enviar</button>
            </div>
            </div>
        </div>
    </div>
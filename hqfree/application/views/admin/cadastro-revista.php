<br>
<br>
<br>
<div class="container-fluid">

  <div class="center-block mt30" style="max-width: 1000px !important;">
    <div class="admin-form theme-danger" id="register1">
      <div class="panel panel-danger heading-border">
        <div class="panel-heading">
          <span class="panel-title">
            <i class="fa fa-pencil-square"></i>Cadastro HQ
          </span>
        </div>
        <!-- end .form-header section -->

        <form method="post" id="formcadastro">
          <input type="hidden" name="hdnUrl" id="hdnUrl" value="/revista">          
          <input type="hidden" name="hdnUrlVisaoGeral" id="hdnUrlVisaoGeral" value="/visao/geral">                    
          <input type="hidden" name="hdnUrlInserir" id="hdnUrlInserir" value="/revista/cadastro/geral">          
          <input type="hidden" name="hdnUrlAlterar" id="hdnUrlAlterar" value="/revista/alterar">          
          <input type="hidden" name="hdnTitle" id="hdnTitle" value="Revista HQ"> 

          <?php if($revista->id): ?>
            <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $revista->id;?>">          
          <?php endif; ?> 

          <div class="panel-body p25">
            <div class="section-divider mt10 mb40">
              <span>Dados HQ</span>
            </div>

            <div class="section row">
              <div class="col-md-6">
                <label for="titulo" class="field prepend-icon">
                  <input type="text" name="titulo" id="titulo" value="<?php echo $revista->titulo;?>" class="gui-input" placeholder="Título..." required maxlength="400">
                  <label for="titulo" class="field-icon">
                    <i class="fa fa-book"></i>
                  </label>
                </label>
              </div>

              <div class="col-md-6">
                <label for="editora" class="field select">
                  <select required id="editora" name="editora" class="empty">
                    <option value="">Editora...</option>
                    <?php foreach ($editoras as $obj): ?>
                    <option value="<?php echo $obj->id;?>" <?php echo $revista->id_editora==$obj->id ? "selected" : "";?> >
                      <?php echo $obj->nome;?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <i class="arrow double"></i>
                </label>
              </div>
            </div>

            <div class="section row">
            <div class="col-md-6">
                <label for="status" class="field select">
                  <select required id="status" name="status" class="empty">
                    <option value="">Status...</option>
                    <option value="A" <?php echo $revista->status=="A" ? "selected" : "";?> >Andamento</option>
                    <option value="C" <?php echo $revista->status=="C" ? "selected" : "";?> >Concluído</option>
                  </select>
                  <i class="arrow double"></i>
                </label>
              </div>
              <div class="col-md-6" >
              <label for="editora" class="field select">
                  <select required id="grupo" name="grupo" class="empty">
                    <option value="">Grupo...</option>
                  <?php foreach ($grupos as $obj): ?>
                    <option value="<?php echo $obj->id;?>" <?php echo $revista->id_grupo==$obj->id ? "selected" : "";?> >
                    <?php echo $obj->nome_grupo;?>
                    </option>
                  <?php endforeach; ?>
                  </select>
                <i class="arrow double"></i>
                </label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="section">
                <label class="field prepend-icon">
                  <textarea class="gui-textarea" id="sinopse" name="sinopse" placeholder="Sinopse....">
                    <?php echo trim($revista->sinopse);?>
                  </textarea>
                  <label for="comment" class="field-icon">
                    <i class="fa fa-comments"></i>
                  </label>
                  <span class="input-footer">                  
                  </span>
                </label>
              </div>
            </div>
          </div>

          <div class="panel-footer text-right">
            <a class="button btn-info" id="reseteditora" href="<?php echo SITE_URL.'/revista'; ?>">Limpar</a>
            <button type="submit" class="button btn-primary" id="submitrevista">Gravar</button>
          </div>

        </form>

        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Listagem</span>
          </div>

          <table class="table table-striped table-hover datatable" id="revistadatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Título</th>
                <th>Editora</th>
                <th>Status</th>
                <th>Grupo</th>
                <th>Capítulos</th>
                <th class="text-right">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(Tools::IsValid($revistas)): ?>
                <?php foreach ($revistas as $obj): ?>
                  <tr>
                    <td><?php echo $obj->titulo;?></td>
                    <td><?php echo $obj->nome_editora;?></td>
                    <td><?php echo Tools::Equals($obj->status, "A") ? "Andamento" : "Concluído"; ?></td>
                    <td><?php echo $obj->nome_grupo;?></td>
                    <td><a href="<?php echo SITE_URL.'/revista/capitulo/'.$obj->id; ?>"><?php echo $obj->total_capitulos;?></a></td>
                    <td class="text-right">
                      <?php if($obj->ativo): ?>
                        <div class="btn-group text-right">
                          <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Ativo
                            <span class="caret ml5"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo SITE_URL.'/revista/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                            <li><a href="<?php echo SITE_URL.'/revista/capitulo/'.$obj->id; ?>">Capítulos</a></li>   
                            <li class="divider"></li>                          
                            <li><a href="#" onclick="javascript: fJSAlteraStatus('/revista/status/<?php echo $obj->id; ?>', '/revista');">Inativar</a></li>
                            <li><a href="#" onclick="javascript: fJSExclirRegistro('/revista/excluir/<?php echo $obj->id; ?>', '/revista', 'Excluir HQ');">Excluir</a></li>
                          </ul>
                        </div>
                      <?php else:?>
                        <div class="btn-group text-right">
                            <button type="button" class="btn btn-danger br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Inativo
                              <span class="caret ml5"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo SITE_URL.'/revista/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                            <li><a href="<?php echo SITE_URL.'/revista/capitulo/'.$obj->id; ?>">Capítulos</a></li>
                            <li class="divider"></li>
                            <li><a href="#" onclick="javascript: fJSAlteraStatus('/revista/status/<?php echo $obj->id; ?>', '/revista');">Ativar</a></li>                          
                            <li><a href="#" onclick="javascript: fJSExclirRegistro('/revista/excluir/<?php echo $obj->id; ?>', '/revista', 'Excluir HQ');">Excluir</a></li>
                          </ul>
                        </div>
                      <?php endif; ?>
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
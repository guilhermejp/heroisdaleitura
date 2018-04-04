
<br><br><br>

<div class="container-fluid">
  <div class="center-block mt30" style="max-width: 1000px !important;">
    <div class="admin-form theme-danger" id="register3">

      <div class="panel panel-danger heading-border">
        <div class="panel-heading">
            <span class="panel-title">
              <i class="fa fa-pencil-square"></i>Cadastro Grupo Parceiro
            </span>
          </div>

        <form method="post" id="formcadastro">
          <input type="hidden" name="hdnUrl" id="hdnUrl" value="/grupo">          
          <input type="hidden" name="hdnUrlInserir" id="hdnUrlInserir" value="/grupo/cadastro/geral">          
          <input type="hidden" name="hdnUrlAlterar" id="hdnUrlAlterar" value="/grupo/alterar">          
          <input type="hidden" name="hdnTitle" id="hdnTitle" value="Grupo Parceiro">   

          <?php if($grupo->id): ?>
            <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $grupo->id;?>">          
          <?php endif; ?> 
                
          <div class="panel-body p25">
            <div class="section-divider mt10 mb40">
              <span>Dados</span>
            </div>

            <div class="section row mb15">
              <div class="col-md-4" >
                <label for="grupo_parceiro" class="field prepend-icon">
                  <input type="text" name="grupo_parceiro" id="grupo_parceiro" value="<?php echo $grupo->nome_grupo;?>" class="gui-input" placeholder="Nome Grupo Parceiro..." required maxlength="30">
                  <label for="grupo_parceiro" class="field-icon">
                    <i class="fa fa-group"></i>
                  </label>
                </label>
              </div>
              <div class="col-md-8">
                <label for="url_parceiro" class="field prepend-icon">
                  <input type="text" name="url_parceiro" id="url_parceiro" value="<?php echo $grupo->url_grupo;?>" class="gui-input" placeholder="URL Site Parceiro..." required maxlength="250">
                  <label for="url_parceiro" class="field-icon">
                    <i class="fa fa-globe"></i>
                  </label>
                </label>
              </div>
            </div>

          <div class="panel-footer text-right">
            <a class="button btn-info" id="resetgrupo" href="<?php echo SITE_URL.'/grupo'; ?>">Limpar</a>
            <button type="submit" class="button btn-primary" id="submitgrupo">Gravar</button>
          </div>
        </form>

        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Listagem</span>
          </div>

          <table class="table table-striped table-hover datatable" id="grupodatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nome Grupo</th>
                <th>Site URL</th>
                <th class="text-right">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(Tools::IsValid($grupos)): ?>
                <?php foreach ($grupos as $obj): ?>
                  <tr>
                    <td><?php echo $obj->nome_grupo;?></td>
                    <td><?php echo $obj->url_grupo;?></td>
                    <td class="text-right">
                      <div class="btn-group text-right">
                        <button type="button" class="btn btn-info br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Ação
                          <span class="caret ml5"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="<?php echo SITE_URL.'/grupo/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                          <li class="divider"></li>                          
                          <li><a href="#" onclick="javascript: fJSExclirRegistro('/grupo/excluir/<?php echo $obj->id; ?>', '/grupo', 'Excluir Grupo Parceiro');">Excluir</a></li>
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
</div>
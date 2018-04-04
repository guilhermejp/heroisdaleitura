
<br><br><br>

<div class="container-fluid">
  <div class="center-block mt30" style="max-width: 1000px !important;">
    <div class="admin-form theme-danger" id="register2">

      <div class="panel panel-danger heading-border">
        <div class="panel-heading">
            <span class="panel-title">
              <i class="fa fa-pencil-square"></i>Cadastro Editora
            </span>
          </div>

        <form method="post" id="formcadastro">
          <input type="hidden" name="hdnUrl" id="hdnUrl" value="/editora">          
          <input type="hidden" name="hdnUrlInserir" id="hdnUrlInserir" value="/editora/cadastro/geral">          
          <input type="hidden" name="hdnUrlAlterar" id="hdnUrlAlterar" value="/editora/alterar">          
          <input type="hidden" name="hdnTitle" id="hdnTitle" value="Editora">   

          <?php if($editora->id): ?>
            <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $editora->id;?>">          
          <?php endif; ?> 
                
          <div class="panel-body p25">
            <div class="section-divider mt10 mb40">
              <span>Dados</span>
            </div>

            <div class="section row mb15">                
              <div class="col-xs-12">
                <label for="nomeeditora" class="field prepend-icon">
                  <input type="text" name="nomeeditora" id="nomeeditora" class="event-name gui-input br-light light" placeholder="Nome..." maxlength="50" required value="<?php echo $editora->nome;?>">
                  <label for="nomeeditora" class="field-icon">
                    <i class="fa fa-user"></i>
                  </label>
                </label>
              </div>
            </div>

          <div class="panel-footer text-right">
            <a class="button btn-info" id="reseteditora" href="<?php echo SITE_URL.'/editora'; ?>">Limpar</a>
            <button type="submit" class="button btn-primary" id="submiteditora">Gravar</button>
          </div>
        </form>

        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Listagem</span>
          </div>

          <table class="table table-striped table-hover datatable" id="editoradatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nome</th>                
                <th class="text-right">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(Tools::IsValid($editoras)): ?>
                <?php foreach ($editoras as $obj): ?>
                  <tr>
                    <td><?php echo $obj->nome;?></td>
                    <td class="text-right">
                      <div class="btn-group text-right">
                        <button type="button" class="btn btn-info br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Ação
                          <span class="caret ml5"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="<?php echo SITE_URL.'/editora/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                          <li class="divider"></li>                          
                          <li><a href="#" onclick="javascript: fJSExclirRegistro('/editora/excluir/<?php echo $obj->id; ?>', '/editora', 'Excluir Editora');">Excluir</a></li>
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
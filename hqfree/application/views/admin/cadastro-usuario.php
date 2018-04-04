
<br><br><br>

<div class="container-fluid">
  <div class="center-block mt30" style="max-width: 1000px !important;">
    <div class="admin-form theme-danger" id="register2">

      <div class="panel panel-danger heading-border">
        <div class="panel-heading">
            <span class="panel-title">
              <i class="fa fa-pencil-square"></i>Cadastro Usuário
            </span>
          </div>

        <form method="post" id="formcadastro">
          <input type="hidden" name="hdnUrl" id="hdnUrl" value="/usuario">          
          <input type="hidden" name="hdnUrlInserir" id="hdnUrlInserir" value="/usuario/cadastro/geral">          
          <input type="hidden" name="hdnUrlAlterar" id="hdnUrlAlterar" value="/usuario/alterar">          
          <input type="hidden" name="hdnTitle" id="hdnTitle" value="Usuário">   
          
          <?php if($usuario->id): ?>
            <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $usuario->id;?>">          
          <?php endif; ?> 
                
          <div class="panel-body p25">
            <div class="section-divider mt10 mb40">
              <span>Dados</span>
            </div>

            <div class="section row mb15">                
              <div class="col-xs-6">
                <label for="nomeusuario" class="field prepend-icon">
                  <input type="text" name="nomeusuario" id="nomeusuario" class="event-name gui-input br-light light" placeholder="Nome..." maxlength="50" required value="<?php echo $usuario->nome;?>">
                  <label for="nomeusuario" class="field-icon">
                    <i class="fa fa-user"></i>
                  </label>
                </label>
              </div>
              <div class="col-xs-6">
                <label for="tipousuario" class="field select">
                  <select required id="tipousuario" name="tipousuario" class="empty" >
                    <option value="">Tipo...</option>
                    <option value="A" <?php echo $usuario->tipo == "A" ? "selected" : "";?> >ADMIN</option>
                    <option value="U" <?php echo $usuario->tipo == "U" ? "selected" : "";?>>Usuário</option>
                  </select>
                  <i class="arrow double"></i>
                </label>
              </div>
            </div>

            <div class="section row mb15">
              <div class="col-xs-6">
                <label for="senhausuario" class="field prepend-icon">
                  <input type="password" name="senhausuario" id="senhausuario" class="event-name gui-input br-light light" placeholder="Senha..." maxlength="20" <?php echo $usuario->id > 0 ? "" : "required";?> >
                  <label for="senhausuario" class="field-icon">
                    <i class="fa fa-lock"></i>
                  </label>
                </label>
              </div>
              <div class="col-xs-6">
                <label for="senhaconf" class="field prepend-icon">
                  <input type="password" name="senhaconf" id="senhaconf" class="event-name gui-input br-light light" placeholder="Confirmação senha..." maxlength="20" <?php echo $usuario->id > 0 ? "" : "required";?>>
                  <label for="senhaconf" class="field-icon">
                    <i class="fa fa-unlock"></i>
                  </label>
                </label>
              </div>
            </div>

            <div class="section mb15">
              <label for="emailusuario" class="field prepend-icon">
                <input type="email" name="emailusuario" id="emailusuario" class="event-name gui-input br-light bg-light" placeholder="E-mail..." maxlength="70" required value="<?php echo $usuario->email;?>" > 
                <label for="emailusuario" class="field-icon">
                  <i class="fa fa-envelope-o"></i>
                </label>
              </label>
            </div>
          </div>

          <div class="panel-footer text-right">
            <a class="button btn-info" id="resetusuario" href="<?php echo SITE_URL.'/usuario'; ?>">Limpar</a>
            <button type="submit" class="button btn-primary" id="submitusuario">Gravar</button>
          </div>
        </form>

        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Listagem</span>
          </div>

          <table class="table table-striped table-hover datatable" id="usuariodatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Tipo</th>
                <th class="text-right">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if(Tools::IsValid($usuarios)): ?>
                <?php foreach ($usuarios as $obj): ?>
                  <tr>
                    <td><?php echo $obj->nome;?></td>
                    <td><?php echo $obj->email;?></td>
                    <td><?php echo Tools::Equals($obj->tipo, "A") ? "Admin" : "Usuário"; ?></td>
                    <td class="text-right">
                      <?php if($obj->ativo): ?>
                        <div class="btn-group text-right">
                          <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Ativo
                            <span class="caret ml5"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo SITE_URL.'/usuario/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                            <li class="divider"></li>                          
                            <li><a href="#" onclick="javascript: fJSAlteraStatus('/usuario/status/<?php echo $obj->id; ?>', '/usuario');">Inativar</a></li>
                            <li><a href="#" onclick="javascript: fJSExclirRegistro('/usuario/excluir/<?php echo $obj->id; ?>', '/usuario', 'Excluir Usuário');">Excluir</a></li>
                          </ul>
                        </div>
                      <?php else:?>
                        <div class="btn-group text-right">
                            <button type="button" class="btn btn-danger br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Inativo
                              <span class="caret ml5"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo SITE_URL.'/usuario/alteracao/'.$obj->id; ?>">Alterar</a></li>   
                            <li class="divider"></li>
                            <li><a href="#" onclick="javascript: fJSAlteraStatus('/usuario/status/<?php echo $obj->id; ?>', '/usuario');">Ativar</a></li>                          
                            <li><a href="#" onclick="javascript: fJSExclirRegistro('/usuario/excluir/<?php echo $obj->id; ?>', '/usuario', 'Excluir Usuário');">Excluir</a></li>
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
</div>
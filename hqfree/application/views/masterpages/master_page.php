<!DOCTYPE html>
<html>

<head>
    <?php
        if($this->pageView == 'home/hq-visao-geral'){
            echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7316519803479393",
    enable_page_level_ads: true
  });
</script>';
        }
    ?>
    <title>
        <?php echo $this->titleView;?>
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/dropzone/css/dropzone.css">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/fonts/icomoon/icomoon.css">

    <!-- AdminForms CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/admin-tools/admin-forms/css/admin-forms.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/datepicker/css/bootstrap-datetimepicker.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/datatables/media/css/dataTables.bootstrap.css"  >
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/assets/datatables/media/css/pagination.css"  >    
</head>

<body>
    <input type="hidden" name="hdnUrlBase" id="hdnUrlBase" value="<?php echo SITE_URL; ?>" />
    <?php 
        $userSession = $this->session->userdata(SESSION_ACCOUNT);
    ?>
    <nav class="navbar navbar-default navbar-fixed-top ruper">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                    aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="<?php echo SITE_URL; ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL . '/listagem'; ?>">Lista de HQ's</a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL . '/grupos/parceiros'; ?>">Sites Parceiros</a>
                    </li>
                    <?php if(Tools::IsValid($userSession) && $userSession->tipo == "A"): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Administração <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-lr animated flipInX" role="menu">
                                <li><a href="<?php echo SITE_URL . '/usuario'; ?>">Usuário</a></li>
                                <li><a href="<?php echo SITE_URL . '/editora'; ?>">Editora</a></li>
                                <li><a href="<?php echo SITE_URL . '/grupo'; ?>">Grupos Parceiros</a></li>
                                <li><a href="<?php echo SITE_URL . '/revista'; ?>">Revistas HQ</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

            <?php if(Tools::IsValid($userSession)): ?>
                <div class="top_users text-right hidden-sm hidden-xs">
                    <a href="<?php echo SITE_URL . '/dashboard'; ?>" class="login">Olá <?php echo $userSession->nome;?></a>
                    <a href="#" class="cadastro" id="btnSair">Sair</a>
                </div>
            <?php else: ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastre-se
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-lr animated flipInX" role="menu">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <h3>
                                        <b>Cadastro</b>
                                    </h3>
                                </div>
                                <form id="ajax-register-form" action="" method="post" role="form" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Nome usuário" value="" required maxlength="70">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="e-mail" value="" required maxlength="80">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="senha" required maxlength="15">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="confirmação senha" required maxlength="15">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6 col-xs-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-info" value="Cadastre-se">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <h3>
                                        <b>Login</b>
                                    </h3>
                                </div>
                                <form id="ajax-login-form" action="" method="post" role="form" autocomplete="off">
                                    <div class="form-group">
                                        <label for="emaillogin">E-mail</label>
                                        <input type="email" name="emaillogin" id="emaillogin" tabindex="1" class="form-control" placeholder="usuário" value="" autocomplete="off" required>
                                            
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Senha</label>
                                        <input type="password" name="senhalogin" id="senhalogin" tabindex="2" class="form-control" placeholder="senha" autocomplete="off" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-8 ">
                                                <input type="checkbox" tabindex="3" name="remember" id="remember" value="S">
                                                <label for="remember"> Lembre-me</label>                                                                                                
                                            </div>    
                                            <div class="col-xs-4 pull-right">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-success" value="Login">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="pull-left">
                                                    <button type="button" class="btn btn-sm change-password" title="Alterar Senha" ><span class="glyphicon glyphicon-lock"></span></button>
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="text-center">                     
                                                    <a href="#" tabindex="5" class="forgot-password">Esqueceu a senha?</a>
                                                </div>
                                            </div>                                         
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <div class="fb-login-button" scope="public_profile,email" onlogin="fJSCheckLoginState();" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                            </div>   
                                        </div>
                                    </div>
                                </form>
                                <form id="ajax-change-pass" action="" method="post" role="form" autocomplete="off" style="display: none;">
                                    <div class="form-group">
                                        <label for="emailtroca">E-mail</label>
                                        <input type="email" name="emailtroca" id="emailtroca" tabindex="1" class="form-control" placeholder="usuário" value="" autocomplete="off" required>
                                            
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Senha Atual</label>
                                        <input type="password" name="senhaatual" id="senhaatual" tabindex="2" class="form-control" placeholder="senha atual" autocomplete="off" required maxlength="15">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Nova Senha</label>
                                        <input type="password" name="senhanova" id="senhanova" tabindex="3" class="form-control" placeholder="nova senha" autocomplete="off" required maxlength="15">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Confirmação</label>
                                        <input type="password" name="senhaconf" id="senhaconf" tabindex="4" class="form-control" placeholder="confirmção" autocomplete="off" required maxlength="15">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7 ">
                                                <a href="#" tabindex="5" class="change-password"><span class="glyphicon glyphicon-arrow-left"></span></a>
                                            </div>
                                            <div class="col-xs-5 pull-right">
                                                <input type="submit" name="change-submit" id="change-submit" tabindex="5" class="form-control btn btn-success" value="Salvar">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="ajax-forgot-pass" action="" method="post" role="form" autocomplete="off" style="display: none;">
                                    <div class="form-group">
                                        <label for="emailforgot">E-mail</label>
                                        <input type="email" name="emailforgot" id="emailforgot" tabindex="1" class="form-control" placeholder="E-mail para envio da senha..." value="" autocomplete="off" required>                                            
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">     
                                            <div class="col-xs-5 pull-right">                                                
                                                <input type="submit" name="forgot-submit" id="forgot-submit" tabindex="4" class="form-control btn btn-success" value="Enviar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="#" tabindex="5" class="forgot-password"><span class="glyphicon glyphicon-arrow-left"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>                
            </div>
            <!-- /.navbar-collapse -->

        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <br />
    <br />
    <?php if(Tools::IsValid($activeSearch)): ?>
        <section id="header_website">
            <div class="container searchbar">                
                <div class="col-md-12 col-xs-12">
                    <form method="post" action="<?php echo SITE_URL.'/consultar'; ?>">
                        <input id="search_topo" name="search_topo" type="text" placeholder="digite sua pesquisa" size="50">
                        <input type="submit" value="pesquisar" class="btn_search">
                    </form>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="wrap">
        <?php $this->load->view($this->pageView); ?>
    </section>

    <br />
    <br />
    <br />

    <div class="navbar navbar-default navbar-static-bottom">
        <div class="container">
            <p class="navbar-text pull-left">Copyright © 2017 - Todos os direitos reservados</p>

        </div>
    </div>
    <!--- Footer static !-->

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo_modal"><?php echo Tools::IsValid($modal) ? $modal->titulo : "";?></h4>
            </div>
            <div class="modal-body">
                <p id="msg_modal"><?php echo Tools::IsValid($modal) ? $modal->msg : "";?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?php echo SITE_URL; ?>/assets/jquery/jquery-1.11.1.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/jquery/jquery_ui/jquery-ui.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/dropzone/dropzone.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/datepicker/js/moment.min.js"></script>    
    <script src="<?php echo SITE_URL; ?>/assets/datepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/datatables/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/datatables/media/js/pagination.js"></script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '202639963647616',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.12'
            });        
            FB.AppEvents.logPageView();               
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.12&appId=202639963647616&autoLogAppEvents=1';                     
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="<?php echo SITE_URL; ?>/js/funcoes.js"></script>

    <?php if(Tools::IsValid($modal)): ?>
        <script>
            $('#myModal').modal('show');
        </script>
    <?php else: ?>
        <script>
            $('#myModal').modal('hide');
        </script>    
    <?php endif; ?>
</body>

</html>
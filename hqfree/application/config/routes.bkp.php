<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		        my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']                                = 'Home';
$route['404_override']                                      = '';
$route['translate_uri_dashes']                              = FALSE;


$route['listagem']                                       = 'Home/ListagemHq';
$route['home/paginacao']['GET']                          = 'Home/HomePaginacao';
$route['visao/geral/(:any)']                             = 'Home/VisaoGeral/$1';
$route['leitura/classica/(:any)/(:any)/(:any)']          = 'Home/LeituraClassica/$1/$2/$3';
$route['leitura/completa/(:any)/(:any)']                 = 'Home/LeituraCompleta/$1/$2';
$route['consultar']['POST']                              = 'Home/ConsultarRevista';
$route['filtrar']['POST']                                = 'Home/FiltraListagem';

$route['usuario']                                            = 'Usuario';
$route['usuario/login']['POST']                              = 'Usuario/Login';
$route['reenviar/senha']['POST']                             = 'Usuario/ReenvioSenha';
$route['alterar/senha']['POST']                              = 'Usuario/AlterarSenha';
$route['usuario/logoff']['PATCH']                            = 'Usuario/LogOff';
$route['usuario/cadastro']['POST']                           = 'Usuario/CadastrarUsuario';
$route['usuario/cadastro/geral']['POST']                     = 'Usuario/Cadastrar';
$route['usuario/excluir/(:any)']['DELETE']                   = 'Usuario/Excluir/$1';
$route['usuario/status/(:any)']['PATCH']                     = 'Usuario/AlterarStatus/$1';
$route['usuario/alteracao/(:any)']                           = 'Usuario/CarregaAlterar/$1';
$route['usuario/alterar']['POST']                            = 'Usuario/AlterarUsuario';
$route['add/favoritos']['POST']                              = 'Usuario/AddFavoritos';
$route['dashboard']                                          = 'Usuario/UsuarioDashboard';
$route['login/facebook']                                     = 'Usuario/LoginFacebook';

$route['revista']                                   = 'Revista';
$route['upload']                                    = 'Revista/Upload';
$route['revista/votar']['POST']                     = 'Revista/GravarVotoRevista';
$route['revista/cadastro/geral']['POST']            = 'Revista/Cadastrar';
$route['revista/excluir/(:any)']['DELETE']          = 'Revista/Excluir/$1';
$route['revista/status/(:any)']['PATCH']            = 'Revista/AlterarStatus/$1';
$route['revista/alteracao/(:any)']                  = 'Revista/CarregaAlterar/$1';
$route['revista/alterar']['POST']                   = 'Revista/AlterarRevista';
$route['revista/capitulo/(:any)']                   = 'Capitulo/CadastroCapitulo/$1';

$route['capitulo/cadastro/geral']['POST']            = 'Capitulo/Cadastrar';
$route['capitulo/excluir/(:any)/(:any)']['DELETE']   = 'Capitulo/Excluir/$1/$2';
$route['capitulo/alteracao/(:any)/(:any)']           = 'Capitulo/CarregaAlterar/$1/$2';
$route['capitulo/alterar']['POST']                   = 'Capitulo/AlterarCapitulo';
$route['upload/alteracao']                           = 'Capitulo/UploadAlteracao';

$route['editora']                                            = 'Editora';
$route['editora/cadastro/geral']['POST']                     = 'Editora/Cadastrar';
$route['editora/excluir/(:any)']['DELETE']                   = 'Editora/Excluir/$1';
$route['editora/alteracao/(:any)']                           = 'Editora/CarregaAlterar/$1';
$route['editora/alterar']['POST']                            = 'Editora/AlterarEditora';

$route['grupo']                                            = 'Grupo';
$route['grupos/parceiros']                                 = 'Grupo/GruposParceiros';
$route['grupo/cadastro/geral']['POST']                     = 'Grupo/Cadastrar';
$route['grupo/excluir/(:any)']['DELETE']                   = 'Grupo/Excluir/$1';
$route['grupo/alteracao/(:any)']                           = 'Grupo/CarregaAlterar/$1';
$route['grupo/alterar']['POST']                            = 'Grupo/AlterarGrupo';
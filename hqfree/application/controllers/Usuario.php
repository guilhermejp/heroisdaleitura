<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once(CONTROLLER_BASE);

/**
 * @class Home
 */
class Usuario extends ControllerBase {

    /**
     * @method Construct
     */
    public function __construct() {
        parent::__construct();

        $this->titleView = 'Heróis da Leitura';
        $this->pageView = 'admin/cadastro-usuario';

        $this->load->helper('send_mail');
        $this->load->helper('html');

        $this->LoadModel(Model::$USUARIO);
        $this->LoadModel(Model::$FAVORITOS);
        $this->LoadModel(Model::$LEITURA);
    }

    public function Index() {
        // Inside helper (login_helper)
        checkAdmin();

        $data = null;
        $data['usuarios'] = $this->UsuarioModel->GetUsuarioByEmail(null);

        $usuario = new stdClass();
        $usuario->id = 0;
        $usuario->nome = "";
        $usuario->email = "";
        $usuario->senha = "";
        $usuario->tipo = "";
        $data['usuario'] = $usuario;

        $this->LoadView($data);
    }

    public function Login() {
        $data = NULL;
        $code = -1;
        $message = "";

        $usermail = $this->input->post('emaillogin', TRUE);
        $password = $this->input->post('senhalogin', TRUE);
        $remember = $this->input->post('remember', TRUE);

        if (Tools::IsValid($usermail) && Tools::IsValid($password)) {
            $pwdMD5 = strtoupper(Security::GenerateMD5($password));
            $obj = $this->UsuarioModel->GetUsuarioByEmail($usermail);

            if (Tools::IsValid($obj) && Tools::Equals($obj[0]->senha, $pwdMD5)) {
                if ($obj[0]->ativo) {
                    $obj[0]->senha = NULL;
                    $this->session->set_userdata(SESSION_ACCOUNT, $obj[0]);
                    $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);

                    if (Tools::Equals($remember, "S")) {
                        setcookie('remember_me', (string) base64_encode($obj[0]->id), 0, "/");
                    }

                    $code = 0;
                    $message = 'success';
                    $data = $obj[0];
                } else {
                    $code = -1;
                    $message = 'Usuário inativo!';
                }
            } else {
                $code = -1;
                $message = 'Usuário/senha inválido!';
            }
        }

        $this->LoadJson($code, $message, $data);
    }

    public function AlterarSenha() {
        $data = NULL;
        $code = -1;
        $message = "";

        $email = $this->input->post('emailtroca', TRUE);
        $senhaatual = $this->input->post('senhaatual', TRUE);
        $senhanova = $this->input->post('senhanova', TRUE);
        $senhaconf = $this->input->post('senhaconf', TRUE);

        if (Tools::IsValid($email) && Tools::IsValid($senhaatual)) {
            $senhaatualcryp = strtoupper(Security::GenerateMD5($senhaatual));
            $obj = $this->UsuarioModel->GetUsuarioByEmail($email);

            if (Tools::IsValid($obj) && Tools::Equals($obj[0]->senha, $senhaatualcryp)) {
                if (Tools::Equals($senhanova, $senhaconf)) {

                    $usuario = $obj[0];

                    $usuario->senha = strtoupper(Security::GenerateMD5($senhanova));
                    $where = array('id' => (int) $usuario->id);
                    if ($this->UsuarioModel->Update($usuario, $where, false)) {

                        $usuario->senha = NULL;
                        $this->session->set_userdata(SESSION_ACCOUNT, $usuario);
                        $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);

                        $code = 0;
                        $message = 'success';
                        $data = $usuario;
                    } else {
                        $message = 'Erro ao alterar senha';
                    }
                } else {
                    $message = 'Confirmação de senha não confere!';
                }
            } else {
                $message = 'Usuário/senha inválido!';
            }
        }

        $this->LoadJson($code, $message, $data);
    }

    public function ReenvioSenha() {
        $data = NULL;
        $code = -1;
        $message = "E-mail não cadastrado!!";

        try {
            $email = $this->input->post('emailforgot', TRUE);

            $obj = $this->UsuarioModel->GetUsuarioByEmail($email);

            if (Tools::IsValid($obj) && sizeof($obj) > 0) {
                $usuario = $obj[0];
                $this->db->trans_begin();

                $novasenha = TRIM(Tools::randomPassword());
                $usuario->senha = strtoupper(Security::GenerateMD5($novasenha));

                $where = array('id' => $usuario->id);
                if ($this->UsuarioModel->Update($usuario, $where, false)) {

                    $mailContent = "<h2><strong>Nova senha</strong></h2>\n";
                    $mailContent .= "<p><b>Login:</b> " . strtolower($email) . "</p>\n";
                    $mailContent .= "<p><b>Senha:</b> " . $novasenha . "</p>\n";

                    $mailContent = Html::GetHTML($mailContent);

                    if (SendMail::send_email($email, "[Esqueci minha senha] - Nova Senha", $mailContent)) {
                        $this->db->trans_commit();
                        $code = 0;
                        $message = 'success';
                    } else {
                        $this->db->trans_rollback();
                        $message = 'Erro ao enviar e-mail';
                    }
                } else {
                    $message = 'Erro ao alterar a senha';
                    $this->db->trans_rollback();
                }
            }
        } catch (Exception $e) {
            log_message('error', sprintf('(AddLeitura) ERRO: %s', $e->getMessage()));
        } finally {
            //limpar o historico
        }

        $this->LoadJson($code, $message, $data);
    }

    public function LogOff() {
        $data = NULL;
        $code = 0;
        $message = 'success';

        session_destroy();

        if (isset($_COOKIE["remember_me"])) {
            delete_cookie('remember_me');
        }

        $this->LoadJson($code, $message, $data);
    }

    public function CadastrarUsuario() {
        // Inside helper (login_helper)
        checkAdmin();

        $data = NULL;
        $code = -1;
        $message = "";

        $username = $this->input->post('username', TRUE);
        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);
        $confirmpass = $this->input->post('confirm-password', TRUE);

        if (Tools::Equals($password, $confirmpass)) {
            $obj = $this->UsuarioModel->GetUsuarioByEmail($email);

            if (!Tools::IsValid($obj)) {

                $usuario = new stdClass();
                $usuario->nome = $username;
                $usuario->email = $email;
                $usuario->senha = strtoupper(Security::GenerateMD5($confirmpass));
                $usuario->ativo = 1;
                $usuario->tipo = "U";
                $usuario->id_facebook = 0;

                $code = $this->UsuarioModel->Save($usuario);

                if ($code) {
                    $usuario->senha = NULL;
                    $usuario->id = $code;
                    $this->session->set_userdata(SESSION_ACCOUNT, $usuario);
                    $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);

                    $code = 0;
                    $message = 'success';
                    $data = $usuario;
                } else {
                    $code = -1;
                    $message = 'Erro ao cadastra  usuário';
                }
            } else {
                $code = -1;
                $message = 'E-mail já cadastrado!';
            }
        } else {
            $code = -1;
            $message = 'Confirmação incorreta!';
        }

        $this->LoadJson($code, $message, $data);
    }

    public function Cadastrar() {
        // Inside helper (login_helper)
        checkAdmin();
            
        $data = NULL;
        $code = -1;
        $message = "";

        $nome = $this->input->post('nomeusuario', TRUE);
        $tipo = $this->input->post('tipousuario', TRUE);
        $email = $this->input->post('emailusuario', TRUE);
        $password = $this->input->post('senhausuario', TRUE);
        $confirmpass = $this->input->post('senhaconf', TRUE);

        if (Tools::Equals($password, $confirmpass)) {
            $obj = $this->UsuarioModel->GetUsuarioByEmail($email);

            if (!Tools::IsValid($obj)) {

                $usuario = new stdClass();
                $usuario->nome = $nome;
                $usuario->email = $email;
                $usuario->senha = strtoupper(Security::GenerateMD5($confirmpass));
                $usuario->ativo = 1;
                $usuario->tipo = $tipo;

                $code = $this->UsuarioModel->Save($usuario);

                if ($code) {
                    $usuario->id = $code;
                    $code = 0;
                    $message = 'success';
                    $data = $usuario;
                } else {
                    $code = -1;
                    $message = 'Erro ao cadastrar usuário';
                }
            } else {
                $code = -1;
                $message = 'E-mail já cadastrado!';
            }
        } else {
            $code = -1;
            $message = 'Confirmação incorreta!';
        }

        $this->LoadJson($code, $message, $data);
    }

    public function Excluir($idusuario) {
        // Inside helper (login_helper)
        checkAdmin();

        $data = null;
        $code = -1;
        $message = 'Erro';

        try {
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            if ($this->UsuarioModel->Delete(NULL, array('id' => (int) $idusuario))) {
                $code = 1;
                $message = "OK";
            }

            //}
        } catch (Exception $e) {
            $code = -1;
            $message = "Erro excluir usuário!";
            log_message('error', sprintf('(ExcluirUsuario) ERRO: %s', $e->getMessage()));
        }

        $this->LoadJson($code, $message, $data);
    }

    public function AlterarStatus($id) {
        // Inside helper (login_helper)
        checkAdmin();
        
        $data = null;
        $code = -1;
        $message = 'erro';

        try {
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            $usuario = $this->UsuarioModel->GetById($id);

            if (Tools::IsValid($usuario)) {
                $status = $usuario->ativo;
                $usuario->ativo = $status ? false : true;

                $where = array('id' => (int) $id);
                if ($this->UsuarioModel->Update($usuario, $where, false)) {
                    $code = 1;
                    $message = "OK";
                }
            } else {
                $code = 0;
                $message = "Invalido";
            }

            //}
        } catch (Exception $e) {
            $code = -1;
            $message = "Erro alterar status usuários!";
            log_message('error', sprintf('(ExcluirUsuario) ERRO: %s', $e->getMessage()));
        }

        $data['usuarios'] = $this->UsuarioModel->GetUsuarioByEmail(null);

        $this->LoadJson($code, $message, $data);
    }

    public function CarregaAlterar($id) {
        $data = null;
        $code = -1;
        $message = '';

        $data['usuarios'] = $this->UsuarioModel->GetUsuarioByEmail(null);
        $data['usuario'] = $this->UsuarioModel->GetById($id);

        $this->LoadView($data);
    }

    public function AlterarUsuario() {
        // Inside helper (login_helper)
        checkAdmin();
        
        $data = NULL;
        $code = -1;
        $message = "erro";

        $nome = $this->input->post('nomeusuario', TRUE);
        $tipo = $this->input->post('tipousuario', TRUE);
        $email = $this->input->post('emailusuario', TRUE);
        $password = $this->input->post('senhausuario', TRUE);
        $confirmpass = $this->input->post('senhaconf', TRUE);
        $id = $this->input->post('hdnId', TRUE);

        $alterasenha = false;
        if ($password != "") {
            $alterasenha = true;
        }

        if ($alterasenha && !Tools::Equals($password, $confirmpass)) {
            $code = -1;
            $message = 'Confirmação incorreta!';
        } else {

            $obj = $this->UsuarioModel->GetById($id);

            if (Tools::IsValid($obj)) {

                $obj->nome = $nome;
                $obj->email = $email;
                $obj->tipo = $tipo;

                if ($alterasenha) {
                    $obj->senha = strtoupper(Security::GenerateMD5($confirmpass));
                }

                $where = array('id' => (int) $id);
                if ($this->UsuarioModel->Update($obj, $where, false)) {
                    $code = 0;
                    $message = 'success';
                    $data = $obj;
                } else {
                    $code = -1;
                    $message = 'Erro ao alerar o usuário';
                }
            } else {
                $code = -1;
                $message = 'Usuário não localizado para alteração!';
            }
        }

        $this->LoadJson($code, $message, $data);
    }

    public function AddFavoritos() {
        $data = NULL;
        $code = -1;
        $message = "";

        try {
            if ($this->HasUserSession() && Tools::IsValid($this->userSession)) {
                $idrevista = $this->input->post('idrevista', TRUE);
                $idusuario = $this->userSession->id;

                $favorito = $this->FavoritosModel->GetRegistroFavorito($idusuario, $idrevista);

                if (Tools::IsValid($favorito)) {
                    $where = array('id_usuario' => (int) $idusuario, 'id_revista' => (int) $idrevista);
                    $this->FavoritosModel->Delete(NULL, $where);
                    $message = "HQ removida!";
                    $code = 0;
                } else {
                    $favorito = new stdClass();
                    $favorito->id_revista = $idrevista;
                    $favorito->id_usuario = $idusuario;
                    $this->FavoritosModel->Save($favorito, false);
                    $message = "HQ adicionada!";
                    $code = 1;
                }
            }
        } catch (Exception $e) {
            log_message('error', sprintf('(AddFavoritos) ERRO: %s', $e->getMessage()));
        } finally {
            //limpar o historico
        }

        $this->LoadJson($code, $message, $data);
    }

    public function UsuarioDashboard() {
        $data = null;

        if ($this->IsValidSession() && Tools::IsValid($this->userSession)) {
            $this->pageView = 'user/dashboard-usuario';
            $data['favoritos'] = $this->FavoritosModel->GetFavoritos($this->userSession->id);
            $data['histleitura'] = $this->LeituraModel->GetHistLeitura($this->userSession->id);
            $data['novidades'] = $this->RevistaModel->GetAllRevitaOrderByDate();
        } else {
            $this->pageView = 'home/home-page';
        }

        $this->LoadView($data);
    }

    public function LoginFacebook() {
        $data = NULL;
        $code = -1;
        $message = "";

        $username = $this->input->post('username', TRUE);
        $email = $this->input->post('email', TRUE);
        $idfacebook = $this->input->post('idfacebook', TRUE);
        $remember = $this->input->post('remember', TRUE);
        $password = TRIM(Tools::randomPassword());

        $obj = $this->UsuarioModel->GetUsuarioByFacebookID($idfacebook);

        if (!Tools::IsValid($obj)) {

            $usuario = new stdClass();
            $usuario->nome = $username;
            $usuario->email = $email;
            $usuario->senha = strtoupper(Security::GenerateMD5($password));
            $usuario->ativo = 1;
            $usuario->tipo = "U";
            $usuario->id_facebook = $idfacebook;

            $code = $this->UsuarioModel->Save($usuario);

            if ($code) {
                $usuario->senha = NULL;
                $usuario->id = $code;
                $this->session->set_userdata(SESSION_ACCOUNT, $usuario);
                $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);

                $code = 0;
                $message = 'success';
                $data = $usuario;
            } else {
                $code = -1;
                $message = 'Erro ao cadastra  usuário';
            }
        } else {
            $code = 0;
            $message = 'login facebook id';

            if ($obj[0]->ativo) {
                $obj[0]->senha = NULL;
                $this->session->set_userdata(SESSION_ACCOUNT, $obj[0]);
                $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);

                if (Tools::Equals($remember, "S")) {
                    setcookie('remember_me', (string) base64_encode($obj[0]->id), 0, "/");
                }

                $code = 0;
                $message = 'success';
                $data = $obj[0];
            } else {
                $code = -1;
                $message = 'Usuário inativo no sistema!';
            }
        }

        $this->LoadJson($code, $message, $data);
    }

}

?>
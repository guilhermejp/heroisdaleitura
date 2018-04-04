<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include_once(CONTROLLER_BASE);
/**
* @class Home
*/
class Grupo extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->titleView    = 'Heróis da Leitura';
        $this->pageView     = 'admin/cadastro-grupo';
        
        $this->LoadModel(Model::$GRUPO);
    }

    public function Index()
    {
        $data = null;    
        $data['grupos'] = $this->GrupoModel->GetAll();        

        $grupo = new stdClass();                                    
        $grupo->id            = 0;
        $grupo->nome_grupo         = "";
        $grupo->url_grupo          = "";

        $data['grupo']  = $grupo;

        $this->LoadView($data);
    }

    public function Cadastrar()
    {        
        $data    = NULL;
        $code    = -1;
        $message = ""; 
      
        $nome           = $this->input->post('grupo_parceiro', TRUE);
        $url            = $this->input->post('url_parceiro', TRUE);

        $grupo       = new stdClass();                                    
        $grupo->nome_grupo = $nome;
        $grupo->url_grupo  = $url;

        $code = $this->GrupoModel->Save($grupo);

        if($code)
        {
            $code    = 0;
            $message = 'success';
            $data    = $grupo; 
        }else{
            $code    = -1;
            $message = 'Erro ao cadastrar grupo';
        }
            
        $this->LoadJson($code, $message, $data);
    }
    
    public function Excluir($id)
    {        
        $data    = null;
        $code    = -1;
        $message = 'Erro';

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            if($this->GrupoModel->Delete(NULL, array('id' => (int) $id))){
                $code = 1;
                $message = "OK";
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro excluir grupo!";            
            log_message('error', sprintf('(Excluirgrupo) ERRO: %s', $e->getMessage()));
        }
                
        $data['grupos'] = $this->GrupoModel->GetAll();
            
        $this->LoadJson($code, $message, $data);
    }

    public function CarregaAlterar($id)
    {        
        $data    = null;
        $code    = -1;
        $message = '';

        $data['grupos']    = $this->GrupoModel->GetAll();      
        $data['grupo']     = $this->GrupoModel->GetById($id);
         
        $this->LoadView($data);
    }

    public function AlterarGrupo()
    {        
        $data    = NULL;
        $code    = -1;
        $message = "erro"; 
      
        $nome           = $this->input->post('grupo_parceiro', TRUE);
        $url            = $this->input->post('url_parceiro', TRUE);
        $id             = $this->input->post('hdnId', TRUE);

        $obj = $this->GrupoModel->GetById($id);
            
        if(Tools::IsValid($obj)){

            $obj->nome_grupo         = $nome;
            $obj->url_grupo          = $url;
            $where = array('id' => (int) $id); 
            if($this->GrupoModel->Update($obj, $where, false)){                        
                $code    = 0;
                $message = 'success';
                $data    = $obj;                   
            }else{
                $code    = -1;
                $message = 'Erro ao alerar o grupo';
            }
        }else{
            $code    = -1;
            $message = 'Grupo não localizada para alteração!';
        }
            
        $this->LoadJson($code, $message, $data);
    }

    public function GruposParceiros()
    {
        $data = null;  
        $this->pageView     = 'home/grupos-parceiros';
        $this->activeSearch = true;
        $data['grupos']    = $this->GrupoModel->GetAll();      
        $this->LoadView($data);
    } 
}

?>
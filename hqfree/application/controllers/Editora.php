<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include_once(CONTROLLER_BASE);
/**
* @class Home
*/
class Editora extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->titleView    = 'Heróis da Leitura';
        $this->pageView     = 'admin/cadastro-editora';
        
        $this->LoadModel(Model::$EDITORA);
    }

    public function Index()
    {
        // Inside helper (login_helper)
        checkAdmin();
        
        $data = null;    
        $data['editoras'] = $this->EditoraModel->GetAll();        

        $editora = new stdClass();                                    
        $editora->id            = 0;
        $editora->nome          = "";

        $data['editora']  = $editora;

        $this->LoadView($data);
    }

    public function Cadastrar()
    {        
        // Inside helper (login_helper)
        checkAdmin();
        
        $data    = NULL;
        $code    = -1;
        $message = ""; 
      
        $nome           = $this->input->post('nomeeditora', TRUE);

        $obj = $this->EditoraModel->GetByNome($nome);

        if(!Tools::IsValid($obj)){

            $editora       = new stdClass();                                    
            $editora->nome = $nome;

            $code = $this->EditoraModel->Save($editora);

            if($code)
            {
                $code    = 0;
                $message = 'success';
                $data    = $editora; 
            }else{
                $code    = -1;
                $message = 'Erro ao cadastrar editora';
            }
        }else{
            $code    = -1;
            $message = 'Editora já cadastrada!';
        }
            
        $this->LoadJson($code, $message, $data);
    }
    
    public function Excluir($id)
    {        
        // Inside helper (login_helper)
        checkAdmin();
        
        $data    = null;
        $code    = -1;
        $message = 'Erro';

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            if($this->EditoraModel->Delete(NULL, array('id' => (int) $id))){
                $code = 1;
                $message = "OK";
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro excluir editora!";            
            log_message('error', sprintf('(ExcluirEditora) ERRO: %s', $e->getMessage()));
        }
                
        $data['editoras'] = $this->EditoraModel->GetAll();
            
        $this->LoadJson($code, $message, $data);
    }

    public function CarregaAlterar($id)
    {        
        // Inside helper (login_helper)
        checkAdmin();
        
        $data    = null;
        $code    = -1;
        $message = '';

        $data['editoras']    = $this->EditoraModel->GetAll();      
        $data['editora']     = $this->EditoraModel->GetById($id);
         
        $this->LoadView($data);
    }

    public function AlterarEditora()
    {        
        // Inside helper (login_helper)
        checkAdmin();
        
        $data    = NULL;
        $code    = -1;
        $message = "erro"; 
      
        $nome           = $this->input->post('nomeeditora', TRUE);
        $id             = $this->input->post('hdnId', TRUE);

        $obj = $this->EditoraModel->GetById($id);
            
        if(Tools::IsValid($obj)){

            $obj->nome          = $nome;
            $where = array('id' => (int) $id); 
            if($this->EditoraModel->Update($obj, $where, false)){                        
                $code    = 0;
                $message = 'success';
                $data    = $obj;                   
            }else{
                $code    = -1;
                $message = 'Erro ao alerar o editora';
            }
        }else{
            $code    = -1;
            $message = 'Editora não localizada para alteração!';
        }
            
        $this->LoadJson($code, $message, $data);
    }
}

?>
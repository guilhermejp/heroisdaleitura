<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include_once(CONTROLLER_BASE);

/**
* @class Revista
*/
class Revista extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->titleView    = 'Heróis da Leitura';
        $this->pageView     = 'admin/cadastro-revista';
        
        $this->LoadModel(Model::$REVISTAPAGINA);
        $this->LoadModel(Model::$VOTACAO);
        $this->LoadModel(Model::$EDITORA);
        $this->LoadModel(Model::$GRUPO);
    }
    
    public function Index()
    {
        $data = null;  
        $data['editoras'] = $this->EditoraModel->GetAll();
        $data['revistas'] = $this->RevistaModel->GetRevistas();    
        $data['grupos'] = $this->GrupoModel->GetAll();            

        $revista = new stdClass();     
        $revista->id              = 0;                               
        $revista->titulo          = "";
        $revista->id_editora      = "";
        $revista->status          = "";
        $revista->id_grupo        = "";        
        $revista->sinopse         = "";
        
        $data['revista'] = $revista;

        $this->LoadView($data);
    }    


    public function Cadastrar()
    {        
        $data    = NULL;
        $code    = -1;
        $message = ""; 
      
        $revista = new stdClass();                                    
        $revista->titulo          = $this->input->post('titulo', TRUE);
        $revista->id_editora      = $this->input->post('editora', TRUE);
        $revista->status          = $this->input->post('status', TRUE);
        $revista->id_grupo        = $this->input->post('grupo', TRUE);        
        $revista->sinopse         = $this->input->post('sinopse', TRUE);
        $revista->ativo           = true;

        $obj = $this->RevistaModel->Select("*", array('titulo' => $revista->titulo));

        if(!Tools::IsValid($obj)){
            $code = $this->RevistaModel->Save($revista);

            if($code)
            {
                $revista->id = $code;
                $code    = 0;
                $message = 'success';
                $data    = $revista; 
            }else{
                $code    = -1;
                $message = 'Erro ao cadastrar HQ';
            }
        }else{
            $code    = -1;
            $message = 'Atenção! Já existe uma HQ com este título cadastrada.';
        }
            
        $this->LoadJson($code, $message, $data);
    }
    
    public function Excluir($idrevista)
    {        
        $data    = null;
        $code    = -1;
        $message = 'Erro';

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            if($this->RevistaModel->Delete(NULL, array('id' => (int) $idrevista))){  

                if($this->RevistapaginaModel->Delete(NULL, array('id_revista' => (int) $idrevista))){
                    $code = 1;
                    $message = "OK";               

                    $dirrevista     = SITE_PATH.'/img/hq/'.$idrevista;

                    if(is_dir($dirrevista)){
                      Tools::ApagaDir($dirrevista);                  
                    }        
                }   
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro excluir HQ!";            
            log_message('error', sprintf('(ExcluirHQ) ERRO: %s', $e->getMessage()));
        }
            
        $this->LoadJson($code, $message, $data);
    }

    public function AlterarStatus($id)
    {        
        $data    = null;
        $code    = -1;
        $message = 'erro';

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {
            
            $revista = $this->RevistaModel->GetById($id);
            
            if(Tools::IsValid($revista)){
                $status = $revista->ativo;
                $revista->ativo = $status ? false : true;

                $where = array('id' => (int)$id); 
                if($this->RevistaModel->Update($revista, $where, false)){
                    $code = 1;
                    $message = "OK";
                }

            }else{
                $code = 0;
                $message = "Invalido";
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro alterar status usuários!";            
            log_message('error', sprintf('(ExcluirRevista) ERRO: %s', $e->getMessage()));
        }
                
        $data['editoras'] = $this->EditoraModel->GetAll();
        $data['revistas'] = $this->RevistaModel->GetRevistas();       
            
        $this->LoadJson($code, $message, $data);
    }

    public function CarregaAlterar($id)
    {        
        $data    = null;
        $code    = -1;
        $message = '';

        $data['editoras']     = $this->EditoraModel->GetAll();
        $data['revistas']     = $this->RevistaModel->GetRevistas();       
        $data['revista']      = $this->RevistaModel->GetById($id);
        $data['grupos'] = $this->GrupoModel->GetAll(); 
         
        $this->LoadView($data);
    }

    public function AlterarRevista()
    {        
        $data    = NULL;
        $code    = -1;
        $message = "erro"; 
      
        $id              = $this->input->post('hdnId', TRUE);

        $obj = $this->RevistaModel->GetById($id);
            
        if(Tools::IsValid($obj)){

            $obj->titulo          = $this->input->post('titulo', TRUE);
            $obj->id_editora      = $this->input->post('editora', TRUE);
            $obj->status          = $this->input->post('status', TRUE);
            $obj->id_grupo        = $this->input->post('grupo', TRUE);            
            $obj->sinopse         = $this->input->post('sinopse', TRUE);

            $where = array('id' => (int) $id); 
            if($this->RevistaModel->Update($obj, $where, false)){                        
                $code    = 0;
                $message = 'success';
                $data    = $obj;                   
            }else{
                $code    = -1;
                $message = 'Erro ao alerar o HQ';
            }
        }else{
            $code    = -1;
            $message = 'HQ não localizado para alteração!';
        }
            
        $this->LoadJson($code, $message, $data);
    }

    public function GravarVotoRevista()
    {        
        $data    = NULL;
        $code    = -1;
        $message = ""; 
      
        $idrevista      = $this->input->post('idrevista', TRUE);
        $nota           = $this->input->post('nota', TRUE);

        if($this->IsValidSession() && Tools::IsValid($this->userSession)) {
            
            $idusuario = $this->userSession->id;           

            if($idusuario > 0){
                $this->VotacaoModel->Delete(NULL, array('id_usuario' => (int) $idusuario, 'id_revista' => $idrevista));

                $votacao       = new stdClass();                                    
                $votacao->id_usuario = $idusuario;
                $votacao->id_revista = $idrevista;
                $votacao->voto = $nota;

                if($this->VotacaoModel->Save($votacao, false))
                {
                    $code    = 0;
                    $message = 'OK';
                    $data    = $votacao; 
                }else{
                    $code    = -1;
                    $message = 'Erro ao gravar voto';
                }
            }
        }


            
        $this->LoadJson($code, $message, $data);
    }

    
    public function Upload() {
        if (!empty($_FILES)) {

            $idRevista  = $this->input->post('idRevista', TRUE);
            $idCapitulo  = $this->input->post('idCapitulo', TRUE);
            $targetPath = getcwd()."/img/temp/$idRevista/$idCapitulo/";

            if (!is_dir($targetPath) && strlen($targetPath)>0){
                mkdir($targetPath, 0777, true);
            }
            
            $fileOrderByName = $_FILES['file']['name'];
            $tmpFileName     = $_FILES['file']['tmp_name'];

            asort($fileOrderByName);

            foreach( $fileOrderByName as $chave => $valor ){
                $tempFile = $tmpFileName[$chave];
                $fileName = Tools::RemoveSpecialCaracterUpload($valor);

                $targetFile = $targetPath . $fileName ;
                $rs = move_uploaded_file($tempFile, $targetFile);    
            }
        }
    }
}

?>
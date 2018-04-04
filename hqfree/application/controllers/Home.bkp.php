<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include_once(CONTROLLER_BASE);

/**
* @class Home
*/
class Home extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->titleView    = 'Heróis da Leitura';
        $this->pageView     = 'home/home-page'; //PageView::HOME;
        
        $this->LoadModel(Model::$VOTACAO);
        $this->LoadModel(Model::$EDITORA);
        $this->LoadModel(Model::$REVISTAPAGINA);
        $this->LoadModel(Model::$LEITURA);
        $this->LoadModel(Model::$USUARIO);
    }
    
    public function Index()
    {
        $data = null;          
        $data['maisvistas'] = $this->RevistaModel->GetAllRevitaOrderByViews();  
        $data['maisvotados'] = $this->RevistaModel->GetAllRevitaOrderByVote();  
    
        $this->activeSearch = true;     
            
        if(isset($_COOKIE["remember_me"])){
        
            $idusuario = base64_decode($_COOKIE["remember_me"]);
            
            $obj = $this->UsuarioModel->GetById($idusuario);
        
            if(Tools::IsValid($obj))
            {
                if($obj->ativo)
                {
                    $obj->senha = NULL;                                 
                    $this->session->set_userdata(SESSION_ACCOUNT, $obj);  
                    $this->session->mark_as_temp(SESSION_ACCOUNT, TIME_SESSION_ACCOUNT);                               
                }
            }
            
        }

        $this->LoadView($data);
    }    

    public function HomePaginacao()
    {
        $data = null;  
        
        $idusuario = 0;        
        if($this->HasUserSession() && Tools::IsValid($this->userSession)){
            $idusuario = $this->userSession->id;
        }

        $data['revistas'] = $this->RevistaModel->GetAllRevista($idusuario);  

        $this->LoadJson(0, '', $data);
    }   

    
    public function ListagemHq()
    {
        $data = null;  
        
        $this->pageView     = 'home/lista-hq';
        $this->activeSearch = true;

        $idusuario = 0;        
        if($this->HasUserSession() && Tools::IsValid($this->userSession)){
            $idusuario = $this->userSession->id;
        }
        
        $data['revistas'] = $this->RevistaModel->GetAllRevista($idusuario); 
        $data['editoras'] = $this->EditoraModel->GetAll();       
        $data['filtro_ordem'] = "";
        $data['filtro_editora'] = "";
        $data['filtro']   = "";
       
        $this->LoadView($data);
    } 

    public function ConsultarRevista(){
        $titulo      = $this->input->post('search_topo', TRUE);
        
        $data = null;  
        $this->pageView     = 'home/lista-hq';
        $this->activeSearch = true;

        $idusuario = 0;        
        if($this->HasUserSession() && Tools::IsValid($this->userSession)){
            $idusuario = $this->userSession->id;
        }

        $data['editoras'] = $this->EditoraModel->GetAll();       
        $data['revistas'] = $this->RevistaModel->GetRevistaByFilro($titulo, null, null, $idusuario); 
        $data['filtro']   = $titulo;
        $data['filtro_ordem'] = "";
        $data['filtro_editora'] = "";
        
        $this->LoadView($data);
    } 

    public function FiltraListagem(){
        $editora      = $this->input->post('filtro_editora', TRUE);
        $ordem        = $this->input->post('filtro_ordem',   TRUE);
        
        $data = null;  
        $this->pageView     = 'home/lista-hq';
        $this->activeSearch = true;

        $idusuario = 0;        
        if($this->HasUserSession() && Tools::IsValid($this->userSession)){
            $idusuario = $this->userSession->id;
        }

        $data['editoras'] = $this->EditoraModel->GetAll();       
        $data['revistas'] = $this->RevistaModel->GetRevistaByFilro(null, $editora, $ordem, $idusuario);         
        $data['filtro_ordem'] = $ordem;
        $data['filtro_editora'] = $editora;

        $this->LoadView($data);
    }

    
    public function VisaoGeral($idrevista)
    {
        $data = null;  
        $this->pageView     = 'home/hq-visao-geral';
        $this->activeSearch = true;

        $revistacapitulos = $this->RevistaModel->GetRevistaVisalGeral($idrevista);
        $revista = $revistacapitulos[0];
        
        $capitulo = $this->RevistapaginaModel->GetCapitulosByRevista($idrevista);  

        if(Tools::IsValid($capitulo) && sizeof($capitulo) > 0){
            $revista->arquivo = $capitulo[0]->arquivo;
        }else{
            $revista->arquivo = "sem_imagem.jpg";
        }

        $data['capitulos'] = $capitulo;
        $data['revista'] = $revista; 

        if($this->HasUserSession() && Tools::IsValid($this->userSession)) {
            $id_usuario = $this->userSession->id;
            $votacao = $this->VotacaoModel->GetVote($id_usuario, $idrevista);
            
            if(Tools::IsValid($votacao)){
                $data['voto_revista'] = $votacao->voto;
            }else{
                $data['voto_revista'] = '';
            }
        }

        //Soma visualizações
        $this->Views($idrevista);

        $this->LoadView($data);
    } 

    private function Views($idrevista){
        $revista = $this->RevistaModel->GetById($idrevista);

        $viewstotal = $revista->views;
        $viewstotal = $viewstotal + 1;
        
        $revista->views = $viewstotal;

        $where = array('id' => (int) $idrevista); 
        $this->RevistaModel->Update($revista, $where, false);
    }

    public function LeituraClassica($idrevista, $ordem, $capitulo)
    {
        $data = null;  
        $this->pageView     = 'home/hq-visao1';
        $this->activeSearch = true;

        $data['revista'] = $this->RevistaModel->GetRevistaById($idrevista, null, $capitulo); 
        $data['revista_ordem'] = $ordem;
        
        $ultima_pag = sizeof($data['revista']) - 1;
        $prox_pag = $ordem + 1;

        if($prox_pag > $ultima_pag){
            $prox_pag = 0;
        }

        $data['prox_pag'] = $prox_pag;

        $this->AddLeitura($idrevista, $capitulo, $ordem);

        $this->LoadView($data);
    } 

    public function LeituraCompleta($idrevista, $capitulo)
    {
        $data = null;  
        $this->pageView     = 'home/hq-visao2';
        $this->activeSearch = true;
        $data['revista'] = $this->RevistaModel->GetRevistaById($idrevista, null, $capitulo);     

        $this->AddLeitura($idrevista, $capitulo);

        $this->LoadView($data);
    } 

    private function AddLeitura($idrevista, $capitulo, $ordem=0)
    {
        try {
            if($this->HasUserSession() && Tools::IsValid($this->userSession)) {
                $id_usuario = $this->userSession->id;
                $hist_leitura = $this->LeituraModel->GetLeituraPorRevista($id_usuario, $idrevista, $capitulo);
    
                if(!Tools::IsValid($hist_leitura)){
                    $hist_leitura = new stdClass();                                    
                    $hist_leitura->id_usuario       = $id_usuario;
                    $hist_leitura->id_revista       = $idrevista;
                    $hist_leitura->capitulo         = $capitulo;
                    $hist_leitura->ordem            = $ordem;
    
                    $hist_leitura = $this->LeituraModel->Save($hist_leitura, false);                
                }else{
                    $hist_leitura->data = date('Y-m-d H:i');                
                    if($ordem != 0){
                        $hist_leitura->ordem            = $ordem;
                    }
                    $where = array('id_usuario' => (int) $id_usuario, 'id_revista' => (int) $idrevista, 'capitulo' => (float) $capitulo); 
                    $this->LeituraModel->Update($hist_leitura, $where, false);
                }
            }
        } catch (Exception $e) {            
            log_message('error', sprintf('(AddLeitura) ERRO: %s', $e->getMessage()));
        } finally {
            //limpar o historico
        }
    }
}

?>
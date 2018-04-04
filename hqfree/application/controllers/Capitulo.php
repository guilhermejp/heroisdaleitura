<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include_once(CONTROLLER_BASE);

/**
* @class Revista
*/
class Capitulo extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->titleView    = 'Heróis da Leitura';
        $this->pageView     = 'admin/cadastro-capitulo';
        
        $this->LoadModel(Model::$REVISTAPAGINA);        
    }
    
    public function Index()
    {
      $data = null;  
      $this->pageView     = 'admin/cadastro-capitulo';                      
      $this->LoadView($data);
    }    

    public function CadastroCapitulo($idrevista){
      $data = null;  
      $this->pageView     = 'admin/cadastro-capitulo';                

      $data['revista']   =  $this->RevistaModel->GetById($idrevista);
      $data['capitulos'] = $this->RevistapaginaModel->GetTotalCapitulos($idrevista, null);
      $data['idrevistaprocesso'] = $idrevista;

      $obj =  new stdClass();
      $obj->nome_capitulo = "";
      $obj->especial      = 0;
      $obj->capitulo      = "";
      $obj->paginas       = null;
      $data['capitulo'] = $obj;
      
      // $dir_temp = SITE_PATH.'/img/temp/';
      // if(is_dir($dir_temp)){Tools::ApagaDir($dir_temp);}        
      
      $this->LoadView($data);
  }


    public function Cadastrar()
    {        
        $data    = NULL;
        $code    = -1;
        $message = ""; 
      
        $nomecapitulo     = $this->input->post('nome_capitulo', TRUE);
        $especial         = $this->input->post('especial', TRUE);
        $numerocapitulo   = $this->input->post('numero_capitulo', TRUE);
        $idrevista        = $this->input->post('hdnIdRevistaProcesso', TRUE);
        $paginas          = $this->input->post('hdnPaginas', TRUE);
        $dirtemp         = SITE_PATH."/img/temp/$idrevista/$numerocapitulo/";
        $dirrevista      = SITE_PATH.'/img/hq/'.$idrevista;
        $dircapitulo     = $dirrevista.'/Capitulo-'.$numerocapitulo;

        if (!is_dir($dirrevista) && strlen($dirrevista) > 0){ mkdir($dirrevista, 0777); }
        if (!is_dir($dircapitulo) && strlen($dircapitulo) > 0){ mkdir($dircapitulo, 0777); }
        
        $ordem = 0;
        foreach($paginas as $arquivopagina){          
            $capitulo = new stdClass(); 
            $capitulo->id_revista = $idrevista;
            $capitulo->ordem = $ordem++;
            $capitulo->arquivo = $idrevista.'/Capitulo-'.$numerocapitulo.'/'.$arquivopagina;
            $capitulo->capitulo = $numerocapitulo;
            $capitulo->descricao = $nomecapitulo;
            $capitulo->especial = Tools::Equals($especial, "S");
            
            $code = $this->RevistapaginaModel->Save($capitulo);

            if($code)
            {
                if (file_exists($dirtemp.$arquivopagina)){
                  rename($dirtemp.$arquivopagina, $dircapitulo.'/'.$arquivopagina);
                }
                $code    = 0;
                $message = 'success';
                continue;
            }else{
                $code    = -1;
                $message = 'Erro ao capítulo da HQ';
                break;
            }
        }
            
        $this->LoadJson($code, $message, $data);
    }
    
    public function Excluir($idrevista, $capitulo)
    {        
        $data    = null;
        $code    = -1;
        $message = 'Erro';

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            if($this->RevistapaginaModel->Delete(NULL, array('id_revista' => (int) $idrevista, 'capitulo' => (float) $capitulo))){
                $code = 1;
                $message = "OK";                
                $dircapitulo     = SITE_PATH.'/img/hq/'.$idrevista.'/Capitulo-'.$capitulo;

                if(is_dir($dircapitulo)){
                  Tools::ApagaDir($dircapitulo);                  
                }      
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro excluir HQ!";            
            log_message('error', sprintf('(ExcluirCapituloHQ) ERRO: %s', $e->getMessage()));
        }
                
        $data['capitulos'] = $this->RevistapaginaModel->GetTotalCapitulos($idrevista, null);
            
        $this->LoadJson($code, $message, $data);
    }

    public function CarregaAlterar($idrevista, $idcapitulo)
    {        
        $data    = null;
        $code    = -1;
        $message = '';

        $data['revista']   =  $this->RevistaModel->GetById($idrevista);
        $data['capitulos'] = $this->RevistapaginaModel->GetTotalCapitulos($idrevista, null);
        $capitulo          = $this->RevistapaginaModel->GetCapitulos($idrevista, $idcapitulo);

        $obj =  new stdClass();
        $obj->nome_capitulo = $capitulo[0]->descricao;
        $obj->especial      = $capitulo[0]->especial;
        $obj->capitulo      = (float) $capitulo[0]->capitulo;
        $obj->paginas       = $capitulo;
        $data['capitulo'] = $obj;

        $data['idrevistaprocesso'] = $idrevista;
         
        $this->LoadView($data);
    }

    public function UploadAlteracao() {
        if (!empty($_FILES) && !empty($_POST)) {
            $targetPath = getcwd().'/img/hq/'.$_POST['idRevista'].'/Capitulo-'.$_POST['idCapitulo'];

            if (is_dir($targetPath) && strlen($targetPath) > 0){

                $fileOrderByName = $_FILES['file']['name'];
                $tmpFileName     = $_FILES['file']['tmp_name'];
    
                asort($fileOrderByName);
    
                foreach( $fileOrderByName as $chave => $valor ){                
                    $tempFile = $tmpFileName[$chave];
                    $fileName = Tools::RemoveSpecialCaracterUpload($valor);
    
                    $targetFile = $targetPath .'/'. $fileName ;
                    $rs = move_uploaded_file($tempFile, $targetFile);    
                }  
            }
        }
    }

    public function AlterarCapitulo()
    {        
        
        $data    = NULL;
        $code    = -1;
        $message = "erro"; 

        try{            
            //if($this->IsValidSession() && Tools::IsValid($this->userSession)) {

            $idrevista        = $this->input->post('hdnIdRevistaProcesso', TRUE);
            $numerocapitulo   = $this->input->post('hdnId', TRUE);
            
            $this->db->trans_begin();

            if($this->RevistapaginaModel->Delete(NULL, array('id_revista' => (int) $idrevista, 'capitulo' => (float) $numerocapitulo))){                
                
                $dircapitulo_old = SITE_PATH.'/img/hq/'.$idrevista.'/Capitulo-'.$numerocapitulo;
                if(is_dir($dircapitulo_old)){
                    
                    if(rename($dircapitulo_old, $dircapitulo_old.'_OLD')){
                        $dircapitulo_old = $dircapitulo_old.'_OLD';

                        $nomecapitulo     = $this->input->post('nome_capitulo', TRUE);
                        $especial         = $this->input->post('especial', TRUE);
                        $paginas          = $this->input->post('hdnPaginas', TRUE);
                        $capitulonovo     = $this->input->post('numero_capitulo', TRUE);
                        $dircapitulo     = SITE_PATH.'/img/hq/'.$idrevista.'/Capitulo-'.$capitulonovo;
        
                        if (!is_dir($dircapitulo) && strlen($dircapitulo) > 0){ mkdir($dircapitulo, 0777); }
    
                        $ordem = 0;
                        foreach($paginas as $arquivopagina){          
                            $capitulo = new stdClass(); 
                            $capitulo->id_revista = $idrevista;
                            $capitulo->ordem = $ordem++;
                            $capitulo->arquivo = $idrevista.'/Capitulo-'.$capitulonovo.'/'.$arquivopagina;
                            $capitulo->capitulo = $capitulonovo;
                            $capitulo->descricao = $nomecapitulo;
                            $capitulo->especial = Tools::Equals($especial, "S");
                            
                            $code = $this->RevistapaginaModel->Save($capitulo);
                
                            if($code)
                            {
                                if (file_exists($dircapitulo_old.'/'.$arquivopagina)){
                                    rename($dircapitulo_old.'/'.$arquivopagina, $dircapitulo.'/'.$arquivopagina);
                                }
    
                                $code    = 0;
                                $message = 'success';
                                continue;
                            }else{
                                $code    = -1;
                                $message = 'Erro ao capítulo da HQ';
                                break;
                            }
                        }
                        if($code >= 0){
                            Tools::ApagaDir($dircapitulo_old);     
                            $this->db->trans_commit();
                        }else{
                            rename($dircapitulo_old.'_OLD', SITE_PATH.'/img/hq/'.$idrevista.'/Capitulo-'.$numerocapitulo);
                            $this->db->trans_rollback(); 
                            Tools::ApagaDir($dircapitulo); 
                        }
                    }
                }      
            }

            //}
        } catch (Exception $e) {    
            $code    = -1;
            $message = "Erro alterar Capitulo HQ!";            
            log_message('error', sprintf('(AlterarCapitulo) ERRO: %s', $e->getMessage()));
        }
            
        $this->LoadJson($code, $message, $data);
    }
}

?>
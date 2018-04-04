<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My class core integration CodeIgniter 
 * @category Controllers
 * @name MY_Controller
 */

/**
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Lang $lang
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $user_agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 * @property CI_Zip $zip
 */
abstract class MY_Controller extends CI_Controller
{

    //--> Attributes
    /**
     * @property string
     */
    public $masterPage     = "/masterpages/master_page";
    
    /**
    * @property string
    */
    public $masterPageJSON = "/masterpages/master_empty";

    /**
     * Page that will load the master page
     * @property string
     */
    public $pageView;

    /**
     * Active Menu that will load the master page
     * @property string
     */
    public $activeSearch;

    /**
     * Title of the page to load a view
     * @property string
     */
    public $titleView;

    /**
     * @property string
     */
    public $lastAccess;
     
    /**
     * @property string
     */
    public $userSession;
    
    /**
     * Current Language
     * @property string
     */
    public $language;


    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();  
        
        $this->load->helper('security');  
        $this->load->library('image_lib');
    }

    /**
     * Loads the default view through the data array.
     * @method LoadView
     * @param array
     * Loads the default view through the data array.
     */
    public function LoadView($data)
    {
        $data['titleView']   = $this->titleView;
        $data['activeSearch']  = $this->activeSearch;
        $data['UserSession'] = $this->userSession;

        if (!array_key_exists("modal", $data)) {
            $data['modal'] = null;
        }
                 
        if(!is_null($data) && !empty($data) && count($data) > 0)
        {
            $this->load->view($this->masterPage, $data);
        }
        else $this->load->view($this->masterPage);
    }

    /**
     * Loads the default view through the data array.
     * @param int $returncode 0 Sucesso, -1 Erro
     * @param string $returnmessage Mensagem
     * @param mixed $data
     * @param boolean $sendHeaders
     */
    public function LoadJson($returncode = 0, $returnmessage = '', $data = '', $sendHeaders = true)
    {
        $return['code']     = $returncode;
        $return['message']  = $returnmessage;
        $return['result']   = $data;

        if($sendHeaders)
        {
                //$this->masterPage = $this->masterPageJSON; 
                //$this->LoadView("parse_json", array("data" => $return));
                $this->load->view($this->masterPageJSON,array("data" => $return));
        }
        else echo  json_encode($return);
    }
    
    /**
     * Loads the default view through the data array.
     * @method LoadModel
     * @param String base in DBGroup
     * @param name modelname
     *
     */
    public function LoadModel($model)
    {
        $model = Model::GetModel($model);
        
        $lowerName	= $model['lowermodel'];
        $name		= $model['model'];

        if(empty($this->{$name . "Model"}))
        {
            $dbGroup	= $model['dbgroup'];
            $modelpath	= $model['path']; //$dbGroup['path'];
  
            $this->load->model($modelpath . "/" . $lowerName . "model", ucfirst ($name) . "Model");
 
        }
        //return $this->{$name . "Model"};
    }

    public function LogOff()
    {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        session_destroy();        
        redirect(base_url());
    }
    
    public function ClearSession()
    {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        session_destroy();
    }
    
    public function HasUserSession()
    {       
        $result = false; 

        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }       
        
        if(!empty($_SESSION[SESSION_ACCOUNT]))
        {
            $obj = $_SESSION[SESSION_ACCOUNT];
        }
        else $obj = null;

        if(Tools::IsValid($obj))
        {
            $this->userSession = $obj;
            $result = true;
        }

        return $result;
    }

    public function IsValidSession()
    {
        $result = TRUE;
        
        //--> Validando sessão
        if(!$this->HasUserSession())
        {
            $result = FALSE;
            $this->LogOff();            
        }
        return $result;
    }

    
}


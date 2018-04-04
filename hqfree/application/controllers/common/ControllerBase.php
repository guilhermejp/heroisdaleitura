<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
 
/**
* @class ControllerBase
*/
class ControllerBase extends MY_Controller
{
    
    /*
    * @property string 
    * Resource for language
    */
    private $resource = "app/resource";
    /*
    * @property string
    * Url Route for language (Use in web api or site map)
    */
    private $urlRoute = "app/urlroute";
    
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->SetLanguage();     
        
        //--> Utilizando em toda a loja por isso ja carregar direto no _BASE 
        $this->LoadModel(Model::$REVISTA);            

        //$this->load->library('ProxyERP');
    }

    /**
     * @method SetLanguage
     * Control language
     */
    protected function SetLanguage($changeLanguage=null)
    {                       
        if(Tools::IsValid($changeLanguage))
        {
            $this->lang->load($this->resource, $changeLanguage);
            $this->lang->load($this->urlRoute, $changeLanguage);
            $this->language = $changeLanguage;
        }
        else
        {
            if(isset($_COOKIE["language"]))
            {
                $this->language = $_COOKIE['language'];
                $this->config->set_item('language', $this->language);
                $this->lang->load($this->resource, $this->language);
                $this->lang->load($this->urlRoute, $this->language);
            }
            else
            {
                $this->lang->load($this->resource, 'pt-BR');
                $this->lang->load($this->urlRoute, 'pt-BR');
                $this->language = 'pt-BR';
            }
        }

        setcookie("language", $this->language, time() + 3600, '/');
    }

    public function LogOff()
    {
        session_destroy();
        redirect(base_url());
    }

    public function GetCurrentLangID()
    {
        $result = 1;

        if(isset($_COOKIE['language']))
        {
            switch (strtolower($_COOKIE['language']))
            {
                case 'pt-br' : $result = 1; break;
                case 'en-us' : $result = 2; break;
                case 'es-es' : $result = 3; break;
                default      : $result = 1; break;
            }
        }

        return $result;
    }
}

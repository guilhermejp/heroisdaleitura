<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once __DIR__ . '/autoload.php';
include_once(CONTROLLER_BASE);
/**
* @class Home
*/
class Contactus extends ControllerBase
{
    /**
     * @method Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('send_mail');
        $this->load->helper('html');  
        $this->titleView    = $this->lang->line('SysName');
        $this->pageView     = PageView::CONTACTUS;       
        $this->LoadModel(Model::$PARAMETER); 
        $this->load->helper('captcha');
    }

    public function Index()
    {
        $data = null;   
        $param = $this->ParameterModel->GetAllParameter();   
        $data['in_maintenance'] = $param['maintenance'];
            
        $this->LoadView($data);
    }

    public function SendEmail(){
        $data = null;
        $code = -1;
        $message = INVALID_PARAMETER;        
        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $subject = $this->input->post('assunto', TRUE);
        $message = $this->input->post('mensagem', TRUE);

        // $recaptcha = new \ReCaptcha\ReCaptcha("6LcqeyEUAAAAADjhtSjLMnmaAA8lDpa0STULPHsG");
        // $resp = $recaptcha->verify($this->input->post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        // if ($resp->isSuccess()){
            $_send = new SendMail();   

            $mailContent = "<p><b>Olá, você recebeu uma nova mensagem de: </b>". strtoupper($name) ."</p>\n"; 
            $mailContent .= "<p><b>Email: </b>".    $email ."</p>";
            $mailContent .= "<p><b>Assunto: </b>".  $subject ."</p>";
            $mailContent .="<p><b>Mensagem: </b>".  $message ."</p>";
            
            $mailContent = Html::GetHTML($mailContent);

            if($_send->send_email($email, $subject, $mailContent)){
                $code = 0;
                $message = 'success';
            }
        // }

        $this->LoadJson($code, $message, $data);       
    }
}

?>
<?php
/**
 * @author Devlink
 * Class SendMail
 * Type: Helpers
 */ 
class SendMail
{
    public static function send_email($mailTo, $subject, $html, $pathFile = NULL)
	{
        $ci = get_instance();
        $ci->load->library('email');

        $config = null;   
        $mailFrom = "" ;

        //if(Environment::DESIGN == ENVIRONMENT){ 
            $config['protocol']    = "smtp";
            $config['smtp_host']   = "mail.ruanpuga.com.br";
            $config['smtp_port']   = '587';
            $config['smtp_user']   = "naoresponda@ruanpuga.com.br"; 
            $config['smtp_pass']   = "Q9oa-d_QDwj1";
            $config['charset']     = "utf-8";
            $config['mailtype']    = "html";
            $config['_smtp_auth']  = TRUE;                             

        //}

        $ci->email->initialize($config);
        $ci->email->from($mailFrom, '');                                                          
        $ci->email->to($mailTo);
        $ci->email->cc(array('tfoliveira11@gmail.com'));         

        $ci->email->subject($subject);   

        if(!Tools::IsNullOrEmpty($pathFile) && file_exists($pathFile))
        {
            $ci->email->attach($pathFile);
        }

        $ci->email->message($html);              
         
        return $ci->email->send();
	}
}
?>

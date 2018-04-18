<?php

if (!function_exists('checkAdmin')) {
    
    function checkAdmin() {
        $CI = & get_instance();

        $user = $CI->session->userdata(SESSION_ACCOUNT);
        if ($user->tipo != "A") {
            redirect(SITE_URL, "refresh");
        }
    }

}
?>
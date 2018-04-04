<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| General Constants - Custom JE
|--------------------------------------------------------------------------
 */

define('MAINTENANCE', FALSE);
define('VHOST', 'heroisdaleitura/hqfree');
define('DOMAIN', 'www.heroisdaleitura.com.br');
define('JS_VERSION',  '1002');
define('CSS_VERSION', '1001');
define('SYS_VERSION', '1.0.0.0');


define('SITE_TIMEFIX', -3); //--> UTC: -3(Brasil)/ -2(Brasil Horário de Verão)
define('INVALID_PARAMETER', 'INVALID PARAMETER');
define('TIME_SESSION_ACCOUNT', 18000);
define('SESSION_ACCOUNT', 'user_session'); 

switch (ENVIRONMENT)
{    
    case Environment::DESIGN:        
        if(empty($_SERVER['DOCUMENT_ROOT']))$_SERVER['DOCUMENT_ROOT'] = str_replace ('\\', '/', $_SERVER['USERPROFILE'] . '/www' );
        if(empty($_SERVER['SERVER_NAME']))$_SERVER['SERVER_NAME'] = 'localhost';
        define('SITE_PROTOCOL', 'http://');
        define('SITE_PATH', $_SERVER['DOCUMENT_ROOT'] ."/". VHOST);
        define('SITE_URL', SITE_PROTOCOL . $_SERVER['SERVER_NAME'] . ":". $_SERVER['SERVER_PORT'] . '/'. VHOST);
        define('PATH_UPLOAD', SITE_PATH.'/files');
        break;
    case Environment::DEVELOPMENT:
        if(empty($_SERVER['DOCUMENT_ROOT']))$_SERVER['DOCUMENT_ROOT'] = str_replace ('\\', '/', $_SERVER['USERPROFILE'] . '/www' );
        if(empty($_SERVER['SERVER_NAME']))$_SERVER['SERVER_NAME'] = 'localhost';
        define('SITE_PROTOCOL', 'http://');
        define('SITE_PATH', $_SERVER['DOCUMENT_ROOT'] . VHOST);
        define('SITE_URL', SITE_PROTOCOL . $_SERVER['SERVER_NAME'] .'/'. VHOST);
        define('PATH_UPLOAD', SITE_PATH.'/files');
        break;
    case Environment::TESTING:
        if(empty($_SERVER['DOCUMENT_ROOT']))$_SERVER['DOCUMENT_ROOT'] = str_replace ('\\', '/', $_SERVER['USERPROFILE'] . '/www' );
        if(empty($_SERVER['SERVER_NAME']))$_SERVER['SERVER_NAME'] = 'localhost';
        define('SITE_PROTOCOL', 'http://');
        define('SITE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/'.VHOST);
        define('SITE_URL', SITE_PROTOCOL . $_SERVER['SERVER_NAME'] .'/'. VHOST);
        define('PATH_UPLOAD', SITE_PATH.'/files');
        break;
    case Environment::PRODUCTION:
        define('SITE_PROTOCOL', 'http://');
        define('SITE_PATH', $_SERVER['DOCUMENT_ROOT']);
        define('SITE_URL', SITE_PROTOCOL . $_SERVER['SERVER_NAME']);
        define('PATH_UPLOAD', SITE_PATH.'/files');
        break;
    default:
        exit('The application environment is not set correctly in constants.');
}

/*
|--------------------------------------------------------------------------
| Includes custom application constants
|--------------------------------------------------------------------------
 */
define('FORM_NAME', 'frmDefault');

/*
|--------------------------------------------------------------------------
| Includes intermediate controller constants
|--------------------------------------------------------------------------
 */
define('CONTROLLER_BASE', SITE_PATH . '/application/controllers/common/ControllerBase.php');
define('CONTROLLER_PATH', SITE_PATH . '/application/controllers');

/*
|--------------------------------------------------------------------------
| Includes intermediate model constants
|--------------------------------------------------------------------------
 */
define('MODEL_BASE', SITE_PATH . '/application/models/common/ModelBase.php');

/*
|--------------------------------------------------------------------------
| Includes Libraries
|--------------------------------------------------------------------------
 */
define('LIBRARIES_PATH', SITE_PATH . '/application/libraries');
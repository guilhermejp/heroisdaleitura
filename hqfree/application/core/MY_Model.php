<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{    
    //--> Construtor
    public function __construct()
    {
        parent::__construct();
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

        $dbGroup	= $model['dbgroup'];
        $modelpath	= $model['path']; //$dbGroup['path'];

        $this->load->model($modelpath . "/" . $lowerName . "model", $name . "Model");
        return $this->{$name . "Model"};
    }

}

?>
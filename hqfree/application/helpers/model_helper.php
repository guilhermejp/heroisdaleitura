<?php
/**
 * Class instance code Model 
 * @category Helpers
 * @name Class Model
 */
class Model
{	        
    public static $REVISTA	    	    = array('model' => 'revista',	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $USUARIO	    	    = array('model' => 'usuario',	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $REVISTAPAGINA        = array('model' => 'revistapagina',     'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $EDITORA 	    	    = array('model' => 'editora',	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $VOTACAO 	    	    = array('model' => 'votacao',	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $FAVORITOS 	    	= array('model' => 'favoritos',	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $GRUPO     	    	= array('model' => 'grupo', 	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);
    public static $LEITURA     	    	= array('model' => 'leitura', 	        'path' => '', 	            'dbgroup' => DBGroup::MASTER_STORE);

    public static function GetModel($model) 
    {        
        return array('lowermodel' => strtolower($model['model']), 'model' => $model['model'], 'path' => $model['path'], 'dbgroup' => DBGroup::${$model['dbgroup']});
    }
}
?>
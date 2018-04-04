<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * My class core integration CodeIgniter
 * @category Model
 * @name Class Model_Base
 */
class ModelBase extends MY_Model
{

    private $defaultTable = "";

    public function __construct($base, $table)
    {        
        if(empty(DBGroup::${$base}['db']))
            DBGroup::${$base}['db'] =  $this->load->database($base, TRUE);

        $this->db = clone(DBGroup::${$base}['db']);
        $this->defaultTable = $table;

        //Ajuste para profiler
        $CI = & get_instance();
        $CI->{$this->GetRegisterName($CI, $base)} = & $this->db;
        
    }

    private function GetRegisterName($CI, $base, $c = 0)
    {
        if(empty($CI->{$base . $c}))
        {
            return $base.$c;
        }
        else
        {
            $c++;
            return $this->GetRegisterName ($CI, $base, $c);
        }
    }

    public function Save($obj, $getInsertedId = TRUE)
    {
        $result = NULL;

        try
        {
            $temp = $this->db->insert($this->defaultTable, $obj);            
            if ($temp)
            {
                if ($getInsertedId)
                {
                    $result = $this->db->insert_id();
                }
                else
                {
                    $result = TRUE;
                }
            }
            else $result = FALSE;            
        }
        catch (Exception $e)
        {
            log_message("error", "ERROR SAVE (INSERT): " . $e->getMessage());
        }

        return $result;
    }

    public function Update($obj, $where, $getUpdateRows = FALSE)
    {
        $result = NULL;

        try
        {
            if (!empty($where))
            {
                $this->db->where($where);
            }
            else
            {
                log_message("error", "[Update]The parameter 'where' was not found.");
                exit("The parameter 'where' was not found.");
            }
            unset($obj->defaultTable);
            $result = $this->db->update($this->defaultTable, $obj);

            if ($getUpdateRows)
            {
                $result = $this->db->affected_rows();
            }
        }
        catch (Exception $e)
        {
            log_message("error", "ERROR Update: " . $e->getMessage());
        }

        return $result;
    }

    public function Delete($obj, $where)
    {
        $result = NULL;

        try
        {
            if (Tools::IsValidArray($where))
            {
                $result = $this->db->delete($this->defaultTable, $where);
                /*
                $accountid = null;
                $CI = & get_instance();
                if ($CI->HasUserSession())
                {
                        $accountid = $CI->GetCurrentUser()->accountid;
                }
                $this->LogSQL($accountid, 3, $this->defaultTable, $obj, $where);
                */
                $obj = null;
            }
        }
        catch (Exception $e)
        {
            log_message("error", "ERROR Update: " . $e->getMessage());
        }

        return $result;
    }

    public function Disable($where)
    {
        $obj = null;
        $obj->status = false;
        return $this->Update($obj, $where);
    }

    public function GetDefaultTable()
    {
        return $this->defaultTable;
    }

    public function GetById($id)
    {
        $obj = NULL;

        $result = $this->db->get_where($this->GetDefaultTable(), array('id' => $id));

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();
            if (count($rows) > 0)
            {
                $obj = $rows[0]; //--> Get object in array;
            }
        }

        return $obj;
    }

    public function GetAll($limit=null)
    {
        $obj = NULL;
        $rows = NULL;
        
        
        if(Tools::IsValid($limit))$this->db->limit($limit);

        $result = $this->db->get($this->GetDefaultTable());

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();
        }

        return $rows;
    }

    public function Count()
    {
        $obj = NULL;
        $rows = NULL;

        $result = $this->Select("COUNT(*) AS total");

        if (Tools::IsValid($result))
        {
            $obj = $result[0]->total;
        }

        return $obj;
    }

    public function GetAllWithUserUpdate($limit=null)
    {
        $obj = NULL;
        $rows = NULL;

        $this->db->select($this->GetDefaultTable() . '.*, u.login');
        $this->db->join('users u', $this->GetDefaultTable().'.userupdate = u.userid', 'INNER');
        //$this->db->where($this->GetDefaultTable() . '.status', true);
        //$this->db->order_by($this->GetDefaultTable() . "id", "desc");
        if(Tools::IsValid($limit))$this->db->limit($limit);

        $result = $this->db->get($this->GetDefaultTable());

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();
        }

        return $rows;
    }

    public function Select($select, $where = null, $orderby = '')
    {
        $obj = NULL;

        $this->db->select($select);
        if (!empty($orderby)) $this->db->order_by($orderby);       

        $result = $this->db->get_where($this->GetDefaultTable(), $where);

        if (Tools::IsValidObject($result))
        {
            $obj = $result->result();
        }

        return $obj;
    }

    public function GetIdFieldName($withAlias = false)
    {
        $explode = explode(".", $this->GetDefaultTable());
        $idFieldName = count($explode) == 1 ? $explode[0] . 'id' : $explode[1] . 'id';

        if (!$withAlias)
        {
            return $idFieldName;
        }
        else
        {
            return $this->GetDefaultTable() . '.' . $idFieldName;
        }
    }

    public function GetAutoSimpleJoin($tablejoin)
    {
        return $this->GetIdFieldName() . ' = ' . $tablejoin . '.' . $this->GetIdFieldName(false);
    }

    /**
     * Valida parâmetros obrigatórios
     * @param array $filters
     * @return boolean
     */
    protected function CheckRequiredFilters($filters, $required = array('accountid' => 'is_numeric'), $orOperator = true)
    {
        if(!is_array($filters) || !is_array($required))
            return false;

        $allFound = true;
        $oneFound = false;

        foreach($required as $filter => $func)
        {
            //Filtro obrigatório não preenchido
            if( empty($filters[$filter]) || (is_string($func) && !call_user_func($func, $filters[$filter])) )
                $allFound = false;
            else
            {
                //Checagem adicional para números
                if($func == 'is_numeric' && $filters[$filter] <= 0)
                {
                    log_message ('error', 'Esperando filtro numérico, mas passado valor negativo ou zero para ' . $filter);
                    return false;
                }

                $oneFound = true;
            }
        }

        if(($orOperator && $oneFound) || (!$orOperator && $allFound))
            return true;
        else
        {
            log_message ('error', 'Faltando filtro obrigatório ' . $filter);
            return false;
        }
    }


}

